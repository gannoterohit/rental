@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h1>
            <p class="text-lg text-gray-600">Find answers to common questions about RoomRental.</p>
        </div>

        <div class="space-y-4">
            @forelse($faqs as $index => $faq)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none transition-colors duration-200 hover:bg-gray-50" 
                            onclick="toggleFaq('faq-{{ $index }}')">
                        <span class="text-lg font-medium text-gray-900">{{ $faq['question'] }}</span>
                        <i id="icon-faq-{{ $index }}" class="fas fa-chevron-down text-gray-400 transition-transform duration-200"></i>
                    </button>
                    <div id="faq-{{ $index }}" class="hidden px-6 pb-4 pt-0 text-gray-600 leading-relaxed border-t border-transparent transition-all duration-300">
                        <div class="pt-4 border-t border-gray-100">
                            {!! $faq['answer'] !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center bg-white rounded-lg shadow-sm p-8">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-question-circle text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No FAQs yet</h3>
                    <p class="text-gray-500">Check back later for updates.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleFaq(id) {
        const element = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        // Close others? Optional. Let's keep multiple openable for now.
        
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            element.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endsection
