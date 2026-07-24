@extends('layouts.app')

@section('title', $title)
@section('description', $metaDescription ?? '')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-4">{{ $title }}</h1>
                
                <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
