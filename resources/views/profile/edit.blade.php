@extends('layouts.app')

@section('title', 'Profile Settings - RoomRental')

@section('content')
<div class="{{ Auth::user()->role === 'owner' ? 'owner-workspace' : 'user-workspace' }} min-h-screen bg-gray-50 flex flex-col lg:flex-row pb-20 lg:pb-0">
    @if(Auth::user()->role === 'owner')
        @include('owner.partials.sidebar', ['active' => 'profile'])
    @else
        @include('user.partials.sidebar', ['active' => 'profile'])
    @endif

    <!-- Mobile Header (Hidden on Desktop) -->
    <div class="lg:hidden bg-white px-4 py-4 border-b border-gray-100 sticky top-0 z-40 flex items-center justify-between">
        <a href="{{ Auth::user()->role === 'owner' ? route('owner.dashboard') : route('dashboard') }}" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-700">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-lg font-bold text-gray-900">Edit Profile</h1>
        <div class="w-10"></div> <!-- Spacer for center-aligned title -->
    </div>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-3xl mx-auto p-4 lg:p-10">
            <!-- App-style Profile Photo Section (Mobile Only) -->
            <div class="lg:hidden flex flex-col items-center mb-8">
                <form id="avatar_form_mobile" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-3xl overflow-hidden border-4 border-white shadow-2xl relative">
                            @if(Auth::user()->avatar)
                                <img id="mobile_avatar_preview" src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div id="mobile_avatar_placeholder" class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white">
                                    <i class="fas fa-user text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-camera text-white text-xl"></i>
                            </div>
                        </div>
                        <label for="mobile_avatar_input" class="absolute -bottom-2 -right-2 w-10 h-10 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-xl cursor-pointer active:scale-90 transition-all border-4 border-white">
                            <i class="fas fa-pen text-xs"></i>
                            <input type="file" id="mobile_avatar_input" name="avatar" class="hidden" accept="image/*" onchange="submitMobileAvatar()">
                        </label>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Forms Section -->
            <div class="space-y-6 lg:space-y-8">
                <!-- Profile Information Card -->
                <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6 hidden lg:flex">
                         <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-id-card"></i>
                         </div>
                         <h3 class="font-bold text-gray-900">General Information</h3>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Account Security / Delete Account -->
                <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-sm border border-red-50">
                    <div class="flex items-center gap-3 mb-6">
                         <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shield-alt"></i>
                         </div>
                         <h3 class="font-bold text-gray-900">Account Security</h3>
                    </div>
                    <div class="prose prose-sm text-gray-500 mb-6">
                        <p>If you'd like to permanently close your account and delete your data, you can do so below. This action is irreversible.</p>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    function submitMobileAvatar() {
        const input = document.getElementById('mobile_avatar_input');
        const preview = document.getElementById('mobile_avatar_preview');
        const placeholder = document.getElementById('mobile_avatar_placeholder');
        
        if (input.files && input.files[0]) {
            // Show preview immediately
            const reader = new FileReader();
            reader.onload = function(e) {
                if(preview) {
                    preview.src = e.target.result;
                } else if(placeholder) {
                    // Create img if placeholder exists
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    img.id = 'mobile_avatar_preview';
                    placeholder.parentNode.appendChild(img);
                    placeholder.remove();
                }
            }
            reader.readAsDataURL(input.files[0]);
            
            // Auto submit
            document.getElementById('avatar_form_mobile').submit();
        }
    }
</script>
@endpush
@endsection
