@php
    $activeOwnerSection = $active ?? '';
    $owner = Auth::user();
    $ownerItems = [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'fa-chart-pie', 'href' => route('owner.dashboard')],
        ['key' => 'create', 'label' => 'Add New Room', 'icon' => 'fa-square-plus', 'href' => route('rooms.create')],
        ['key' => 'rooms', 'label' => 'My Rooms', 'icon' => 'fa-building', 'href' => route('owner.dashboard') . '#my-rooms'],
        ['key' => 'plans', 'label' => 'Plans & Pricing', 'icon' => 'fa-tags', 'href' => route('plans')],
        ['key' => 'profile', 'label' => 'Profile Settings', 'icon' => 'fa-user-gear', 'href' => route('profile.edit')],
    ];
    $ownerLogo = \App\Models\Setting::get('navbar_logo') ?: \App\Models\Setting::get('website_logo');
@endphp

@once
<style>
    .owner-workspace { background: #f8fafc; }
    .owner-workspace > .flex,
    .owner-workspace.flex { align-items: stretch; }
    .owner-workspace main { min-width: 0; }
    .owner-workspace .owner-page-header {
        background: #fff !important;
        color: #0f172a !important;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem !important;
    }
    .owner-workspace .owner-page-header p { color: #64748b !important; }
    .owner-workspace .rounded-\[2rem\],
    .owner-workspace .rounded-\[2\.5rem\] { border-radius: 1rem !important; }
    .owner-workspace .rounded-3xl { border-radius: .875rem !important; }
    .owner-workspace .p-8 { padding: 1.25rem !important; }
    .owner-workspace .p-6 { padding: 1rem !important; }
    .owner-workspace .p-12 { padding: 2rem !important; }
    .owner-workspace .mb-8 { margin-bottom: 1.25rem !important; }
    .owner-workspace .gap-8 { gap: 1.25rem !important; }
    .owner-workspace .space-y-8 > :not([hidden]) ~ :not([hidden]) { margin-top: 1.25rem !important; }
    .owner-workspace .text-3xl { font-size: 1.5rem !important; line-height: 2rem !important; }
    .owner-workspace .w-24.h-24 { width: 4rem !important; height: 4rem !important; }
    .owner-workspace input,
    .owner-workspace select,
    .owner-workspace textarea { border: 1px solid #e2e8f0 !important; border-radius: .75rem !important; }
    .owner-workspace input:focus,
    .owner-workspace select:focus,
    .owner-workspace textarea:focus { background: #fff !important; }
    .owner-workspace main button[type="submit"] { border-radius: .75rem !important; padding-top: .8rem !important; padding-bottom: .8rem !important; }
    .owner-room-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }
    .owner-room-form-grid > * { margin-top: 0 !important; min-width: 0; }
    .owner-room-form-grid > .owner-form-wide { grid-column: 1 / -1; }
    .owner-room-form-grid label[class*="p-10"],
    .owner-room-form-grid label[class*="p-8"] { padding: 1.5rem !important; }
    .owner-room-form-grid .h-80 { height: 15rem !important; }
    .owner-room-form-grid .min-h-\[300px\] { min-height: 15rem !important; }
    .owner-room-form-grid input[class*="py-4"],
    .owner-room-form-grid select[class*="py-4"],
    .owner-room-form-grid textarea[class*="py-4"] { padding-top: .7rem !important; padding-bottom: .7rem !important; }
    .owner-room-form-grid h3 { margin-bottom: 1rem !important; padding-bottom: .75rem !important; }
    @media (max-width: 1023px) {
        .owner-workspace .p-8,
        .owner-workspace .p-6 { padding: 1rem !important; }
        .owner-room-form-grid { display: block; }
        .owner-room-form-grid > * + * { margin-top: 1rem !important; }
    }
</style>
@endonce

<aside class="hidden lg:flex w-64 shrink-0 bg-white border-r border-slate-200 flex-col sticky top-16 h-[calc(100vh-4rem)]">
    <div class="px-5 py-5 border-b border-slate-100">
        <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3">
            @if($ownerLogo)
                <img src="{{ asset('storage/' . $ownerLogo) }}" alt="Owner panel" class="w-10 h-10 rounded-xl object-contain border border-slate-200 bg-white p-1">
            @else
                <span class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center">
                    <i class="fas fa-house"></i>
                </span>
            @endif
            <span class="min-w-0">
                <strong class="block text-sm text-slate-900 truncate">Owner Workspace</strong>
                <small class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Manage properties</small>
            </span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto p-3 space-y-1.5" aria-label="Owner navigation">
        @foreach($ownerItems as $item)
            @php $isActive = $activeOwnerSection === $item['key']; @endphp
            <a href="{{ $item['href'] }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ $isActive ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
               @if($isActive) aria-current="page" @endif>
                <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isActive ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                    <i class="fas {{ $item['icon'] }} text-xs"></i>
                </span>
                <span>{{ $item['label'] }}</span>
                @if($isActive)<i class="fas fa-chevron-right text-[9px] ml-auto"></i>@endif
            </a>
        @endforeach
    </nav>

    <div class="p-3 border-t border-slate-100">
        <div class="flex items-center gap-3 px-3 py-2 mb-1">
            <span class="w-9 h-9 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs">
                {{ strtoupper(substr($owner?->name ?? 'O', 0, 1)) }}
            </span>
            <span class="min-w-0">
                <strong class="block text-xs text-slate-800 truncate">{{ $owner?->name }}</strong>
                <small class="block text-[10px] text-slate-400 truncate">Property Owner</small>
            </span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                <span class="w-8 text-center"><i class="fas fa-right-from-bracket"></i></span>
                Logout
            </button>
        </form>
    </div>
</aside>
