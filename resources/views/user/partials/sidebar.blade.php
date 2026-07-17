@php
    $activeUserSection = $active ?? '';
    $accountUser = Auth::user();
    $userItems = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-chart-pie', 'href' => route('dashboard')],
        ['key' => 'browse', 'label' => 'Browse Rooms', 'icon' => 'fa-magnifying-glass', 'href' => route('rooms.index')],
        ['key' => 'wallet', 'label' => 'My Wallet', 'icon' => 'fa-wallet', 'href' => route('wallet')],
        ['key' => 'wishlist', 'label' => 'Wishlist', 'icon' => 'fa-heart', 'href' => route('wishlist.index')],
        ['key' => 'referral', 'label' => 'Refer & Earn', 'icon' => 'fa-gift', 'href' => route('referral.index')],
        ['key' => 'plans', 'label' => 'Plans', 'icon' => 'fa-tags', 'href' => route('plans')],
        ['key' => 'profile', 'label' => 'Profile Settings', 'icon' => 'fa-user-gear', 'href' => route('profile.edit')],
    ];
    $accountLogo = \App\Models\Setting::get('navbar_logo') ?: \App\Models\Setting::get('website_logo');
@endphp

@once
<style>
    .user-workspace { display: flex !important; width: 100%; min-width: 0; background: #f8fafc; }
    .user-workspace > .user-sidebar { display: flex !important; position: fixed !important; top: 4rem !important; bottom: 0 !important; left: 0 !important; z-index: 35; width: 16rem !important; height: calc(100vh - 4rem) !important; overflow: hidden; }
    .user-workspace > .user-sidebar nav { overflow: hidden !important; min-height: 0; }
    .user-workspace > main { min-width: 0; width: calc(100% - 16rem); margin-left: 16rem !important; }
    .user-workspace .workspace-header {
        background: #fff !important;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem !important;
    }
    .user-workspace .rounded-3xl { border-radius: 1rem !important; }
    .user-workspace .p-8,
    .user-workspace .lg\:p-8,
    .user-workspace .lg\:p-10 { padding: 1.25rem !important; }
    .user-workspace .p-12 { padding: 2rem !important; }
    .user-workspace .text-4xl { font-size: 1.75rem !important; line-height: 2.1rem !important; }
    .user-workspace .text-3xl { font-size: 1.5rem !important; line-height: 2rem !important; }
    .user-workspace .shadow-xl,
    .user-workspace .shadow-2xl { box-shadow: 0 10px 28px rgba(15, 23, 42, .08) !important; }
    .user-workspace input,
    .user-workspace select,
    .user-workspace textarea { border-radius: .75rem !important; border: 1px solid #e2e8f0 !important; }
    .user-workspace button[type="submit"] { border-radius: .75rem !important; }
    @media (max-width: 1023px) {
        .user-workspace { display: block !important; }
        .user-workspace > .user-sidebar { display: none !important; }
        .user-workspace > main { width: 100% !important; margin-left: 0 !important; }
        .user-workspace .p-8,
        .user-workspace .lg\:p-8,
        .user-workspace .lg\:p-10 { padding: 1rem !important; }
    }
</style>
@endonce

<aside class="user-sidebar hidden lg:flex bg-white border-r border-slate-200 flex-col">
    <div class="px-5 py-5 border-b border-slate-100">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            @if($accountLogo)
                <img src="{{ asset('storage/' . $accountLogo) }}" alt="Account" class="w-10 h-10 rounded-xl object-contain border border-slate-200 bg-white p-1">
            @else
                <span class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center"><i class="fas fa-user"></i></span>
            @endif
            <span><strong class="block text-sm text-slate-900">My Account</strong><small class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">User workspace</small></span>
        </a>
    </div>
    <nav class="flex-1 overflow-y-auto p-3 space-y-1.5" aria-label="User navigation">
        @foreach($userItems as $item)
            @php $isActive = $activeUserSection === $item['key']; @endphp
            <a href="{{ $item['href'] }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $isActive ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" @if($isActive) aria-current="page" @endif>
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isActive ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}"><i class="fas {{ $item['icon'] }} text-xs"></i></span>
                <span>{{ $item['label'] }}</span>
                @if($isActive)<i class="fas fa-chevron-right text-[9px] ml-auto"></i>@endif
            </a>
        @endforeach
    </nav>
    <div class="p-3 border-t border-slate-100">
        <div class="flex items-center gap-3 px-3 py-2 mb-1">
            <img src="{{ $accountUser?->avatar ? asset('storage/'.$accountUser->avatar) : asset('assets/images/default-avatar.svg') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/default-avatar.svg') }}'" alt="User profile" class="w-9 h-9 rounded-full border border-slate-200 bg-indigo-50 object-cover">
            <span class="min-w-0"><strong class="block text-xs text-slate-800 truncate">{{ $accountUser?->name }}</strong><small class="block text-[10px] text-slate-400 truncate">{{ $accountUser?->email }}</small></span>
        </div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors"><span class="w-8 text-center"><i class="fas fa-right-from-bracket"></i></span>Logout</button>
        </form>
    </div>
</aside>
