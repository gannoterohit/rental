@extends('layouts.app')

@section('title', 'Contact Us | ' . \App\Models\Setting::get('website_name', 'RoomRental'))

@section('content')
<div class="bg-slate-50 py-12 md:py-20 min-h-[80vh]">
    <div class="container mx-auto px-4">
        {{-- Page Header --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 mb-4 uppercase tracking-tight">
                Get In <span class="text-indigo-600">Touch</span>
            </h1>
            <p class="text-slate-600 max-w-2xl mx-auto font-medium">
                Have questions or need support? Our team is here to help you find your perfect stay.
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-100">
                
                {{-- Left Side: Info (Dark themed) --}}
                <div class="lg:w-2/5 bg-slate-900 p-8 md:p-12 text-white flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-8">Contact Information</h2>
                        
                        <div class="space-y-8">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-600/20 rounded-xl flex items-center justify-center text-indigo-400">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Our Location</p>
                                    <p class="text-sm font-bold text-slate-200">{{ \App\Models\Setting::get('company_address', 'Bhopal, Madhya Pradesh, India') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-emerald-600/20 rounded-xl flex items-center justify-center text-emerald-400">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Phone Number</p>
                                    <p class="text-sm font-bold text-slate-200">{{ \App\Models\Setting::get('contact_phone', '+91 9340058914') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center text-blue-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Email Support</p>
                                    <p class="text-sm font-bold text-slate-200">{{ \App\Models\Setting::get('contact_email', 'support@roomrental.com') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex gap-4">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white hover:bg-indigo-600 transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white hover:bg-indigo-600 transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white hover:bg-indigo-600 transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                {{-- Right Side: Form --}}
                <div class="lg:w-3/5 p-8 md:p-12">
                    <form action="{{ route('pages.contact.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2" for="name">Your Name</label>
                                <input type="text" name="name" id="name" required placeholder="Full Name"
                                       class="w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-slate-700">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2" for="email">Email Address</label>
                                <input type="email" name="email" id="email" required placeholder="email@address.com"
                                       class="w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-slate-700">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2" for="subject">Subject</label>
                            <input type="text" name="subject" id="subject" placeholder="How can we help?"
                                   class="w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-slate-700">
                        </div>

                        <div class="mb-8">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2" for="message">Message</label>
                            <textarea name="message" id="message" rows="5" required placeholder="Tell us more..."
                                      class="w-full bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-0 rounded-xl py-3 px-4 font-bold text-slate-700"></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1">
                            Send Message Now
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
