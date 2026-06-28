@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Newsletter Subscribers</h2>
            <p class="text-sm text-gray-500 mt-1">Manage email subscriptions from the blog.</p>
        </div>
        <button onclick="window.print()" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
            <i class="fas fa-print mr-2"></i> Print List
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold border-b border-gray-100">Email Address</th>
                    <th class="p-4 font-semibold border-b border-gray-100">Subscribed At</th>
                    <th class="p-4 font-semibold border-b border-gray-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($subscribers as $subscriber)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-800 font-medium">{{ $subscriber->email }}</td>
                        <td class="p-4 text-gray-500">{{ $subscriber->created_at->format('M d, Y h:i A') }}</td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 w-8 h-8 rounded-full flex items-center justify-center transition">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-400">
                            <i class="far fa-envelope-open text-3xl mb-3 block"></i>
                            No subscribers found yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($subscribers->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $subscribers->links() }}
        </div>
    @endif
</div>
@endsection
