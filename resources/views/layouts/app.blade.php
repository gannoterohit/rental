<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4f46e5">
    <meta name="description" content="Find the best rooms for rent in Bhopal, Bangalore, and Indore. Easy booking, verified listings, and great amenities.">
    <meta name="robots" content="index, follow">
    <meta name="format-detection" content="telephone=no">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SEO Meta Tags -->
    <title>@yield('title', \App\Models\Setting::get('website_name', 'RoomRental') . ' - Find Your Perfect Room')</title>
    <meta name="description" content="@yield('description', \App\Models\Setting::get('seo_meta_description', 'Find your perfect room in your city. Browse verified room listings.'))">
    <meta name="keywords" content="@yield('keywords', \App\Models\Setting::get('seo_meta_keywords', 'room rental, apartment, house, property'))">
    <meta name="author" content="{{ \App\Models\Setting::get('website_name', 'RoomRental') }}">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#6366f1">
    
    
    <!-- Favicon -->
    @php
        $favicon = \App\Models\Setting::get('website_favicon');
    @endphp
    @if($favicon && file_exists(public_path('storage/' . $favicon)))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
        <link rel="shortcut icon" href="{{ asset('storage/' . $favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    @include('partials.seo')
    @if(Route::currentRouteName() === 'home')
        @include('partials.home-ld')
    @endif
    
    <!-- Google Ads & Analytics (Production Only) -->
    @if(app()->environment('production'))
        @php
            $gaEnabled = \App\Models\Setting::get('google_ads_enabled') == '1';
            $ga4Id = \App\Models\Setting::get('ga4_measurement_id');
            $adsId = \App\Models\Setting::get('google_ads_tag_id');
            
            $adsenseEnabled = \App\Models\Setting::get('adsense_enabled') == '1';
            $adsenseId = \App\Models\Setting::get('adsense_client_id');
        @endphp

        {{-- Google Analytics & Ads --}}
        @if($ga4Id || ($gaEnabled && $adsId))
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id ?: $adsId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                // GA4 Config (Always load if ID exists)
                @if($ga4Id)
                gtag('config', '{{ $ga4Id }}');
                @endif

                // Google Ads Config (Load only if enabled)
                @if($gaEnabled && $adsId)
                gtag('config', '{{ $adsId }}');
                @endif

                // Helper function for conversion tracking
                window.trackAdsConversion = function(label, value, currency = 'INR') {
                    @if($gaEnabled && $adsId && \App\Models\Setting::get('google_ads_conversion_label'))
                    gtag('event', 'conversion', {
                        'send_to': '{{ $adsId }}/{{ \App\Models\Setting::get('google_ads_conversion_label') }}',
                        'value': value || 1.0,
                        'currency': currency
                     });
                    @endif
                };
            </script>
        @endif

        {{-- Google AdSense --}}
        @if($adsenseEnabled && $adsenseId)
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsenseId }}" crossorigin="anonymous"></script>
        @endif
    @endif
    
    <!-- Preconnect to external domains - Mobile Optimized -->
    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <!-- Resource Hints for Mobile Performance -->
    <meta http-equiv="x-dns-prefetch-control" content="on">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --accent: #F59E0B;
            --secondary: #10B981;
            --danger: #EF4444;
            --gray-light: #F8FAFC;
            --bg-premium: #F8FAFC;
            --text-main: #1E293B;
            --text-dark: #0F172A;
            --border: #E2E8F0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 12px;
        }
    </style>

    <!-- Anti-Inspection Shield (Only for guests/users in production) -->
    @if(app()->environment('production'))
        @auth
            @if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'owner')
                <script>
                    document.addEventListener('contextmenu', event => event.preventDefault());
                    document.onkeydown = function(e) {
                        if(e.keyCode == 123) return false; // F12
                        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false; 
                        if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false; 
                        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false; 
                        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false; 
                    };
                    setInterval(function() { console.clear(); }, 1000);
                </script>
            @endif
        @else
            <script>
                document.addEventListener('contextmenu', event => event.preventDefault());
                document.onkeydown = function(e) {
                    if(e.keyCode == 123) return false; 
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false; 
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false; 
                    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false; 
                    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false; 
                };
                setInterval(function() { console.clear(); }, 1000);
            </script>
        @endauth
    @endif

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-premium);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    
    <!-- Critical Inline CSS (Prevents FOUC when Tailwind is deferred) - Mobile Optimized -->
    <style>
        :root { --primary: #4f46e5; --secondary: #ec4899; }
        @media (max-width: 1023px) {
            .hero-mobile { background: #4f46e5; min-height: 300px; display: flex; align-items: center; justify-content: center; }
            img[loading="lazy"] { content-visibility: auto; }
        }
        @media (min-width: 1024px) {
            .hero-mobile { display: none !important; }
        }
        .loading-overlay { position: fixed; inset: 0; background: #fff; z-index: 9999; display: flex; align-items: center; justify-content: center; }
        @font-face { font-family: 'Font Awesome 6 Free'; font-display: swap; }
    </style>
    
    <!-- Defer Heavy Assets (Non-blocking) - Mobile Optimized -->
    <link rel="preload" href="{{ asset('assets/css/all.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}"></noscript>
    <script>
        // Load Font Awesome asynchronously for better mobile performance
        (function() {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = '{{ asset('assets/css/all.min.css') }}';
            link.media = 'print';
            link.onload = function() { this.media = 'all'; };
            document.head.appendChild(link);
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}" media="print" onload="this.media='all'">

    <!-- Custom Styles -->
    <style>
        html, body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
        }
        
        footer {
            margin-top: auto;
        }
        /* App-like Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            display: none;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 1000;
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.05);
            padding-bottom: env(safe-area-inset-bottom, 15px);
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #334155; /* Improved contrast from #64748b */
            text-decoration: none;
            font-size: 10px;
            font-weight: 600;
            transition: all 0.2s;
            flex: 1;
        }
        
        .bottom-nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }
        
        .bottom-nav-item.active {
            color: #10b981;
        }
        
        .bottom-nav-item.active i {
            transform: translateY(-2px);
        }

        /* Mobile Header */
        .mobile-app-header {
            position: sticky;
            top: 0;
            z-index: 999;
            background: #fff;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            display: none;
            align-items: center;
            justify-content: space-between;
        }

        @media (max-width: 1023px) {
            body.mobile-app-view {
                padding-bottom: 70px; /* Space for bottom nav */
            }
        }
         
        @media (max-width: 1023px) {
            body.mobile-app-view main {
                padding-top: 0 !important;
            }
        }
        
        @media (max-width: 1023px) {
            .bottom-nav, .mobile-app-header {
                display: flex;
            }
            footer {
                display: none !important;
            }
        }
        
        /* Enhanced mobile app styles */
        .mobile-app-view .app-card {
            margin: 8px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        
        .mobile-app-view .app-btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
        }
        
        .mobile-app-view .app-btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }
    </style>
    

    @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-screen mobile-app-view">
    @include('partials.offer-banner', ['placement' => 'top_nav'])
    
    <!-- Mobile App Header - Enhanced App Style -->
    <div class="mobile-app-header lg:hidden">
        <div class="header-left">
                    <div class="app-icon">
                        <i class="fas fa-home text-white text-xl"></i>
                    </div>
                <div class="header-content">
                <h1 class="text-lg font-bold text-gray-900 leading-none">{{ \App\Models\Setting::get('website_name', 'RoomRental') }}</h1>
                <p class="text-[10px] text-gray-600 font-medium">Find your stay</p>
                </div>
        </div>
        <div class="header-right">
            <button id="mobile-menu-toggle-app"
                    class="menu-toggle"
                    aria-label="Open navigation menu">
                <i class="fas fa-bars text-xl" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile App Menu - Include the new app-style menu -->
    @include('partials.mobile-app-menu')
    
    
    <!-- Compact Desktop Navigation -->
    <nav class="hidden md:block bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-2">
                <a href="{{ route('home') }}" class="flex items-center">
                    @php
                        $logo = \App\Models\Setting::get('website_logo');
                    @endphp
                    @if($logo && file_exists(public_path('storage/' . $logo)))
                        <img src="{{ asset('storage/' . $logo) }}"
                             alt="Logo"
                             class="h-9 w-auto rounded-lg"
                             width="36" height="36">
                    @else
                        <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-lg p-2">
                            <i class="fas fa-home text-base"></i>
                        </div>
                    @endif
                    <!-- <span class="ml-2 text-xl font-bold bg-gradient-to-r from-slate-900 to-emerald-500 bg-clip-text text-transparent">
                        {{ \App\Models\Setting::get('website_name', 'RoomRental') }}
                        </span> -->
                </a>
                
                <div class="flex items-center gap-3">
                    
                     <a href="{{ route('blogs.index') }}"
                        class="text-gray-700 hover:text-emerald-600 font-medium transition-colors duration-200 px-3 py-1.5 text-sm hidden lg:block">
                         Blog
                     </a>

                    @auth
                        @if(Auth::user()->role === 'owner')
                            <a href="{{ route('rooms.create') }}"
                               class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm">
                                <i class="fas fa-plus mr-1 text-xs"></i>List Room
                            </a>
                        @endif
                        
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm">
                                <i class="fas fa-tachometer-alt mr-1 text-xs"></i>Admin
                            </a>
                        @endif
                        
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-gray-700 hover:text-emerald-600 transition-colors duration-200 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div class="bg-gradient-to-r from-slate-900 to-emerald-500 text-white rounded-full p-1">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                @endif
                                <span class="hidden lg:inline text-sm">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg py-1 hidden group-hover:block">
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                    <i class="fas fa-user mr-2 text-primary text-xs"></i>Profile
                                </a>
                                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                    <i class="fas fa-tachometer-alt mr-2 text-primary text-xs"></i>Dashboard
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                    <i class="fas fa-heart mr-2 text-red-500 text-xs"></i>My Wishlist
                                </a>
                                <a href="{{ route('referral.index') }}" class="block px-3 py-2 text-emerald-600 hover:bg-emerald-50 text-sm font-bold">
                                    <i class="fas fa-gift mr-2 text-xs"></i>Refer & Earn
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 text-sm">
                                        <i class="fas fa-sign-out-alt mr-2 text-xs"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-primary font-medium transition-colors duration-200 px-3 py-1.5 text-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-gradient-to-r from-slate-900 to-emerald-500 hover:from-slate-800 hover:to-emerald-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile App Loading Indicator -->
    @include('partials.mobile-loading')
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-3 mx-4 mt-4 md:mt-0 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <div class="bg-green-500 rounded-full p-1.5 mr-2">
                    <i class="fas fa-check-circle text-white text-sm"></i>
                </div>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-3 mx-4 mt-4 md:mt-0 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <div class="bg-red-500 rounded-full p-1.5 mr-2">
                    <i class="fas fa-exclamation-circle text-white text-sm"></i>
                </div>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="pt-16 md:pt-0">
        @yield('content')
    </main>

    <!-- Compact Footer -->
    <!-- Premium Footer -->
    <!-- Clean & Modern Desktop Footer -->
    <!-- Premium Dark Footer -->
    <footer class="relative bg-[#0f172a] text-slate-300 mt-12 hidden lg:block overflow-hidden">
        {{-- Ambient Background Glows --}}
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-slate-900/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-emerald-600/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Pre-footer CTA --}}
            <div class="py-8 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="max-w-2xl text-center md:text-left">
                    <h3 class="text-2xl font-black text-white mb-2 tracking-tight">Ready to list your property?</h3>
                    <p class="text-slate-400 font-medium">Join our verified network of owners and find premium tenants today.</p>
                </div>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('register') }}" class="group relative px-6 py-3 bg-white text-indigo-950 font-bold rounded-xl hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all duration-300 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative flex items-center gap-2">
                            Get Started
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                    <a href="{{ route('pages.contact') }}" class="px-6 py-3 bg-white/5 text-white font-bold rounded-xl border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300 backdrop-blur-sm">
                        Contact Support
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 py-10">
                <!-- Brand Info (Col span 4) -->
                <div class="lg:col-span-4 space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group" aria-label="RoomRental Home">
                        <div class="w-12 h-12 bg-gradient-to-br from-slate-900 to-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-home text-xl" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span class="text-xl font-black text-white tracking-tight block">
                                {{ \App\Models\Setting::get('website_name', 'RoomRental') }}
                            </span>
                            <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Premium Living</span>
                        </div>
                    </a>
                    <p class="text-slate-300 text-sm leading-relaxed font-medium max-w-sm">
                        The ultimate destination for verified room rentals. We connect owners and tenants through a secure platform.
                    </p>
                    <div class="flex gap-3">
                        @php
                            $socialLinks = [
                                'facebook-f' => \App\Models\Setting::get('facebook_url', '#'),
                                'twitter' => \App\Models\Setting::get('twitter_url', '#'),
                                'instagram' => \App\Models\Setting::get('instagram_url', '#'),
                                'linkedin-in' => \App\Models\Setting::get('linkedin_url', '#')
                            ];
                        @endphp
                        @foreach($socialLinks as $icon => $url)
                            <a href="{{ $url }}" aria-label="Visit us on {{ ucfirst(str_replace(['-f', '-in'], '', $icon)) }}" class="w-9 h-9 rounded-lg bg-white/5 text-slate-400 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all duration-300 border border-white/5 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/30" {{ $url != '#' ? 'target="_blank"' : '' }}>
                                <i class="fa-brands fa-{{ $icon }} text-sm" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation (Col span 2) -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-black mb-4 text-sm uppercase tracking-widest border-l-4 border-indigo-500 pl-3">Discover</h4>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="{{ route('rooms.index') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Browse Listings</a></li>
                        <li><a href="{{ route('blogs.index') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Latest Blogs</a></li>
                        <li><a href="{{ route('plans') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Membership Plans</a></li>
                        <li><a href="{{ route('referral.index') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Refer & Earn</a></li>
                    </ul>
                </div>

                <!-- Support (Col span 2) -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-black mb-4 text-sm uppercase tracking-widest border-l-4 border-purple-500 pl-3">Support</h4>
                    <ul class="space-y-2 text-sm font-medium">
                        <li><a href="{{ route('pages.faq') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Help & FAQ</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Terms of Service</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-slate-400 hover:text-white hover:translate-x-1 transition-all inline-block">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Newsletter (Col span 4) -->
                <div class="lg:col-span-4">
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/5 backdrop-blur-sm">
                        <h4 class="text-white font-black mb-1 text-base">Stay Updated</h4>
                        <p class="text-slate-400 text-sm mb-4">Get the latest room additions and exclusive offers.</p>
                        
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl blur opacity-20 group-hover:opacity-40 transition-opacity"></div>
                                <div class="relative flex bg-[#0f172a] border border-white/10 rounded-xl overflow-hidden focus-within:border-emerald-500/50 transition-colors">
                                    <input type="email" name="email" required placeholder="Enter your email"
                                           class="w-full bg-transparent text-white px-4 py-3 text-sm focus:outline-none placeholder-slate-400" aria-label="Email Address">
                                    <button type="submit" aria-label="Subscribe to Newsletter" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 font-bold transition-colors">
                                        <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="pt-4 mt-4 border-t border-white/5 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-slate-400 block mb-1">Owner Support</span>
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+919340058914') }}" class="text-white font-black text-base hover:text-indigo-400 transition-colors">{{ \App\Models\Setting::get('contact_phone', '+91 9340058914') }}</a>
                            </div>
                            <div class="w-9 h-9 bg-emerald-500/20 rounded-full flex items-center justify-center text-emerald-400 animate-pulse-slow">
                                <i class="fas fa-headset" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="py-5 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-400 font-bold">
                    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('website_name', 'RoomRental') }}. All rights reserved.
                </p>
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-2 text-xs font-bold text-slate-400 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
                        <i class="fas fa-shield-alt text-emerald-400" aria-hidden="true"></i> Secure Payment
                    </span>
                    <span class="flex items-center gap-2 text-xs font-bold text-slate-400 bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
                        <i class="fas fa-check-circle text-sky-400" aria-hidden="true"></i> Verified Listings
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- App Bottom Navigation - Enhanced Design -->
    <!-- App Bottom Navigation -->
    @include('partials.mobile-bottom-nav')


    <!-- Google Ads Conversion Tracking (Fire after successful payment) -->
    @if(session('google_ads_conversion') && app()->environment('production') && \App\Models\Setting::get('google_ads_enabled') == '1')
        @php
            $conv = session('google_ads_conversion');
            $convLabel = \App\Models\Setting::get('google_ads_conversion_label');
            $adsId = \App\Models\Setting::get('google_ads_tag_id');
        @endphp
        @if($adsId && $convLabel && isset($conv['amount']))
        <script>
            if (typeof trackAdsConversion === 'function') {
                trackAdsConversion('{{ $convLabel }}', {{ $conv['amount'] }}, 'INR');
            } else if (typeof gtag !== 'undefined') {
                gtag('event', 'conversion', {
                    'send_to': '{{ $adsId }}/{{ $convLabel }}',
                    'value': {{ $conv['amount'] }},
                    'currency': 'INR'
                });
            }
        </script>
        @endif
        {{ session()->forget('google_ads_conversion') }}
    @endif

    <!-- Scripts Loaded in Footer for Performance -->
    @stack('sweetalert') {{-- Only load SweetAlert2 when needed --}}
    <script defer>
        // Suppress console warnings from third-party libraries (Tailwind, Google Maps)
        const originalConsoleWarn = console.warn;
        console.warn = function (message) {
            if (typeof message === 'string' && (
                message.includes('cdn.tailwindcss.com should not be used in production') ||
                message.includes('google.maps.places.Autocomplete is not available to new customers') ||
                message.includes('google.maps.Marker is deprecated')
            )) {
                return;
            }
            originalConsoleWarn.apply(console, arguments);
        };

        // Global Utility for Distance Calculation (Haversine Formula)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            if (!lat1 || !lon1 || !lat2 || !lon2) return null;
            const R = 6371; // Radius of the earth in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return (R * c).toFixed(1);
        }

        // Global User Location Tracking
        let userCoords = null;
        function detectUserLocation(callback) {
            if (sessionStorage.getItem('user_lat') && sessionStorage.getItem('user_lng')) {
                userCoords = {
                    lat: parseFloat(sessionStorage.getItem('user_lat')),
                    lng: parseFloat(sessionStorage.getItem('user_lng'))
                };
                if (callback) callback(userCoords);
                return;
            }

            const isSecure = window.location.protocol === 'https:' || window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

            if (navigator.geolocation && isSecure) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userCoords = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        sessionStorage.setItem('user_lat', userCoords.lat);
                        sessionStorage.setItem('user_lng', userCoords.lng);

                        if (callback) callback(userCoords);
                    },
                    (error) => {
                        getLocationByIP(callback);
                    },
                    { enableHighAccuracy: true, timeout: 6000, maximumAge: 0 }
                );
            } else {
                getLocationByIP(callback);
            }
        }

        function getLocationByIP(callback) {
            fetch('https://ipapi.co/json/')
                .then(res => res.json())
                .then(data => {
                    if (data.latitude && data.longitude) {
                        userCoords = { lat: data.latitude, lng: data.longitude };
                        sessionStorage.setItem('user_lat', userCoords.lat);
                        sessionStorage.setItem('user_lng', userCoords.lng);

                        if (callback) callback(userCoords);
                    }
                })
                .catch(err => {
                    fetch('http://ip-api.com/json/')
                        .then(res => res.json())
                        .then(data => {
                            if (data.lat && data.lon) {
                                userCoords = { lat: data.lat, lng: data.lon };
                                sessionStorage.setItem('user_lat', userCoords.lat);
                                sessionStorage.setItem('user_lng', userCoords.lng);
                                if (callback) callback(userCoords);
                            }
                        });
                });
        }

        // Global Razorpay Loader
        window.loadRazorpaySDK = function() {
            return new Promise((resolve, reject) => {
                if (window.Razorpay) {
                    resolve(window.Razorpay);
                    return;
                }
                const script = document.createElement('script');
                script.src = 'https://checkout.razorpay.com/v1/checkout.js';
                script.async = true;
                script.onload = () => resolve(window.Razorpay);
                script.onerror = () => reject(new Error('Razorpay SDK failed to load'));
                document.body.appendChild(script);
            });
        };

        document.addEventListener('DOMContentLoaded', () => detectUserLocation());
    </script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    @stack('scripts')
    @include('partials.offer-banner', ['placement' => 'popup'])
    {{-- Google Ads Signup Conversion --}}
    @if(session('signup_success') && app()->environment('production') && \App\Models\Setting::get('google_ads_enabled') == '1')
        @php
            $signupLabel = \App\Models\Setting::get('google_ads_signup_label');
        @endphp
        @if($signupLabel)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof trackAdsConversion === 'function') {
                        trackAdsConversion('{{ $signupLabel }}', 0, 'INR');
                    }
                });
            </script>
        @endif
        {{ session()->forget('signup_success') }}
    @endif
</body>
</html>