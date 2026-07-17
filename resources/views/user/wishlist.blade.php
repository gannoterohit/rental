@extends('layouts.app')

@section('title', 'My Wishlist | ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
<div class="user-workspace min-h-screen bg-slate-50 flex">
    @include('user.partials.sidebar', ['active' => 'wishlist'])
    <main class="flex-1 min-w-0 bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 flex items-center gap-3">
                    <i class="fas fa-heart text-red-500"></i> My Wishlist
                </h1>
                <p class="text-gray-600">You have <span class="font-bold text-indigo-600">{{ $wishlists->count() }}</span> rooms saved for later.</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="mt-4 md:mt-0 inline-flex items-center text-indigo-600 font-bold hover:underline">
                <i class="fas fa-arrow-left mr-2"></i> Browse More Rooms
            </a>
        </div>

        @if($wishlists->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($wishlists as $wishlist)
                    @php $room = $wishlist->room; @endphp
                    @if($room)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden group border border-gray-100 hover:border-indigo-300 transition-all duration-300" id="wishlist-item-{{ $room->id }}">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $room->photo_url }}" 
                                 alt="{{ $room->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <button onclick="removeFromWishlist({{ $room->id }})" 
                                    class="absolute top-3 right-3 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-all shadow-lg active:scale-90">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="absolute bottom-3 left-3 text-white">
                                <p class="text-xl font-black italic">₹{{ number_format($room->rent) }}<span class="text-xs font-normal not-italic"> /mo</span></p>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $room->title }}</h3>
                            <p class="text-gray-500 text-sm mb-4 flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-red-500"></i> {{ $room->city }}
                            </p>
                            <div class="flex gap-2">
                                <a href="{{ route('rooms.show', $room) }}" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-center font-bold py-2.5 rounded-xl hover:shadow-lg transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl p-12 text-center shadow-xl border-2 border-dashed border-gray-200">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="far fa-heart text-4xl text-red-300"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-2">Your wishlist is empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Save your favorite rooms here to easily find them later and compare.</p>
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center justify-center bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 transition shadow-lg">
                    Discover Rooms
                </a>
            </div>
        @endif
    </div>
</div>
    </main>
</div>

<script>
async function removeFromWishlist(roomId) {
    if(!confirm('Remove this room from your wishlist?')) return;

    try {
        const response = await fetch(`{{ url('/wishlist/toggle') }}/${roomId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            const item = document.getElementById(`wishlist-item-${roomId}`);
            item.style.opacity = '0';
            item.style.transform = 'scale(0.9)';
            setTimeout(() => {
                item.remove();
                if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
                    location.reload();
                }
            }, 300);
        }
    } catch (error) {
        console.error(error);
    }
}
</script>
@endsection
