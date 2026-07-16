@extends('layouts.admin')

@section('title', 'Reports - Admin')

@section('admin-content')
<div class="min-h-screen bg-gray-50">
    <div class="flex">
        {{-- SIDEBAR --}}
        {{-- MAIN --}}
        <div class="flex-1 min-w-0 p-4 md:p-6">
            {{-- HEADER --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>Reports
                        </h1>
                        <p class="text-gray-500 mt-1">Bookings & Payment transaction history</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg transition text-sm flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            {{-- SUMMARY STATS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Bookings</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $bookings->total() }}</p>
                        </div>
                        <div class="bg-indigo-100 rounded-full p-3">
                            <i class="fas fa-calendar-check text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Completed Payments</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $payments->total() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-rupee-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-5 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Revenue</p>
                            <p class="text-3xl font-bold text-gray-800">₹{{ number_format($payments->getCollection()->sum('amount'), 0) }}</p>
                            <p class="text-xs text-gray-400 mt-1">(this page only)</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABS --}}
            <div x-data="{ activeTab: 'payments' }">
                <div class="flex gap-2 mb-4">
                    <button @click="activeTab = 'payments'"
                        :class="activeTab === 'payments' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                        class="px-5 py-2.5 rounded-lg font-bold text-sm transition border border-gray-200 flex items-center gap-2">
                        <i class="fas fa-credit-card"></i> Payments
                        <span class="bg-white/20 px-2 py-0.5 rounded-full text-xs">{{ $payments->total() }}</span>
                    </button>
                    <button @click="activeTab = 'bookings'"
                        :class="activeTab === 'bookings' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50'"
                        class="px-5 py-2.5 rounded-lg font-bold text-sm transition border border-gray-200 flex items-center gap-2">
                        <i class="fas fa-calendar-check"></i> Bookings
                        <span class="bg-white/20 px-2 py-0.5 rounded-full text-xs">{{ $bookings->total() }}</span>
                    </button>
                </div>

                {{-- PAYMENTS TABLE --}}
                <div x-show="activeTab === 'payments'">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#ID</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Gateway</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($payments as $payment)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-4 text-sm text-gray-500 font-mono">#{{ $payment->id }}</td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $payment->user->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-400">{{ $payment->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @php
                                                $typeColors = [
                                                    'listing'      => 'bg-blue-100 text-blue-700',
                                                    'unlock'       => 'bg-purple-100 text-purple-700',
                                                    'featured'     => 'bg-yellow-100 text-yellow-700',
                                                    'booking'      => 'bg-green-100 text-green-700',
                                                    'subscription' => 'bg-indigo-100 text-indigo-700',
                                                ];
                                                $color = $typeColors[$payment->type] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase {{ $color }}">
                                                {{ $payment->type }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-bold text-gray-900">
                                            ₹{{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="text-xs font-semibold text-gray-600 capitalize">{{ $payment->gateway ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase bg-green-100 text-green-700">
                                                {{ $payment->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $payment->created_at->format('d M Y, h:i A') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                                            <i class="fas fa-credit-card text-4xl mb-3 block"></i>
                                            No completed payments yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($payments->hasPages())
                        <div class="px-5 py-4 border-t bg-gray-50">
                            {{ $payments->links() }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- BOOKINGS TABLE --}}
                <div x-show="activeTab === 'bookings'">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#ID</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Room</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Owner Payout</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($bookings as $booking)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-4 text-sm text-gray-500 font-mono">#{{ $booking->id }}</td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $booking->user->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-400">{{ $booking->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-sm font-semibold text-gray-900 max-w-[150px] truncate">
                                                {{ $booking->room->title ?? 'Room #' . $booking->room_id }}
                                            </div>
                                            <div class="text-xs text-gray-400">{{ $booking->room->city ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-600">
                                            <div>{{ \Carbon\Carbon::parse($booking->from_date)->format('d M Y') }}</div>
                                            <div class="text-gray-400">to {{ \Carbon\Carbon::parse($booking->to_date)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-bold text-gray-900">
                                            ₹{{ number_format($booking->total_amount, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-sm text-green-700 font-semibold">
                                            ₹{{ number_format($booking->owner_payout ?? 0, 2) }}
                                        </td>
                                        <td class="px-5 py-4">
                                            @php
                                                $statusColor = match($booking->status ?? 'pending') {
                                                    'confirmed' => 'bg-green-100 text-green-700',
                                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                                    'cancelled' => 'bg-red-100 text-red-700',
                                                    default     => 'bg-gray-100 text-gray-700',
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase {{ $statusColor }}">
                                                {{ $booking->status ?? 'pending' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $booking->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                                            <i class="fas fa-calendar-check text-4xl mb-3 block"></i>
                                            No bookings yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($bookings->hasPages())
                        <div class="px-5 py-4 border-t bg-gray-50">
                            {{ $bookings->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
