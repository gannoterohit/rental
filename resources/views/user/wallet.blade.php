@extends('layouts.app')
@section('title', 'My Wallet - ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
<div class="{{ $user->role === 'owner' ? 'owner-workspace' : 'user-workspace' }} min-h-screen bg-slate-50 flex">
    @if($user->role === 'owner') @include('owner.partials.sidebar', ['active' => 'wallet']) @else @include('user.partials.sidebar', ['active' => 'wallet']) @endif
    <main class="flex-1 min-w-0 pb-20 lg:pb-12">
        <header class="border-b border-slate-200 bg-white"><div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6"><p class="text-xs font-bold uppercase tracking-wider text-indigo-600">Payments & rewards</p><h1 class="mt-1 text-2xl font-extrabold text-slate-950">My Wallet</h1><p class="mt-1 text-sm text-slate-500">View reward points and available balance.</p></div></header>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))<div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800"><i class="fas fa-circle-check mr-2"></i>{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800"><i class="fas fa-circle-exclamation mr-2"></i>{{ session('error') }}</div>@endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <article class="relative overflow-hidden rounded-2xl bg-slate-950 p-6 text-white shadow-sm"><div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-indigo-500/20"></div><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-amber-300"><i class="fas fa-coins"></i></span><p class="mt-5 text-sm text-slate-300">Referral points</p><p class="mt-1 text-4xl font-extrabold">{{ number_format($user->wallet ?? 0) }}</p><p class="mt-3 text-xs text-slate-400">1,000 points = &#8377;10 wallet balance</p></article>
                <article class="relative overflow-hidden rounded-2xl bg-indigo-600 p-6 text-white shadow-sm"><div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/10"></div><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15"><i class="fas fa-wallet"></i></span><p class="mt-5 text-sm text-indigo-100">Available balance</p><p class="mt-1 text-4xl font-extrabold">&#8377;{{ number_format($user->wallet_balance ?? 0, 2) }}</p><p class="mt-3 text-xs text-indigo-100">Use for room listings, plans and unlocks.</p></article>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <section class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"><i class="fas fa-arrow-right-arrow-left"></i></span><div><h2 class="font-bold text-slate-950">Convert points</h2><p class="text-xs text-slate-500">Move eligible reward points into wallet balance.</p></div></div>
                    <form action="{{ route('wallet.convert') }}" method="POST" class="mt-6">@csrf
                        <label for="wallet-points" class="block text-sm font-bold text-slate-700">Points to convert</label>
                        <div class="mt-2 flex flex-col sm:flex-row gap-3"><input id="wallet-points" type="number" name="points" min="1000" step="1000" max="{{ max(1000, (int) $user->wallet) }}" required class="min-w-0 flex-1 rounded-xl border-slate-200 bg-slate-50 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Minimum 1,000 points"><button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white hover:bg-indigo-700">Convert to balance</button></div>
                        <p class="mt-2 text-xs text-slate-500">Available: {{ number_format($user->wallet ?? 0) }} points. Conversion must be in multiples of 1,000.</p>
                    </form>
                </section>
                <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">How it works</p><ol class="mt-5 space-y-4 text-sm text-slate-600"><li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600">1</span><span>Invite friends using your referral link.</span></li><li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600">2</span><span>Receive points after they join.</span></li><li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600">3</span><span>Convert points and use the balance.</span></li></ol><a href="{{ route('referral.index') }}" class="mt-6 flex items-center justify-center gap-2 rounded-xl bg-slate-100 py-3 text-sm font-bold text-slate-700 hover:bg-slate-200"><i class="fas fa-gift text-indigo-600"></i>Refer & Earn</a></aside>
            </div>
        </div>
    </main>
</div>
@endsection
