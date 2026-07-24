@extends('layouts.admin')

@section('title', 'CMS Pages')

@section('admin-content')
<div class="space-y-5 p-5 lg:p-6">
    <header class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-[10px] font-extrabold uppercase tracking-[.2em] text-indigo-600">Content management</p>
            <h1 class="mt-1 text-2xl font-extrabold">CMS Pages</h1>
            <p class="text-sm text-slate-500">Manage static website pages without adding sidebar clutter.</p>
        </div>
        <a href="{{ route('admin.cms-pages.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-xs font-bold text-white">
            <i class="fas fa-plus"></i>Add Page
        </a>
    </header>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm font-bold text-emerald-700">{{ session('success') }}</div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-3 text-sm font-bold text-red-700">{{ $errors->first() }}</div>
    @endif

    <form method="GET" class="flex flex-wrap items-end gap-2 rounded-2xl border bg-white p-4">
        <div>
            <label class="mb-1 block text-[10px] font-bold uppercase text-slate-400">Search</label>
            <input name="search" value="{{ request('search') }}" placeholder="Title or slug" class="h-10 rounded-lg text-xs">
        </div>
        <div>
            <label class="mb-1 block text-[10px] font-bold uppercase text-slate-400">Status</label>
            <select name="status" class="h-10 rounded-lg text-xs">
                <option value="">All</option>
                <option value="published" @selected(request('status')==='published')>Published</option>
                <option value="draft" @selected(request('status')==='draft')>Draft</option>
            </select>
        </div>
        <button class="h-10 rounded-lg bg-slate-900 px-4 text-xs font-bold text-white">Apply</button>
        <a href="{{ route('admin.cms-pages.index') }}" class="flex h-10 items-center rounded-lg border px-3 text-xs font-bold">Reset</a>
    </form>

    <div class="overflow-hidden rounded-2xl border bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-[900px] w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-extrabold uppercase tracking-wide text-slate-400">
                    <tr><th class="p-4">Page</th><th class="p-4">Template</th><th class="p-4">Status</th><th class="p-4">Updated</th><th class="p-4 text-right">Actions</th></tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pages as $page)
                        <tr>
                            <td class="p-4">
                                <p class="text-sm font-extrabold text-slate-900">{{ $page->title }}</p>
                                <p class="text-xs text-slate-400">/{{ $page->slug }}</p>
                            </td>
                            <td class="p-4"><span class="rounded-lg bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-600">{{ ucfirst($page->template) }}</span></td>
                            <td class="p-4">
                                <span class="rounded-lg px-2 py-1 text-[10px] font-extrabold {{ $page->isPublished() ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($page->status) }}</span>
                                @if($page->is_system)<span class="ml-1 rounded-lg bg-indigo-50 px-2 py-1 text-[10px] font-bold text-indigo-700">System</span>@endif
                            </td>
                            <td class="p-4 text-xs text-slate-500">{{ $page->updated_at?->format('d M Y, h:i A') }}</td>
                            <td class="p-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ $page->public_url }}" target="_blank" class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.cms-pages.edit', $page) }}" class="rounded-lg bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-700"><i class="fas fa-edit mr-1"></i>Edit</a>
                                    @unless($page->is_system)
                                        <form method="POST" action="{{ route('admin.cms-pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-700"><i class="fas fa-trash"></i></button></form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-12 text-center text-sm text-slate-500">No CMS pages found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pages->hasPages())
            <div class="border-t p-4">{{ $pages->links() }}</div>
        @endif
    </div>
</div>
@endsection
