@extends('layouts.app')

@section('title', 'Room Options')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Room Option Manager</h1>
                <p class="text-gray-600 mt-2">Manage room type, furnishing, and preferred tenant values from one place.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Option</h2>
                    <form action="{{ route('admin.room-options.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Group</label>
                            <select name="group" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach($groups as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Key</label>
                            <input type="text" name="key" required class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="single_room">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                            <input type="text" name="label" required class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Single Room">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="0" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700">Save Option</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                @foreach($groups as $groupKey => $groupLabel)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">{{ $groupLabel }}</h2>
                        </div>
                        <div class="space-y-3">
                            @forelse($options->get($groupKey, collect()) as $option)
                                <div class="flex items-center justify-between border border-gray-200 rounded-xl p-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $option->label }}</p>
                                        <p class="text-sm text-gray-500">Key: {{ $option->key }} · Order: {{ $option->sort_order }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.room-options.update', $option) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="group" value="{{ $groupKey }}">
                                            <input type="text" name="key" value="{{ $option->key }}" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-28">
                                            <input type="text" name="label" value="{{ $option->label }}" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-32">
                                            <input type="number" name="sort_order" value="{{ $option->sort_order }}" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-20">
                                            <button type="submit" class="px-3 py-2 bg-amber-500 text-white rounded-lg text-sm hover:bg-amber-600">Update</button>
                                        </form>
                                        <form action="{{ route('admin.room-options.destroy', $option) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No options added yet.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
