<x-guest-layout>
    {{-- Header --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold mb-2 text-neutral-900">Create an account</h1>
        <p class="text-sm text-neutral-500 font-medium">
            Join us to track orders & checkout faster
        </p>
    </div>

    {{-- Form Register --}}
    {{-- QUAN TRỌNG: novalidate để tắt popup mặc định --}}
    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        {{-- 1. FULL NAME --}}
        <x-floating-input name="name" label="Full Name" type="text" :value="old('name')" required autofocus
            autocomplete="name" />

        {{-- 2. EMAIL ADDRESS --}}
        <x-floating-input name="email" label="Email Address" type="email" :value="old('email')" required
            autocomplete="username" />

        {{-- 3. PASSWORD --}}
        <x-floating-input name="password" label="Password" type="password" required autocomplete="new-password" />

        {{-- 4. CONFIRM PASSWORD --}}
        <x-floating-input name="password_confirmation" label="Confirm Password" type="password" required
            autocomplete="new-password" />

        {{-- Submit Button --}}
        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                class="w-full py-3.5 bg-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition duration-300 hover:shadow-lg hover:-translate-y-0.5">
                {{ __('Create account') }}
            </button>
        </div>

        {{-- Link Login --}}
        {{-- Link Login --}}
        <div class="text-center mt-8">
            <span class="text-sm text-neutral-500">Already have an account?</span>
            <a href="{{ route('login') }}"
                class="ml-1 text-sm font-semibold text-black hover:text-neutral-600 hover:underline transition">
                Log In
            </a>
        </div>
    </form>
    <x-social-login-buttons />
</x-guest-layout>