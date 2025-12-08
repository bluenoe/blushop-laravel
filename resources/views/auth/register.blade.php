<x-guest-layout>
    {{-- Header --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold tracking-tighter mb-2">Join the Inner Circle.</h1>
        <p class="text-sm text-neutral-500 font-light">
            Create an account to track orders & checkout faster.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-8">
        @csrf

        <div class="relative z-0 w-full group">
            <input type="text" name="name" id="name"
                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                placeholder=" " required autofocus autocomplete="name" value="{{ old('name') }}" />
            <label for="name"
                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                Full Name
            </label>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="relative z-0 w-full group">
            <input type="email" name="email" id="email"
                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                placeholder=" " required autocomplete="username" value="{{ old('email') }}" />
            <label for="email"
                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                Email Address
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="relative z-0 w-full group">
            <input type="password" name="password" id="password"
                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                placeholder=" " required autocomplete="new-password" />
            <label for="password"
                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                Password
            </label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="relative z-0 w-full group">
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                placeholder=" " required autocomplete="new-password" />
            <label for="password_confirmation"
                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                Confirm Password
            </label>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full py-4 bg-black text-white font-bold uppercase text-xs tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1">
                {{ __('Create Account') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <span class="text-xs text-neutral-500">Already have an account?</span>
            <a href="{{ route('login') }}"
                class="ml-1 text-xs font-bold uppercase tracking-wide border-b border-black pb-0.5 hover:text-neutral-600 hover:border-neutral-600 transition">
                Log In
            </a>
        </div>
    </form>
</x-guest-layout>