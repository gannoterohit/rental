@extends('layouts.app')

@section('title', 'Business Settings')

@section('content')
@push('styles')
<style>
    /* Hide main site footer and mobile nav on settings page for better full-height layout */
    footer, .mobile-bottom-nav, #fixed-footer {
        display: none !important;
    }
</style>
@endpush
<!-- Alpine Data for Tabs -->
<div x-data="{ activeTab: 'general' }" class="flex flex-col h-[calc(100vh-64px)] bg-gray-50">
    
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm z-10 w-full">
        <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Business Settings</h1>
                <p class="text-gray-500 text-sm mt-1">Manage global configurations for your platform</p>
            </div>
             <div class="flex gap-3">
                 <form action="{{ route('admin.settings.ping') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center px-4 py-2 rounded-lg hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100" title="Notify Google/Bing about new content">
                        <i class="fas fa-satellite-dish mr-2"></i> Ping Search Engines
                    </button>
                </form>
                <button form="settings-form" type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-2 rounded-lg font-medium shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Layout Container -->
    <div class="flex flex-1 overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <div class="w-72 bg-white border-r border-gray-200 overflow-y-auto flex-shrink-0 py-6 px-4 hidden md:block">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Configuration Modules</p>
            <nav class="space-y-1">
                <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'general' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                        <i class="fas fa-sliders-h w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    General & Fees
                </button>
                
                <button @click="activeTab = 'commission'" :class="activeTab === 'commission' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'commission' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                        <i class="fas fa-percentage w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    Commission
                </button>

                 <button @click="activeTab = 'appearance'" :class="activeTab === 'appearance' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'appearance' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                        <i class="fas fa-paint-brush w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    Appearance
                </button>
                
                <button @click="activeTab = 'payment'" :class="activeTab === 'payment' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'payment' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                        <i class="fas fa-credit-card w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    Payment Gateway
                </button>
                
                <button @click="activeTab = 'integrations'" :class="activeTab === 'integrations' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'integrations' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                        <i class="fas fa-plug w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    Integrations (Maps)
                </button>
                
                <button @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'seo' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                         <i class="fas fa-search w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    SEO & Analytics
                </button>
                
                 <button @click="activeTab = 'mail'" :class="activeTab === 'mail' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'mail' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                     <i class="fas fa-envelope w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    Mail Server
                </button>

                <button @click="activeTab = 'referral'" :class="activeTab === 'referral' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium'" class="w-full flex items-center px-4 py-3 text-sm rounded-lg transition-all duration-200 group">
                    <span :class="activeTab === 'referral' ? 'bg-indigo-200 text-indigo-700' : 'bg-gray-100 text-gray-500 group-hover:bg-white group-hover:text-indigo-500'" class="p-2 rounded-md mr-3 transition-colors">
                        <i class="fas fa-share-alt w-4 h-4 flex items-center justify-center"></i>
                    </span>
                    Referral System
                </button>
            </nav>
            
            <div class="mt-8 px-4">
                 <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
                    <p class="text-xs font-semibold uppercase opacity-75 mb-1">System Status</p>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-sm font-bold">Operational</span>
                    </div>
                    <p class="text-xs opacity-90">Secure & Protected</p>
                 </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8 flex flex-col items-center">
            <!-- Mobile Menu -->
            <div class="md:hidden mb-6 overflow-x-auto pb-2 w-full">
                <div class="flex space-x-2">
                     <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">General</button>
                    <button @click="activeTab = 'commission'" :class="activeTab === 'commission' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">Commission</button>
                    <button @click="activeTab = 'appearance'" :class="activeTab === 'appearance' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">Appearance</button>
                    <button @click="activeTab = 'payment'" :class="activeTab === 'payment' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">Payment</button>
                    <button @click="activeTab = 'integrations'" :class="activeTab === 'integrations' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">Integrations</button>
                    <button @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">SEO</button>
                    <button @click="activeTab = 'mail'" :class="activeTab === 'mail' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">Mail</button>
                    <button @click="activeTab = 'referral'" :class="activeTab === 'referral' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600'" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap shadow-sm transition-colors">Referral</button>
                    <!-- Add other mobile tabs as needed -->
                </div>
            </div>

            <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-5xl space-y-8 pb-12">
                @csrf
                
                <!-- General Section -->
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mr-4">
                                <i class="fas fa-rupee-sign text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Fee Configuration</h2>
                                <p class="text-sm text-gray-500">Set the pricing model for your platform</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Listing Fee</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="listing_fee" value="{{ \App\Models\Setting::get('listing_fee', 199) }}" class="block w-full pl-8 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900" placeholder="0.00">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Charged per property listing</p>
                            </div>
                            
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Fee</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="featured_fee" value="{{ \App\Models\Setting::get('featured_fee', 99) }}" class="block w-full pl-8 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900" placeholder="0.00">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">To highlight a property</p>
                            </div>
                            
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Unlock Fee</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="unlock_fee" value="{{ \App\Models\Setting::get('unlock_fee', 49) }}" class="block w-full pl-8 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900" placeholder="0.00">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">To view contact details</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4">
                                <i class="fas fa-magic text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Promotional Settings</h2>
                                <p class="text-sm text-gray-500">Configure how offers interact with users</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Popup Banner Delay (Seconds)</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                    <input type="number" name="popup_delay" value="{{ \App\Models\Setting::get('popup_delay', 5) }}" min="0" class="block w-full pl-10 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900" placeholder="5">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">How many seconds to wait before showing the popup modal</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <!-- Commission Section -->
                <div x-show="activeTab === 'commission'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4">
                                <i class="fas fa-percentage text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Platform Commission</h2>
                                <p class="text-sm text-gray-500">Earnings from bookings</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Commission Percentage</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <input type="number" name="commission_percent" value="{{ \App\Models\Setting::get('commission_percent', 10) }}" min="0" max="100" class="block w-full pl-4 pr-10 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900">
                                     <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium sm:text-sm">%</span>
                                    </div>
                                </div>
                            </div>
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fixed Service Charge</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="service_charge" value="{{ \App\Models\Setting::get('service_charge', 200) }}" class="block w-full pl-8 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appearance Section -->
                <div x-show="activeTab === 'appearance'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                         <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center mr-4">
                                <i class="fas fa-palette text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Branding & Identity</h2>
                                <p class="text-sm text-gray-500">Look and feel of your website</p>
                            </div>
                        </div>
                        
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Website Logo</label>
                                <div class="flex items-start gap-6">
                                    <div class="h-24 w-24 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden relative group">
                                         @if(\App\Models\Setting::get('website_logo'))
                                            <img src="{{ asset('storage/' . \App\Models\Setting::get('website_logo')) }}" class="h-full w-full object-contain p-2">
                                        @else
                                            <i class="fas fa-image text-gray-300 text-3xl"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                         <label class="cursor-pointer bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg inline-flex items-center transition shadow-sm hover:border-indigo-300 hover:text-indigo-600">
                                            <i class="fas fa-upload mr-2"></i> Upload New Logo
                                            <input type="file" name="website_logo" class="hidden">
                                        </label>
                                        <p class="mt-2 text-xs text-gray-500">Recommended size: 200x50px. Max: 2MB. Formats: PNG, JPG.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Favicon (Browser Icon)</label>
                                <div class="flex items-start gap-6">
                                    <div class="h-24 w-24 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden relative group">
                                         @if(\App\Models\Setting::get('website_favicon'))
                                            <img src="{{ asset('storage/' . \App\Models\Setting::get('website_favicon')) }}" class="h-full w-full object-contain p-2">
                                        @else
                                            <i class="fas fa-star text-gray-300 text-3xl"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                         <label class="cursor-pointer bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg inline-flex items-center transition shadow-sm hover:border-indigo-300 hover:text-indigo-600">
                                            <i class="fas fa-upload mr-2"></i> Upload Favicon
                                            <input type="file" name="website_favicon" class="hidden" accept="image/x-icon,image/png,image/svg+xml">
                                        </label>
                                        <p class="mt-2 text-xs text-gray-500">Recommended: 32x32px or 64x64px. Formats: ICO, PNG, SVG. Max: 1MB.</p>
                                        <p class="mt-1 text-xs text-indigo-600"><i class="fas fa-info-circle mr-1"></i>Shows in browser tab next to page title</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Website Name</label>
                                    <input type="text" name="website_name" value="{{ \App\Models\Setting::get('website_name', 'RoomRental') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                                </div>
                                 <div class="grid grid-cols-2 gap-4">
                                    <div>
                                         <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                                         <input type="text" name="contact_phone" value="{{ \App\Models\Setting::get('contact_phone') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="+91 9340058914">
                                    </div>
                                    <div>
                                         <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Email</label>
                                         <input type="email" name="contact_email" value="{{ \App\Models\Setting::get('contact_email') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="support@roomrental.com">
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Company Address</label>
                                <textarea name="company_address" rows="3" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="Enter your company address">{{ \App\Models\Setting::get('company_address') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">This will be displayed on the Contact Us page and footer</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Primary Color</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="primary_color" value="{{ \App\Models\Setting::get('primary_color', '#4F46E5') }}" class="h-12 w-16 rounded-lg cursor-pointer border border-gray-200 p-1">
                                        <input type="text" name="primary_color_text" value="{{ \App\Models\Setting::get('primary_color', '#4F46E5') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="#4F46E5" id="primary_color_text">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Main brand color for headers, buttons, links</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Secondary Color</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" name="secondary_color" value="{{ \App\Models\Setting::get('secondary_color', '#10B981') }}" class="h-12 w-16 rounded-lg cursor-pointer border border-gray-200 p-1">
                                        <input type="text" name="secondary_color_text" value="{{ \App\Models\Setting::get('secondary_color', '#10B981') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="#10B981" id="secondary_color_text">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Accent color for success states, highlights</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Social Media Links</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Facebook URL</label>
                                        <input type="url" name="facebook_url" value="{{ \App\Models\Setting::get('facebook_url') }}" class="block w-full px-4 py-2 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white text-sm" placeholder="https://facebook.com/yourpage">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Twitter URL</label>
                                        <input type="url" name="twitter_url" value="{{ \App\Models\Setting::get('twitter_url') }}" class="block w-full px-4 py-2 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white text-sm" placeholder="https://twitter.com/yourhandle">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Instagram URL</label>
                                        <input type="url" name="instagram_url" value="{{ \App\Models\Setting::get('instagram_url') }}" class="block w-full px-4 py-2 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white text-sm" placeholder="https://instagram.com/yourprofile">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">LinkedIn URL</label>
                                        <input type="url" name="linkedin_url" value="{{ \App\Models\Setting::get('linkedin_url') }}" class="block w-full px-4 py-2 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white text-sm" placeholder="https://linkedin.com/company/yourcompany">
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Social media links will appear in the footer. Leave blank to hide.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mail Section -->
                 <div x-show="activeTab === 'mail'" class="space-y-6 w-full" style="display: none;">
                     <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 w-full">
                         <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Mail Server (SMTP)</h2>
                                <p class="text-sm text-gray-500">Email delivery configuration</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Host</label>
                                <input type="text" name="mail_host" value="{{ \App\Models\Setting::get('mail_host', 'smtp.gmail.com') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Port</label>
                                <input type="number" name="mail_port" value="{{ \App\Models\Setting::get('mail_port', '587') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                                <input type="text" name="mail_username" value="{{ \App\Models\Setting::get('mail_username') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <input type="password" name="mail_password" value="{{ \App\Models\Setting::get('mail_password') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>
                        </div>
                        
                         <div class="mt-4 p-4 bg-indigo-50 rounded-lg flex items-start gap-3">
                             <i class="fas fa-info-circle text-indigo-500 mt-1"></i>
                             <p class="text-sm text-indigo-800">You may need to clear cache after updating mail settings.</p>
                         </div>
                    </div>
                </div>

                <!-- Referral Section -->
                 <div x-show="activeTab === 'referral'" class="space-y-6 w-full" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 w-full">
                        <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mr-4">
                                <i class="fas fa-gift text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Refer & Earn Settings</h2>
                                <p class="text-sm text-gray-500">Configure rewards for growth</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Referrer Reward (Points)</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-coins text-gray-400"></i>
                                    </div>
                                    <input type="number" name="referral_reward" value="{{ \App\Models\Setting::get('referral_reward', 10) }}" class="block w-full pl-10 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Points given to the user who refers a friend</p>
                            </div>
                            
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Join Reward (Points)</label>
                                <div class="relative rounded-lg shadow-sm group transition-all focus-within:ring-2 ring-indigo-500/20">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-plus text-gray-400"></i>
                                    </div>
                                    <input type="number" name="join_reward" value="{{ \App\Models\Setting::get('join_reward', 5) }}" class="block w-full pl-10 pr-3 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-medium text-gray-900">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Sign-up bonus points for the new user</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div x-show="activeTab === 'payment'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                         <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                                <i class="fas fa-credit-card text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Razorpay Configuration</h2>
                                <p class="text-sm text-gray-500">Secure payments integration</p>
                            </div>
                        </div>
                         <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Key ID</label>
                                <input type="text" name="razorpay_key" value="{{ \App\Models\Setting::get('razorpay_key') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="rzp_test_...">
                            </div>
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Key Secret</label>
                                <input type="password" name="razorpay_secret" value="{{ \App\Models\Setting::get('razorpay_secret') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Webhook Secret</label>
                                <input type="password" name="razorpay_webhook_secret" value="{{ \App\Models\Setting::get('razorpay_webhook_secret') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="whsec_...">
                                <p class="mt-2 text-xs text-gray-500">Razorpay Dashboard → Webhooks → create secret. Webhook URL: <code class="bg-gray-100 px-1 rounded">{{ url('/api/v1/webhook/razorpay') }}</code></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <!-- Integrations (Maps) Section -->
                <div x-show="activeTab === 'integrations'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                         <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center mr-4">
                                <i class="fas fa-map-marked-alt text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Google Maps Integration</h2>
                                <p class="text-sm text-gray-500">For location services and maps</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">API Key</label>
                            <input type="text" name="google_maps_api_key" value="{{ \App\Models\Setting::get('google_maps_api_key') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono">
                        </div>
                    </div>
                </div>

                <!-- SEO Section -->
                 <div x-show="activeTab === 'seo'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                         <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center mr-4">
                                <i class="fas fa-search text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">SEO & Analytics</h2>
                                <p class="text-sm text-gray-500">Optimize for search engines</p>
                            </div>
                        </div>
                         <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">GA4 Measurement ID</label>
                                    <input type="text" name="ga4_measurement_id" value="{{ \App\Models\Setting::get('ga4_measurement_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="G-XXXXXXXXXX">
                                    <p class="mt-1 text-xs text-gray-500">For Traffic Analytics (G-XXXX or UA-XXXX)</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Search Console Code</label>
                                    <input type="text" name="google_search_console_code" value="{{ \App\Models\Setting::get('google_search_console_code') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="Ex: Zxsdf-Asw3... (Only the content code)">
                                    <p class="mt-1 text-xs text-gray-500">Paste the <strong>content</strong> value from the meta tag.</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Global Meta Description</label>
                                <textarea name="seo_meta_description" rows="3" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm">{{ \App\Models\Setting::get('seo_meta_description') }}</textarea>
                            </div>
                             <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" name="seo_meta_keywords" value="{{ \App\Models\Setting::get('seo_meta_keywords') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="rental, rooms, apartment...">
                            </div>
                        </div>
                    </div>

                    <!-- Google Ads Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mt-6">
                         <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                             <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                                <i class="fas fa-ad text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">Google Ads Integration</h2>
                                <p class="text-sm text-gray-500">Track conversions and manage ad campaigns</p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <input type="checkbox" name="google_ads_enabled" value="1" id="google_ads_enabled" {{ \App\Models\Setting::get('google_ads_enabled', '0') == '1' ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <label for="google_ads_enabled" class="text-sm font-semibold text-gray-700 cursor-pointer">
                                    Enable Google Ads Tracking
                                    <span class="text-xs text-gray-500 block font-normal mt-1">⚠️ Only works on production environment</span>
                                </label>
                            </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Google Ads Tag ID</label>
                                    <input type="text" name="google_ads_tag_id" value="{{ \App\Models\Setting::get('google_ads_tag_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="AW-XXXXXXXXX">
                                    <p class="mt-1 text-xs text-gray-500">For Ads Tracking. Starts with <strong>AW-</strong></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Conversion Label</label>
                                    <input type="text" name="google_ads_conversion_label" value="{{ \App\Models\Setting::get('google_ads_conversion_label') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="abc123xyz">
                                    <p class="mt-1 text-xs text-gray-500">Label for successful payments</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Signup Conversion Label</label>
                                    <input type="text" name="google_ads_signup_label" value="{{ \App\Models\Setting::get('google_ads_signup_label') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="signup_xyz123">
                                    <p class="mt-1 text-xs text-gray-500">Label for new user registrations</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Room View Conversion Label</label>
                                <input type="text" name="google_ads_room_view_label" value="{{ \App\Models\Setting::get('google_ads_room_view_label') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="view_xyz123">
                                <p class="mt-1 text-xs text-gray-500">Label for room detail page views</p>
                            </div>

                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs text-blue-800 flex items-start gap-2">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <span><strong>Note:</strong> Google Ads tracking will only work when <code class="bg-blue-100 px-1 rounded">APP_ENV=production</code> in your <code class="bg-blue-100 px-1 rounded">.env</code> file. This prevents tracking during development.</span>
                                </p>
                            </div>
                        </div>

                        <!-- Google AdSense Section -->
                        <div class="space-y-6 pt-6 border-t border-gray-100">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-ad text-yellow-600"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Google AdSense</h3>
                            </div>

                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <input type="checkbox" name="adsense_enabled" value="1" id="adsense_enabled" {{ \App\Models\Setting::get('adsense_enabled', '0') == '1' ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                <label for="adsense_enabled" class="text-sm font-semibold text-gray-700 cursor-pointer">
                                    Enable Google AdSense (Production Only)
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">AdSense Client ID (Publisher ID)</label>
                                <input type="text" name="adsense_client_id" value="{{ \App\Models\Setting::get('adsense_client_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="ca-pub-XXXXXXXXXXXXXXXX">
                                <p class="mt-1 text-xs text-gray-500">Found in your AdSense account (e.g., ca-pub-1234567890123456)</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Home Page: Top Slot ID</label>
                                    <input type="text" name="adsense_home_top_id" value="{{ \App\Models\Setting::get('adsense_home_top_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="1234567890">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Home Page: Bottom Slot ID</label>
                                    <input type="text" name="adsense_home_bottom_id" value="{{ \App\Models\Setting::get('adsense_home_bottom_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="1234567890">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Room Detail: Content Slot ID</label>
                                    <input type="text" name="adsense_room_content_id" value="{{ \App\Models\Setting::get('adsense_room_content_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="1234567890">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Room Detail: Sidebar Slot ID</label>
                                    <input type="text" name="adsense_room_sidebar_id" value="{{ \App\Models\Setting::get('adsense_room_sidebar_id') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white sm:text-sm font-mono" placeholder="1234567890">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function syncColorInputs(colorId, textId) {
    const colorInput = document.getElementById(colorId);
    const textInput = document.getElementById(textId);
    if (colorInput && textInput) {
        colorInput.addEventListener('input', () => {
            textInput.value = colorInput.value;
        });
        textInput.addEventListener('input', () => {
            if (/^#[0-9A-Fa-f]{6}$/.test(textInput.value)) {
                colorInput.value = textInput.value;
            }
        });
    }
}
syncColorInputs('primary_color', 'primary_color_text');
syncColorInputs('secondary_color', 'secondary_color_text');
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
@endpush

