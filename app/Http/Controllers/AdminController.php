<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Payout;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\RoomApprovedMail;
use App\Mail\RoomRejectedMail;
use App\Models\RejectionReason;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
   
    
    public function dashboard()
    {
        // Counts
        $rooms = Room::where('listing_fee_paid', true)->count();
        $users = User::count();
        $owners = User::where('role', 'owner')->count();
    
        $activeRooms = Room::where('status', 'active')
            ->where('listing_fee_paid', true)
            ->count();
    
        // Room status
        $approvedRooms = Room::where('listing_status', 'approved')->count();
        $pendingRooms  = Room::where('listing_status', 'pending')->count();
        $rejectedRooms = Room::where('listing_status', 'rejected')->count();
    
        // Earnings
        $totalEarnings = Payment::where('status', 'completed')->sum('amount');
    
        $listingEarnings = Payment::where('status', 'completed')
            ->where('type', 'listing')
            ->sum('amount');
            
        $unlockEarnings = Payment::where('status', 'completed')
            ->where('type', 'unlock')
            ->sum('amount');

        $featuredEarnings = Payment::where('status', 'completed')
            ->where('type', 'featured')
            ->sum('amount');

        $bookingEarnings = Payment::where('status', 'completed')
        ->where('type', 'booking')
        ->sum('amount');

    $subscriptionEarnings = Payment::where('status', 'completed')
        ->where('type', 'subscription')
        ->sum('amount');
    
        // Monthly revenue graph
        $monthlyRevenue = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');
    
        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
        }
        
        // Monthly comparison
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;
        
        $currentMonthEarnings = Payment::where('status', 'completed')
            ->whereMonth('created_at', $currentMonth)
            ->sum('amount');
            
        $lastMonthEarnings = Payment::where('status', 'completed')
            ->whereMonth('created_at', $lastMonth)
            ->sum('amount');
            
        $percentageChange = $lastMonthEarnings > 0 
            ? (($currentMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100 
            : 0;
    
        // Recents
        $recentRooms = Room::with('owner')->latest()->limit(5)->get();
        $recentPayments = Payment::with('user')->latest()->limit(5)->get();
        $recentUsers = User::where('role', 'user')->latest()->limit(5)->get();
        $recentOwners = User::where('role', 'owner')->withCount('rooms')->latest()->limit(5)->get();
    
        return view('admin.dashboard', compact(
            'rooms','users','owners','activeRooms',
            'approvedRooms','pendingRooms','rejectedRooms',
            'totalEarnings','listingEarnings','unlockEarnings','featuredEarnings','bookingEarnings','subscriptionEarnings',
            'revenueData',
            'currentMonthEarnings','lastMonthEarnings','percentageChange',
            'recentRooms','recentPayments','recentUsers','recentOwners'
        ));
    }
    
    
    public function Rooms()
    {
        $allrooms = Room::with('owner')->latest()->paginate(10);
        $rejectionReasons = RejectionReason::where('is_active', true)->get();

        return view('admin.all-room', compact('allrooms', 'rejectionReasons'));
    }

    public function approveRoom(Room $room)
    {
        try {
            // Update room status
            $room->listing_status = 'approved';
            $room->save();

            // Send email to owner (try-catch to prevent failure if mail not configured)
            try {
                $owner = $room->owner;
                Mail::to($owner->email)->send(new RoomApprovedMail($room, $owner));
                
                // Trigger City Alerts
                $alerts = \App\Models\CityAlert::with('user')->where('city', $room->city)->get();
                foreach ($alerts as $alert) {
                    if ($alert->user && $alert->user->email) {
                        Mail::to($alert->user->email)->send(new \App\Mail\NewRoomInCityAlert($room, $room->city));
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Mail sending failed: ' . $e->getMessage());
                // Continue execution even if mail fails
            }

            return response()->json(['success' => true, 'message' => 'Room approved successfully']);
        } catch (\Exception $e) {
            \Log::error('Room approval error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error approving room: ' . $e->getMessage()], 500);
        }
    }

    public function rejectRoom(Request $request, Room $room)
    {
        try {
            $request->validate([
                'reasons' => 'array',
                'customReason' => 'nullable|string|max:500'
            ]);

            // Update room status
            $room->listing_status = 'rejected';
            $room->save();

            // Save rejection reasons
            if (!empty($request->reasons)) {
                $room->rejectionReasons()->attach($request->reasons);
            }

            // Get all rejection reasons for email
            $reasons = [];
            if (!empty($request->reasons)) {
                $selectedReasons = RejectionReason::whereIn('id', $request->reasons)->get();
                foreach ($selectedReasons as $reason) {
                    $reasons[] = $reason->reason;
                }
            }
            
            if (!empty($request->customReason)) {
                $reasons[] = $request->customReason;
            }

            // Send email to owner
            $owner = $room->owner;
            Mail::to($owner->email)->send(new RoomRejectedMail($room, $owner, $reasons));

            return response()->json(['success' => true, 'message' => 'Room rejected and email sent to owner']);
        } catch (\Exception $e) {
            \Log::error('Room rejection error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error rejecting room: ' . $e->getMessage()], 500);
        }
    }

    public function deleteRoom(Room $room)
    {
        try {
            $room->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Room deletion error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting room: ' . $e->getMessage()], 500);
        }
    }

    public function reports()
    {
        $bookings = Booking::with(['user', 'room'])
            ->latest()
            ->paginate(20);

        $payments = Payment::with('user')
            ->where('status', 'completed')
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('bookings', 'payments'));
    }

    public function payouts()
    {
        $payouts = Payout::with(['owner', 'booking'])
            ->latest()
            ->paginate(20);

        return view('admin.payouts', compact('payouts'));
    }

    public function processPayout(Request $request, $id)
    {
        $payout = Payout::findOrFail($id);
        
        if ($payout->status !== 'pending') {
            return back()->with('error', 'Payout already processed!');
        }

        if ($payout->release_date > now()) {
            return back()->with('error', 'Payout is still on hold period!');
        }

        $payout->update([
            'status' => 'processed',
            'payment_reference' => $request->payment_reference
        ]);

        return back()->with('success', 'Payout processed successfully!');
    }

    public function users(Request $request)
    {
        $query = User::withTrashed()->where('role', 'user');
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function owners(Request $request)
    {
        $query = User::withTrashed()->where('role', 'owner')->withCount('rooms');
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $owners = $query->latest()->paginate(10);
        return view('admin.owners', compact('owners'));
    }

    public function userDetail(User $user)
    {
        $user->load(['bookings', 'rooms']);
        return view('admin.user-detail', compact('user'));
    }

    public function ownerDetail(User $owner)
    {
        $owner->load(['rooms', 'bookings']);
        $rooms = $owner->rooms()->latest()->paginate(10);
        return view('admin.owner-detail', compact('owner', 'rooms'));
    }

    public function toggleBlock(Request $request, User $user)
    {
        $user->update([
            'is_blocked' => !$user->is_blocked
        ]);

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User {$status} successfully!");
    }


    public function cityAlerts()
    {
        $alerts = \App\Models\CityAlert::with('user')->latest()->paginate(20);
        return view('admin.city-alerts.index', compact('alerts'));
    }

    public function deleteCityAlert($id)
    {
        $alert = \App\Models\CityAlert::findOrFail($id);
        $alert->delete();
        return back()->with('success', 'City alert subscription removed successfully!');
    }

    // New Owner Registration by Admin
    public function createOwner()
    {
        return view('admin.owners.create');
    }

    public function storeOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $owner = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'owner',
            'is_verified' => true, // Admin created owners are verified by default
        ]);

        return redirect()->route('admin.owners')->with('success', 'Owner registered successfully!');
    }

    // Room Management by Admin
    public function createRoom()
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.rooms.create', compact('owners'));
    }

    public function storeRoom(Request $request)
    {
        $data = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'furnishing_type' => 'required|in:furnished,semi-furnished,unfurnished',
            'tenant_type' => 'required|in:family,bachelors,girls,boys,any',
            'room_type' => 'required|in:single_room,shared_room,1bhk,2bhk,3bhk,flat',
            'amenities' => 'nullable|array',
            'landmarks' => 'nullable|array',
            'photos.*' => 'image|max:2048',
            'photos' => 'required|array|min:1|max:5',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
            'video_url' => 'nullable|url|max:255',
            'is_featured' => 'nullable|boolean',
            'listing_fee_paid' => 'nullable|boolean',
        ]);

        $data['user_id'] = $request->owner_id;
        $data['listing_status'] = 'approved';
        $data['listing_fee_paid'] = $request->has('listing_fee_paid') ? true : true; // Default true for admin
        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = 'active';

        // Convert empty latitude/longitude strings to null
        if (isset($data['latitude']) && $data['latitude'] === '') {
            $data['latitude'] = null;
        }
        if (isset($data['longitude']) && $data['longitude'] === '') {
            $data['longitude'] = null;
        }

        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('rooms', 'public');
            }
            $data['photos'] = $photos;
            $data['photo'] = $photos[0];
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('rooms/videos', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.all-rooms')->with('success', 'Room created successfully by Admin!');
    }

    public function editRoom(Room $room)
    {
        $owners = User::where('role', 'owner')->get();
        return view('admin.rooms.edit', compact('room', 'owners'));
    }

    public function updateRoom(Request $request, Room $room)
    {
        $data = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rent' => 'required|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'furnishing_type' => 'required|in:furnished,semi-furnished,unfurnished',
            'tenant_type' => 'required|in:family,bachelors,girls,boys,any',
            'room_type' => 'required|in:single_room,shared_room,1bhk,2bhk,3bhk,flat',
            'amenities' => 'nullable|array',
            'landmarks' => 'nullable|array',
            'photos.*' => 'image|max:2048',
            'photos' => 'nullable|array|max:5',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
            'video_url' => 'nullable|url|max:255',
            'is_featured' => 'nullable|boolean',
            'listing_fee_paid' => 'nullable|boolean',
            'listing_status' => 'nullable|in:pending,approved,rejected',
            'status' => 'nullable|in:active,booked',
        ]);

        $data['user_id'] = $request->owner_id;
        $data['is_featured'] = $request->has('is_featured');
        $data['listing_fee_paid'] = $request->has('listing_fee_paid');
        $data['listing_status'] = $request->listing_status ?? $room->listing_status;
        $data['status'] = $request->status ?? $room->status;

        // Convert empty latitude/longitude strings to null
        if (isset($data['latitude']) && $data['latitude'] === '') {
            $data['latitude'] = null;
        }
        if (isset($data['longitude']) && $data['longitude'] === '') {
            $data['longitude'] = null;
        }

        if ($request->hasFile('photos')) {
            // Delete old photos
            if ($room->photos) {
                $oldPhotos = $room->photos;
                if (is_string($oldPhotos)) {
                    $oldPhotos = json_decode($oldPhotos, true);
                }
                if ($oldPhotos && is_array($oldPhotos)) {
                    foreach ($oldPhotos as $oldPhoto) {
                        Storage::disk('public')->delete($oldPhoto);
                    }
                }
            }

            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('rooms', 'public');
            }
            $data['photos'] = $photos;
            $data['photo'] = $photos[0];
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video
            if ($room->video) {
                Storage::disk('public')->delete($room->video);
            }
            $data['video'] = $request->file('video')->store('rooms/videos', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.all-rooms')->with('success', 'Room updated successfully by Admin!');
    }

    public function showRoom(Room $room)
    {
        $isUnlocked = true; 
        $isOwner = true; 
        $subscriptionRemaining = 0;
        $room->load('owner');
        
        return view('rooms.show', compact('room', 'isUnlocked', 'isOwner', 'subscriptionRemaining'));
    }

    public function paymentsindex(Request $request)
    {
        $query = Payment::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function contactMessages()
    {
        $messages = \App\Models\ContactMessage::latest()->paginate(15);
        return view('admin.contact-messages.index', compact('messages'));
    }

    public function deleteContactMessage($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->delete();
        return back()->with('success', 'Contact message deleted successfully!');
    }

    public function markMessageAsRead($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }
}
