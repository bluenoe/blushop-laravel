<x-guest-layout>
    <div class="max-w-md mx-auto pt-10 pb-20 px-4 sm:px-0 text-center">

        {{-- Header --}}
        <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tighter mb-4">
            Verify Email
        </h1>

        <div class="text-sm text-neutral-500 font-light leading-relaxed mb-8">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the
            link we just emailed to you?') }}
        </div>

        @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-4 bg-green-50 border border-green-100">
            <p class="text-[10px] uppercase tracking-widest font-bold text-green-700">
                Link Sent
            </p>
            <p class="text-xs text-green-600 mt-1">
                A new verification link has been sent to your email.
            </p>
        </div>
        @endif

        <div class="space-y-6 mt-8">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-black text-white py-4 uppercase tracking-[0.2em] text-[10px] font-bold hover:bg-neutral-800 transition shadow-xl shadow-black/10 group">
                    <span class="group-hover:translate-x-1 transition-transform inline-block">
                        Resend Verification Email
                    </span>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black border-b border-transparent hover:border-black transition pb-0.5">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>