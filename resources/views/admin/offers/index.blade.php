@extends('layouts.admin')

@section('title', 'Manage Offers')

@section('admin-content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Promotional Offers</h1>
            <a href="{{ route('admin.offers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition">
                <i class="fas fa-plus mr-2"></i>Create New Offer
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview / Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($offers as $offer)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($offer->image_path)
                                        <img src="{{ $offer->image_url }}" alt="" class="w-12 h-12 rounded object-cover mr-3 border">
                                    @else
                                        <div class="w-12 h-12 rounded mr-3 flex items-center justify-center text-white font-bold" style="background-color: {{ $offer->banner_color }}">
                                            {{ substr($offer->discount_text ?? $offer->title, 0, 2) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $offer->title }}</div>
                                        <div class="text-xs text-indigo-600 font-semibold">{{ strtoupper($offer->type) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ str_replace('_', ' ', ucfirst($offer->placement)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $offer->target_audience === 'user' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $offer->target_audience === 'owner' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $offer->target_audience === 'both' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ ucfirst($offer->target_audience) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($offer->start_date)
                                    {{ $offer->start_date->format('M d') }}
                                @else
                                    -
                                @endif
                                to
                                @if($offer->end_date)
                                    {{ $offer->end_date->format('M d, Y') }}
                                @else
                                    ∞
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $offer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $offer->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.offers.edit', $offer) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.offers.toggleActive', $offer) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-{{ $offer->is_active ? 'orange' : 'green' }}-600 hover:text-{{ $offer->is_active ? 'orange' : 'green' }}-900">
                                            <i class="fas fa-{{ $offer->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>No offers created yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
