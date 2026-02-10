<x-guest-layout>
    <div x-data="{ page: 'forgot', 'loaded': true }">

        <!-- Preloader -->
        <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})" class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white" style="display: none;">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-blue-500 border-t-transparent"></div>
        </div>

        <!-- Page Wrapper -->
        <div class="relative z-1 bg-white ">
            <div class="relative flex h-screen w-full flex-col justify-center lg:flex-row ">

                <!-- Left Side - Form -->
                <div class="flex w-full flex-1 flex-col lg:w-1/2">
                    <div class="mx-auto w-full max-w-md pt-10">
                    </div>

                    <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                        <div>
                            <div class="mb-5 sm:mb-8">
                                <h1 class="text-2xl sm:text-3xl mb-2 font-semibold text-gray-800">
                                    {{ __('Forgot Password') }}
                                </h1>
                                <p class="text-sm text-gray-500">
                                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                </p>
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Forgot Password Form -->
                            <form method="POST" action="{{ route('password.email') }}" class="mt-5 sm:mt-8">
                                @csrf

                                <div class="space-y-5">
                                    <!-- Email Address -->
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input
                                            id="email"
                                            class="block mt-1 w-full shadow-sm h-11 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none"
                                            type="email"
                                            name="email"
                                            :value="old('email')"
                                            placeholder="info@example.com"
                                            required
                                            autofocus
                                        />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Submit Button -->
                                    <div>
                                        <button type="submit" class="w-full text-center items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                            {{ __('Email Password Reset Link') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Back to Login -->
                            <div class="mt-5">
                                <p class="text-center text-sm text-gray-600">
                                    <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 font-medium">{{ __('Back to Login') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Branding (Hidden on Mobile) -->
                <div class="relative hidden h-full w-full items-center bg-gradient-to-br from-blue-950 to-blue-900 lg:grid lg:w-1/2">
                    <div class="z-1 flex items-center justify-center">
                        <div class="flex max-w-xs flex-col items-center text-center">
                            <div class="mb-6">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/10 backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-white mb-3">{{ __('Reset Your Password') }}</h2>
                            <p class="text-gray-300 text-sm">
                                {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
