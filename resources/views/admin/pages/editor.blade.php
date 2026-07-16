@extends('layouts.admin')

@section('admin-content')
<div class="flex min-h-0">
    <!-- Sidebar -->
    <!-- Main Content -->
    <div class="flex-1 min-w-0 flex flex-col">
        <div class="container-fluid px-4 py-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-slate-800">{{ $pageTitle }}</h1>
            </div>

            <div id="pageEditorCard" class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <label for="content" class="block text-sm font-medium text-slate-700">Page Content</label>
                            <button type="button" id="toggleEditorFullscreen" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 text-xs font-bold transition"><i class="fas fa-expand mr-1"></i>Full screen</button>
                        </div>
                        <textarea id="content" name="content" rows="20" 
                                  class="block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $setting->value ?? '' }}</textarea>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Page Content
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.pages.partials.rich-editor')
<script>
document.addEventListener('DOMContentLoaded', function() {
    createRichEditor(document.querySelector('#content'));
    document.getElementById('toggleEditorFullscreen')?.addEventListener('click', function() {
        const card = document.getElementById('pageEditorCard');
        card.classList.toggle('page-editor-fullscreen');
        const active = card.classList.contains('page-editor-fullscreen');
        this.innerHTML = active ? '<i class="fas fa-compress mr-1"></i>Exit full screen' : '<i class="fas fa-expand mr-1"></i>Full screen';
    });
});
</script>
@endsection
