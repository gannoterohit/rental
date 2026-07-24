@extends('layouts.admin')

@section('admin-content')
<div class="flex min-h-0">
    <div class="flex-1 min-w-0 flex flex-col">
        <div class="container-fluid px-4 py-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-slate-800">{{ $pageTitle }}</h1>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm font-semibold text-green-700">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm font-semibold text-red-700">{{ $errors->first() }}</div>
            @endif

            <div id="pageEditorCard" class="bg-white rounded-lg shadow-md p-6">
                <form id="pageEditorForm" action="{{ $route }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <label for="content" class="block text-sm font-medium text-slate-700">Page Content</label>
                            <button type="button" id="toggleEditorFullscreen" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 text-xs font-bold transition"><i class="fas fa-expand mr-1"></i>Full screen</button>
                        </div>
                        <textarea id="content" name="content" rows="20" 
                                  class="block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $setting->value ?? '' }}</textarea>
                        <p id="editorFallbackNote" class="hidden mt-2 text-xs text-amber-600 font-semibold">Rich editor unavailable. You can edit directly in the textarea above.</p>
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
(function() {
    'use strict';
    
    function syncEditors() {
        if (window.richEditors && typeof window.richEditors.forEach === 'function') {
            window.richEditors.forEach(function(editor) {
                if (editor && typeof editor.getData === 'function' && editor.sourceElement) {
                    editor.sourceElement.value = editor.getData();
                }
            });
        }
    }
    
    function restoreTextarea(textarea) {
        if (!textarea || !textarea.parentNode) return;
        var clone = document.createElement('textarea');
        clone.id = textarea.id;
        clone.name = textarea.name;
        clone.rows = textarea.rows || 20;
        clone.className = textarea.className;
        clone.value = textarea.value || '';
        textarea.parentNode.replaceChild(clone, textarea);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('pageEditorForm');
        var contentEl = document.getElementById('content');
        var fallbackNote = document.getElementById('editorFallbackNote');
        var isEditorReady = false;
        
        if (typeof createRichEditor === 'function' && contentEl) {
            try {
                createRichEditor(contentEl).then(function() {
                    isEditorReady = true;
                }).catch(function(err) {
                    console.error('CKEditor init failed:', err);
                    restoreTextarea(contentEl);
                    if (fallbackNote) fallbackNote.classList.remove('hidden');
                });
            } catch (err) {
                console.error('CKEditor init threw:', err);
                restoreTextarea(contentEl);
                if (fallbackNote) fallbackNote.classList.remove('hidden');
            }
        } else if (contentEl && typeof CKEDITOR === 'undefined') {
            console.warn('CKEditor script not loaded. Using plain textarea fallback.');
            if (fallbackNote) fallbackNote.classList.remove('hidden');
        }
        
        if (form) {
            form.addEventListener('submit', function() {
                syncEditors();
            });
        }
        
        document.getElementById('toggleEditorFullscreen')?.addEventListener('click', function() {
            var card = document.getElementById('pageEditorCard');
            card.classList.toggle('page-editor-fullscreen');
            var active = card.classList.contains('page-editor-fullscreen');
            this.innerHTML = active ? '<i class="fas fa-compress mr-1"></i>Exit full screen' : '<i class="fas fa-expand mr-1"></i>Full screen';
        });
    });
})();
</script>
@endsection
