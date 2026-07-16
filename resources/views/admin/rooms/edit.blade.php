@extends('layouts.app')

@section('title', 'Edit Room - Admin')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 min-w-0 overflow-hidden overflow-y-auto">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-edit text-blue-600 mr-2"></i>Edit Room #{{ $room->id }}
                    </h1>
                    <p class="text-gray-600 mt-1">Modify any details of this property listing</p>
                </div>
                <a href="{{ route('admin.all-rooms') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to All Rooms
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-8">
                        <!-- Owner Selection -->
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                                <i class="fas fa-user-tie mr-2"></i> Change Room Owner (Optional)
                            </h3>
                            <div>
                                <label for="owner_id" class="block text-sm font-semibold text-gray-700 mb-2">Owner Name/Email</label>
                                <select name="owner_id" id="owner_id" required
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ $room->user_id == $owner->id ? 'selected' : '' }}>
                                            {{ $owner->name }} ({{ $owner->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Room Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $room->title) }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g. Luxury 1BHK in Downtown">
                            </div>
                            <div>
                                <label for="room_type" class="block text-sm font-semibold text-gray-700 mb-2">Room Type</label>
                                <select name="room_type" id="room_type" required
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                    @foreach(App\Models\RoomOption::optionsFor('room_type', $room->room_type_option_id) as $option)
                                        <option value="{{ $option->id }}" {{ $room->room_type_option_id == $option->id ? 'selected' : '' }}>
                                            {{ $option->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" required
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                      placeholder="Detailed description of the room...">{{ old('description', $room->description) }}</textarea>
                        </div>

                        <!-- Pricing & Types -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <label for="rent" class="block text-sm font-semibold text-gray-700 mb-2">Monthly Rent (₹)</label>
                                <input type="number" name="rent" id="rent" value="{{ old('rent', $room->rent) }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="deposit" class="block text-sm font-semibold text-gray-700 mb-2">Deposit (₹)</label>
                                <input type="number" name="deposit" id="deposit" value="{{ old('deposit', $room->deposit) }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="furnishing_type" class="block text-sm font-semibold text-gray-700 mb-2">Furnishing</label>
                                <select name="furnishing_type" id="furnishing_type" required
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                    @foreach(App\Models\RoomOption::optionsFor('furnishing_type', $room->furnishing_option_id) as $option)
                                        <option value="{{ $option->id }}" {{ $room->furnishing_option_id == $option->id ? 'selected' : '' }}>{{ $option->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="tenant_type" class="block text-sm font-semibold text-gray-700 mb-2">Tenant Type</label>
                                <select name="tenant_type" id="tenant_type" required
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                    @foreach(App\Models\RoomOption::optionsFor('tenant_type', $room->tenant_option_id) as $option)
                                        <option value="{{ $option->id }}" {{ $room->tenant_option_id == $option->id ? 'selected' : '' }}>
                                            {{ $option->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $room->city) }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                                <input type="text" name="state" id="state" value="{{ old('state', $room->state) }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g. Maharashtra">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                                <input type="text" name="country" id="country" value="{{ old('country', $room->country) }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Full Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $room->address) }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Geo-Coordinates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">Latitude (Optional)</label>
                                <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $room->latitude) }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g. 19.0760">
                            </div>
                            <div>
                                <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">Longitude (Optional)</label>
                                <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $room->longitude) }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g. 72.8777">
                            </div>
                        </div>

                        <!-- Landmarks -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> Nearby Landmarks
                            </h3>
                            <div id="landmarks-container" class="space-y-3">
                                @php $currentLandmarks = is_array($room->landmarks) ? $room->landmarks : (json_decode($room->landmarks, true) ?? []); @endphp
                                @if(count($currentLandmarks) > 0)
                                    @foreach($currentLandmarks as $landmark)
                                    <div class="flex gap-2">
                                        <input type="text" name="landmarks[]" value="{{ $landmark }}" class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <button type="button" class="remove-landmark bg-red-100 text-red-600 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="flex gap-2">
                                        <input type="text" name="landmarks[]" class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g. Near Metro Station">
                                        <button type="button" class="remove-landmark bg-red-100 text-red-600 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-landmark" class="mt-4 text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                                <i class="fas fa-plus-circle mr-1"></i> Add Another Landmark
                            </button>
                        </div>

                        <!-- Amenities -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Amenities</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @php $currentAmenities = is_array($room->amenities) ? $room->amenities : (json_decode($room->amenities, true) ?? []); @endphp
                                @foreach(['Wifi', 'AC', 'TV', 'Geyser', 'Cooler', 'Parking', 'Kitchen', 'Cleaning', 'Laundry', 'Power Backup', 'CCTV', 'Lift', 'Security', 'Water Supply', 'Gym', 'Swimming Pool', 'Clubhouse'] as $amenity)
                                <label class="flex items-center space-x-2 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity }}" 
                                           {{ in_array($amenity, $currentAmenities) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 rounded">
                                    <span class="text-sm text-gray-700">{{ $amenity }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Update Photos (Optional)</label>
                                <input type="file" name="photos[]" multiple accept="image/*"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-2">Current Thumbnail:</p>
                                @if($room->photo)
                                    <img src="{{ asset('storage/'.$room->photo) }}" class="h-20 w-20 object-cover rounded-lg border mt-1">
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Update Video (File)</label>
                                <input type="file" name="video" accept="video/*"
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                                @if($room->video)
                                    <div class="mt-2 flex items-center text-sm text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i> Video uploaded
                                        <a href="{{ asset('storage/'.$room->video) }}" target="_blank" class="ml-2 text-blue-600 hover:underline">View Current Video</a>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Short walk-through video (Max: 10MB)</p>
                            </div>
                        </div>

                        <div>
                            <label for="video_url" class="block text-sm font-semibold text-gray-700 mb-2">Or Video URL (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $room->video_url) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://www.youtube.com/watch?v=...">
                        </div>

                        <!-- Administrative Controls -->
                        <div class="bg-amber-50 p-6 rounded-xl border border-amber-100">
                            <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center">
                                <i class="fas fa-tools mr-2"></i> Administrative Controls
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1" {{ $room->is_featured ? 'checked' : '' }} class="h-5 w-5 text-indigo-600 rounded">
                                    <span class="text-sm font-bold text-gray-700">Featured Room</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="listing_fee_paid" value="1" {{ $room->listing_fee_paid ? 'checked' : '' }} class="h-5 w-5 text-indigo-600 rounded">
                                    <span class="text-sm font-bold text-gray-700">Listing Fee Paid</span>
                                </label>
                                
                                <div>
                                    <label for="listing_status" class="block text-xs font-bold text-gray-500 uppercase mb-1">Listing Status</label>
                                    <select name="listing_status" id="listing_status" class="w-full px-3 py-2 border rounded-lg text-sm">
                                        <option value="pending" {{ $room->listing_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $room->listing_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $room->listing_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-xs font-bold text-gray-500 uppercase mb-1">Room Status</label>
                                    <select name="status" id="status" class="w-full px-3 py-2 border rounded-lg text-sm">
                                        <option value="active" {{ $room->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="booked" {{ $room->status == 'booked' ? 'selected' : '' }}>Booked/Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t flex gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg">
                                <i class="fas fa-save mr-2"></i> Update Room Details
                            </button>
                            <a href="{{ route('admin.all-rooms') }}" 
                               class="px-8 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 rounded-lg transition text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Add landmark
    $('#add-landmark').click(function() {
        const html = `
            <div class="flex gap-2">
                <input type="text" name="landmarks[]" class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g. Beside Central Park">
                <button type="button" class="remove-landmark bg-red-100 text-red-600 px-3 py-2 rounded-lg hover:bg-red-200 transition">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        $('#landmarks-container').append(html);
    });

    // Remove landmark
    $(document).on('click', '.remove-landmark', function() {
        $(this).parent().remove();
    });
});
</script>
@endpush
