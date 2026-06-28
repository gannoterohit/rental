{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Register - RoomRental')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden py-12 px-4 sm:px-6 lg:px-8">

        <!-- Refined Aurora/Glow Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-32 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow">
            </div>
            <div
                class="absolute -bottom-40 -left-32 w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slower">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[600px] bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-slow">
            </div>
        </div>

        <!-- Register Card -->
        <div class="relative z-10 w-full max-w-2xl">
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 shadow-lg shadow-purple-500/30 mb-5">
                    <i class="fas fa-user-plus text-2xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Create Account</h1>
                <p class="text-slate-400 mt-2 text-sm">Join our community of verified members</p>
            </div>

            <!-- Main Card -->
            <div
                class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-6 sm:p-8 transition-all duration-300 hover:shadow-purple-500/10">

                <!-- Status Messages -->
                <div id="status-message"
                    class="hidden mb-6 p-3 rounded-xl text-sm flex items-start gap-2 border transition-all duration-200">
                </div>

                <!-- Step 1: Registration Details -->
                <div id="details-step" class="transition-all duration-300">
                    <form id="details-form">
                        @csrf

                        <!-- Two Column Layout for Name & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="name"
                                    class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">Full
                                    Name *</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-slate-500 text-sm"></i>
                                    </div>
                                    <input type="text" id="name" name="name" required
                                        class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-200 placeholder:text-slate-600 text-sm"
                                        placeholder="John Doe">
                                </div>
                            </div>

                            <div>
                                <label for="phone"
                                    class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">Phone
                                    Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone-alt text-slate-500 text-sm"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone"
                                        class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-200 placeholder:text-slate-600 text-sm"
                                        placeholder="+91 98765 43210">
                                </div>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="mb-5">
                            <label for="email"
                                class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">Email
                                Address *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-slate-500 text-sm"></i>
                                </div>
                                <input type="email" id="email" name="email" required
                                    class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-200 placeholder:text-slate-600 text-sm"
                                    placeholder="you@example.com">
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 ml-1">I
                                want to *</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="role" value="user" checked class="peer sr-only">
                                    <div
                                        class="p-3 rounded-xl bg-slate-900/40 border border-white/10 peer-checked:bg-indigo-600/20 peer-checked:border-indigo-500/50 peer-checked:ring-2 peer-checked:ring-indigo-500/20 transition-all hover:bg-white/5 flex items-center justify-center gap-2">
                                        <i class="fas fa-search text-slate-500 peer-checked:text-indigo-400 text-sm"></i>
                                        <span class="text-sm font-medium text-slate-400 peer-checked:text-white">Find a
                                            Room</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="role" value="owner" class="peer sr-only">
                                    <div
                                        class="p-3 rounded-xl bg-slate-900/40 border border-white/10 peer-checked:bg-purple-600/20 peer-checked:border-purple-500/50 peer-checked:ring-2 peer-checked:ring-purple-500/20 transition-all hover:bg-white/5 flex items-center justify-center gap-2">
                                        <i class="fas fa-home text-slate-500 peer-checked:text-purple-400 text-sm"></i>
                                        <span class="text-sm font-medium text-slate-400 peer-checked:text-white">List a
                                            Room</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Referral Code -->
                        <div class="mb-6">
                            <label
                                class="flex justify-between text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">
                                <span>Referral Code</span>
                                <span
                                    class="text-slate-500 font-normal normal-case tracking-normal text-[10px]">Optional</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-ticket-alt text-slate-500 text-sm"></i>
                                </div>
                                <input type="text" id="referral_code_input" name="referral_code"
                                    class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-transparent transition-all duration-200 placeholder:text-slate-700 text-sm uppercase tracking-wider"
                                    placeholder="Enter referral code"
                                    value="{{ old('referral_code', session('referral_code')) }}">
                            </div>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="mb-6">
                            <label class="flex items-start gap-2 cursor-pointer">
                                <input type="checkbox" id="terms_checkbox" required
                                    class="mt-0.5 w-4 h-4 rounded border-white/20 bg-slate-900/60 text-purple-600 focus:ring-purple-500 focus:ring-offset-0">
                                <span class="text-xs text-slate-400">I agree to the <a href="#"
                                        class="text-purple-400 hover:text-purple-300 transition-colors">Terms of Service</a>
                                    and <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">Privacy
                                        Policy</a></span>
                            </label>
                        </div>

                        <button type="submit" id="send-otp-btn"
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 transform active:scale-95 flex items-center justify-center gap-2 shadow-md shadow-purple-600/20">
                            <span>Continue to Verification</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>

                        <div class="relative flex items-center py-4 mt-2">
                            <div class="flex-grow border-t border-white/10"></div>
                            <span
                                class="flex-shrink mx-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Secure
                                Registration</span>
                            <div class="flex-grow border-t border-white/10"></div>
                        </div>
                    </form>
                </div>

                <!-- Step 2: OTP Verification -->
                <div id="otp-step" class="hidden transition-all duration-300 opacity-0 transform translate-y-2">
                    <form id="otp-form">
                        @csrf
                        <div class="text-center mb-6">
                            <div
                                class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shield-alt text-purple-400 text-2xl"></i>
                            </div>
                            <p class="text-slate-300 text-sm">We've sent a verification code to</p>
                            <p id="email-display" class="font-semibold text-white text-base mt-1 break-all"></p>
                            <p class="text-slate-500 text-xs mt-2">Please check your inbox or spam folder</p>
                        </div>

                        <div class="mb-6">
                            <label for="otp"
                                class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">Verification
                                Code</label>
                            <input type="text" id="otp" name="otp" maxlength="6" required
                                class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 px-4 text-center text-2xl font-mono tracking-[0.4em] focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-200"
                                placeholder="000000">
                        </div>

                        <div class="flex justify-between items-center mb-6 text-xs">
                            <span class="text-slate-500">Code expires in 5 minutes</span>
                            <button type="button" id="resend-otp-btn"
                                class="text-purple-400 hover:text-purple-300 font-medium transition-colors">
                                Resend Code
                            </button>
                        </div>

                        <button type="submit" id="verify-otp-btn"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 transform active:scale-95 flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20">
                            <span>Verify & Create Account</span>
                            <i class="fas fa-user-check"></i>
                        </button>

                        <button type="button" id="back-to-details-btn"
                            class="w-full mt-3 text-slate-400 hover:text-white text-xs flex items-center justify-center gap-1 transition-colors">
                            <i class="fas fa-chevron-left text-[10px]"></i>
                            Back to registration form
                        </button>
                    </form>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-slate-500">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-purple-400 hover:text-purple-300 font-medium transition-colors">
                        Sign in instead
                    </a>
                </p>
            </div>

            <!-- Trust Badges -->
            <div class="flex justify-center gap-4 mt-6 text-[11px] text-slate-500">
                <div class="flex items-center gap-1">
                    <i class="fas fa-lock"></i>
                    <span>256-bit SSL</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-shield-alt"></i>
                    <span>Privacy Protected</span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-headset"></i>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-pulse-slow {
            animation: pulseSlow 8s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-pulse-slower {
            animation: pulseSlow 12s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulseSlow {

            0%,
            100% {
                opacity: 0.15;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(1.1);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const detailsStep = document.getElementById('details-step');
            const otpStep = document.getElementById('otp-step');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const referralCodeInput = document.getElementById('referral_code_input');
            const emailDisplay = document.getElementById('email-display');
            const otpInput = document.getElementById('otp');
            const statusBox = document.getElementById('status-message');
            const termsCheckbox = document.getElementById('terms_checkbox');

            // Helper: Show status message
            const setStatus = (msg, type = 'error') => {
                statusBox.classList.remove('hidden');
                if (type === 'error') {
                    statusBox.className = 'hidden mb-6 p-3 rounded-xl text-sm flex items-start gap-2 border border-rose-500/20 bg-rose-500/10 text-rose-400';
                } else {
                    statusBox.className = 'hidden mb-6 p-3 rounded-xl text-sm flex items-start gap-2 border border-emerald-500/20 bg-emerald-500/10 text-emerald-400';
                }
                statusBox.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} mt-0.5"></i>
                <span class="flex-1">${msg}</span>
            `;
                statusBox.classList.remove('hidden');
                statusBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Auto hide after 4 seconds
                setTimeout(() => {
                    if (statusBox && !statusBox.classList.contains('hidden')) {
                        statusBox.classList.add('hidden');
                    }
                }, 4000);
            };

            // Helper: Set loading state for buttons
            const setLoading = (btn, isLoading, originalText = null) => {
                if (!btn) return;
                if (isLoading) {
                    btn.dataset.originalText = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Please wait...</span>';
                    btn.classList.add('opacity-70', 'cursor-not-allowed');
                } else {
                    if (btn.dataset.originalText) {
                        btn.innerHTML = btn.dataset.originalText;
                    }
                    btn.disabled = false;
                    btn.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            };

            // Helper: Validate email format
            const isValidEmail = (email) => {
                return /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/.test(email);
            };

            // Step 1: Send OTP
            document.getElementById('details-form').addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.add('hidden');

                // Validate required fields
                const name = nameInput.value.trim();
                const email = emailInput.value.trim();

                if (!name) {
                    setStatus('Please enter your full name.', 'error');
                    nameInput.focus();
                    return;
                }

                if (!email) {
                    setStatus('Please enter your email address.', 'error');
                    emailInput.focus();
                    return;
                }

                if (!isValidEmail(email)) {
                    setStatus('Please enter a valid email address.', 'error');
                    emailInput.focus();
                    return;
                }

                if (!termsCheckbox.checked) {
                    setStatus('Please agree to the Terms of Service and Privacy Policy.', 'error');
                    termsCheckbox.focus();
                    return;
                }

                const btn = document.getElementById('send-otp-btn');
                setLoading(btn, true);

                try {
                    const response = await fetch('{{ route("send.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: email })
                    });
                    const data = await response.json();

                    if (data.success) {
                        emailDisplay.textContent = email;
                        detailsStep.classList.add('hidden');
                        otpStep.classList.remove('hidden');
                        // Trigger entrance animation
                        setTimeout(() => {
                            otpStep.classList.remove('opacity-0', 'translate-y-2');
                        }, 10);
                        otpInput.focus();
                        setStatus('Verification code sent! Check your email.', 'success');
                    } else {
                        setStatus(data.message || 'Failed to send verification code. Please try again.', 'error');
                    }
                } catch (error) {
                    console.error('Send OTP error:', error);
                    setStatus('Network error. Please check your connection.', 'error');
                } finally {
                    setLoading(btn, false);
                }
            });

            // Step 2: Verify OTP and complete registration
            document.getElementById('otp-form').addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.add('hidden');

                const otp = otpInput.value.trim();
                if (!otp || otp.length < 6) {
                    setStatus('Please enter the 6-digit verification code.', 'error');
                    otpInput.focus();
                    return;
                }

                const btn = document.getElementById('verify-otp-btn');
                setLoading(btn, true);

                const payload = {
                    name: nameInput.value.trim(),
                    email: emailInput.value.trim(),
                    phone: phoneInput.value.trim(),
                    role: document.querySelector('input[name="role"]:checked').value,
                    referral_code: referralCodeInput.value.trim(),
                    otp: otp
                };

                try {
                    const response = await fetch('{{ route("verify.registration.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });
                    const data = await response.json();

                    if (data.success) {
                        setStatus('Registration complete! Welcome to RoomRental.', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect || '{{ route("dashboard") }}';
                        }, 1000);
                    } else {
                        setStatus(data.message || 'Invalid verification code. Please try again.', 'error');
                        if (data.message && data.message.toLowerCase().includes('invalid')) {
                            otpInput.value = '';
                            otpInput.focus();
                        }
                    }
                } catch (error) {
                    console.error('Registration error:', error);
                    setStatus('Registration failed. Please try again.', 'error');
                } finally {
                    setLoading(btn, false);
                }
            });

            // Resend OTP
            const resendBtn = document.getElementById('resend-otp-btn');
            resendBtn.addEventListener('click', async () => {
                statusBox.classList.add('hidden');
                const email = emailInput.value.trim();
                if (!email) {
                    setStatus('Email address is missing. Please go back and enter your email.', 'error');
                    return;
                }

                const originalText = resendBtn.innerHTML;
                resendBtn.disabled = true;
                resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

                try {
                    const response = await fetch('{{ route("send.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: email })
                    });
                    const data = await response.json();

                    if (data.success) {
                        setStatus('New verification code sent!', 'success');
                        otpInput.value = '';
                        otpInput.focus();
                    } else {
                        setStatus(data.message || 'Failed to resend code.', 'error');
                    }
                } catch (error) {
                    setStatus('Could not resend code. Please try again.', 'error');
                } finally {
                    resendBtn.disabled = false;
                    resendBtn.innerHTML = originalText;
                }
            });

            // Back to details form
            const backBtn = document.getElementById('back-to-details-btn');
            backBtn.addEventListener('click', () => {
                statusBox.classList.add('hidden');
                otpStep.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    otpStep.classList.add('hidden');
                    detailsStep.classList.remove('hidden');
                    otpInput.value = '';
                }, 200);
            });
        });
    </script>
@endsection