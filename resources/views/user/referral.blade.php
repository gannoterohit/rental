@extends('layouts.app')
@section('title', 'Refer & Earn - ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
<div class="{{ $user->role === 'owner' ? 'owner-workspace' : 'user-workspace' }} min-h-screen bg-slate-50 flex">
    @if($user->role === 'owner') @include('owner.partials.sidebar', ['active' => 'referral']) @else @include('user.partials.sidebar', ['active' => 'referral']) @endif
    <main class="flex-1 min-w-0 pb-20 lg:pb-12">
        <header class="border-b border-slate-200 bg-white"><div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6"><p class="text-xs font-bold uppercase tracking-wider text-indigo-600">Rewards program</p><h1 class="mt-1 text-2xl font-extrabold text-slate-950">Refer & Earn</h1><p class="mt-1 text-sm text-slate-500">Invite friends and earn points when they join.</p></div></header>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <section class="overflow-hidden rounded-2xl bg-slate-950 p-6 sm:p-8 text-white shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-7"><div class="max-w-xl"><span class="inline-flex rounded-full bg-indigo-500/20 px-3 py-1 text-xs font-bold text-indigo-200">Earn {{ $refReward }} points per referral</span><h2 class="mt-4 text-2xl sm:text-3xl font-extrabold">Share your link. Get rewarded.</h2><p class="mt-2 text-sm leading-6 text-slate-300">Your friend receives {{ $joinReward }} joining points, and you receive {{ $refReward }} points after registration.</p></div><div class="w-full lg:w-[420px]"><label class="text-xs font-bold uppercase tracking-wider text-slate-400">Your referral link</label><div class="mt-2 flex rounded-xl bg-white p-1.5"><input id="referralLink" type="text" readonly value="{{ $referralLink }}" class="min-w-0 flex-1 border-0 bg-transparent px-3 text-sm text-slate-700 focus:ring-0"><button type="button" onclick="copyLink()" class="shrink-0 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white">Copy</button></div><a href="https://wa.me/?text={{ urlencode('Find your next room on ' . \App\Models\Setting::get('website_name', 'RoomRental') . '. Join with my link and get ' . $joinReward . ' points: ' . $referralLink) }}" target="_blank" rel="noopener" class="mt-3 flex items-center justify-center gap-2 rounded-xl bg-emerald-500 py-3 text-sm font-bold text-white hover:bg-emerald-600"><i class="fa-brands fa-whatsapp"></i>Share on WhatsApp</a></div></div>
            </section>

            <section class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach([['Current points', number_format($user->wallet ?? 0), 'fa-coins', 'text-amber-600 bg-amber-50'], ['Friends joined', $referrals->count(), 'fa-users', 'text-emerald-600 bg-emerald-50'], ['Points earned', number_format($referrals->count() * $refReward), 'fa-gift', 'text-indigo-600 bg-indigo-50']] as $stat)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div class="flex items-start justify-between gap-3"><div><p class="text-xs font-semibold text-slate-500">{{ $stat[0] }}</p><p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $stat[1] }}</p></div><span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $stat[3] }}"><i class="fas {{ $stat[2] }}"></i></span></div></article>
                @endforeach
            </section>

            <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 sm:px-6 py-4"><div><h2 class="font-bold text-slate-950">Referral history</h2><p class="mt-0.5 text-xs text-slate-500">Friends who registered using your link.</p></div><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $referrals->count() }} total</span></div>
                <div class="overflow-x-auto"><table class="w-full text-left"><thead class="bg-slate-50"><tr><th class="px-5 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Friend</th><th class="px-5 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Joined</th><th class="px-5 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Reward</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse($referrals as $referral)<tr><td class="px-5 sm:px-6 py-4"><div class="flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-50 text-sm font-bold text-indigo-600">{{ strtoupper(substr($referral->name,0,1)) }}</span><span class="font-bold text-slate-900">{{ $referral->name }}</span></div></td><td class="px-5 sm:px-6 py-4 text-sm text-slate-600">{{ $referral->created_at->format('d M Y') }}</td><td class="px-5 sm:px-6 py-4"><span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">+{{ $refReward }} points</span></td></tr>@empty<tr><td colspan="3" class="px-6 py-14 text-center"><i class="fas fa-user-group text-3xl text-slate-300"></i><h3 class="mt-3 font-bold text-slate-900">No referrals yet</h3><p class="mt-1 text-sm text-slate-500">Share your link to invite your first friend.</p></td></tr>@endforelse</tbody></table></div>
            </section>
        </div>
    </main>
</div>

<script>
async function copyLink() {
    const input = document.getElementById('referralLink');
    try { await navigator.clipboard.writeText(input.value); if (typeof toastr !== 'undefined') toastr.success('Referral link copied!'); }
    catch (error) { input.select(); document.execCommand('copy'); if (typeof toastr !== 'undefined') toastr.success('Referral link copied!'); }
}
</script>
@endsection
