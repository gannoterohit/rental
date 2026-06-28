@extends('layouts.app')

@section('title', isset($blog) ? 'Edit Blog' : 'Create Blog')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.blogs.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">{{ isset($blog) ? 'Edit Post' : 'Create New Post' }}</h1>
        </div>

        <form action="{{ isset($blog) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($blog))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title & Slug -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title', $blog->title ?? '') }}" class="block w-full px-4 py-3 border-gray-200 rounded-lg focus:ring-0 focus:border-indigo-500 transition-colors bg-gray-50 focus:bg-white" placeholder="Enter post title" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Content</label>
                            <textarea name="content" id="editor" class="block w-full border-gray-200 rounded-lg" rows="15">{{ old('content', $blog->content ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-search text-indigo-500 mr-2"></i> SEO Configuration
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                                <input type="text" name="meta_title" value="{{ old('meta_title', $blog->meta_title ?? '') }}" class="block w-full px-3 py-2 border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white">
                                <p class="text-xs text-gray-500 mt-1">Leave blank to use post title.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                                <textarea name="meta_description" rows="3" class="block w-full px-3 py-2 border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Summary for Google search results.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                                <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}" class="block w-full px-3 py-2 border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white" placeholder="room, rental, tips">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="space-y-6">
                    <!-- Publish Status -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Publishing</h3>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-700 text-sm">Status</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $blog->is_published ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg shadow-sm transition">
                            {{ isset($blog) ? 'Update Post' : 'Publish Post' }}
                        </button>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Featured Image</h3>
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition cursor-pointer relative group">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                            
                            <div id="image-preview" class="{{ isset($blog) && $blog->image ? '' : 'hidden' }} mb-2">
                                @if(isset($blog) && $blog->image)
                                    <img src="{{ $blog->featured_image }}" class="w-full h-40 object-cover rounded-lg">
                                @else
                                    <img src="" class="w-full h-40 object-cover rounded-lg">
                                @endif
                            </div>
                            
                            <div id="upload-placeholder" class="{{ isset($blog) && $blog->image ? 'hidden' : '' }}">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Click to upload image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });

    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
