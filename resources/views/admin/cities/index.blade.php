@extends('layouts.admin')

@section('title', 'Operational Cities')

@section('admin-content')
<div class="space-y-5 p-5 lg:p-6">
    <header class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-[10px] font-extrabold uppercase tracking-[.2em] text-indigo-600">Market operations</p>
            <h1 class="mt-1 text-2xl font-extrabold">Operational Cities</h1>
            <p class="text-sm text-slate-500">Control where RoomNest is live. Inactive cities show a launching-soon message and fall back to the default city.</p>
        </div>
    </header>

    @if(session('success'))
        <div class="rounded-xl bg-emerald-50 p-3 text-sm font-bold text-emerald-700">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.cities.store') }}" class="grid gap-3 rounded-2xl border bg-white p-4 shadow-sm lg:grid-cols-[1fr_1fr_120px_120px_100px_auto]">
        @csrf
        <input name="name" value="{{ old('name') }}" placeholder="City name" required class="h-10 rounded-xl text-xs">
        <input name="state" value="{{ old('state') }}" placeholder="State" class="h-10 rounded-xl text-xs">
        <input name="latitude" value="{{ old('latitude') }}" placeholder="Latitude" class="h-10 rounded-xl text-xs">
        <input name="longitude" value="{{ old('longitude') }}" placeholder="Longitude" class="h-10 rounded-xl text-xs">
        <input name="sort_order" value="{{ old('sort_order', 0) }}" type="number" min="0" placeholder="Order" class="h-10 rounded-xl text-xs">
        <div class="flex items-center gap-3">
            <label class="flex items-center gap-1.5 text-xs font-bold"><input type="checkbox" name="is_active" value="1" class="rounded"> Active</label>
            <label class="flex items-center gap-1.5 text-xs font-bold"><input type="checkbox" name="is_default" value="1" class="rounded"> Default</label>
            <button class="h-10 rounded-xl bg-indigo-600 px-4 text-xs font-bold text-white">Add</button>
        </div>
    </form>

    @if(isset($errors) && $errors->any())
        <div class="rounded-xl bg-red-50 p-3 text-sm font-semibold text-red-700">{{ $errors->first() }}</div>
    @endif

    <section class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        <div class="flex justify-between border-b px-5 py-4">
            <div>
                <h2 class="text-sm font-extrabold">City directory</h2>
                <p class="text-xs text-slate-500">{{ $cities->count() }} configured cities</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[920px]">
                <thead>
                    <tr>
                        <th class="text-left">City</th>
                        <th class="text-left">State</th>
                        <th class="text-left">Coordinates</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Default</th>
                        <th class="text-right">Save</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($cities as $city)
                        <tr>
                            <form method="POST" action="{{ route('admin.cities.update', $city) }}">
                                @csrf
                                @method('PUT')
                                <td class="px-5">
                                    <input name="name" value="{{ $city->name }}" required class="h-10 w-full rounded-xl text-xs font-bold">
                                    <input type="hidden" name="sort_order" value="{{ $city->sort_order }}">
                                </td>
                                <td class="px-5"><input name="state" value="{{ $city->state }}" class="h-10 w-full rounded-xl text-xs"></td>
                                <td class="px-5">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input name="latitude" value="{{ $city->latitude }}" class="h-10 rounded-xl text-xs" placeholder="Lat">
                                        <input name="longitude" value="{{ $city->longitude }}" class="h-10 rounded-xl text-xs" placeholder="Lng">
                                    </div>
                                </td>
                                <td class="px-5">
                                    <label class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold {{ $city->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        <input type="checkbox" name="is_active" value="1" @checked($city->is_active) class="rounded">
                                        {{ $city->is_active ? 'Active' : 'Coming Soon' }}
                                    </label>
                                </td>
                                <td class="px-5">
                                    <label class="inline-flex items-center gap-2 text-xs font-bold">
                                        <input type="checkbox" name="is_default" value="1" @checked($city->is_default) class="rounded">
                                        Default fallback
                                    </label>
                                </td>
                                <td class="px-5 text-right">
                                    <button class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white">Save</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
