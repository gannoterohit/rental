@extends('layouts.admin')

@section('title', 'All Payments - Admin')

@section('admin-content')
<div class="min-h-screen bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="flex-1 min-w-0 p-4 md:p-6">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-credit-card text-green-600 mr-2"></i>All Payments
                    </h1>
                    <p class="text-gray-600 mt-1">Total: {{ $payments->total() }} payments</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-4 mb-6">
                <a href="{{ route('admin.payments.index') }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ !request('status') ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-gray-600 border hover:bg-gray-50' }}">
                    All
                </a>
                <a href="{{ route('admin.payments.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('status') === 'completed' ? 'bg-green-600 text-white shadow-md' : 'bg-white text-gray-600 border hover:bg-gray-50' }}">
                    Completed
                </a>
                <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ request('status') === 'pending' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white text-gray-600 border hover:bg-gray-50' }}">
                    Pending
                </a>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Gateway</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Transaction ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($payments as $payment)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        @if($payment->user)
                                            <div class="flex flex-col">
                                                <span class="font-medium text-gray-800">{{ $payment->user->name }}</span>
                                                <span class="text-xs text-gray-500">{{ $payment->user->email }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">User not found</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium uppercase
                                            @if($payment->type === 'listing') bg-blue-100 text-blue-800
                                            @elseif($payment->type === 'featured') bg-purple-100 text-purple-800
                                            @elseif($payment->type === 'unlock') bg-yellow-100 text-yellow-800
                                            @elseif($payment->type === 'subscription') bg-pink-100 text-pink-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $payment->type }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-800">
                                        ₹{{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 uppercase">
                                        {{ $payment->gateway }}
                                    </td>
                                    <td class="px-4 py-3 text-xs font-mono text-gray-500">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($payment->status === 'completed') bg-green-100 text-green-800
                                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        {{ $payment->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                        <i class="fas fa-credit-card text-4xl mb-2"></i>
                                        <p>No payments found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                <div class="px-4 py-4 border-t bg-gray-50">
                    {{ $payments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
