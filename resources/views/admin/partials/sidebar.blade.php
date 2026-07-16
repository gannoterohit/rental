@php
    $adminSiteName = \App\Models\Setting::get('website_name', config('app.name', 'ApnaNest'));
    $adminLogo = \App\Models\Setting::get('navbar_logo') ?: \App\Models\Setting::get('website_logo');
    $navGroups = [
        'Overview' => [
            ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
            ['route' => 'admin.analytics', 'match' => 'admin.analytics', 'icon' => 'fa-chart-line', 'label' => 'Search Analytics'],
            ['route' => 'admin.reports', 'match' => 'admin.reports', 'icon' => 'fa-chart-pie', 'label' => 'Reports'],
        ],
        'Property Management' => [
            ['route' => 'admin.all-rooms', 'match' => 'admin.all-rooms', 'icon' => 'fa-building', 'label' => 'All Rooms'],
            ['route' => 'admin.room-options.index', 'match' => 'admin.room-options*', 'icon' => 'fa-sliders-h', 'label' => 'Room Options'],
            ['route' => 'admin.rejection-reasons.index', 'match' => 'admin.rejection-reasons*', 'icon' => 'fa-clipboard-list', 'label' => 'Rejection Reasons'],
        ],
        'People' => [
            ['route' => 'admin.users', 'match' => 'admin.users*', 'icon' => 'fa-users', 'label' => 'Users'],
            ['route' => 'admin.owners', 'match' => 'admin.owners*', 'icon' => 'fa-user-tie', 'label' => 'Owners'],
            ['route' => 'admin.subscribers.index', 'match' => 'admin.subscribers*', 'icon' => 'fa-envelope', 'label' => 'Subscribers'],
            ['route' => 'admin.city-alerts.index', 'match' => 'admin.city-alerts*', 'icon' => 'fa-bell', 'label' => 'City Alerts'],
            ['route' => 'admin.contact-messages.index', 'match' => 'admin.contact-messages*', 'icon' => 'fa-inbox', 'label' => 'Messages'],
        ],
        'Finance & Growth' => [
            ['route' => 'admin.payments.index', 'match' => 'admin.payments*', 'icon' => 'fa-credit-card', 'label' => 'Payments'],
            ['route' => 'admin.payouts', 'match' => 'admin.payouts*', 'icon' => 'fa-wallet', 'label' => 'Payouts'],
            ['route' => 'admin.plans.index', 'match' => 'admin.plans*', 'icon' => 'fa-tags', 'label' => 'Plans'],
            ['route' => 'admin.offers.index', 'match' => 'admin.offers*', 'icon' => 'fa-bullhorn', 'label' => 'Offers'],
        ],
        'Content & Settings' => [
            ['route' => 'admin.blogs.index', 'match' => 'admin.blogs*', 'icon' => 'fa-newspaper', 'label' => 'Blogs'],
            ['route' => 'admin.settings', 'match' => 'admin.settings*', 'icon' => 'fa-cog', 'label' => 'Business Settings'],
        ],
    ];
    $pageItems = [
            ['route' => 'admin.pages.about', 'match' => 'admin.pages.about*', 'icon' => 'fa-info-circle', 'label' => 'About Us'],
            ['route' => 'admin.pages.careers', 'match' => 'admin.pages.careers*', 'icon' => 'fa-briefcase', 'label' => 'Careers'],
            ['route' => 'admin.pages.how-it-works', 'match' => 'admin.pages.how-it-works*', 'icon' => 'fa-route', 'label' => 'How It Works'],
            ['route' => 'admin.pages.safety-tips', 'match' => 'admin.pages.safety-tips*', 'icon' => 'fa-shield-alt', 'label' => 'Safety Tips'],
            ['route' => 'admin.pages.terms', 'match' => 'admin.pages.terms*', 'icon' => 'fa-file-contract', 'label' => 'Terms'],
            ['route' => 'admin.pages.privacy', 'match' => 'admin.pages.privacy*', 'icon' => 'fa-user-shield', 'label' => 'Privacy Policy'],
            ['route' => 'admin.pages.condition', 'match' => 'admin.pages.condition*', 'icon' => 'fa-clipboard-check', 'label' => 'Condition Policy'],
            ['route' => 'admin.pages.contact', 'match' => 'admin.pages.contact*', 'icon' => 'fa-address-book', 'label' => 'Contact Us'],
            ['route' => 'admin.pages.faq', 'match' => 'admin.pages.faq*', 'icon' => 'fa-question-circle', 'label' => 'FAQ'],
    ];
    $pagesOpen = request()->routeIs('admin.pages*');
@endphp

<button id="adminSidebarOpen" class="lg:hidden fixed top-3 left-3 z-[70] w-10 h-10 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-200" aria-label="Open admin menu"><i class="fas fa-bars"></i></button>
<div id="adminSidebarBackdrop" class="hidden lg:hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[55]"></div>
<aside id="adminSidebar" class="fixed lg:sticky top-0 left-0 z-[60] h-screen w-[250px] bg-white text-slate-700 border-r border-slate-200 flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-200 shrink-0 shadow-[4px_0_18px_rgba(15,23,42,0.035)]">
    <div class="h-14 px-4 flex items-center justify-between border-b border-slate-100">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
            @if($adminLogo)
                <span class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center overflow-hidden shadow-sm p-1">
                    <img src="{{ asset('storage/' . $adminLogo) }}" alt="{{ $adminSiteName }}" class="w-full h-full object-contain">
                </span>
            @else
                <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 text-white flex items-center justify-center shadow-sm shadow-indigo-200"><i class="fas fa-home text-xs"></i></span>
            @endif
            <span class="min-w-0"><strong class="block text-slate-900 text-sm leading-tight truncate max-w-[150px]">{{ $adminSiteName }}</strong><small class="block text-[8px] text-slate-400 tracking-[.16em] uppercase mt-0.5">Admin Workspace</small></span>
        </a>
        <button id="adminSidebarClose" class="lg:hidden w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100"><i class="fas fa-times"></i></button>
    </div>
    <nav class="flex-1 min-h-0 overflow-y-auto px-2.5 py-3.5 space-y-3 overscroll-contain">
        @foreach($navGroups as $group => $items)
            <section>
                <p class="px-2.5 mb-1.5 text-[8px] font-extrabold uppercase tracking-[.15em] text-slate-400">{{ $group }}</p>
                <div class="space-y-1">
                    @foreach($items as $item)
                        <a href="{{ route($item['route']) }}" class="group relative flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[12px] transition {{ request()->routeIs($item['match']) ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-50 hover:text-slate-900' }}">
                            @if(request()->routeIs($item['match']))<span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-indigo-600"></span>@endif
                            <span class="w-7 h-7 -my-1 rounded-md flex items-center justify-center {{ request()->routeIs($item['match']) ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-indigo-100' : 'text-slate-400 group-hover:bg-white group-hover:text-indigo-600' }} transition">
                                <i class="fas {{ $item['icon'] }} text-[11px]"></i>
                            </span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach
        <section>
            <p class="px-2.5 mb-1.5 text-[8px] font-extrabold uppercase tracking-[.15em] text-slate-400">Website Content</p>
            <button type="button" id="websitePagesToggle" class="w-full group relative flex items-center justify-between gap-2.5 px-2.5 py-2 rounded-lg text-[12px] transition {{ $pagesOpen ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 font-medium hover:bg-slate-50 hover:text-slate-900' }}">
                <span class="flex items-center gap-2.5">
                    <span class="w-7 h-7 -my-1 rounded-md flex items-center justify-center {{ $pagesOpen ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-indigo-100' : 'text-slate-400 group-hover:bg-white group-hover:text-indigo-600' }}"><i class="fas fa-file-alt text-[11px]"></i></span>
                    <span>Website Pages</span>
                </span>
                <i id="websitePagesChevron" class="fas fa-chevron-down text-[9px] text-slate-400 transition-transform {{ $pagesOpen ? 'rotate-180' : '' }}"></i>
            </button>
            <div id="websitePagesMenu" class="{{ $pagesOpen ? '' : 'hidden' }} mt-1 ml-4 pl-2 border-l border-slate-200 space-y-0.5">
                @foreach($pageItems as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-[11px] transition {{ request()->routeIs($item['match']) ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fas {{ $item['icon'] }} w-4 text-center text-[10px] {{ request()->routeIs($item['match']) ? 'text-indigo-600' : 'text-slate-400' }}"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    </nav>
    <div id="adminSidebarFooter" class="shrink-0 p-2.5 border-t border-slate-200 bg-white shadow-[0_-6px_18px_rgba(15,23,42,0.04)]">
        <div class="flex items-center gap-2.5 px-2 py-1.5 mb-1.5 rounded-lg bg-slate-50 border border-slate-100">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-lg object-cover ring-2 ring-white shadow-sm">
            @else
                <div class="w-8 h-8 shrink-0 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            @endif
            <div class="min-w-0 flex-1"><p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p><p class="text-[8px] text-slate-400 font-semibold uppercase tracking-wider">Administrator</p></div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-red-50 border border-red-100 text-red-600 hover:bg-red-600 hover:border-red-600 hover:text-white text-[11px] font-bold transition">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
<script>
(() => {
    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('adminSidebarBackdrop');
    const toggle = (open) => { sidebar?.classList.toggle('-translate-x-full', !open); backdrop?.classList.toggle('hidden', !open); };
    document.getElementById('adminSidebarOpen')?.addEventListener('click', () => toggle(true));
    document.getElementById('adminSidebarClose')?.addEventListener('click', () => toggle(false));
    backdrop?.addEventListener('click', () => toggle(false));
    document.getElementById('websitePagesToggle')?.addEventListener('click', () => {
        document.getElementById('websitePagesMenu')?.classList.toggle('hidden');
        document.getElementById('websitePagesChevron')?.classList.toggle('rotate-180');
    });
})();
</script>
