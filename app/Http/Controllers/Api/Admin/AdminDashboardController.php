<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\SearchLog;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends BaseApiController
{
    /**
     * Admin Dashboard Statistics
     */
    public function index()
    {
        $totalRooms        = Room::where('listing_fee_paid', true)->count();
        $totalUsers        = User::where('role', 'user')->count();
        $totalOwners       = User::where('role', 'owner')->count();
        $activeRooms       = Room::where('status', 'active')->where('listing_fee_paid', true)->count();
        $pendingRooms      = Room::where('listing_status', 'pending')->count();
        $approvedRooms     = Room::where('listing_status', 'approved')->count();
        $rejectedRooms     = Room::where('listing_status', 'rejected')->count();

        $totalEarnings        = Payment::where('status', 'completed')->sum('amount');
        $listingEarnings      = Payment::where('status', 'completed')->where('type', 'listing')->sum('amount');
        $unlockEarnings       = Payment::where('status', 'completed')->where('type', 'unlock')->sum('amount');
        $featuredEarnings     = Payment::where('status', 'completed')->where('type', 'featured')->sum('amount');
        $bookingEarnings      = Payment::where('status', 'completed')->where('type', 'booking')->sum('amount');
        $subscriptionEarnings = Payment::where('status', 'completed')->where('type', 'subscription')->sum('amount');

        // Monthly revenue (12 months)
        $monthlyRevenue = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = (float) ($monthlyRevenue[$i] ?? 0);
        }

        $currentMonthEarnings = Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
            
        $lastMonthEarnings = Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('amount');

        $percentageChange = $lastMonthEarnings > 0
            ? round((($currentMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100, 2)
            : 0;

        $recentRooms    = RoomResource::collection(Room::with('owner')->latest()->limit(5)->get());
        $recentPayments = Payment::with('user')->latest()->limit(5)->get();
        $recentUsers    = User::where('role', 'user')->latest()->limit(5)->get(['id','name','email','created_at']);
        $recentOwners   = User::where('role', 'owner')->withCount('rooms')->latest()->limit(5)->get(['id','name','email','created_at','rooms_count']);

        return $this->sendSuccess([
            'counts' => [
                'total_rooms'    => $totalRooms,
                'total_users'    => $totalUsers,
                'total_owners'   => $totalOwners,
                'active_rooms'   => $activeRooms,
                'pending_rooms'  => $pendingRooms,
                'approved_rooms' => $approvedRooms,
                'rejected_rooms' => $rejectedRooms,
            ],
            'earnings' => [
                'total'        => (float) $totalEarnings,
                'listing'      => (float) $listingEarnings,
                'unlock'       => (float) $unlockEarnings,
                'featured'     => (float) $featuredEarnings,
                'booking'      => (float) $bookingEarnings,
                'subscription' => (float) $subscriptionEarnings,
            ],
            'monthly_revenue'          => $revenueData,
            'current_month_earnings'   => (float) $currentMonthEarnings,
            'last_month_earnings'      => (float) $lastMonthEarnings,
            'percentage_change'        => $percentageChange,
            'recent_rooms'    => $recentRooms,
            'recent_payments' => $recentPayments,
            'recent_users'    => $recentUsers,
            'recent_owners'   => $recentOwners,
        ]);
    }

    /**
     * Analytics summary
     */
    public function analytics()
    {
        $topCities = Room::where('status', 'active')
            ->selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $bookingsPerMonth = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        $bookingData = [];
        for ($i = 1; $i <= 12; $i++) {
            $bookingData[] = (int) ($bookingsPerMonth[$i] ?? 0);
        }

        $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->where('role', 'user')
            ->groupBy('month')
            ->pluck('count', 'month');

        $userData = [];
        for ($i = 1; $i <= 12; $i++) {
            $userData[] = (int) ($usersPerMonth[$i] ?? 0);
        }

        return $this->sendSuccess([
            'top_cities'       => $topCities,
            'bookings_monthly' => $bookingData,
            'users_monthly'    => $userData,
        ]);
    }

    /**
     * Detailed search analytics
     */
    public function searchAnalytics(Request $request)
    {
        $topSearchedCities = SearchLog::whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topListingCities = Room::whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $recentLogs = SearchLog::with('user')
            ->orderByDesc('created_at')
            ->paginate($request->get('limit', 20));

        return $this->sendSuccess([
            'top_searched_cities' => $topSearchedCities,
            'top_listing_cities'  => $topListingCities,
            'recent_logs'         => $recentLogs,
        ]);
    }
}
