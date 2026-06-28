@extends('layouts.app')

@section('title', (request('city') ? 'Verified Rooms & PG in ' . request('city') : 'Browse Rooms & PG for Rent') . ' | ' . \App\Models\Setting::get('website_name', 'RoomRental'))
@section('description', (request('city') ? 'Find the best verified rooms, apartments, and PG in ' . request('city') . '. Browse listings with photos, rents, and owner contacts.' : 'Browse verified room listings in your city. Find apartments, houses, and rooms for rent with verified owners.'))
@section('keywords', (request('city') ? 'pg in ' . request('city') . ', room for rent in ' . request('city') . ', ' : '') . 'browse rooms, room listings, ' . \App\Models\Setting::get('seo_meta_keywords', 'apartment, house, property'))
@section('og_title', (request('city') ? 'Rooms & PG in ' . request('city') : 'Browse Rooms') . ' | ' . \App\Models\Setting::get('website_name', 'RoomRental'))
@section('og_description', (request('city') ? 'Check out available rooms and paying guests in ' . request('city') : 'Browse verified room listings in your city. Find apartments and rooms for rent.'))
@section('og_url', route('rooms.index', request()->all()))
@section('canonical', route('rooms.index'))

@push('styles')
@include('partials.listings-ld')
<link rel="preload" href="{{ asset('assets/images/hero-bg-desktop.webp') }}" as="image" fetchpriority="high" media="(min-width: 768px)">
<style>
    /* Inline critical CSS for above-the-fold content */
    @media (max-width: 1023px) {
        .navbar, footer, .hero-mobile {
            display: none !important;
        }
        body {
            padding-bottom: 70px; /* Space for bottom nav */
            background-color: #f8fafc;
        }
    }
    .hero-mobile {
        background: linear-gradient(to bottom right, #1e1b4b, #312e81, #581c87);
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-content-mobile {
        width: 100%;
        padding: 0 1rem;
        z-index: 10;
    }
    .glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
    }
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .pulse-glow {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
    }
</style>

@endpush

@section('content')
<!-- Mobile-First Hero Section -->
<div class="relative">
    <!-- Background Image - Mobile Optimized -->
    <!-- Mobile App Structure -->
    <div class="md:hidden">
        @include('partials.mobile-search')
    </div>
    
    <!-- Desktop Hero Section -->
    <div class="hidden md:block relative min-h-[580px] flex items-center pt-12 pb-24">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <picture>
                <source srcset="{{ asset('assets/images/hero-bg-desktop.webp') }}" type="image/webp">
                <img src="{{ asset('assets/images/hero-bg.png') }}"
                     alt="Room rental background"
                     class="w-full h-full object-cover"
                     fetchpriority="high"
                     width="1200" height="400"
                     decoding="async"
                     loading="eager">
            </picture>
            <!-- Soft gradient: dark on left/top, fades to translucent on right -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-800/70 to-slate-700/30"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-transparent to-slate-900/80"></div>
        </div>
        
        <div class="container mx-auto px-6 h-full flex items-center relative z-10">
            <div class="w-full max-w-5xl mx-auto">
                <!-- Headline -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-2 bg-indigo-600/80 backdrop-blur-sm text-white text-xs font-bold px-4 py-1.5 rounded-full mb-4 border border-indigo-400/30">
                        <i class="fas fa-shield-halved text-indigo-300"></i>
                        <span>100% Verified Listings — Zero Brokerage</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-white mb-4 leading-tight [text-shadow:0_2px_20px_rgba(0,0,0,0.9),0_0_40px_rgba(0,0,0,0.5)]">
                        @if(request('city'))
                            Rooms in <span class="text-indigo-300">{{ request('city') }}</span>
                        @else
                            Find Your Perfect<br><span class="text-indigo-300">Room to Call Home</span>
                        @endif
                    </h1>
                    <p class="text-white/90 text-lg font-medium [text-shadow:0_1px_8px_rgba(0,0,0,0.8)] max-w-xl mx-auto">
                        10,000+ rooms, PG & apartments across India with direct owner contact.
                    </p>
                </div>

                <!-- Search Card -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-2xl p-4">
                    <form action="{{ route('rooms.index') }}" method="GET">
                        <div class="flex items-end gap-3">
                            <!-- Location -->
                            <div class="flex-[2] min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="text-xs font-bold text-white/90 uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-indigo-300"></i> Location
                                    </label>
                                    <button type="button" onclick="detectLocation(true)" 
                                            class="text-[10px] font-bold text-indigo-200 hover:text-white flex items-center gap-1 bg-indigo-600/30 hover:bg-indigo-600/60 px-2 py-0.5 rounded-full transition-all border border-indigo-400/30 whitespace-nowrap">
                                        <i class="fas fa-location-crosshairs text-[8px]"></i> Near Me
                                    </button>
                                </div>
                                <div class="relative">
                                    <input type="text" name="city" id="hero-city-input"
                                           value="{{ request('city') }}" 
                                           placeholder="City or area..."
                                           class="w-full py-3 pl-4 pr-9 bg-white text-slate-800 rounded-xl text-sm font-semibold shadow-md border-0 focus:ring-2 focus:ring-indigo-400 outline-none">
                                    @if(request('city') || session('user_city'))
                                        <a href="{{ route('rooms.index', ['clear' => 1]) }}" 
                                           class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors" title="Clear">
                                            <i class="fas fa-times-circle text-sm"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <!-- Furnishing -->
                            <div class="flex-1 min-w-0">
                                <label class="text-xs font-bold text-white/90 block mb-1.5 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-couch text-indigo-300"></i> Type
                                </label>
                                <select name="furnishing_type" class="w-full py-3 px-3 bg-white text-slate-800 rounded-xl text-sm font-semibold shadow-md border-0 focus:ring-2 focus:ring-indigo-400 appearance-none outline-none">
                                    <option value="">Any</option>
                                    <option value="furnished" {{ request('furnishing_type') == 'furnished' ? 'selected' : '' }}>Furnished</option>
                                    <option value="semi-furnished" {{ request('furnishing_type') == 'semi-furnished' ? 'selected' : '' }}>Semi</option>
                                    <option value="unfurnished" {{ request('furnishing_type') == 'unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                                </select>
                            </div>
                            <!-- Room Type -->
                            <div class="flex-1 min-w-0">
                                <label class="text-xs font-bold text-white/90 block mb-1.5 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-bed text-indigo-300"></i> Room
                                </label>
                                <select name="room_type" class="w-full py-3 px-3 bg-white text-slate-800 rounded-xl text-sm font-semibold shadow-md border-0 focus:ring-2 focus:ring-indigo-400 appearance-none outline-none">
                                    <option value="">Any</option>
                                    <option value="single_room" {{ request('room_type') == 'single_room' ? 'selected' : '' }}>Single</option>
                                    <option value="shared_room" {{ request('room_type') == 'shared_room' ? 'selected' : '' }}>Shared</option>
                                    <option value="1bhk" {{ request('room_type') == '1bhk' ? 'selected' : '' }}>1 BHK</option>
                                    <option value="2bhk" {{ request('room_type') == '2bhk' ? 'selected' : '' }}>2 BHK</option>
                                </select>
                            </div>
                            <!-- Budget Min -->
                            <div class="flex-1 min-w-0">
                                <label class="text-xs font-bold text-white/90 block mb-1.5 uppercase tracking-wider">
                                    <i class="fas fa-rupee-sign text-indigo-300 mr-1"></i> Min
                                </label>
                                <input type="number" name="min_rent" value="{{ request('min_rent') }}" 
                                       placeholder="Min ₹"
                                       class="w-full py-3 px-3 bg-white text-slate-800 rounded-xl text-sm font-semibold shadow-md border-0 focus:ring-2 focus:ring-indigo-400 outline-none">
                            </div>
                            <!-- Budget Max -->
                            <div class="flex-1 min-w-0">
                                <label class="text-xs font-bold text-white/90 block mb-1.5 uppercase tracking-wider">
                                    Max
                                </label>
                                <input type="number" name="max_rent" value="{{ request('max_rent') }}" 
                                       placeholder="Max ₹"
                                       class="w-full py-3 px-3 bg-white text-slate-800 rounded-xl text-sm font-semibold shadow-md border-0 focus:ring-2 focus:ring-indigo-400 outline-none">
                            </div>
                            <!-- Search Button -->
                            <div class="flex-shrink-0">
                                <label class="text-xs font-bold text-white/0 block mb-1.5">Go</label>
                                <button type="submit" 
                                        class="py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl shadow-lg transition-all hover:-translate-y-0.5 flex items-center gap-2 text-sm whitespace-nowrap">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-12 md:h-16">
                <path d="M0,40L60,35C120,30 240,20 360,20C480,20 600,25 720,30C840,35 960,35 1080,30C1200,25 1320,20 1380,20L1440,20V80H1380C1320,80 1200,80 1080,80C960,80 840,80 720,80C600,80 480,80 360,80C240,80 120,80 60,80H0Z" fill="white"/>
            </svg>
        </div>
    </div>
</div>

<!-- Quick Filter Chips (Desktop) -->
<div class="hidden md:block bg-white border-b border-slate-100 shadow-sm">
    <div class="container mx-auto px-6 py-3">
        <form action="{{ route('rooms.index') }}" method="GET" id="quick-filter-form">
            @if(request('city'))<input type="hidden" name="city" value="{{ request('city') }}">@endif
            @if(request('min_rent'))<input type="hidden" name="min_rent" value="{{ request('min_rent') }}">@endif
            @if(request('max_rent'))<input type="hidden" name="max_rent" value="{{ request('max_rent') }}">@endif
            <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar">
                <span class="text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap mr-1">Quick Filters:</span>

                @php
                $chips = [
                    ['label' => '🏠 Single Room',   'name' => 'room_type',        'value' => 'single_room'],
                    ['label' => '👥 Shared Room',   'name' => 'room_type',        'value' => 'shared_room'],
                    ['label' => '🏢 1 BHK',          'name' => 'room_type',        'value' => '1bhk'],
                    ['label' => '🛋 Furnished',      'name' => 'furnishing_type',  'value' => 'furnished'],
                    ['label' => '👩 Girls Only',     'name' => 'tenant_type',      'value' => 'girls'],
                    ['label' => '👨 Boys Only',      'name' => 'tenant_type',      'value' => 'boys'],
                    ['label' => '💸 Under ₹5000',    'name' => 'max_rent',         'value' => '5000'],
                    ['label' => '💸 Under ₹10000',   'name' => 'max_rent',         'value' => '10000'],
                    ['label' => '✅ No Brokerage',   'name' => 'listing_type',     'value' => 'owner'],
                ];
                @endphp

                @foreach($chips as $chip)
                    @php
                        $isActive = request($chip['name']) === $chip['value'];
                        $params = array_merge(request()->except([$chip['name']]), $isActive ? [] : [$chip['name'] => $chip['value']]);
                    @endphp
                    <a href="{{ route('rooms.index', $params) }}"
                       class="flex-shrink-0 text-xs font-bold px-4 py-1.5 rounded-full border transition-all duration-200
                              {{ $isActive ? 'bg-indigo-600 text-white border-indigo-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        {{ $chip['label'] }}
                    </a>
                @endforeach

                @if(request()->hasAny(['room_type','furnishing_type','tenant_type','max_rent','min_rent','listing_type','city']))
                    <a href="{{ route('rooms.index', ['clear' => 1]) }}"
                       class="flex-shrink-0 text-xs font-bold px-4 py-1.5 rounded-full border border-red-200 text-red-500 hover:bg-red-50 transition-all ml-2">
                        ✕ Clear All
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Offer Hero Banner Section -->
<section class="bg-white">
    <div class="container mx-auto px-4 md:px-6">
        @include('partials.offer-banner', ['placement' => 'home_hero'])
    </div>
     <!-- 1st Ad Slot: Below Search/Hero -->
    <div class="container mx-auto px-4 mt-4">
        @include('partials.adsense-slot', ['placement' => 'home_top'])
    </div>
</section>

<!-- Rooms Section -->
<div class="bg-gradient-to-b from-gray-50 to-white py-6 md:py-8">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8">
            <div>
                <div class="inline-flex items-center gap-2 md:gap-3 mb-2">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg md:rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-home text-white text-base md:text-lg"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-slate-900">
                        {{ request('city') ? 'Rooms in ' . request('city') : 'Available Rooms' }}
                    </h2>
                </div>
                <p class="text-slate-600 text-sm md:text-base font-medium ml-12 md:ml-14">
                    @if(request('city'))
                        Best <b>PG</b>, <b>shared rooms</b>, and <b>rented apartments</b> in {{ request('city') }}.
                        Found <span class="font-black text-indigo-600 text-lg md:text-xl">{{ $rooms->total() }}</span> verified listings.
                    @elseif(request('min_rent') || request('max_rent'))
                        Found <span class="font-black text-indigo-600 text-lg md:text-xl">{{ $rooms->total() }}</span> rooms matching your search
                    @else
                        Browse the latest verified room listings across all cities.
                    @endif
                </p>
            </div>
            
            <!-- Trust Badges -->
            <div class="hidden lg:flex items-center gap-8">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-black text-slate-900 uppercase">100% Verified</span>
                        <span class="block text-[10px] font-bold text-slate-500 uppercase">Direct Owners</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-black text-slate-900 uppercase">Secure Contact</span>
                        <span class="block text-[10px] font-bold text-slate-500 uppercase">Verified PG</span>
                    </div>
                </div>
            </div>
            @auth
                @if(Auth::user()->role === 'owner')
                    <a href="{{ route('rooms.create') }}"
                       class="inline-flex items-center justify-center bg-gradient-to-r from-indigo-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-2.5 px-5 md:px-6 rounded-lg md:rounded-xl transition-all duration-300 shadow-md hover:shadow-lg text-sm md:text-base">
                        <i class="fas fa-plus-circle mr-2"></i>List Your Room
                    </a>
                @endif
            @endauth
        </div>
    </div> <!-- Close Header Container -->
        
    <div class="container mx-auto px-4">
        @if($rooms->count() > 0)
            
            @include('rooms.partials.listing-mobile')
            @include('rooms.partials.listing-desktop')

            <!-- 2nd Ad Slot: Bottom of List -->
            <div class="mt-8">
                 @include('partials.adsense-slot', ['placement' => 'home_bottom'])
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-12 md:py-16 bg-gradient-to-br from-slate-50 to-blue-50 rounded-xl md:rounded-2xl shadow-lg border-2 border-dashed border-slate-300">
                <div class="max-w-md mx-auto">
                    <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full mb-4 md:mb-6 shadow-md float-animation">
                        <i class="fas fa-home text-4xl md:text-5xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 mb-2 md:mb-3">No Rooms Found</h3>
                    <p class="text-slate-600 mb-6 md:mb-8 text-sm md:text-base">Try adjusting your search criteria or browse all available rooms</p>
                    <a href="{{ route('rooms.index') }}" 
                       class="inline-flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-2.5 px-6 md:px-8 rounded-lg md:rounded-xl transition-all duration-300 shadow-md hover:shadow-lg text-sm md:text-base">
                        <i class="fas fa-search mr-2"></i>Browse All Rooms
                    </a>
                    
                    @if(request('city'))
                        <div class="mt-8 p-6 bg-white rounded-xl shadow-sm border border-indigo-100">
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Want to be notified?</h4>
                            <p class="text-slate-600 text-sm mb-4">We'll email you as soon as a new room is listed in <strong>{{ request('city') }}</strong>.</p>
                            <button onclick="subscribeToAlerts('{{ request('city') }}')" 
                                    id="notify-btn"
                                    class="inline-flex items-center justify-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold py-2.5 px-6 rounded-lg transition-all duration-300 border border-indigo-200 text-sm">
                                <i class="fas fa-bell mr-2"></i>Notify Me for {{ request('city') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
@auth
    @if(Auth::user()->role === 'owner')
        @push('sweetalert')
            <script src="{{ asset('assets/js/sweetalert2.min.js') }}" defer></script>
        @endpush
    @endif
    <script defer>
    async function toggleWishlist(event, roomId) {
        event.preventDefault();
        event.stopPropagation();
        
        @guest
            window.location.href = '{{ route("login") }}';
            return;
        @endguest

        try {
            const response = await fetch(`{{ url('/wishlist/toggle') }}/${roomId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to toggle wishlist');
            const data = await response.json();

            if (data.success) {
                const updateBtn = (id) => {
                    const btn = document.getElementById(id);
                    if (btn) {
                        const icon = btn.querySelector('i');
                        if (data.status === 'added') {
                            icon.classList.remove('far');
                            icon.classList.add('fas', 'text-red-500');
                        } else {
                            icon.classList.remove('fas', 'text-red-500');
                            icon.classList.add('far');
                        }
                    }
                };
                updateBtn(`wishlist-btn-${roomId}`);
                updateBtn(`wishlist-btn-mobile-${roomId}`);
            }
        } catch (error) {
            console.error(error);
        }
    }
    const razorpayKey = '{{ \App\Models\Setting::get("razorpay_key", "") }}';
    
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-room-form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const result = await Swal.fire({
                    title: 'Delete Room?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                });

                if (!result.isConfirmed) return;
                
                const formData = new FormData(this);
                const roomId = this.dataset.roomId;
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Deleting...';
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(async response => {
                    if (response.status === 419) {
                        throw new Error('CSRF token mismatch. Please refresh the page and try again.');
                    }
                    
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.includes("application/json")) {
                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.message || 'Failed to delete room');
                        }
                        return data;
                    } else {
                        const text = await response.text();
                        throw new Error(text || 'Invalid response from server');
                    }
                })
                .then(data => {
                    if (data.success) {
                        toastr.success('Room deleted successfully', 'Success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(data.message || 'Failed to delete room', 'Error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error(error.message || 'Failed to delete room', 'Error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        });
    });

    async function markBooked(roomId) {
        const result = await Swal.fire({
            title: 'Mark as Booked?',
            text: "This room will be hidden from users.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7c3aed',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, mark it!'
        });

        if (!result.isConfirmed) return;
        
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            const response = await fetch(`{{ route('rooms.markBooked', ':id') }}`.replace(':id', roomId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire(
                    'Booked!',
                    'Room has been marked as booked.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            } else {
                toastr.error(data.message || 'Failed to mark room as booked', 'Error');
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('Something went wrong', 'Error');
        }
    }

    async function markAvailable(roomId) {
        const result = await Swal.fire({
            title: 'Make Available?',
            text: "Making this room available will charge listing fee.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Continue'
        });

        if (!result.isConfirmed) return;
        
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            const response = await fetch(`{{ route('rooms.markAvailable', ':id') }}`.replace(':id', roomId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            
            const data = await response.json();
            
            if (data.success) {
                if (data.subscription_used) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Room made available using subscription!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else if (data.payment_id) {
                    await initiatePayment(data.payment_id, data.amount, 'listing', roomId);
                } else {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Room marked as available.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                }
            } else {
                toastr.error(data.message || 'Failed to make room available', 'Error');
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('Something went wrong', 'Error');
        }
    }

    async function initiatePayment(paymentId, amount, type, referenceId) {
        try {
            // Lazy load Razorpay SDK
            const Razorpay = await loadRazorpaySDK();

            if (!razorpayKey || razorpayKey === '' || razorpayKey === 'null') {
                toastr.error('Razorpay key not configured. Please add it in Business Settings.', 'Error');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            const orderResponse = await fetch('{{ route("razorpay.createOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ amount }),
                credentials: 'same-origin'
            });
            
            if (!orderResponse.ok) {
                const errorData = await orderResponse.json().catch(() => ({ message: 'Failed to create order' }));
                throw new Error(errorData.message || 'Failed to create order');
            }
            
            const orderData = await orderResponse.json();
            
            if (!orderData.success || !orderData.order_id) {
                throw new Error(orderData.message || 'Failed to create order');
            }
            
            const options = {
                key: razorpayKey,
                amount: orderData.amount * 100,
                currency: 'INR',
                name: '{{ \App\Models\Setting::get("website_name", "RoomRental") }}',
                description: 'Make Room Available - Listing Fee',
                order_id: orderData.order_id,
                handler: async function(response) {
                    console.log('Razorpay Response:', response);
                    
                    if (!response.razorpay_order_id || !response.razorpay_signature) {
                        alert('Payment failed: Missing order ID or signature. Please try again.');
                        console.error('Missing properties in response', response);
                        return;
                    }

                    try {
                        const verifyResponse = await fetch('{{ route("razorpay.verify") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id || orderData.order_id,
                                razorpay_signature: response.razorpay_signature,
                                payment_id: paymentId,
                                type: type,
                                reference_id: referenceId
                            }),
                            credentials: 'same-origin'
                        });
                        
                        if (!verifyResponse.ok) {
                            const errorData = await verifyResponse.json().catch(() => ({ message: 'Payment verification failed' }));
                            throw new Error(errorData.message || 'Payment verification failed');
                        }
                        
                        const verifyData = await verifyResponse.json();
                        
                        if (verifyData.status === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Payment successful! Room is now available.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            toastr.error(verifyData.message || 'Payment verification failed', 'Error');
                        }
                    } catch (error) {
                        console.error('Verification error:', error);
                        toastr.error(error.message || 'Payment verification failed', 'Error');
                    }
                },
                prefill: {
                    name: '{{ Auth::user()->name ?? "" }}',
                    email: '{{ Auth::user()->email ?? "" }}'
                },
                theme: {
                    color: '#4f46e5'
                },
                method: {
                    upi: true,
                    card: true,
                    netbanking: true,
                    wallet: true
                }
            };
            
            const razorpay = new Razorpay(options);
            razorpay.on('payment.failed', function(response) {
                toastr.error('Payment failed: ' + (response.error.description || 'Unknown error'), 'Payment Failed');
            });
            razorpay.open();
            
        } catch (error) {
            console.error('Payment error:', error);
            toastr.error('Payment initialization failed: ' + error.message, 'Error');
        }
    }
    async function subscribeToAlerts(city) {
        @guest
            window.location.href = '{{ route("login") }}';
            return;
        @endguest

        const btn = document.getElementById('notify-btn');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Subscribing...';

        try {
            const response = await fetch('{{ route("city-alerts.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ city })
            });

            const data = await response.json();
            if (data.success) {
                toastr.success(data.message, 'Success');
                btn.innerHTML = '<i class="fas fa-check mr-2"></i>Subscribed';
                btn.classList.replace('bg-indigo-50', 'bg-green-50');
                btn.classList.replace('text-indigo-700', 'text-green-700');
            } else {
                toastr.error(data.message || 'Failed to subscribe', 'Error');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('Something went wrong. Please try again.', 'Error');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }
    }
    </script>

    <!-- Auto-City Detection -->
    <script>
        async function detectLocation(force = false) {
            if (!navigator.geolocation) return;

            // Show loading state in input
            const cityInput = document.getElementById('hero-city-input');
            const originalPlaceholder = cityInput ? cityInput.placeholder : '';
            if (cityInput) cityInput.placeholder = 'Detecting location...';

            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                    const data = await response.json();
                    const city = data.address.city || data.address.town || data.address.village || data.address.suburb || data.address.state_district;
                    
                    if (city) {
                        // Save to session and redirect
                        await fetch(`/set-city?city=${encodeURIComponent(city)}&lat=${lat}&lng=${lng}&verified=true`);
                        window.location.href = window.location.pathname + `?lat=${lat}&lng=${lng}&city=${encodeURIComponent(city)}`;
                    } else if (cityInput) {
                        cityInput.placeholder = originalPlaceholder;
                    }
                } catch (error) {
                    console.error('Location error:', error);
                    if (cityInput) cityInput.placeholder = originalPlaceholder;
                }
            }, (error) => {
                console.warn('Geolocation failed:', error);
                if (cityInput) cityInput.placeholder = 'Location denied. Type city manually.';
            });
        }

        // Run automatically catch-all if no city and NOT search
        @if(!request('city') && !session('location_verified') && !session('no_auto'))
            document.addEventListener('DOMContentLoaded', () => {
                // Don't annoy user with prompt instantly, maybe wait 2 seconds
                setTimeout(() => detectLocation(), 2000);
            });
        @endif
    </script>
@endauth

<script defer>
    document.addEventListener('DOMContentLoaded', () => {
        // Wait for user coordinates before updating
        detectUserLocation((coords) => {
            const tags = document.querySelectorAll('.distance-tag');
            tags.forEach(tag => {
                const roomLat = parseFloat(tag.dataset.lat);
                const roomLng = parseFloat(tag.dataset.lng);
                
                if (roomLat && roomLng) {
                    const dist = calculateDistance(coords.lat, coords.lng, roomLat, roomLng);
                    if (dist) {
                        const kmSpan = tag.querySelector('.distance-km');
                        if (kmSpan) kmSpan.textContent = dist;
                        tag.classList.remove('hidden');
                    }
                }
            });
        });
    });
</script>

<!-- Infinite Scroll Script -->
<script defer>
    // Infinite Scroll for Mobile
    document.addEventListener('DOMContentLoaded', function() {
        const mobileRoomList = document.getElementById('mobile-room-list');
        const loader = document.getElementById('infinite-loader');
        let isLoading = false;
        let hasMore = @json($rooms->hasMorePages());
        let nextPage = @json($rooms->currentPage() + 1);

        if (!mobileRoomList || !loader) return;

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !isLoading && hasMore) {
                loadMoreRooms();
            }
        }, { threshold: 0.1 });

        observer.observe(loader);

        async function loadMoreRooms() {
            isLoading = true;
            loader.classList.remove('hidden');

            try {
                const url = new URL(window.location.href);
                url.searchParams.set('page', nextPage);

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Failed to load rooms');

                const data = await response.json();
                
                if (data.html) {
                    mobileRoomList.insertAdjacentHTML('beforeend', data.html);
                    nextPage++;
                    hasMore = data.hasMore;
                    
                    if (!hasMore) {
                        loader.remove();
                        observer.disconnect();
                    }
                }
            } catch (error) {
                console.error('Error loading more rooms:', error);
            } finally {
                isLoading = false;
                if (hasMore) {
                    loader.classList.add('hidden');
                }
            }
        }
    });
</script>
@endpush
@endsection
