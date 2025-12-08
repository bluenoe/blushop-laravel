{{--
BluShop - High Conversion Landing Page
Style: Minimalist (Zara/COS inspired) but with Conversion Triggers
Stack: Laravel Blade + Tailwind CSS + Alpine.js
--}}

<x-app-layout>
    @push('head')
    {{-- Preload LCP Image --}}
    <link rel="preload" as="image" href="{{ asset('images/hero-main.jpg') }}" fetchpriority="high">
    {{-- Alpine.js for interactions (nếu chưa có trong layout chính thì uncomment dòng dưới) --}}
    {{--
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <style>
        /* Custom scrollbar ẩn cho trải nghiệm mượt mà hơn */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @endpush

    <main class="bg-white font-sans text-slate-900">

        {{-- ============================================
        1. ANNOUNCEMENT BAR (Top Bar) - Kích thích mua hàng
        ============================================ --}}
        <div class="bg-slate-900 text-white text-xs tracking-widest py-2.5 text-center uppercase relative z-50">
            <p class="animate-pulse">
                Miễn phí vận chuyển cho đơn từ 500k — <span class="font-bold text-yellow-400">Code:
                    BLUSHOPFREESHIP</span>
            </p>
        </div>

        {{-- ============================================
        2. HERO SECTION - Cinematic & Bold
        ============================================ --}}
        <section class="relative h-[calc(100vh-40px)] min-h-[600px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-slate-950">
                <img src="{{ asset('images/hero-main.jpg') }}" alt="BluShop New Collection"
                    class="w-full h-full object-cover opacity-80 scale-100 hover:scale-105 transition-transform duration-[2000ms] ease-out"
                    loading="eager" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20"></div>
            </div>

            <div class="relative z-10 text-center px-4 w-full max-w-5xl mx-auto">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
                    class="transition-all duration-1000 transform"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">

                    <span
                        class="inline-block py-1 px-3 border border-white/30 rounded-full text-white/80 text-xs uppercase tracking-[0.2em] mb-6 backdrop-blur-sm">
                        Fall / Winter 2025
                    </span>

                    <h1
                        class="text-5xl md:text-7xl lg:text-8xl font-light tracking-tighter text-white mb-6 drop-shadow-xl">
                        Simplicity <br class="hidden sm:block" /> <span class="italic font-serif">Redefined.</span>
                    </h1>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                        <a href="{{ route('products.index') }}"
                            class="group relative px-8 py-4 bg-white text-slate-900 min-w-[180px] overflow-hidden">
                            <span
                                class="relative z-10 text-sm font-bold tracking-widest uppercase group-hover:text-white transition-colors duration-300">
                                Shop Now
                            </span>
                            <div
                                class="absolute inset-0 bg-slate-900 transform scale-x-0 origin-left group-hover:scale-x-100 transition-transform duration-300 ease-out">
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
                <svg class="w-6 h-6 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </section>

        {{-- ============================================
        3. TRENDING NOW (Product Slider/Grid) - Conversion Focus
        ============================================ --}}
        <section id="featured" class="py-20 px-4 md:px-8 max-w-[1600px] mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-light mb-2">New Arrivals</h2>
                    <p class="text-gray-500 text-sm">Những món đồ được săn đón nhất tuần qua</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="hidden md:flex items-center gap-2 text-sm font-medium border-b border-black pb-0.5 hover:text-gray-600 transition">
                    View All <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            {{-- Grid with Quick Add feature --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                @forelse(($featured ?? collect())->take(4) as $product)
                <div class="group relative" x-data="{ hovered: false }" @mouseenter="hovered = true"
                    @mouseleave="hovered = false">
                    {{-- Image Container --}}
                    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100 mb-4">
                        {{-- Badges --}}
                        @if($loop->first)
                        <span
                            class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-bold px-2 py-1 uppercase tracking-wider z-20">
                            Best Seller
                        </span>
                        @else
                        <span
                            class="absolute top-3 left-3 bg-white text-slate-900 text-[10px] font-bold px-2 py-1 uppercase tracking-wider z-20">
                            New
                        </span>
                        @endif

                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105"
                                loading="lazy">
                        </a>

                        {{-- Quick Add Button (Trồi lên khi hover - Key feature của Zara/Uniqlo) --}}
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out z-20">
                            <button
                                class="w-full bg-white text-slate-900 py-3 text-xs font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-colors shadow-lg">
                                + Quick Add
                            </button>
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div>
                        <div class="flex justify-between items-start">
                            <h3 class="text-sm font-medium text-slate-900">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="text-sm font-medium text-slate-900">
                                ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Essentials' }}</p>

                        {{-- Color Swatches (Giả lập - Tạo cảm giác chuyên nghiệp) --}}
                        <div class="mt-3 flex gap-2">
                            <div
                                class="w-3 h-3 rounded-full bg-black border border-gray-300 ring-1 ring-offset-1 ring-transparent hover:ring-gray-400 cursor-pointer">
                            </div>
                            <div class="w-3 h-3 rounded-full bg-beige-200 border border-gray-300 ring-1 ring-offset-1 ring-transparent hover:ring-gray-400 cursor-pointer"
                                style="background-color: #d2b48c;"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-gray-400">Products loading...</div>
                @endforelse
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('products.index') }}"
                    class="inline-block border border-slate-900 px-6 py-3 text-sm font-medium uppercase">
                    View All Products
                </a>
            </div>
        </section>

        {{-- ============================================
        4. CATEGORY MOSAIC - Visual Hierarchy
        ============================================ --}}
        <section class="grid grid-cols-1 md:grid-cols-2 h-[600px] md:h-[800px]">
            {{-- Women --}}
            <div class="relative group overflow-hidden h-full">
                <img src="{{ asset('images/category-women.jpg') }}" alt="Women"
                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>
                <div class="absolute bottom-10 left-10 text-white">
                    <h3 class="text-4xl font-light mb-4">Women</h3>
                    <a href="{{ route('products.index', ['category' => 'women']) }}"
                        class="inline-block border-b-2 border-white pb-1 text-sm font-bold uppercase tracking-widest hover:text-gray-200 hover:border-gray-200 transition">
                        Shop Collection
                    </a>
                </div>
            </div>
            {{-- Men --}}
            <div class="relative group overflow-hidden h-full">
                <img src="{{ asset('images/category-men.jpg') }}" alt="Men"
                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>
                <div class="absolute bottom-10 left-10 text-white">
                    <h3 class="text-4xl font-light mb-4">Men</h3>
                    <a href="{{ route('products.index', ['category' => 'men']) }}"
                        class="inline-block border-b-2 border-white pb-1 text-sm font-bold uppercase tracking-widest hover:text-gray-200 hover:border-gray-200 transition">
                        Shop Collection
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================
        5. TRUST SIGNALS & BRAND PROMISE
        ============================================ --}}
        <section class="py-16 bg-slate-50 border-t border-slate-100">
            <div
                class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-slate-200">
                <div class="px-4 py-4">
                    <h4 class="font-bold text-sm uppercase tracking-widest mb-2 text-slate-900">Sustainable</h4>
                    <p class="text-gray-500 text-sm">Chất liệu thân thiện với môi trường, bao bì tái chế 100%.</p>
                </div>
                <div class="px-4 py-4">
                    <h4 class="font-bold text-sm uppercase tracking-widest mb-2 text-slate-900">Express Delivery</h4>
                    <p class="text-gray-500 text-sm">Giao hàng 2h nội thành HCM & HN. Đổi trả trong 30 ngày.</p>
                </div>
                <div class="px-4 py-4">
                    <h4 class="font-bold text-sm uppercase tracking-widest mb-2 text-slate-900">Secure Payment</h4>
                    <p class="text-gray-500 text-sm">Thanh toán an toàn qua VNPAY, Momo và Visa/Mastercard.</p>
                </div>
            </div>
        </section>

        {{-- ============================================
        6. NEWSLETTER - Clean & Functional
        ============================================ --}}
        <section class="py-24 bg-white text-center px-4">
            <div class="max-w-lg mx-auto">
                <h2 class="text-2xl font-light mb-2">Join the Club</h2>
                <p class="text-gray-500 text-sm mb-8">Đăng ký để nhận voucher 10% cho đơn hàng đầu tiên của bạn.</p>

                <form x-data="{ email: '', submitted: false }" @submit.prevent="submitted = true" class="relative">
                    <div class="flex border-b border-slate-300 focus-within:border-slate-900 transition-colors">
                        <input x-model="email" type="email" placeholder="Email address" required
                            class="w-full py-3 bg-transparent border-none focus:ring-0 placeholder-gray-400 text-slate-900">
                        <button type="submit"
                            class="text-xs font-bold uppercase tracking-widest text-slate-900 hover:text-indigo-600 transition">
                            Subscribe
                        </button>
                    </div>

                    {{-- Success Message --}}
                    <div x-show="submitted" x-transition
                        class="absolute top-full left-0 mt-2 text-xs text-green-600 font-medium">
                        Cảm ơn bạn! Hãy kiểm tra email để lấy mã giảm giá.
                    </div>
                </form>
            </div>
        </section>

    </main>

    {{-- Script Reveal Animation (Simplified) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-10');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section > div').forEach(el => {
                el.classList.add('transition-all', 'duration-1000', 'ease-out', 'opacity-0', 'translate-y-10');
                observer.observe(el);
            });
        });
    </script>
</x-app-layout>