{{--
Modern Fashion Landing Page
Minimalist design inspired by Zara, COS, Uniqlo
Laravel Blade + Tailwind CSS
--}}

<x-app-layout>
    @push('head')
    {{-- Preload hero image for faster LCP --}}
    <link rel="preload" as="image" href="{{ asset('images/hero-main.jpg') }}" fetchpriority="high">
    @endpush

    <main class="bg-white">
        {{-- ============================================
        HERO SECTION - Fullscreen minimal
        ============================================ --}}
        <section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
            {{-- Background Image/Video --}}
            <div class="absolute inset-0 bg-slate-950">
                <img src="{{ asset('images/hero-main.jpg') }}" alt="Fashion Collection"
                    class="w-full h-full object-cover opacity-90" loading="eager" />
                {{-- Optional: Gradient overlay for better text readability --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/5 to-black/40"></div>
            </div>

            {{-- Hero Content - Centered --}}
            <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
                <div data-reveal style="transition-delay: 200ms"
                    class="opacity-0 translate-y-4 transition duration-1000">
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-light tracking-tight text-white mb-6">
                        Timeless Essentials
                    </h1>
                    <p class="text-lg sm:text-xl text-white/90 font-light mb-8 max-w-2xl mx-auto">
                        Curated wardrobe pieces designed for everyday elegance
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-slate-950 
                                  text-sm font-medium tracking-wide uppercase hover:bg-slate-100 
                                  transition-all duration-300 hover:scale-105">
                            Discover Collection
                        </a>
                        <a href="#featured" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white 
                                  text-white text-sm font-medium tracking-wide uppercase 
                                  hover:bg-white hover:text-slate-950 transition-all duration-300">
                            Shop New Arrivals
                        </a>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10">
                <a href="#featured"
                    class="flex flex-col items-center gap-2 text-white/70 hover:text-white transition group">
                    <span class="text-xs uppercase tracking-widest">Scroll</span>
                    <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </a>
            </div>
        </section>

        {{-- ============================================
        BRAND PHILOSOPHY - Minimal text block
        ============================================ --}}
        <section class="py-20 sm:py-32 bg-warm/30">
            <div class="max-w-4xl mx-auto px-6 text-center" data-reveal>
                <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-4">Our Philosophy</p>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-light text-ink mb-6 leading-tight">
                    Less, but better
                </h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed max-w-2xl mx-auto">
                    We believe in conscious design. Each piece is crafted to last beyond seasons,
                    blending timeless silhouettes with modern comfort. Quality over quantity,
                    always.
                </p>
            </div>
        </section>

        {{-- ============================================
        FEATURED COLLECTION - Large visual grid
        ============================================ --}}
        <section id="featured" class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                {{-- Section Header --}}
                <div class="mb-12 text-center" data-reveal>
                    <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-3">New Season</p>
                    <h2 class="text-3xl sm:text-4xl font-light text-ink">Featured Collection</h2>
                </div>

                {{-- Product Grid - Asymmetric Layout --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse(($featured ?? collect())->take(6) as $index => $product)
                    <article data-reveal
                        class="group relative overflow-hidden {{ $index === 0 ? 'lg:row-span-2' : '' }}">
                        {{-- Product Image --}}
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                            class="block relative overflow-hidden bg-warm/20"
                            style="aspect-ratio: {{ $index === 0 ? '3/4' : '4/5' }}">
                            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 
                                           group-hover:scale-105" loading="lazy" />
                            {{-- Hover Overlay --}}
                            <div
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300">
                            </div>
                        </a>

                        {{-- Product Info - Minimal --}}
                        <div class="mt-4 space-y-1">
                            <h3 class="text-sm font-medium text-ink group-hover:text-indigo-600 transition">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            @if($product->category && $product->category->name != 'Uncategorized')
                            <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                            @endif
                            <p class="text-sm font-medium text-ink">
                                ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </article>
                    @empty
                    {{-- Empty State --}}
                    <div class="col-span-full py-12 text-center">
                        <p class="text-gray-500">Collection coming soon</p>
                    </div>
                    @endforelse
                </div>

                {{-- View All CTA --}}
                <div class="mt-12 text-center" data-reveal>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-ink 
                              border-b-2 border-ink hover:border-indigo-600 hover:text-indigo-600 
                              transition pb-1">
                        View Full Collection
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================
        CATEGORY SPOTLIGHT - Image + Text blocks
        ============================================ --}}
        <section class="py-16 sm:py-24 bg-warm/20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @php
                    $categories = [
                    [
                    'name' => 'Women',
                    'desc' => 'Effortless elegance for the modern woman',
                    'image' => 'category-women.jpg',
                    'link' => route('products.index', ['category' => 'women'])
                    ],
                    [
                    'name' => 'Men',
                    'desc' => 'Classic pieces, contemporary style',
                    'image' => 'category-men.jpg',
                    'link' => route('products.index', ['category' => 'men'])
                    ],
                    ];
                    @endphp

                    @foreach($categories as $cat)
                    <article data-reveal class="group relative overflow-hidden">
                        <a href="{{ $cat['link'] }}" class="block">
                            {{-- Category Image --}}
                            <div class="relative overflow-hidden bg-warm/40" style="aspect-ratio: 4/5">
                                <img src="{{ asset('images/' . $cat['image']) }}" alt="{{ $cat['name'] }} Collection"
                                    class="w-full h-full object-cover transition-transform duration-700 
                                           group-hover:scale-105" loading="lazy" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                                </div>
                            </div>

                            {{-- Category Info Overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                                <h3 class="text-3xl font-light mb-2">{{ $cat['name'] }}</h3>
                                <p class="text-sm text-white/90 mb-4">{{ $cat['desc'] }}</p>
                                <span class="inline-flex items-center gap-2 text-sm font-medium 
                                             border-b border-white/50 group-hover:border-white transition pb-1">
                                    Shop Now
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        BRAND VALUES - Icon + Text grid
        ============================================ --}}
        <section class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                    $values = [
                    ['icon' => 'truck', 'title' => 'Free Shipping', 'desc' => 'On orders over ₫500,000'],
                    ['icon' => 'shield', 'title' => 'Secure Payment', 'desc' => 'Safe & encrypted checkout'],
                    ['icon' => 'refresh', 'title' => 'Easy Returns', 'desc' => '30-day return policy'],
                    ['icon' => 'heart', 'title' => 'Sustainable', 'desc' => 'Ethically sourced materials'],
                    ];
                    @endphp

                    @foreach($values as $val)
                    <div data-reveal class="text-center space-y-3">
                        {{-- Icon --}}
                        <div class="flex justify-center">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-warm/50">
                                @if($val['icon'] === 'truck')
                                <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                @elseif($val['icon'] === 'shield')
                                <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                @elseif($val['icon'] === 'refresh')
                                <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                @else
                                <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-ink">{{ $val['title'] }}</h3>
                        <p class="text-xs text-gray-600">{{ $val['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================
        EDITORIAL QUOTE - Full-width statement
        ============================================ --}}
        <section class="py-24 sm:py-32 bg-ink text-white">
            <div class="max-w-4xl mx-auto px-6 text-center" data-reveal>
                <blockquote class="space-y-6">
                    <p class="text-2xl sm:text-3xl lg:text-4xl font-light leading-relaxed italic">
                        "Style is a way to say who you are without having to speak"
                    </p>
                    <footer class="text-sm tracking-wider text-white/70">
                        — RACHEL ZOE
                    </footer>
                </blockquote>
            </div>
        </section>

        {{-- ============================================
        INSTAGRAM FEED - Social proof
        ============================================ --}}
        <section class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12" data-reveal>
                    <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-3">#YourBrandName</p>
                    <h2 class="text-3xl sm:text-4xl font-light text-ink">Community Style</h2>
                </div>

                {{-- Instagram Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @for($i = 1; $i <= 8; $i++) <a href="#" data-reveal
                        class="group relative overflow-hidden bg-warm/20" style="aspect-ratio: 1">
                        <img src="{{ asset('images/instagram-' . $i . '.jpg') }}" alt="Instagram post {{ $i }}" class="w-full h-full object-cover transition-transform duration-500 
                                   group-hover:scale-110" loading="lazy" />
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300">
                        </div>
                        </a>
                        @endfor
                </div>

                <div class="mt-8 text-center" data-reveal>
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-medium text-ink 
                              hover:text-indigo-600 transition">
                        Follow us on Instagram
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================
        NEWSLETTER - Minimal signup
        ============================================ --}}
        <section class="py-20 sm:py-32 bg-warm/30">
            <div class="max-w-2xl mx-auto px-6 text-center" data-reveal>
                <h2 class="text-3xl sm:text-4xl font-light text-ink mb-4">
                    Stay Connected
                </h2>
                <p class="text-base text-gray-700 mb-8">
                    Subscribe to receive updates on new arrivals, special offers, and exclusive content.
                </p>

                <form x-data="{ email: '', status: null }"
                    @submit.prevent="if(!email || !email.includes('@')){ status='error' } else { status='success'; email='' }"
                    class="max-w-md mx-auto">
                    <div class="flex gap-3">
                        <input x-model="email" type="email" placeholder="Enter your email" required class="flex-1 px-5 py-3 text-sm border border-beige bg-white text-ink 
                                   placeholder:text-gray-400 focus:outline-none focus:border-ink transition" />
                        <button type="submit" class="px-8 py-3 bg-ink text-white text-sm font-medium tracking-wide 
                                   uppercase hover:bg-indigo-900 transition">
                            Subscribe
                        </button>
                    </div>
                    <p x-show="status==='success'" x-transition class="mt-3 text-sm text-green-700">
                        Thank you for subscribing!
                    </p>
                    <p x-show="status==='error'" x-transition class="mt-3 text-sm text-rose-700">
                        Please enter a valid email address.
                    </p>
                </form>
            </div>
        </section>
    </main>

    {{-- Include wishlist functionality if needed --}}
    @include('partials.wishlist-script')

    @push('scripts')
    {{-- Reveal animations on scroll --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>