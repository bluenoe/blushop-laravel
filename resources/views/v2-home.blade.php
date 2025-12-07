{{--
═══════════════════════════════════════════════════════════════
BluShop Home v3 - Professional Minimalist
Concept: Art Gallery / Editorial Store
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ asset('images/hero-bg.jpg') }}" fetchpriority="high">
    <style>
        /* Ẩn thanh cuộn cho các thành phần cuộn ngang */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white">

        {{-- 1. HERO SECTION: Clean Split or Centered --}}
        <section class="relative min-h-[85vh] flex items-center bg-neutral-100 overflow-hidden">
            {{-- Background with Parallax effect --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/hero-bg.jpg') }}" alt="BluShop Essence"
                    class="w-full h-full object-cover opacity-90" style="object-position: center 30%;" loading="eager"
                    fetchpriority="high">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-[1px]"></div> {{-- Light overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/40 via-transparent to-transparent"></div>
            </div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 pt-20">
                <div class="max-w-3xl">
                    <p data-reveal class="text-xs md:text-sm font-bold tracking-[0.3em] uppercase text-white mb-6 pl-1">
                        Since 2025 • Student Essentials
                    </p>
                    <h1 data-reveal style="transition-delay: 100ms"
                        class="text-5xl md:text-7xl lg:text-8xl font-bold text-white tracking-tighter leading-[0.9] mb-8">
                        Simplicity <br>
                        <span class="font-serif italic font-light ml-4">in Motion.</span>
                    </h1>
                    <p data-reveal style="transition-delay: 200ms"
                        class="text-lg md:text-xl text-white/80 max-w-lg mb-10 font-light leading-relaxed pl-1 border-l border-white/30 pl-6">
                        Curated gear for the modern student. <br>
                        Minimalist design, maximum utility.
                    </p>

                    <div data-reveal style="transition-delay: 300ms" class="flex flex-col sm:flex-row gap-4 pl-1">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-black text-xs font-bold uppercase tracking-widest hover:bg-neutral-200 transition duration-300">
                            Shop Collection
                        </a>
                        <a href="#new-arrivals"
                            class="inline-flex items-center justify-center px-8 py-4 border border-white text-white text-xs font-bold uppercase tracking-widest hover:bg-white hover:text-black transition duration-300">
                            New Arrivals
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. MARQUEE STRIP (Chạy chữ) --}}
        <div class="bg-neutral-900 text-white py-3 overflow-hidden whitespace-nowrap border-y border-neutral-800">
            <div class="animate-marquee inline-block">
                @for($i=0; $i<6; $i++) <span class="mx-8 text-xs font-medium uppercase tracking-[0.2em]">
                    Free Shipping over 500k <span class="mx-4 text-neutral-600">•</span>
                    Student Discount Available <span class="mx-4 text-neutral-600">•</span>
                    30-Day Returns
                    </span>
                    @endfor
            </div>
        </div>

        {{-- 3. CURATED EDITS (Category) - Bento Grid Style --}}
        <section class="py-24 px-6 max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-12" data-reveal>
                <h2 class="text-3xl font-bold tracking-tight">Curated Edits</h2>
                <a href="{{ route('products.index') }}"
                    class="hidden md:inline-block text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:opacity-60 transition">View
                    All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6 h-auto md:h-[600px]">
                {{-- Edit 1: Large Left --}}
                <div class="md:col-span-5 relative group overflow-hidden bg-neutral-100 h-[400px] md:h-full cursor-pointer"
                    data-reveal>
                    <img src="{{ asset('images/cat-campus.jpg') }}" alt="Campus Ready"
                        class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition duration-500"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <span
                            class="text-[10px] uppercase tracking-widest border border-white/50 px-2 py-1 mb-2 inline-block backdrop-blur-sm">Everyday</span>
                        <h3 class="text-2xl font-bold">Campus Life</h3>
                    </div>
                    <a href="{{ route('products.index', ['cat' => 'campus']) }}" class="absolute inset-0 z-10"></a>
                </div>

                <div class="md:col-span-7 grid grid-rows-2 gap-4 md:gap-6">
                    {{-- Edit 2: Top Right --}}
                    <div class="relative group overflow-hidden bg-neutral-100 h-[300px] md:h-auto cursor-pointer"
                        data-reveal style="transition-delay: 100ms">
                        <img src="{{ asset('images/cat-tech.jpg') }}" alt="Tech Essentials"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition duration-500"></div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <span
                                class="text-[10px] uppercase tracking-widest border border-white/50 px-2 py-1 mb-2 inline-block backdrop-blur-sm">Tech</span>
                            <h3 class="text-2xl font-bold">Desk Setup</h3>
                        </div>
                        <a href="{{ route('products.index', ['cat' => 'tech']) }}" class="absolute inset-0 z-10"></a>
                    </div>

                    {{-- Edit 3 & 4: Bottom Right Split --}}
                    <div class="grid grid-cols-2 gap-4 md:gap-6">
                        <div class="relative group overflow-hidden bg-neutral-100 h-[250px] md:h-auto cursor-pointer"
                            data-reveal style="transition-delay: 200ms">
                            <img src="{{ asset('images/cat-acc.jpg') }}" alt="Accessories"
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="absolute bottom-6 left-6 text-white z-10">
                                <h3 class="text-lg font-bold">Accessories</h3>
                            </div>
                            <a href="{{ route('products.index', ['cat' => 'accessories']) }}"
                                class="absolute inset-0 z-10"></a>
                        </div>
                        <div class="relative group overflow-hidden bg-neutral-900 h-[250px] md:h-auto flex items-center justify-center text-center cursor-pointer"
                            data-reveal style="transition-delay: 300ms">
                            <div class="p-6">
                                <h3 class="text-white text-xl font-serif italic mb-2">New Drop</h3>
                                <p class="text-neutral-400 text-xs uppercase tracking-widest">Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. FEATURED PRODUCTS (Slider/Scroll) --}}
        <section id="new-arrivals" class="bg-neutral-50 py-24 overflow-hidden border-y border-neutral-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-2xl mb-12" data-reveal>
                    <span class="text-neutral-500 text-xs font-bold uppercase tracking-[0.2em] mb-2 block">Weekly
                        Selection</span>
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-neutral-900">Essential Pieces.</h2>
                </div>

                {{-- Horizontal Scroll Container --}}
                <div class="flex gap-6 overflow-x-auto hide-scrollbar pb-8 snap-x" data-reveal>
                    @if(($featured ?? collect())->isEmpty())
                    {{-- Placeholder for development --}}
                    @for($i=0; $i<4; $i++) <div class="min-w-[280px] md:min-w-[320px] snap-center bg-white p-4">
                        <div
                            class="bg-neutral-100 w-full h-[350px] mb-4 flex items-center justify-center text-neutral-300">
                            Product Image
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-wide">Blu Hoodie Basic</h3>
                        <p class="text-neutral-500 text-sm mt-1">550.000 ₫</p>
                </div>
                @endfor
                @else
                @foreach($featured as $product)
                <div class="min-w-[280px] md:min-w-[320px] snap-center group relative">
                    {{-- Minimal Product Card --}}
                    <div class="aspect-[4/5] overflow-hidden bg-white relative mb-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105 filter grayscale-[20%] group-hover:grayscale-0">

                        {{-- Quick Add Button (appears on hover) --}}
                        <button
                            class="absolute bottom-0 left-0 w-full bg-black text-white text-xs font-bold uppercase py-3 translate-y-full group-hover:translate-y-0 transition duration-300">
                            Add to Cart
                        </button>

                        {{-- Wishlist Icon --}}
                        <button class="absolute top-3 right-3 text-neutral-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <h3 class="text-sm font-bold text-neutral-900 leading-none">
                        <a href="{{ route('products.show', $product) }}">
                            <span class="absolute inset-0"></span>
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="text-sm text-neutral-500 mt-2 font-medium">{{ number_format($product->price) }} ₫</p>
                </div>
                @endforeach
                @endif
            </div>
            </div>
        </section>

        {{-- 5. SOCIAL PROOF: Minimal Typography --}}
        <section class="py-24 px-6 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div data-reveal>
                    <h2
                        class="text-6xl md:text-8xl font-bold tracking-tighter text-neutral-100 leading-none select-none">
                        TRUST<br>PILOT
                    </h2>
                    <div class="mt-[-2rem] ml-2 relative z-10">
                        <p class="text-lg font-medium mb-6">"Not just a brand, it's a student survival kit. <br>The
                            quality is unexpectedly good."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-neutral-200 rounded-full overflow-hidden">
                                {{-- Avatar --}}
                                <svg class="w-full h-full text-neutral-400 p-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold">Minh Nguyen</p>
                                <p class="text-xs text-neutral-500 uppercase tracking-wider">Verified Buyer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 border-l border-neutral-100 pl-8 md:pl-16" data-reveal
                    style="transition-delay: 200ms">
                    <div>
                        <span class="block text-4xl font-bold tracking-tighter mb-1">10k+</span>
                        <span class="text-xs text-neutral-500 uppercase tracking-widest">Community</span>
                    </div>
                    <div>
                        <span class="block text-4xl font-bold tracking-tighter mb-1">4.9</span>
                        <span class="text-xs text-neutral-500 uppercase tracking-widest">Star Rating</span>
                    </div>
                    <div>
                        <span class="block text-4xl font-bold tracking-tighter mb-1">24h</span>
                        <span class="text-xs text-neutral-500 uppercase tracking-widest">Dispatch</span>
                    </div>
                    <div>
                        <span class="block text-4xl font-bold tracking-tighter mb-1">VN</span>
                        <span class="text-xs text-neutral-500 uppercase tracking-widest">Local Made</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. FOOTER CTA --}}
        <section class="bg-black text-white py-20 text-center px-6">
            <div class="max-w-2xl mx-auto" data-reveal>
                <h2 class="text-3xl font-bold mb-6">Join the Inner Circle</h2>
                <p class="text-neutral-400 mb-8 font-light">Get early access to drops and exclusive student discounts.
                </p>
                <form class="flex max-w-md mx-auto border-b border-white/30 pb-2">
                    <input type="email" placeholder="Enter your email"
                        class="bg-transparent border-none w-full text-white placeholder-neutral-600 focus:ring-0 px-0">
                    <button type="submit"
                        class="text-xs font-bold uppercase tracking-widest hover:text-neutral-300">Subscribe</button>
                </form>
            </div>
        </section>

    </main>

    @push('scripts')
    <script>
        // Simple Reveal Effect
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-4', 'transition', 'duration-1000', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
    </style>
    @endpush
</x-app-layout>