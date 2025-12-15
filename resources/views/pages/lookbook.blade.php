{{--
═══════════════════════════════════════════════════════════════
BluShop Lookbook v1 - The Digital Magazine
Concept: Asymmetrical Grid, Sticky Details, Storytelling
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    <style>
        /* Ẩn scrollbar để trải nghiệm sạch hơn */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Hiệu ứng Parallax nhẹ cho ảnh full-width */
        .parallax-container {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white">

        {{-- 1. COVER / HERO SECTION --}}
        <section class="relative h-screen w-full flex items-end pb-12 sm:pb-24 px-6 overflow-hidden">
            {{-- Background Image --}}
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2670&auto=format&fit=crop"
                    alt="Lookbook Cover" class="w-full h-full object-cover object-top filter brightness-90">
            </div>

            {{-- Title Overlay --}}
            <div class="relative z-10 max-w-[1600px] mx-auto w-full grid grid-cols-1 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <p data-reveal class="text-white text-[10px] uppercase tracking-[0.4em] font-bold mb-4">
                        Collection No. 05
                    </p>
                    <h1 data-reveal style="transition-delay: 100ms"
                        class="text-6xl md:text-8xl lg:text-[9rem] font-bold text-white tracking-tighter leading-[0.8]">
                        URBAN <br>
                        <span class="font-serif italic font-light ml-4 md:ml-12">Solitude.</span>
                    </h1>
                </div>
                {{-- Scroll Indicator --}}
                <div class="lg:col-span-4 hidden lg:flex items-end justify-end pb-4" data-reveal
                    style="transition-delay: 300ms">
                    <div class="text-white text-xs uppercase tracking-widest flex items-center gap-4">
                        <span>Scroll to Explore</span>
                        <div class="h-[1px] w-12 bg-white"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. EDITORIAL INTRO --}}
        <section class="py-24 px-6 max-w-4xl mx-auto text-center" data-reveal>
            <h2 class="text-2xl md:text-4xl font-serif italic text-neutral-800 mb-8 leading-relaxed">
                "In the silence of the city, <br> style speaks the loudest."
            </h2>
            <p class="text-neutral-500 text-sm md:text-base font-light leading-7 max-w-xl mx-auto">
                This season, we explore the intersection of comfort and structure.
                Designed for the creative mind wandering through concrete jungles.
                Focusing on tactile fabrics, oversized silhouettes, and a monochrome palette.
            </p>
        </section>

        {{-- 3. LOOK 01: ASYMMETRICAL GRID (Sticky Description) --}}
        <section class="max-w-[1600px] mx-auto px-6 mb-32">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">

                {{-- Left Image (Large) --}}
                <div class="lg:col-span-7" data-reveal>
                    <div class="aspect-[3/4] overflow-hidden bg-neutral-100 relative group">
                        <img src="https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?q=80&w=1964&auto=format&fit=crop"
                            alt="Look 01"
                            class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">
                        {{-- Hover Badge --}}
                        <div class="absolute bottom-6 left-6 opacity-0 group-hover:opacity-100 transition duration-500">
                            <span class="bg-white text-black text-[10px] font-bold uppercase px-4 py-2 tracking-widest">
                                Look 01
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Right Content (Sticky) --}}
                <div class="lg:col-span-5 relative">
                    <div class="lg:sticky lg:top-32 space-y-12" data-reveal style="transition-delay: 200ms">

                        {{-- Look Description --}}
                        <div>
                            <span class="text-neutral-400 text-[10px] uppercase tracking-[0.3em] block mb-4">01 — The
                                Layering</span>
                            <h3 class="text-3xl font-bold tracking-tight mb-4">Structure & Fluidity</h3>
                            <p class="text-neutral-500 font-light text-sm leading-relaxed mb-8">
                                Combining the rigidity of our structured oversized blazer with the softness of organic
                                cotton. A look defined by contrast.
                            </p>
                            <a href="#"
                                class="group inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-600 hover:border-neutral-600 transition">
                                Shop The Look
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>

                        {{-- Supporting Image (Small) --}}
                        <div
                            class="aspect-[4/5] w-2/3 ml-auto overflow-hidden bg-neutral-100 grayscale hover:grayscale-0 transition duration-700">
                            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. FULL WIDTH PARALLAX BREAK --}}
        <section class="w-full h-[80vh] mb-32 parallax-container flex items-center justify-center relative"
            style="background-image: url('https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative z-10 text-center text-white" data-reveal>
                <h2 class="text-5xl md:text-7xl font-serif italic mb-4">Atmosphere</h2>
                <p class="text-xs uppercase tracking-[0.3em] font-bold">Fall / Winter 2025</p>
            </div>
        </section>

        {{-- 5. LOOK 02 & 03: MAGAZINE SPREAD (2 Columns) --}}
        <section class="max-w-[1600px] mx-auto px-6 mb-32">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-12 items-end">

                {{-- Col 1 --}}
                <div class="space-y-4" data-reveal>
                    <div class="aspect-[3/4] overflow-hidden bg-neutral-100 relative group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1550614000-4b9519e02a29?q=80&w=2000&auto=format&fit=crop"
                            class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                        {{-- Quick Shop Overlay --}}
                        <div
                            class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span
                                class="bg-white/90 backdrop-blur text-black px-6 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                                View Products
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-start pt-2">
                        <div>
                            <h3 class="text-lg font-bold">Look 02</h3>
                            <p class="text-xs text-neutral-500">Oversized Coat / Wool Trousers</p>
                        </div>
                        <span class="text-xs font-bold border border-neutral-200 px-2 py-1">Featured</span>
                    </div>
                </div>

                {{-- Col 2 (Offset Down) --}}
                <div class="space-y-4 md:mb-[-100px]" data-reveal style="transition-delay: 150ms">
                    <div class="aspect-[3/4] overflow-hidden bg-neutral-100 relative group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1509631179647-b84928d50f0d?q=80&w=1974&auto=format&fit=crop"
                            class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span
                                class="bg-white/90 backdrop-blur text-black px-6 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                                View Products
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-start pt-2">
                        <div>
                            <h3 class="text-lg font-bold">Look 03</h3>
                            <p class="text-xs text-neutral-500">Knitted Vest / Leather Accessories</p>
                        </div>
                        <span class="text-xs font-bold border border-neutral-200 px-2 py-1">Featured</span>
                    </div>
                </div>

            </div>
        </section>

        {{-- 6. "SHOP THE LOOK" DETAIL SECTION (High Utility) --}}
        {{-- Spacer to account for the offset image above --}}
        <div class="h-24 md:h-48"></div>

        <section class="bg-neutral-50 py-24 lg:py-32 px-6 border-y border-neutral-200">
            <div class="max-w-[1400px] mx-auto">
                <div class="mb-16 text-center" data-reveal>
                    <h2 class="text-3xl font-bold tracking-tight mb-2">The Breakdown</h2>
                    <p class="text-neutral-500 text-sm font-light">Dissecting the essentials.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    {{-- Look Image --}}
                    <div class="lg:col-span-6" data-reveal>
                        <div
                            class="aspect-[4/5] bg-white p-4 shadow-sm border border-neutral-100 rotate-1 hover:rotate-0 transition duration-500">
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=2000&auto=format&fit=crop"
                                class="w-full h-full object-cover filter contrast-125">
                        </div>
                    </div>

                    {{-- Product List --}}
                    <div class="lg:col-span-6 space-y-2" data-reveal style="transition-delay: 200ms">

                        {{-- Product Item 1 --}}
                        <div
                            class="group flex items-center gap-6 p-4 border-b border-neutral-200 hover:bg-white hover:shadow-sm transition cursor-pointer">
                            <div class="w-20 h-24 bg-neutral-200 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="text-sm font-bold uppercase tracking-wider mb-1 group-hover:underline underline-offset-4">
                                    Classic Trench</h4>
                                <p class="text-xs text-neutral-500">Outerwear</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold">2.500.000 ₫</p>
                                <button
                                    class="text-[10px] uppercase font-bold text-neutral-400 mt-2 hover:text-black">Add
                                    to Cart</button>
                            </div>
                        </div>

                        {{-- Product Item 2 --}}
                        <div
                            class="group flex items-center gap-6 p-4 border-b border-neutral-200 hover:bg-white hover:shadow-sm transition cursor-pointer">
                            <div class="w-20 h-24 bg-neutral-200 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?q=80&w=800&auto=format&fit=crop"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="text-sm font-bold uppercase tracking-wider mb-1 group-hover:underline underline-offset-4">
                                    Oxford Shirt</h4>
                                <p class="text-xs text-neutral-500">Tops</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold">850.000 ₫</p>
                                <button
                                    class="text-[10px] uppercase font-bold text-neutral-400 mt-2 hover:text-black">Add
                                    to Cart</button>
                            </div>
                        </div>

                        {{-- Product Item 3 --}}
                        <div
                            class="group flex items-center gap-6 p-4 border-b border-neutral-200 hover:bg-white hover:shadow-sm transition cursor-pointer">
                            <div class="w-20 h-24 bg-neutral-200 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1542272454315-4c01d7abdf4a?q=80&w=800&auto=format&fit=crop"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="text-sm font-bold uppercase tracking-wider mb-1 group-hover:underline underline-offset-4">
                                    Leather Chelsea</h4>
                                <p class="text-xs text-neutral-500">Footwear</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold">1.200.000 ₫</p>
                                <button
                                    class="text-[10px] uppercase font-bold text-neutral-400 mt-2 hover:text-black">Add
                                    to Cart</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- 7. CTA / NEXT NAVIGATION --}}
        <section class="py-32 px-6 text-center">
            <div data-reveal>
                <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-neutral-400 mb-6">What's Next?</p>
                <h2
                    class="text-4xl md:text-6xl font-bold tracking-tighter mb-8 hover:italic transition-all duration-300 cursor-default">
                    The Modernist
                </h2>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-black text-white px-10 py-4 text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1">
                    Shop Full Collection
                </a>
            </div>
        </section>

    </main>

    {{-- Script Reveal Animation (Reused from your Home/Contact pages) --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-1000', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>