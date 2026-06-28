
<!-- Desktop Grid (Visible on Desktop/Tablet) -->
<div class="hidden md:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($rooms as $room)
        <div class="group bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_rgba(79,70,229,0.15)] transition-all duration-500 overflow-hidden border border-slate-100 hover:border-indigo-200 transform hover:-translate-y-2 flex flex-col h-full">
            <!-- Image Container (Clickable) -->
            <a href="{{ route('rooms.show', $room->id) }}" class="relative block h-56 overflow-hidden bg-slate-100 group/img">
                @if($room->photo_url)
                    @php
                        $photoUrl = $room->photo_url;
                        if (str_contains($photoUrl, 'unsplash.com')) {
                            $baseUrl = strtok($photoUrl, '?');
                            $optimizedUrl = $baseUrl . '?w=600&h=400&fm=webp&q=85&fit=crop';
                        } else {
                            $optimizedUrl = $photoUrl;
                        }
                    @endphp
                    <img src="{{ $optimizedUrl }}"
                         alt="{{ $room->title }}"
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Room+Image+Coming+Soon';">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-indigo-50/50">
                        <i class="fas fa-house-chimney text-5xl text-indigo-200 mb-2"></i>
                        <span class="text-xs font-bold text-indigo-300 uppercase tracking-widest">Image Coming Soon</span>
                    </div>
                @endif
                
                <!-- Status Badges -->
                <div class="absolute top-4 left-4 flex flex-col gap-2 z-20">
                    @if($room->is_featured)
                        <span class="bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg shadow-lg">Featured</span>
                    @endif
                    <span class="bg-white/90 backdrop-blur-md dark:bg-slate-800/90 text-indigo-700 dark:text-indigo-400 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-lg shadow-sm border border-white/50 dark:border-slate-700">
                        {{ str_replace('_', ' ', $room->room_type) }}
                    </span>
                    
                    @if($room->listing_type === 'broker')
                        <span style="background-color: #f97316 !important;" class="text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg shadow-lg border border-white/20">
                            Broker Fee: ₹{{ $room->broker_fee }}
                        </span>
                    @else
                        <span class="bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg shadow-lg border border-emerald-400">
                            No Broker Fee
                        </span>
                    @endif
                </div>

                {{-- Wishlist Toggle --}}
                <button onclick="toggleWishlist(event, {{ $room->id }})" 
                        class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-md rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 transition-all shadow-lg active:scale-90 z-20 hover:bg-white"
                        id="wishlist-btn-{{ $room->id }}">
                    <i class="{{ (Auth::check() && Auth::user()->hasInWishlist($room->id)) ? 'fas text-red-500' : 'far' }} fa-heart text-xl"></i>
                </button>
                
                <!-- Price Floating Tag -->
                <div class="absolute bottom-4 left-4">
                    <div class="bg-indigo-600 text-white px-4 py-2 rounded-xl shadow-xl border border-white/20">
                        <span class="text-xl font-black">₹{{ number_format($room->rent) }}</span>
                        <span class="text-[10px] uppercase font-bold text-indigo-100 ml-1">/ Month</span>
                    </div>
                </div>
            </a>
            
            <!-- Content -->
            <div class="p-6 flex flex-col flex-grow">
                <div class="mb-4">
                    <h3 class="font-bold text-lg mb-2 text-slate-900 line-clamp-1 group-hover:text-indigo-600 transition-colors font-heading">
                        <a href="{{ route('rooms.show', $room->id) }}">{{ $room->title }}</a>
                    </h3>
                    <div class="flex flex-col">
                        <div class="flex items-center text-slate-500 text-sm">
                            <i class="fas fa-location-dot mr-2 text-indigo-500"></i>
                            <span class="font-medium">{{ $room->city }}</span>
                        </div>
                        <!-- Distance Tag -->
                        <div class="distance-tag hidden mt-1 flex items-center gap-1.5" data-lat="{{ $room->latitude }}" data-lng="{{ $room->longitude }}">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest"><span class="distance-km">0</span> km away</span>
                        </div>
                    </div>
                </div>
                
                <p class="text-slate-600 text-sm mb-5 line-clamp-2 leading-relaxed">
                    {{ $room->description ?? 'Beautifully maintained property in a prime location with all essential amenities.' }}
                </p>
                
                <!-- Quick Tags -->
                <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                    <div class="flex items-center bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-lg">
                        <i class="fas fa-couch text-indigo-400 text-xs mr-2"></i>
                        <span class="text-[11px] font-bold text-slate-600 uppercase">{{ $room->furnishing_type }}</span>
                    </div>
                    @if($room->tenant_type)
                    <div class="flex items-center bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-lg">
                        <i class="fas fa-users text-indigo-400 text-xs mr-2"></i>
                        <span class="text-[11px] font-bold text-slate-600 uppercase">{{ $room->tenant_type }}</span>
                    </div>
                    @endif
                </div>
                
                <!-- Action -->
                @auth
                    @if(Auth::user()->role === 'owner' && Auth::id() === $room->user_id)
                        <div class="grid grid-cols-2 gap-3 mt-auto">
                            <a href="{{ route('rooms.edit', $room) }}" class="flex items-center justify-center bg-amber-50 text-amber-700 font-bold py-3 rounded-xl hover:bg-amber-100 transition-colors text-sm">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="delete-room-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center bg-red-50 text-red-600 font-bold py-3 rounded-xl hover:bg-red-100 transition-colors text-sm">
                                    <i class="fas fa-trash mr-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('rooms.show', $room->id) }}" 
                           class="group/btn relative overflow-hidden bg-slate-900 text-white text-center font-bold py-3.5 px-6 rounded-xl transition-all duration-300 hover:bg-indigo-600 shadow-lg mt-auto">
                            <span class="relative z-10 flex items-center justify-center">
                                View Property Details
                                <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('rooms.show', $room->id) }}" 
                       class="group/btn relative overflow-hidden bg-slate-900 text-white text-center font-bold py-3.5 px-6 rounded-xl transition-all duration-300 hover:bg-indigo-600 shadow-lg mt-auto">
                        <span class="relative z-10 flex items-center justify-center">
                            View Property Details
                            <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                @endauth
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination (Desktop) -->
<div class="hidden md:flex justify-center mt-4 mb-10 custom-pagination">
    <div class="inline-block">
        {{ $rooms->withQueryString()->links() }}
    </div>
</div>
