@extends('layouts.app')

@php
    $cityContext = $cityContext ?? ['isFallback' => false, 'activeCityName' => request('city') ?? session('user_city'), 'launchingSoonCityName' => null, 'defaultCityName' => 'Bhopal'];
    $homeCity = $cityContext['activeCityName'] ?? request('city') ?? session('user_city');
    $displayCity = $cityContext['launchingSoonCityName'] ?? $homeCity;
    $siteName = \App\Models\Setting::get('website_name', 'ApnaNest');
    $text = fn (string $key, string $fallback = '') => \App\Models\Setting::get($key, $fallback);
    $heroImage = $heroRoom?->photo_url ?: asset('assets/images/hero-bg-desktop.webp');
@endphp

@section('title', ($homeCity ? 'Verified Rooms & PG in '.$homeCity : 'Verified Rooms, PG & Apartments') . ' | ' . $siteName)
@section('description', $homeCity ? 'Find verified rooms, PG and apartments in '.$homeCity.'. Connect directly with property owners.' : 'Find verified rooms, PG and apartments. Compare rentals and connect directly with property owners.')
@section('canonical', route('home'))

@push('styles')
@include('partials.listings-ld')
<link rel="preload" href="{{ $heroImage }}" as="image" fetchpriority="high">
<style>
.market-home{background:#fff;color:#0f172a}.market-wrap{width:min(1240px,calc(100% - 40px));margin:auto}.launch-banner{margin-top:18px;display:flex;align-items:center;justify-content:space-between;gap:16px;border:1px solid #fed7aa;background:#fff7ed;color:#9a3412;border-radius:16px;padding:14px 16px}.launch-banner strong{display:block;font-size:13px}.launch-banner span{font-size:12px;color:#c2410c}.launch-banner a{flex:none;color:#1d4ed8;font-size:12px;font-weight:900}.market-hero{padding:28px 0 34px;background:linear-gradient(180deg,#f8fafc 0%,#fff 100%)}.market-hero-box{position:relative;min-height:570px;overflow:hidden;border-radius:26px;background:#0f172a;box-shadow:0 25px 65px -35px rgba(15,23,42,.65)}.market-hero-image{position:absolute;inset:0;background-position:center;background-size:cover}.market-hero-image:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(9,18,38,.98) 0%,rgba(9,18,38,.9) 42%,rgba(9,18,38,.25) 75%,rgba(9,18,38,.12) 100%)}.market-hero-copy{position:relative;z-index:2;width:58%;padding:64px 56px 170px}.market-eyebrow{display:inline-flex;align-items:center;gap:8px;padding:7px 11px;border:1px solid rgba(255,255,255,.16);border-radius:999px;background:rgba(255,255,255,.08);color:#dbeafe;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.09em}.market-eyebrow i{color:#34d399}.market-hero h1{max-width:650px;margin:22px 0 16px;color:#fff;font-size:52px;line-height:1.05;font-weight:900;letter-spacing:-2px}.market-hero h1 span{color:#fb923c}.market-hero-copy>p{max-width:580px;margin:0;color:#cbd5e1;font-size:16px;line-height:1.7}.market-benefits{display:flex;flex-wrap:wrap;gap:18px;margin-top:25px;color:#e2e8f0;font-size:13px;font-weight:700}.market-benefits i{margin-right:6px;color:#60a5fa}.market-search{position:absolute;z-index:3;left:34px;right:34px;bottom:32px;padding:18px;border:1px solid rgba(255,255,255,.65);border-radius:18px;background:rgba(255,255,255,.98);box-shadow:0 20px 45px -24px rgba(15,23,42,.8)}.market-search-grid{display:grid;grid-template-columns:1.25fr 1fr .85fr .85fr auto;gap:10px;align-items:end}.market-field label{display:block;margin:0 0 7px;color:#64748b;font-size:10px;font-weight:850;text-transform:uppercase;letter-spacing:.08em}.market-field input,.market-field select{width:100%;height:46px;padding:0 13px;border:1px solid #dbe3ee;border-radius:10px;background:#f8fafc;color:#334155;font-size:13px;font-weight:650;outline:none}.market-field input:focus,.market-field select:focus{border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.1);background:#fff}.market-search button{height:46px;padding:0 24px;border:0;border-radius:10px;background:#2563eb;color:#fff;font-size:13px;font-weight:850;box-shadow:0 9px 18px rgba(37,99,235,.2)}.market-search button:hover{background:#1d4ed8}.market-stats{display:grid;grid-template-columns:repeat(4,1fr);margin-top:18px;border:1px solid #e2e8f0;border-radius:17px;background:#fff;box-shadow:0 8px 28px -24px rgba(15,23,42,.5)}.market-stat{display:flex;align-items:center;justify-content:center;gap:12px;min-height:86px;border-right:1px solid #e2e8f0}.market-stat:last-child{border:0}.market-stat>span{display:grid;place-items:center;width:42px;height:42px;border-radius:11px;background:#eff6ff;color:#2563eb}.market-stat strong{display:block;font-size:19px}.market-stat small{color:#64748b;font-size:11px;font-weight:650}.market-section{padding:58px 0}.market-section.soft{background:#f8fafc;border-top:1px solid #eef2f7;border-bottom:1px solid #eef2f7}.market-section-head{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:24px}.market-kicker{color:#2563eb;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.13em}.market-section h2{margin:6px 0 5px;font-size:30px;line-height:1.2;font-weight:900;letter-spacing:-.8px}.market-section-head p{margin:0;color:#64748b;font-size:13px}.market-section-head>a{color:#2563eb;font-size:12px;font-weight:800;text-decoration:none}.market-types{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}.market-type{display:flex;align-items:center;gap:12px;padding:17px;border:1px solid #e2e8f0;border-radius:14px;background:#fff;color:#0f172a;text-decoration:none;transition:.2s}.market-type:hover{transform:translateY(-3px);border-color:#bfdbfe;box-shadow:0 14px 28px -22px rgba(15,23,42,.45)}.market-type>span{display:grid;place-items:center;flex:none;width:40px;height:40px;border-radius:11px;background:#eff6ff;color:#2563eb}.market-type strong{display:block;font-size:13px}.market-type small{display:block;margin-top:3px;color:#94a3b8;font-size:10px}.market-room-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}.market-room{overflow:hidden;border:1px solid #e2e8f0;border-radius:16px;background:#fff;color:inherit;text-decoration:none;box-shadow:0 4px 15px rgba(15,23,42,.035);transition:.22s}.market-room:hover{transform:translateY(-4px);border-color:#bfdbfe;box-shadow:0 18px 34px -22px rgba(15,23,42,.45)}.market-room-photo{position:relative;height:190px;background:#f1f5f9}.market-room-photo img{width:100%;height:100%;object-fit:cover}.market-room-badge{position:absolute;left:10px;top:10px;padding:5px 7px;border-radius:7px;background:#2563eb;color:#fff;font-size:8px;font-weight:900;text-transform:uppercase}.market-room-price{position:absolute;left:10px;bottom:10px;padding:7px 10px;border-radius:9px;background:rgba(15,23,42,.9);color:#fff;font-size:14px;font-weight:900}.market-room-price small{font-size:8px;color:#cbd5e1}.market-room-copy{padding:15px}.market-room-copy h3{margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:14px;font-weight:850}.market-room-copy>p{margin:7px 0 12px;color:#64748b;font-size:11px}.market-room-copy>p i{margin-right:5px;color:#f43f5e}.market-room-meta{display:flex;gap:6px;flex-wrap:wrap}.market-room-meta span{padding:5px 7px;border-radius:6px;background:#f1f5f9;color:#64748b;font-size:8px;font-weight:750}.market-areas{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}.market-area{display:flex;align-items:center;justify-content:space-between;padding:17px;border:1px solid #e2e8f0;border-radius:13px;background:#fff;text-decoration:none}.market-area:hover{border-color:#93c5fd;background:#f8fbff}.market-area strong{display:block;color:#0f172a;font-size:13px}.market-area small{display:block;margin-top:4px;color:#64748b;font-size:10px}.market-area i{color:#cbd5e1}.market-how{display:grid;grid-template-columns:1.05fr .95fr;gap:22px}.market-process,.market-trust{padding:28px;border:1px solid #e2e8f0;border-radius:18px;background:#fff}.market-process-list{display:grid;gap:12px;margin-top:22px}.market-step{display:grid;grid-template-columns:42px 1fr;gap:13px;align-items:center;padding:13px;border-radius:12px;background:#f8fafc}.market-step>b{display:grid;place-items:center;width:42px;height:42px;border-radius:11px;background:#2563eb;color:#fff}.market-step strong{display:block;font-size:13px}.market-step small{display:block;margin-top:4px;color:#64748b;font-size:11px;line-height:1.5}.market-trust{position:relative;overflow:hidden;background:#0f172a;color:#fff}.market-trust:after{content:"";position:absolute;width:260px;height:260px;right:-130px;top:-130px;border-radius:50%;background:#2563eb;opacity:.18}.market-trust h2{color:#fff}.market-trust>p{color:#94a3b8;font-size:13px;line-height:1.7}.market-checks{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin-top:24px}.market-check{position:relative;z-index:1;padding:14px;border:1px solid rgba(255,255,255,.08);border-radius:11px;background:rgba(255,255,255,.04);font-size:11px;font-weight:750}.market-check i{margin-right:7px;color:#34d399}.market-owner{display:flex;align-items:center;justify-content:space-between;gap:30px;padding:36px 40px;border-radius:21px;background:linear-gradient(120deg,#172554,#1e3a8a 55%,#2563eb);color:#fff}.market-owner h2{margin:0 0 8px;color:#fff}.market-owner p{margin:0;color:#bfdbfe;font-size:13px}.market-owner a{flex:none;padding:13px 18px;border-radius:11px;background:#fff;color:#1d4ed8;font-size:12px;font-weight:900;text-decoration:none}.market-editorial{display:grid;grid-template-columns:1.2fr .8fr;gap:22px}.market-blogs,.market-reviews{padding:24px;border:1px solid #e2e8f0;border-radius:18px;background:#fff}.market-blog-list{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:19px}.market-blog{color:inherit;text-decoration:none}.market-blog img{width:100%;height:110px;object-fit:cover;border-radius:10px;background:#f1f5f9}.market-blog h3{margin:9px 0 4px;font-size:11px;line-height:1.4}.market-blog small{color:#94a3b8;font-size:9px}.market-review-list{display:grid;gap:10px;margin-top:19px}.market-review{padding:14px;border-radius:11px;background:#f8fafc}.market-review p{margin:0;color:#475569;font-size:11px;line-height:1.6}.market-review strong{display:block;margin-top:9px;font-size:10px}.market-review small{color:#94a3b8;font-size:9px}.market-empty{grid-column:1/-1;padding:45px 20px;border:1px dashed #cbd5e1;border-radius:16px;text-align:center;color:#64748b}.market-empty i{display:block;margin-bottom:10px;color:#94a3b8;font-size:28px}.market-empty p{font-size:12px}.market-empty a{display:inline-block;margin-top:12px;color:#2563eb;font-size:11px;font-weight:800}.market-home a,.market-home button{transition:.18s}.market-home button:active,.market-home a:active{transform:scale(.98)}
.market-home{overflow-x:hidden}.market-wrap{width:min(1400px,calc(100% - 48px))}
@media(min-width:1600px){.market-wrap{width:min(1440px,calc(100% - 80px))}.market-hero-box{min-height:600px}.market-hero-copy{padding-left:68px}.market-hero h1{font-size:58px}.market-room-photo{height:210px}}
@media(min-width:1200px) and (max-width:1599px){.market-wrap{width:min(1320px,calc(100% - 48px))}.market-hero h1{font-size:clamp(44px,3.65vw,52px)}.market-hero-copy{padding-left:clamp(42px,4vw,56px);padding-right:35px}.market-search{left:28px;right:28px}}
@media(min-width:1024px) and (max-width:1199px){.market-wrap{width:calc(100% - 36px)}.market-hero-box{min-height:550px}.market-hero-copy{width:64%;padding:46px 38px 165px}.market-hero h1{font-size:40px;letter-spacing:-1.3px}.market-hero-copy>p{font-size:14px}.market-search{left:22px;right:22px;bottom:22px;padding:14px}.market-search-grid{grid-template-columns:1.25fr 1fr .8fr .8fr auto;gap:8px}.market-field input,.market-field select{height:43px;font-size:12px}.market-search button{height:43px;padding:0 16px;white-space:nowrap}.market-types{grid-template-columns:repeat(5,minmax(0,1fr))}.market-type{padding:13px}.market-room-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}.market-room-photo{height:165px}.market-room-copy{padding:12px}.market-areas{grid-template-columns:repeat(4,minmax(0,1fr))}.market-area{padding:14px}.market-section{padding:48px 0}}
@media(max-width:1023px){.market-wrap{width:min(100% - 28px,900px)}.market-hero-box{min-height:auto}.market-hero-copy{width:72%;padding:45px 36px 40px}.market-hero h1{font-size:42px}.market-search{position:relative;left:auto;right:auto;bottom:auto;margin:0 22px 22px}.market-search-grid{grid-template-columns:1fr 1fr}.market-search button{grid-column:1/-1}.market-types{grid-template-columns:repeat(3,1fr)}.market-room-grid{grid-template-columns:repeat(2,1fr)}.market-areas{grid-template-columns:repeat(2,1fr)}.market-how,.market-editorial{grid-template-columns:1fr}.market-stat{padding:12px}}
@media(min-width:768px) and (max-width:899px){.market-wrap{width:calc(100% - 28px)}.market-hero-copy{width:78%;padding:38px 30px 32px}.market-hero h1{font-size:36px}.market-hero-copy>p{font-size:14px}.market-search{margin:0 16px 16px}.market-stats{grid-template-columns:repeat(2,1fr)}.market-stat:nth-child(2){border-right:0}.market-stat:nth-child(-n+2){border-bottom:1px solid #e2e8f0}.market-types{grid-template-columns:repeat(2,1fr)}.market-how,.market-editorial{gap:16px}.market-owner{padding:30px}}
@media(max-width:767px){.market-wrap{width:min(100% - 22px,680px)}.market-hero{padding-top:12px}.market-hero-box{border-radius:18px}.market-hero-copy{width:100%;padding:38px 22px 28px;background:rgba(15,23,42,.82)}.market-hero h1{font-size:35px;letter-spacing:-1.2px}.market-hero-copy>p{font-size:14px}.market-search{margin:0;border-radius:0;padding:14px}.market-search-grid{grid-template-columns:1fr}.market-search button{grid-column:auto}.market-stats{grid-template-columns:1fr 1fr}.market-stat{min-height:75px;justify-content:flex-start;padding-left:16px}.market-stat:nth-child(2){border-right:0}.market-stat:nth-child(-n+2){border-bottom:1px solid #e2e8f0}.market-section{padding:40px 0}.market-section-head{align-items:flex-start;flex-direction:column}.market-section h2{font-size:24px}.market-types{grid-template-columns:1fr 1fr}.market-room-grid{grid-template-columns:1fr}.market-room-photo{height:210px}.market-areas{grid-template-columns:1fr}.market-checks{grid-template-columns:1fr}.market-owner{align-items:flex-start;flex-direction:column;padding:28px}.market-owner a{width:100%;text-align:center}.market-blog-list{grid-template-columns:1fr 1fr}.market-blog:last-child{display:none}}
</style>
@endpush

@section('content')
<main class="market-home">
    <section class="market-hero">
        <div class="market-wrap">
            <div class="market-hero-box">
                <div class="market-hero-image" style="background-image:url('{{ $heroImage }}')"></div>
                <div class="market-hero-copy">
                    <span class="market-eyebrow"><i class="fas fa-circle-check"></i>{{ $text('home_hero_eyebrow','Verified rooms. Direct owner contact.') }}</span>
                    <h1>{{ $text('home_hero_title','Find a place that feels right') }} <span>{{ $displayCity ? 'in '.$displayCity : $text('home_hero_highlight','near you') }}</span></h1>
                    <p>{{ $text('home_hero_description','Compare verified rooms, PGs and apartments, then connect directly with genuine property owners.') }}</p>
                    <div class="market-benefits"><span><i class="fas fa-ban"></i>No brokerage</span><span><i class="fas fa-user-check"></i>Verified owners</span><span><i class="fas fa-shield-halved"></i>Secure payments</span></div>
                </div>
                <form action="{{ route('rooms.index') }}" method="GET" class="market-search">
                    <div class="market-search-grid">
                        <div class="market-field"><label>Where do you want to live?</label><input name="city" value="{{ $displayCity }}" placeholder="Enter city or locality"></div>
                        <div class="market-field"><label>Property type</label><select name="room_type[]"><option value="">All property types</option>@foreach($roomCategories as $category)<option value="{{ $category->room_type_option_id }}">{{ $category->label }}</option>@endforeach</select></div>
                        <div class="market-field"><label>Minimum rent</label><input type="number" name="min_rent" placeholder="₹ Minimum"></div>
                        <div class="market-field"><label>Maximum rent</label><input type="number" name="max_rent" placeholder="₹ Maximum"></div>
                        <button type="submit"><i class="fas fa-search"></i>&nbsp; Search rooms</button>
                    </div>
                </form>
            </div>
            @include('partials.offer-banner', ['placement' => 'home_hero'])
            <div class="market-stats">
                @foreach([['fa-house-circle-check',number_format($totalRooms).'+','Verified rooms'],['fa-user-check',number_format($totalOwners).'+','Property owners'],['fa-location-dot',number_format($totalAreas).'+','Cities & areas'],['fa-headset','7 days','Customer support']] as $stat)
                    <div class="market-stat"><span><i class="fas {{ $stat[0] }}"></i></span><div><strong>{{ $stat[1] }}</strong><small>{{ $stat[2] }}</small></div></div>
                @endforeach
            </div>
            @if($cityContext['isFallback'])
                <div class="launch-banner">
                    <div><strong>Launching soon in {{ $cityContext['launchingSoonCityName'] }}</strong><span>We're currently active in {{ $cityContext['activeCityName'] }}. Showing verified {{ $cityContext['activeCityName'] }} properties for now.</span></div>
                    <a href="{{ route('rooms.index', ['city' => $cityContext['activeCityName']]) }}">View {{ $cityContext['activeCityName'] }}</a>
                </div>
            @endif
        </div>
    </section>

    <section class="market-section">
        <div class="market-wrap">
            <div class="market-section-head"><div><span class="market-kicker">Explore your options</span><h2>Find the right kind of home</h2><p>Start with a property type that matches your lifestyle and budget.</p></div><a href="{{ route('rooms.index') }}">Browse all rooms <i class="fas fa-arrow-right"></i></a></div>
            <div class="market-types">
                @forelse($roomCategories->take(5) as $category)
                    <a href="{{ route('rooms.index',['room_type'=>[$category->room_type_option_id]]) }}" class="market-type"><span><i class="fas fa-building"></i></span><div><strong>{{ $category->label }}</strong><small>{{ $category->total ?? 0 }} available</small></div></a>
                @empty
                    <div class="market-empty"><i class="fas fa-building"></i><p>Property categories will appear here.</p></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="market-section soft">
        <div class="market-wrap">
            <div class="market-section-head"><div><span class="market-kicker">Freshly added</span><h2>{{ $text('home_latest_title','Latest verified rooms') }}</h2><p>{{ $text('home_latest_description','Genuine listings with clear rent, photos and property details.') }}</p></div><a href="{{ route('rooms.index') }}">View every listing <i class="fas fa-arrow-right"></i></a></div>
            <div class="market-room-grid">
                @forelse($rooms->take(8) as $room)
                    <a href="{{ route('rooms.show',$room) }}" class="market-room">
                        <div class="market-room-photo">
                            @if($room->photo_url)
                                <img src="{{ $room->photo_url }}" alt="{{ $room->title }}" loading="lazy">
                            @endif
                            @if($room->is_featured)
                                <span class="market-room-badge">Featured</span>
                            @endif
                            <span class="market-room-price">₹{{ number_format($room->rent) }} <small>/month</small></span>
                        </div>
                        <div class="market-room-copy"><h3>{{ $room->title }}</h3><p><i class="fas fa-location-dot"></i>{{ $room->city }}</p><div class="market-room-meta"><span>{{ $room->roomTypeLabel() }}</span><span>{{ $room->furnishingTypeLabel() }}</span><span>{{ $room->tenantTypeLabel() }}</span></div></div>
                    </a>
                @empty
                    <div class="market-empty"><i class="fas fa-house"></i><p>No verified listings are available yet.</p><a href="{{ route('rooms.index') }}">Browse rooms</a></div>
                @endforelse
            </div>
        </div>
    </section>

    @if($popularAreas->count())
    <section class="market-section">
        <div class="market-wrap">
            <div class="market-section-head"><div><span class="market-kicker">Popular neighbourhoods</span><h2>Explore places renters search most</h2><p>Compare local options before choosing your next area.</p></div></div>
            <div class="market-areas">@foreach($popularAreas->take(8) as $area)<a href="{{ route('rooms.index',['city'=>$homeCity,'area'=>$area->area_name]) }}" class="market-area"><div><strong>{{ $area->area_name }}</strong><small>{{ $area->total }} rooms · from ₹{{ number_format($area->min_rent) }}</small></div><i class="fas fa-arrow-right"></i></a>@endforeach</div>
        </div>
    </section>
    @endif

    <section class="market-section soft">
        <div class="market-wrap market-how">
            <div class="market-process"><span class="market-kicker">Simple rental journey</span><h2>{{ $text('home_steps_title','How ApnaNest works') }}</h2><div class="market-process-list">@foreach([['Search','Filter rooms by city, budget and preference.'],['Compare','Review photos, rent, amenities and owner information.'],['Connect','Unlock contact and speak directly with the property owner.']] as $i=>$step)<div class="market-step"><b>{{ $i+1 }}</b><div><strong>{{ $text('home_step_'.($i+1).'_title',$step[0]) }}</strong><small>{{ $text('home_step_'.($i+1).'_description',$step[1]) }}</small></div></div>@endforeach</div></div>
            <div class="market-trust"><span class="market-kicker">Built for safer renting</span><h2>More clarity before you connect</h2><p>ApnaNest helps users compare useful property information and reach owners without unnecessary middlemen.</p><div class="market-checks"><div class="market-check"><i class="fas fa-check-circle"></i>Reviewed listings</div><div class="market-check"><i class="fas fa-check-circle"></i>Clear monthly rent</div><div class="market-check"><i class="fas fa-check-circle"></i>Direct owner contact</div><div class="market-check"><i class="fas fa-check-circle"></i>Report and support tools</div></div></div>
        </div>
    </section>

    <section class="market-section"><div class="market-wrap"><div class="market-owner"><div><span class="market-kicker" style="color:#93c5fd">For property owners</span><h2>{{ $text('home_owner_title','Have a room or property to rent?') }}</h2><p>{{ $text('home_owner_description','Create a clear listing and connect with people actively searching in your city.') }}</p></div><a href="{{ route('register',['role'=>'owner']) }}"><i class="fas fa-plus"></i>&nbsp; {{ $text('home_owner_button','List your property') }}</a></div></div></section>

    <section class="market-section soft">
        <div class="market-wrap market-editorial">
            <div class="market-blogs"><span class="market-kicker">Rental knowledge</span><h2>Helpful guides and updates</h2><div class="market-blog-list">@forelse($latestBlogs->take(3) as $blog)<a href="{{ route('blogs.show',$blog->slug) }}" class="market-blog">@if($blog->featured_image)<img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" loading="lazy">@else<div style="height:110px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;color:#818cf8"><i class="fas fa-newspaper"></i></div>@endif<h3>{{ $blog->title }}</h3><small>{{ optional($blog->published_at ?? $blog->created_at)->format('d M Y') }}</small></a>@empty<div class="market-empty"><p>Helpful rental guides will appear here.</p></div>@endforelse</div></div>
            <div class="market-reviews"><span class="market-kicker">Renter experiences</span><h2>What users value</h2><div class="market-review-list">@foreach([['home_testimonial_1','Rahul Sharma','Student'],['home_testimonial_2','Neha Verma','Working professional']] as $item)<div class="market-review"><p>“{{ $text($item[0].'_text','The listing information was easy to understand and contacting the owner was straightforward.') }}”</p><strong>{{ $text($item[0].'_name',$item[1]) }}</strong><small>{{ $text($item[0].'_role',$item[2]) }}</small></div>@endforeach</div></div>
        </div>
    </section>
</main>
@endsection
