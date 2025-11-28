<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ Storage::url('products/' . $product->image) }}" fetchpriority="high">
    @endpush
    <section class="min-h-[calc(100vh-4rem)] bg-warm">
        <div class="max-w-7xl mx-auto px-6 py-10 sm:py-16">
            <x-breadcrumbs :items="$breadcrumbs" />

            <div x-data="{
                    images: [
                        '{{ Storage::url('products/' . $product->image) }}',
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
                }" class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Left: hero image + thumbnails -->
                <div class="group" data-reveal="fade-up">
                    <div class="relative overflow-hidden rounded-xl border border-beige bg-white"
                        style="aspect-ratio: 4/3;" x-on:touchstart="ts = $event.changedTouches[0].clientX"
                        x-on:touchend="te = $event.changedTouches[0].clientX; if (te - ts > 40) { imgLoading = true; active = (active - 1 + images.length) % images.length } else if (ts - te > 40) { imgLoading = true; active = (active + 1) % images.length }">
                        <!-- Skeleton overlay: visible immediately, fades out on image load -->
                        <div class="absolute inset-0 pointer-events-none" x-show="imgLoading" x-transition.opacity>
                            <x-skeleton.image class="w-full h-full" />
                        </div>
                        <!-- Hero image (fills frame, keeps rounded corners) -->
                        <img :src="images[active]" alt="{{ $product->name }}"
                            class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-300 ease-out group-hover:scale-[1.02]"
                            :class="imgLoading ? 'opacity-0' : 'opacity-100'" @load="imgLoading = false"
                            fetchpriority="high" decoding="async" draggable="false" />

                        <!-- Prev/Next -->
                        <button type="button" aria-label="Previous image"
                            class="absolute left-3 top-1/2 -translate-y-1/2 rounded-md bg-ink/10 text-ink px-2 py-1 hover:bg-ink/20 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            @click="imgLoading = true; active = (active - 1 + images.length) % images.length">
                            ‹
                        </button>
                        <button type="button" aria-label="Next image"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md bg-ink/10 text-ink px-2 py-1 hover:bg-ink/20 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            @click="imgLoading = true; active = (active + 1) % images.length">
                            ›
                        </button>

                        <!-- Wishlist heart (aligned with product card styles) -->
                        <div class="absolute top-0 right-0"
                            x-data="{ id: {{ $product->id }}, active: $store.wishlist.isFav({{ $product->id }}) }">
                            <button type="button"
                                class="group/heart absolute top-4 right-4 z-20 inline-flex h-9 w-9 items-center justify-center rounded-full
                                           bg-white/90 text-ink shadow-sm ring-1 ring-beige/70
                                           transition hover:bg-rose-50 hover:text-rose-500 hover:ring-rose-200 hover:scale-105"
                                :class="active ? 'bg-rose-50 text-rose-600 ring-rose-200' : ''" :aria-pressed="active"
                                :title="active ? 'Remove from wishlist' : 'Add to wishlist'"
                                @click.stop="$store.wishlist.toggle(id); active = $store.wishlist.isFav(id)">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                                        :fill="active ? 'currentColor' : 'none'"
                                        :stroke="active ? 'none' : 'currentColor'" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="mt-4 flex items-center gap-3">
                        <template x-for="(src, i) in images" :key="i">
                            <button type="button" :aria-label="'Show image ' + (i+1)"
                                @click="imgLoading = true; active = i" :class="{'ring-2 ring-indigo-500': active === i}"
                                class="overflow-hidden rounded-md border border-beige bg-white w-20 h-20 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <img :src="src" alt="{{ $product->name }} thumbnail" loading="lazy" decoding="async"
                                    class="w-full h-full object-cover" />
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right: info panel -->
                <div class="flex flex-col" data-reveal="fade-up">
                    <div class="rounded-xl border border-beige bg-white p-6 sm:p-8 shadow-soft">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    @if ($product->is_on_sale)
                                    <span
                                        class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">On
                                        sale</span>
                                    @endif
                                    @if ($product->is_bestseller)
                                    <span
                                        class="rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800">Bestseller</span>
                                    @endif
                                    @if ($product->is_new)
                                    <span
                                        class="rounded-full bg-beige px-2 py-0.5 text-xs font-medium text-ink">New</span>
                                    @endif
                                </div>
                                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-ink">{{ $product->name }}
                                </h1>
                                @if($product->category && $product->category->name != 'Uncategorized')
                                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                                    class="mt-1 inline-flex items-center gap-1 text-xs text-gray-600 hover:text-indigo-600">
                                    <span class="inline-block w-2 h-2 rounded-full bg-indigo-500"></span>
                                    <span>{{ $product->category->name }}</span>
                                </a>
                                @endif
                            </div>
                            <span class="text-xs text-gray-500">SKU: {{ $product->id }}</span>
                        </div>

                        <div class="mt-2 flex items-center gap-3">
                            <p class="text-indigo-600 text-xl sm:text-2xl font-semibold">₫{{
                                number_format((float)$product->price, 0, ',', '.') }}</p>
                            <span class="text-sm text-green-600">In stock</span>
                        </div>

                        <!-- Variant selectors -->
                        <div class="mt-6 space-y-5">
                            <!-- Sizes -->
                            <div>
                                <p class="text-sm font-medium text-gray-700">Size</p>
                                <div role="radiogroup" aria-label="Choose size" class="mt-2 flex flex-wrap gap-2">
                                    <template x-for="s in ['S','M','L','XL']" :key="s">
                                        <button type="button" :aria-checked="size === s"
                                            :class="size === s ? 'bg-indigo-600 text-white ring-2 ring-indigo-500' : 'bg-warm text-ink border border-beige hover:bg-beige'"
                                            class="px-3 py-1.5 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            @click="size = s" :disabled="s === 'XL' ? false : false"
                                            aria-disabled="false">
                                            <span x-text="s"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Colors -->
                            <div>
                                <p class="text-sm font-medium text-gray-700">Color</p>
                                <div role="radiogroup" aria-label="Choose color" class="mt-2 flex items-center gap-3">
                                    <template x-for="c in [
                                        {id:'black', name:'Black', cls:'bg-black'},
                                        {id:'gray', name:'Gray', cls:'bg-gray-500'},
                                        {id:'navy', name:'Navy', cls:'bg-indigo-900'}
                                    ]" :key="c.id">
                                        <button type="button" :aria-checked="color === c.id"
                                            class="w-7 h-7 rounded-full ring-2 ring-beige focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            :class="[c.cls, color === c.id ? 'ring-indigo-500 ring-offset-2 ring-offset-white' : 'hover:ring-beige']"
                                            @click="color = c.id">
                                            <span class="sr-only" x-text="c.name"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity + actions -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-6 sm:mt-8"
                            x-data="{loading:false,ok:false}" @submit.prevent="
                            loading = true;
                            fetch($el.action, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-Token': document.querySelector('meta[name=csrf-token]')?.content || ''
                                },
                                body: JSON.stringify({ quantity: qty })
                            }).then(r => r.ok ? r.json() : Promise.reject(r)).then(data => {
                                if (data && data.success) { 
                                    if (window.Alpine && Alpine.store('cart')) {
                                        Alpine.store('cart').set(data.cart_count);
                                        ok = true; 
                                        setTimeout(() => ok = false, 2000);
                                    }
                                }
                            }).catch(() => {}).finally(() => { loading = false; });
                        ">
                            @csrf
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <label for="qty" class="text-sm font-medium text-gray-700">Quantity</label>
                                    <div class="flex items-center gap-1">
                                        <button type="button"
                                            class="px-2 py-1 rounded-md bg-beige text-ink border border-beige hover:bg-rosebeige focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            @click="qty = Math.max(1, qty - 1)">–</button>
                                        <input type="number" min="1" name="quantity" id="qty" x-model.number="qty"
                                            required
                                            class="w-20 rounded-md border border-beige bg-white px-3 py-2 text-ink placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-soft" />
                                        <button type="button"
                                            class="px-2 py-1 rounded-md bg-beige text-ink border border-beige hover:bg-rosebeige focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            @click="qty = qty + 1">+</button>
                                    </div>
                                </div>
                                @error('quantity')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <div class="flex flex-wrap gap-3">
                                    <button type="submit" :class="loading ? 'opacity-70 cursor-wait' : ''"
                                        class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-soft hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                        Add to Cart
                                    </button>
                                    <span x-show="ok" x-transition
                                        class="inline-flex items-center text-xs text-green-600 font-medium">Added</span>
                                    <a href="{{ route('checkout.index') }}"
                                        class="inline-flex items-center justify-center rounded-md border border-beige bg-beige px-5 py-2.5 text-sm font-semibold text-ink hover:bg-rosebeige focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                        Buy Now
                                    </a>
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center justify-center rounded-md text-sm font-semibold text-gray-600 hover:text-ink focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                <div
                    class="rounded-xl bg-white border border-beige p-5 shadow-soft hover:shadow-lg transition duration-300">
                    <h3 class="text-ink font-semibold">{{ $b['title'] }}</h3>
                    <p class="mt-1 text-gray-700 text-sm">{{ $b['desc'] }}</p>
                </div>
                @endforeach
            </div>

            <!-- Tabs -->
            <div x-data="{tab: 'desc'}" class="mt-12 rounded-xl border border-beige bg-white">
                <div class="flex flex-wrap gap-2 px-6 pt-6">
                    <button @click="tab = 'desc'"
                        :class="tab === 'desc' ? 'bg-indigo-600 text-white' : 'bg-warm text-ink hover:bg-beige'"
                        class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">Description</button>
                    <button @click="tab = 'specs'"
                        :class="tab === 'specs' ? 'bg-indigo-600 text-white' : 'bg-warm text-ink hover:bg-beige'"
                        class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">Specs</button>
                    <button @click="tab = 'ship'"
                        :class="tab === 'ship' ? 'bg-indigo-600 text-white' : 'bg-warm text-ink hover:bg-beige'"
                        class="px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">Shipping
                        & Returns</button>
                </div>
                <div class="px-6 pb-6">
                    <div x-show="tab === 'desc'" class="pt-4 text-gray-700 text-sm sm:text-base">
                        @if($product->description)
                        {{ $product->description }}
                        @else
                        Detailed product description will be available soon.
                        @endif
                    </div>
                    <div x-show="tab === 'specs'" class="pt-4 text-gray-700 text-sm sm:text-base">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Premium materials and build</li>
                            <li>Designed for daily use</li>
                            <li>Warranty and support from BluShop</li>
                        </ul>
                    </div>
                    <div x-show="tab === 'ship'" class="pt-4 text-gray-700 text-sm sm:text-base">
                        <p>Ships within 2–4 business days. Free returns within 14 days if unused and in original
                            packaging.</p>
                    </div>
                </div>
            </div>

            <!-- Related products -->
            <div class="mt-12">
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl sm:text-3xl font-bold text-ink">You may also like</h2>
                    <a href="{{ route('products.index') }}" class="text-indigo-400 font-medium hover:underline">View
                        all</a>
                </div>
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse(($relatedProducts ?? []) as $r)
                    <x-cart :product="$r" type="featured" :is-wished="in_array($r->id, $wishedIds ?? [])" />
                    @empty
                    <x-skeleton.card />
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    @include('partials.wishlist-script')
</x-app-layout>