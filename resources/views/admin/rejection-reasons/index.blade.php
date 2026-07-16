@extends('layouts.admin')

@section('title', 'Rejection Reasons')

@section('admin-content')
<div class="min-h-screen bg-gray-50">
    <div class="flex">
        {{-- SIDEBAR --}}
        {{-- MAIN --}}
        <div class="flex-1 min-w-0 p-4 md:p-6">
            {{-- HEADER --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Rejection Reasons</h1>
                        <p class="text-gray-500 mt-1">Manage reasons for room rejections</p>
                    </div>
                    <button onclick="openAddModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Reason
                    </button>
                </div>
            </div>

            {{-- REASONS LIST --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reason
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
                            @foreach($reasons as $reason)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $reason->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $reason->reason }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $reason->created_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="openEditModal({{ $reason->id }}, '{{ $reason->reason }}')" 
                                                class="text-indigo-600 hover:text-indigo-900" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteReason({{ $reason->id }})" 
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
            </div>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-indigo-100 rounded-full">
                <i class="fas fa-plus text-indigo-600"></i>
            </div>
            <div class="mt-4 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Add Rejection Reason</h3>
                <div class="mt-2 px-7 py-3">
                    <input type="text" 
                           id="newReason" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                           placeholder="Enter rejection reason...">
                </div>
                <div class="items-center px-4 py-3">
                    <button id="cancelAdd" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-400">
                        Cancel
                    </button>
                    <button id="confirmAdd" 
                            class="px-4 py-2 bg-indigo-600 text-white text-base font-medium rounded-md w-24 hover:bg-indigo-700">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-indigo-100 rounded-full">
                <i class="fas fa-edit text-indigo-600"></i>
            </div>
            <div class="mt-4 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Rejection Reason</h3>
                <div class="mt-2 px-7 py-3">
                    <input type="hidden" id="editReasonId">
                    <input type="text" 
                           id="editReason" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                           placeholder="Enter rejection reason...">
                </div>
                <div class="items-center px-4 py-3">
                    <button id="cancelEdit" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-400">
                        Cancel
                    </button>
                    <button id="confirmEdit" 
                            class="px-4 py-2 bg-indigo-600 text-white text-base font-medium rounded-md w-24 hover:bg-indigo-700">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal functions
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function openEditModal(id, reason) {
    document.getElementById('editReasonId').value = id;
    document.getElementById('editReason').value = reason;
    document.getElementById('editModal').classList.remove('hidden');
}

function deleteReason(id) {
    if (confirm('Are you sure you want to delete this rejection reason?')) {
        const url = "{{ route('admin.rejection-reasons.destroy', ':id') }}".replace(':id', id);
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
                alert('Error deleting rejection reason');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting rejection reason');
        });
    }
}

// Modal event listeners
document.getElementById('cancelAdd').addEventListener('click', function() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('newReason').value = '';
});

document.getElementById('confirmAdd').addEventListener('click', function() {
    const reason = document.getElementById('newReason').value.trim();
    
    if (!reason) {
        alert('Please enter a rejection reason');
        return;
    }
    
    fetch("{{ route('admin.rejection-reasons.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('newReason').value = '';
            location.reload();
        } else {
            alert('Error adding rejection reason');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding rejection reason');
    });
});

document.getElementById('cancelEdit').addEventListener('click', function() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editReason').value = '';
    document.getElementById('editReasonId').value = '';
});

document.getElementById('confirmEdit').addEventListener('click', function() {
    const id = document.getElementById('editReasonId').value;
    const reason = document.getElementById('editReason').value.trim();
    
    if (!reason) {
        alert('Please enter a rejection reason');
        return;
    }
    
    const url = "{{ route('admin.rejection-reasons.update', ':id') }}".replace(':id', id);
    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editReason').value = '';
            document.getElementById('editReasonId').value = '';
            location.reload();
        } else {
            alert('Error updating rejection reason');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating rejection reason');
    });
});
</script>
@endsection
