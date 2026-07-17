@extends('layouts.app')

@section('title', 'Profile - ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
@php
    $user = Auth::user();
    $unlockedCount = \App\Models\Enquiry::where('user_id', $user->id)->where('unlocked', true)->count();
    $wishlistCount = \App\Models\Wishlist::where('user_id', $user->id)->count();

@endphp

<div class="user-workspace min-h-screen bg-gray-50 flex flex-col lg:flex-row pb-20 lg:pb-0">
    @include('user.partials.sidebar', ['active' => 'dashboard'])

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-4 lg:p-8">
        <!-- Dynamic Offer Banners from Database -->
        @include('partials.offer-banner', ['placement' => 'dashboard'])
        
        <!-- Welcome Section (Hidden on Desktop) -->
        <div class="lg:hidden bg-white px-6 pt-8 pb-6 border-b border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-black text-gray-900">Profile</h1>
                <a href="{{ route('profile.edit') }}" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-600">
                     <i class="fas fa-pen text-sm"></i>
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-20 h-20 rounded-2xl object-cover border-4 border-indigo-50 shadow-xl">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white shadow-xl">
                            <i class="fas fa-user text-3xl"></i>
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm italic">{{ $user->email }}</p>
                </div>
            </div>
        </div>

       

        <!-- Desktop Header Card -->
        <div class="workspace-header hidden lg:block bg-white p-8 border-b border-gray-200">
            <div class="max-w-5xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-6">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-24 h-24 rounded-3xl object-cover border-4 border-indigo-50 shadow-xl">
                    @else
                        <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-white shadow-xl">
                            <i class="fas fa-user text-4xl"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-black text-gray-900">Welcome, {{ $user->name }}</h1>
                        <p class="text-gray-500 mt-1">Manage your properties, wishlist and account settings.</p>
                        <div class="mt-3 flex items-center gap-2">
                             <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $user->role }}</span>
                             @if($user->is_verified)
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Verified User</span>
                             @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>

        <div class="max-w-5xl mx-auto p-6 md:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Wallet & Stats -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Wallet Card -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-3xl p-6 text-white shadow-xl shadow-indigo-100 overflow-hidden relative">
                        <div class="absolute -right-8 -bottom-8 opacity-20 transform rotate-12">
                            <i class="fas fa-wallet text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest mb-1">My Balance</p>
                            <div class="flex items-end gap-1 mb-6">
                                <span class="text-3xl font-black text-white">₹{{ number_format($user->wallet_balance ?? 0, 2) }}</span>
                            </div>
                            <div class="flex flex-col gap-2">
                                 <a href="{{ route('wallet') }}" class="w-full bg-white/20 backdrop-blur-md px-4 py-3 rounded-2xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-white/30 transition text-center">
                                    <i class="fas fa-plus"></i> Recharge Wallet
                                 </a>
                                 <a href="{{ route('referral.index') }}" class="w-full bg-white text-indigo-600 px-4 py-3 rounded-2xl text-xs font-bold flex items-center justify-center gap-2 shadow-lg text-center">
                                    <i class="fas fa-gift"></i> Refer & Earn
                                 </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center gap-2">
                            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-xl">
                                <i class="fas fa-unlock"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">Unlocked</p>
                                <p class="text-2xl font-black text-gray-900">{{ $unlockedCount }}</p>
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center gap-2">
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 text-xl">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">Wishlist</p>
                                <p class="text-2xl font-black text-gray-900">{{ $wishlistCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Menu Grid -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- General Links -->
                    <div>
                        <h3 class="text-gray-900 font-black mb-4 flex items-center gap-2">
                             <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                             General Management
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $generalLinks = [
                                    ['label' => 'My Wishlist', 'desc' => 'Your saved room listings', 'icon' => 'fas fa-heart', 'color' => 'text-red-500', 'bg' => 'bg-red-50', 'href' => route('wishlist.index')],
                                    ['label' => 'Refer & Earn', 'desc' => 'Invite friends and get rewards', 'icon' => 'fas fa-gift', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50', 'href' => route('referral.index')],
                                    ['label' => 'Pricing Plans', 'desc' => 'View available membership plans', 'icon' => 'fas fa-tags', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50', 'href' => route('plans')],
                                    ['label' => 'Account Security', 'desc' => 'Manage password and privacy', 'icon' => 'fas fa-shield-alt', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50', 'href' => route('profile.edit')],
                                ];
                            @endphp

                            @foreach($generalLinks as $link)
                            <a href="{{ $link['href'] }}" class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition group flex items-start gap-4">
                                <div class="w-12 h-12 {{ $link['bg'] }} {{ $link['color'] }} rounded-2xl flex-shrink-0 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                                    <i class="{{ $link['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $link['label'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $link['desc'] }}</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-200 group-hover:text-indigo-300 transition-colors mt-1"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- App Information -->
                    <div>
                        <h3 class="text-gray-900 font-black mb-4 flex items-center gap-2">
                             <div class="w-2 h-6 bg-purple-500 rounded-full"></div>
                             Support & Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $infoLinks = [
                                    ['label' => 'Contact Us', 'desc' => 'Talk to our support team', 'icon' => 'fas fa-headset', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50', 'href' => route('pages.contact')],
                                    ['label' => 'About Us', 'desc' => 'Learn more about RoomRental', 'icon' => 'fas fa-info-circle', 'color' => 'text-purple-600', 'bg' => 'bg-purple-50', 'href' => '#'],
                                    ['label' => 'Privacy Policy', 'desc' => 'How we handle your data', 'icon' => 'fas fa-lock', 'color' => 'text-teal-600', 'bg' => 'bg-teal-50', 'href' => route('pages.privacy')],
                                    ['label' => 'Terms of Service', 'desc' => 'Our legal agreement', 'icon' => 'fas fa-file-contract', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50', 'href' => route('pages.terms')],
                                ];
                            @endphp

                            @foreach($infoLinks as $link)
                            <a href="{{ $link['href'] }}" class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition group flex items-start gap-4">
                                <div class="w-12 h-12 {{ $link['bg'] }} {{ $link['color'] }} rounded-2xl flex-shrink-0 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                                    <i class="{{ $link['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $link['label'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $link['desc'] }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sign Out -->
                    <div class="pt-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold py-4 px-6 rounded-3xl flex items-center justify-center gap-3 transition active:scale-95 shadow-sm shadow-red-100">
                                <i class="fas fa-sign-out-alt"></i> Sign Out from Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center py-10 text-gray-400 text-[10px] font-bold uppercase tracking-widest px-6">
            <p>© {{ date('Y') }} {{ \App\Models\Setting::get('website_name', 'RoomRental') }} • Standard License • v 1.0.0</p>
        </div>
    </main>
</div>
@endsection
