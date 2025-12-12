{{--
═══════════════════════════════════════════════════════════════
BluShop Product Detail v3 - Optimized Flow
Luồng: Product → Gallery → Variants → Complete Look → Reviews → Related
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

        {{-- BREADCRUMBS --}}
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
                images: [
                    '{{ Storage::url('products/' . $product->image) }}',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=1000',
                    'https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?auto=format&fit=crop&q=80&w=1000',
                    'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?auto=format&fit=crop&q=80&w=1000'
                ]
            }">

                {{-- LEFT: GALLERY --}}
                <div class="lg:col-span-7 col-span-12 w-full">
                    {{-- Mobile Slider --}}
                    <div
                        class="lg:hidden relative w-full overflow-x-auto snap-x snap-mandatory flex no-scrollbar aspect-[3/4]">
                        <template x-for="(img, index) in images" :key="index">
                            <div class="snap-center min-w-full w-full h-full bg-neutral-100 relative">
                                <img :src="img" class="w-full h-full object-cover">
                                <div
                                    class="absolute bottom-4 right-4 bg-black/50 backdrop-blur text-white text-[10px] px-2 py-1 rounded-full">
                                    <span x-text="index + 1"></span> / <span x-text="images.length"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Desktop Grid --}}
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

                {{-- RIGHT: PRODUCT INFO (Sticky) --}}
                <div class="lg:col-span-5 col-span-12 px-6 lg:px-0 mt-8 lg:mt-0 lg:sticky lg:top-24">

                    {{-- Header --}}
                    <div class="mb-8 border-b border-neutral-200 pb-6">
                        <div class="flex justify-between items-start">
                            <h1
                                class="text-3xl md:text-4xl font-bold tracking-tighter leading-tight text-neutral-900 mb-2">
                                {{ $product->name }}
                            </h1>

                            {{-- Wishlist Button --}}
                            <div x-data="{ id: {{ $product->id }} }">
                                <button @click="$store.wishlist.toggle(id)"
                                    class="group p-2 -mr-2 rounded-full hover:bg-neutral-100 transition-colors duration-300">
                                    <svg class="w-6 h-6 transition-all duration-300"
                                        :class="$store.wishlist.isFav(id) 
                                            ? 'text-black fill-current transform scale-110' 
                                            : 'text-neutral-400 fill-none group-hover:text-black group-hover:scale-105'" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
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

                        {{-- Color Selection --}}
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

                        {{-- Size Selection --}}
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

                        {{-- Action Buttons --}}
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

                    {{-- Accordion Sections --}}
                    <div class="mt-12 border-t border-neutral-200" x-data="{ activeTab: 'details' }">

                        {{-- Details --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'details' ? null : 'details'"
                                class="w-full py-5 flex justify-between items-center text-left group">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">
                                    Details & Composition
                                </span>
                                <span
                                    class="text-xl leading-none transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="activeTab === 'details' ? 'rotate-45' : 'rotate-0'">+</span>
                            </button>
                            <div x-show="activeTab === 'details'" x-collapse.duration.500ms class="overflow-hidden">
                                <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed">
                                    <p class="mb-5">{{ $product->description ?? 'Timeless design meets modern
                                        functionality.' }}</p>
                                    @if(!empty($product->specifications))
                                    <dl class="space-y-2">
                                        @foreach($product->specifications as $key => $value)
                                        <div
                                            class="flex justify-between py-2 border-b border-dashed border-neutral-100 last:border-0">
                                            <dt class="text-neutral-900 font-medium">{{ $key }}</dt>
                                            <dd class="text-neutral-500">{{ $value }}</dd>
                                        </div>
                                        @endforeach
                                    </dl>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Care Guide --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'care' ? null : 'care'"
                                class="w-full py-5 flex justify-between items-center text-left group">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">Care
                                    Guide</span>
                                <span
                                    class="text-xl leading-none transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="activeTab === 'care' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div x-show="activeTab === 'care'" x-collapse.duration.500ms class="overflow-hidden">
                                <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed space-y-2">
                                    @if($product->care_guide)
                                    {!! nl2br(e($product->care_guide)) !!}
                                    @else
                                    <p>Do not wash. Do not bleach. Do not iron. Do not dry clean.</p>
                                    <p>Clean with a soft dry cloth. Keep away from direct heat.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Shipping --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'ship' ? null : 'ship'"
                                class="w-full py-5 flex justify-between items-center text-left group">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">Shipping
                                    & Returns</span>
                                <span
                                    class="text-xl leading-none transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="activeTab === 'ship' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div x-show="activeTab === 'ship'" x-collapse.duration.500ms class="overflow-hidden">
                                <div class="pb-6 text-sm text-neutral-600 font-light">
                                    Free standard shipping on orders over 500k. Returns accepted within 30 days.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- COMPLETE THE LOOK --}}
        @if($product->completeLookProducts->count() > 0)
        <section class="max-w-[1400px] mx-auto px-6 py-20 border-t border-neutral-100">
            <div class="md:flex md:items-end md:justify-between mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-neutral-900">Complete The Look</h2>
                <a href="#"
                    class="hidden md:block text-xs border-b border-black pb-0.5 hover:text-neutral-600 transition">Shop
                    the full set</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10 gap-x-6">
                @foreach($product->completeLookProducts as $lookItem)
                <div class="group relative">
                    <div class="aspect-[3/4] overflow-hidden bg-neutral-100 mb-4">
                        <img src="{{ Storage::url('products/' . $lookItem->image) }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    </div>
                    <h3 class="text-sm font-medium">
                        <a href="{{ route('products.show', $lookItem->id) }}">
                            <span class="absolute inset-0"></span>
                            {{ $lookItem->name }}
                        </a>
                    </h3>
                    <p class="text-sm text-neutral-500 mt-1">₫{{ number_format($lookItem->price, 0, ',', '.') }}</p>

                    <button
                        class="absolute bottom-20 right-4 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity translate-y-2 group-hover:translate-y-0 duration-300 z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- REVIEWS SECTION --}}
        <section class="border-t border-neutral-100 py-16 lg:py-24" id="reviews">
            <div class="max-w-[1400px] mx-auto px-6">
                <div class="lg:grid lg:grid-cols-12 lg:gap-16">

                    {{-- Left: Summary --}}
                    <div class="lg:col-span-4 mb-12 lg:mb-0">
                        <h2 class="text-2xl font-bold tracking-tight mb-6">Reviews</h2>

                        {{-- Overall Rating --}}
                        <div class="flex items-baseline gap-4 mb-8">
                            <span class="text-5xl font-bold tracking-tighter">{{ number_format($product->avg_rating, 1)
                                }}</span>
                            <div class="flex flex-col">
                                <div class="flex text-black">
                                    @for($i=1; $i<=5; $i++) <svg
                                        class="w-4 h-4 {{ $i <= round($product->avg_rating) ? 'fill-current' : 'text-neutral-300' }}"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                        @endfor
                                </div>
                                <span class="text-xs text-neutral-500 mt-1">Based on {{ $product->reviews->count() }}
                                    reviews</span>
                            </div>
                        </div>

                        {{-- Fit Scale --}}
                        <div class="mb-8">
                            <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 mb-4">Fit Scale</p>
                            <div class="relative h-2 bg-neutral-100 rounded-full w-full mt-2">
                                @php
                                $fitPercent = ($product->avg_fit - 1) / 4 * 100;
                                $fitPercent = max(0, min(100, $fitPercent));
                                @endphp
                                <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-black rounded-full border-2 border-white shadow-sm transition-all duration-1000"
                                    style="left: {{ $fitPercent }}%"></div>
                            </div>
                            <div
                                class="flex justify-between text-[10px] text-neutral-400 uppercase tracking-wider mt-2 font-medium">
                                <span>Tight</span>
                                <span>True to Size</span>
                                <span>Loose</span>
                            </div>
                        </div>

                        {{-- Write Review Button --}}
                        <div x-data="{ open: false }">
                            @auth
                            <button @click="open = !open"
                                class="w-full py-3 border border-black text-black text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                                Write a Review
                            </button>
                            @else
                            <a href="{{ route('login') }}"
                                class="block text-center w-full py-3 border border-neutral-200 text-neutral-500 text-xs font-bold uppercase tracking-widest hover:border-black hover:text-black transition">
                                Login to Review
                            </a>
                            @endauth

                            {{-- Review Form --}}
                            <div x-show="open" x-collapse class="mt-6 p-6 bg-neutral-50">
                                <form action="{{ route('reviews.store', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Star Rating --}}
                                    <div class="mb-4" x-data="{ rating: 0, hoverRating: 0 }">
                                        <label
                                            class="block text-xs font-bold uppercase tracking-widest mb-2">Rating</label>
                                        <div class="flex gap-1 cursor-pointer" @mouseleave="hoverRating = 0">
                                            <template x-for="i in 5">
                                                <svg @click="rating = i" @mouseover="hoverRating = i"
                                                    class="w-6 h-6 transition-colors"
                                                    :class="(hoverRating || rating) >= i ? 'fill-black text-black' : 'text-neutral-300 fill-none'"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                            </template>
                                        </div>
                                        <input type="hidden" name="rating" :value="rating" required>
                                    </div>

                                    {{-- Fit Rating --}}
                                    <div class="mb-4" x-data="{ fit: 3 }">
                                        <label class="block text-xs font-bold uppercase tracking-widest mb-2">How's the
                                            fit?</label>
                                        <input type="range" name="fit_rating" min="1" max="5" step="1" x-model="fit"
                                            class="w-full h-1 bg-neutral-200 rounded-lg appearance-none cursor-pointer accent-black">
                                        <div
                                            class="flex justify-between text-[10px] text-neutral-500 mt-2 uppercase font-medium">
                                            <span :class="fit == 1 ? 'text-black font-bold' : ''">Tight</span>
                                            <span :class="fit == 3 ? 'text-black font-bold' : ''">True to Size</span>
                                            <span :class="fit == 5 ? 'text-black font-bold' : ''">Loose</span>
                                        </div>
                                    </div>

                                    {{-- Comment --}}
                                    <div class="mb-4">
                                        <label
                                            class="block text-xs font-bold uppercase tracking-widest mb-2">Review</label>
                                        <textarea name="comment" rows="3" required
                                            class="w-full bg-white border border-neutral-200 p-3 text-sm focus:outline-none focus:border-black transition"
                                            placeholder="Tell us what you think..."></textarea>
                                    </div>

                                    {{-- Image Upload --}}
                                    <div class="mb-6">
                                        <label class="block text-xs font-bold uppercase tracking-widest mb-2">Photo
                                            (Optional)</label>
                                        <input type="file" name="image" accept="image/*"
                                            class="block w-full text-xs text-neutral-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-700 transition" />
                                    </div>

                                    <button type="submit"
                                        class="w-full py-3 bg-neutral-900 text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                                        Submit Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-12"> {{-- Tạm để full width hoặc chỉnh lại col-span-8 tùy layout trên --}}
                        @if($product->reviews->count() > 0)
                        <div class="space-y-12">
                            @foreach($product->reviews as $review)
                            <div class="border-b border-neutral-100 pb-8 last:border-0">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-full bg-neutral-900 text-white flex items-center justify-center text-xs font-bold uppercase">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-neutral-900">{{ $review->user->name }}
                                            </div>
                                            <div class="text-[10px] text-neutral-400 uppercase tracking-wider">{{
                                                $review->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>

                                    {{-- Stars --}}
                                    <div class="flex text-black gap-0.5">
                                        @for($i=1; $i<=5; $i++) <svg
                                            class="w-3 h-3 {{ $i <= $review->rating ? 'fill-black' : 'text-neutral-200 fill-none' }}"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                            @endfor
                                    </div>
                                </div>

                                <div class="pl-14">
                                    {{-- Fit Badge --}}
                                    @php
                                    $fitLabel = match($review->fit_rating) {
                                    1 => 'Runs Small', 2 => 'Slightly Small', 3 => 'True to Size', 4 => 'Slightly
                                    Large', 5 => 'Runs Large', default => 'True to Size'
                                    };
                                    @endphp
                                    <div class="mb-3">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-widest border border-neutral-200 px-2 py-1 rounded-sm">
                                            Fit: {{ $fitLabel }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-neutral-600 leading-relaxed font-light mb-4">
                                        {{ $review->comment }}
                                    </p>

                                    @if($review->image)
                                    <div>
                                        <img src="{{ Storage::url($review->image) }}"
                                            class="w-20 h-20 object-cover cursor-zoom-in grayscale hover:grayscale-0 transition duration-500"
                                            onclick="window.open(this.src)">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="py-16 text-center">
                            <p class="text-neutral-400 font-light text-sm italic">Be the first to review this piece.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{--
        ========================================================
        5. CURATED FOR YOU (LV / EDITORIAL STYLE)
        Layout: Bento Grid (1 Large Left + 4 Small Grid Right)
        ========================================================
        --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <section class="border-t border-black py-20 lg:py-24 bg-white">
            <div class="max-w-[1400px] mx-auto px-6">

                {{-- Typography Heading --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <h2 class="text-4xl md:text-6xl font-light tracking-tighter leading-none text-neutral-900">
                        Curated <br> <span class="font-serif italic text-neutral-400 pl-16">for you.</span>
                    </h2>
                    <a href="{{ route('products.index') }}"
                        class="mt-6 md:mt-0 text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-600 hover:border-neutral-600 transition">View
                        Collection</a>
                </div>

                {{-- BENTO GRID LAYOUT --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 h-auto md:h-[600px]">

                    @foreach($relatedProducts->take(5) as $index => $related)
                    @php
                    $imgUrl = $related->image ? Storage::url('products/' . $related->image) :
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=800';

                    // LOGIC QUAN TRỌNG:
                    // Item đầu tiên (index 0): Chiếm 2 cột, 2 dòng (To bự bên trái)
                    // Các item còn lại: Chiếm 1 cột, 1 dòng (Vuông nhỏ bên phải)
                    $classes = ($index === 0)
                    ? 'col-span-2 row-span-2 md:h-full relative group'
                    : 'col-span-1 row-span-1 relative group';
                    @endphp

                    <div class="{{ $classes }} overflow-hidden bg-neutral-100">
                        {{-- Ảnh --}}
                        <img src="{{ $imgUrl }}"
                            class="w-full h-full object-cover transition duration-[1.5s] ease-out group-hover:scale-105"
                            loading="lazy">

                        {{-- Badges --}}
                        @if($index === 0)
                        <div
                            class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold uppercase px-3 py-1.5 z-10">
                            New Drop</div>
                        @elseif($related->is_new)
                        <div class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full z-10"></div>
                        @endif

                        {{-- Info Overlay (Hiệu ứng mờ dần từ dưới lên) --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                            <div
                                class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500 text-white">
                                <h3 class="text-sm md:text-lg font-bold uppercase tracking-widest">{{ $related->name }}
                                </h3>
                                <p class="text-xs md:text-sm font-light mt-1 opacity-90">₫{{
                                    number_format($related->price, 0, ',', '.') }}</p>
                                <a href="{{ route('products.show', $related->id) }}"
                                    class="inline-block mt-3 text-[10px] font-bold uppercase border-b border-white pb-0.5">Shop
                                    Now</a>
                            </div>
                        </div>

                        {{-- Link bao trùm --}}
                        <a href="{{ route('products.show', $related->id) }}" class="absolute inset-0 z-20"></a>
                    </div>
                    @endforeach

                </div>
            </div>
        </section>
        @endif

    </main>
    @include('partials.wishlist-script')
</x-app-layout>