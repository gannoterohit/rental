@extends('layouts.app')

@section('title', 'Create Offer')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.offers.index') }}" class="text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Offers
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Offer</h1>

            <form action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Offer Type</label>
                            <select name="type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="text_only" {{ old('type') == 'text_only' ? 'selected' : '' }}>Text Only (Classic Banner)</option>
                                <option value="image_only" {{ old('type') == 'image_only' ? 'selected' : '' }}>Image Only (Graphic Banner)</option>
                                <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both (Image + Text Overlay)</option>
                            </select>
                            @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Placement Location</label>
                            <select name="placement" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="dashboard" {{ old('placement') == 'dashboard' ? 'selected' : '' }}>Dashboard (User/Owner Home)</option>
                                <option value="top_nav" {{ old('placement') == 'top_nav' ? 'selected' : '' }}>Top Navigation (Announcement Bar)</option>
                                <option value="home_hero" {{ old('placement') == 'home_hero' ? 'selected' : '' }}>Home Page Hero (Main Carousel)</option>
                                <option value="sidebar" {{ old('placement') == 'sidebar' ? 'selected' : '' }}>Sidebar (Room Listings)</option>
                                <option value="popup" {{ old('placement') == 'popup' ? 'selected' : '' }}>Popup Modal (Timed Promotion)</option>
                            </select>
                            @error('placement')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="🎉 New Year Special - 50% OFF!">
                        @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                  placeholder="Describe the offer details...">{{ old('description') }}</textarea>
                        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Banner Image</label>
                            <input type="file" name="image" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Recommended: 1200x400 for Hero, 400x600 for Sidebar</p>
                            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Redirect URL (Optional)</label>
                            <input type="url" name="link_url" value="{{ old('link_url') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="https://example.com/promo">
                            @error('link_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Discount Text</label>
                            <input type="text" name="discount_text" value="{{ old('discount_text') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="50% OFF">
                            @error('discount_text')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Banner Color</label>
                            <input type="color" name="banner_color" value="{{ old('banner_color', \App\Models\Setting::get('primary_color', '#4F46E5')) }}" required
                                   class="w-full h-12 border border-gray-300 rounded-lg cursor-pointer">
                            @error('banner_color')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Target Audience</label>
                        <select name="target_audience" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="both" {{ old('target_audience') == 'both' ? 'selected' : '' }}>Both (Users & Owners)</option>
                            <option value="user" {{ old('target_audience') == 'user' ? 'selected' : '' }}>Users Only</option>
                            <option value="owner" {{ old('target_audience') == 'owner' ? 'selected' : '' }}>Owners Only</option>
                        </select>
                        @error('target_audience')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date (Optional)</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">End Date (Optional)</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" checked
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition">
                            <i class="fas fa-save mr-2"></i>Create Offer
                        </button>
                        <a href="{{ route('admin.offers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
