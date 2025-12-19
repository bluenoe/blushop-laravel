<div class="mt-8">
    {{-- Divider Text --}}
    <div class="relative mb-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-neutral-200"></div>
        </div>
        <div class="relative flex justify-center text-xs uppercase tracking-widest">
            <span class="bg-white px-4 text-neutral-400">Or continue with</span>
        </div>
    </div>

    <div class="space-y-3">
        {{-- Google Button --}}
        <a href="#"
            class="relative flex w-full items-center justify-center gap-3 bg-white px-4 py-3 border border-neutral-200 hover:bg-neutral-50 transition shadow-sm group">
            <img src="{{ asset('images/google.svg') }}" alt="Google" class="h-5 w-5">
            <span class="text-[11px] font-bold uppercase tracking-[0.1em] text-neutral-600 group-hover:text-black">
                Google
            </span>
        </a>

        {{-- Apple Button --}}
        <a href="#"
            class="relative flex w-full items-center justify-center gap-3 bg-white px-4 py-3 border border-neutral-200 hover:bg-neutral-50 transition shadow-sm group">
            <img src="{{ asset('images/apple.svg') }}" alt="Apple" class="h-7 w-7">
            <span class="text-[13px] font-bold uppercase tracking-[0.1em] text-neutral-600 group-hover:text-black">
                Apple
            </span>
        </a>
    </div>
</div>