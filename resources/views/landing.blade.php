{{--
Blushop Premium Landing Page
Minimal, accessible, conversion-optimized design
Laravel Blade + Tailwind CSS + Storage integration
--}}

<x-app-layout>
    @push('head')
    {{-- SEO Meta Tags --}}
    <title>Blushop - Premium Fashion & Lifestyle Essentials</title>
    <meta name="description"
        content="Discover timeless fashion pieces and curated lifestyle accessories. Premium quality, minimalist design, sustainable materials. Free shipping on orders over ₫500,000.">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Blushop - Premium Fashion & Lifestyle">
    <meta property="og:description" content="Curated wardrobe essentials for everyday elegance">
    <meta property="og:image" content="{{ asset('images/og-blushop.jpg') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blushop - Premium Fashion">
    <meta name="twitter:description" content="Timeless essentials for modern living">
    <meta name="twitter:image" content="{{ asset('images/og-blushop.jpg') }}">

    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Preload critical hero image --}}
    <link rel="preload" as="image" href="{{ Storage::url('home/banners/hero-desktop.webp') }}" type="image/webp"
        fetchpriority="high">

    {{-- JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Blushop",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('images/logo.png') }}",
      "description": "Premium fashion and lifestyle e-commerce",
      "sameAs": [
        "https://www.instagram.com/blushop",
        "https://www.facebook.com/blushop"
      ]
    }
    </script>
    @endpush

    <main class="bg-white antialiased">
        {{-- ============================================
        HERO SECTION - Premium fullscreen with responsive images
        ============================================ --}}
        <header class="relative h-screen min-h-[600px] max-h-[900px] flex items-center justify-center overflow-hidden"
            role="banner">
            {{-- Responsive Background Image with Picture element --}}
            <figure class="absolute inset-0 bg-neutral-900 m-0">
                <picture>
                    {{-- WebP format for modern browsers --}}
                    <source type="image/webp" srcset="{{ Storage::url('home/banners/hero-mobile.webp') }} 640w,
                                {{ Storage::url('home/banners/hero-tablet.webp') }} 1024w,
                                {{ Storage::url('home/banners/hero-desktop.webp') }} 1920w" sizes="100vw">

                    {{-- JPEG fallback --}}
                    <source type="image/jpeg" srcset="{{ Storage::url('home/banners/hero-mobile.jpg') }} 640w,
                                {{ Storage::url('home/banners/hero-tablet.jpg') }} 1024w,
                                {{ Storage::url('home/banners/hero-desktop.jpg') }} 1920w" sizes="100vw">

                    {{-- Fallback img tag --}}
                    <img src="{{ Storage::url('home/banners/hero-desktop.jpg') }}"
                        alt="Blushop premium fashion collection featuring minimalist wardrobe essentials"
                        class="w-full h-full object-cover object-center opacity-90" loading="eager" fetchpriority="high"
                        decoding="async" width="1920" height="1080">
                </picture>

                {{-- Gradient overlay for readability --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/50"
                    aria-hidden="true"></div>
            </figure>

            {{-- Hero Content - Accessible & Centered --}}
            <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
                <div data-reveal style="transition-delay: 200ms"
                    class="opacity-0 translate-y-8 transition-all duration-1000 ease-out">

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-light tracking-tight text-white mb-4 sm:mb-6 leading-[1.1]">
                        Timeless Essentials
                    </h1>

                    <p
                        class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/90 font-light mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed">
                        Curated wardrobe pieces designed for everyday elegance
                    </p>

                    {{-- Primary CTA --}}
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-8 lg:px-10 py-3.5 lg:py-4 
                                   bg-white text-neutral-900 text-sm lg:text-base font-medium tracking-wide uppercase 
                                   hover:bg-neutral-100 focus:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-neutral-900
                                   transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]"
                            aria-label="Browse our full product collection">
                            Discover Collection
                        </a>

                        <a href="#featured" class="inline-flex items-center justify-center w-full sm:w-auto px-8 lg:px-10 py-3.5 lg:py-4 
                                   border-2 border-white text-white text-sm lg:text-base font-medium tracking-wide uppercase 
                                   hover:bg-white hover:text-neutral-900 focus:bg-white focus:text-neutral-900 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-neutral-900
                                   transition-all duration-300" aria-label="View new arrival products">
                            Shop New Arrivals
                        </a>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator with reduced motion support --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 motion-reduce:hidden">
                <a href="#philosophy"
                    class="flex flex-col items-center gap-2 text-white/70 hover:text-white focus:text-white focus:outline-none transition group"
                    aria-label="Scroll to content">
                    <span class="text-xs uppercase tracking-widest font-light">Scroll</span>
                    <svg class="w-5 h-5 animate-bounce motion-reduce:animate-none" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </a>
            </div>
        </header>

        {{-- ============================================
        BRAND PHILOSOPHY - Minimal text block
        ============================================ --}}
        <section id="philosophy" class="py-20 sm:py-28 lg:py-32 bg-neutral-50" aria-labelledby="philosophy-heading">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-reveal>
                <p class="text-xs tracking-[0.3em] uppercase text-neutral-500 mb-4 font-medium">Our Philosophy</p>

                <h2 id="philosophy-heading"
                    class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-light text-neutral-900 mb-6 leading-tight">
                    Less, but better
                </h2>

                <p class="text-base sm:text-lg lg:text-xl text-neutral-700 leading-relaxed max-w-2xl mx-auto">
                    We believe in conscious design. Each piece is crafted to last beyond seasons,
                    blending timeless silhouettes with modern comfort. Quality over quantity, always.
                </p>
            </div>
        </section>

        {{-- ============================================
        FEATURED COLLECTION - Large visual grid
        ============================================ --}}
        <section id="featured" class="py-16 sm:py-20 lg:py-24 bg-white" aria-labelledby="featured-heading">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <header class="mb-12 lg:mb-16 text-center" data-reveal>
                    <p class="text-xs tracking-[0.3em] uppercase text-neutral-500 mb-3 font-medium">New Season</p>
                    <h2 id="featured-heading" class="text-3xl sm:text-4xl lg:text-5xl font-light text-neutral-900">
                        Featured Collection
                    </h2>
                </header>

                {{-- Product Grid - Asymmetric Layout --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                    @forelse(($featured ?? collect())->take(6) as $index => $product)
                    <article data-reveal
                        class="group relative overflow-hidden {{ $index === 0 ? 'sm:col-span-2 lg:col-span-1 lg:row-span-2' : '' }}"
                        itemscope itemtype="https://schema.org/Product">

                        {{-- Product Image with lazy loading --}}
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                            class="block relative overflow-hidden bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2"
                            style="aspect-ratio: {{ $index === 0 ? '3/4' : '4/5' }}"
                            aria-label="View {{ $product->name }} product details">

                            <picture>
                                <source type="image/webp"
                                    srcset="{{ Storage::url('products/' . pathinfo($product->image, PATHINFO_FILENAME) . '.webp') }}"
                                    onerror="this.style.display='none'">

                                <img src="{{ Storage::url('products/' . $product->image) }}"
                                    alt="{{ $product->name }} - {{ $product->category->name ?? 'Fashion item' }}"
                                    itemprop="image"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 motion-reduce:transition-none motion-reduce:hover:scale-100"
                                    loading="lazy" decoding="async" width="600" height="750">
                            </picture>

                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300 motion-reduce:transition-none"
                                aria-hidden="true"></div>
                        </a>

                        {{-- Product Info - Minimal & Semantic --}}
                        <div class="mt-4 space-y-1">
                            <h3 class="text-sm sm:text-base font-medium text-neutral-900 group-hover:text-neutral-600 transition-colors"
                                itemprop="name">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                                    class="focus:outline-none focus:underline">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            @if ($product->category && $product->category->name != 'Uncategorized')
                            <p class="text-xs text-neutral-500" itemprop="category">
                                {{ $product->category->name }}
                            </p>
                            @endif

                            <p class="text-sm sm:text-base font-medium text-neutral-900" itemprop="offers" itemscope
                                itemtype="https://schema.org/Offer">
                                <span itemprop="priceCurrency" content="VND">₫</span><span itemprop="price"
                                    content="{{ $product->price }}">{{ number_format((float) $product->price, 0, ',',
                                    '.') }}</span>
                            </p>
                        </div>
                    </article>
                    @empty
                    {{-- Empty State --}}
                    <div class="col-span-full py-12 text-center">
                        <p class="text-neutral-500 text-base">Collection coming soon</p>
                    </div>
                    @endforelse
                </div>

                {{-- View All CTA --}}
                <footer class="mt-12 lg:mt-16 text-center" data-reveal>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm sm:text-base font-medium text-neutral-900 
                               border-b-2 border-neutral-900 hover:border-neutral-600 hover:text-neutral-600 
                               focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-4
                               transition-colors pb-1" aria-label="Browse all products in our collection">
                        View Full Collection
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </footer>
            </div>
        </section>

        {{-- ============================================
        CATEGORY SPOTLIGHT - Image + Text blocks
        ============================================ --}}
        <section class="py-16 sm:py-20 lg:py-24 bg-neutral-50" aria-labelledby="categories-heading">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 id="categories-heading" class="sr-only">Shop by Category</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    @php
                    $categories = [
                    [
                    'name' => 'Women',
                    'desc' => 'Effortless elegance for the modern woman',
                    'image' => 'categories/women.webp',
                    'link' => route('products.index', ['category' => 'women']),
                    ],
                    [
                    'name' => 'Men',
                    'desc' => 'Classic pieces, contemporary style',
                    'image' => 'categories/men.webp',
                    'link' => route('products.index', ['category' => 'men']),
                    ],
                    ];
                    @endphp

                    @foreach ($categories as $cat)
                    <article data-reveal class="group relative overflow-hidden">
                        <a href="{{ $cat['link'] }}"
                            class="block focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2"
                            aria-label="Shop {{ $cat['name'] }} collection">

                            {{-- Category Image --}}
                            <figure class="relative overflow-hidden bg-neutral-200 m-0" style="aspect-ratio: 4/5">
                                <picture>
                                    <source type="image/webp" srcset="{{ Storage::url('home/' . $cat['image']) }}">

                                    <img src="{{ Storage::url('home/' . str_replace('.webp', '.jpg', $cat['image'])) }}"
                                        alt="{{ $cat['name'] }} collection preview showcasing {{ strtolower($cat['desc']) }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 motion-reduce:transition-none motion-reduce:hover:scale-100"
                                        loading="lazy" decoding="async" width="800" height="1000">
                                </picture>

                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"
                                    aria-hidden="true"></div>
                            </figure>

                            {{-- Category Info Overlay --}}
                            <figcaption class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-white">
                                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-light mb-2">
                                    {{ $cat['name'] }}
                                </h3>
                                <p class="text-sm sm:text-base text-white/90 mb-4">
                                    {{ $cat['desc'] }}
                                </p>
                                <span
                                    class="inline-flex items-center gap-2 text-sm font-medium border-b border-white/50 group-hover:border-white transition-colors pb-1">
                                    Shop Now
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </figcaption>
                        </a>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        BRAND VALUES - Icon + Text grid
        ============================================ --}}
        <section class="py-16 sm:py-20 lg:py-24 bg-white" aria-labelledby="values-heading">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 id="values-heading" class="sr-only">Our Commitments</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
                    @php
                    $values = [
                    ['icon' => 'truck', 'title' => 'Free Shipping', 'desc' => 'On orders over ₫500,000'],
                    ['icon' => 'shield', 'title' => 'Secure Payment', 'desc' => 'Safe & encrypted checkout'],
                    ['icon' => 'refresh', 'title' => 'Easy Returns', 'desc' => '30-day return policy'],
                    ['icon' => 'heart', 'title' => 'Sustainable', 'desc' => 'Ethically sourced materials'],
                    ];
                    @endphp

                    @foreach ($values as $val)
                    <div data-reveal class="text-center space-y-3">
                        {{-- Icon --}}
                        <div class="flex justify-center" aria-hidden="true">
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 flex items-center justify-center rounded-full bg-neutral-100">
                                @if ($val['icon'] === 'truck')
                                <svg class="w-6 h-6 text-neutral-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                @elseif($val['icon'] === 'shield')
                                <svg class="w-6 h-6 text-neutral-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                @elseif($val['icon'] === 'refresh')
                                <svg class="w-6 h-6 text-neutral-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                @else
                                <svg class="w-6 h-6 text-neutral-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-sm sm:text-base font-medium text-neutral-900">{{ $val['title'] }}</h3>
                        <p class="text-xs sm:text-sm text-neutral-600">{{ $val['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        EDITORIAL QUOTE - Full-width statement
        ============================================ --}}
        <section class="py-20 sm:py-28 lg:py-32 bg-neutral-900 text-white" aria-label="Inspirational quote">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-reveal>
                <blockquote class="space-y-6" cite="https://www.brainyquote.com/quotes/rachel_zoe_483352">
                    <p class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-light leading-relaxed italic">
                        "Style is a way to say who you are without having to speak"
                    </p>
                    <footer class="text-sm tracking-wider text-white/70 not-italic">
                        — RACHEL ZOE
                    </footer>
                </blockquote>
            </div>
        </section>

        {{-- ============================================
        SOCIAL PROOF - Instagram-style grid
        ============================================ --}}
        <section class="py-16 sm:py-20 lg:py-24 bg-white" aria-labelledby="social-heading">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <header class="text-center mb-12 lg:mb-16" data-reveal>
                    <p class="text-xs tracking-[0.3em] uppercase text-neutral-500 mb-3 font-medium">#BlushopStyle</p>
                    <h2 id="social-heading" class="text-3xl sm:text-4xl lg:text-5xl font-light text-neutral-900">
                        Community Style
                    </h2>
                </header>

                {{-- Social Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                    @for ($i = 1; $i <= 8; $i++) <a href="https://www.instagram.com/blushop" data-reveal
                        class="group relative overflow-hidden bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2"
                        style="aspect-ratio: 1" aria-label="View Instagram post {{ $i }} on our profile" target="_blank"
                        rel="noopener noreferrer">

                        <picture>
                            <source type="image/webp"
                                srcset="{{ Storage::url('home/social/instagram-' . $i . '.webp') }}">

                            <img src="{{ Storage::url('home/social/instagram-' . $i . '.jpg') }}"
                                alt="Customer style inspiration post {{ $i }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 motion-reduce:transition-none motion-reduce:hover:scale-100"
                                loading="lazy" decoding="async" width="400" height="400">
                        </picture>

                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 motion-reduce:transition-none"
                            aria-hidden="true"></div>
                        </a>
                        @endfor
                </div>


                <footer class="mt-8 lg:mt-10 text-center" data-reveal>
                    <a href="https://www.instagram.com/blushop"
                        class="inline-flex items-center gap-2 text-sm sm:text-base font-medium text-neutral-900 
                               hover:text-neutral-600 focus:text-neutral-600 focus:outline-none focus:underline transition-colors" target="_blank"
                        rel="noopener noreferrer">
                        Follow us on Instagram
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                        </svg>
                    </a>
                </footer>
            </div>
        </section>
        {{-- ============================================
        NEWSLETTER - Minimal signup with accessibility
        ============================================ --}}
        <section class="py-20 sm:py-28 lg:py-32 bg-neutral-50" aria-labelledby="newsletter-heading">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-reveal>
                <h2 id="newsletter-heading" class="text-3xl sm:text-4xl lg:text-5xl font-light text-neutral-900 mb-4">
                    Stay Connected
                </h2>
                <p class="text-base sm:text-lg text-neutral-700 mb-8 lg:mb-10">
                    Subscribe to receive updates on new arrivals, special offers, and exclusive content.
                </p>

                <form x-data="{ email: '', status: null, loading: false }" x-on:submit.prevent="
                loading = true;
                if(!email || !email.includes('@')) {
                    status='error';
                    loading = false;
                } else {
                    setTimeout(() => {
                        status='success';
                        email='';
                        loading = false;
                    }, 800);
                }" class="max-w-md mx-auto" aria-label="Newsletter subscription form">

                    <div class="flex flex-col sm:flex-row gap-3">
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input x-model="email" id="newsletter-email" type="email" placeholder="Enter your email"
                            required aria-required="true" aria-describedby="newsletter-status" class="flex-1 px-4 sm:px-5 py-3 text-sm sm:text-base border border-neutral-300 bg-white text-neutral-900 
                       placeholder:text-neutral-400 focus:outline-none focus:border-neutral-900 focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2
                       disabled:opacity-50 disabled:cursor-not-allowed transition" :disabled="loading" />

                        <button type="submit" :disabled="loading" class="px-6 sm:px-8 py-3 bg-neutral-900 text-white text-sm sm:text-base font-medium tracking-wide 
                       uppercase hover:bg-neutral-800 focus:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2
                       disabled:opacity-50 disabled:cursor-not-allowed transition"
                            :aria-label="loading ? 'Subscribing...' : 'Subscribe to newsletter'">
                            <span x-show="!loading">Subscribe</span>
                            <span x-show="loading" class="inline-block">
                                <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <div id="newsletter-status" role="status" aria-live="polite" class="mt-3 min-h-[1.5rem]">
                        <p x-show="status==='success'" x-transition class="text-sm text-green-700">
                            Thank you for subscribing! Check your inbox for confirmation.
                        </p>
                        <p x-show="status==='error'" x-transition class="text-sm text-rose-700">
                            Please enter a valid email address.
                        </p>
                    </div>
                </form>
            </div>
        </section>

    </main>

    {{-- Include wishlist functionality if needed --}}
    @if (View::exists('partials.wishlist-script'))
    @include('partials.wishlist-script')
    @endif

    @push('scripts')
    {{-- Reveal animations on scroll with reduced motion support --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check for reduced motion preference
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (prefersReducedMotion) {
                // Skip animations for users who prefer reduced motion
                document.querySelectorAll('[data-reveal]').forEach(el => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });
                return;
            }

            // Intersection Observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        // Unobserve after animation to improve performance
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px' // Trigger slightly before element is visible
            });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                observer.observe(el);
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        e.preventDefault();
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        // Update URL without jumping
                        history.pushState(null, null, targetId);

                        // Focus target for keyboard accessibility
                        targetElement.setAttribute('tabindex', '-1');
                        targetElement.focus();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>