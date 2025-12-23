<x-guest-layout>
    <div class="max-w-md mx-auto pt-10 pb-20 px-4 sm:px-0">

        {{-- Header Section --}}
        <div class="text-center mb-12">
            <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tighter mb-3">
                New Credentials
            </h1>
            <p class="text-xs text-neutral-400 font-light leading-relaxed max-w-xs mx-auto">
                Secure your account with a new password.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-10">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email Address (Readonly for aesthetics usually, but editable here) --}}
            <div class="group relative">
                <label for="email"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    Email Address
                </label>
                <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                    autocomplete="username"
                    class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-xl font-medium text-black focus:border-black focus:ring-0 placeholder-neutral-200 transition-all" />
                <x-input-error :messages="$errors->get('email')"
                    class="absolute -bottom-6 left-0 text-[10px] text-red-500 font-medium" />
            </div>

            {{-- Password --}}
            <div class="group relative">
                <label for="password"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    New Password
                </label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-xl font-medium text-black focus:border-black focus:ring-0 placeholder-neutral-200 transition-all" />
                <x-input-error :messages="$errors->get('password')"
                    class="absolute -bottom-6 left-0 text-[10px] text-red-500 font-medium" />
            </div>

            {{-- Confirm Password --}}
            <div class="group relative">
                <label for="password_confirmation"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    Confirm Password
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password"
                    class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-xl font-medium text-black focus:border-black focus:ring-0 placeholder-neutral-200 transition-all" />
                <x-input-error :messages="$errors->get('password_confirmation')"
                    class="absolute -bottom-6 left-0 text-[10px] text-red-500 font-medium" />
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-black text-white py-4 uppercase tracking-[0.2em] text-[10px] font-bold hover:bg-neutral-800 transition shadow-xl shadow-black/10 group">
                    <span class="group-hover:translate-x-1 transition-transform inline-block">
                        Reset Password
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>