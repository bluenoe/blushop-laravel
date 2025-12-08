{{--
Premium Fashion Landing Page
Conversion-focused minimal design
Laravel Blade + Tailwind CSS
--}}

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discover timeless fashion essentials. Premium quality, conscious design.">
    <title>New Season Collection | Your Brand</title>

    {{-- Preload critical assets --}}
    <link rel="preload" as="image" href="{{ Storage::url('home/hero-main.webp') }}" fetchpriority="high">

    {{-- Tailwind CDN for demo - replace with your build process --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        [data-fade] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-fade].visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-fade] {
                transition: none;
                opacity: 1;
                transform: none;
            }
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.8) 100%);
        }

        .text-balance {
            text-wrap: balance;
        }

        .snap-x {
            scroll-snap-type: x mandatory;
        }

        .snap-center {
            scroll-snap-align: center;
        }

        .product-card {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>

<body class="bg-white text-slate-950 antialiased">

    {{-- Navigation --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}"
                    class="text-xl font-light tracking-tight text-slate-950 hover:text-indigo-600 transition-colors">
                    YOURNAME
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('products.index', ['category' => 'women']) }}"
                        class="text-sm font-medium text-slate-700 hover:text-slate-950 transition-colors">
                        Women
                    </a>
                    <a href="{{ route('products.index', ['category' => 'men']) }}"
                        class="text-sm font-medium text-slate-700 hover:text-slate-950 transition-colors">
                        Men
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="text-sm font-medium text-slate-700 hover:text-slate-950 transition-colors">
                        New Arrivals
                    </a>
                    <a href="{{ route('products.index', ['sale' => true]) }}"
                        class="text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors">
                        Sale
                    </a>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}"
                        class="hidden md:block text-slate-700 hover:text-slate-950 transition-colors"
                        aria-label="Shopping cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </a>

                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-btn" class="md:hidden text-slate-950" aria-label="Toggle menu"
                        aria-expanded="false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div id="mobile-menu"
        class="mobile-menu fixed top-0 right-0 bottom-0 w-full max-w-sm bg-white z-50 shadow-2xl md:hidden">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <span class="text-xl font-light tracking-tight">Menu</span>
                <button id="mobile-menu-close" aria-label="Close menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <nav class="space-y-6">
                    <a href="{{ route('products.index', ['category' => 'women']) }}"
                        class="block text-lg font-light text-slate-950 hover:text-indigo-600 transition-colors">
                        Women
                    </a>
                    <a href="{{ route('products.index', ['category' => 'men']) }}"
                        class="block text-lg font-light text-slate-950 hover:text-indigo-600 transition-colors">
                        Men
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="block text-lg font-light text-slate-950 hover:text-indigo-600 transition-colors">
                        New Arrivals
                    </a>
                    <a href="{{ route('products.index', ['sale' => true]) }}"
                        class="block text-lg font-light text-rose-600 hover:text-rose-700 transition-colors">
                        Sale
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="block text-lg font-light text-slate-950 hover:text-indigo-600 transition-colors">
                        Cart
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <main>
        {{-- ============================================
        HERO SECTION
        ============================================ --}}
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16">
            {{-- Background Image --}}
            <div class="absolute inset-0 bg-slate-950">
                <picture>
                    <source srcset="{{ Storage::url('home/hero-main.webp') }}" type="image/webp">
                    <source srcset="{{ Storage::url('home/hero-main.jpg') }}" type="image/jpeg">
                    <img src="{{ Storage::url('home/hero-main.jpg') }}" alt="New Season Collection"
                        class="w-full h-full object-cover object-center" loading="eager" decoding="async"
                        sizes="100vw" />
                </picture>
                <div class="absolute inset-0 hero-gradient"></div>
            </div>

            {{-- Hero Content --}}
            <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
                <div data-fade style="transition-delay: 100ms">
                    <p class="text-xs tracking-[0.4em] uppercase text-white/80 mb-6">
                        New Season 2025
                    </p>
                </div>

                <div data-fade style="transition-delay: 200ms">
                    <h1
                        class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-light tracking-tight text-white mb-8 leading-[1.1] text-balance">
                        Essential Minimalism
                    </h1>
                </div>

                <div data-fade style="transition-delay: 300ms">
                    <p
                        class="text-lg sm:text-xl lg:text-2xl text-white/90 font-light mb-12 max-w-2xl mx-auto text-balance">
                        Discover pieces designed to elevate your everyday wardrobe with timeless sophistication
                    </p>
                </div>

                <div data-fade style="transition-delay: 400ms">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#collection"
                            class="inline-flex items-center justify-center px-10 py-4 bg-white text-slate-950 text-sm font-medium tracking-wide uppercase hover:bg-slate-100 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            Explore Collection
                        </a>
                        <a href="{{ route('products.index', ['category' => 'women']) }}"
                            class="inline-flex items-center justify-center px-10 py-4 border-2 border-white text-white text-sm font-medium tracking-wide uppercase hover:bg-white hover:text-slate-950 transition-all duration-300">
                            Shop Women
                        </a>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <a href="#collection"
                class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-white/60 hover:text-white transition-colors group"
                aria-label="Scroll to collection">
                <span class="text-xs uppercase tracking-widest">Scroll</span>
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </section>

        {{-- ============================================
        BRAND STATEMENT
        ============================================ --}}
        <section class="py-24 sm:py-32 lg:py-40 bg-slate-50">
            <div class="max-w-5xl mx-auto px-6 text-center" data-fade>
                <p class="text-xs tracking-[0.4em] uppercase text-slate-500 mb-6">
                    Our Philosophy
                </p>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-light text-slate-950 mb-8 leading-tight text-balance">
                    Designed for life,<br />crafted to last
                </h2>
                <p class="text-lg sm:text-xl text-slate-700 leading-relaxed max-w-3xl mx-auto text-balance">
                    We create wardrobe essentials that transcend trends. Each piece is thoughtfully designed
                    with premium materials and meticulous attention to detail, ensuring quality that endures
                    season after season.
                </p>
            </div>
        </section>

        {{-- ============================================
        CURATED CATEGORIES
        ============================================ --}}
        <section id="collection" class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mb-16 text-center" data-fade>
                    <p class="text-xs tracking-[0.4em] uppercase text-slate-500 mb-4">
                        Shop By Category
                    </p>
                    <h2 class="text-4xl sm:text-5xl font-light text-slate-950">
                        Curated Collections
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    {{-- Women Category --}}
                    <article data-fade class="group relative overflow-hidden">
                        <a href="{{ route('products.index', ['category' => 'women']) }}" class="block">
                            <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio: 3/4">
                                <picture>
                                    <source srcset="{{ Storage::url('home/category-women.webp') }}" type="image/webp">
                                    <img src="{{ Storage::url('home/category-women.jpg') }}" alt="Women's Collection"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="lazy" decoding="async" />
                                </picture>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                                </div>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-10 text-white">
                                <h3 class="text-3xl lg:text-4xl font-light mb-3">
                                    Women
                                </h3>
                                <p class="text-sm text-white/90 mb-5 max-w-md">
                                    Refined silhouettes and contemporary elegance for the modern woman
                                </p>
                                <span
                                    class="inline-flex items-center gap-2 text-sm font-medium border-b border-white/50 group-hover:border-white transition-colors pb-1">
                                    Discover Collection
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </article>

                    {{-- Men Category --}}
                    <article data-fade class="group relative overflow-hidden">
                        <a href="{{ route('products.index', ['category' => 'men']) }}" class="block">
                            <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio: 3/4">
                                <picture>
                                    <source srcset="{{ Storage::url('home/category-men.webp') }}" type="image/webp">
                                    <img src="{{ Storage::url('home/category-men.jpg') }}" alt="Men's Collection"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="lazy" decoding="async" />
                                </picture>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                                </div>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 p-8 lg:p-10 text-white">
                                <h3 class="text-3xl lg:text-4xl font-light mb-3">
                                    Men
                                </h3>
                                <p class="text-sm text-white/90 mb-5 max-w-md">
                                    Classic pieces reimagined with contemporary details and premium fabrics
                                </p>
                                <span
                                    class="inline-flex items-center gap-2 text-sm font-medium border-b border-white/50 group-hover:border-white transition-colors pb-1">
                                    Discover Collection
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        {{-- ============================================
        FEATURED PRODUCTS
        ============================================ --}}
        <section class="py-16 sm:py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mb-16 text-center" data-fade>
                    <p class="text-xs tracking-[0.4em] uppercase text-slate-500 mb-4">
                        Bestsellers
                    </p>
                    <h2 class="text-4xl sm:text-5xl font-light text-slate-950 mb-6">
                        Featured Pieces
                    </h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Our most-loved essentials, chosen by our community
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                    @php
                    $featured = [
                    ['name' => 'Essential Trench Coat', 'price' => 1890000, 'image' => 'product-1.jpg', 'category' =>
                    'Outerwear'],
                    ['name' => 'Cashmere Blend Sweater', 'price' => 890000, 'image' => 'product-2.jpg', 'category' =>
                    'Knitwear'],
                    ['name' => 'Tailored Wide-Leg Trousers', 'price' => 690000, 'image' => 'product-3.jpg', 'category'
                    => 'Bottoms'],
                    ['name' => 'Silk Relaxed Shirt', 'price' => 590000, 'image' => 'product-4.jpg', 'category' =>
                    'Tops'],
                    ];
                    @endphp

                    @foreach($featured as $product)
                    <article data-fade class="product-card group">
                        <a href="{{ route('products.show', Str::slug($product['name'])) }}" class="block">
                            <div class="relative overflow-hidden bg-white mb-4" style="aspect-ratio: 3/4">
                                <picture>
                                    <source
                                        srcset="{{ Storage::url('home/' . pathinfo($product['image'], PATHINFO_FILENAME) . '.webp') }}"
                                        type="image/webp">
                                    <img src="{{ Storage::url('home/' . $product['image']) }}"
                                        alt="{{ $product['name'] }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy" decoding="async" />
                                </picture>
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <p class="text-xs uppercase tracking-wider text-slate-500">
                                    {{ $product['category'] }}
                                </p>
                                <h3
                                    class="text-sm font-medium text-slate-950 group-hover:text-indigo-600 transition-colors">
                                    {{ $product['name'] }}
                                </h3>
                                <p class="text-sm font-medium text-slate-950">
                                    ₫{{ number_format($product['price'], 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>

                <div class="mt-12 text-center" data-fade>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-2 text-sm font-medium text-slate-950 border-b-2 border-slate-950 hover:border-indigo-600 hover:text-indigo-600 transition-colors pb-1">
                        View All Products
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================
        SOCIAL PROOF / TESTIMONIALS
        ============================================ --}}
        <section class="py-24 sm:py-32 lg:py-40 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mb-16 text-center" data-fade>
                    <p class="text-xs tracking-[0.4em] uppercase text-slate-500 mb-4">
                        Testimonials
                    </p>
                    <h2 class="text-4xl sm:text-5xl font-light text-slate-950">
                        Loved By Many
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    @php
                    $testimonials = [
                    ['text' => 'The quality is exceptional. These pieces have become staples in my wardrobe, and they
                    only get better with time.', 'author' => 'Sarah Chen', 'role' => 'Creative Director'],
                    ['text' => 'Finally found a brand that understands timeless design. Every item feels carefully
                    considered and built to last.', 'author' => 'Michael Park', 'role' => 'Architect'],
                    ['text' => 'Investing in fewer, better pieces has transformed how I dress. This is exactly what
                    conscious fashion should be.', 'author' => 'Emma Rodriguez', 'role' => 'Stylist'],
                    ];
                    @endphp

                    @foreach($testimonials as $testimonial)
                    <div data-fade class="space-y-6">
                        <div class="flex gap-1 text-slate-950">
                            @for($i = 0; $i < 5; $i++) <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                @endfor
                        </div>
                        <p class="text-lg text-slate-700 leading-relaxed">
                            "{{ $testimonial['text'] }}"
                        </p>
                        <div>
                            <p class="font-medium text-slate-950">{{ $testimonial['author'] }}</p>
                            <p class="text-sm text-slate-500">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        VALUES / TRUST SIGNALS
        ============================================ --}}
        <section class="py-16 sm:py-24 bg-slate-50 border-y border-slate-200">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
                    @php
                    $values = [
                    ['icon' => 'truck', 'title' => 'Free Shipping', 'desc' => 'Orders over ₫500,000'],
                    ['icon' => 'shield', 'title' => 'Secure Checkout', 'desc' => 'SSL encrypted'],
                    ['icon' => 'refresh', 'title' => '30-Day Returns', 'desc' => 'Easy exchanges'],
                    ['icon' => 'leaf', 'title' => 'Sustainable', 'desc' => 'Ethical production'],
                    ];
                    @endphp

                    @foreach($values as $value)
                    <div data-fade class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div
                                class="w-14 h-14 flex items-center justify-center rounded-full bg-white border border-slate-200">
                                @if($value['icon'] === 'truck')
                                <svg class="w-7 h-7 text-slate-950" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                @elseif($value['icon'] === 'shield')
                                <svg class="w-7 h-7 text-slate-950" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                @elseif($value['icon'] === 'refresh')
                                <svg class="w-7 h-7 text-slate-950" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                @else
                                <svg class="w-7 h-7 text-slate-950" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-950 mb-1">{{ $value['title'] }}</h3>
                            <p class="text-xs text-slate-600">{{ $value['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        NEWSLETTER CTA
        ============================================ --}}
        <section class="py-24 sm:py-32 lg:py-40 bg-white">
            <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center" data-fade>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-light text-slate-950 mb-6 text-balance">
                    Join Our Community
                </h2>
                <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto text-balance">
                    Subscribe for early access to new collections, exclusive offers, and style inspiration delivered to
                    your inbox.
                </p>
                {{-- Newsletter Subscription Form {{ route('newsletter.subscribe') }} --}}
                <form action="#" method="POST" class="max-w-lg mx-auto" id="newsletter-form">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" name="email" placeholder="Enter your email address" required
                            aria-label="Email address"
                            class="flex-1 px-6 py-4 text-sm border-2 border-slate-300 bg-white text-slate-950 placeholder:text-slate-400 focus:outline-none focus:border-slate-950 transition-colors" />
                        <button type="submit"
                            class="px-10 py-4 bg-slate-950 text-white text-sm font-medium tracking-wide uppercase hover:bg-indigo-600 transition-all duration-300 hover:scale-105">
                            Subscribe
                        </button>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">
                        By subscribing, you agree to our Privacy Policy and consent to receive updates.
                    </p>
                </form>
            </div>
        </section>
    </main>

    {{-- ============================================
    FOOTER
    ============================================ --}}
    <footer class="bg-slate-950 text-white py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                {{-- Brand --}}
                <div>
                    <h3 class="text-xl font-light tracking-tight mb-6">YOURNAME</h3>
                    <p class="text-sm text-white/70 leading-relaxed">
                        Timeless fashion for the conscious consumer. Quality pieces designed to last.
                    </p>
                </div>

                {{-- Shop --}}
                <div>
                    <h4 class="text-sm font-medium uppercase tracking-wider mb-4">Shop</h4>
                    <nav class="space-y-3">
                        <a href="{{ route('products.index', ['category' => 'women']) }}"
                            class="block text-sm text-white/70 hover:text-white transition-colors">
                            Women
                        </a>
                        <a href="{{ route('products.index', ['category' => 'men']) }}"
                            class="block text-sm text-white/70 hover:text-white transition-colors">
                            Men
                        </a>
                        <a href="{{ route('products.index') }}"
                            class="block text-sm text-white/70 hover:text-white transition-colors">
                            New Arrivals
                        </a>
                        <a href="{{ route('products.index', ['sale' => true]) }}"
                            class="block text-sm text-white/70 hover:text-white transition-colors">
                            Sale
                        </a>
                    </nav>
                </div>

                {{-- Help --}}
                <div>
                    <h4 class="text-sm font-medium uppercase tracking-wider mb-4">Help</h4>
                    <nav class="space-y-3">
                        <a href="#" class="block text-sm text-white/70 hover:text-white transition-colors">
                            Contact Us
                        </a>
                        <a href="#" class="block text-sm text-white/70 hover:text-white transition-colors">
                            Shipping Info
                        </a>
                        <a href="#" class="block text-sm text-white/70 hover:text-white transition-colors">
                            Returns
                        </a>
                        <a href="#" class="block text-sm text-white/70 hover:text-white transition-colors">
                            FAQ
                        </a>
                    </nav>
                </div>

                {{-- Social --}}
                <div>
                    <h4 class="text-sm font-medium uppercase tracking-wider mb-4">Follow Us</h4>
                    <div class="flex gap-4">
                        <a href="#" aria-label="Instagram" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Facebook" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Pinterest" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-white/50">
                    © 2025 YOURNAME. All rights reserved.
                </p>
                <div class="flex gap-6 text-xs text-white/50">
                    <a href="#" class="hover:text-white transition-colors">
                        Privacy Policy
                    </a>
                    <a href="#" class="hover:text-white transition-colors">
                        Terms of Service
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ============================================
    JAVASCRIPT
    ============================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ==========================================
            // Mobile Menu Toggle
            // ==========================================
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuClose = document.getElementById('mobile-menu-close');

            function openMobileMenu() {
                mobileMenu.classList.add('open');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                mobileMenu.classList.remove('open');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            mobileMenuBtn.addEventListener('click', openMobileMenu);
            mobileMenuClose.addEventListener('click', closeMobileMenu);

            // Close on escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
                    closeMobileMenu();
                }
            });

            // Close when clicking outside
            mobileMenu.addEventListener('click', function (e) {
                if (e.target === mobileMenu) {
                    closeMobileMenu();
                }
            });

            // ==========================================
            // Smooth Scroll
            // ==========================================
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        const offsetTop = target.offsetTop - 64; // Account for fixed nav
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });

                        // Close mobile menu if open
                        if (mobileMenu.classList.contains('open')) {
                            closeMobileMenu();
                        }
                    }
                });
            });

            // ==========================================
            // Fade-in on Scroll Animation
            // ==========================================
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!prefersReducedMotion) {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('[data-fade]').forEach(el => {
                    observer.observe(el);
                });
            } else {
                // If prefers reduced motion, show all elements immediately
                document.querySelectorAll('[data-fade]').forEach(el => {
                    el.classList.add('visible');
                });
            }

            // ==========================================
            // Newsletter Form Enhancement
            // ==========================================
            const newsletterForm = document.getElementById('newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function (e) {
                    // Add your AJAX submission logic here if needed
                    // For now, let it submit normally
                });
            }
        });
    </script>
</body>

</html>