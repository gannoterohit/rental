@php
    $siteName = \App\Models\Setting::get('website_name', 'RoomRental');
    $defaultDescription = \App\Models\Setting::get('seo_meta_description', 'Find your perfect room in your city. Browse verified room listings.');
    $defaultKeywords = \App\Models\Setting::get('seo_meta_keywords', 'room rental, apartment, house, property');
    $defaultImage = asset('storage/' . (\App\Models\Setting::get('website_logo') ?? 'default-room.jpg'));
    $title = trim($__env->yieldContent('title')) ?: $siteName;
    $description = trim($__env->yieldContent('description')) ?: $defaultDescription;
    $keywords = trim($__env->yieldContent('keywords')) ?: $defaultKeywords;
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogTitle = trim($__env->yieldContent('og_title')) ?: $title;
    $ogDescription = trim($__env->yieldContent('og_description')) ?: $description;
    $ogUrl = trim($__env->yieldContent('og_url')) ?: $canonical;
    $ogImage = trim($__env->yieldContent('og_image')) ?: $defaultImage;
@endphp

<!-- Canonical -->
<link rel="canonical" href="{{ $canonical }}">

<!-- Open Graph -->
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:url" content="{{ $ogUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:type" content="website">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- Sitemap link -->
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}">

@stack('head')

@php
    $gsc = \App\Models\Setting::get('google_search_console_code');
@endphp

@if($gsc)
    <meta name="google-site-verification" content="{{ $gsc }}">
@endif
