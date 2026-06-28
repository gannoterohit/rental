@extends('layouts.app')

@section('title', 'Owner Dashboard - ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
@php
    $user = Auth::user();
    
    $ownerNavItems = [
        ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'href' => route('owner.dashboard'), 'active' => true],
        ['label' => 'List New Room', 'icon' => 'fas fa-plus-circle text-indigo-500', 'href' => route('rooms.create'), 'active' => false],
        ['label' => 'My Rooms', 'icon' => 'fas fa-home text-blue-500', 'href' => route('rooms.index'), 'active' => false],
        ['label' => 'Plans', 'icon' => 'fas fa-tags text-emerald-500', 'href' => route('plans'), 'active' => false],
        ['label' => 'Settings', 'icon' => 'fas fa-user-cog text-gray-500', 'href' => route('profile.edit'), 'active' => false],
    ];
@endphp

<div class="min-h-screen bg-gray-50 flex flex-col lg:flex-row pb-20 lg:pb-0">
    <!-- Desktop Sidebar (Hidden on Mobile) -->
    <aside class="hidden lg:flex w-64 bg-white shadow-sm border-r border-gray-200 flex-col h-screen sticky top-0">
        <div class="p-6 border-b">
            <h2 class="font-bold text-gray-900">Owner Panel</h2>
        </div>
        <nav class="flex-1 p-3 space-y-1">
            @foreach($ownerNavItems as $item)
                <a href="{{ $item['href'] }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ $item['active'] ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-gray-50 text-gray-700' }}">
                    <div class="w-6 h-6 flex items-center justify-center mr-3">
                        <i class="{{ $item['icon'] }} text-sm"></i>
                    </div>
                    <span class="font-medium">{{ $item['label'] }}</span>
                    @if($item['active'])
                        <i class="fas fa-chevron-right text-xs ml-auto text-indigo-400"></i>
                    @endif
                </a>
            @endforeach
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto">
        <div class="p-4 lg:p-8 pb-0">
            @include('partials.offer-banner', ['placement' => 'dashboard'])
        </div>
        <!-- Mobile Header (Hidden on Desktop) -->
        <div class="lg:hidden bg-white px-6 pt-8 pb-6 border-b border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-black text-gray-900">Dashboard</h1>
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
                            <i class="fas fa-user-circle text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm italic">Property Owner</p>
                </div>
            </div>
        </div>

        <!-- Desktop Header Card -->
        <div class="hidden lg:block bg-white p-8 border-b border-gray-200">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-6">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-24 h-24 rounded-3xl object-cover border-4 border-indigo-50 shadow-xl">
                    @else
                        <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-white shadow-xl">
                            <i class="fas fa-user-circle text-5xl"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-black text-gray-900">Welcome back, {{ $user->name }}!</h1>
                        <p class="text-gray-500 mt-1">Manage your properties, bookings, and subscription plans.</p>
                        <div class="mt-3 flex items-center gap-2">
                             <span class="bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Property Owner</span>
                             @if($user->is_verified)
                                <span class="bg-green-100 text-green-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Verified Account</span>
                             @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('rooms.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 flex items-center gap-2">
                        <i class="fas fa-plus"></i> List New Room
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto p-4 lg:p-8">
            <!-- Stats Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col items-center text-center gap-2 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-xl">
                        <i class="fas fa-home"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Rooms</p>
                        <p class="text-2xl font-black text-gray-900">{{ $rooms ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col items-center text-center gap-2 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 text-xl">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Bookings</p>
                        <p class="text-2xl font-black text-gray-900">{{ $bookings ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col items-center text-center gap-2 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600 text-xl">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Featured</p>
                        <p class="text-2xl font-black text-gray-900">{{ $featuredRooms ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col items-center text-center gap-2 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-xl">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Wallet</p>
                        <p class="text-2xl font-black text-gray-900">{{ number_format($user->wallet ?? 0) }} <span class="text-sm font-medium text-gray-500">pts</span></p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (Mobile Only) -->
            <div class="lg:hidden mb-10">
                <h3 class="text-gray-900 font-black mb-4 flex items-center gap-2 px-2">
                    <i class="fas fa-bolt text-yellow-500"></i> Quick Actions
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('rooms.create') }}" class="bg-indigo-600 p-6 rounded-[2rem] text-white shadow-xl shadow-indigo-100 flex flex-col items-center gap-3">
                        <i class="fas fa-plus-circle text-3xl"></i>
                        <span class="font-bold text-sm">List Room</span>
                    </a>
                    <a href="{{ route('plans') }}" class="bg-white p-6 rounded-[2rem] text-gray-900 shadow-sm border border-gray-100 flex flex-col items-center gap-3">
                        <i class="fas fa-gem text-3xl text-amber-500"></i>
                        <span class="font-bold text-sm">Upgrade</span>
                    </a>
                </div>
            </div>

            <!-- Rooms Section -->
            <div class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-xl font-black text-gray-900 flex items-center gap-2">
                        <i class="fas fa-home text-indigo-600"></i> Local Listings
                    </h2>
                    <a href="{{ route('rooms.index') }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest">View All</a>
                </div>

                @if(isset($myRooms) && $myRooms->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($myRooms as $room)
                            <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-50 hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group">
                                <!-- Image Section -->
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    @if($room->photo_url)
                                        <img src="{{ $room->photo_url }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                                    @else
                                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                            <i class="fas fa-image text-4xl"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                    
                                    <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between">
                                        <div class="bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20">
                                            <span class="text-white text-xs font-bold">₹{{ number_format($room->rent) }}<span class="text-[10px] opacity-75">/mo</span></span>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/20 backdrop-blur-md
                                                @if($room->status === 'active') bg-green-500/80 text-white
                                                @elseif($room->status === 'pending') bg-yellow-500/80 text-white
                                                @elseif($room->status === 'booked') bg-purple-500/80 text-white
                                                @else bg-red-500/80 text-white
                                                @endif">
                                                {{ $room->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Section -->
                                <div class="p-6">
                                    <h3 class="text-base font-bold text-gray-900 mb-1 line-clamp-1 group-hover:text-indigo-600 transition">{{ $room->title }}</h3>
                                    <p class="text-gray-400 text-xs flex items-center gap-1 mb-4">
                                        <i class="fas fa-map-marker-alt text-red-400"></i> {{ $room->city }}{{ ($room->state ?? $room->address) ? ', ' . ($room->state ?? Str::limit($room->address, 20)) : '' }}
                                    </p>
                                    
                                    <div class="grid grid-cols-2 gap-3">
                                        <a href="{{ route('rooms.show', $room) }}" class="bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold py-3 rounded-2xl text-xs flex items-center justify-center gap-2 transition active:scale-95">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('rooms.edit', $room) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold py-3 rounded-2xl text-xs flex items-center justify-center gap-2 transition active:scale-95">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>

                                    <!-- Status Management -->
                                    <div class="mt-3">
                                        @if($room->status === 'booked')
                                            <button onclick="markAvailable({{ $room->id }})" class="w-full bg-green-50 hover:bg-green-100 text-green-600 font-bold py-3 rounded-2xl text-xs flex items-center justify-center gap-2 transition active:scale-95">
                                                <i class="fas fa-check-circle"></i> Make Available
                                            </button>
                                        @elseif($room->status === 'active')
                                            <button onclick="markBooked({{ $room->id }})" class="w-full bg-purple-50 hover:bg-purple-100 text-purple-600 font-bold py-3 rounded-2xl text-xs flex items-center justify-center gap-2 transition active:scale-95">
                                                <i class="fas fa-lock"></i> Mark Booked
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-[2.5rem] p-12 text-center border border-dashed border-gray-200 shadow-sm">
                        <div class="w-20 h-20 bg-indigo-50 rounded-3xl flex items-center justify-center text-indigo-600 text-4xl mx-auto mb-6">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2">No listings yet</h3>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto">Start listing your property today and find the perfect tenants quickly.</p>
                        <a href="{{ route('rooms.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i> List Your First Room
                        </a>
                    </div>
                @endif
            </div>

            <!-- Account Menu (Mobile Only) -->
            <div class="lg:hidden mt-12 space-y-6">
                <div>
                    <h3 class="text-gray-900 font-black mb-4 flex items-center gap-2 px-2">
                        <i class="fas fa-cog text-gray-400"></i> Account Settings
                    </h3>
                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100">
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-5 hover:bg-gray-50 transition border-b border-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="font-bold text-gray-700">Personal Information</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                        </a>
                        <a href="{{ route('plans') }}" class="flex items-center justify-between p-5 hover:bg-gray-50 transition border-b border-gray-50">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                    <i class="fas fa-gem"></i>
                                </div>
                                <span class="font-bold text-gray-700">Subscription Plans</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center p-5 hover:bg-red-50 transition text-red-600">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <span class="font-bold">Log Out</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
const razorpayKey = '{{ \App\Models\Setting::get("razorpay_key", "") }}';
const OWNER_PRIMARY_COLOR = '{{ \App\Models\Setting::get("primary_color", "#4F46E5") }}';
const OWNER_SECONDARY_COLOR = '{{ \App\Models\Setting::get("secondary_color", "#10B981") }}';

async function markBooked(roomId) {
    const result = await Swal.fire({
        title: 'Mark as Booked?',
        text: "This room will be hidden from users.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: OWNER_PRIMARY_COLOR,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, mark it!'
    });

    if (!result.isConfirmed) return;
    
    try {
        const response = await fetch(`{{ route('rooms.markBooked', ':id') }}`.replace(':id', roomId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            Swal.fire(
                'Booked!',
                'Room has been marked as booked.',
                'success'
            ).then(() => {
                location.reload();
            });
        } else {
            toastr.error(data.message || 'Error');
        }
    } catch (error) {
        toastr.error('Something went wrong');
    }
}

async function markAvailable(roomId) {
    const result = await Swal.fire({
        title: 'Make Available?',
        text: "Making this room available will charge listing fee (if applicable).",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: OWNER_SECONDARY_COLOR,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Continue'
    });

    if (!result.isConfirmed) return;
    
    try {
        const response = await fetch(`{{ route('rooms.markAvailable', ':id') }}`.replace(':id', roomId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        if (data.success) {
            if (data.subscription_used) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Room made available using subscription!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else if (data.payment_id) {
                initiatePayment(data.payment_id, data.amount, 'listing', roomId);
            } else {
                Swal.fire({
                    title: 'Success!',
                    text: 'Room marked as available.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        } else {
            toastr.error(data.message || 'Error');
        }
    } catch (error) {
        toastr.error('Something went wrong');
    }
}

async function initiatePayment(paymentId, amount, type, referenceId) {
    // Lazy load Razorpay SDK
    const Razorpay = await loadRazorpaySDK();
    
    try {
        const csrfToken = '{{ csrf_token() }}';
        
        // 1. Create Order
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

        if (!orderResponse.ok) throw new Error('Failed to create order');
        const orderData = await orderResponse.json();
        
        if (!orderData.success || !orderData.order_id) {
            throw new Error(orderData.message || 'Order creation failed');
        }

        const options = {
            key: razorpayKey,
            amount: orderData.amount * 100,
            currency: 'INR',
            name: '{{ \App\Models\Setting::get("website_name", "RoomRental") }}',
            description: 'Listing Fee',
            order_id: orderData.order_id, // Critical for signature verification
            handler: async function(response) {
                // 2. Verify Payment (Fallback for non-redirect methods)
                try {
                    const verify = await fetch('{{ route("razorpay.verify") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id || orderData.order_id,
                            razorpay_signature: response.razorpay_signature,
                            payment_id: paymentId,
                            type: type,
                            reference_id: referenceId
                        })
                    });
                    
                    if (!verify.ok) throw new Error('Verification failed');
                    
                    const verifyData = await verify.json();
                    if (verifyData.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment successful!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        toastr.error(verifyData.message || 'Verification failed');
                    }
                } catch (err) {
                    console.error(err);
                    toastr.error('Payment verification failed');
                }
            },
            prefill: {
                name: '{{ Auth::user()->name }}',
                email: '{{ Auth::user()->email }}'
            },
            theme: {
                color: OWNER_PRIMARY_COLOR
            }
        };
        new Razorpay(options).open();
    } catch (error) {
        console.error('Payment error:', error);
        toastr.error(error.message || 'Payment initialization failed');
    }
}
</script>
@endpush
@endsection