@extends('layouts.app')

@section('title', 'My Wallet')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">My Wallet</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Points Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl shadow-lg p-6 text-white text-center">
                <i class="fas fa-coins text-4xl mb-3 opacity-80"></i>
                <h2 class="text-lg font-semibold opacity-90">Referral Points</h2>
                <p class="text-4xl font-bold mt-2">{{ number_format($user->wallet) }}</p>
                <p class="text-sm mt-2 opacity-75">1000 Points = ₹10</p>
            </div>

            <!-- Balance Card -->
            <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-xl shadow-lg p-6 text-white text-center">
                <i class="fas fa-wallet text-4xl mb-3 opacity-80"></i>
                <h2 class="text-lg font-semibold opacity-90">Wallet Balance</h2>
                <p class="text-4xl font-bold mt-2">₹{{ number_format($user->wallet_balance, 2) }}</p>
                <p class="text-sm mt-2 opacity-75">Use for Listings & Unlocks</p>
            </div>
        </div>

        <!-- Conversion Section -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Convert Points to Balance</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('wallet.convert') }}" method="POST" class="max-w-md mx-auto">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Points to Convert</label>
                    <input type="number" name="points" min="1000" step="1000" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter points (min 1000)">
                    <p class="text-xs text-gray-500 mt-1">Minimum 1000 points required.</p>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition">
                    Convert to Balance
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
