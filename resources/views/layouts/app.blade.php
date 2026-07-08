<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="{{ \App\Models\Setting::get('primary_color', '#4F46E5') }}">
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
    <meta name="theme-color" content="{{ \App\Models\Setting::get('primary_color', '#4F46E5') }}">
    
    
    <!-- Favicon -->
    @php
        $favicon = \App\Models\Setting::get('website_favicon');
    @endphp
    @if($favicon)
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
            --primary: {{ \App\Models\Setting::get('primary_color', '#4F46E5') }};
            --primary-dark: {{ \App\Models\Setting::get('primary_color', '#4F46E5') }};
            --accent: #F59E0B;
            --secondary: {{ \App\Models\Setting::get('secondary_color', '#10B981') }};
            --danger: #EF4444;
            --primary-rgb: {{ implode(',', sscanf(ltrim(\App\Models\Setting::get('primary_color', '#4F46E5'), '#'), '%02x%02x%02x')) }};
            --secondary-rgb: {{ implode(',', sscanf(ltrim(\App\Models\Setting::get('secondary_color', '#10B981'), '#'), '%02x%02x%02x')) }};
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
        :root { --primary: {{ \App\Models\Setting::get('primary_color', '#4F46E5') }}; --secondary: {{ \App\Models\Setting::get('secondary_color', '#10B981') }}; }
        @media (max-width: 1023px) {
            .hero-mobile { background: var(--primary); min-height: 300px; display: flex; align-items: center; justify-content: center; }
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
            color: var(--secondary);
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }
    </style>

    <style>
        .dynamic-theme-override .bg-indigo-600 { background-color: var(--primary) !important; }
        .dynamic-theme-override .bg-indigo-500 { background-color: var(--primary) !important; }
        .dynamic-theme-override .bg-indigo-700 { background-color: rgba(var(--primary-rgb), 0.9) !important; }
        .dynamic-theme-override .bg-indigo-400 { background-color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .bg-indigo-100 { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .bg-indigo-50 { background-color: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .bg-indigo-300 { background-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .bg-violet-100 { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .bg-violet-600 { background-color: var(--primary) !important; }
        .dynamic-theme-override .bg-purple-100 { background-color: rgba(var(--secondary-rgb), 0.15) !important; }
        
        .dynamic-theme-override .text-indigo-600 { color: var(--primary) !important; }
        .dynamic-theme-override .text-indigo-500 { color: var(--primary) !important; }
        .dynamic-theme-override .text-indigo-700 { color: var(--primary) !important; }
        .dynamic-theme-override .text-indigo-300 { color: rgba(var(--primary-rgb), 0.6) !important; }
        .dynamic-theme-override .text-indigo-200 { color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .text-indigo-400 { color: rgba(var(--primary-rgb), 0.7) !important; }
        
        .dynamic-theme-override .border-indigo-600 { border-color: var(--primary) !important; }
        .dynamic-theme-override .border-indigo-500 { border-color: var(--primary) !important; }
        .dynamic-theme-override .border-indigo-400 { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .border-indigo-100 { border-color: rgba(var(--primary-rgb), 0.2) !important; }
        .dynamic-theme-override .border-indigo-200 { border-color: rgba(var(--primary-rgb), 0.3) !important; }
        
        .dynamic-theme-override .hover\:bg-indigo-600:hover { background-color: var(--primary) !important; }
        .dynamic-theme-override .hover\:bg-indigo-700:hover { background-color: rgba(var(--primary-rgb), 0.9) !important; }
        .dynamic-theme-override .hover\:text-indigo-600:hover { color: var(--primary) !important; }
        .dynamic-theme-override .hover\:border-indigo-400:hover { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .hover\:border-indigo-600:hover { border-color: var(--primary) !important; }
        .dynamic-theme-override .hover\:bg-indigo-50:hover { background-color: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .hover\:bg-indigo-100:hover { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        
        .dynamic-theme-override .focus\:ring-indigo-500:focus { --tw-ring-color: var(--primary) !important; }
        .dynamic-theme-override .focus\:ring-indigo-400:focus { --tw-ring-color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .ring-indigo-500 { --tw-ring-color: var(--primary) !important; }
        
        .dynamic-theme-override .from-indigo-50 { --tw-gradient-from: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .from-indigo-100 { --tw-gradient-from: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .from-indigo-500 { --tw-gradient-from: var(--primary) !important; }
        .dynamic-theme-override .from-indigo-600 { --tw-gradient-from: var(--primary) !important; }
        .dynamic-theme-override .from-indigo-700 { --tw-gradient-from: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .to-indigo-900 { --tw-gradient-to: rgba(var(--primary-rgb), 0.9) !important; }
        .dynamic-theme-override .from-indigo-950 { --tw-gradient-from: rgba(var(--primary-rgb), 0.95) !important; }
        .dynamic-theme-override .to-purple-950 { --tw-gradient-to: rgba(var(--secondary-rgb), 0.95) !important; }
        
        .dynamic-theme-override .hover\:from-indigo-700:hover { --tw-gradient-from: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .hover\:to-indigo-900:hover { --tw-gradient-to: rgba(var(--primary-rgb), 0.9) !important; }
        
        .dynamic-theme-override .to-indigo-500 { --tw-gradient-to: var(--primary) !important; }
        .dynamic-theme-override .to-indigo-600 { --tw-gradient-to: var(--primary) !important; }
        .dynamic-theme-override .to-indigo-100 { --tw-gradient-to: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .to-indigo-800 { --tw-gradient-to: rgba(var(--primary-rgb), 0.85) !important; }
        
        .dynamic-theme-override .ring-indigo-200 { --tw-ring-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .ring-indigo-500\/20 { --tw-ring-color: rgba(var(--primary-rgb), 0.2) !important; }
        
        .dynamic-theme-override .group-focus-within\:text-indigo-600 { color: var(--primary) !important; }
        .dynamic-theme-override .shadow-indigo-100 { --tw-shadow-color: rgba(var(--primary-rgb), 0.15); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-indigo-100\/50 { --tw-shadow: 0 4px 6px -1px rgba(var(--primary-rgb), 0.1) !important; }
        .dynamic-theme-override .shadow-indigo-500 { --tw-shadow-color: rgba(var(--primary-rgb), 0.2); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-indigo-500\/5 { --tw-shadow-color: rgba(var(--primary-rgb), 0.05); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-indigo-500\/10 { --tw-shadow-color: rgba(var(--primary-rgb), 0.1); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-indigo-500\/20 { --tw-shadow: 0 10px 15px -3px rgba(var(--primary-rgb), 0.2) !important; }
        .dynamic-theme-override .shadow-indigo-600 { --tw-shadow-color: rgba(var(--primary-rgb), 0.3); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-indigo-600\/20 { --tw-shadow: 0 10px 15px -3px rgba(var(--primary-rgb), 0.2) !important; }
        
        .dynamic-theme-override .text-indigo-200 { color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .text-indigo-300 { color: rgba(var(--primary-rgb), 0.6) !important; }
        .dynamic-theme-override .text-indigo-400 { color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .text-indigo-500 { color: var(--primary) !important; }
        .dynamic-theme-override .text-indigo-600 { color: var(--primary) !important; }
        .dynamic-theme-override .text-indigo-700 { color: var(--primary) !important; }
        .dynamic-theme-override .text-indigo-800 { color: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .text-indigo-900 { color: rgba(var(--primary-rgb), 0.8) !important; }
        .dynamic-theme-override .text-primary { color: var(--primary) !important; }
        
        .dynamic-theme-override .bg-indigo-50 { background-color: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .bg-indigo-100 { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .bg-indigo-200 { background-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .bg-indigo-300 { background-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .bg-indigo-400 { background-color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .bg-indigo-500 { background-color: var(--primary) !important; }
        .dynamic-theme-override .bg-indigo-600 { background-color: var(--primary) !important; }
        .dynamic-theme-override .bg-indigo-700 { background-color: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .bg-indigo-800 { background-color: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .bg-indigo-900 { background-color: rgba(var(--primary-rgb), 0.9) !important; }
        
        .dynamic-theme-override .border-indigo-50 { border-color: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .border-indigo-100 { border-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .border-indigo-200 { border-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .border-indigo-300 { border-color: rgba(var(--primary-rgb), 0.4) !important; }
        .dynamic-theme-override .border-indigo-400 { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .border-indigo-500 { border-color: var(--primary) !important; }
        .dynamic-theme-override .border-indigo-600 { border-color: var(--primary) !important; }
        .dynamic-theme-override .border-indigo-700 { border-color: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .border-indigo-800 { border-color: rgba(var(--primary-rgb), 0.85) !important; }
        
        .dynamic-theme-override .hover\:bg-indigo-50:hover { background-color: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .hover\:bg-indigo-100:hover { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .hover\:bg-indigo-600:hover { background-color: var(--primary) !important; }
        .dynamic-theme-override .hover\:bg-indigo-700:hover { background-color: rgba(var(--primary-rgb), 0.85) !important; }
        .dynamic-theme-override .hover\:border-indigo-100:hover { border-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .hover\:border-indigo-200:hover { border-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .hover\:border-indigo-300:hover { border-color: rgba(var(--primary-rgb), 0.4) !important; }
        .dynamic-theme-override .hover\:border-indigo-400:hover { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .hover\:border-indigo-500:hover { border-color: var(--primary) !important; }
        .dynamic-theme-override .hover\:border-indigo-600:hover { border-color: var(--primary) !important; }
        .dynamic-theme-override .hover\:text-indigo-600:hover { color: var(--primary) !important; }
        .dynamic-theme-override .hover\:text-indigo-700:hover { color: var(--primary) !important; }
        
        .dynamic-theme-override .focus\:ring-indigo-500:focus { --tw-ring-color: var(--primary) !important; }
        .dynamic-theme-override .focus\:ring-indigo-500\/10:focus { --tw-ring-color: rgba(var(--primary-rgb), 0.1) !important; }
        .dynamic-theme-override .focus\:ring-indigo-500\/20:focus { --tw-ring-color: rgba(var(--primary-rgb), 0.2) !important; }
        .dynamic-theme-override .focus\:ring-indigo-500\/50:focus { --tw-ring-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .focus\:border-indigo-500:focus { border-color: var(--primary) !important; }
        .dynamic-theme-override .focus\:border-indigo-700:focus { border-color: rgba(var(--primary-rgb), 0.85) !important; }
        
        .dynamic-theme-override .peer-checked\:border-indigo-500\/50 { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .peer-checked\:border-indigo-600 { border-color: var(--primary) !important; }
        .dynamic-theme-override .peer-checked\:border-indigo-600\/30 { border-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .peer-checked\:bg-indigo-50 { background-color: rgba(var(--primary-rgb), 0.08) !important; }
        .dynamic-theme-override .peer-checked\:bg-indigo-600\/20 { background-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .peer-checked\:text-indigo-400 { color: rgba(var(--primary-rgb), 0.7) !important; }
        
        .dynamic-theme-override .group-hover\:text-indigo-600 { color: var(--primary) !important; }
        .dynamic-theme-override .group-hover\:bg-indigo-100 { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .group-hover\:bg-white { background-color: #fff !important; }
        .dynamic-theme-override .group-hover\:text-indigo-300 { color: rgba(var(--primary-rgb), 0.6) !important; }
        .dynamic-theme-override .group-hover\:text-indigo-400 { color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .group-hover\:text-indigo-500 { color: var(--primary) !important; }
        .dynamic-theme-override .group-hover\:text-indigo-700 { color: var(--primary) !important; }
        .dynamic-theme-override .group-active\:scale-95 { --tw-scale-x: .95; --tw-scale-y: .95; transform: translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)) !important; }
        
        .dynamic-theme-override .bg-purple-50 { background-color: rgba(var(--secondary-rgb), 0.08) !important; }
        .dynamic-theme-override .bg-purple-100 { background-color: rgba(var(--secondary-rgb), 0.15) !important; }
        .dynamic-theme-override .bg-purple-600 { background-color: var(--secondary) !important; }
        .dynamic-theme-override .bg-purple-700 { background-color: rgba(var(--secondary-rgb), 0.85) !important; }
        .dynamic-theme-override .text-purple-100 { color: rgba(var(--secondary-rgb), 0.4) !important; }
        .dynamic-theme-override .text-purple-300 { color: rgba(var(--secondary-rgb), 0.6) !important; }
        .dynamic-theme-override .text-purple-400 { color: rgba(var(--secondary-rgb), 0.7) !important; }
        .dynamic-theme-override .text-purple-500 { color: var(--secondary) !important; }
        .dynamic-theme-override .text-purple-600 { color: var(--secondary) !important; }
        .dynamic-theme-override .text-purple-700 { color: var(--secondary) !important; }
        .dynamic-theme-override .border-purple-400 { border-color: rgba(var(--secondary-rgb), 0.5) !important; }
        .dynamic-theme-override .border-purple-500 { border-color: var(--secondary) !important; }
        .dynamic-theme-override .from-purple-500 { --tw-gradient-from: var(--secondary) !important; }
        .dynamic-theme-override .from-purple-600 { --tw-gradient-from: var(--secondary) !important; }
        .dynamic-theme-override .from-purple-700 { --tw-gradient-from: rgba(var(--secondary-rgb), 0.85) !important; }
        .dynamic-theme-override .to-purple-500 { --tw-gradient-to: var(--secondary) !important; }
        .dynamic-theme-override .to-purple-600 { --tw-gradient-to: var(--secondary) !important; }
        .dynamic-theme-override .to-purple-700 { --tw-gradient-to: rgba(var(--secondary-rgb), 0.85) !important; }
        .dynamic-theme-override .to-purple-100 { --tw-gradient-to: rgba(var(--secondary-rgb), 0.15) !important; }
        
        .dynamic-theme-override .shadow-purple-500 { --tw-shadow-color: rgba(var(--secondary-rgb), 0.2); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-purple-500\/10 { --tw-shadow-color: rgba(var(--secondary-rgb), 0.1); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-purple-500\/30 { --tw-shadow-color: rgba(var(--secondary-rgb), 0.3); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-purple-600 { --tw-shadow-color: rgba(var(--secondary-rgb), 0.2); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .shadow-purple-600\/20 { --tw-shadow-color: rgba(var(--secondary-rgb), 0.2); --tw-shadow: var(--tw-shadow-colored) !important; }
        
        .dynamic-theme-override .hover\:bg-purple-100:hover { background-color: rgba(var(--secondary-rgb), 0.15) !important; }
        .dynamic-theme-override .hover\:bg-purple-700:hover { background-color: rgba(var(--secondary-rgb), 0.85) !important; }
        .dynamic-theme-override .hover\:border-purple-400:hover { border-color: rgba(var(--secondary-rgb), 0.5) !important; }
        .dynamic-theme-override .hover\:border-purple-500:hover { border-color: var(--secondary) !important; }
        
        .dynamic-theme-override .ring-pink-500\/50 { --tw-ring-color: rgba(236,72,153,0.5) !important; }
        .dynamic-theme-override .focus\:border-pink-500:focus { border-color: #ec4899 !important; }
        .dynamic-theme-override .focus\:border-purple-500:focus { border-color: var(--secondary) !important; }
        
        .dynamic-theme-override .focus-within\:ring-2:focus-within { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000) !important; }
        .dynamic-theme-override .from-violet-100 { --tw-gradient-from: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .hover\:border-violet-400:hover { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .text-violet-500 { color: var(--primary) !important; }
        .dynamic-theme-override .text-violet-600 { color: var(--primary) !important; }
        
        .dynamic-theme-override .hover\:shadow-indigo-500\/10:hover { --tw-shadow-color: rgba(var(--primary-rgb), 0.1); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .hover\:shadow-indigo-500\/5:hover { --tw-shadow-color: rgba(var(--primary-rgb), 0.05); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .hover\:shadow-indigo-200:hover { --tw-shadow-color: rgba(var(--primary-rgb), 0.2); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .hover\:shadow-purple-500\/10:hover { --tw-shadow-color: rgba(var(--secondary-rgb), 0.1); --tw-shadow: var(--tw-shadow-colored) !important; }
        .dynamic-theme-override .ring-purple-500\/50 { --tw-ring-color: rgba(var(--secondary-rgb), 0.5) !important; }
        
        .dynamic-theme-override .hover\:ring-2:hover { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow, 0 0 #0000) !important; }
        .dynamic-theme-override .peer-checked\:bg-purple-600\/30 { background-color: rgba(var(--secondary-rgb), 0.3) !important; }
        .dynamic-theme-override .peer-checked\:ring-indigo-500\/50 { --tw-ring-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .peer-checked\:ring-purple-500\/50 { --tw-ring-color: rgba(var(--secondary-rgb), 0.5) !important; }
        .dynamic-theme-override .peer-checked\:text-purple-400 { color: var(--primary) !important; }
        .dynamic-theme-override .peer-checked\:text-white { color: #fff !important; }
        .dynamic-theme-override .peer:checked ~ .peer-checked\:border-indigo-500\/50 { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        .dynamic-theme-override .peer:checked ~ .peer-checked\:border-purple-500\/50 { border-color: rgba(var(--secondary-rgb), 0.5) !important; }
        .dynamic-theme-override .peer:checked ~ .peer-checked\:text-indigo-400 { color: var(--primary) !important; }
        
        .dynamic-theme-override .group:hover .group-hover\:text-indigo-700 { color: var(--primary) !important; }
        .dynamic-theme-override .group:hover .group-hover\:bg-indigo-100 { background-color: rgba(var(--primary-rgb), 0.15) !important; }
        .dynamic-theme-override .group:hover .group-hover\:text-indigo-300 { color: rgba(var(--primary-rgb), 0.6) !important; }
        .dynamic-theme-override .group:hover .group-hover\:text-indigo-400 { color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .group:hover .group-hover\:text-indigo-500 { color: var(--primary) !important; }
        .dynamic-theme-override .group:hover .group-hover\:text-indigo-600 { color: var(--primary) !important; }
        .dynamic-theme-override .group:hover .group-hover\:border-indigo-500 { border-color: var(--primary) !important; }
        
        .dynamic-theme-override .group\/btn:hover .group-hover\/btn\:translate-x-1 { --tw-translate-x: .25rem; transform: translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)) !important; }
        .dynamic-theme-override .group\/banner:hover .group-hover\/banner\:scale-105 { --tw-scale-x: 1.05; --tw-scale-y: 1.05; transform: translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)) !important; }
        .dynamic-theme-override .group:hover .group-hover\:scale-105 { --tw-scale-x: 1.05; --tw-scale-y: 1.05; transform: translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)) !important; }
        .dynamic-theme-override .group.bg-white:hover { background-color: #fff !important; }
        .dynamic-theme-override .group:hover .group-hover\:rotate-6 { --tw-rotate: 6deg; transform: translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)) !important; }
        .dynamic-theme-override .group:hover .group-hover\:rotate-12 { --tw-rotate: 12deg; transform: translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skew(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)) !important; }
        
        .dynamic-theme-override .dark\:text-indigo-400 { color: rgba(var(--primary-rgb), 0.7) !important; }
        .dynamic-theme-override .text-indigo-100 { color: rgba(var(--primary-rgb), 0.4) !important; }
        .dynamic-theme-override .bg-indigo-600\/30 { background-color: rgba(var(--primary-rgb), 0.3) !important; }
        .dynamic-theme-override .bg-indigo-600\/80 { background-color: rgba(var(--primary-rgb), 0.8) !important; }
        
        .dynamic-theme-override .shadow-indigo-100\/50 { --tw-shadow: 0 4px 6px -1px rgba(var(--primary-rgb), 0.1) !important; }
        .dynamic-theme-override .shadow-indigo-600\/20 { --tw-shadow: 0 10px 15px -3px rgba(var(--primary-rgb), 0.2) !important; }
        .dynamic-theme-override .hover\:border-indigo-400:hover { border-color: rgba(var(--primary-rgb), 0.5) !important; }
        
        .dynamic-theme-override .from-purple-500 { --tw-gradient-from: var(--secondary) !important; }
        .dynamic-theme-override .to-pink-500 { --tw-gradient-to: #ec4899 !important; }
        .dynamic-theme-override .to-pink-600 { --tw-gradient-to: #db2777 !important; }
        .dynamic-theme-override .to-pink-700 { --tw-gradient-to: #be185d !important; }
        .dynamic-theme-override .to-rose-600 { --tw-gradient-to: #e11d48 !important; }
        .dynamic-theme-override .border-indigo-100 { border-color: rgba(var(--primary-rgb), 0.15) !important; }
        
        .dynamic-theme-override .hover\:shadow-indigo-200:hover { --tw-shadow-color: rgba(var(--primary-rgb), 0.2); --tw-shadow: var(--tw-shadow-colored) !important; }
        
        .dynamic-theme-override .shadow-lg { --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / .1), 0 4px 6px -4px rgb(0 0 0 / .1); --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .hover\:shadow-lg:hover { --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / .1), 0 4px 6px -4px rgb(0 0 0 / .1); --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .shadow-xl { --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / .1), 0 8px 10px -6px rgb(0 0 0 / .1); --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px rgb(0 0 0 / .1); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .hover\:shadow-xl:hover { --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / .1), 0 8px 10px -6px rgb(0 0 0 / .1); --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .shadow-2xl { --tw-shadow: 0 25px 50px -12px rgb(0 0 0 / .25); --tw-shadow-colored: 0 25px 50px -12px var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .shadow-md { --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / .1), 0 2px 4px -2px rgb(0 0 0 / .1); --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px rgb(0 0 0 / .1); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .shadow-sm { --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / .05); --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color); box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .group:hover .shadow-md { --tw-shadow: 0 4px 6px -1px rgba(var(--primary-rgb), 0.08), 0 2px 4px -2px rgba(var(--primary-rgb), 0.05) !important; --tw-shadow-colored: 0 4px 6px -1px rgba(var(--primary-rgb), 0.08), 0 2px 4px -2px rgba(var(--primary-rgb), 0.05) !important; box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        .dynamic-theme-override .group:hover .shadow-xl { --tw-shadow: 0 20px 25px -5px rgba(var(--primary-rgb), 0.15), 0 8px 10px -6px rgba(var(--primary-rgb), 0.1) !important; --tw-shadow-colored: 0 20px 25px -5px rgba(var(--primary-rgb), 0.15), 0 8px 10px -6px rgba(var(--primary-rgb), 0.1) !important; box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow) !important; }
        
        .dynamic-theme-override .hover\:shadow-\[0_20px_40px_rgba\(79\,70\,229\,0\.1\)\]:hover { --tw-shadow: 0 20px 40px rgba(var(--primary-rgb), 0.1) !important; }
        .dynamic-theme-override .hover\:shadow-\[0_20px_50px_rgba\(79\,70\,229\,0\.4\)\]:hover { --tw-shadow: 0 20px 50px rgba(var(--primary-rgb), 0.4) !important; }
        .dynamic-theme-override .shadow-\[0_20px_60px_-15px_rgba\(0\,0\,0\,0\.3\)\] { --tw-shadow: 0 20px 60px -15px rgb(0 0 0 / .3) !important; }
    </style>
    

    @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-screen mobile-app-view dynamic-theme-override">
    @include('partials.offer-banner', ['placement' => 'top_nav'])
    
    <!-- Mobile App Header - Enhanced App Style -->
    <div class="mobile-app-header lg:hidden">
        <div class="header-left">
                    @php $mobileLogo = \App\Models\Setting::get('website_logo'); @endphp
                    @if($mobileLogo)
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/' . $mobileLogo) }}" alt="{{ \App\Models\Setting::get('website_name', 'RoomRental') }}" class="h-9 w-auto rounded-lg">
                        </a>
                    @else
                        <div class="app-icon">
                            <i class="fas fa-home text-white text-xl"></i>
                        </div>
                    @endif
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
    <!-- Desktop Navigation (Redesigned) -->
    <nav class="hidden md:block bg-white border-b border-slate-100 shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center h-16 py-2">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 overflow-visible">
                    @php
                        $navbarLogo = \App\Models\Setting::get('navbar_logo');
                    @endphp
                    @if($navbarLogo)
                        <img src="{{ asset('storage/' . $navbarLogo) }}"
                             alt="ApnaNest Logo"
                             class="h-10 w-auto object-contain">
                    @else
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md">
                                <i class="fas fa-home text-lg"></i>
                            </div>
                            <span class="text-xl font-black text-slate-900 tracking-tight">Apna<span class="text-indigo-600">Nest</span></span>
                        </div>
                    @endif
                </a>
                
                <!-- Center Links -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">Home</a>
                    <a href="{{ route('rooms.index') }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">Browse Rooms</a>
                    <a href="{{ route('rooms.index', ['room_type' => 'shared_room']) }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">PG</a>
                    <a href="{{ route('rooms.index', ['room_type' => '1bhk']) }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">Apartments</a>
                    <a href="{{ Auth::check() ? (Auth::user()->role === 'owner' ? route('owner.dashboard') : route('dashboard')) : route('register') }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">Owners</a>
                    <a href="{{ route('plans') }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">Pricing</a>
                    <a href="{{ route('blogs.index') }}" class="text-slate-600 hover:text-indigo-600 text-sm font-semibold transition-colors duration-200">Blog</a>
                </div>
                
                <!-- Right Side Actions -->
                <div class="flex items-center gap-4">
                    <!-- Wishlist Icon (Heart) -->
                    <a href="{{ route('wishlist.index') }}" class="text-slate-600 hover:text-red-500 transition-colors p-2 relative" title="My Wishlist">
                        <i class="far fa-heart text-lg"></i>
                    </a>
                    
                    <!-- Notification Icon (Bell) -->
                    <a href="{{ route('pages.faq') }}" class="text-slate-600 hover:text-indigo-600 transition-colors p-2 relative" title="Notifications">
                        <i class="far fa-bell text-lg"></i>
                    </a>
                    
                    @auth
                        <!-- User Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-slate-700 hover:text-indigo-600 transition-colors duration-200 bg-slate-50 hover:bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/60">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div class="bg-indigo-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="hidden xl:inline text-xs font-semibold">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                <i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div class="absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-xl py-1 hidden group-hover:block border border-slate-100 z-50">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 text-sm font-medium">
                                    <i class="far fa-user text-slate-400 text-xs"></i>Profile
                                </a>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 text-sm font-medium">
                                    <i class="fas fa-tachometer-alt text-slate-400 text-xs"></i>Dashboard
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2 px-4 py-2 text-slate-700 hover:bg-slate-50 text-sm font-medium">
                                    <i class="far fa-heart text-red-500 text-xs"></i>My Wishlist
                                </a>
                                <a href="{{ route('referral.index') }}" class="flex items-center gap-2 px-4 py-2 text-emerald-600 hover:bg-emerald-50 text-sm font-bold">
                                    <i class="fas fa-gift text-xs"></i>Refer & Earn
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 text-sm font-medium">
                                        <i class="fas fa-sign-out-alt text-xs"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Post Property Button for Logged In -->
                        <a href="{{ route('rooms.create') }}"
                           class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200 shadow-md shadow-orange-500/10 flex items-center gap-1.5">
                            <i class="fas fa-plus text-xs"></i> Post Property
                        </a>
                    @else
                        <!-- Guest Actions -->
                        <a href="{{ route('login') }}" 
                           class="text-slate-700 hover:text-indigo-600 font-bold transition-colors duration-200 text-sm px-2">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200 shadow-md shadow-indigo-600/15">
                            Sign Up
                        </a>
                        <a href="{{ route('register') }}?role=owner"
                           class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200 shadow-md shadow-orange-500/15">
                            Post Property
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

    <!-- Stay Updated Banner Section -->
    @if(!Route::is('home'))
    <div class="hidden lg:block bg-indigo-50/70 border-t border-indigo-100 py-8">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md">
                    <i class="far fa-envelope-open text-xl"></i>
                </div>
                <div>
                    <h4 class="text-slate-900 font-bold text-lg leading-tight">Stay Updated</h4>
                    <p class="text-slate-600 text-sm">Subscribe to get updates on new rooms and offers.</p>
                </div>
            </div>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex w-full max-w-md bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all">
                @csrf
                <input type="email" name="email" required placeholder="Enter your email" 
                       class="w-full bg-transparent text-slate-800 px-4 py-3 text-sm focus:outline-outline placeholder-slate-400 border-0 outline-none">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 font-bold text-sm transition-colors whitespace-nowrap">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Redesigned Footer Section -->
    <footer class="relative bg-[#0b0f19] text-slate-400 py-12 hidden lg:block overflow-hidden border-t border-slate-900">
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
                <!-- Brand Info (Col span 3) -->
                <div class="lg:col-span-3 space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group" aria-label="RoomRental Home">
                        @php $footerLogo = \App\Models\Setting::get('footer_logo'); @endphp
                        @if($footerLogo)
                            <img src="{{ asset('storage/' . $footerLogo) }}" alt="{{ \App\Models\Setting::get('website_name', 'RoomRental') }}" class="h-10 w-auto object-contain">
                        @else
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md">
                                    <i class="fas fa-home text-lg"></i>
                                </div>
                                <span class="text-xl font-black text-white tracking-tight">Apna<span class="text-indigo-500">Nest</span></span>
                            </div>
                        @endif
                    </a>
                    <p class="text-slate-400 text-xs leading-relaxed font-medium">
                        India's most trusted platform for room rentals. Connect directly with verified owners. Find your stay with zero brokerage.
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
                            <a href="{{ $url }}" aria-label="Visit us on {{ ucfirst(str_replace(['-f', '-in'], '', $icon)) }}" class="w-8 h-8 rounded-lg bg-white/5 text-slate-400 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all duration-300 border border-white/5" {{ $url != '#' ? 'target="_blank"' : '' }}>
                                <i class="fa-brands fa-{{ $icon }} text-xs" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Columns -->
                <!-- Discover -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Discover</h4>
                    <ul class="space-y-2.5 text-xs font-semibold">
                        <li><a href="{{ route('rooms.index') }}" class="text-slate-400 hover:text-white transition-all">Browse Rooms</a></li>
                        <li><a href="{{ route('rooms.index', ['room_type' => 'shared_room']) }}" class="text-slate-400 hover:text-white transition-all">PG</a></li>
                        <li><a href="{{ route('rooms.index', ['room_type' => '1bhk']) }}" class="text-slate-400 hover:text-white transition-all">Apartments</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-400 hover:text-white transition-all">Hostels</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="text-slate-400 hover:text-white transition-all">Villas</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Company</h4>
                    <ul class="space-y-2.5 text-xs font-semibold">
                        <li><a href="{{ route('pages.contact') }}" class="text-slate-400 hover:text-white transition-all">About Us</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-slate-400 hover:text-white transition-all">Careers</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="text-slate-400 hover:text-white transition-all">Terms of Service</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="text-slate-400 hover:text-white transition-all">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-slate-400 hover:text-white transition-all">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Support</h4>
                    <ul class="space-y-2.5 text-xs font-semibold">
                        <li><a href="{{ route('pages.faq') }}" class="text-slate-400 hover:text-white transition-all">Help Center</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="text-slate-400 hover:text-white transition-all">How It Works</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="text-slate-400 hover:text-white transition-all">Safety Tips</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="text-slate-400 hover:text-white transition-all">Report an Issue</a></li>
                        <li><a href="{{ route('sitemap') }}" class="text-slate-400 hover:text-white transition-all">Sitemap</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Contact</h4>
                    <ul class="space-y-3 text-xs font-semibold">
                        <li class="flex items-center gap-2 text-white">
                            <i class="fas fa-phone-alt text-indigo-500"></i>
                            <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+911234567890') }}" class="hover:text-indigo-400 font-bold">{{ \App\Models\Setting::get('contact_phone', '+91 12345 67890') }}</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="far fa-envelope text-indigo-500"></i>
                            <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'support@apnanest.com') }}" class="hover:text-white transition-all">{{ \App\Models\Setting::get('contact_email', 'support@apnanest.com') }}</a>
                        </li>
                        <li class="flex items-center gap-2 text-slate-500">
                            <i class="far fa-clock text-indigo-500"></i>
                            <span>Mon - Sun: 9AM - 8PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="pt-6 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500 font-semibold">
                    &copy; {{ date('Y') }} ApnaNest. All rights reserved.
                </p>
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-slate-500">
                        <i class="fas fa-shield-alt text-emerald-500" aria-hidden="true"></i> Secure Payments
                    </span>
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-slate-500">
                        <i class="fas fa-check-circle text-indigo-500" aria-hidden="true"></i> Verified Listings
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