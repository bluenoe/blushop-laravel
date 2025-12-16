{{--
High-End Fashion Editorial Landing Page
Redesign for BluShop - Inspired by COS, ZARA, LEMAIRE
Focus: Visual Hierarchy, Negative Space, Typography
--}}

<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ asset('images/hero-main.jpg') }}" fetchpriority="high">
    <style>
        /* Ẩn scrollbar nhưng vẫn scroll được để giữ thẩm mỹ */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white">

        {{-- ============================================
        HERO SECTION - BRAND STATEMENT
        Style: Fullscreen Image, Minimal Text overlay
        ============================================ --}}
        <section class="relative h-[95vh] w-full overflow-hidden bg-neutral-100">
            <div class="absolute inset-0">
                <img src="{{ asset('images/hero-main.jpg') }}" alt="BluShop Campaign"
                    class="w-full h-full object-cover object-center scale-100 transition-transform duration-[2s] hover:scale-105"
                    loading="eager" />
                {{-- Giảm độ tối overlay để ảnh tự nhiên hơn (Editorial style) --}}
                <div class="absolute inset-0 bg-black/10"></div>
            </div>

            {{-- Text đặt ở góc dưới (Bottom-Left) thay vì giữa - Trend hiện đại --}}
            <div class="absolute bottom-0 left-0 p-8 md:p-12 lg:p-16 z-10 max-w-2xl">
                <h1
                    class="text-white text-5xl md:text-7xl lg:text-8xl font-light tracking-tighter leading-none mb-4 mix-blend-difference">
                    TIMELESS <br> ESSENTIALS
                </h1>
                <div class="flex flex-col md:flex-row gap-6 items-start md:items-center pt-4">
                    <a href="{{ route('products.index') }}"
                        class="group inline-flex items-center gap-2 text-white text-sm tracking-[0.2em] uppercase border-b border-transparent hover:border-white transition-all pb-1">
                        Explore Collection
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================
        EDITORIAL BLOCK - "The Philosophy"
        Style: Split Screen (Text Left, Image Right)
        FIX: Added object-top & min-height to prevent cropping heads
        ============================================ --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-0 border-b border-neutral-100 lg:min-h-[600px]">
            {{-- Text Area --}}
            <div class="lg:col-span-5 flex items-center p-12 md:p-20 bg-white">
                <div data-reveal class="max-w-md">
                    <span class="block text-xs font-bold tracking-[0.3em] text-neutral-400 mb-6 uppercase">The
                        Philosophy</span>
                    <h2 class="text-3xl md:text-4xl font-light leading-tight mb-8">
                        Simplicity is the ultimate sophistication.
                    </h2>
                    <p class="text-neutral-600 font-light leading-relaxed mb-10 text-justify">
                        We believe in conscious design. Each piece is crafted to last beyond seasons, blending timeless
                        silhouettes with modern comfort. It's not just about clothes; it's about a way of life.
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block text-xs font-bold uppercase tracking-widest border-b border-neutral-900 pb-1 hover:text-neutral-600 hover:border-neutral-600 transition">
                        Read Our Story
                    </a>
                </div>
            </div>

            {{-- Image Area --}}
            {{-- Fix: Thay 'lg:h-auto' thành 'lg:h-full' để nó fill hết chiều cao của Grid --}}
            <div class="lg:col-span-7 h-[600px] lg:h-full bg-neutral-100 relative overflow-hidden">
                {{-- Fix: Thêm 'object-top' để neo ảnh lên trên, không bị cắt đầu --}}
                <img src="{{ asset('images/category-women.jpg') }}" alt="Philosophy"
                    class="absolute inset-0 w-full h-full object-cover object-top grayscale hover:grayscale-0 transition duration-700">
            </div>
        </section>

        {{-- ============================================
        NEW ARRIVALS - CLEAN GRID
        Style: Minimal Cards, No Buttons
        ============================================ --}}
        <section id="featured" class="py-20 md:py-32 px-4 md:px-8">
            <div class="max-w-[1800px] mx-auto">
                <div class="flex justify-between items-end mb-12 md:mb-16 px-2">
                    <h2 class="text-2xl md:text-3xl font-light tracking-wide uppercase">New Arrivals</h2>
                    <a href="{{ route('products.index') }}"
                        class="hidden md:block text-xs font-bold uppercase tracking-widest hover:underline">
                        View All
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-12 md:gap-x-8">
                    @forelse($featured as $product)
                    <div class="group cursor-pointer">
                        {{-- Image Container --}}
                        <div class="relative overflow-hidden bg-neutral-100 aspect-[3/4] mb-4">
                            <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full">
                                <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                    loading="lazy" />
                            </a>

                            {{-- Wishlist Button (Minimal, Top Right) --}}
                            <div class="absolute top-4 right-4 translate-y-[-10px] opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300"
                                x-data="{ id: {{ $product->id }} }">
                                <button @click.prevent="$store.wishlist.toggle(id)"
                                    class="text-neutral-900 hover:scale-110 transition">
                                    <svg class="w-6 h-6"
                                        :class="$store.wishlist.isFav(id) ? 'fill-neutral-900' : 'fill-none'"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="flex flex-col space-y-1">
                            <h3
                                class="text-sm tracking-wide font-normal text-neutral-900 group-hover:text-neutral-600 transition-colors">
                                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-light text-neutral-500">
                                    ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                                </span>
                                {{-- Màu sắc (Giả lập) - Thường thấy ở ZARA --}}
                                <div class="hidden group-hover:flex gap-1">
                                    <span class="w-2 h-2 rounded-full bg-neutral-800"></span>
                                    <span class="w-2 h-2 rounded-full bg-neutral-300"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center text-neutral-400 font-light">
                        Collection updating...
                    </div>
                    @endforelse
                </div>

                <div class="mt-12 text-center md:hidden">
                    <a href="{{ route('products.index') }}"
                        class="inline-block border border-neutral-900 px-8 py-3 text-xs font-bold uppercase tracking-widest">
                        View All Products
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================
        CAMPAIGN / CATEGORIES
        Style: Large Dual Banner
        ============================================ --}}
        <section class="grid grid-cols-1 md:grid-cols-2 h-auto md:h-[85vh]">
            @php
            $categories = [
            [
            'name' => 'WOMEN',
            'image' => 'category-women.jpg',
            'link' => route('products.index', ['category' => 'women'])
            ],
            [
            'name' => 'MEN',
            'image' => 'category-men.jpg',
            'link' => route('products.index', ['category' => 'men'])
            ],
            ];
            @endphp

            @foreach($categories as $cat)
            <div class="relative group h-[50vh] md:h-full overflow-hidden">
                <a href="{{ $cat['link'] }}" class="block w-full h-full">
                    <img src="{{ asset('images/' . $cat['image']) }}" alt="{{ $cat['name'] }}"
                        class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-105"
                        loading="lazy" />

                    {{-- Overlay khi hover --}}
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500">
                    </div>

                    {{-- Text giữa ảnh --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <h2 class="text-4xl md:text-6xl font-light text-white tracking-[0.2em] mb-4 drop-shadow-md">
                            {{ $cat['name'] }}
                        </h2>
                        <span
                            class="opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 delay-100 bg-white text-black px-6 py-2 text-xs font-bold uppercase tracking-widest">
                            Shop Now
                        </span>
                    </div>
                </a>
            </div>
            @endforeach
        </section>

        {{-- ============================================
        LOOKBOOK / COMMUNITY
        Style: Editorial Masonry / Horizontal Scroll
        ============================================ --}}
        <section class="py-20 md:py-32 bg-neutral-50 border-t border-neutral-200">
            <div class="max-w-[1800px] mx-auto px-4 md:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <span
                            class="text-xs font-bold tracking-[0.3em] uppercase text-neutral-400 block mb-2">#BluShop</span>
                        <h2 class="text-3xl md:text-4xl font-light uppercase tracking-wide">Journal</h2>
                    </div>
                    <p class="mt-4 md:mt-0 text-sm text-neutral-500 max-w-md text-right">
                        Daily inspiration from our community. <br>Tag us to be featured.
                    </p>
                </div>

                <div
                    class="flex overflow-x-auto gap-4 pb-8 md:grid md:grid-cols-4 md:gap-px md:bg-neutral-200 no-scrollbar">
                    @foreach($socialFeed as $index => $item)
                    @php
                    // Logic grid style "Tạp chí"
                    $gridClass = 'md:aspect-[3/4]'; // Default
                    if ($index === 0) $gridClass = 'md:col-span-2 md:aspect-square';
                    if ($index === 2) $gridClass = 'md:aspect-[3/4] md:translate-y-12'; // Lệch 1 chút cho nghệ
                    @endphp

                    <div class="min-w-[280px] md:min-w-0 bg-white relative group {{ $gridClass }}">
                        <img src="{{ Storage::url('products/' . $item['image']) }}" alt="Lookbook"
                            class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 transition duration-700" />

                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span
                                class="text-white tracking-widest text-xs uppercase border border-white px-4 py-2">View
                                Look</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        NEWSLETTER - MINIMAL
        Style: Clean text only
        ============================================ --}}
        <section class="py-24 bg-white text-center px-4">
            <div class="max-w-xl mx-auto" data-reveal>
                <h3 class="text-lg uppercase tracking-[0.2em] mb-8">Join Our Newsletter</h3>
                <form x-data="{ email: '', status: null }" @submit.prevent="status='success'"
                    class="flex flex-col gap-4">
                    <div class="relative border-b border-neutral-300 focus-within:border-neutral-900 transition-colors">
                        <input x-model="email" type="email" placeholder="Enter your email address"
                            class="w-full py-3 text-center bg-transparent border-none focus:ring-0 placeholder-neutral-400 text-neutral-900"
                            required />
                    </div>
                    <button type="submit"
                        class="text-xs font-bold uppercase tracking-widest text-neutral-500 hover:text-neutral-900 mt-4 transition">
                        Subscribe
                    </button>

                    <p x-show="status==='success'" x-transition class="text-xs text-green-600 mt-2">
                        You are on the list.
                    </p>
                </form>
            </div>
        </section>

        {{-- ============================================
        FOOTER STRIP (Thay thế Brand Values Icons)
        Style: Text Marquee or Simple Grid
        ============================================ --}}
        <div class="border-t border-neutral-100 py-6 bg-neutral-50">
            <div
                class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-8 md:gap-16 text-[10px] uppercase tracking-widest text-neutral-400">
                <span>Free Shipping Over 500k</span>
                <span>30-Day Returns</span>
                <span>Secure Checkout</span>
                <span>Sustainable Sourcing</span>
            </div>
        </div>

    </main>

    @include('partials.wishlist-script')

    @push('scripts')
    <script>
        // Simple fade-in animation logic
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                    }
                });
            }, { threshold: 0.05 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('transition-all', 'duration-1000', 'opacity-0', 'translate-y-8');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>