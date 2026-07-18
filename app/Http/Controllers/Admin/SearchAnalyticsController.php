<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchAnalyticsController extends Controller
{
    public function index(Request $request)
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
        $logsQuery = SearchLog::with('user');
        if ($request->filled('from')) $logsQuery->whereDate('created_at', '>=', $request->date('from'));
        if ($request->filled('to')) $logsQuery->whereDate('created_at', '<=', $request->date('to'));
        if ($request->filled('city')) $logsQuery->where('city', 'like', '%'.$request->city.'%');
        $recentLogs = $logsQuery->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.search_logs.index', compact('topCities', 'recentLogs', 'topListingCities'));
    }

    public function destroy(SearchLog $searchLog)
    {
        $searchLog->delete();
        return back()->with('success', 'Search log deleted.');
    }

    public function destroyRange(Request $request)
    {
        $data = $request->validate(['from' => 'required|date', 'to' => 'required|date|after_or_equal:from']);
        $count = SearchLog::whereDate('created_at', '>=', $data['from'])->whereDate('created_at', '<=', $data['to'])->delete();
        return redirect()->route('admin.analytics', ['tab' => 'logs'])->with('success', $count.' search logs deleted.');
    }

    public function destroyAll()
    {
        $count = SearchLog::query()->delete();
        return redirect()->route('admin.analytics', ['tab' => 'logs'])->with('success', $count.' search logs deleted.');
    }
}
