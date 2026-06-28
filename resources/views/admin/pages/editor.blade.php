@extends('layouts.app') {{-- Assuming you have a main admin layout --}}

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('admin.partials.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
        <div class="container-fluid px-4 py-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-slate-800">{{ $pageTitle }}</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-slate-700 mb-2">
                            Page Content
                        </label>
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

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
});
</script>
@endsection