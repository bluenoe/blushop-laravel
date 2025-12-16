{{--
═══════════════════════════════════════════════════════════════
BluShop Home v6 - Fixed Layout & Visual Hierarchy
Status: STABLE (Flexbox Hybrid Layout)
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    {{-- Preload Hero Image --}}
    <link rel="preload" as="image"
        href="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop"
        fetchpriority="high">
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Marquee Animation */
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 40s linear infinite;
        }

        /* Utility */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 overflow-x-hidden">

        {{-- ==========================================
        1. HERO SECTION
        ========================================== --}}
        <section class="relative h-screen min-h-[600px] w-full flex items-end pb-12 md:pb-24">
            {{-- Background --}}
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop"
                    alt="Campaign" class="w-full h-full object-cover object-center brightness-75">
            </div>

            {{-- Text Content --}}
            <div
                class="relative z-10 w-full max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-12 gap-8 items-end">
                <div class="md:col-span-8">
                    <p data-reveal class="text-white/90 text-xs md:text-sm font-bold tracking-[0.3em] uppercase mb-4">
                        Spring / Summer 2025
                    </p>
                    <h1 data-reveal style="transition-delay: 100ms"
                        class="text-5xl md:text-8xl lg:text-9xl font-bold text-white tracking-tighter leading-[0.9]">
                        QUIET <br> <span class="font-serif italic font-light">Luxury.</span>
                    </h1>
                </div>

                <div class="md:col-span-4 md:border-l md:border-white/30 md:pl-8 pb-1" data-reveal
                    style="transition-delay: 200ms">
                    <p class="text-white/90 text-base md:text-lg font-light leading-relaxed mb-8 max-w-sm">
                        Curated essentials for the modern minimalist. Timeless silhouettes for Him & Her.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="group inline-flex items-center gap-3 text-white uppercase tracking-widest text-xs font-bold border-b border-white pb-2 hover:opacity-70 transition">
                        Explore Collection
                        <svg class="w-4 h-4 transform group-hover:translate-x-2 transition duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ==========================================
        2. PHILOSOPHY
        ========================================== --}}
        <section class="py-24 md:py-32 px-6 bg-white">
            <div class="max-w-4xl mx-auto text-center" data-reveal>
                <span class="text-neutral-400 text-[10px] font-bold uppercase tracking-[0.3em] mb-6 block">The
                    Concept</span>
                <h2 class="text-3xl md:text-5xl font-serif leading-tight text-neutral-900 mb-8">
                    "Simplicity is the ultimate <br> sophistication."
                </h2>
                <p class="text-neutral-500 text-sm md:text-base leading-relaxed max-w-2xl mx-auto font-light">
                    We strip away the unnecessary, leaving only what truly matters: Quality, Function, and Form.
                    BluShop is an attempt to organize the modern lifestyle through carefully selected items.
                </p>
            </div>
        </section>

        {{-- ==========================================
        3. CATEGORIES (FIXED LAYOUT)
        ========================================== --}}
        <section class="pb-24 px-4 md:px-8 max-w-[1600px] mx-auto">
            {{-- Grid Container: Mobile 1 cột, Desktop 2 cột bằng nhau --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-auto md:h-[800px]">

                {{-- LEFT COLUMN: WOMEN (Full Height) --}}
                <div class="relative w-full h-[500px] md:h-full group overflow-hidden cursor-pointer bg-neutral-100"
                    data-reveal>
                    <img src="https://images.unsplash.com/photo-1548622722-1f74fa2772a5?q=80&w=1000&auto=format&fit=crop"
                        alt="Women" class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">

                    {{-- Overlay làm tối ảnh để nổi chữ --}}
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition z-10"></div>

                    {{-- Text Content (Z-Index cao hơn Overlay) --}}
                    <div class="absolute bottom-10 left-10 text-white z-20 pointer-events-none">
                        <h3 class="text-5xl md:text-6xl font-bold tracking-tighter mb-2">Women</h3>
                        <p
                            class="text-sm font-light opacity-80 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                            Elegance in every stitch.
                        </p>
                    </div>

                    {{-- Link bao trùm (Z-Index nằm giữa) --}}
                    <a href="{{ route('products.index', ['category' => 'women']) }}" class="absolute inset-0 z-10"></a>
                </div>

                {{-- RIGHT COLUMN: MEN & FRAGRANCE (Flex Column) --}}
                <div class="flex flex-col gap-4 h-full">

                    {{-- TOP: MEN (Flex Grow) --}}
                    <div class="relative flex-1 min-h-[350px] group overflow-hidden cursor-pointer bg-neutral-100"
                        data-reveal style="transition-delay: 100ms">
                        <img src="https://images.unsplash.com/photo-1617137984095-74e4e5e3613f?q=80&w=1000&auto=format&fit=crop"
                            alt="Men"
                            class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">

                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition z-10"></div>

                        <div class="absolute bottom-8 left-8 text-white z-20 pointer-events-none">
                            <h3 class="text-4xl md:text-5xl font-bold tracking-tighter">Men</h3>
                            <p
                                class="text-xs uppercase tracking-widest mt-2 opacity-80 group-hover:opacity-100 transition">
                                Modern Utility</p>
                        </div>

                        <a href="{{ route('products.index', ['category' => 'men']) }}"
                            class="absolute inset-0 z-10"></a>
                    </div>

                    {{-- BOTTOM: FRAGRANCE (Flex Grow) --}}
                    <div class="relative flex-1 min-h-[350px] group overflow-hidden cursor-pointer bg-neutral-100"
                        data-reveal style="transition-delay: 200ms">
                        <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?q=80&w=1000&auto=format&fit=crop"
                            alt="Fragrance"
                            class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">

                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition z-10"></div>

                        <div class="absolute bottom-8 left-8 text-white z-20 pointer-events-none">
                            <h3 class="text-3xl md:text-4xl font-serif italic">Fragrance</h3>
                            <p class="text-xs uppercase tracking-widest mt-2 opacity-80">Scent of a memory</p>
                        </div>

                        <a href="{{ route('products.index', ['category' => 'fragrance']) }}"
                            class="absolute inset-0 z-10"></a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==========================================
        4. WEEKLY ESSENTIALS
        ========================================== --}}
        <section class="py-24 px-6 max-w-[1600px] mx-auto border-t border-neutral-100">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6" data-reveal>
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tighter text-neutral-900">Weekly Essentials</h2>
                    <p class="text-neutral-500 mt-2 font-light">Hand-picked items trending this week.</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-500 transition">
                    View All Products
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-12 gap-x-8">
                @if(isset($featured) && $featured->count() > 0)
                @foreach($featured as $product)
                <div class="group relative cursor-pointer" data-reveal>
                    <div class="aspect-[3/4] w-full overflow-hidden bg-neutral-100 relative mb-4">
                        @php
                        $imgSrc = $product->image;
                        if (!Str::contains($imgSrc, 'http')) {
                        $imgSrc = Storage::url('products/' . $imgSrc);
                        }
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $product->name }}" loading="lazy"
                            class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-105">

                        {{-- Quick View Button --}}
                        <div
                            class="absolute bottom-4 left-0 right-0 flex justify-center opacity-0 group-hover:opacity-100 transition duration-300 z-20">
                            <span
                                class="bg-white text-black text-[10px] font-bold uppercase px-6 py-3 tracking-widest hover:bg-black hover:text-white transition shadow-lg">
                                Quick View
                            </span>
                        </div>
                        <a href="{{ route('products.show', $product->id) }}" class="absolute inset-0 z-10"></a>
                    </div>

                    <div class="flex justify-between items-start">
                        <div>
                            <h3
                                class="text-sm font-bold text-neutral-900 group-hover:underline underline-offset-4 decoration-1">
                                {{ $product->name }}
                            </h3>
                            <p class="text-[10px] text-neutral-500 mt-1 uppercase tracking-wider">
                                {{ $product->category->name ?? 'Collection' }}
                            </p>
                        </div>
                        <span class="text-sm font-medium">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    </div>
                </div>
                @endforeach
                @else
                {{-- Fallback nếu chưa có data thật --}}
                <div class="col-span-4 text-center py-12 border border-dashed border-neutral-200">
                    <p class="text-neutral-400">No featured products found.</p>
                </div>
                @endif
            </div>
        </section>

        {{-- ==========================================
        5. CAMPAIGN (Monochrome)
        ========================================== --}}
        <section class="bg-[#1a1a1a] text-white py-24 md:py-32 overflow-hidden relative">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full text-center pointer-events-none opacity-5 whitespace-nowrap select-none">
                <span class="text-[20vw] font-bold uppercase tracking-tighter leading-none">BluShop</span>
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div class="order-2 md:order-1" data-reveal>
                        <div class="mb-8">
                            <span
                                class="inline-block border border-white/30 px-3 py-1 text-[10px] uppercase tracking-widest mb-4 rounded-full">Editorial</span>
                            <h2 class="text-4xl md:text-6xl font-bold tracking-tight mb-6">The Monochrome <br> Edit.
                            </h2>
                            <p class="text-neutral-400 text-lg font-light leading-relaxed max-w-md">
                                Focusing on shades of grey, black, and white. A collection designed to blend in, yet
                                stand out through texture and silhouette.
                            </p>
                        </div>
                        <a href="{{ route('products.index') }}"
                            class="inline-block bg-white text-black px-8 py-4 text-xs font-bold uppercase tracking-widest hover:bg-neutral-200 transition">
                            Explore Collection
                        </a>
                    </div>
                    <div class="order-1 md:order-2 relative" data-reveal style="transition-delay: 200ms">
                        <div class="aspect-[4/5] overflow-hidden bg-neutral-800 relative z-10">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1000&auto=format&fit=crop"
                                alt="Lookbook" loading="lazy" class="w-full h-full object-cover opacity-90">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==========================================
        6. MARQUEE
        ========================================== --}}
        <div class="bg-white py-8 border-b border-neutral-100 overflow-hidden">
            <div
                class="animate-marquee whitespace-nowrap flex gap-12 text-neutral-300 font-bold text-4xl md:text-6xl uppercase tracking-tighter select-none">
                <span>Timeless Design</span> • <span>Premium Quality</span> • <span>Modern Luxury</span> •
                <span>Timeless Design</span> • <span>Premium Quality</span> • <span>Modern Luxury</span> •
                <span>Timeless Design</span> • <span>Premium Quality</span> • <span>Modern Luxury</span>
            </div>
        </div>

        {{-- ==========================================
        7. NEWSLETTER
        ========================================== --}}
        <section class="py-32 px-6 bg-white text-center">
            <div class="max-w-xl mx-auto" data-reveal>
                <h2 class="text-3xl font-bold tracking-tight mb-4">Join the Inner Circle</h2>
                <p class="text-neutral-500 font-light mb-10">Sign up for exclusive drops, early access, and minimalist
                    inspiration.</p>

                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Email address"
                        class="w-full bg-neutral-50 border-neutral-200 focus:border-black focus:ring-0 text-sm px-4 py-3 placeholder-neutral-400">
                    <button type="submit"
                        class="bg-black text-white px-8 py-3 text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
                <p class="text-[10px] text-neutral-400 mt-4">No spam. Unsubscribe anytime.</p>
            </div>
        </section>

    </main>

    @push('scripts')
    <script>
        // Reveal Animation Logic
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-8', 'transition', 'duration-1000', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>