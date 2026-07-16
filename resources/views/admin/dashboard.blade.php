@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin-content')
@php
 $logo = \App\Models\Setting::get('website_logo');
@endphp

<div class="min-h-screen bg-gray-50">
    <div class="flex">

        {{-- SIDEBAR --}}
        {{-- MAIN --}}
        <div class="flex-1 min-w-0 p-4 md:p-6">

            {{-- WELCOME SECTION --}}
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 mb-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl font-bold mb-1">
                            Welcome, {{ Auth::user()->name }} 👋
                        </h1>
                        <p class="text-indigo-100">Admin control panel overview</p>
                    </div>
                    <div class="flex gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ $rooms }}</div>
                            <div class="text-sm text-indigo-100">Rooms</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">{{ $users }}</div>
                            <div class="text-sm text-indigo-100">Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">
                                ₹{{ number_format($totalEarnings) }}
                            </div>
                            <div class="text-sm text-indigo-100">Revenue</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-green-500 h-2"></div>
                    <div class="p-3 md:p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-xs md:text-sm">Approved</p>
                                <p class="text-xl md:text-3xl font-bold text-green-600 mt-1">{{ $approvedRooms }}</p>
                            </div>
                            <div class="bg-green-100 rounded-full p-2 md:p-3">
                                <i class="fas fa-check-circle text-green-600 text-base md:text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-yellow-500 h-2"></div>
                    <div class="p-3 md:p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-xs md:text-sm">Pending</p>
                                <p class="text-xl md:text-3xl font-bold text-yellow-600 mt-1">{{ $pendingRooms }}</p>
                            </div>
                            <div class="bg-yellow-100 rounded-full p-2 md:p-3">
                                <i class="fas fa-clock text-yellow-600 text-base md:text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-red-500 h-2"></div>
                    <div class="p-3 md:p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-xs md:text-sm">Rejected</p>
                                <p class="text-xl md:text-3xl font-bold text-red-600 mt-1">{{ $rejectedRooms }}</p>
                            </div>
                            <div class="bg-red-100 rounded-full p-2 md:p-3">
                                <i class="fas fa-times-circle text-red-600 text-base md:text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-indigo-500 h-2"></div>
                    <div class="p-3 md:p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-xs md:text-sm">Total Revenue</p>
                                <p class="text-lg md:text-3xl font-bold text-indigo-600 mt-1">
                                    ₹{{ number_format($totalEarnings ?? 0) }}
                                </p>
                            </div>
                            <div class="bg-indigo-100 rounded-full p-2 md:p-3">
                                <i class="fas fa-rupee-sign text-indigo-600 text-base md:text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHARTS SECTION - FIXED HEIGHT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                {{-- REVENUE CHART --}}
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6 flex flex-col h-[450px]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Monthly Revenue ({{ date('Y') }})</h3>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-chart-line mr-1"></i>
                            <span>Total: ₹{{ number_format($totalEarnings) }}</span>
                        </div>
                    </div>
                    <div class="flex-grow relative">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- REVENUE BREAKDOWN --}}
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col h-[450px]">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Revenue Breakdown</h3>
                    <div class="flex-1 min-h-0 mb-6 flex items-center justify-center">
                        <div class="w-full h-full max-h-[220px] flex justify-center">
                            <canvas id="revenueBreakdownChart"></canvas>
                        </div>
                    </div>
                    <div class="space-y-2.5 overflow-y-auto pr-1 custom-scrollbar">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <div class="w-2.5 h-2.5 bg-indigo-500 rounded-full mr-2"></div>
                                <span class="text-gray-600">Listing Fees</span>
                            </div>
                            <span class="font-bold text-gray-800">₹{{ number_format($listingEarnings) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <div class="w-2.5 h-2.5 bg-amber-500 rounded-full mr-2"></div>
                                <span class="text-gray-600">Featured Fees</span>
                            </div>
                            <span class="font-bold text-gray-800">₹{{ number_format($featuredEarnings) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <div class="w-2.5 h-2.5 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-gray-600">Unlock Fees</span>
                            </div>
                            <span class="font-bold text-gray-800">₹{{ number_format($unlockEarnings) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full mr-2"></div>
                                <span class="text-gray-600">Bookings</span>
                            </div>
                            <span class="font-bold text-gray-800">₹{{ number_format($bookingEarnings) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <div class="w-2.5 h-2.5 bg-rose-500 rounded-full mr-2"></div>
                                <span class="text-gray-600">Subscriptions</span>
                            </div>
                            <span class="font-bold text-gray-800">₹{{ number_format($subscriptionEarnings) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MONTHLY COMPARISON --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Comparison</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Current Month</span>
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800 font-semibold">
                                {{ $percentageChange > 0 ? '↑' : '↓' }} {{ abs(round($percentageChange)) }}%
                            </span>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">₹{{ number_format($currentMonthEarnings) }}</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500">Last Month</span>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">₹{{ number_format($lastMonthEarnings) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                {{-- RECENT USERS --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
                        <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RECENT OWNERS --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Owners</h3>
                        <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentOwners as $owner)
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-tie text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $owner->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $owner->rooms_count }} rooms</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RECENT ROOMS --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Rooms</h3>
                        <a href="{{ route('admin.all-rooms') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentRooms as $room)
                            <div class="border-l-4 
                                {{ $room->listing_status=='approved'?'border-green-500':
                                   ($room->listing_status=='pending'?'border-yellow-500':'border-red-500') }}
                                pl-3 py-1">
                                <p class="font-medium text-gray-800 text-sm truncate">{{ $room->title ?? 'Room #'.$room->id }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-500">{{ $room->owner->name ?? 'N/A' }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full 
                                        {{ $room->listing_fee_paid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $room->listing_fee_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RECENT PAYMENTS --}}
            <div class="bg-white rounded-lg shadow-md p-6 overflow-hidden">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-history text-blue-600 mr-2"></i>Recent Payments
                    </h2>
                    <a href="{{ route('admin.payments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                </div>

                @if(isset($recentPayments) && $recentPayments->count() > 0)
                    <div class="overflow-x-auto w-full">
                        <div class="min-w-full">
                            <table class="w-full table-fixed">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700 w-1/5">User</th>
                                        <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700 w-1/6">Type</th>
                                        <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700 w-1/6">Amount</th>
                                        <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700 w-1/5">Date</th>
                                        <th class="text-left py-3 px-4 font-semibold text-sm text-gray-700 w-1/6">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-2 flex-shrink-0">
                                                        <i class="fas fa-user text-gray-600 text-xs"></i>
                                                    </div>
                                                    <span class="truncate">{{ $payment->user->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                                    @if($payment->type === 'listing') bg-blue-100 text-blue-800
                                                    @elseif($payment->type === 'featured') bg-yellow-100 text-yellow-800
                                                    @elseif($payment->type === 'unlock') bg-purple-100 text-purple-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($payment->type) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 font-semibold text-green-600 whitespace-nowrap">
                                                ₹{{ number_format($payment->amount) }}
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-600 whitespace-nowrap">
                                                {{ $payment->created_at->format('d M Y') }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 whitespace-nowrap">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No payments yet</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- CHARTS --}}
@php
$primaryChartColor = \App\Models\Setting::get('primary_color', '#4F46E5');
$secondaryChartColor = \App\Models\Setting::get('secondary_color', '#10B981');
$primaryRgb = implode(',', sscanf(ltrim($primaryChartColor, '#'), '%02x%02x%02x'));
$secondaryRgb = implode(',', sscanf(ltrim($secondaryChartColor, '#'), '%02x%02x%02x'));
@endphp
<script>
const PRIMARY_CHART_COLOR = '{{ $primaryChartColor }}';
const SECONDARY_CHART_COLOR = '{{ $secondaryChartColor }}';
const PRIMARY_CHART_RGB = '{{ $primaryRgb }}';
const SECONDARY_CHART_RGB = '{{ $secondaryRgb }}';
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Revenue Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            data: @json($revenueData),
            borderColor: PRIMARY_CHART_COLOR,
            backgroundColor: 'rgba(' + PRIMARY_CHART_RGB + ',0.15)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                padding: 10,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return 'Revenue: ₹' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: { 
            y: { 
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Revenue Breakdown Pie Chart
new Chart(document.getElementById('revenueBreakdownChart'), {
    type: 'doughnut',
    data: {
        labels: ['Listing Fees', 'Featured Fees', 'Unlock Fees', 'Bookings', 'Subscriptions'],
        datasets: [{
            data: [{{ $listingEarnings }}, {{ $featuredEarnings }}, {{ $unlockEarnings }}, {{ $bookingEarnings }}, {{ $subscriptionEarnings }}],
            backgroundColor: [PRIMARY_CHART_COLOR, '#f59e0b', '#a855f7', SECONDARY_CHART_COLOR, '#f43f5e'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                padding: 10,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = Math.round((context.parsed / total) * 100);
                        return context.label + ': ₹' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '60%'
    }
});
</script>
@endsection