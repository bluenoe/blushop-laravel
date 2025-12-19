<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold tracking-tighter mb-2">Welcome Back.</h1>
        <p class="text-sm text-neutral-500 font-light">Enter your details to access your account.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Thêm 'novalidate' để tắt popup mặc định --}}
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- Component Input Mới --}}
        <x-floating-input name="email" label="Email Address" type="email" :value="old('email')" required autofocus
            autocomplete="username" />

        <x-floating-input name="password" label="Password" type="password" required autocomplete="current-password" />

        {{-- Các phần còn lại giữ nguyên --}}
        <div class="flex items-center justify-between mt-2 mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded border-neutral-300 text-black shadow-sm focus:ring-black cursor-pointer"
                    name="remember">
                <span
                    class="ms-2 text-[10px] uppercase tracking-wider font-bold text-neutral-500 group-hover:text-black transition">{{
                    __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-[10px] font-bold uppercase tracking-wider text-neutral-400 hover:text-black border-b border-transparent hover:border-black transition pb-0.5"
                href="{{ route('password.request') }}">
                {{ __('Forgot password?') }}
            </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-4 bg-black text-white font-bold uppercase text-xs tracking-widest hover:bg-neutral-800 transition duration-300 hover:-translate-y-1">
            {{ __('Log In') }}
        </button>

        <div class="text-center mt-8">
            <span class="text-xs text-neutral-500">New to BluShop?</span>
            <a href="{{ route('register') }}"
                class="ml-1 text-xs font-bold uppercase tracking-wide border-b border-black pb-0.5 hover:text-neutral-600 hover:border-neutral-600 transition">
                Create Account
            </a>
        </div>

    </form>
    <x-social-login-buttons />
</x-guest-layout>