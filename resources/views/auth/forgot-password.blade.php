<x-guest-layout>
    @if (session('status'))
    {{-- SUCCESS STATE: Check Your Email --}}
    <div class="text-center">
        <!-- Icon -->
        <div class="mb-6 flex justify-center">
            <div class="w-16 h-16 bg-neutral-50 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold mb-2 text-neutral-900">Check your mail</h1>
        <p class="text-sm text-neutral-500 font-medium mb-8">
            We have sent a password recover instructions to your email.
        </p>

        <div class="space-y-6">
            <a href="mailto:"
                class="block w-full py-3.5 bg-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition duration-300 hover:shadow-lg hover:-translate-y-0.5">
                Open Email App
            </a>

            <div class="text-center text-sm text-neutral-500">
                Did not receive the email? Check your spam filter, or
                <a href="{{ route('password.request') }}" class="text-black font-semibold hover:underline transition">
                    try another email address
                </a>
            </div>
        </div>
    </div>
    @else
    {{-- FORM STATE: Forgot Password --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold mb-2 text-neutral-900">Reset your password</h1>
        <p class="text-sm text-neutral-500 font-medium">
            Enter the email address associated with your account and we'll send you a link to reset your password.
        </p>
    </div>

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
    @endif
</x-guest-layout>