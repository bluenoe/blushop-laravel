{{--
═══════════════════════════════════════════════════════════════
BluShop Product Detail v3 - High-End Minimalist
Concept: Sticky Sidebar & Vertical Gallery
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ Storage::url('products/' . $product->image) }}" fetchpriority="high">
    <style>
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

        {{-- BREADCRUMBS: Minimal --}}
        <div class="max-w-[1400px] mx-auto px-6 pt-6 pb-2">
            <nav class="flex text-xs uppercase tracking-widest text-neutral-500">
                <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-black transition">Shop</a>
                @if($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                    class="hover:text-black transition">{{ $product->category->name }}</a>
                @endif
                <span class="mx-2">/</span>
                <span class="text-black border-b border-black">{{ $product->name }}</span>
            </nav>
        </div>

        {{-- MAIN PRODUCT SECTION --}}
        <section class="max-w-[1400px] mx-auto px-0 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-start" x-data="{
                    activeImage: 0,
                    size: null,
                    color: null,
                    qty: 1,
                    loading: false,
                    added: false,
                    // Giả lập nhiều ảnh nếu DB chỉ có 1 ảnh
                    images: [
                        '{{ Storage::url('products/' . $product->image) }}',
                        // Thêm ảnh placeholder để demo layout gallery
                        'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=1000',
                        'https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?auto=format&fit=crop&q=80&w=1000',
                        'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?auto=format&fit=crop&q=80&w=1000'
                    ]
                 }">

                {{-- LEFT COLUMN: GALLERY (Mobile Slider / Desktop Grid) --}}
                <div class="lg:col-span-7 col-span-12 w-full">

                    {{-- Mobile View: Horizontal Slider --}}
                    <div
                        class="lg:hidden relative w-full overflow-x-auto snap-x snap-mandatory flex no-scrollbar aspect-[3/4]">
                        <template x-for="(img, index) in images" :key="index">
                            <div class="snap-center min-w-full w-full h-full bg-neutral-100 relative">
                                <img :src="img" class="w-full h-full object-cover">
                                {{-- Counter badge --}}
                                <div
                                    class="absolute bottom-4 right-4 bg-black/50 backdrop-blur text-white text-[10px] px-2 py-1 rounded-full">
                                    <span x-text="index + 1"></span> / <span x-text="images.length"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Desktop View: Vertical Masonry/Grid --}}
                    <div class="hidden lg:grid grid-cols-2 gap-4">
                        <template x-for="(img, index) in images" :key="index">
                            <div class="bg-neutral-50 relative group cursor-zoom-in"
                                :class="index === 0 ? 'col-span-2 aspect-[4/5]' : 'col-span-1 aspect-[3/4]'">
                                <img :src="img"
                                    class="w-full h-full object-cover mix-blend-multiply transition duration-700 group-hover:scale-[1.02]"
                                    loading="lazy">
                            </div>
                        </template>
                    </div>
                </div>

                {{-- RIGHT COLUMN: PRODUCT INFO (Sticky) --}}
                <div class="lg:col-span-5 col-span-12 px-6 lg:px-0 mt-8 lg:mt-0 lg:sticky lg:top-24">

                    {{-- Header --}}
                    <div class="mb-8 border-b border-neutral-200 pb-6">
                        <div class="flex justify-between items-start">
                            <h1
                                class="text-3xl md:text-4xl font-bold tracking-tighter leading-tight text-neutral-900 mb-2">
                                {{ $product->name }}
                            </h1>

                            {{-- Wishlist Button --}}
                            <div x-data="{ id: {{ $product->id }}, active: $store.wishlist.isFav({{ $product->id }}) }">
                                <button @click="$store.wishlist.toggle(id); active = $store.wishlist.isFav(id)"
                                    class="group p-2 -mr-2 rounded-full hover:bg-neutral-100 transition">
                                    <svg class="w-6 h-6 transition-colors"
                                        :class="active ? 'text-red-600 fill-current' : 'text-neutral-400 group-hover:text-black'"
                                        viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-xl font-medium text-neutral-900">
                                ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                            </span>
                            @if($product->is_on_sale)
                            <span class="bg-black text-white text-[10px] uppercase font-bold px-2 py-1">Sale</span>
                            @endif
                        </div>
                    </div>

                    {{-- Add to Cart Form --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" @submit.prevent="
                            if(!size) { alert('Please select a size'); return; }
                            loading = true;
                            // Simulate API call logic here...
                            fetch($el.action, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-Token': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({ quantity: qty, size: size, color: color })
                            }).then(r => r.ok ? r.json() : Promise.reject(r))
                            .then(data => {
                                if (data && data.success) { 
                                    Alpine.store('cart').set(data.cart_count);
                                    added = true; 
                                    setTimeout(() => added = false, 3000);
                                }
                            }).catch(() => alert('Something went wrong')).finally(() => { loading = false; });
                          ">
                        @csrf

                        {{-- 1. COLOR SELECTION --}}
                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Color</span>
                                <span class="text-xs text-neutral-900" x-text="color ? color : 'Select'"></span>
                            </div>
                            <div class="flex gap-3">
                                <template x-for="c in [
                                    {id:'black', cls:'bg-neutral-900'},
                                    {id:'white', cls:'bg-white border border-gray-200'},
                                    {id:'beige', cls:'bg-[#E8E0D5]'},
                                    {id:'navy',  cls:'bg-[#1F2937]'}
                                ]" :key="c.id">
                                    <button type="button" @click="color = c.id"
                                        class="w-8 h-8 rounded-full focus:outline-none ring-1 ring-offset-2 transition-all duration-200"
                                        :class="color === c.id ? 'ring-black scale-110' : 'ring-transparent hover:ring-gray-300 hover:scale-105'">
                                        <div :class="c.cls" class="w-full h-full rounded-full"></div>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- 2. SIZE SELECTION --}}
                        <div class="mb-8">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Size</span>
                                <button type="button" class="text-xs underline text-neutral-400 hover:text-black">Size
                                    Guide</button>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="s in ['S','M','L','XL']" :key="s">
                                    <button type="button" @click="size = s"
                                        class="py-3 border text-sm font-medium transition-all duration-200"
                                        :class="size === s 
                                                ? 'border-black bg-black text-white' 
                                                : 'border-neutral-200 text-neutral-600 hover:border-black hover:text-black'">
                                        <span x-text="s"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- 3. ACTION BUTTONS --}}
                        <div class="space-y-3">
                            <button type="submit" :disabled="loading"
                                class="w-full py-4 bg-neutral-900 text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition disabled:opacity-50 disabled:cursor-not-allowed relative">
                                <span x-show="!loading && !added">Add to Bag</span>
                                <span x-show="loading" class="animate-pulse">Processing...</span>
                                <span x-show="added" class="flex items-center justify-center gap-2">
                                    Added
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </button>

                            <p class="text-center text-[10px] text-neutral-400 uppercase tracking-widest">
                                Free shipping on orders over 500k
                            </p>
                        </div>
                    </form>

                    {{-- DETAILS ACCORDION --}}
                    <div class="mt-10 border-t border-neutral-200" x-data="{ activeTab: 'desc' }">
                        {{-- Item 1 --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'desc' ? null : 'desc'"
                                class="w-full py-4 flex justify-between items-center text-left group">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:opacity-70 transition">Description</span>
                                <span class="text-lg leading-none transition-transform duration-300"
                                    :class="activeTab === 'desc' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div x-show="activeTab === 'desc'" x-collapse
                                class="pb-6 text-sm text-neutral-600 leading-relaxed font-light">
                                <p class="mb-4">
                                    @if($product->description) {{ $product->description }} @else
                                    Crafted with precision for the modern student. This piece combines functional
                                    utility with a minimalist aesthetic, ensuring you look sharp from the lecture hall
                                    to the coffee shop.
                                    @endif
                                </p>
                                <ul class="list-disc list-inside space-y-1 text-neutral-500 marker:text-neutral-300">
                                    <li>Premium durable fabric</li>
                                    <li>Relaxed fit for comfort</li>
                                    <li>Machine washable</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Item 2 --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'ship' ? null : 'ship'"
                                class="w-full py-4 flex justify-between items-center text-left group">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:opacity-70 transition">Shipping
                                    & Returns</span>
                                <span class="text-lg leading-none transition-transform duration-300"
                                    :class="activeTab === 'ship' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div x-show="activeTab === 'ship'" x-collapse
                                class="pb-6 text-sm text-neutral-600 leading-relaxed font-light">
                                <p>Standard shipping (2-4 business days). Free returns within 14 days of purchase. Items
                                    must be unworn and in original packaging.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- RELATED PRODUCTS --}}
        <section class="border-t border-neutral-100 py-16 lg:py-24">
            <div class="max-w-[1400px] mx-auto px-6">
                <h2 class="text-2xl font-bold tracking-tight mb-8">Complete the Look</h2>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse(($relatedProducts ?? []) as $r)
                    <div class="group relative">
                        <div class="aspect-[3/4] overflow-hidden bg-neutral-100 mb-4 relative">
                            <img src="{{ Storage::url('products/' . $r->image) }}" alt="{{ $r->name }}"
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-105 filter grayscale-[20%] group-hover:grayscale-0">

                            @if($r->is_new)
                            <div
                                class="absolute top-2 left-2 bg-white text-black text-[10px] font-bold uppercase px-2 py-1">
                                New</div>
                            @endif
                        </div>
                        <h3 class="text-sm font-bold">
                            <a href="{{ route('products.show', $r) }}">
                                <span class="absolute inset-0"></span>
                                {{ $r->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-neutral-500 mt-1">₫{{ number_format((float)$r->price, 0, ',', '.') }}</p>
                    </div>
                    @empty
                    {{-- Skeleton for empty related --}}
                    <div class="col-span-full text-center py-12 text-neutral-400 text-sm">
                        More essentials coming soon.
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

    </main>

    @include('partials.wishlist-script')
</x-app-layout>