{{--
Landing Page (BluShop)
- Uses Breeze layout: <x-app-layout>
    - Sections: Hero, Highlights, Featured, Collections, How it works, About, CTA
    --}}

    <x-app-layout>
        @push('head')
        <link rel="preload" as="image" href="{{ asset('images/hero-bg.jpg') }}" fetchpriority="high">
        @endpush

        <main>
            {{-- Hero Section --}}
            <section x-data="{ bgLoaded: false }" x-init="(() => {
                const img = new Image();
                img.src = '{{ asset('images/hero-bg.jpg') }}';
                img.onload = () => { bgLoaded = true; };
            })()" class="relative text-white bg-slate-900 bg-cover bg-center lg:bg-fixed"
                style="background-image: url('{{ asset('images/hero-bg.jpg') }}');">
                <div class="relative min-h-[350px] sm:min-h-[480px] lg:min-h-[600px] flex items-center justify-center">
                    {{-- overlay hơi rực hơn một tí --}}
                    <div class="absolute inset-0 z-10 bg-gradient-to-b from-black/75 via-black/40 to-black/30"></div>

                    {{-- skeleton cho bg --}}
                    <div class="absolute inset-0 z-20" x-show="!bgLoaded" x-transition.opacity x-cloak>
                        <x-skeleton.image class="w-full h-full" />
                    </div>

                    {{-- content --}}
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

            {{-- Why BluShop (Highlights) – icon line trắng đen, không còn emoji --}}
            <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <h2 class="text-2xl sm:text-3xl font-bold text-ink text-center" data-reveal>
                    Why BluShop?
                </h2>

                @php
                $highlights = [
                ['title' => 'Free Shipping', 'desc' => 'Enjoy free shipping on selected student orders.'],
                ['title' => 'Secure Payment', 'desc' => 'Encrypted checkout. No shady stuff, no drama.'],
                ['title' => '24/7 Support', 'desc' => 'Need help? We’re just a ping away.'],
                ['title' => 'Quality Products','desc' => 'Curated Blu goods with reliable quality.'],
                ];
                @endphp

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($highlights as $index => $h)
                    <article data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 rounded-xl bg-white border border-beige p-6 shadow-soft hover:shadow-lg hover:-translate-y-[2px]">
                        <div
                            class="flex items-center justify-center h-10 w-10 rounded-full bg-ink/5 border border-beige">
                            @switch($index)
                            {{-- Truck icon --}}
                            @case(0)
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-6 w-6 text-ink">
                                <rect x="3" y="9" width="11" height="7" rx="1.5" ry="1.5" fill="none"
                                    stroke="currentColor" stroke-width="1.6" />
                                <rect x="14" y="11" width="5" height="5" rx="1.2" ry="1.2" fill="none"
                                    stroke="currentColor" stroke-width="1.6" />
                                <circle cx="8" cy="18" r="1.6" fill="none" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="17" cy="18" r="1.6" fill="none" stroke="currentColor" stroke-width="1.6" />
                                <path d="M3 18h2.2M10.5 18h2.8" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" />
                            </svg>
                            @break

                            {{-- Lock icon --}}
                            @case(1)
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-6 w-6 text-ink">
                                <rect x="6" y="10" width="12" height="9" rx="2" fill="none" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M9 10V8a3 3 0 0 1 6 0v2" fill="none" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" />
                                <circle cx="12" cy="14" r="1.3" fill="none" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                            @break

                            {{-- Clock icon --}}
                            @case(2)
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-6 w-6 text-ink">
                                <circle cx="12" cy="12" r="7" fill="none" stroke="currentColor" stroke-width="1.6" />
                                <path d="M12 9v3.5l2 2" fill="none" stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @break

                            {{-- Star / Sparkles icon --}}
                            @case(3)
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-6 w-6 text-ink">
                                <path
                                    d="M12 4.5 14.09 8.7l4.69.68-3.39 3.3.8 4.62L12 15.9 7.81 17.3l.8-4.62-3.39-3.3 4.69-.68L12 4.5Z"
                                    fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                            </svg>
                            @break
                            @endswitch
                        </div>

                        <h3 class="mt-4 text-lg font-semibold text-ink">
                            {{ $h['title'] }}
                        </h3>
                        <p class="mt-2 text-gray-700 text-sm sm:text-base">
                            {{ $h['desc'] }}
                        </p>
                    </article>
                    @endforeach
                </div>
            </section>

            {{-- Featured Products --}}
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
                    <article data-reveal
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
                    </article>
                    @endforeach
                </div>
                @endif
            </section>

            {{-- New: Shop by Category (section kéo trang dài & rực rỡ hơn) --}}
            <section class="bg-gradient-to-b from-warm/60 via-warm/30 to-white">
                <div class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                    <div class="flex items-end justify-between gap-4" data-reveal>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-ink">Shop by Category</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Quick filters for different student vibes.
                            </p>
                        </div>
                        <a href="{{ route('products.index') }}"
                            class="hidden sm:inline-flex text-indigo-600 font-medium hover:underline">
                            Browse all products
                        </a>
                    </div>

                    @php
                    $collections = [
                    [
                    'name' => 'Study Essentials',
                    'desc' => 'Bottles, cases, stationery — gear for long study sessions.',
                    'pill' => 'Focus & productivity',
                    ],
                    [
                    'name' => 'Desk & Tech',
                    'desc' => 'Phone stands, chargers, desk upgrades for cleaner setups.',
                    'pill' => 'For your battlestation',
                    ],
                    [
                    'name' => 'Lifestyle & Outdoors',
                    'desc' => 'Umbrellas, socks, blankets — Blu energy outside class.',
                    'pill' => 'Stay comfy, stay Blu',
                    ],
                    ];
                    @endphp

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($collections as $c)
                        <article data-reveal
                            class="opacity-0 translate-y-2 transition duration-500 rounded-2xl bg-white/90 backdrop-blur border border-beige shadow-soft hover:shadow-lg hover:-translate-y-[2px]">
                            <div class="p-5 flex flex-col h-full">
                                <span
                                    class="inline-flex items-center rounded-full bg-indigo-50 text-xs font-medium text-indigo-700 px-3 py-1">
                                    {{ $c['pill'] }}
                                </span>
                                <h3 class="mt-4 text-lg font-semibold text-ink">
                                    {{ $c['name'] }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                                    {{ $c['desc'] }}
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center text-indigo-600 text-sm font-medium hover:underline">
                                        Explore category
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- New: How BluShop Works --}}
            <section class="max-w-5xl mx-auto px-6 py-12 sm:py-16">
                <h2 data-reveal class="text-2xl sm:text-3xl font-bold text-ink text-center">
                    How BluShop Works
                </h2>
                <p data-reveal style="transition-delay: 150ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-3 text-center text-sm text-gray-600">
                    Simple flow for both users and devs: browse, learn the stack, ship your own features.
                </p>

                @php
                $steps = [
                [
                'title' => 'Browse & Filter',
                'desc' => 'Use search, price filters, and categories to find Blu items that match your vibe.',
                ],
                [
                'title' => 'Add to Cart',
                'desc' => 'Add products, manage quantities, and see your cart update in real time.',
                ],
                [
                'title' => 'Learn the Stack',
                'desc' => 'Under the hood: Laravel 11, Blade, Vite, Tailwind – clean MVC you can read and extend.',
                ],
                ];
                @endphp

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($steps as $i => $step)
                    <article data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 rounded-2xl border border-beige bg-white p-6 shadow-soft">
                        <div
                            class="flex items-center justify-center h-9 w-9 rounded-full bg-indigo-600 text-white text-sm font-semibold">
                            {{ $i + 1 }}
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-ink">
                            {{ $step['title'] }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                            {{ $step['desc'] }}
                        </p>
                    </article>
                    @endforeach
                </div>
            </section>

            {{-- About + cuối trang CTA nhẹ --}}
            <section id="about-blushop" class="max-w-3xl mx-auto px-6 pb-12 sm:pb-16 text-center">
                <h2 data-reveal class="text-2xl sm:text-3xl font-bold text-ink">
                    About BluShop
                </h2>
                <p data-reveal style="transition-delay: 200ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-4 text-gray-700 leading-relaxed">
                    BluShop is a calm, minimal e-commerce experience built around Blu-branded essentials.
                    It’s also a learning playground: under the hood, it runs on Laravel, Blade, Vite, and Tailwind,
                    following clean MVC patterns and student-friendly code. Browse the catalog, add items to your cart,
                    and see how a modern Laravel shop comes together.
                </p>

                <div data-reveal style="transition-delay: 350ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-8">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-indigo-600 via-violet-600 to-rose-500 px-8 py-3 text-sm sm:text-base font-semibold text-white shadow-lg hover:shadow-xl hover:scale-[1.03] transition">
                        Start exploring BluShop
                    </a>
                </div>
            </section>
        </main>
    </x-app-layout>