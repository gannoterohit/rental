<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Cache\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as FacadesCache;
use Illuminate\Support\Facades\Http;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query()
            ->where('status', 'active')
            ->where('listing_fee_paid', true)
            ->where('listing_status', 'approved')
            ->with(['user:id,name,avatar']);

        $userCity = session('user_city');
        $locationVerified = session('location_verified', false);
        $lat = $request->lat ?: ($request->filled('city') ? null : session('user_lat'));
        $lng = $request->lng ?: ($request->filled('city') ? null : session('user_lng'));

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
            session(['user_city' => $request->city]);
            session()->forget('no_auto');

            if ($request->has('lat') && $request->has('lng')) {
                session(['user_lat' => $request->lat, 'user_lng' => $request->lng]);
                if ($request->has('verified')) {
                    session(['location_verified' => true]);
                }
            } else {
                $lat = $lng = null;
                session()->forget(['user_lat', 'user_lng', 'location_verified']);
            }
        } elseif ($userCity) {
            $query->where('city', 'like', '%' . $userCity . '%');
        } else {
            // Server-side IP-based city auto-detection fallback
            if (!session('no_auto') && !$request->filled('city')) {
                try {
                    $ip = $request->ip();
                    if (!in_array($ip, ['127.0.0.1', '::1']) && !str_starts_with($ip, '192.168.') && !str_starts_with($ip, '10.')) {
                        $geoResponse = \Illuminate\Support\Facades\Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,city,lat,lon");
                        if ($geoResponse->successful()) {
                            $geo = $geoResponse->json();
                            if (($geo['status'] ?? '') === 'success' && !empty($geo['city'])) {
                                $detectedCity = $geo['city'];
                                session(['user_city' => $detectedCity, 'user_lat' => $geo['lat'], 'user_lng' => $geo['lon'], 'location_verified' => true]);
                                $userCity = $detectedCity;
                                $lat = $geo['lat'];
                                $lng = $geo['lon'];
                                $locationVerified = true;
                                $query->where('city', 'like', '%' . $detectedCity . '%');
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Fail silently
                }
            }
        }

        if ($lat && $lng && $locationVerified && !$request->filled('city')) {
            $query->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                  ->orderBy('distance', 'asc');
        }

        $rooms = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        if ($request->ajax()) {
            $view = '';
            foreach ($rooms as $room) {
                $view .= view('partials.mobile-room-card', compact('room'))->render();
            }

            return response()->json([
                'html' => $view,
                'hasMore' => $rooms->hasMorePages(),
            ]);
        }

        $popularCities = FacadesCache::remember('popular_cities_web', 86400, function () {
            return Room::select('city', \DB::raw('count(*) as total'))
                ->where('status', 'active')
                ->where('listing_status', 'approved')
                ->groupBy('city')
                ->orderByDesc('total')
                ->take(10)
                ->get();
        });

       

        return view('home', compact('rooms', 'popularCities'));
    }
}
