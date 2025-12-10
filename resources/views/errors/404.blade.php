{{--
═══════════════════════════════════════════════════════════════
BluShop 404 Error - High-End Editorial Style (Updated)
Concept: Massive Outline Typography, Clean Search
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main
        class="bg-white min-h-[80vh] flex flex-col items-center justify-center text-neutral-900 px-6 relative overflow-hidden">

        {{-- Background "404" Watermark --}}
        {{-- UPDATE: Dùng Outline Text để rõ hơn nhưng vẫn tinh tế --}}
        <div
            class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden z-0">
            <span class="text-[25vw] font-black tracking-tighter leading-none translate-y-10"
                style="-webkit-text-stroke: 2px #E5E5E5; color: transparent;">
                404
            </span>
        </div>

        {{-- Content --}}
        <div
            class="relative z-10 max-w-xl w-full text-center space-y-10 bg-white/60 backdrop-blur-[2px] py-10 rounded-3xl">

            {{-- Header --}}
            <div class="space-y-4">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-neutral-400">Page Not Found</p>
                <h1 class="text-4xl md:text-6xl font-bold tracking-tight leading-tight">
                    Lost in the <br>
                    <span class="font-serif italic font-light text-neutral-500">Archives?</span>
                </h1>
                <p class="text-sm md:text-base text-neutral-500 font-light leading-relaxed max-w-md mx-auto">
                    The page you are looking for has been moved, removed, or never existed.
                </p>
            </div>

            {{-- Search Bar (Underline Style) --}}
            <form action="{{ route('products.index') }}" method="GET" class="max-w-sm mx-auto">
                <div class="relative group">
                    <input type="text" name="q" placeholder="Search for products..."
                        class="w-full py-3 bg-transparent border-b border-neutral-300 text-center text-sm focus:border-black focus:outline-none focus:ring-0 placeholder:text-neutral-300 transition-colors duration-300">
                    <button type="submit"
                        class="absolute right-0 top-1/2 -translate-y-1/2 text-neutral-300 group-focus-within:text-black hover:text-black transition duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                <a href="{{ route('home') }}"
                    class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                    Back to Home
                </a>
                <a href="{{ route('new-arrivals') }}"
                    class="inline-block px-10 py-4 border border-neutral-200 text-neutral-500 font-bold uppercase tracking-widest text-xs hover:border-black hover:text-black transition">
                    New Arrivals
                </a>
            </div>

        </div>

    </main>
</x-app-layout>