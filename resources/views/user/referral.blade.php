@extends('layouts.app')

@section('title', 'Refer & Earn - ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-slate-900 mb-4">Refer & <span class="text-indigo-600">Earn Points</span></h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Invite your friends to find their perfect home and get rewarded with points you can use for free listings and contact unlocks!</p>
        </div>

        <!-- Main Stats Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-2xl mb-4">
                        <i class="fas fa-coins text-indigo-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">{{ number_format($user->wallet, 0) }}</div>
                    <div class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Points</div>
                </div>
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-2xl mb-4">
                        <i class="fas fa-users text-emerald-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">{{ $referrals->count() }}</div>
                    <div class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Referrals</div>
                </div>
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-2xl mb-4">
                        <i class="fas fa-gift text-amber-600 text-xl"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">{{ number_format($referrals->count() * $refReward, 0) }}</div>
                    <div class="text-sm font-medium text-slate-500 uppercase tracking-wider">Points Earned</div>
                </div>
            </div>
        </div>

        <!-- Referral Link Card -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-3xl shadow-2xl p-8 text-white mb-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold mb-2">Share the love!</h2>
                    <p class="text-indigo-100">Send this link to your friends. When they register, you get {{ $refReward }} points and they get {{ $joinReward }} points!</p>
                </div>
                <div class="w-full md:w-auto space-y-4">
                    <div class="relative">
                        <input type="text" readonly value="{{ $referralLink }}" id="referralLink" 
                               class="w-full md:w-80 bg-white/10 border border-white/20 rounded-2xl py-4 px-6 text-white placeholder-white/50 focus:outline-none focus:ring-2 ring-white/50 pr-12 text-sm">
                        <button onclick="copyLink()" class="absolute right-4 top-1/2 -translate-y-1/2 hover:text-indigo-200 transition">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <div class="flex gap-4">
                        <a href="https://wa.me/?text={{ urlencode('Bhai, is website pe acche rooms mil rahe hain! Mere link se join kar toh tujhe bhi ' . $joinReward . ' Points milenge: ' . $referralLink) }}" target="_blank"
                           class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-6 rounded-2xl text-center transition flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp
                        </a>
                        <button onclick="copyLink()" class="flex-1 bg-white text-indigo-600 font-bold py-3 px-6 rounded-2xl text-center transition hover:bg-indigo-50">
                            Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral Table -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <div class="p-8 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-900">Your Referrals</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Friend Name</th>
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Joined Date</th>
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Points Earned</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($referrals as $referral)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($referral->name, 0, 1) }}
                                    </div>
                                    <div class="font-bold text-slate-900">{{ $referral->name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-slate-600 font-medium">
                                {{ $referral->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-bold">
                                    +{{ $refReward }} Points
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400 font-medium">
                                No referrals yet. Start sharing to earn points!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink() {
    var copyText = document.getElementById("referralLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    // Show Toastr notification
    if(typeof toastr !== 'undefined') {
        toastr.success('Referral link copied to clipboard!');
    } else {
        alert('Copied to clipboard!');
    }
}
</script>
@endsection
