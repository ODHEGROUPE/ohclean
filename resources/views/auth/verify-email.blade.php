<x-guest-layout>
    <div x-data="{ page: 'verify', 'loaded': true }">

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
                                    Verify Email
                                </h1>
                                <p class="text-sm text-gray-500">
                                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                                </p>
                            </div>

                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-5 p-4 rounded-lg bg-green-50 border border-green-200">
                                    <p class="font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                    </p>
                                </div>
                            @endif

                            <!-- Verification Form -->
                            <div class="mt-5 sm:mt-8 space-y-4">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-center items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                        {{ __('Resend Verification Email') }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-center items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 transition rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-white mb-3">Verify Your Email</h2>
                            <p class="text-gray-300 text-sm">
                                Check your inbox for a verification link to complete your account setup.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
