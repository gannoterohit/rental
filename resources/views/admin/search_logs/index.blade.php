@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    @include('admin.partials.sidebar')
    
    <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
        <div class="container-fluid px-4 py-6 overflow-y-auto">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">User Search Analytics</h1>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Top Cities Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-700 mb-4 border-b pb-2">Top Active Cities (Traffic & Searches)</h2>
                    <div class="space-y-3">
                        @forelse($topCities as $cityStat)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">{{ $cityStat->city }}</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2.5 mr-3">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($cityStat->total / $topCities->first()->total) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-indigo-600">{{ $cityStat->total }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No searches recorded yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top Listings Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-700 mb-4 border-b pb-2">Top Cities (Owner Listings)</h2>
                    <div class="space-y-3">
                        @forelse($topListingCities as $cityStat)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">{{ $cityStat->city }}</span>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 rounded-full h-2.5 mr-3">
                                        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ ($cityStat->total / $topListingCities->first()->total) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">{{ $cityStat->total }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No listings yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow p-6 text-white">
                    <h2 class="text-lg font-semibold mb-2">Marketing Insights</h2>
                    <p class="mb-4 text-indigo-100">
                        Use this data to understand where demand is highest. Focus your marketing efforts (ads, recruitment) in cities with high search volume.
                    </p>
                    <div class="bg-white/10 rounded p-4">
                        <p class="text-3xl font-bold">{{ $recentLogs->total() }}</p>
                        <p class="text-sm opacity-80">Total Searches Tracked</p>
                    </div>
                </div>
            </div>

            <!-- Recent Logs Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-slate-700">Recent Search Logs</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filters</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentLogs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $log->city ?? 'All Cities' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->user ? $log->user->name : 'Guest' }}
                                        <span class="text-xs text-gray-400 block">{{ $log->ip_address }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if(!empty($log->filters))
                                            @foreach($log->filters as $key => $val)
                                                @if($val)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ str_replace('_', ' ', ucfirst($key)) }}: {{ $val }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    {{ $recentLogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
