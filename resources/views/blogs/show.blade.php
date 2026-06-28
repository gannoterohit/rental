@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title)
@section('description', $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160))
@section('keywords', $blog->meta_keywords)

@section('content')
<!-- Progress Bar -->
<div id="progress-bar" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 z-50 w-0 transition-all duration-200" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>

<!-- Mobile Back Navigation -->
<div class="lg:hidden bg-white/80 backdrop-blur-md border-b border-gray-100 py-3 px-4 sticky top-0 z-40 flex items-center gap-4">
    <a href="{{ route('blogs.index') }}" class="w-10 h-10 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-700 active:scale-90 transition-transform" aria-label="Back to articles">
        <i class="fas fa-arrow-left text-sm"></i>
    </a>
    <h2 class="text-sm font-black text-gray-900 truncate pr-10">Article Details</h2>
</div>

<div class="bg-white min-h-screen">
    <!-- Desktop: Contained Hero | Mobile: Full Hero -->
    <div class="max-w-7xl mx-auto lg:mt-10 lg:px-8">
        <div class="relative w-full aspect-[16/10] md:aspect-[21/9] lg:rounded-[3rem] overflow-hidden shadow-2xl">
            @if($blog->image)
                <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center text-white/20" aria-hidden="true">
                    <i class="fas fa-newspaper text-[10rem]"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" aria-hidden="true"></div>
            <div class="absolute bottom-10 left-10 right-10 hidden lg:block">
                 <span class="inline-block bg-white/20 backdrop-blur-md text-white text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest mb-4 border border-white/20">Featured Story</span>
                 <h1 class="text-white text-5xl font-black leading-tight max-w-3xl">{{ $blog->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Article Content Layout -->
    <div class="max-w-7xl mx-auto px-4 lg:px-8 mt-10 lg:mt-16 pb-20">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Main Content Column -->
            <div class="lg:w-2/3">
                <!-- Mobile Only Title -->
                <div class="lg:hidden mb-8">
                    <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest mb-4 inline-block">News Update</span>
                    <h1 class="text-3xl font-black text-gray-900 leading-tight mb-6">{{ $blog->title }}</h1>
                    
                    <div class="flex items-center gap-4 py-6 border-y border-gray-50">
                        <div class="w-12 h-12 rounded-2xl ring-4 ring-indigo-50 overflow-hidden shadow-sm">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff&size=96" alt="RoomRental Editor" class="w-full h-full">
                        </div>
                        <div>
                            <p class="text-sm font-black text-gray-900 leading-none mb-1">RoomRental Editor</p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ $blog->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Desktop Meta -->
                <div class="hidden lg:flex items-center justify-between mb-10 pb-8 border-b border-gray-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl ring-4 ring-indigo-50 overflow-hidden shadow-sm">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff&size=96" alt="RoomRental Editor" class="w-full h-full">
                        </div>
                        <div>
                            <p class="text-sm font-black text-gray-900 leading-none mb-1">RoomRental Editor</p>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Published on {{ $blog->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest mr-2">Share On:</span>
                         <a href="https://api.whatsapp.com/send?text={{ rawurlencode($blog->title . ': ' . request()->url()) }}" target="_blank" class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center hover:bg-green-600 hover:text-white transition-all active:scale-95" aria-label="Share on WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all active:scale-95" aria-label="Share on Facebook">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Content Body -->
                <div class="prose prose-lg prose-indigo max-w-none text-gray-600 leading-[1.8] font-medium blog-content-body">
                    {!! $blog->content !!}
                </div>

                <!-- Interaction Footer -->
                <div class="mt-16 bg-gray-50 rounded-[2.5rem] p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-left">
                        <p class="text-sm font-black text-gray-900 mb-1">Thanks for reading!</p>
                        <p class="text-xs text-gray-500">We hope this article was helpful for your rental journey.</p>
                    </div>
                    <div class="flex items-center gap-3">
                         <button class="flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition active:scale-95" aria-label="Mark this article as helpful">
                            <i class="far fa-thumbs-up"></i> Helpful
                         </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="lg:w-1/3">
                <div class="sticky top-24 space-y-10">
                    <!-- Recent Posts Widget -->
                    <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm">
                         <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider mb-8 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-indigo-500 rounded-full" aria-hidden="true"></span>
                            Latest News
                         </h2>
                         <div class="space-y-8">
                            @php
                                $recentBlogs = \App\Models\Blog::where('id', '!=', $blog->id)->where('is_published', true)->latest()->take(3)->get();
                            @endphp
                            @foreach($recentBlogs as $recent)
                                <a href="{{ route('blogs.show', $recent->slug) }}" class="flex gap-4 group">
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm">
                                        @if($recent->image)
                                            <img src="{{ $recent->featured_image }}" alt="{{ $recent->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-slate-100" aria-hidden="true"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug group-hover:text-indigo-600 transition mb-2">{{ $recent->title }}</h3>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">{{ $recent->created_at->format('M d, Y') }}</span>
                                            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest flex items-center gap-1"><i class="far fa-clock" aria-hidden="true"></i> {{ max(1, ceil(str_word_count(strip_tags($recent->content)) / 200)) }}m</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                         </div>
                    </div>

                    <!-- CTA Widget -->
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-[2.5rem] p-10 text-center text-white relative overflow-hidden shadow-2xl shadow-indigo-500/20">
                        <div class="absolute inset-x-0 top-0 h-40 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10" aria-hidden="true"></div>
                        <div class="relative z-10">
                            <i class="fas fa-home text-4xl mb-6 text-indigo-200" aria-hidden="true"></i>
                            <h2 class="text-2xl font-black mb-4 leading-tight">Finding a room is now easy.</h2>
                            <p class="text-indigo-100 text-sm mb-8 leading-relaxed">Search thousands of verified listings and connect with owners instantly.</p>
                            <a href="{{ route('rooms.index') }}" class="inline-block w-full bg-white text-indigo-600 font-black py-4 rounded-2xl hover:bg-indigo-50 transition-all active:scale-95 shadow-xl">
                                Start Exploring
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <!-- Newsletter Section (App Style) -->
    <div class="bg-gray-50 py-20 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-indigo-600 rounded-[3rem] p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black/10" aria-hidden="true"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-black mb-4">Never miss an update.</h2>
                    <p class="text-indigo-100 mb-10 max-w-md mx-auto">Subscribe for curated rental tips and exclusive neighborhood guides.</p>
                    <form id="newsletter-form-show" class="max-w-md mx-auto space-y-3">
                        <label for="newsletter-email" class="sr-only">Your email address</label>
                        <input id="newsletter-email" type="email" placeholder="Your best email" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/60 px-6 py-4 rounded-2xl focus:ring-2 focus:ring-white/30 backdrop-blur-sm shadow-inner">
                        <button type="submit" class="w-full bg-white text-indigo-600 font-black py-4 rounded-2xl hover:bg-indigo-50 transition-all shadow-xl">Join the newsletter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .blog-content-body p { margin-bottom: 1.75rem; }
    .blog-content-body h3 { font-size: 1.5rem; font-weight: 800; color: #111827; margin-top: 2.5rem; margin-bottom: 1.25rem; }
    .blog-content-body ul { list-style-type: none; padding-left: 0; margin-bottom: 1.75rem; }
    .blog-content-body li { position: relative; padding-left: 1.5rem; margin-bottom: 0.75rem; }
    .blog-content-body li::before { content: '→'; position: absolute; left: 0; color: var(--primary); font-weight: bold; }
    .blog-content-body img { border-radius: 2rem; box-shadow: 0 20px 50px rgba(0,0,0,0.08); margin: 3rem 0; }
</style>

<script>
    // Reading Progress Bar
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        document.getElementById("progress-bar").style.width = scrolled + "%";
        document.getElementById("progress-bar").setAttribute("aria-valuenow", scrolled);
    };
</script>
@endsection