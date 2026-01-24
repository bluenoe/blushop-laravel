<div class="mt-8">
    {{-- Divider Text --}}
    <div class="relative mb-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-neutral-200"></div>
        </div>
        <div class="relative flex justify-center text-xs font-medium text-neutral-400">
            <span class="bg-white px-4">Or continue with</span>
        </div>
    </div>

    <div class="space-y-3">
        {{-- Google Button --}}
        <a href="#"
            class="relative flex w-full items-center justify-center gap-3 bg-white px-4 py-3.5 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition shadow-sm hover:shadow group">
            <img src="{{ asset('images/google.svg') }}" alt="Google" class="h-5 w-5">
            <span class="text-sm font-medium text-neutral-600 group-hover:text-black">
                Google
            </span>
        </a>

        {{-- Apple Button --}}
        <a href="#"
            class="relative flex w-full items-center justify-center gap-3 bg-white px-4 py-3.5 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition shadow-sm hover:shadow group">
            <img src="{{ asset('images/apple.svg') }}" alt="Apple" class="h-6 w-6">
            <span class="text-sm font-medium text-neutral-600 group-hover:text-black">
                Apple
            </span>
        </a>
    </div>
</div>