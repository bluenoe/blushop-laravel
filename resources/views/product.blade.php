<x-app-layout>
    @push('head')
        <link rel="preload" as="image" href="{{ asset('images/' . $product->image) }}" fetchpriority="high">
    @endpush
    <section class="min-h-[calc(100vh-4rem)] bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-10 sm:py-16">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-400" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1">
                    <li><a href="{{ route('home') }}" class="hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white/20 rounded">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white/20 rounded">Shop</a></li>
                    <li>/</li>
                    <li aria-current="page" class="text-gray-300">{{ $product->name }}</li>
                </ol>
            </nav>

            <div
                x-data="{
                    images: [
                        '{{ asset('images/' . $product->image) }}',
                        '{{ asset('images/sample2.jpg') }}',
                        '{{ asset('images/sample3.jpg') }}'
                    ],
                    active: 0,
                    size: null,
                    color: null,
                    qty: 1,
                    ts: 0,
                    te: 0,
                    imgLoading: true,
                }"
                class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12"
            >
                <!-- Left: hero image + thumbnails -->
                <div class="group" data-reveal="fade-up">
                    <div
                        class="relative overflow-hidden rounded-xl ring-1 ring-white/10 bg-gray-800"
                        style="aspect-ratio: 4/3;"
                        x-on:touchstart="ts = $event.changedTouches[0].clientX"
                        x-on:touchend="te = $event.changedTouches[0].clientX; if (te - ts > 40) { imgLoading = true; active = (active - 1 + images.length) % images.length } else if (ts - te > 40) { imgLoading = true; active = (active + 1) % images.length }"
                    >
                        <!-- Skeleton overlay: visible immediately, fades out on image load -->
                        <div class="absolute inset-0 pointer-events-none" x-show="imgLoading" x-transition.opacity>
                            <x-skeleton.image class="w-full h-full" />
                        </div>
                        <!-- Hero image (keeps container height constant) -->
                        <img
                            :src="images[active]"
                            alt="{{ $product->name }}"
                            class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 ease-out group-hover:scale-[1.02]"
                            :class="imgLoading ? 'opacity-0' : 'opacity-100'"
                            @load="imgLoading = false"
                            fetchpriority="high"
                            decoding="async"
                            draggable="false"
                        />

                        <!-- Prev/Next -->
                        <button type="button" aria-label="Previous image"
                                class="absolute left-3 top-1/2 -translate-y-1/2 rounded-md bg-gray-900/60 text-gray-200 px-2 py-1 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-white/20"
                                @click="imgLoading = true; active = (active - 1 + images.length) % images.length">
                            ‹
                        </button>
                        <button type="button" aria-label="Next image"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md bg-gray-900/60 text-gray-200 px-2 py-1 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-white/20"
                                @click="imgLoading = true; active = (active + 1) % images.length">
                            ›
                        </button>

                        <!-- Wishlist heart -->
                        <div class="absolute top-3 right-3">
                            <form action="{{ route('favorites.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-full bg-black/40 backdrop-blur px-3 py-2 text-white hover:bg-black/60 transition" aria-label="Add to favorites">❤️</button>
                            </form>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="mt-4 flex items-center gap-3">
                        <template x-for="(src, i) in images" :key="i">
                            <button type="button" :aria-label="'Show image ' + (i+1)"
                                    @click="imgLoading = true; active = i"
                                    :class="{'ring-2 ring-indigo-500': active === i}"
                                    class="overflow-hidden rounded-md ring-1 ring-white/10 bg-gray-800 w-20 h-20 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <img :src="src" alt="{{ $product->name }} thumbnail" loading="lazy" decoding="async"
                                     class="w-full h-full object-cover" />
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right: info panel -->
                <div class="flex flex-col" data-reveal="fade-up">
                    <div class="rounded-xl ring-1 ring-white/10 bg-gray-800 p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4">
                            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">{{ $product->name }}</h1>
                            <span class="text-xs text-gray-400">SKU: {{ $product->id }}</span>
                        </div>

                        <div class="mt-2 flex items-center gap-3">
                            <p class="text-indigo-400 text-xl sm:text-2xl font-semibold">₫{{ number_format((float)$product->price, 0, ',', '.') }}</p>
                            <span class="text-sm text-green-400">In stock</span>
                        </div>

                        <!-- Variant selectors -->
                        <div class="mt-6 space-y-5">
                            <!-- Sizes -->
                            <div>
                                <p class="text-sm font-medium text-gray-300">Size</p>
                                <div role="radiogroup" aria-label="Choose size" class="mt-2 flex flex-wrap gap-2">
                                    <template x-for="s in ['S','M','L','XL']" :key="s">
                                        <button type="button"
                                                :aria-checked="size === s"
                                                :class="size === s ? 'bg-indigo-600 text-white ring-2 ring-indigo-500' : 'bg-gray-900/60 text-gray-200 ring-1 ring-white/10 hover:bg-gray-800'"
                                                class="px-3 py-1.5 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                @click="size = s"
                                                :disabled="s === 'XL' ? false : false" aria-disabled="false">
                                            <span x-text="s"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Colors -->
                            <div>
                                <p class="text-sm font-medium text-gray-300">Color</p>
                                <div role="radiogroup" aria-label="Choose color" class="mt-2 flex items-center gap-3">
                                    <template x-for="c in [
                                        {id:'black', name:'Black', cls:'bg-black'},
                                        {id:'gray', name:'Gray', cls:'bg-gray-500'},
                                        {id:'navy', name:'Navy', cls:'bg-indigo-900'}
                                    ]" :key="c.id">
                                        <button type="button"
                                                :aria-checked="color === c.id"
                                                class="w-7 h-7 rounded-full ring-2 ring-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                :class="[c.cls, color === c.id ? 'ring-indigo-500 ring-offset-2 ring-offset-gray-800' : 'hover:ring-white/30']"
                                                @click="color = c.id">
                                            <span class="sr-only" x-text="c.name"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity + actions -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-6 sm:mt-8">
                            @csrf
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <label for="qty" class="text-sm font-medium text-gray-300">Quantity</label>
                                    <div class="flex items-center gap-1">
                                        <button type="button" class="px-2 py-1 rounded-md bg-gray-900/60 text-gray-200 ring-1 ring-white/10 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="qty = Math.max(1, qty - 1)">–</button>
                                        <input type="number" min="1" name="quantity" id="qty" x-model.number="qty" required
                                               class="w-20 rounded-md border border-white/10 bg-gray-900/70 px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                                        <button type="button" class="px-2 py-1 rounded-md bg-gray-900/60 text-gray-200 ring-1 ring-white/10 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="qty = qty + 1">+</button>
                                    </div>
                                </div>
                                @error('quantity')
                                    <p class="text-sm text-red-400">{{ $message }}</p>
                                @enderror

                                <div class="flex flex-wrap gap-3">
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                        Add to Cart
                                    </button>
                                    <a href="{{ route('checkout.index') }}" class="inline-flex items-center justify-center rounded-md border border-white/10 bg-gray-900/50 px-5 py-2.5 text-sm font-semibold text-gray-200 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-white/20 transition-colors">
                                        Buy Now
                                    </a>
                                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-semibold text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/20">
                                        Back to Shop
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Trust badges -->
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $badges = [
                        ['title' => 'Free Shipping', 'desc' => 'On selected orders'],
                        ['title' => 'Secure Payment', 'desc' => 'Encrypted checkout'],
                        ['title' => '24/7 Support', 'desc' => 'We’re here to help'],
                        ['title' => 'Genuine Quality', 'desc' => 'Reliable, curated items'],
                    ];
                @endphp
                @foreach($badges as $b)
                    <div class="rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-5 shadow-sm hover:shadow-lg transition duration-300">
                        <h3 class="text-gray-900 dark:text-gray-100 font-semibold">{{ $b['title'] }}</h3>
                        <p class="mt-1 text-gray-700 dark:text-gray-300 text-sm">{{ $b['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Tabs -->
            <div x-data="{tab: 'desc'}" class="mt-12 rounded-xl ring-1 ring-white/10 bg-gray-800">
                <div class="flex flex-wrap gap-2 px-6 pt-6">
                    <button @click="tab = 'desc'" :class="tab === 'desc' ? 'bg-indigo-600 text-white' : 'bg-gray-900/60 text-gray-200 hover:bg-gray-800'" class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">Description</button>
                    <button @click="tab = 'specs'" :class="tab === 'specs' ? 'bg-indigo-600 text-white' : 'bg-gray-900/60 text-gray-200 hover:bg-gray-800'" class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">Specs</button>
                    <button @click="tab = 'ship'" :class="tab === 'ship' ? 'bg-indigo-600 text-white' : 'bg-gray-900/60 text-gray-200 hover:bg-gray-800'" class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">Shipping & Returns</button>
                </div>
                <div class="px-6 pb-6">
                    <div x-show="tab === 'desc'" class="pt-4 text-gray-300 text-sm sm:text-base">
                        @if($product->description)
                            {{ $product->description }}
                        @else
                            Detailed product description will be available soon.
                        @endif
                    </div>
                    <div x-show="tab === 'specs'" class="pt-4 text-gray-300 text-sm sm:text-base">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Premium materials and build</li>
                            <li>Designed for daily use</li>
                            <li>Warranty and support from BluShop</li>
                        </ul>
                    </div>
                    <div x-show="tab === 'ship'" class="pt-4 text-gray-300 text-sm sm:text-base">
                        <p>Ships within 2–4 business days. Free returns within 14 days if unused and in original packaging.</p>
                    </div>
                </div>
            </div>

            <!-- Related products -->
            <div class="mt-12">
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-100">You may also like</h2>
                    <a href="{{ route('products.index') }}" class="text-indigo-400 font-medium hover:underline">View all</a>
                </div>
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse(($relatedProducts ?? []) as $r)
                        <div class="group rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm transition duration-300 hover:shadow-lg hover:-translate-y-[2px]" data-reveal="fade-up" x-data="{ loaded: false }">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                <template x-if="!loaded">
                                    <x-skeleton.image class="aspect-[4/3]" />
                                </template>
                                <img src="{{ asset('images/' . $r->image) }}" alt="{{ $r->name }}" class="w-full h-full object-cover opacity-0 transition-opacity duration-500 group-hover:scale-105" onload="this.classList.remove('opacity-0')" />
                            </div>
                            <div class="p-4">
                                <h3 class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ $r->name }}</h3>
                                <p class="mt-1 text-gray-700 dark:text-gray-300 font-medium">₫{{ number_format((float)$r->price, 0, ',', '.') }}</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <a href="{{ route('product.show', $r->id) }}" class="inline-block rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">View</a>
                                    <form action="{{ route('favorites.add', $r->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-block rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">❤️ Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <x-skeleton.card />
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
