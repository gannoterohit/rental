<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchAnalyticsController extends Controller
{
    public function index()
    {
        // Top 10 searched cities
        // Exclude null or empty city searches
        $topCities = SearchLog::whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->limit(10)
            ->get();

        // Top Cities by Owner Listings (Supply)
        $topListingCities = \App\Models\Room::whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();


        // Recent Logs
        $recentLogs = SearchLog::with('user') // Showing user if logged in
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.search_logs.index', compact('topCities', 'recentLogs', 'topListingCities'));
    }
}
