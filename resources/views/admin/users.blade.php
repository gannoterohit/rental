@extends('layouts.admin')

@section('title', 'All Users - Admin')

@section('admin-content')
<div class="min-h-screen bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="flex-1 min-w-0 p-4 md:p-6">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-users text-green-600 mr-2"></i>All Users
                    </h1>
                    <p class="text-gray-600 mt-1">Total: {{ $users->total() }} users</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>

            <!-- Search -->
            <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                <form method="GET" action="{{ route('admin.users') }}">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name or email..."
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Joined</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                            <a href="{{ route('admin.users.detail', $user->id) }}" 
                                               class="font-medium text-blue-600 hover:text-blue-800">
                                                {{ $user->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $user->phone ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($user->trashed())
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-600 text-white">
                                                Deleted
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if(!$user->is_blocked) bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ !$user->is_blocked ? 'Active' : 'Blocked' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.users.detail', $user->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                            <form action="{{ route('admin.users.toggleBlock', $user->id) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="px-3 py-1 rounded text-xs transition
                                                        @if(!$user->is_blocked) bg-red-600 hover:bg-red-700 text-white
                                                        @else bg-green-600 hover:bg-green-700 text-white
                                                        @endif">
                                                    <i class="fas {{ !$user->is_blocked ? 'fa-ban' : 'fa-check' }} mr-1"></i>
                                                    {{ !$user->is_blocked ? 'Block' : 'Unblock' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                        <i class="fas fa-users text-4xl mb-2"></i>
                                        <p>No users found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-4 py-4 border-t bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

