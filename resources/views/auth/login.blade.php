<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold mb-2 text-neutral-900">Welcome back</h1>
        <p class="text-sm text-neutral-500 font-medium">Enter your details to access your account</p>
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
                <span class="ms-2 text-xs font-medium text-neutral-600 group-hover:text-black transition">{{
                    __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-xs font-medium text-neutral-500 hover:text-black hover:underline transition"
                href="{{ route('password.request') }}">
                {{ __('Forgot password?') }}
            </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-3.5 bg-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition duration-300 hover:shadow-lg hover:-translate-y-0.5">
            {{ __('Log In') }}
        </button>

        <div class="text-center mt-8">
            <span class="text-sm text-neutral-500">New to BluShop?</span>
            <a href="{{ route('register') }}"
                class="ml-1 text-sm font-semibold text-black hover:text-neutral-600 hover:underline transition">
                Create account
            </a>
        </div>

    </form>
    <x-social-login-buttons />
</x-guest-layout>