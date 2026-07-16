@extends('layouts.admin')

@section('title', 'All Rooms')

@section('admin-content')
<div class="min-h-screen bg-gray-50">
    <div class="flex">
        {{-- SIDEBAR --}}
        {{-- MAIN --}}
        <div class="flex-1 min-w-0 p-4 md:p-6">
            {{-- HEADER --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">All Rooms</h1>
                        <p class="text-gray-500 mt-1">Manage and monitor all property listings</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput" 
                                   placeholder="Search rooms..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-64">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Create New Room
                        </a>
                        <a href="{{ route('admin.rejection-reasons.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-list mr-2"></i>Rejection Reasons
                        </a>
                    </div>
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Rooms</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $allrooms->total() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i class="fas fa-home text-blue-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Approved</p>
                            <p class="text-2xl font-bold text-green-600">{{ $allrooms->where('listing_status', 'approved')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $allrooms->where('listing_status', 'pending')->count() }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Rejected</p>
                            <p class="text-2xl font-bold text-red-600">{{ $allrooms->where('listing_status', 'rejected')->count() }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <i class="fas fa-times-circle text-red-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ROOMS TABLE --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full" id="roomsTable">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Room Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Owner
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Listing Fee
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($allrooms as $room)
                            <tr class="hover:bg-gray-50 transition-colors room-row" 
                                data-status="{{ $room->listing_status }}"
                                data-search="{{ strtolower($room->title ?? '') }} {{ strtolower($room->owner->name ?? '') }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            @if($room->photo_url)
                                                <img class="h-16 w-16 rounded-lg object-cover" 
                                                     src="{{ $room->photo_url }}" 
                                                     alt="{{ $room->title }}">
                                            @else
                                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-home text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $room->title ?? 'Room #' . $room->id }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $room->address ?? 'No address' }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                ID: #{{ $room->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-user text-indigo-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $room->owner->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $room->owner->email ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        ₹{{ number_format($room->rent ?? 0) }}
                                        <span class="text-xs text-gray-500 font-normal">/month</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $room->listing_status == 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($room->listing_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($room->listing_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $room->listing_fee_paid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $room->listing_fee_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $room->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.rooms.show', $room) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" 
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.rooms.edit', $room) }}" 
                                           class="text-blue-600 hover:text-blue-900" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($room->listing_status == 'pending')
                                            <button onclick="approveRoom({{ $room->id }})" 
                                                    class="text-green-600 hover:text-green-900" 
                                                    title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button onclick="openRejectModal({{ $room->id }})" 
                                                    class="text-red-600 hover:text-red-900" 
                                                    title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        <button onclick="deleteRoom({{ $room->id }})" 
                                                class="text-red-600 hover:text-red-900" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $allrooms->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- REJECT MODAL -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="mt-4 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Room</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Please select reasons for rejecting this room listing.
                    </p>
                    <div class="mt-3 text-left">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reasons:</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3">
                            @foreach($rejectionReasons as $reason)
                            <div class="flex items-center">
                                <input id="reason_{{ $reason->id }}" 
                                       name="rejection_reasons[]" 
                                       value="{{ $reason->id }}" 
                                       type="checkbox" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="reason_{{ $reason->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $reason->reason }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3 text-left">
                        <label for="customReason" class="block text-sm font-medium text-gray-700 mb-2">Additional Reason (Optional):</label>
                        <textarea id="customReason" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                                  rows="3" 
                                  placeholder="Enter additional reason..."></textarea>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="cancelReject" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-400">
                        Cancel
                    </button>
                    <button id="confirmReject" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 hover:bg-red-700">
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- APPROVE MODAL -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div class="mt-4 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Approve Room</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to approve this room listing? An email notification will be sent to owner.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="cancelApprove" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-400">
                        Cancel
                    </button>
                    <button id="confirmApprove" 
                            class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-24 hover:bg-green-700">
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.room-row');
    
    rows.forEach(row => {
        const searchableText = row.getAttribute('data-search');
        if (searchableText.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function(e) {
    const status = e.target.value;
    const rows = document.querySelectorAll('.room-row');
    
    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        if (status === '' || rowStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Global variables
let currentRoomId = null;

// Approve room
function approveRoom(roomId) {
    currentRoomId = roomId;
    document.getElementById('approveModal').classList.remove('hidden');
}

// Open reject modal
function openRejectModal(roomId) {
    currentRoomId = roomId;
    document.getElementById('rejectModal').classList.remove('hidden');
}

// Delete room
function deleteRoom(roomId) {
    if (confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
        const url = "{{ route('admin.rooms.destroy', ':id') }}".replace(':id', roomId);
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting room');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting room');
        });
    }
}

// Modal event listeners
document.getElementById('cancelReject').addEventListener('click', function() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('customReason').value = '';
    // Uncheck all checkboxes
    document.querySelectorAll('input[name="rejection_reasons[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    currentRoomId = null;
});

document.getElementById('confirmReject').addEventListener('click', function() {
    const selectedReasons = [];
    document.querySelectorAll('input[name="rejection_reasons[]"]:checked').forEach(checkbox => {
        selectedReasons.push(checkbox.value);
    });
    const customReason = document.getElementById('customReason').value.trim();
    
    if (selectedReasons.length === 0 && !customReason) {
        alert('Please select at least one rejection reason or provide a custom reason');
        return;
    }
    
    // Show loading state
    document.getElementById('confirmReject').disabled = true;
    document.getElementById('confirmReject').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    
    const url = "{{ route('admin.rooms.reject', ':id') }}".replace(':id', currentRoomId);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            reasons: selectedReasons,
            customReason: customReason
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('customReason').value = '';
            // Uncheck all checkboxes
            document.querySelectorAll('input[name="rejection_reasons[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            currentRoomId = null;
            location.reload();
        } else {
            alert('Error rejecting room: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error rejecting room: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        document.getElementById('confirmReject').disabled = false;
        document.getElementById('confirmReject').innerHTML = 'Reject';
    });
});

document.getElementById('cancelApprove').addEventListener('click', function() {
    document.getElementById('approveModal').classList.add('hidden');
    currentRoomId = null;
});

document.getElementById('confirmApprove').addEventListener('click', function() {
    const url = "{{ route('admin.rooms.approve', ':id') }}".replace(':id', currentRoomId);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('approveModal').classList.add('hidden');
            currentRoomId = null;
            location.reload();
        } else {
            alert(data.message || 'Error approving room');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error approving room');
    });
});
</script>
@endsection