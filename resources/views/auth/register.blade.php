<x-guest-layout>
    {{-- Header --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold tracking-tighter mb-2">Join the Inner Circle.</h1>
        <p class="text-sm text-neutral-500 font-light">
            Create an account to track orders & checkout faster.
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
        <div class="pt-2">
            <button type="submit"
                class="w-full py-4 bg-black text-white font-bold uppercase text-xs tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1 duration-300">
                {{ __('Create Account') }}
            </button>
        </div>

        {{-- Link Login --}}
        <div class="text-center mt-8">
            <span class="text-xs text-neutral-500">Already have an account?</span>
            <a href="{{ route('login') }}"
                class="ml-1 text-xs font-bold uppercase tracking-wide border-b border-black pb-0.5 hover:text-neutral-600 hover:border-neutral-600 transition">
                Log In
            </a>
        </div>
    </form>
    <x-social-login-buttons />
</x-guest-layout>