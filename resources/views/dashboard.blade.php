@extends('layouts.app')
@section('title', 'Dashboard - ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@push('styles')
<style>
    .user-quick-actions { background: #0f172a !important; color: #fff !important; }
    .user-quick-actions h2 { color: #fff !important; }
    .user-quick-primary { background: #fff !important; color: #0f172a !important; }
    .user-quick-primary span, .user-quick-primary i { color: inherit; }
    .user-quick-secondary { background: #1e293b !important; color: #fff !important; border: 1px solid #334155; }
    .user-quick-secondary span, .user-quick-secondary i { color: inherit; }
    .user-quick-primary:hover { background: #eef2ff !important; }
    .user-quick-secondary:hover { background: #334155 !important; }
</style>
@endpush

@section('content')
@php
    $user = Auth::user();
    $unlockedCount = \App\Models\Enquiry::where('user_id', $user->id)->where('unlocked', true)->count();
    $wishlistCount = \App\Models\Wishlist::where('user_id', $user->id)->count();
    $recentUnlocks = \App\Models\Enquiry::where('user_id', $user->id)->where('unlocked', true)->with('room')->latest()->take(4)->get();
@endphp

<div class="user-workspace min-h-screen bg-slate-50">
    @include('user.partials.sidebar', ['active' => 'dashboard'])
    <main class="pb-20 lg:pb-12">
        <header class="border-b border-slate-200 bg-white"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5"><div><p class="text-xs font-bold uppercase tracking-wider text-indigo-600">User dashboard</p><h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-slate-950">Welcome back, {{ $user->name }}</h1><p class="mt-2 text-sm text-slate-500">Find rooms, manage unlocked contacts and track your rewards.</p></div><a href="{{ route('rooms.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700"><i class="fas fa-magnifying-glass"></i>Browse Rooms</a></div></header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <section class="grid grid-cols-2 xl:grid-cols-4 gap-4">
                @foreach([['Wallet balance','₹'.number_format($user->wallet_balance ?? 0,2),'fa-wallet','bg-indigo-50 text-indigo-600'],['Reward points',number_format($user->wallet ?? 0),'fa-coins','bg-amber-50 text-amber-600'],['Unlocked rooms',$unlockedCount,'fa-lock-open','bg-emerald-50 text-emerald-600'],['Wishlist',$wishlistCount,'fa-heart','bg-rose-50 text-rose-600']] as $stat)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="flex items-start justify-between gap-3"><div><p class="text-xs font-semibold text-slate-500">{{ $stat[0] }}</p><p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $stat[1] }}</p></div><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $stat[3] }}"><i class="fas {{ $stat[2] }}"></i></span></div></article>
                @endforeach
            </section>

            <section class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <div id="unlocked" class="lg:col-span-2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4"><div><h2 class="font-bold text-slate-950">Recently unlocked rooms</h2><p class="mt-0.5 text-xs text-slate-500">Rooms whose owner contact you can access.</p></div><a href="{{ route('rooms.index') }}" class="text-sm font-bold text-indigo-600">Find more</a></div>
                    @forelse($recentUnlocks as $unlock)
                        @if($unlock->room)<div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 last:border-0"><div class="h-16 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100">@if($unlock->room->photo_url)<img src="{{ $unlock->room->photo_url }}" alt="" class="h-full w-full object-cover" onerror="this.style.display='none'">@else<div class="flex h-full items-center justify-center text-slate-300"><i class="fas fa-house"></i></div>@endif</div><div class="min-w-0 flex-1"><h3 class="truncate text-sm font-bold text-slate-900">{{ $unlock->room->title }}</h3><p class="mt-1 truncate text-xs text-slate-500"><i class="fas fa-location-dot mr-1 text-rose-400"></i>{{ $unlock->room->city }}</p><p class="mt-1 text-sm font-extrabold text-slate-900">₹{{ number_format($unlock->room->rent) }}<span class="text-xs font-normal text-slate-400">/month</span></p></div><a href="{{ route('rooms.show',$unlock->room) }}" class="rounded-xl bg-indigo-50 px-4 py-2 text-xs font-bold text-indigo-700">View contact</a></div>@endif
                    @empty<div class="px-6 py-14 text-center"><i class="fas fa-lock-open text-3xl text-slate-300"></i><h3 class="mt-3 font-bold text-slate-900">No rooms unlocked yet</h3><p class="mt-1 text-sm text-slate-500">Browse rooms and unlock the contacts you like.</p><a href="{{ route('rooms.index') }}" class="mt-4 inline-flex rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white">Browse rooms</a></div>@endforelse
                </div>

                <aside class="space-y-5">
                    <div class="user-quick-actions rounded-2xl p-5"><h2 class="font-bold">Quick actions</h2><div class="mt-4 space-y-2"><a href="{{ route('wishlist.index') }}" class="user-quick-primary flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold"><span><i class="fas fa-heart mr-2"></i>My Wishlist</span><i class="fas fa-arrow-right text-xs"></i></a><a href="{{ route('plans') }}" class="user-quick-secondary flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold"><span><i class="fas fa-tags mr-2"></i>Unlock Plans</span><i class="fas fa-arrow-right text-xs"></i></a><a href="{{ route('referral.index') }}" class="user-quick-secondary flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold"><span><i class="fas fa-gift mr-2"></i>Refer & Earn</span><i class="fas fa-arrow-right text-xs"></i></a></div></div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Account</p><div class="mt-3 flex items-center gap-3"><span class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-50 font-bold text-indigo-600">{{ strtoupper(substr($user->name,0,1)) }}</span><div class="min-w-0"><p class="truncate text-sm font-bold text-slate-900">{{ $user->name }}</p><p class="truncate text-xs text-slate-500">{{ $user->email }}</p></div></div><a href="{{ route('profile.edit') }}" class="mt-4 flex justify-center rounded-xl border border-slate-200 py-2.5 text-sm font-bold text-slate-700">Manage profile</a></div>
                </aside>
            </section>
        </div>
    </main>
</div>
@endsection
