@extends('layouts.app')
@section('title', 'Submit a Complaint')
@section('content')
@php $isOwner = Auth::user()->role === 'owner'; @endphp
<div class="{{ $isOwner ? 'owner-workspace' : 'user-workspace' }} min-h-screen">
    @include($isOwner ? 'owner.partials.sidebar' : 'user.partials.sidebar', ['active' => 'complaints'])
    <main class="complaint-page-main">
        <header class="{{ $isOwner ? 'owner-page-header' : 'workspace-header' }}"><h1 class="text-2xl font-bold text-slate-900">Submit a Complaint</h1><p class="text-sm text-slate-500 mt-1">Give clear details and evidence so our team can investigate.</p></header>
        <div class="complaint-page-content">
            @if($errors->any())<div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-4xl space-y-5 rounded-2xl border border-slate-200 bg-white p-5 md:p-6 shadow-sm">@csrf
                <div><label class="mb-2 block text-sm font-bold text-slate-700">Category *</label><select name="category" required class="w-full rounded-xl border-slate-300">@foreach(\App\Models\Complaint::CATEGORIES as $key => $label)<option value="{{ $key }}" @selected(old('category') === $key)>{{ $label }}</option>@endforeach</select></div>
                <div><label class="mb-2 block text-sm font-bold text-slate-700">Related property (optional)</label><input type="number" name="room_id" value="{{ old('room_id', $room?->id) }}" class="w-full rounded-xl border-slate-300" placeholder="Property ID">@if($room)<p class="mt-2 text-xs text-slate-500">Selected: {{ $room->title }}</p>@endif</div>
                <div><label class="mb-2 block text-sm font-bold text-slate-700">Subject *</label><input name="subject" value="{{ old('subject') }}" maxlength="255" required class="w-full rounded-xl border-slate-300" placeholder="Short summary"></div>
                <div><label class="mb-2 block text-sm font-bold text-slate-700">Details *</label><textarea name="description" rows="7" minlength="20" required class="w-full rounded-xl border-slate-300" placeholder="What happened, when, and what resolution do you expect?">{{ old('description') }}</textarea></div>
                <div><label class="mb-2 block text-sm font-bold text-slate-700">Evidence (optional)</label><input type="file" name="evidence" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full rounded-xl border border-slate-300 p-3 text-sm"><p class="mt-1 text-xs text-slate-500">JPG, PNG, WebP or PDF, maximum 5 MB.</p></div>
                <div class="flex gap-3"><button class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white">Submit Complaint</button><a href="{{ route('complaints.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-600">Cancel</a></div>
            </form>
        </div>
    </main>
</div>
@endsection
