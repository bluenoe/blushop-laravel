<x-guest-layout>
    {{-- Header --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold tracking-tighter mb-2">Welcome Back.</h1>
        <p class="text-sm text-neutral-500 font-light">
            Enter your details to access your account.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-8">
        @csrf

        <div class="relative z-0 w-full group">
            <input type="email" name="email" id="email"
                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                placeholder=" " required autofocus autocomplete="username" value="{{ old('email') }}" />
            <label for="email"
                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                Email Address
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="relative z-0 w-full group">
            <input type="password" name="password" id="password"
                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                placeholder=" " required autocomplete="current-password" />
            <label for="password"
                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                Password
            </label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-neutral-300 text-black shadow-sm focus:ring-black" name="remember">
                <span class="ms-2 text-xs uppercase tracking-wide text-neutral-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-xs text-neutral-400 hover:text-black hover:underline underline-offset-4 transition"
                href="{{ route('password.request') }}">
                {{ __('Forgot password?') }}
            </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full py-4 bg-black text-white font-bold uppercase text-xs tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1">
                {{ __('Log In') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <span class="text-xs text-neutral-500">New to BluShop?</span>
            <a href="{{ route('register') }}"
                class="ml-1 text-xs font-bold uppercase tracking-wide border-b border-black pb-0.5 hover:text-neutral-600 hover:border-neutral-600 transition">
                Create Account
            </a>
        </div>
    </form>
</x-guest-layout>