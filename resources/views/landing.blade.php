{{--
Landing Page (BluShop)
- Uses Breeze layout: <x-app-layout>
    - TailwindCSS classes via @vite assets (already configured)
    - Sections: Hero, Highlights, Featured Products, About
    --}}

    <x-app-layout>
        @push('head')
            <link rel="preload" as="image" href="{{ asset('images/hero-bg.jpg') }}" fetchpriority="high">
        @endpush
        {{-- Hero Section: full-bleed background image with overlay, skeleton, and reveal --}}
        <section
            x-data="{ bgLoaded: false }"
            x-init="(() => { const img = new Image(); img.src = '{{ asset('images/hero-bg.jpg') }}'; img.onload = () => { bgLoaded = true; }; })()"
            class="relative text-white bg-fixed bg-cover bg-center"
            style="background-image: url('{{ asset('images/hero-bg.jpg') }}');"
        >
            <!-- Stable height to prevent CLS -->
            <div class="relative min-h-[350px] sm:min-h-[480px] lg:min-h-[600px] flex items-center justify-center">
                <!-- Dark overlay for readability -->
                <div class="absolute inset-0 z-10 bg-gradient-to-b from-black/60 to-black/30"></div>
                <!-- Skeleton/blurred placeholder while bg loads -->
                <div class="absolute inset-0 z-20" x-show="!bgLoaded" x-transition.opacity>
                    <x-skeleton.image class="w-full h-full" />
                </div>
                <!-- Hero content -->
                <div class="relative z-30 max-w-4xl mx-auto px-6 text-center">
                    <h1 data-reveal style="transition-delay: 300ms" class="opacity-0 translate-y-2 transition duration-700 text-gray-100 text-4xl sm:text-5xl font-extrabold tracking-tight">
                        Welcome to BluShop
                    </h1>
                    <p data-reveal style="transition-delay: 500ms" class="opacity-0 translate-y-2 transition duration-700 mt-4 text-lg sm:text-xl text-white/90">
                        Minimal, student-friendly e-commerce. Great quality, fair prices.
                    </p>
                    <div data-reveal style="transition-delay: 700ms" class="opacity-0 translate-y-2 transition duration-700 mt-8">
                        <a href="{{ route('products.index') }}"
                           class="inline-block rounded-lg bg-white text-indigo-700 font-semibold px-6 py-3 shadow hover:shadow-lg transition-transform duration-300 hover:scale-105">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Highlights Section --}}
        <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">Why BluShop?</h2>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                $highlights = [
                ['title' => 'Free Shipping', 'desc' => 'Enjoy free shipping on selected orders.'],
                ['title' => 'Secure Payment', 'desc' => 'Pay confidently with secure checkout.'],
                ['title' => '24/7 Support', 'desc' => 'We’re here to help anytime.'],
                ['title' => 'Quality Products', 'desc' => 'Curated items with reliable quality.'],
                ];
                @endphp

                @foreach($highlights as $h)
                <div
                    class="rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg transition duration-300 hover:scale-[1.02]">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $h['title'] }}</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $h['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Featured Products Section --}}
        <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
            <div class="flex items-end justify-between">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">Featured Products</h2>
                <a href="{{ route('products.index') }}"
                    class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">View all</a>
            </div>

            @if(($featured ?? collect())->isEmpty())
            <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                No products yet. Did you run seeder?
                <code class="ml-1">php artisan db:seed --class=ProductSeeder</code>
            </div>
            @else
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featured as $product)
                <div
                    class="group rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition duration-300">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transform transition duration-300 group-hover:scale-105">
                    </div>
                    <div class="p-4">
                        <h3 class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ $product->name }}</h3>
                        <p class="mt-1 text-gray-700 dark:text-gray-300 font-medium">
                            ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center text-indigo-600 dark:text-indigo-400 font-medium hover:underline">
                                Explore more
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
        <section class="max-w-3xl mx-auto px-6 py-12 sm:py-16 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">About BluShop</h2>
            <p class="mt-4 text-gray-700 dark:text-gray-300">
                BluShop is a minimal e-commerce project built for students and learners.
                We focus on clean UI, sensible UX, and great content structure. Explore the
                catalog, add items to cart, and learn how modern Laravel + Blade + Vite workflows
                tie together.
            </p>
        </section>
    </x-app-layout>