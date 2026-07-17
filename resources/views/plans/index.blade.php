@extends(request()->routeIs('admin.*') ? 'layouts.admin' : 'layouts.app')

@section('title', 'Subscription Plans - RoomRental')

@section(request()->routeIs('admin.*') ? 'admin-content' : 'content')
@push('head')
    @include('partials.plans-ld')
@endpush
@if(!request()->routeIs('admin.*') && Auth::check() && in_array(Auth::user()->role, ['user', 'owner']))
    <div class="{{ Auth::user()->role === 'owner' ? 'owner-workspace' : 'user-workspace' }} min-h-screen bg-slate-50 flex">
        @if(Auth::user()->role === 'owner')
            @include('owner.partials.sidebar', ['active' => 'plans'])
        @else
            @include('user.partials.sidebar', ['active' => 'plans'])
        @endif
        <main class="flex-1 min-w-0">
@endif
<div class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12 md:py-16 mb-8 relative overflow-hidden border-b border-slate-200">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-64 h-64 md:w-96 md:h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    </div>
    <div class="container mx-auto px-3 md:px-4 relative z-10">
        <div class="text-center">
            <div class="inline-block bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-full p-3 md:p-6 mb-4 md:mb-6 shadow-lg">
                <i class="fas fa-tags text-3xl md:text-6xl text-white"></i>
            </div>
            <h1 class="text-3xl md:text-5xl lg:text-7xl font-black mb-4 md:mb-6 text-slate-800">
                Subscription Plans
            </h1>
            @if(Auth::check() && Auth::user()->role === 'user')
                <p class="text-base md:text-xl lg:text-2xl text-slate-600 max-w-2xl lg:max-w-3xl mx-auto font-medium">Choose a plan to unlock multiple room contacts - Lifetime validity, count-based</p>
            @elseif(Auth::check() && Auth::user()->role === 'owner')
                <p class="text-base md:text-xl lg:text-2xl text-slate-600 max-w-2xl lg:max-w-3xl mx-auto font-medium">Choose a plan to list multiple rooms - Lifetime validity, count-based</p>
            @else
                <p class="text-base md:text-xl lg:text-2xl text-slate-600 max-w-2xl lg:max-w-3xl mx-auto font-medium">Choose a subscription plan to save money</p>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
</style>

<div class="container mx-auto px-3 md:px-4 pb-8 md:pb-12">
    <!-- Offer Banners -->
    @include('partials.offer-banner')

    @if(isset($listingPlans) && $listingPlans->count() > 0)
        <div class="mb-12 md:mb-16">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-900 mb-3 md:mb-4 text-center flex items-center justify-center">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg p-2 md:p-3 mr-2 md:mr-4">
                    <i class="fas fa-home text-white text-lg md:text-2xl"></i>
                </div>
                Room Listing Plans
            </h2>
            <p class="text-center text-gray-600 mb-6 md:mb-10 text-sm md:text-base lg:text-lg font-semibold">List multiple rooms and save money - Lifetime validity, count-based</p>
            
            <!-- Mobile Grid (1 column) -->
            <div class="md:hidden space-y-4">
                @foreach($listingPlans as $plan)
                    <div class="group bg-white rounded-xl shadow-lg border border-gray-200 hover:border-indigo-400 transition-all duration-300 transform hover:scale-[1.02] overflow-hidden">
                        <div class="bg-gradient-to-br from-indigo-500 via-cyan-500 to-amber-400 text-white p-4 md:p-6 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                            <div class="relative z-10">
                                <h3 class="text-lg md:text-xl font-black mb-2 text-white">{{ $plan->name }}</h3>
                                <div class="text-3xl md:text-4xl font-black mb-1 text-white">₹{{ number_format($plan->price) }}</div>
                                <p class="text-white/90 text-xs md:text-sm font-semibold">Lifetime Validity</p>
                            </div>
                        </div>
                        
                        <div class="p-3 md:p-4">
                            <div class="mb-3 md:mb-4">
                                <div class="flex items-center justify-center mb-3 md:mb-4">
                                    <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl p-3 md:p-4 transform group-hover:rotate-6 transition-transform">
                                        <i class="fas fa-home text-2xl md:text-3xl text-blue-600"></i>
                                    </div>
                                </div>
                                <p class="text-center text-xl md:text-2xl font-black text-gray-900 mb-2">
                                    {{ $plan->listing_limit == -1 ? 'Unlimited' : $plan->listing_limit }} Rooms
                                </p>
                                <p class="text-center text-gray-600 text-sm md:text-base font-semibold">
                                    {{ $plan->listing_limit == -1 ? 'List unlimited rooms' : 'List ' . $plan->listing_limit . ' rooms or make available' }}
                                </p>
                            </div>

                            @if($plan->benefits && is_array($plan->benefits))
                            <ul class="space-y-2 md:space-y-3 mb-4 md:mb-6">
                                @foreach($plan->benefits as $benefit)
                                    <li class="flex items-start text-gray-800 text-sm md:text-base font-semibold">
                                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-full p-1 mr-2 mt-0.5 flex-shrink-0">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @endif

                            <div class="text-center mb-4 md:mb-6 bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-3 md:p-4 border border-gray-200">
                                <p class="text-xs md:text-sm text-gray-600 font-semibold mb-1">
                                    Single listing: ₹{{ \App\Models\Setting::get('listing_fee', 199) }} × {{ $plan->listing_limit }} = ₹{{ $plan->listing_limit * \App\Models\Setting::get('listing_fee', 199) }}
                                </p>
                                <p class="text-green-600 font-black text-lg md:text-xl">
                                    Save ₹{{ ($plan->listing_limit * \App\Models\Setting::get('listing_fee', 199)) - $plan->price }}
                                </p>
                            </div>

                            @auth
                                @if(Auth::user()->role === 'owner')
                                    <button onclick="openPaymentModal({{ $plan->id }})" 
                                            class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-black py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm md:text-base">
                                        <i class="fas fa-shopping-cart mr-1 md:mr-2"></i>Purchase Plan
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white text-center font-black py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl text-sm md:text-base">
                                    <i class="fas fa-sign-in-alt mr-1 md:mr-2"></i>Login to Purchase
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Desktop Grid (3 columns) -->
            <div class="hidden md:grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                @foreach($listingPlans as $plan)
                    <div class="group bg-white rounded-2xl shadow-xl border-2 border-gray-200 hover:border-indigo-500 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl overflow-hidden">
                        <div class="bg-gradient-to-br from-indigo-500 via-cyan-500 to-amber-400 text-white p-6 md:p-8 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="relative z-10">
                                <h3 class="text-xl md:text-2xl font-black mb-3 text-white">{{ $plan->name }}</h3>
                                <div class="text-4xl md:text-5xl font-black mb-2 text-white">₹{{ number_format($plan->price) }}</div>
                                <p class="text-white/90 text-sm md:text-base font-semibold">Lifetime Validity</p>
                            </div>
                        </div>
                        
                        <div class="p-4 md:p-5">
                            <div class="mb-4 md:mb-5">
                                <div class="flex items-center justify-center mb-4 md:mb-6">
                                    <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl p-5 md:p-6 transform group-hover:rotate-12 transition-transform">
                                        <i class="fas fa-home text-3xl md:text-4xl text-blue-600"></i>
                                    </div>
                                </div>
                                <p class="text-center text-2xl md:text-3xl font-black text-gray-900 mb-3">
                                    {{ $plan->listing_limit }} Rooms
                                </p>
                                <p class="text-center text-gray-600 text-base md:text-lg font-semibold">
                                    List {{ $plan->listing_limit }} rooms or make available
                                </p>
                            </div>

                            @if($plan->benefits && is_array($plan->benefits))
                            <ul class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                                @foreach($plan->benefits as $benefit)
                                    <li class="flex items-center text-gray-800 text-base md:text-lg font-semibold">
                                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-full p-1.5 mr-3">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        {{ $benefit }}
                                    </li>
                                @endforeach
                            </ul>
                            @endif

                            <div class="text-center mb-6 md:mb-8 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-4 md:p-5 border-2 border-gray-200">
                                <p class="text-sm md:text-base text-gray-600 font-semibold mb-2">
                                    Single listing: ₹{{ \App\Models\Setting::get('listing_fee', 199) }} × {{ $plan->listing_limit }} = ₹{{ $plan->listing_limit * \App\Models\Setting::get('listing_fee', 199) }}
                                </p>
                                <p class="text-green-600 font-black text-xl md:text-2xl">
                                    Save ₹{{ ($plan->listing_limit * \App\Models\Setting::get('listing_fee', 199)) - $plan->price }}
                                </p>
                            </div>

                            @auth
                                @if(Auth::user()->role === 'owner')
                                    <button onclick="openPaymentModal({{ $plan->id }})" 
                                            class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-black py-3 md:py-4 px-6 rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 text-base md:text-lg">
                                        <i class="fas fa-shopping-cart mr-2"></i>Purchase Plan
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white text-center font-black py-3 md:py-4 px-6 rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl text-base md:text-lg">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Purchase
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(isset($contactPlans) && $contactPlans->count() > 0)
        <div class="mb-12 md:mb-16">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-900 mb-3 md:mb-4 text-center flex items-center justify-center">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-2 md:p-3 mr-2 md:mr-4">
                    <i class="fas fa-unlock text-white text-lg md:text-2xl"></i>
                </div>
                Contact Unlock Plans
            </h2>
            <p class="text-center text-gray-600 mb-6 md:mb-10 text-sm md:text-base lg:text-lg font-semibold">Unlock multiple room contacts and save money - Lifetime validity, count-based</p>
            
            <!-- Mobile Grid (1 column) -->
            <div class="md:hidden space-y-4">
                @foreach($contactPlans as $plan)
                <div class="group bg-white rounded-xl shadow-lg border border-gray-200 hover:border-purple-400 transition-all duration-300 transform hover:scale-[1.02] overflow-hidden">
                    <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 text-white p-4 md:p-6 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                        <div class="relative z-10">
                            <h3 class="text-lg md:text-xl font-black mb-2">{{ $plan->name }}</h3>
                            <div class="text-3xl md:text-4xl font-black mb-1">₹{{ number_format($plan->price) }}</div>
                            <p class="text-purple-100 text-xs md:text-sm font-semibold">Lifetime Validity</p>
                        </div>
                    </div>
                    
                    <div class="p-4 md:p-6">
                        <div class="mb-4 md:mb-6">
                            <div class="flex items-center justify-center mb-3 md:mb-4">
                                <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl p-3 md:p-4 transform group-hover:rotate-6 transition-transform">
                                    <i class="fas fa-unlock text-2xl md:text-3xl text-purple-600"></i>
                                </div>
                            </div>
                            <p class="text-center text-xl md:text-2xl font-black text-gray-900 mb-2">
                                {{ $plan->contacts_limit }} Contacts
                            </p>
                            <p class="text-center text-gray-600 text-sm md:text-base font-semibold">
                                Unlock {{ $plan->contacts_limit }} room owner contacts
                            </p>
                        </div>

                        @if($plan->benefits && is_array($plan->benefits))
                        <ul class="space-y-2 md:space-y-3 mb-4 md:mb-6">
                            @foreach($plan->benefits as $benefit)
                                <li class="flex items-start text-gray-800 text-sm md:text-base font-semibold">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-full p-1 mr-2 mt-0.5 flex-shrink-0">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <span>{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                        @endif

                        <div class="text-center mb-4 md:mb-6 bg-gradient-to-br from-gray-50 to-purple-50 rounded-xl p-3 md:p-4 border border-gray-200">
                            <p class="text-xs md:text-sm text-gray-600 font-semibold mb-1">
                                Single unlock: ₹{{ \App\Models\Setting::get('unlock_fee', 49) }} × {{ $plan->contacts_limit }} = ₹{{ $plan->contacts_limit * \App\Models\Setting::get('unlock_fee', 49) }}
                            </p>
                            <p class="text-green-600 font-black text-lg md:text-xl">
                                Save ₹{{ ($plan->contacts_limit * \App\Models\Setting::get('unlock_fee', 49)) - $plan->price }}
                            </p>
                        </div>

                        @auth
                            @if(Auth::user()->role === 'user')
                                <button onclick="openPaymentModal({{ $plan->id }})" 
                                        class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-black py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm md:text-base">
                                    <i class="fas fa-shopping-cart mr-1 md:mr-2"></i>Purchase Plan
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white text-center font-black py-2.5 md:py-3 px-4 md:px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl text-sm md:text-base">
                                <i class="fas fa-sign-in-alt mr-1 md:mr-2"></i>Login to Purchase
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Desktop Grid (2 columns) -->
            <div class="hidden md:grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-5xl mx-auto">
                @foreach($contactPlans as $plan)
                <div class="group bg-white rounded-2xl shadow-xl border-2 border-gray-200 hover:border-purple-500 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 text-white p-6 md:p-8 text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <h3 class="text-xl md:text-2xl font-black mb-3">{{ $plan->name }}</h3>
                            <div class="text-4xl md:text-5xl font-black mb-2">₹{{ number_format($plan->price) }}</div>
                            <p class="text-purple-100 text-sm md:text-base font-semibold">Lifetime Validity</p>
                        </div>
                    </div>
                    
                    <div class="p-6 md:p-8">
                        <div class="mb-6 md:mb-8">
                            <div class="flex items-center justify-center mb-4 md:mb-6">
                                <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl p-5 md:p-6 transform group-hover:rotate-12 transition-transform">
                                    <i class="fas fa-unlock text-3xl md:text-4xl text-purple-600"></i>
                                </div>
                            </div>
                            <p class="text-center text-2xl md:text-3xl font-black text-gray-900 mb-3">
                                {{ $plan->contacts_limit == -1 ? 'Unlimited' : $plan->contacts_limit }} Contacts
                            </p>
                            <p class="text-center text-gray-600 text-base md:text-lg font-semibold">
                                {{ $plan->contacts_limit == -1 ? 'Unlock unlimited contacts' : 'Unlock ' . $plan->contacts_limit . ' room owner contacts' }}
                            </p>
                        </div>

                        @if($plan->benefits && is_array($plan->benefits))
                        <ul class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                            @foreach($plan->benefits as $benefit)
                                <li class="flex items-center text-gray-800 text-base md:text-lg font-semibold">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-full p-1.5 mr-3">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    {{ $benefit }}
                                </li>
                            @endforeach
                        </ul>
                        @endif

                        <div class="text-center mb-6 md:mb-8 bg-gradient-to-br from-gray-50 to-purple-50 rounded-2xl p-4 md:p-5 border-2 border-gray-200">
                            <p class="text-sm md:text-base text-gray-600 font-semibold mb-2">
                                Single unlock: ₹{{ \App\Models\Setting::get('unlock_fee', 49) }} × {{ $plan->contacts_limit }} = ₹{{ $plan->contacts_limit * \App\Models\Setting::get('unlock_fee', 49) }}
                            </p>
                            <p class="text-green-600 font-black text-xl md:text-2xl">
                                Save ₹{{ ($plan->contacts_limit * \App\Models\Setting::get('unlock_fee', 49)) - $plan->price }}
                            </p>
                        </div>

                        @auth
                            @if(Auth::user()->role === 'user')
                                <button onclick="openPaymentModal({{ $plan->id }})" 
                                        class="w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-black py-3 md:py-4 px-6 rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl transform hover:scale-105 text-base md:text-lg">
                                    <i class="fas fa-shopping-cart mr-2"></i>Purchase Plan
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white text-center font-black py-3 md:py-4 px-6 rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl text-base md:text-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login to Purchase
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-10 md:py-16 bg-white rounded-xl md:rounded-2xl shadow-lg">
            <i class="fas fa-tags text-4xl md:text-6xl lg:text-8xl text-gray-300 mb-4 md:mb-6"></i>
            <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 md:mb-3">No Plans Available</h3>
            <p class="text-gray-600 text-sm md:text-base">Contact subscription plans will be available soon.</p>
        </div>
    @endif

    @if(isset($plans) && Auth::check() && Auth::user()->role === 'admin')
        <!-- User Plans Section -->
        <div class="mt-8 md:mt-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-2 mr-3">
                        <i class="fas fa-unlock text-white"></i>
                    </div>
                    User Plans (Contact Unlocks)
                </h2>
                <a href="{{ route('admin.plans.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-semibold transition shadow-lg hover:shadow-xl text-sm md:text-base">
                    <i class="fas fa-plus mr-2"></i>Add New Plan
                </a>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-purple-50">
                            <tr>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Name</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Price</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Duration</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Contacts Limit</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Status</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plans->where('type', 'user') as $plan)
                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                <td class="p-3 md:p-4 font-semibold text-sm md:text-base">{{ $plan->name }}</td>
                                <td class="p-3 md:p-4 text-sm md:text-base">₹{{ number_format($plan->price) }}</td>
                                <td class="p-3 md:p-4 text-sm md:text-base">{{ $plan->duration_days }} days</td>
                                <td class="p-3 md:p-4 text-sm md:text-base">
                                    <span class="font-bold text-purple-600">
                                        {{ $plan->contacts_limit == -1 ? 'Unlimited' : $plan->contacts_limit }} Contacts
                                    </span>
                                </td>
                                <td class="p-3 md:p-4 text-sm md:text-base">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $plan->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="p-3 md:p-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.plans.toggleActive', $plan) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-{{ $plan->is_active ? 'orange' : 'green' }}-500 hover:bg-{{ $plan->is_active ? 'orange' : 'green' }}-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                <i class="fas fa-{{ $plan->is_active ? 'ban' : 'check' }}"></i> {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>No User plans created yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Owner Plans Section -->
        <div class="mt-8 md:mt-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg p-2 mr-3">
                        <i class="fas fa-home text-white"></i>
                    </div>
                    Owner Plans (Room Listings)
                </h2>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Name</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Price</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Duration</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Listing Limit</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Status</th>
                                <th class="p-3 md:p-4 text-left font-semibold text-gray-700 text-sm md:text-base">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plans->where('type', 'owner') as $plan)
                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                <td class="p-3 md:p-4 font-semibold text-sm md:text-base">{{ $plan->name }}</td>
                                <td class="p-3 md:p-4 text-sm md:text-base">₹{{ number_format($plan->price) }}</td>
                                <td class="p-3 md:p-4 text-sm md:text-base">{{ $plan->duration_days }} days</td>
                                <td class="p-3 md:p-4 text-sm md:text-base">
                                    <span class="font-bold text-blue-600">
                                        {{ $plan->listing_limit == -1 ? 'Unlimited' : $plan->listing_limit }} Rooms
                                    </span>
                                </td>
                                <td class="p-3 md:p-4 text-sm md:text-base">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $plan->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="p-3 md:p-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.plans.edit', $plan) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.plans.toggleActive', $plan) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-{{ $plan->is_active ? 'orange' : 'green' }}-500 hover:bg-{{ $plan->is_active ? 'orange' : 'green' }}-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                <i class="fas fa-{{ $plan->is_active ? 'ban' : 'check' }}"></i> {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>No Owner plans created yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Payment Selection Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-black text-gray-900">Select Payment Method</h3>
            <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <!-- Wallet Payment Option -->
            <button onclick="purchaseWithMethod('wallet')" class="w-full group relative overflow-hidden bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl p-5 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-white/20 rounded-full p-3">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <div class="font-black text-lg">Pay with Wallet</div>
                            <div class="text-sm text-white/90">Balance: ₹{{ Auth::check() ? Auth::user()->wallet_balance : 0 }}</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-xl group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>

            <!-- Online Payment Option -->
            <button onclick="purchaseWithMethod('online')" class="w-full group relative overflow-hidden bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl p-5 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-white/20 rounded-full p-3">
                            <i class="fas fa-credit-card text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <div class="font-black text-lg">Pay Online</div>
                            <div class="text-sm text-white/90">UPI, Card, Net Banking</div>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-xl group-hover:translate-x-1 transition-transform"></i>
                </div>
            </button>
        </div>
    </div>
</div>

@if(!request()->routeIs('admin.*') && Auth::check() && in_array(Auth::user()->role, ['user', 'owner']))
        </main>
    </div>
@endif

@push('scripts')
@auth
<script>
const razorpayKey = '{{ \App\Models\Setting::get("razorpay_key", "") }}';

let selectedPlanId = null;

function openPaymentModal(planId) {
    selectedPlanId = planId;
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    selectedPlanId = null;
}

async function purchaseWithMethod(paymentMethod) {
    console.log('Purchase with method called. Selected plan ID:', selectedPlanId);
    if (!selectedPlanId) {
        toastr.error('Please select a plan first', 'Error');
        return;
    }
    
    // Store the plan ID before closing modal (which resets it to null)
    const planIdToUse = selectedPlanId;
    closePaymentModal();
    
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        const requestBody = { 
            plan_id: planIdToUse,
            payment_method: paymentMethod
        };
        console.log('Sending request with body:', requestBody);
        
        const response = await fetch('{{ route("subscription.purchase") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestBody),
            credentials: 'same-origin'
        });
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({ message: 'Failed to purchase subscription' }));
            throw new Error(errorData.message || 'Failed to purchase subscription');
        }
        
        const data = await response.json();
        
        if (data.success) {
            if (data.wallet_used) {
                toastr.success('Subscription activated successfully using wallet!', 'Success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else if (data.payment_id) {
                await initiatePayment(data.payment_id, data.amount, 'subscription', data.subscription_id);
            } else {
                toastr.success('Subscription activated successfully!', 'Success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        } else {
            toastr.error(data.message || 'Failed to purchase subscription', 'Error');
        }
    } catch (error) {
        console.error('Error:', error);
        toastr.error(error.message || 'Something went wrong', 'Error');
    }
}

async function initiatePayment(paymentId, amount, type, referenceId) {
        try {
            // Lazy load Razorpay SDK
            const Razorpay = await loadRazorpaySDK();

            if (!razorpayKey || razorpayKey === '' || razorpayKey === 'null') {
                toastr.error('Razorpay key not configured. Please add it in Business Settings.', 'Error');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            const orderResponse = await fetch('{{ route("razorpay.createOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ amount }),
                credentials: 'same-origin'
            });
            
            if (!orderResponse.ok) {
                const errorData = await orderResponse.json().catch(() => ({ message: 'Failed to create order' }));
                throw new Error(errorData.message || 'Failed to create order');
            }
            
            const orderData = await orderResponse.json();
            
            if (!orderData.success || !orderData.order_id) {
                throw new Error(orderData.message || 'Failed to create order');
            }
            
            const options = {
                key: razorpayKey,
                amount: orderData.amount * 100,
                currency: 'INR',
                name: '{{ \App\Models\Setting::get("website_name", "RoomRental") }}',
                description: 'Subscription Plan Purchase',
                order_id: orderData.order_id,
                handler: async function(response) {
                    try {
                        const verifyResponse = await fetch('{{ route("razorpay.verify") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                ...response,
                                payment_id: paymentId,
                                type: type,
                                reference_id: referenceId
                            }),
                            credentials: 'same-origin'
                        });
                        
                        if (!verifyResponse.ok) {
                            const errorData = await verifyResponse.json().catch(() => ({ message: 'Payment verification failed' }));
                            throw new Error(errorData.message || 'Payment verification failed');
                        }
                        
                        const verifyData = await verifyResponse.json();
                        
                        if (verifyData.status === 'success') {
                            toastr.success('Payment successful! Subscription activated.', 'Success');
                            setTimeout(() => {
                                window.location.href = '{{ route("dashboard") }}';
                            }, 1500);
                        } else {
                            toastr.error(verifyData.message || 'Payment verification failed', 'Error');
                        }
                    } catch (error) {
                        console.error('Verification error:', error);
                        toastr.error(error.message || 'Payment verification failed', 'Error');
                    }
                },
                prefill: {
                    name: '{{ Auth::user()->name ?? "" }}',
                    email: '{{ Auth::user()->email ?? "" }}'
                },
                theme: {
                    color: '#9333ea'
                },
                method: {
                    upi: true,
                    card: true,
                    netbanking: true,
                    wallet: true
                }
            };
            
            const razorpay = new Razorpay(options);
            razorpay.on('payment.failed', function(response) {
                toastr.error('Payment failed: ' + (response.error.description || 'Unknown error'), 'Payment Failed');
            });
            razorpay.open();
            
        } catch (error) {
            console.error('Payment error:', error);
            toastr.error('Payment initialization failed: ' + error.message, 'Error');
        }
    }
    </script>
@endauth
@endpush
@endsection
