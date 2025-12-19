<x-guest-layout>
    <div class="max-w-md mx-auto pt-10 pb-20 px-4 sm:px-0">

        {{-- Header Section --}}
        <div class="text-center mb-12">
            <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tighter mb-3">
                Reset Password
            </h1>
            <p class="text-xs text-neutral-400 font-light leading-relaxed max-w-xs mx-auto">
                Enter the email associated with your account and we'll send you a link to reset your password.
            </p>
        </div>

        {{-- Session Status (Thông báo thành công) --}}
        @if (session('status'))
        <div class="mb-8 p-4 bg-neutral-50 border border-neutral-100 text-center">
            <p class="text-[10px] uppercase tracking-widest font-bold text-green-600">
                Email Sent Successfully
            </p>
            <p class="text-xs text-neutral-500 mt-1">Check your inbox (and spam folder).</p>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-10">
            @csrf

            {{-- Email Input (Style gạch chân High-Fashion) --}}
            <div class="group relative">
                <label for="email"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    Email Address
                </label>

                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                    class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-xl font-medium text-black focus:border-black focus:ring-0 placeholder-neutral-200 transition-all"
                    placeholder="name@example.com" />

                <x-input-error :messages="$errors->get('email')"
                    class="absolute -bottom-6 left-0 text-[10px] text-red-500 font-medium" />
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-6 pt-4">
                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-black text-white py-4 uppercase tracking-[0.2em] text-[10px] font-bold hover:bg-neutral-800 transition shadow-xl shadow-black/10 group">
                    <span class="group-hover:translate-x-1 transition-transform inline-block">
                        Send Reset Link
                    </span>
                </button>

                {{-- Back to Login --}}
                <div class="text-center">
                    <a href="{{ route('login') }}"
                        class="group inline-flex items-center gap-2 text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition">
                        <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Login
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>