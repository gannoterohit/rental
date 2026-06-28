@extends('layouts.app')

@section('title', 'City Alert Subscriptions - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 shadow-lg">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fas fa-bell"></i>
                    City Alert Subscriptions
                </h1>
                <p class="text-indigo-100 mt-1">Manage users who want to be notified about new rooms in specific cities.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white/20 backdrop-blur-md rounded-lg text-sm font-medium">
                    Total Subscriptions: {{ $alerts->total() }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-4 md:p-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">User</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">City Requested</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">Subscribed Date</th>
                            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($alerts as $alert)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr($alert->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $alert->user->name ?? 'Unknown User' }}</p>
                                        <p class="text-xs text-gray-500">{{ $alert->user->email ?? 'No Email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-tight">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $alert->city }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                {{ $alert->created_at->format('M d, Y') }}
                                <p class="text-[10px] text-gray-400">{{ $alert->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.city-alerts.destroy', $alert->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this subscription?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-bell-slash text-4xl text-gray-200"></i>
                                    <p class="text-gray-500 font-medium">No city alert subscriptions found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($alerts->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $alerts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
