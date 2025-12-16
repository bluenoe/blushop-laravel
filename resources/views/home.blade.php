{{--
═══════════════════════════════════════════════════════════════
BluShop Home v5 - The "Lifestyle" Update
Focus: Women / Men / Fragrance
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    {{-- Preload Hero Image --}}
    <link rel="preload" as="image"
        href="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2000&auto=format&fit=crop"
        fetchpriority="high">
    <style>
        html {
            scroll-behavior: smooth;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 30s linear infinite;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white overflow-x-hidden">

        {{-- ==========================================
        1. HERO SECTION: Cinematic Fashion
        ========================================== --}}
        <section class="relative h-screen min-h-[700px] w-full overflow-hidden flex items-end pb-24 md:pb-32">
            {{-- Background Image (Thay ảnh thời trang xịn xò vào đây) --}}
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop"
                    alt="BluShop Campaign" class="w-full h-full object-cover object-center"
                    style="filter: brightness(0.85);" fetchpriority="high">
            </div>

            {{-- Content --}}
            <div
                class="relative z-10 w-full max-w-[1600px] mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                <div class="md:col-span-8">
                    <p data-reveal class="text-white/80 text-xs md:text-sm font-bold tracking-[0.3em] uppercase mb-4">
                        New Collection 2025
                    </p>
                    <h1 data-reveal style="transition-delay: 100ms"
                        class="text-6xl md:text-8xl lg:text-9xl font-bold text-white tracking-tighter leading-[0.85]">
                        QUIET <br> <span class="font-serif italic font-light">Luxury.</span>
                    </h1>
                </div>

                <div class="md:col-span-4 md:border-l md:border-white/30 md:pl-8 pb-2" data-reveal
                    style="transition-delay: 200ms">
                    <p class="text-white/90 text-lg font-light leading-relaxed mb-8 max-w-sm">
                        Essentials for the modern lifestyle. Refined silhouettes for Him & Her.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="group inline-flex items-center gap-3 text-white uppercase tracking-widest text-xs font-bold border-b border-white pb-2 hover:opacity-70 transition">
                        Shop The Look
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
        <section class="py-32 px-6 bg-white">
            <div class="max-w-4xl mx-auto text-center" data-reveal>
                <span class="text-neutral-400 text-[10px] font-bold uppercase tracking-[0.3em] mb-6 block">The
                    Concept</span>
                <h2 class="text-3xl md:text-5xl font-serif leading-tight text-neutral-900 mb-8">
                    "Simplicity is the ultimate <br> sophistication."
                </h2>
                <p class="text-neutral-500 text-sm md:text-base leading-relaxed max-w-2xl mx-auto font-light">
                    We curate distinct pieces that transcend seasons. From the perfect white tee to signature scents
                    that define your presence.
                </p>
            </div>
        </section>

        {{-- ==========================================
        3. CATEGORIES (NEW BENTO GRID)
        ========================================== --}}
        <section class="pb-24 px-4 md:px-8 max-w-[1600px] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 h-auto md:h-[700px]">

                {{-- 1. WOMEN (Lớn nhất - Bên trái) --}}
                <div class="md:col-span-6 relative group overflow-hidden h-[500px] md:h-full cursor-pointer"
                    data-reveal>
                    {{-- Ảnh placeholder Nữ --}}
                    <img src="https://images.unsplash.com/photo-1503342394128-c104d54dba01?q=80&w=1000&auto=format&fit=crop"
                        alt="Women" loading="lazy"
                        class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">

                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition"></div>
                    <div class="absolute bottom-10 left-10 text-white">
                        <h3 class="text-5xl font-bold tracking-tighter mb-2">Women</h3>
                        <p
                            class="text-sm font-light opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition duration-500">
                            Elegance in every stitch.
                        </p>
                    </div>
                    {{-- Link đến danh mục Women --}}
                    <a href="{{ route('products.index', ['category' => 'women']) }}" class="absolute inset-0 z-20"></a>
                </div>

                <div class="md:col-span-6 grid grid-rows-2 gap-4">

                    {{-- 2. MEN (Góc phải trên) --}}
                    <div class="relative group overflow-hidden h-[350px] md:h-full cursor-pointer" data-reveal
                        style="transition-delay: 100ms">
                        {{-- Ảnh placeholder Nam --}}
                        <img src="https://images.unsplash.com/photo-1516826957135-700dedea698c?q=80&w=1000&auto=format&fit=crop"
                            alt="Men" loading="lazy"
                            class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">

                        <div class="absolute inset-0 bg-black/10 transition"></div>
                        <div class="absolute bottom-8 left-8 text-white">
                            <h3 class="text-4xl font-bold tracking-tighter">Men</h3>
                            <p
                                class="text-xs uppercase tracking-widest mt-2 opacity-0 group-hover:opacity-100 transition duration-500">
                                Modern Utility</p>
                        </div>
                        <a href="{{ route('products.index', ['category' => 'men']) }}"
                            class="absolute inset-0 z-20"></a>
                    </div>

                    {{-- 3. FRAGRANCE (Góc phải dưới - Lifestyle) --}}
                    <div class="relative group overflow-hidden cursor-pointer" data-reveal
                        style="transition-delay: 200ms">
                        {{-- Ảnh placeholder Nước hoa --}}
                        <img src="https://images.unsplash.com/photo-1594035910387-fea477942698?q=80&w=1000&auto=format&fit=crop"
                            alt="Fragrance" loading="lazy"
                            class="w-full h-full object-cover transition duration-[1.5s] group-hover:scale-105">

                        <div class="absolute bottom-8 left-8 text-white z-10">
                            <h3 class="text-3xl font-serif italic">Fragrance</h3>
                            <p class="text-xs uppercase tracking-widest mt-1 opacity-80">Scent of a memory</p>
                        </div>
                        <a href="{{ route('products.index', ['category' => 'fragrance']) }}"
                            class="absolute inset-0 z-20"></a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==========================================
        4. WEEKLY ESSENTIALS
        ========================================== --}}
        <section class="py-24 px-6 max-w-[1600px] mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6" data-reveal>
                <div>
                    <h2 class="text-4xl font-bold tracking-tighter text-neutral-900">Weekly Essentials</h2>
                    <p class="text-neutral-500 mt-2 font-light">Hand-picked items trending this week.</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-500 transition">
                    View All Products
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-16 gap-x-8">
                @if(($featured ?? collect())->isEmpty())
                {{-- Mockup Data (Cập nhật cho khớp với SP mới) --}}
                @php
                $mockups = [
                ['name' => 'Santal 33 - Le Labo', 'price' => '4.500.000', 'cat'=>'Fragrance', 'img' =>
                'https://images.unsplash.com/photo-1594035910387-fea477942698?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Silk Camisole', 'price' => '229.000', 'cat'=>'Women', 'img' =>
                'https://images.unsplash.com/photo-1618221631726-563372ee02e9?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Everyday Hoodie', 'price' => '399.000', 'cat'=>'Men', 'img' =>
                'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=800&auto=format&fit=crop'],
                ['name' => 'Classic Trench', 'price' => '899.000', 'cat'=>'Women', 'img' =>
                'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop'],
                ];
                @endphp
                @foreach($mockups as $mock)
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-neutral-100 mb-4 overflow-hidden">
                        <img src="{{ $mock['img'] }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>
                    <h3 class="text-sm font-bold">{{ $mock['name'] }}</h3>
                    <p class="text-xs text-neutral-500">{{ $mock['cat'] }}</p>
                    <p class="text-sm font-medium mt-1">{{ $mock['price'] }} ₫</p>
                </div>
                @endforeach
                @else
                {{-- Real Data --}}
                @foreach($featured as $product)
                <div class="group relative cursor-pointer" data-reveal>
                    <div class="aspect-[3/4] w-full overflow-hidden bg-neutral-100 relative mb-5">
                        @php
                        // Logic lấy ảnh: Nếu là URL (unsplash) thì dùng luôn, nếu là tên file thì bọc Storage
                        $imgSrc = $product->image;
                        if (!Str::startsWith($imgSrc, 'http')) {
                        $imgSrc = Storage::url('products/'.$product->image);
                        }
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $product->name }}" loading="lazy"
                            class="w-full h-full object-cover transition duration-[1.2s] ease-out group-hover:scale-105">

                        <a href="{{ route('products.show', $product->id) }}" class="absolute inset-0 z-10"></a>
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h3
                                class="text-base font-medium text-neutral-900 group-hover:underline underline-offset-4 decoration-1">
                                {{ $product->name }}</h3>
                            <p class="text-xs text-neutral-500 mt-1 uppercase tracking-wider">
                                {{ $product->category->name ?? 'Essential' }}
                            </p>
                        </div>
                        <span class="text-sm font-bold">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </section>

        {{-- ==========================================
        5. CAMPAIGN (Monochrome Edit)
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
        6. MARQUEE (Updated Text)
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
        // Simple Reveal Animation
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