{{--
Landing Page (BluShop)
- Uses Breeze layout: <x-app-layout>
    - Sections: Hero, Highlights, Featured Products, About
    --}}

    <x-app-layout>
        @push('head')
        <link rel="preload" as="image" href="{{ asset('images/hero-bg.jpg') }}" fetchpriority="high">
        @endpush

        <main>
            {{-- Hero Section: full-bleed background image with overlay & skeleton --}}
            <section x-data="{ bgLoaded: false }" x-init="(() => {
                const img = new Image();
                img.src = '{{ asset('images/hero-bg.jpg') }}';
                img.onload = () => { bgLoaded = true; };
            })()" class="relative text-white bg-slate-900 bg-cover bg-center lg:bg-fixed"
                style="background-image: url('{{ asset('images/hero-bg.jpg') }}');">
                {{-- Stable height to prevent CLS --}}
                <div class="relative min-h-[350px] sm:min-h-[480px] lg:min-h-[600px] flex items-center justify-center">
                    {{-- Dark overlay for readability --}}
                    <div class="absolute inset-0 z-10 bg-gradient-to-b from-black/70 via-black/40 to-black/20"></div>

                    {{-- Skeleton while bg loads --}}
                    <div class="absolute inset-0 z-20" x-show="!bgLoaded" x-transition.opacity x-cloak>
                        <x-skeleton.image class="w-full h-full" />
                    </div>

                    {{-- Hero content --}}
                    <div class="relative z-30 max-w-4xl mx-auto px-6 text-center">
                        <h1 data-reveal style="transition-delay: 300ms"
                            class="opacity-0 translate-y-2 transition duration-700 text-gray-100 text-4xl sm:text-5xl font-extrabold tracking-tight">
                            Welcome to BluShop
                        </h1>

                        <p data-reveal style="transition-delay: 500ms"
                            class="opacity-0 translate-y-2 transition duration-700 mt-4 text-lg sm:text-xl text-white/90">
                            Minimal, student-friendly e-commerce. Great quality, fair prices.
                        </p>

                        <div data-reveal style="transition-delay: 700ms"
                            class="opacity-0 translate-y-2 transition duration-700 mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('products.index') }}"
                                class="inline-block rounded-lg bg-white text-indigo-700 font-semibold px-6 py-3 shadow hover:shadow-lg transition-transform duration-300 hover:scale-105">
                                Shop Now
                            </a>

                            <a href="#about-blushop"
                                class="inline-block rounded-lg border border-white/70 text-white font-medium px-6 py-3 bg-white/5 hover:bg-white/10 backdrop-blur-sm transition">
                                About BluShop
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Highlights Section --}}
            <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-ink text-center" data-reveal>
                    Why BluShop?
                </h2>

                @php
                $highlights = [
                ['title' => 'Free Shipping', 'desc' => 'Enjoy free shipping on selected student orders.', 'icon' =>
                '🚚'],
                ['title' => 'Secure Payment', 'desc' => 'Encrypted checkout. No shady stuff, no drama.', 'icon' =>
                '🔒'],
                ['title' => '24/7 Support', 'desc' => 'Need help? We’re just a ping away.', 'icon' => '🕒'],
                ['title' => 'Quality Products','desc' => 'Curated Blu goods with reliable quality.', 'icon' => '⭐'],
                ];
                @endphp

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($highlights as $h)
                    <div data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 rounded-xl bg-white border border-beige p-6 shadow-soft hover:shadow-lg hover:scale-[1.02]">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-warm/80">
                            <span class="text-2xl" aria-hidden="true">{{ $h['icon'] }}</span>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-ink">
                            {{ $h['title'] }}
                        </h3>
                        <p class="mt-2 text-gray-700 text-sm sm:text-base">
                            {{ $h['desc'] }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- Featured Products Section --}}
            <section id="featured" class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <div class="flex items-end justify-between gap-4" data-reveal>
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-ink">Featured Products</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            A quick peek at Blu essentials students actually use.
                        </p>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-indigo-600 font-medium hover:underline">
                        View all
                    </a>
                </div>

                @if(($featured ?? collect())->isEmpty())
                <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                    No products yet. Did you run seeder?
                    <code class="ml-1">php artisan db:seed --class=ProductSeeder</code>
                </div>
                @else
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featured as $product)
                    <div data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 group rounded-xl overflow-hidden bg-white border border-beige shadow-soft hover:shadow-lg hover:-translate-y-[2px]">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transform transition duration-300 group-hover:scale-105">
                            <span
                                class="absolute top-3 left-3 inline-flex items-center rounded-full bg-indigo-600/90 text-white text-xs font-semibold px-2 py-0.5 shadow">
                                Featured
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="text-ink font-semibold truncate">
                                {{ $product->name }}
                            </h3>
                            <p class="mt-1 text-gray-700 font-medium">
                                ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                            </p>
                            <div class="mt-3 flex items-center justify-between">
                                <a href="{{ route('product.show', $product->id) }}"
                                    class="inline-flex items-center text-indigo-600 font-medium hover:underline">
                                    View product
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </section>

            {{-- About Section --}}
            <section id="about-blushop" class="max-w-3xl mx-auto px-6 py-12 sm:py-16 text-center">
                <h2 data-reveal class="text-2xl sm:text-3xl font-bold text-ink">
                    About BluShop
                </h2>
                <p data-reveal style="transition-delay: 200ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-4 text-gray-700 leading-relaxed">
                    BluShop is a calm, minimal e-commerce experience built around Blu-branded essentials.
                    It’s also a learning playground: under the hood, it runs on Laravel, Blade, Vite, and Tailwind,
                    following clean MVC patterns and student-friendly code.
                    Browse the catalog, add items to your cart, and see how a modern Laravel shop comes together.
                </p>
            </section>
        </main>
    </x-app-layout>