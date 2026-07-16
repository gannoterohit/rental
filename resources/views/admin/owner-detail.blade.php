@extends('layouts.admin')

@section('title', 'Owner Details - Admin')

@section('admin-content')
<div class="flex min-h-0 bg-gray-100">
    <div class="flex-1 min-w-0">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-user-tie text-yellow-600 mr-2"></i>Owner Details
                </h1>
                <div class="flex gap-2">
                    <a href="{{ route('admin.owners') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                    <form action="{{ route('admin.owners.toggleBlock', $owner->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg transition
                                @if(!$owner->is_blocked) bg-red-600 hover:bg-red-700 text-white
                                @else bg-green-600 hover:bg-green-700 text-white
                                @endif">
                            <i class="fas {{ !$owner->is_blocked ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                            {{ !$owner->is_blocked ? 'Block Owner' : 'Unblock Owner' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Owner Info -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Owner Information</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Name</p>
                                <p class="font-semibold text-lg">{{ $owner->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Email</p>
                                <p class="font-semibold">{{ $owner->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Phone</p>
                                <p class="font-semibold">{{ $owner->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Status</p>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if(!$owner->is_blocked) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ !$owner->is_blocked ? 'Active' : 'Blocked' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Total Rooms</p>
                                <p class="font-semibold text-blue-600">{{ $owner->rooms_count ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Joined Date</p>
                                <p class="font-semibold">{{ $owner->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rooms -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Owner's Rooms</h2>
                        @if($rooms->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($rooms as $room)
                                    <div class="border rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $room->photo) }}" 
                                             alt="{{ $room->title }}"
                                             class="w-full h-32 object-cover">
                                        <div class="p-3">
                                            <h3 class="font-semibold">{{ $room->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $room->city }}</p>
                                            <p class="text-blue-600 font-bold">₹{{ number_format($room->rent) }}/mo</p>
                                            <a href="{{ route('rooms.show', $room) }}" 
                                               class="text-blue-600 text-sm hover:underline">View Room</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $rooms->links() }}
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No rooms listed yet</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                        <h3 class="font-bold mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <form action="{{ route('admin.owners.toggleBlock', $owner->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-2 rounded-lg transition text-left
                                        @if(!$owner->is_blocked) bg-red-600 hover:bg-red-700 text-white
                                        @else bg-green-600 hover:bg-green-700 text-white
                                        @endif">
                                    <i class="fas {{ !$owner->is_blocked ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                                    {{ !$owner->is_blocked ? 'Block Owner' : 'Unblock Owner' }}
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

