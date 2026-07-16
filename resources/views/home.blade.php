@extends('layouts.app')

@php($homeCity = request('city') ?? session('user_city'))
@section('title', ($homeCity ? 'Verified Rooms & PG in ' . $homeCity : 'Browse Rooms & PG for Rent') . ' | ' . \App\Models\Setting::get('website_name', 'RoomRental'))
@section('description', ($homeCity ? 'Find the best verified rooms, apartments, and PG in ' . $homeCity . '. Browse listings with photos, rents, and owner contacts.' : 'Browse verified room listings in your city. Find apartments, houses, and rooms for rent with verified owners.'))
@section('keywords', ($homeCity ? 'pg in ' . $homeCity . ', room for rent in ' . $homeCity . ', ' : '') . 'browse rooms, room listings, ' . \App\Models\Setting::get('seo_meta_keywords', 'apartment, house, property'))
@section('og_title', ($homeCity ? 'Rooms & PG in ' . $homeCity : 'Browse Rooms') . ' | ' . \App\Models\Setting::get('website_name', 'RoomRental'))
@section('og_description', ($homeCity ? 'Check out available rooms and paying guests in ' . $homeCity : 'Browse verified room listings in your city. Find apartments and rooms for rent.'))
@section('og_url', route('rooms.index', request()->all()))
@section('canonical', route('rooms.index'))

@push('styles')
@include('partials.listings-ld')
<link rel="preload" href="{{ asset('assets/images/hero-bg-desktop.webp') }}" as="image" fetchpriority="high" media="(min-width: 768px)">
<style>
    /* ===== HERO ANIMATIONS ===== */
    @media (max-width: 1023px) {
        .navbar, footer, .hero-mobile { display: none !important; }
        body { padding-bottom: 70px; background-color: #f8fafc; }
    }
    /* Float animation for cards */
    @keyframes floatY {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-10px); }
    }
    @keyframes floatY2 {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-7px); }
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeSlideRight {
        from { opacity: 0; transform: translateX(40px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0 rgba(249,115,22,.4); }
        70%  { box-shadow: 0 0 0 12px rgba(249,115,22,0); }
        100% { box-shadow: 0 0 0 0 rgba(249,115,22,0); }
    }
    .float-card-1 { animation: floatY  3.5s ease-in-out infinite; }
    .float-card-2 { animation: floatY2 4.0s ease-in-out infinite 0.8s; }
    .float-card-3 { animation: floatY  3.2s ease-in-out infinite 1.8s; }
    .hero-left    { animation: fadeSlideUp    0.7s ease both; }
    .hero-right   { animation: fadeSlideRight 0.8s ease 0.2s both; }
    .pulse-orange { animation: pulseRing 2s infinite; }

    /* Gradient mesh background */
    .hero-mesh-bg {
        background: #ffffff;
        background-image:
            radial-gradient(ellipse at 80% 20%, rgba(99,102,241,.07) 0%, transparent 55%),
            radial-gradient(ellipse at 10% 80%, rgba(249,115,22,.06) 0%, transparent 50%);
    }

    /* Stat counter shimmer */
    @keyframes statFadeIn {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .stat-card { animation: statFadeIn 0.6s ease both; }
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    /* Scroll-reveal */
    .reveal { opacity:0; transform:translateY(28px); transition: opacity .6s ease, transform .6s ease; }
    .reveal.in-view { opacity:1; transform:translateY(0); }

    /* Why-card hover lift */
    .why-card { transition: transform .25s ease, box-shadow .25s ease; }
    .why-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px -8px rgba(99,102,241,.18); }

    /* Glass float card */
    .glass-card {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.7);
    }
</style>
@endpush

@section('content')
<!-- Mobile Search (Visible on Mobile Only) -->
<div class="md:hidden relative bg-white">
    @include('partials.mobile-search')
</div>

<!-- ===== DESKTOP HERO ===== -->
<div class="hidden md:block hero-mesh-bg pt-8 pb-16 overflow-hidden relative">
    <!-- Decorative orbs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-indigo-100/30 blur-[120px] pointer-events-none -translate-y-1/4 translate-x-1/4"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-orange-100/40 blur-[100px] pointer-events-none translate-y-1/4 -translate-x-1/4"></div>

    <div class="container mx-auto px-6 relative z-10">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-1.5 text-[11px] font-bold text-slate-400 mb-6">
            <span class="text-indigo-600">Verified Rooms</span>
            <i class="fas fa-chevron-right text-[8px]"></i>
            <span class="text-indigo-600">No-Brokerage</span>
            <i class="fas fa-chevron-right text-[8px]"></i>
            <span>Direct Owner Contact</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start justify-between">

            <!-- ===== LEFT CONTENT ===== -->
            <div class="w-full lg:w-[65%] space-y-6 hero-left">

                <!-- Headline -->
                <h1 class="text-4xl lg:text-[50px] font-black text-slate-900 leading-[1.1] tracking-tight">
                    Find Verified Rooms<br>
                    @if($homeCity)
                        in <span class="text-orange-500 relative">
                            {{ $homeCity }}
                            <svg class="absolute -bottom-1 left-0 w-full" height="5" viewBox="0 0 200 5" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                                <path d="M0 4 Q100 0 200 4" stroke="#f97316" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-500 text-white ml-2 align-middle shadow-md" style="font-size:18px;"><i class="fas fa-check text-sm"></i></span>
                    @else
                        in <span class="text-orange-500 relative">
                            Your City
                            <svg class="absolute -bottom-1 left-0 w-full" height="5" viewBox="0 0 200 5" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                                <path d="M0 4 Q100 0 200 4" stroke="#f97316" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            </svg>
                        </span>
                    @endif
                </h1>

                <p class="text-slate-500 text-sm font-medium max-w-xl leading-relaxed">
                    100% Verified Rooms, PGs &amp; Apartments{{ $homeCity ? ' in ' . $homeCity : '' }}.
                    No Brokerage. Connect Directly with Owners.
                </p>

                <!-- Trust Badge Row -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-3 py-1.5 shadow-sm text-xs font-bold text-slate-700">
                        <div class="w-5 h-5 rounded-md bg-indigo-50 text-indigo-600 flex items-center justify-center text-[9px]"><i class="fas fa-ban"></i></div>
                        No brokerage
                    </div>
                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-3 py-1.5 shadow-sm text-xs font-bold text-slate-700">
                        <div class="w-5 h-5 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center text-[9px]"><i class="fas fa-user-check"></i></div>
                        Owner Verified
                    </div>
                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-3 py-1.5 shadow-sm text-xs font-bold text-slate-700">
                        <div class="w-5 h-5 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center text-[9px]"><i class="fas fa-shield-halved"></i></div>
                        Safe &amp; Secure
                    </div>
                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-3 py-1.5 shadow-sm text-xs font-bold text-slate-700">
                        <div class="w-5 h-5 rounded-md bg-purple-50 text-purple-600 flex items-center justify-center text-[9px]"><i class="fas fa-headset"></i></div>
                        24x7 Support
                    </div>
                </div>

                <!-- Search Card — 5 fields + full-width button -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-lg p-5">
                    <form action="{{ route('rooms.index') }}" method="GET">
                        <!-- Row 1: Fields -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                            <!-- Location -->
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center justify-between">
                                    <span>Location</span>
                                    <button type="button" onclick="detectLocation(true)" class="text-[9px] text-orange-500 hover:text-orange-700 font-bold flex items-center gap-0.5">
                                        <i class="fas fa-location-crosshairs text-[8px]"></i>
                                    </button>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-map-pin absolute left-2.5 top-1/2 -translate-y-1/2 text-orange-400 text-[10px]"></i>
                                    <input type="text" name="city" id="hero-city-input"
                                           value="{{ request('city') ?? session('user_city') }}"
                                           placeholder="{{ $homeCity ?? 'City...' }}"
                                           class="w-full py-2.5 pl-7 pr-2 bg-slate-50 border border-slate-200 text-slate-800 rounded-lg text-xs font-semibold focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 focus:bg-white outline-none transition-all">
                                </div>
                            </div>
                            <!-- Property Type -->
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Property Type</label>
                                <div class="relative">
                                    <i class="fas fa-building absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                                    <select name="room_type" class="w-full py-2.5 pl-7 pr-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-xs font-semibold focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 focus:bg-white outline-none appearance-none transition-all">
                                        <option value="">Any Type</option>
                                        @foreach($roomCategories as $cat)
                                            <option value="{{ $cat->room_type_option_id }}" {{ request('room_type') == $cat->room_type_option_id ? 'selected' : '' }}>{{ $cat->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Budget -->
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Budget</label>
                                <div class="flex items-center gap-1">
                                    <input type="number" name="min_rent" value="{{ request('min_rent') }}" placeholder="₹ Min"
                                           class="w-full py-2.5 px-2 bg-slate-50 border border-slate-200 text-slate-800 rounded-lg text-[10px] font-semibold focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 focus:bg-white outline-none transition-all">
                                    <span class="text-slate-300 font-bold">–</span>
                                    <input type="number" name="max_rent" value="{{ request('max_rent') }}" placeholder="Max"
                                           class="w-full py-2.5 px-2 bg-slate-50 border border-slate-200 text-slate-800 rounded-lg text-[10px] font-semibold focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 focus:bg-white outline-none transition-all">
                                </div>
                            </div>
                            <!-- Preferred Tenant -->
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Preferred Tenant</label>
                                <div class="relative">
                                    <i class="fas fa-users absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                                    <select name="tenant_type" class="w-full py-2.5 pl-7 pr-2 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-xs font-semibold focus:ring-2 focus:ring-orange-400/20 focus:border-orange-400 focus:bg-white outline-none appearance-none transition-all">
                                        <option value="">Any</option>
                                        @foreach(\App\Models\RoomOption::optionsFor('tenant_type') as $option)
                                            <option value="{{ $option->id }}" {{ (string) request('tenant_type') === (string) $option->id ? 'selected' : '' }}>{{ $option->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Row 2: Full-width Search Button -->
                        <button type="submit" id="hero-search-btn"
                                class="w-full py-3 bg-orange-500 hover:bg-orange-600 active:scale-[0.99] text-white font-extrabold rounded-xl shadow-lg shadow-orange-400/30 transition-all flex items-center justify-center gap-2 text-sm pulse-orange">
                            <i class="fas fa-search"></i> Search Rooms
                        </button>

                        <!-- Popular Tags -->
                        <div class="flex items-center gap-2 mt-3 flex-wrap border-t border-slate-100 pt-3">
                            <span class="font-extrabold text-slate-400 uppercase tracking-wider text-[9px]">Popular:</span>
                            @foreach(\App\Models\RoomOption::optionsFor('room_type')->take(4) as $option)
                                <a href="{{ route('rooms.index', ['room_type' => [$option->id]]) }}" class="bg-slate-100 hover:bg-orange-50 hover:text-orange-600 text-slate-600 font-semibold px-2.5 py-0.5 rounded-full text-[10px] transition-all">{{ $option->label }}</a>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== RIGHT — Hero Room Card ===== -->
            <div class="w-full lg:w-[32%] hero-right">
                @if($heroRoom)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
                    <!-- Room Photo -->
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $heroRoom->photo_url }}" alt="{{ $heroRoom->title }}"
                             class="w-full h-full object-cover" loading="eager">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                        @if($heroRoom->is_featured)
                        <div class="absolute top-3 left-3 bg-orange-500 text-white text-[9px] font-extrabold px-2 py-1 rounded-lg flex items-center gap-1">
                            <i class="fas fa-bolt text-[8px]"></i> Featured
                        </div>
                        @endif
                        <div class="absolute bottom-3 left-3">
                            <span class="block text-white font-black text-xl">₹{{ number_format($heroRoom->rent) }}<span class="text-slate-300 text-xs font-medium">/month</span></span>
                        </div>
                        <div class="absolute top-3 right-3 bg-emerald-500 text-white text-[9px] font-extrabold px-2 py-0.5 rounded-full">
                            <i class="fas fa-circle-check text-[8px] mr-0.5"></i> Verified
                        </div>
                    </div>
                    <!-- Card info -->
                    <div class="p-4">
                        <p class="font-bold text-slate-900 text-sm line-clamp-1">{{ $heroRoom->title }}</p>
                        <p class="text-slate-500 text-xs mt-1 flex items-center gap-1">
                            <i class="fas fa-map-pin text-orange-500 text-[10px]"></i>
                            {{ $heroRoom->city }}{{ $heroRoom->address ? ', '.$heroRoom->address : '' }}
                        </p>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex text-amber-400 text-xs gap-0.5">
                                @for($i=0;$i<5;$i++)<i class="fas fa-star"></i>@endfor
                                <span class="text-slate-500 text-[10px] ml-1 font-bold">4.8</span>
                            </div>
                            <a href="{{ route('rooms.show', $heroRoom->slug) }}"
                               class="text-xs bg-orange-500 hover:bg-orange-600 text-white font-bold px-3 py-1.5 rounded-lg transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <!-- Fallback card if no rooms -->
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-8 text-white text-center shadow-xl">
                    <i class="fas fa-home text-5xl text-indigo-300 mb-4 block"></i>
                    <p class="font-bold text-lg">Find Your Perfect Room</p>
                    <p class="text-indigo-300 text-sm mt-2">Browse verified listings near you</p>
                    <a href="{{ route('rooms.index') }}" class="mt-4 inline-block bg-white text-indigo-700 font-bold px-5 py-2 rounded-xl text-sm hover:bg-indigo-50 transition-all">Browse Rooms</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- ===== WHY CHOOSE APNANEST ===== -->
<section class="bg-[#f8fafc] py-16 reveal">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-3xl font-black text-slate-900 font-heading">Why Choose <span class="text-indigo-600">ApnaNest?</span></h2>
            <p class="text-slate-500 text-sm font-medium mt-2">We ensure a safe, secure, and hassle-free renting experience.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="why-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-indigo-200">
                    <i class="fas fa-circle-check"></i>
                </div>
                <h3 class="font-bold text-base text-slate-900">Verified Listings</h3>
                <p class="text-slate-500 text-xs mt-2 leading-relaxed">All rooms and properties are physically verified for authenticity.</p>
            </div>
            <div class="why-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-orange-200">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="font-bold text-base text-slate-900">Zero Brokerage</h3>
                <p class="text-slate-500 text-xs mt-2 leading-relaxed">Direct connection with owners. No hidden charges or end-to-commission fees.</p>
            </div>
            <div class="why-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-emerald-200">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h3 class="font-bold text-base text-slate-900">Secure Payments</h3>
                <p class="text-slate-500 text-xs mt-2 leading-relaxed">Safe rent transactions and refunds via our secure payment system.</p>
            </div>
            <div class="why-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-purple-200">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="font-bold text-base text-slate-900">24×7 Support</h3>
                <p class="text-slate-500 text-xs mt-2 leading-relaxed">Dedicated support agents to assist you throughout your rental journey.</p>
            </div>
        </div>
    </div>
</section>



<!-- Browse by Category -->
<section class="bg-white py-16 reveal">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto">
            <div>
                <div class="mb-6">
                    <h2 class="text-2xl font-black text-slate-900">Browse by Category</h2>
                    <p class="text-slate-500 text-sm font-medium mt-1">Explore different types of rental options available near you.</p>
                </div>
                <?php if($roomCategories->count() > 0): ?>
                <?php
                    $catPalette = ['indigo', 'orange', 'emerald', 'purple', 'pink', 'amber', 'blue', 'cyan', 'teal', 'rose'];
                ?>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <?php foreach($roomCategories->take(8) as $index => $cat): ?>
                        <?php
                            $color = $catPalette[$index % count($catPalette)];
                        ?>
                        <a href="<?php echo route('rooms.index', ['room_type' => [$cat->room_type_option_id]]); ?>"
                           class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-col items-center justify-center text-center hover:border-indigo-500 hover:shadow-md hover:-translate-y-1 transition-all shadow-sm group">
                            <div class="w-11 h-11 bg-<?php echo $color; ?>-50 text-<?php echo $color; ?>-600 rounded-xl flex items-center justify-center text-lg mb-2 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <i class="<?php echo $cat->icon; ?>"></i>
                            </div>
                            <span class="block text-slate-900 font-bold text-xs leading-tight mb-0.5"><?php echo $cat->label; ?></span>
                            <span class="block text-[10px] text-slate-400 font-semibold"><?php echo number_format($cat->total); ?> Listings</span>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4">
                    <a href="{{ route('rooms.index') }}" class="text-indigo-600 hover:text-indigo-700 font-bold text-sm flex items-center gap-1">
                        View All Categories <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <?php else: ?>
                <div class="text-center py-12 text-slate-400 text-sm">
                    <i class="fas fa-layer-group text-3xl mb-3 block"></i>
                    <p class="font-medium">No categories available yet.</p>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<!-- Latest Verified Rooms Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black text-slate-900 font-heading">Latest Verified Rooms</h2>
                <p class="text-slate-500 text-sm font-medium mt-1">Handpicked verified listings just for you.</p>
            </div>
            
            <a href="{{ route('rooms.index') }}" class="text-indigo-600 hover:text-indigo-700 font-bold text-sm flex items-center gap-1 mt-4 md:mt-0">
                View All Rooms <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        
        <?php if($rooms->count() > 0): ?>
            @include('rooms.partials.listing-mobile', ['homePage' => true])
            @include('rooms.partials.listing-desktop', ['homePage' => true])
        <?php else: ?>
            <!-- Empty state fallback -->
            <div class="text-center py-12 bg-slate-50 border border-slate-200/60 rounded-2xl">
                <i class="fas fa-house-chimney text-4xl text-slate-300 mb-2"></i>
                <h3 class="font-bold text-slate-700 text-sm">No Listings Available</h3>
                <p class="text-slate-500 text-xs mt-1">Check back later or change your filters.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Trust & Info Ribbon -->
<div class="bg-[#0b0f19] text-white py-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <div class="flex items-center gap-3 bg-white/5 rounded-2xl px-4 py-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <span class="block font-bold text-sm text-white leading-tight">Available Today</span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">Move in hassle free</span>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/5 rounded-2xl px-4 py-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <span class="block font-bold text-sm text-white leading-tight">Instant Bookings</span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">Quick & easy process</span>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/5 rounded-2xl px-4 py-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <span class="block font-bold text-sm text-white leading-tight">Easy Documentation</span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">Minimal paperwork</span>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/5 rounded-2xl px-4 py-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <div>
                    <span class="block font-bold text-sm text-white leading-tight">100% Verified</span>
                    <span class="block text-[10px] text-slate-400 mt-0.5">Trusted & genuine listings</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Multi-Section Grid: How it Works, Testimonials, App Download -->
<section class="bg-white py-16 border-b border-slate-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- 1. How It Works (Col span 4) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-xl font-black text-slate-900 font-heading">How It Works?</h3>
                    <p class="text-slate-500 text-xs font-semibold mt-1">3 simple steps to find your perfect home.</p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm flex-shrink-0">1</div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">Search</h4>
                            <p class="text-slate-500 text-xs mt-1 leading-relaxed">Find rooms by location, budget & preference.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center font-bold text-sm flex-shrink-0">2</div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">Connect</h4>
                            <p class="text-slate-500 text-xs mt-1 leading-relaxed">Contact with owner and visit the property.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold text-sm flex-shrink-0">3</div>
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">Book</h4>
                            <p class="text-slate-500 text-xs mt-1 leading-relaxed">Complete documentation and move in.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 2. Testimonials (Col span 5) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-xl font-black text-slate-900 font-heading">What Our Users Say</h3>
                    <p class="text-slate-500 text-xs font-semibold mt-1">Trusted by thousands of happy tenants.</p>
                </div>
                
                <div class="space-y-4">
                    <!-- Review 1 -->
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex flex-col gap-2">
                        <div class="flex text-amber-400 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-slate-600 text-xs italic">"Found my perfect room in Bhopal within 2 days. Direct owner contact and zero brokerage. Great experience!"</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 font-bold flex items-center justify-center text-xs">R</div>
                            <div>
                                <span class="block text-slate-800 font-bold text-xs">Rahul Sharma</span>
                                <span class="block text-[9px] text-slate-500">Student</span>
                            </div>
                        </div>
                    </div>
                    <!-- Review 2 -->
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex flex-col gap-2">
                        <div class="flex text-amber-400 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-slate-600 text-xs italic">"Very easy to use platform. Listings are truly verified. Finding PG was never this hassle-free!"</p>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 font-bold flex items-center justify-center text-xs">N</div>
                            <div>
                                <span class="block text-slate-800 font-bold text-xs">Neha Verma</span>
                                <span class="block text-[9px] text-slate-500">Working Professional</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 3. App Download (Col span 3) -->
            <div class="lg:col-span-3 space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-xl font-black text-slate-900 font-heading">Download Our App</h3>
                    <p class="text-slate-500 text-xs font-semibold mt-1">Find stays on the go with mobile app.</p>
                </div>
                
                <div class="bg-slate-50 border border-slate-150 rounded-2xl p-5 flex flex-col items-center justify-center gap-4 text-center">
                    <!-- Simulated QR Code SVG -->
                    <div class="w-28 h-28 bg-white border border-slate-200 rounded-xl p-2 shadow-sm flex items-center justify-center">
                        <i class="fas fa-qrcode text-6xl text-slate-800"></i>
                    </div>
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-widest leading-none">Scan to Download</span>
                    
                    <div class="flex flex-col gap-2 w-full">
                        <a href="#" class="bg-black text-white hover:bg-slate-900 px-4 py-2 rounded-xl flex items-center justify-center gap-2.5 shadow-sm transition-colors text-xs font-bold w-full">
                            <i class="fab fa-apple text-base"></i>
                            <div class="text-left leading-tight">
                                <span class="block text-[8px] font-medium text-slate-400">Download on</span>
                                <span class="block text-xs font-black">App Store</span>
                            </div>
                        </a>
                        <a href="#" class="bg-black text-white hover:bg-slate-900 px-4 py-2 rounded-xl flex items-center justify-center gap-2.5 shadow-sm transition-colors text-xs font-bold w-full">
                            <i class="fab fa-google-play text-base text-emerald-400"></i>
                            <div class="text-left leading-tight">
                                <span class="block text-[8px] font-medium text-slate-400">Get it on</span>
                                <span class="block text-xs font-black">Google Play</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Own a Property CTA Banner -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6">
        <div class="bg-[#0b0f19] rounded-[32px] overflow-hidden relative border border-slate-900 shadow-xl flex flex-col lg:flex-row items-center justify-between p-8 lg:p-12 gap-8">
            <!-- Background lights inside block -->
            <div class="absolute -top-32 -left-32 w-80 h-80 bg-indigo-600/10 rounded-full blur-[100px] pointer-events-none"></div>
            
            <div class="space-y-4 max-w-2xl relative z-10">
                <h3 class="text-2xl lg:text-3xl font-black text-white font-heading">Own a Property?</h3>
                <p class="text-slate-400 text-sm font-medium">List it on ApnaNest and find verified tenants without paying any brokerage fee.</p>
                <div class="grid grid-cols-2 gap-3 text-xs font-bold text-slate-300">
                    <span class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> 100% Free Listing</span>
                    <span class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Zero Brokerage</span>
                    <span class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Verified Tenants</span>
                    <span class="flex items-center gap-2"><i class="fas fa-check text-emerald-500"></i> Quick Payments</span>
                </div>
            </div>
            
            <div class="relative z-10 flex-shrink-0">
                <a href="{{ route('register') }}?role=owner" class="px-6 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-extrabold rounded-xl shadow-lg shadow-orange-500/25 transition-all text-sm flex items-center gap-2 hover:-translate-y-0.5">
                    List Your Property Free <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Blog and FAQs Section -->
<section class="bg-[#f8fafc] py-16">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Side: Latest from Blog (Col span 7) -->
            <div class="lg:col-span-7 space-y-6">
                <div class="flex items-end justify-between border-b border-slate-200/80 pb-4">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 font-heading">Latest from Blog</h3>
                        <p class="text-slate-500 text-xs font-semibold mt-1">Tips, guides, and room insights.</p>
                    </div>
                    <a href="{{ route('blogs.index') }}" class="text-indigo-600 hover:text-indigo-700 font-bold text-xs flex items-center gap-0.5">
                        View All Blogs <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @if(isset($latestBlogs) && $latestBlogs->count() > 0)
                        @foreach($latestBlogs as $blog)
                            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                                <div class="h-28 bg-slate-100 relative">
                                    <img src="{{ $blog->featured_image ?? 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=300&h=200&fit=crop&q=80' }}" 
                                         alt="{{ $blog->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-3.5 flex flex-col flex-grow">
                                    <span class="text-[9px] bg-indigo-50 text-indigo-600 font-extrabold uppercase px-2 py-0.5 rounded-full inline-block self-start mb-2">Guide</span>
                                    <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-tight mb-2 hover:text-indigo-600"><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a></h4>
                                    <div class="flex items-center justify-between text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-auto">
                                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                        <span>5 min read</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Mock data Fallback in case of no database posts -->
                        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col">
                            <div class="h-28 bg-slate-100 relative">
                                <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=300&h=200&fit=crop&q=80" alt="Blog stay guide" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3.5 flex flex-col flex-grow">
                                <span class="text-[9px] bg-indigo-50 text-indigo-600 font-extrabold uppercase px-2 py-0.5 rounded-full inline-block self-start mb-2">Rental Guide</span>
                                <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-tight mb-2">How to Rent a Room Safely in India</h4>
                                <div class="flex items-center justify-between text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-auto">
                                    <span>May 20, 2026</span>
                                    <span>5 min read</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col">
                            <div class="h-28 bg-slate-100 relative">
                                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=300&h=200&fit=crop&q=80" alt="PG locations" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3.5 flex flex-col flex-grow">
                                <span class="text-[9px] bg-indigo-50 text-indigo-600 font-extrabold uppercase px-2 py-0.5 rounded-full inline-block self-start mb-2">PG Guide</span>
                                <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-tight mb-2">Top PG Areas in Bhopal for Students</h4>
                                <div class="flex items-center justify-between text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-auto">
                                    <span>May 18, 2026</span>
                                    <span>6 min read</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col">
                            <div class="h-28 bg-slate-100 relative">
                                <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=300&h=200&fit=crop&q=80" alt="Move tips" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3.5 flex flex-col flex-grow">
                                <span class="text-[9px] bg-indigo-50 text-indigo-600 font-extrabold uppercase px-2 py-0.5 rounded-full inline-block self-start mb-2">Tips</span>
                                <h4 class="font-bold text-slate-900 text-xs line-clamp-2 leading-tight mb-2">Checklist For Moving Into a New Room</h4>
                                <div class="flex items-center justify-between text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-auto">
                                    <span>May 15, 2026</span>
                                    <span>4 min read</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Right Side: Frequently Asked Questions (Col span 5) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="border-b border-slate-200/80 pb-4">
                    <h3 class="text-2xl font-black text-slate-900 font-heading">Frequently Asked Questions</h3>
                    <p class="text-slate-500 text-xs font-semibold mt-1">Quick answers to common queries.</p>
                </div>
                
                <div class="space-y-3">
                    <?php
                        $faqs = [
                            ['q' => 'How do I book a room?', 'a' => 'Search for your preferred room by location and filters. Once you find a suitable listing, click "View Details", verify the info, and click on "Book Room" or unlock details to connect directly with the owner.'],
                            ['q' => 'Is there any brokerage charge?', 'a' => 'No! ApnaNest connects owners and tenants directly. There are no brokerage charges or hidden fees involved.'],
                            ['q' => 'How can I contact the owner?', 'a' => 'You can view the owner\'s verified contact details after unlocking the contact section on the stay details page.'],
                            ['q' => 'Is my payment information secure?', 'a' => 'Yes, absolutely. All payments on ApnaNest are processed via Razorpay secure gateways. We do not store any card or credential details.'],
                            ['q' => 'Can I visit the property before booking?', 'a' => 'Yes, we recommend contacting the owner using their unlocked contact details to schedule a physical visit before confirming your stay.']
                        ];
                    ?>
                    @foreach($faqs as $i => $faq)
                        <div class="bg-white border border-slate-200/85 rounded-xl overflow-hidden shadow-sm faq-item">
                            <button onclick="toggleFaqAccordion({{ $i }})" class="w-full text-left p-4 font-bold text-slate-800 text-xs md:text-sm flex justify-between items-center hover:bg-slate-50/50 transition-colors">
                                <span>{{ $faq['q'] }}</span>
                                <span class="faq-icon-{{ $i }} transition-transform"><i class="fas fa-plus text-slate-400"></i></span>
                            </button>
                            <div class="faq-content-{{ $i }} hidden px-4 pb-4 text-xs text-slate-500 leading-relaxed border-t border-slate-100 pt-3">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stay Updated Newsletter Section -->
<section class="bg-[#f8fafc] pb-16 reveal">
    <div class="container mx-auto px-6">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl border border-indigo-100">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h3 class="font-black text-slate-900 text-base md:text-lg">Stay Updated</h3>
                    <p class="text-slate-500 text-xs md:text-sm font-medium">Subscribe to get updates on new rooms and offers.</p>
                </div>
            </div>
            <div class="w-full md:w-auto flex-1 max-w-md">
                <form action="#" method="POST" class="flex gap-2" onsubmit="event.preventDefault(); toastr.success('Thank you for subscribing!', 'Success');">
                    <input type="email" required placeholder="Enter your email address"
                           class="flex-1 py-3 px-4 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-extrabold rounded-xl shadow-md transition-all text-xs whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Accordion Toggle JavaScript -->
<script>
    function toggleFaqAccordion(index) {
        const content = document.querySelector(`.faq-content-${index}`);
        const icon = document.querySelector(`.faq-icon-${index}`);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(45deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>

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
            confirmButtonColor: ROOM_PRIMARY_COLOR,
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
            confirmButtonColor: ROOM_SECONDARY_COLOR,
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
                    color: ROOM_PRIMARY_COLOR
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
@endauth

    <!-- Auto-City Detection -->
    <script>
    const ROOM_PRIMARY_COLOR = '{{ \App\Models\Setting::get("primary_color", "#4F46E5") }}';
    const ROOM_SECONDARY_COLOR = '{{ \App\Models\Setting::get("secondary_color", "#10B981") }}';
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
                        if (cityInput) {
                            cityInput.value = city;
                            cityInput.placeholder = originalPlaceholder;
                        }
                        // Save to session and redirect
                        await fetch(`{{ route('set-city') }}?city=${encodeURIComponent(city)}&lat=${lat}&lng=${lng}&verified=true`);
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
        @if(!request('city') && !session('user_city') && !session('no_auto'))
            document.addEventListener('DOMContentLoaded', () => {
                // Don't annoy user with prompt instantly, maybe wait 2 seconds
                setTimeout(() => detectLocation(), 2000);
            });
        @endif
    </script>

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
<script>
    // ===== SCROLL-REVEAL =====
    (function () {
        const revealEls = document.querySelectorAll('.reveal');
        if (!revealEls.length) return;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('in-view');
                    observer.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(el => observer.observe(el));
    })();
</script>
@endpush
@endsection
