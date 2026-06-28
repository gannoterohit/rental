<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Room;
use App\Models\Payment;
use App\Models\Setting;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiRoomController extends BaseApiController
{
    /**
     * List rooms with filters (Public)
     */
    public function index(Request $request)
    {
        $query = Room::query()
            ->with('owner')
            ->where('status', 'active')
            ->where('listing_fee_paid', true)
            ->where('listing_status', 'approved');

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('min_rent')) {
            $query->where('rent', '>=', $request->min_rent);
        }

        if ($request->filled('max_rent')) {
            $query->where('rent', '<=', $request->max_rent);
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }
        
        if ($request->filled('furnishing_type')) {
            $query->where('furnishing_type', $request->furnishing_type);
        }

        if ($request->filled('tenant_type')) {
            $query->where('tenant_type', $request->tenant_type);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
            });
        }

        if ($request->filled('lat') && $request->filled('lng')) {
            $lat = $request->lat;
            $lng = $request->lng;
            $query->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                  ->orderBy('distance', 'asc');
        } else {
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('created_at', 'desc');
        }

        $rooms = $query->paginate($request->get('limit', 10));

        // Log the search
        if ($request->filled('city') || $request->filled('min_rent') || $request->filled('max_rent') || $request->filled('search')) {
            try {
                \App\Models\SearchLog::create([
                    'city'        => $request->city ?? 'Unknown',
                    'search_term' => $request->search ?? $request->city ?? 'Filter Applied',
                    'filters'     => [
                        'min_rent' => $request->min_rent,
                        'max_rent' => $request->max_rent,
                        'room_type' => $request->room_type,
                        'is_api'   => true
                    ],
                    'user_id'     => Auth::id(),
                    'ip_address'  => $request->ip(),
                ]);
            } catch (\Exception $e) {
                // Fail silently
            }
        }

        return RoomResource::collection($rooms)->additional(['status' => 'success']);
    }

    /**
     * Get single room details
     */
    public function show($id)
    {
        $room = Room::with('owner')->find($id);

        if (!$room) {
            return $this->sendError('Room not found');
        }

        $isUnlocked = false;
        if (Auth::check()) {
            $isUnlocked = (Auth::id() === $room->user_id) || 
                          Enquiry::where('user_id', Auth::id())->where('room_id', $room->id)->where('unlocked', true)->exists();
        }

        if ($room->listing_type === 'broker') $isUnlocked = true;

        $resource = new RoomResource($room);
        return $this->sendSuccess([
            'room' => $resource,
            'is_unlocked' => $isUnlocked
        ]);
    }
    
    /**
     * Get similar rooms
     */
    public function similar(Request $request, $id)
    {
        $room = Room::find($id);
        if (!$room) return $this->sendError('Room not found');
        
        $rooms = Room::where('id', '!=', $id)
            ->where('city', $room->city)
            ->where('status', 'active')
            ->where('listing_fee_paid', true)
            ->limit(4)
            ->get();
            
        return $this->sendSuccess(RoomResource::collection($rooms));
    }

    /**
     * Detect city from coordinates
     */
    public function detectCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Coordinates required', $validator->errors(), 422);
        }

        // Logic to find closest city from our database
        $closestRoom = Room::selectRaw("city, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$request->lat, $request->lng, $request->lat])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('distance', 'asc')
            ->first();

        if ($closestRoom && $closestRoom->distance < 50) { // Within 50km
            return $this->sendSuccess(['city' => $closestRoom->city]);
        }

        return $this->sendError('No nearby city found with listings', [], 404);
    }

    /**
     * List rooms owned by the authenticated user
     */
    public function myRooms(Request $request)
    {
        $rooms = Room::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('limit', 10));

        return RoomResource::collection($rooms)->additional(['status' => 'success']);
    }

    /**
     * Store a new room (Owner)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'furnishing_type' => 'required|in:furnished,semi-furnished,unfurnished',
            'tenant_type' => 'required|in:family,bachelors,girls,boys,any',
            'room_type' => 'required|in:single_room,shared_room,1bhk,2bhk,3bhk,flat',
            'amenities' => 'nullable|array',
            'landmarks' => 'nullable|array',
            'photos' => 'required|array|min:1|max:5',
            'photos.*' => 'image|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:10240',
            'listing_type' => 'required|in:owner,broker',
            'broker_fee' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 422);
        }

        DB::beginTransaction();
        try {
            $data = $request->except('photos', 'video');
            $data['user_id'] = Auth::id();
            $data['status'] = 'pending';
            $data['listing_fee_paid'] = false;

            if ($request->hasFile('photos')) {
                $photos = [];
                foreach ($request->file('photos') as $photo) {
                    $filename = uniqid('room_') . '.jpg';
                    $path = 'rooms/' . $filename;
                    $fullPath = storage_path('app/public/' . $path);
                    
                    if (!file_exists(storage_path('app/public/rooms'))) {
                        mkdir(storage_path('app/public/rooms'), 0755, true);
                    }

                    \App\Helpers\ImageHelper::compressImage($photo->getRealPath(), $fullPath, 70);
                    $photos[] = $path;
                }
                $data['photos'] = $photos;
                $data['photo'] = $photos[0];
            }

            if ($request->hasFile('video')) {
                $data['video'] = $request->file('video')->store('rooms/videos', 'public');
            }

            $room = Room::create($data);
            \Illuminate\Support\Facades\Cache::forget('public_cities_list');

            // Check Owner Subscription
            $activeSub = \App\Models\Subscription::where('user_id', Auth::id())
                ->where('status', 'active')
                ->whereHas('plan', fn($q) => $q->where('type', 'owner'))
                ->with('plan')
                ->first();

            if ($activeSub) {
                $used = Room::where('user_id', Auth::id())->where('listing_fee_paid', true)->whereNull('listing_payment_id')->count();
                $limit = $activeSub->plan->listing_limit;
                if ($limit === -1 || $used < $limit) {
                    $room->update(['listing_fee_paid' => true, 'status' => 'active']);
                    DB::commit();
                    return $this->sendSuccess(new RoomResource($room), 'Room listed successfully using subscription!');
                }
            }

            $listingFee = (float) Setting::get('listing_fee', 199);

            // Handle Wallet Payment
            if ($request->payment_method === 'wallet') {
                $user = Auth::user();
                if ($user->wallet_balance >= $listingFee) {
                    $user->decrement('wallet_balance', $listingFee);
                    Payment::create([
                        'user_id' => $user->id,
                        'type' => 'listing',
                        'amount' => $listingFee,
                        'gateway' => 'wallet',
                        'reference_id' => $room->id,
                        'status' => 'completed'
                    ]);
                    $room->update(['listing_fee_paid' => true, 'status' => 'active']);
                    DB::commit();
                    return $this->sendSuccess(new RoomResource($room), 'Room listed successfully using wallet balance!');
                } else {
                    return $this->sendError('Insufficient wallet balance', [], 400);
                }
            }

            DB::commit();
            return $this->sendSuccess([
                'room' => new RoomResource($room),
                'amount' => $listingFee,
                'type' => 'listing'
            ], 'Room created. Please complete payment to activate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($this->safeErrorMessage($e, 'Unable to save room. Please try again.'), [], 500);
        }
    }

    /**
     * Update room details
     */
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room || $room->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized or room not found', [], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'rent' => 'required|numeric',
            'photos.*' => 'image|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 422);
        }

        $data = $request->except('photos', 'video');

        if ($request->hasFile('photos')) {
            if ($room->photos) {
                foreach ($room->photos as $oldPhoto) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPhoto);
                }
            }
            
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $filename = uniqid('room_') . '.jpg';
                $path = 'rooms/' . $filename;
                $fullPath = storage_path('app/public/' . $path);
                
                if (!file_exists(storage_path('app/public/rooms'))) {
                    mkdir(storage_path('app/public/rooms'), 0755, true);
                }

                \App\Helpers\ImageHelper::compressImage($photo->getRealPath(), $fullPath, 70);
                $photos[] = $path;
            }
            $data['photos'] = $photos;
            $data['photo'] = $photos[0];
        }

        $room->update($data);
        \Illuminate\Support\Facades\Cache::forget('public_cities_list');

        return $this->sendSuccess(new RoomResource($room), 'Room updated successfully');
    }

    /**
     * Delete room
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room || $room->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized or room not found', [], 403);
        }

        $room->delete();

        return $this->sendSuccess([], 'Room deleted successfully');
    }

    /**
     * Toggle room status (Booked/Available)
     */
    public function toggleStatus(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room || $room->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized or room not found', [], 403);
        }

        if ($room->status === 'active') {
            $room->update(['status' => 'booked']);
            return $this->sendSuccess(['new_status' => 'booked'], 'Room marked as booked');
        } else {
            // Making available again! In web, this charges listing fee again.
            
            DB::beginTransaction();
            try {
                // 1. Check Owner Subscription
                $activeSub = \App\Models\Subscription::where('user_id', Auth::id())
                    ->where('status', 'active')
                    ->whereHas('plan', fn($q) => $q->where('type', 'owner'))
                    ->with('plan')
                    ->first();

                if ($activeSub) {
                    $used = Room::where('user_id', Auth::id())->where('listing_fee_paid', true)->whereNull('listing_payment_id')->count();
                    if ($activeSub->plan->listing_limit === -1 || $used < $activeSub->plan->listing_limit) {
                        $room->update(['status' => 'active', 'listing_fee_paid' => true]);
                        DB::commit();
                        return $this->sendSuccess(['new_status' => 'active'], 'Room marked as available using subscription');
                    }
                }

                $listingFee = (float) Setting::get('listing_fee', 199);

                // 2. Handle Wallet
                if ($request->payment_method === 'wallet') {
                    $user = Auth::user();
                    if ($user->wallet_balance >= $listingFee) {
                        $user->decrement('wallet_balance', $listingFee);
                        Payment::create([
                            'user_id' => $user->id,
                            'type' => 'listing',
                            'amount' => $listingFee,
                            'gateway' => 'wallet',
                            'reference_id' => $room->id,
                            'status' => 'completed'
                        ]);
                        $room->update(['status' => 'active', 'listing_fee_paid' => true]);
                        DB::commit();
                        return $this->sendSuccess(['new_status' => 'active', 'new_balance' => $user->wallet_balance], 'Room marked as available using wallet balance');
                    } else {
                        return $this->sendError('Insufficient wallet balance', [], 400);
                    }
                }

                // 3. Return Payment requirement
                DB::commit();
                return $this->sendSuccess([
                    'amount' => $listingFee,
                    'type' => 'listing',
                    'action' => 'mark_available'
                ], 'Payment required to make room available again');

            } catch (\Exception $e) {
                DB::rollBack();
                return $this->sendError($this->safeErrorMessage($e, 'Unable to complete this action. Please try again.'), [], 500);
            }
        }
    }

    /**
     * Make room featured
     */
    public function makeFeatured(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room || $room->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized or room not found', [], 403);
        }

        if ($room->is_featured) {
            return $this->sendError('Room is already featured', [], 400);
        }

        $featuredFee = Setting::get('featured_fee', 99);
        $user = Auth::user();

        if ($request->payment_method === 'wallet') {
            if ($user->wallet_balance >= $featuredFee) {
                $user->decrement('wallet_balance', $featuredFee);
                
                Payment::create([
                    'user_id' => $user->id,
                    'type' => 'featured',
                    'amount' => $featuredFee,
                    'gateway' => 'wallet',
                    'reference_id' => $room->id,
                    'status' => 'completed'
                ]);

                $room->update(['is_featured' => true]);

                return $this->sendSuccess([
                    'new_balance' => $user->wallet_balance
                ], 'Room featured successfully using wallet balance');
            } else {
                return $this->sendError('Insufficient wallet balance', [], 400);
            }
        }

        // Return payment details for Flutter to handle Razorpay
        return $this->sendSuccess([
            'amount'       => (float) $featuredFee,
            'reference_id' => $room->id,
            'type'         => 'featured'
        ], 'Proceed to payment to feature this room');
    }

    /**
     * Get list of unique cities with room listings
     */
    public function getCities()
    {
        $cities = \Illuminate\Support\Facades\Cache::remember('public_cities_list', 86400, function () {
            return Room::where('status', 'active')
                ->where('listing_fee_paid', true)
                ->where('listing_status', 'approved')
                ->distinct()
                ->pluck('city');
        });

        return $this->sendSuccess($cities);
    }
}
