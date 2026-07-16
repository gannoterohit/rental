@extends('layouts.admin')
@section('title', 'Edit Subscription Plan')
@section('admin-content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                Edit Plan
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                Update subscription package details.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 sm:p-12">
                <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-2">
                        <!-- Plan Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Plan Name</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" required class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 h-12 sm:text-lg border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price (₹)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg">₹</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price', $plan->price) }}" required class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 h-12 sm:text-lg border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration_days" class="block text-sm font-bold text-gray-700 mb-2">Duration (Days)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $plan->duration_days) }}" required class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 h-12 sm:text-lg border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Plan Type -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Plan Type</label>
                            <select name="type" id="type" onchange="toggleLimitFields()" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-12 sm:text-lg border-gray-300 rounded-lg">
                                <option value="user" {{ $plan->type == 'user' ? 'selected' : '' }}>User (Contact Unlocks)</option>
                                <option value="owner" {{ $plan->type == 'owner' ? 'selected' : '' }}>Owner (Room Listings)</option>
                            </select>
                        </div>

                        <!-- Limits (Dynamic) -->
                        <div class="col-span-2 sm:col-span-1">
                            <!-- Contact Limits (User) -->
                            <div id="contacts_limit_group" class="{{ $plan->type == 'user' ? '' : 'hidden' }}">
                                <label for="contacts_limit" class="block text-sm font-bold text-gray-700 mb-2">
                                    Contact Unlocks Limit <span class="text-indigo-600 text-xs font-normal ml-1">(-1 for Unlimited)</span>
                                </label>
                                <input type="number" name="contacts_limit" id="contacts_limit" value="{{ old('contacts_limit', $plan->contacts_limit) }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-12 sm:text-lg border-gray-300 rounded-lg">
                            </div>

                            <!-- Listing Limits (Owner) -->
                            <div id="listing_limit_group" class="{{ $plan->type == 'owner' ? '' : 'hidden' }}">
                                <label for="listing_limit" class="block text-sm font-bold text-gray-700 mb-2">
                                    Listing Limit <span class="text-indigo-600 text-xs font-normal ml-1">(-1 for Unlimited)</span>
                                </label>
                                <input type="number" name="listing_limit" id="listing_limit" value="{{ old('listing_limit', $plan->listing_limit) }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-12 sm:text-lg border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <!-- Benefits -->
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Plan Benefits</label>
                            <div id="benefits-container" class="space-y-3">
                                @if($plan->benefits && is_array($plan->benefits))
                                    @foreach($plan->benefits as $benefit)
                                        <div class="flex items-center space-x-2">
                                            <input type="text" name="benefits[]" value="{{ $benefit }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-10 border-gray-300 rounded-lg text-sm">
                                            <button type="button" onclick="this.parentElement.remove()" class="bg-red-50 text-red-600 p-2 rounded-lg hover:bg-red-100 transition"><i class="fas fa-trash"></i></button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="benefits[]" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-10 border-gray-300 rounded-lg text-sm" placeholder="Add new benefit">
                                    <button type="button" onclick="addBenefitField()" class="bg-indigo-50 text-indigo-600 p-2 rounded-lg hover:bg-indigo-100 transition"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200 flex gap-4">
                        <button type="submit" class="flex-1 flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-lg font-black text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-[1.02] transition-all duration-200">
                            Update Plan
                        </button>
                        <a href="{{ route('admin.plans.index') }}" class="flex-shrink-0 flex justify-center py-4 px-6 border-2 border-gray-300 rounded-xl text-lg font-black text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleLimitFields() {
        const type = document.getElementById('type').value;
        const contactGroup = document.getElementById('contacts_limit_group');
        const listingGroup = document.getElementById('listing_limit_group');

        if (type === 'user') {
            contactGroup.classList.remove('hidden');
            listingGroup.classList.add('hidden');
        } else {
            contactGroup.classList.add('hidden');
            listingGroup.classList.remove('hidden');
        }
    }

    function addBenefitField() {
        const container = document.getElementById('benefits-container');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2';
        div.innerHTML = `
            <input type="text" name="benefits[]" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-10 border-gray-300 rounded-lg text-sm" placeholder="Benefit description">
            <button type="button" onclick="this.parentElement.remove()" class="bg-red-50 text-red-600 p-2 rounded-lg hover:bg-red-100 transition"><i class="fas fa-trash"></i></button>
        `;
        container.appendChild(div);
    }
</script>
@endsection
