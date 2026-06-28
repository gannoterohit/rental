{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login - RoomRental')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden py-12 px-4 sm:px-6 lg:px-8">

        <!-- Refined Aurora/Glow Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-32 w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow">
            </div>
            <div
                class="absolute -bottom-40 -left-32 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slower">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[600px] bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-slow">
            </div>
        </div>

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-md">
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/30 mb-5">
                    <i class="fas fa-building text-2xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">RoomRental</h1>
                <p class="text-slate-400 mt-2 text-sm">Find your perfect space, hassle-free</p>
            </div>

            <!-- Main Card -->
            <div
                class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-6 sm:p-8 transition-all duration-300 hover:shadow-indigo-500/10">
                <!-- Status Messages -->
                @if (session('status'))
                    <div
                        class="mb-6 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <div id="status-message"
                    class="hidden mb-6 p-3 rounded-xl text-sm flex items-start gap-2 border transition-all duration-200">
                </div>

                <!-- Step 1: Email Form -->
                <div id="email-step" class="transition-all duration-300">
                    <form id="email-form">
                        @csrf
                        <div class="mb-5">
                            <label for="email"
                                class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">Email
                                Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-slate-500 text-sm"></i>
                                </div>
                                <input type="email" id="email" name="email" required
                                    class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200 placeholder:text-slate-600 text-sm"
                                    placeholder="you@example.com">
                            </div>
                        </div>

                        <button type="submit" id="send-otp-btn"
                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 transform active:scale-95 flex items-center justify-center gap-2 shadow-md shadow-indigo-600/20">
                            <span>Continue with Email</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>

                        <div class="relative flex items-center py-4 mt-2">
                            <div class="flex-grow border-t border-white/10"></div>
                            <span
                                class="flex-shrink mx-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Secure
                                Login</span>
                            <div class="flex-grow border-t border-white/10"></div>
                        </div>
                    </form>
                </div>

                <!-- Step 2: OTP Form -->
                <div id="otp-step" class="hidden transition-all duration-300 opacity-0 transform translate-y-2">
                    <form id="otp-form">
                        @csrf
                        <div class="text-center mb-6">
                            <div
                                class="w-12 h-12 bg-indigo-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shield-alt text-indigo-400 text-xl"></i>
                            </div>
                            <p class="text-slate-300 text-sm">Enter verification code sent to</p>
                            <p id="email-display"
                                class="font-semibold text-white text-sm mt-1 bg-white/5 inline-block px-3 py-1 rounded-full">
                            </p>
                        </div>

                        <div class="mb-6">
                            <label for="otp"
                                class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1 ml-1">Verification
                                Code</label>
                            <input type="text" id="otp" name="otp" maxlength="6" required
                                class="w-full bg-slate-900/60 border border-white/10 text-white rounded-xl py-3 px-4 text-center text-2xl font-mono tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-transparent transition-all duration-200"
                                placeholder="000000">
                        </div>

                        <div class="flex justify-between items-center mb-5 text-xs">
                            <span class="text-slate-500">Code expires in 5 minutes</span>
                            <button type="button" id="resend-otp-btn"
                                class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                                Resend Code
                            </button>
                        </div>

                        <button type="submit" id="verify-otp-btn"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 transform active:scale-95 flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20">
                            <span>Verify & Sign In</span>
                            <i class="fas fa-check-circle text-sm"></i>
                        </button>

                        <button type="button" id="back-to-email-btn"
                            class="w-full mt-3 text-slate-400 hover:text-white text-xs flex items-center justify-center gap-1 transition-colors">
                            <i class="fas fa-chevron-left text-[10px]"></i>
                            Use different email
                        </button>
                    </form>
                </div>

                <!-- Footer Links -->
                <div class="mt-6 text-center text-sm text-slate-500 border-t border-white/10 pt-5">
                    <p>Don't have an account?
                        <a href="{{ route('register') }}"
                            class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                            Sign up
                        </a>
                    </p>
                </div>
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
                    <i class="fas fa-clock"></i>
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
            const emailStep = document.getElementById('email-step');
            const otpStep = document.getElementById('otp-step');
            const emailInput = document.getElementById('email');
            const emailDisplay = document.getElementById('email-display');
            const otpInput = document.getElementById('otp');
            const statusBox = document.getElementById('status-message');
            const sendOtpBtn = document.getElementById('send-otp-btn');
            const verifyOtpBtn = document.getElementById('verify-otp-btn');
            const resendOtpBtn = document.getElementById('resend-otp-btn');
            const backToEmailBtn = document.getElementById('back-to-email-btn');
            const emailForm = document.getElementById('email-form');
            const otpForm = document.getElementById('otp-form');

            // Helper: Show status message
            const setStatus = (msg, type = 'error') => {
                statusBox.classList.remove('hidden');
                statusBox.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} mt-0.5"></i>
                <span class="flex-1">${msg}</span>
            `;
                const baseClasses = 'bg-';
                if (type === 'error') {
                    statusBox.className = 'hidden mb-6 p-3 rounded-xl text-sm flex items-start gap-2 border border-rose-500/20 bg-rose-500/10 text-rose-400';
                } else {
                    statusBox.className = 'hidden mb-6 p-3 rounded-xl text-sm flex items-start gap-2 border border-emerald-500/20 bg-emerald-500/10 text-emerald-400';
                }
                statusBox.classList.remove('hidden');
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

            // Step 1: Send OTP
            emailForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.add('hidden');

                const email = emailInput.value.trim();
                if (!email) {
                    setStatus('Please enter your email address.', 'error');
                    return;
                }

                setLoading(sendOtpBtn, true);

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
                        // Switch to OTP step
                        emailDisplay.textContent = email;
                        emailStep.classList.add('hidden');
                        otpStep.classList.remove('hidden');
                        // Trigger entrance animation
                        setTimeout(() => {
                            otpStep.classList.remove('opacity-0', 'translate-y-2');
                        }, 10);
                        otpInput.focus();
                        setStatus('Verification code sent! Check your inbox.', 'success');
                    } else {
                        setStatus(data.message || 'Failed to send verification code. Please try again.', 'error');
                    }
                } catch (error) {
                    console.error('Send OTP error:', error);
                    setStatus('Network error. Please check your connection.', 'error');
                } finally {
                    setLoading(sendOtpBtn, false);
                }
            });

            // Step 2: Verify OTP
            otpForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                statusBox.classList.add('hidden');

                const otp = otpInput.value.trim();
                if (!otp || otp.length < 6) {
                    setStatus('Please enter the 6-digit verification code.', 'error');
                    return;
                }

                setLoading(verifyOtpBtn, true);

                try {
                    const response = await fetch('{{ route("verify.login.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email: emailInput.value.trim(),
                            otp: otp
                        })
                    });
                    const data = await response.json();

                    if (data.success) {
                        setStatus('Login successful! Redirecting...', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect || '{{ route("dashboard") }}';
                        }, 800);
                    } else {
                        setStatus(data.message || 'Invalid verification code. Please try again.', 'error');
                        if (data.message && data.message.toLowerCase().includes('invalid')) {
                            otpInput.value = '';
                            otpInput.focus();
                        }
                    }
                } catch (error) {
                    console.error('Verify OTP error:', error);
                    setStatus('Verification failed. Please try again.', 'error');
                } finally {
                    setLoading(verifyOtpBtn, false);
                }
            });

            // Resend OTP
            resendOtpBtn.addEventListener('click', async () => {
                statusBox.classList.add('hidden');
                const email = emailInput.value.trim();
                if (!email) {
                    setStatus('Email address is missing. Please go back and enter your email.', 'error');
                    return;
                }

                const originalText = resendOtpBtn.innerHTML;
                resendOtpBtn.disabled = true;
                resendOtpBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

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
                    resendOtpBtn.disabled = false;
                    resendOtpBtn.innerHTML = originalText;
                }
            });

            // Back to email step
            backToEmailBtn.addEventListener('click', () => {
                statusBox.classList.add('hidden');
                otpStep.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    otpStep.classList.add('hidden');
                    emailStep.classList.remove('hidden');
                    otpInput.value = '';
                }, 200);
            });
        });
    </script>
@endsection