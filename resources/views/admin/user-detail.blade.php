@extends('layouts.app')

@section('title', 'User Details - Admin')

@section('content')
<div class="flex h-screen bg-gray-100">
    @include('admin.partials.sidebar')

    <div class="flex-1 min-w-0 overflow-hidden overflow-y-auto">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-user-circle text-green-600 mr-2"></i>User Details
                </h1>
                <div class="flex gap-2">
                    <a href="{{ route('admin.users') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                    <form action="{{ route('admin.users.toggleBlock', $user->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg transition
                                @if(!$user->is_blocked) bg-red-600 hover:bg-red-700 text-white
                                @else bg-green-600 hover:bg-green-700 text-white
                                @endif">
                            <i class="fas {{ !$user->is_blocked ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                            {{ !$user->is_blocked ? 'Block User' : 'Unblock User' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Info -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">User Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Name</p>
                                <p class="font-semibold text-lg">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Email</p>
                                <p class="font-semibold">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Phone</p>
                                <p class="font-semibold">{{ $user->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Status</p>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if(!$user->is_blocked) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ !$user->is_blocked ? 'Active' : 'Blocked' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Joined Date</p>
                                <p class="font-semibold">{{ $user->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Wallet Balance</p>
                                <p class="font-semibold text-green-600">₹{{ number_format($user->wallet ?? 0) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Bookings</h2>
                        @if($user->bookings && $user->bookings->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->bookings as $booking)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold">{{ $booking->room->title ?? 'N/A' }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking->room->city ?? '' }}</p>
                                                <p class="text-sm text-gray-500">{{ $booking->from_date }} to {{ $booking->to_date }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No bookings yet</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                        <h3 class="font-bold mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <form action="{{ route('admin.users.toggleBlock', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-2 rounded-lg transition text-left
                                        @if(!$user->is_blocked) bg-red-600 hover:bg-red-700 text-white
                                        @else bg-green-600 hover:bg-green-700 text-white
                                        @endif">
                                    <i class="fas {{ !$user->is_blocked ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                                    {{ !$user->is_blocked ? 'Block User' : 'Unblock User' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

