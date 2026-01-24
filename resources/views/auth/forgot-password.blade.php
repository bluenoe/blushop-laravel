<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold mb-2 text-neutral-900">Reset your password</h1>
        <p class="text-sm text-neutral-500 font-medium">
            Enter the email address associated with your account and we'll send you a link to reset your password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <x-floating-input name="email" label="Email Address" type="email" :value="old('email')" required autofocus />

        <div class="mt-6 flex flex-col gap-6">
            <button type="submit"
                class="w-full py-3.5 bg-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition duration-300 hover:shadow-lg hover:-translate-y-0.5">
                {{ __('Send Reset Link') }}
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-500 hover:text-black transition group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Login
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>