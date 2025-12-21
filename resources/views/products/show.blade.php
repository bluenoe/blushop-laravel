{{--
═══════════════════════════════════════════════════════════════
BluShop Product Detail v4 - Hybrid (Apparel & Fragrance Engine)
Updated: Supports Dynamic Pricing, Scent Pyramid, & Variants
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

        [x-cloak] {
            display: none !important;
        }

        /* Hiệu ứng fade cho giá tiền */
        .price-transition {
            transition: all 0.3s ease;
        }
    </style>

    @endpush

    <main class="bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white">

        {{-- 1. BREADCRUMBS --}}
        <div class="max-w-[1400px] mx-auto px-6 pt-6 pb-2">
            <nav class="flex text-xs uppercase tracking-widest text-neutral-500">
                <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-black transition">Shop</a>
                @if($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('products.index', ['category' => $product->category]) }}"
                    class="hover:text-black transition">
                    {{ ucfirst($product->category) }}
                </a>
                @endif
                <span class="mx-2">/</span>
                <span class="text-black border-b border-black">{{ $product->name }}</span>
            </nav>
        </div>

        {{-- 2. MAIN PRODUCT SECTION --}}
        <section class="max-w-[1400px] mx-auto px-0 sm:px-6 lg:px-8 py-0 lg:py-12">
            @php
            // 1. LOGIC TÌM ẢNH MẶC ĐỊNH (FIXED by Antigravity)
            // Priority: Default Variant Image -> Product Main Image -> Placeholder

            // $defaultVariant is already passed from controller, but let's ensure we have it
            $defVariant = $product->variants->first();
            $defaultImage = null;

            if ($defVariant && $defVariant->image_path) {
            // Calculate URL safely
            $defaultImage = Storage::url($defVariant->image_path);
            $defaultColor = $defVariant->color_name;
            } elseif ($product->image) {
            // Fallback to Product Image
            // Check if it already has path or needs prefix
            $path = Str::startsWith($product->image, 'products/') ? $product->image : 'products/' . $product->image;
            $defaultImage = Storage::url($path);
            $defaultColor = null;
            } else {
            $defaultImage = 'https://placehold.co/600x800?text=No+Image';
            $defaultColor = null;
            }

            // 2. Logic Variants (Fragrance/General)
            $isFragrance = $product->variants->isNotEmpty() && !empty($defVariant->capacity_ml);

            // 3. PRICE LOGIC (Fix Missing Prices)
            // Priority: Product Price -> First Variant Price -> 0
            $currentPrice = $product->price ?? ($defVariant ? $defVariant->price : 0);

            // SKU
            $currentSku = $defVariant ? $defVariant->sku : null;
            @endphp

            {{--
            ALPINE DATA OBJECT (THE BRAIN)
            ------------------------------
            Xử lý song song 2 logic: Quần áo (Color/Size) và Nước hoa (Variant/Price)
            --}}
            {{-- 1. CHUẨN BỊ DỮ LIỆU Ở VÙNG AN TOÀN (SCRIPT TAG) --}}
            <script>
                window.productConfig = {
                    isFragrance: @json($isFragrance),
                    variants: @json($product -> variants),
                    defaultImage: @json($defaultImage),
                    defaultPrice: @json($currentPrice),
                    defaultColor: @json($defaultColor),
                    defaultSize: @json($product -> default_size ?? null),
                    defaultCapacity: @json($product -> default_capacity ?? null),
                    defaultVariantId: @json($product -> default_variant_id ?? null)
                };
            </script>

            {{-- 2. KHỞI TẠO ALPINE VỚI DỮ LIỆU SẠCH --}}
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-start" x-data="{
    // State cơ bản
    loading: false,
    added: false,
    qty: 1,
    
    // Lấy dữ liệu từ biến window
    isFragrance: window.productConfig.isFragrance,
    variants: window.productConfig.variants,
    
    // State hiển thị
    currentImage: window.productConfig.defaultImage,
    price: window.productConfig.defaultPrice,
    
    // State lựa chọn
    selectedColor: window.productConfig.defaultColor,
    selectedSize: window.productConfig.defaultSize,
    selectedCapacity: window.productConfig.defaultCapacity,
    selectedVariantId: window.productConfig.defaultVariantId,
    sku: null,

    // VINTAGE PALETTE (MINIMALIST & VINTAGE AESTHETIC)
    vintageColorPalette: {
        'Red': '#A94044',       // Muted Clay/Brick
        'Blue': '#2C3E50',      // Deep Slate/Navy
        'Green': '#556B2F',     // Olive/Sage
        'Yellow': '#E3C800',    // Mustard/Ochre
        'Black': '#1A1A1A',     // Off-Black
        'White': '#F5F5F5',     // Off-White/Cream
        'Brown': '#8D6E63',     // Warm Taupe
        'Pink': '#D8B4B4',      // Dusty Rose
        'Beige': '#F5F5DC',     // Beige
        'Navy': '#202A44',      // Classic Navy
        'Grey': '#808080',      // Neutral Grey
        'Gray': '#808080'       // Neutral Gray
    },

    // CUSTOM HELPER: GET COLOR STYLE
    getColorStyle(name, dbHex) {
        // 1. Nếu DB có Hex xịn -> Dùng luôn
        if (dbHex && dbHex !== 'null') return dbHex;
        
        // 2. Map theo tên (Vintage Palette) - Case Insensitive for safety
        // Capitalize first letter logic handled by simple lookup since keys are capitalized
        return this.vintageColorPalette[name] || this.vintageColorPalette[Object.keys(this.vintageColorPalette).find(k => k.toLowerCase() === name.toLowerCase())] || '#CCCCCC';
    },

    // CÁC HÀM XỬ LÝ LOGIC GIỮ NGUYÊN
    init() {
        console.log('Alpine Loaded. Variants:', this.variants);
    },

    // LOGIC 1: CHỌN MÀU
    selectColor(colorName, imageUrl) {
        this.selectedColor = colorName;
        if (imageUrl) this.currentImage = imageUrl;

        // Tìm variant khớp Màu + Size đang chọn
        let variant = this.variants.find(v => v.color === colorName && v.size === this.selectedSize) 
                   || this.variants.find(v => v.color === colorName);

        if (variant) this.updateVariantState(variant);
    },

    // LOGIC 2: CHỌN SIZE
    selectSize(size) {
        this.selectedSize = size;
        let variant = this.variants.find(v => v.color === this.selectedColor && v.size === size);
        if (variant) this.updateVariantState(variant);
    },

    // LOGIC 3: CHỌN DUNG TÍCH
    selectCapacity(capacity) {
        this.selectedCapacity = capacity;
        let variant = this.variants.find(v => v.capacity == capacity);
        if (variant) {
            this.updateVariantState(variant);
            if (variant.image) this.currentImage = variant.image; 
        }
    },

    // Cập nhật giá và ID
    updateVariantState(v) {
        this.selectedVariantId = v.id;
        this.price = v.price;
    }
}">

                {{-- LEFT: GALLERY --}}
                <div class="lg:col-span-7 col-span-12 w-full mb-8 lg:mb-0">
                    <div
                        class="relative w-full aspect-[3/4] lg:aspect-[4/5] bg-neutral-100 overflow-hidden group cursor-zoom-in">
                        <img :src="currentImage" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110"
                            loading="eager" fetchpriority="high">

                        {{-- Badge SKU (Only showing if Fragrance) --}}
                        <div x-show="sku" class="absolute top-6 left-6" x-cloak>
                            <span
                                class="bg-white/80 backdrop-blur px-3 py-1 text-[10px] font-mono uppercase tracking-widest"
                                x-text="'REF: ' + sku"></span>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: PRODUCT INFO --}}
                <div class="lg:col-span-5 col-span-12 px-6 lg:px-0 mt-8 lg:mt-0 lg:sticky lg:top-24">

                    {{-- Header --}}
                    <div class="mb-8 border-b border-neutral-200 pb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1
                                    class="text-3xl md:text-4xl font-bold tracking-tighter leading-tight text-neutral-900 mb-2">
                                    {{ $product->name }}
                                </h1>
                                {{-- Subtitle cho Nước hoa (Concentration) --}}
                                @if(!empty($product->specifications['concentration']))
                                <p class="text-sm text-neutral-500 uppercase tracking-widest mb-1">{{
                                    $product->specifications['concentration'] }}</p>
                                @endif
                            </div>

                            {{-- Wishlist Button --}}
                            <div x-data="{ id: {{ $product->id }} }">
                                <button @click="$store.wishlist.toggle(id)"
                                    class="group p-2 -mr-2 rounded-full hover:bg-neutral-100 transition-colors duration-300">
                                    <svg class="w-6 h-6 transition-all duration-300"
                                        :class="$store.wishlist.isFav(id) ? 'text-black fill-current transform scale-110' : 'text-neutral-400 fill-none group-hover:text-black'"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Price Area (Dynamic) --}}
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-xl font-medium text-neutral-900 price-transition"
                                x-text="'₫' + new Intl.NumberFormat('vi-VN').format(price)">
                                {{-- Server Render Fallback --}}
                                ₫{{ number_format((float)$currentPrice, 0, ',', '.') }}
                            </span>

                            @if($product->is_on_sale)
                            <span class="bg-black text-white text-[10px] uppercase font-bold px-2 py-1">Sale</span>
                            @endif
                        </div>
                    </div>

                    {{-- Add to Cart Form --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" @submit.prevent="
                        if(isFragrance ? !selectedVariantId : !selectedSize) { alert(isFragrance ? 'Please select a volume' : 'Please select a size'); return; }
                        loading = true;
                        
                        // Chuẩn bị payload
                        let payload = { quantity: qty, size: selectedSize, color: selectedColor };
                        if(selectedVariantId) payload.variant_id = selectedVariantId; // Gửi kèm ID variant nếu có

                        fetch($el.action, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-Token': document.querySelector('meta[name=csrf-token]').content },
                            body: JSON.stringify(payload)
                        }).then(r => r.ok ? r.json() : Promise.reject(r))
                        .then(data => {
                            loading = false;
                            if (data && data.success) { 
                                window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
                                added = true; 
                                setTimeout(() => added = false, 3000);
                            }
                        });
                    ">
                        @csrf

                        {{-- =================================================== --}}
                        {{-- CASE 1: APPAREL SELECTORS (MÀU & SIZE S/M/L) --}}
                        {{-- =================================================== --}}
                        <div x-show="!isFragrance">
                            {{-- Color Selection --}}
                            <div class="mb-6">
                                <div class="flex justify-between mb-2">
                                    <span
                                        class="text-xs font-bold uppercase tracking-widest text-neutral-500">Color</span>
                                    <span class="text-xs text-neutral-900"
                                        x-text="selectedColor ? selectedColor : 'Select'"></span>
                                </div>

                                @if(count($availableColors) > 0)
                                <div class="flex gap-3">
                                    @foreach($availableColors as $c)
                                    <button type="button" {{-- Lấy tên và ảnh từ mảng $c --}}
                                        @click="selectColor('{{ $c['name'] }}', '{{ $c['image'] }}')"
                                        class="w-8 h-8 rounded-full focus:outline-none ring-1 ring-offset-2 transition-all duration-200"
                                        {{-- Logic Active: So sánh với selectedColor --}}
                                        :class="selectedColor === '{{ $c['name'] }}' ? 'ring-black scale-110' : 'ring-transparent hover:ring-gray-300 hover:scale-105'"
                                        title="{{ $c['name'] }}">

                                        {{-- Hiển thị chấm màu: Dùng getColorStyle thay vì Hex trực tiếp --}}
                                        <div class="w-full h-full rounded-full border border-neutral-200"
                                            :style="`background-color: ${getColorStyle('{{ $c['name'] }}', '{{ $c['hex'] }}')}`">
                                        </div>
                                    </button>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-sm text-neutral-400 italic">One color only</p>
                                @endif
                            </div>

                            {{-- Size Selection (Standard) --}}
                            <div class="mb-8">
                                <div class="flex justify-between mb-2">
                                    <span
                                        class="text-xs font-bold uppercase tracking-widest text-neutral-500">Size</span>
                                    <x-product.size-guide-modal model-info="Model is 175cm / 65kg – Wearing size M" />
                                </div>
                                <div class="grid grid-cols-4 gap-2">
                                    <template x-for="s in ['S','M','L','XL']" :key="s">
                                        <button type="button" @click="selectSize(s)"
                                            class="py-3 border text-sm font-medium transition-all duration-200"
                                            :class="selectedSize === s ? 'border-black bg-black text-white' : 'border-neutral-200 text-neutral-600 hover:border-black hover:text-black'">
                                            <span x-text="s"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- =================================================== --}}
                        {{-- CASE 2: FRAGRANCE SELECTORS (VOLUME - DUNG TÍCH) --}}
                        {{-- =================================================== --}}
                        <div x-show="isFragrance" x-cloak>
                            <div class="mb-8">
                                <div class="flex justify-between mb-2">
                                    <span
                                        class="text-xs font-bold uppercase tracking-widest text-neutral-500">Volume</span>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    {{-- Loop qua Variants JSON --}}
                                    <template x-for="variant in variants" :key="variant.id">
                                        <button type="button" @click="selectVariant(variant)"
                                            class="py-4 border flex flex-col items-center justify-center transition-all duration-200 relative overflow-hidden"
                                            :class="selectedVariantId === variant.id ? 'border-black bg-neutral-50' : 'border-neutral-200 hover:border-neutral-400'">

                                            {{-- Dung tích --}}
                                            <span class="text-sm font-bold uppercase"
                                                :class="selectedVariantId === variant.id ? 'text-black' : 'text-neutral-600'"
                                                x-text="variant.capacity_ml + 'ml'"></span>

                                            {{-- Trạng thái kho --}}
                                            <template x-if="variant.stock_quantity <= 0">
                                                <span
                                                    class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                                    <span
                                                        class="text-[10px] bg-neutral-200 px-2 py-1 text-neutral-500 font-bold uppercase">Sold
                                                        Out</span>
                                                </span>
                                            </template>
                                        </button>
                                    </template>
                                </div>
                                <p class="mt-3 text-[10px] text-neutral-400 font-light flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    In Stock. Ready to ship.
                                </p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-3">
                            <button type="submit" :disabled="loading"
                                class="w-full py-4 bg-neutral-900 text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition disabled:opacity-50 disabled:cursor-not-allowed relative">
                                <span x-show="!loading && !added">Add to Bag</span>
                                <span x-show="loading" class="animate-pulse">Processing...</span>
                                <span x-show="added" class="flex items-center justify-center gap-2">Added <svg
                                        class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg></span>
                            </button>
                            <p
                                class="flex items-center justify-center gap-2 text-center text-[10px] text-neutral-400 uppercase tracking-widest">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Free shipping over 1.000.000₫ & 30-day returns
                            </p>
                        </div>
                    </form>

                    {{-- Accordion Sections --}}
                    <div class="mt-12 border-t border-neutral-200" x-data="{ activeTab: 'details' }">

                        {{-- Details --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'details' ? null : 'details'"
                                class="w-full py-5 flex justify-between items-center text-left group select-none">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">
                                    Details & Composition
                                </span>
                                <span class="text-xl leading-none transition-transform duration-300"
                                    :class="activeTab === 'details' ? 'rotate-45' : 'rotate-0'">+</span>
                            </button>
                            <div class="grid transition-[grid-template-rows] duration-300"
                                :class="activeTab === 'details' ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                <div class="overflow-hidden">
                                    <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed">
                                        <p class="mb-5">{{ $product->description }}</p>

                                        {{--
                                        VISUAL SCENT PYRAMID (HIỂN THỊ TẦNG HƯƠNG)
                                        Chỉ hiện nếu có data trong cột specifications
                                        --}}
                                        @if(!empty($product->specifications) &&
                                        isset($product->specifications['top_notes']))
                                        <div class="bg-neutral-50 p-5 rounded-sm border border-neutral-100 space-y-4">
                                            <h4
                                                class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 border-b border-neutral-200 pb-2 mb-2">
                                                Olfactory Notes</h4>

                                            {{-- Top Notes --}}
                                            <div class="flex gap-4">
                                                <div class="w-16 text-[10px] font-bold uppercase text-neutral-400 pt-1">
                                                    Top</div>
                                                <div class="text-neutral-900 font-medium">
                                                    {{ implode(', ', $product->specifications['top_notes']) }}
                                                </div>
                                            </div>
                                            {{-- Middle Notes --}}
                                            @if(isset($product->specifications['middle_notes']))
                                            <div class="flex gap-4">
                                                <div class="w-16 text-[10px] font-bold uppercase text-neutral-400 pt-1">
                                                    Heart</div>
                                                <div class="text-neutral-900 font-medium">
                                                    {{ implode(', ', $product->specifications['middle_notes']) }}
                                                </div>
                                            </div>
                                            @endif
                                            {{-- Base Notes --}}
                                            @if(isset($product->specifications['base_notes']))
                                            <div class="flex gap-4">
                                                <div class="w-16 text-[10px] font-bold uppercase text-neutral-400 pt-1">
                                                    Base</div>
                                                <div class="text-neutral-900 font-medium">
                                                    {{ implode(', ', $product->specifications['base_notes']) }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @elseif(!empty($product->specifications))
                                        {{-- Fallback cho sản phẩm thường --}}
                                        <dl class="space-y-2 mt-4">
                                            @foreach($product->specifications as $key => $value)
                                            @if(is_string($value))
                                            <div
                                                class="flex justify-between py-2 border-b border-dashed border-neutral-100 last:border-0">
                                                <dt class="text-neutral-900 font-medium capitalize">{{ str_replace('_',
                                                    ' ', $key) }}</dt>
                                                <dd class="text-neutral-500">{{ $value }}</dd>
                                            </div>
                                            @endif
                                            @endforeach
                                        </dl>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Care Guide & Shipping (Giữ nguyên) --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'ship' ? null : 'ship'"
                                class="w-full py-5 flex justify-between items-center text-left group">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">Shipping
                                    & Returns</span>
                                <span class="text-xl leading-none transition-transform duration-300"
                                    :class="activeTab === 'ship' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div class="grid transition-[grid-template-rows] duration-300"
                                :class="activeTab === 'ship' ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                <div class="overflow-hidden">
                                    <div class="pb-6 text-sm text-neutral-600 font-light">Free standard shipping on
                                        orders over 500k. Returns accepted within 30 days.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. COMPLETE THE LOOK (Smart Logic: Apparel + Same Gender) --}}
        @if(isset($completeLook) && $completeLook->count() > 0)
        <section class="max-w-[1400px] mx-auto px-6 py-20 border-t border-neutral-100">
            <div class="md:flex md:items-end md:justify-between mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-neutral-900">Complete The Look</h2>
                <a href="{{ route('products.index', ['complete_look' => $product->id]) }}"
                    class="hidden md:block text-xs border-b border-black pb-0.5 hover:text-neutral-600 transition">
                    Shop the full set
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10 gap-x-6">
                @foreach($completeLook as $lookItem)
                @php
                // 1. Default to Placeholder first
                $imgSrc = 'https://placehold.co/600x800?text=No+Image';

                // 2. Only attempt to build path if image is NOT empty
                if (!empty($lookItem->image)) {
                // Check if it's already an absolute URL
                if (Str::startsWith($lookItem->image, ['http://', 'https://'])) {
                $imgSrc = $lookItem->image;
                } else {
                // Build the path: storage/products/{slug}/{filename}
                $imgSrc = asset('storage/products/' . $lookItem->slug . '/' . basename($lookItem->image));
                }
                }
                @endphp
                <div class="group relative overflow-hidden">
                    <div class="aspect-[3/4] overflow-hidden bg-neutral-100 mb-4">
                        <img src="{{ $imgSrc }}"
                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                            alt="{{ $lookItem->name }}" loading="lazy">
                    </div>
                    <h3 class="text-sm font-medium">
                        <a href="{{ route('products.show', $lookItem->id) }}">
                            <span class="absolute inset-0"></span>
                            {{ $lookItem->name }}
                        </a>
                    </h3>
                    <p class="text-sm text-neutral-600 mt-1">₫{{ number_format($lookItem->price ??
                        $lookItem->variants->first()?->price ?? 0, 0, ',', '.') }}</p>

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

        {{-- 4. REVIEWS SECTION (AJAX Enabled) --}}
        <section class="border-t border-neutral-100 py-16 lg:py-24 bg-neutral-50/30" id="reviews">
            <div class="max-w-[1400px] mx-auto px-6 grid lg:grid-cols-12 gap-12">
                {{-- LEFT COLUMN: Summary & Form --}}
                <div class="lg:col-span-4">
                    <h2 class="text-2xl font-bold mb-4 tracking-tight">Reviews</h2>
                    <div class="flex items-baseline gap-4 mb-6">
                        <span class="text-5xl font-bold tracking-tighter">{{ number_format($product->avg_rating, 1)
                            }}</span>
                        <div class="flex flex-col">
                            <div class="flex text-black text-xs">
                                @for($i=1; $i<=5; $i++) <svg
                                    class="w-4 h-4 {{ $i <= round($product->avg_rating) ? 'fill-black' : 'text-neutral-300 fill-none' }}"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    @endfor
                            </div>
                            <span class="text-xs text-neutral-500 mt-1 font-medium">{{ $product->reviews_count }}
                                reviews</span>
                        </div>
                    </div>

                    {{-- Minimalist Validation --}}
                    <div x-data="{ 
    open: false, 
    submitting: false, 
    success: false,
    rating: 5, 
    hoverRating: 0,
    fit: 3,
    errors: {}, // 1. Biến chứa lỗi từ Server
    imagePreview: null,

    // Hàm xử lý file ảnh review
    handleImage(e) {
        const file = e.target.files[0];
        if(file) {
            this.imagePreview = URL.createObjectURL(file);
        }
    },

    submitReview(e) {
        this.submitting = true;
        this.errors = {}; // Reset lỗi cũ
        const formData = new FormData(e.target);

        fetch(e.target.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json' // Bắt buộc để Laravel trả về JSON
            },
            body: formData
        }).then(response => {
            // 2. Nếu lỗi Validate (422), ném ra catch
            if (response.status === 422) {
                return response.json().then(data => {
                    this.errors = data.errors;
                    throw new Error('Validation Failed');
                });
            }
            if (!response.ok) throw response;
            return response.json();
        }).then(data => {
            // 3. Thành công
            this.success = true;
            this.submitting = false;
            this.open = false;
            setTimeout(() => { window.location.reload(); }, 1500);
        }).catch(err => {
            this.submitting = false;
            // Nếu không phải lỗi validate thì mới alert
            if (!this.errors || Object.keys(this.errors).length === 0) {
                console.error(err);
                alert('Something went wrong. Please try again.');
            }
        });
    }
}">
                        @auth
                        <button @click="open = !open" x-show="!success"
                            class="w-full py-4 border border-black text-black text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition duration-300">
                            <span x-text="open ? 'Close' : 'Write a Review'"></span>
                        </button>

                        {{-- Thông báo thành công --}}
                        <div x-show="success" x-transition
                            class="p-4 bg-black text-white text-center text-sm mb-4 flex flex-col items-center justify-center">
                            <svg class="w-6 h-6 mb-2 text-green-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="font-bold uppercase tracking-widest text-xs">Review Submitted</p>
                        </div>

                        {{-- Form Area --}}
                        <div x-show="open && !success" x-collapse class="mt-8">
                            {{-- Thêm novalidate để tắt popup trình duyệt --}}
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST"
                                enctype="multipart/form-data" @submit.prevent="submitReview" novalidate>

                                {{-- 1. RATING --}}
                                <div class="mb-8">
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest mb-3 transition-colors duration-300"
                                        :class="errors.rating ? 'text-red-500 animate-pulse' : 'text-neutral-500'">
                                        Rating <span x-show="errors.rating" x-text="'(* Required)'"
                                            class="normal-case font-medium"></span>
                                    </label>
                                    <div class="flex gap-2 cursor-pointer" @mouseleave="hoverRating = 0">
                                        <template x-for="i in 5">
                                            <svg @click="rating = i" @mouseover="hoverRating = i"
                                                class="w-8 h-8 transition-all duration-200 transform hover:scale-110"
                                                :class="(hoverRating || rating) >= i ? 'fill-black text-black' : 'text-neutral-200 fill-none'"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </template>
                                    </div>
                                    <input type="hidden" name="rating" :value="rating">
                                    <p x-show="errors.rating" x-text="errors.rating[0]"
                                        class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide"></p>
                                </div>

                                {{-- 2. FIT RATING (Slider) --}}
                                <div class="mb-8">
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest mb-4 transition-colors duration-300"
                                        :class="errors.fit_rating ? 'text-red-500 animate-pulse' : 'text-neutral-500'">
                                        How's the fit?
                                    </label>
                                    <div class="relative pt-1">
                                        <input type="range" name="fit_rating" min="1" max="5" step="1" x-model="fit"
                                            class="w-full h-1 bg-neutral-200 rounded-lg appearance-none cursor-pointer accent-black focus:outline-none">
                                        <div
                                            class="flex justify-between text-[9px] text-neutral-400 uppercase mt-3 font-bold tracking-wider">
                                            <span :class="fit == 1 ? 'text-black' : ''">Tight</span>
                                            <span :class="fit == 3 ? 'text-black' : ''">True to Size</span>
                                            <span :class="fit == 5 ? 'text-black' : ''">Loose</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. REVIEW CONTENT (Floating Label - Minimalist Style) --}}
                                <div class="relative z-0 w-full mb-8 group">
                                    <textarea name="content" id="content" rows="4" placeholder=" "
                                        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer resize-none transition-colors duration-300"
                                        :class="errors.content 
                        ? 'border-red-500 text-red-900 focus:border-red-500 placeholder-red-300' 
                        : 'border-neutral-300 text-neutral-900 focus:border-black'"></textarea>

                                    {{-- Label bay lên --}}
                                    <label for="content"
                                        class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest"
                                        :class="errors.content ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black'">
                                        Your Review
                                    </label>

                                    {{-- Lỗi hiển thị bên dưới --}}
                                    <p x-show="errors.content" x-text="errors.content[0]"
                                        class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                    </p>
                                </div>

                                {{-- 4. IMAGE UPLOAD (Custom Minimalist Button) --}}
                                <div class="mb-8">
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest mb-3 text-neutral-500">
                                        Add Photo (Optional)
                                    </label>

                                    <div class="flex items-center gap-4">
                                        {{-- Nút upload giả --}}
                                        <label
                                            class="cursor-pointer group flex items-center gap-2 px-4 py-3 border border-neutral-300 hover:border-black transition duration-300">
                                            <svg class="w-4 h-4 text-neutral-500 group-hover:text-black" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wider text-neutral-600 group-hover:text-black">Choose
                                                File</span>
                                            <input type="file" name="image" accept="image/*" class="hidden"
                                                @change="handleImage">
                                        </label>

                                        {{-- Preview Ảnh --}}
                                        <template x-if="imagePreview">
                                            <div class="relative w-12 h-12 border border-neutral-200 overflow-hidden">
                                                <img :src="imagePreview" class="w-full h-full object-cover">
                                                <button type="button"
                                                    @click="imagePreview = null; $el.closest('form').querySelector('input[type=file]').value = ''"
                                                    class="absolute top-0 right-0 bg-black text-white w-4 h-4 flex items-center justify-center text-[10px] hover:bg-red-600 transition">&times;</button>
                                            </div>
                                        </template>
                                    </div>
                                    <p x-show="errors.image" x-text="errors.image[0]"
                                        class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide"></p>
                                </div>

                                <button type="submit" :disabled="submitting"
                                    class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-text="submitting ? 'Submitting...' : 'Post Review'"></span>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="bg-neutral-50 p-8 text-center border border-neutral-100">
                            <p class="text-xs text-neutral-500 mb-4 font-light">Please login to share your thoughts.</p>
                            <a href="{{ route('login') }}"
                                class="inline-block border-b border-black text-xs font-bold uppercase tracking-widest pb-0.5 hover:text-neutral-600 hover:border-neutral-600 transition">
                                Login / Register
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>

                {{-- RIGHT COLUMN: Reviews List --}}
                <div class="lg:col-span-8 space-y-10">
                    @forelse($reviews as $review)
                    <div class="border-b border-neutral-200 pb-8 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-xs font-bold text-neutral-900 uppercase tracking-widest border border-neutral-200">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-neutral-900">{{ $review->user->name }}</h4>
                                    <span class="text-[10px] text-neutral-400 uppercase tracking-wider font-medium">{{
                                        $review->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i=1; $i<=5; $i++) <svg
                                    class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-black' : 'text-neutral-200 fill-none' }}"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    @endfor
                            </div>
                        </div>
                        <div class="pl-14">
                            @php
                            $fitLabel = match($review->fit_rating) {
                            1 => 'Runs Small', 2 => 'Slightly Small', 3 => 'True to Size', 4 => 'Slightly Large', 5 =>
                            'Runs Large', default => 'True to Size'
                            };
                            @endphp
                            <div class="mb-3">
                                <span
                                    class="inline-block text-[9px] font-bold uppercase tracking-widest border border-neutral-200 px-2 py-1 bg-white text-neutral-600">
                                    Fit: {{ $fitLabel }}
                                </span>
                            </div>
                            <p class="text-sm text-neutral-700 leading-relaxed font-light mb-4">
                                {!! nl2br(e($review->content)) !!}
                            </p>
                            @if($review->image)
                            <div class="mt-4">
                                <img src="{{ Storage::url($review->image) }}"
                                    class="w-24 h-24 object-cover cursor-zoom-in grayscale hover:grayscale-0 transition duration-500 border border-neutral-100"
                                    onclick="window.open(this.src)">
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center border border-dashed border-neutral-200 rounded-lg">
                        <p class="text-neutral-400 font-light text-sm italic">No reviews yet.</p>
                    </div>
                    @endforelse
                    <div class="mt-8">
                        {{ $reviews->fragment('reviews')->links() }}
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. CURATED FOR YOU (Apparel + Random) --}}
        @if(isset($curated) && $curated->count() > 0)
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
                    @foreach($curated->take(5) as $index => $curatedItem)
                    @php
                    // 1. Default to Placeholder first
                    $imgSrc = 'https://placehold.co/600x800?text=No+Image';

                    // 2. Only attempt to build path if image is NOT empty
                    if (!empty($curatedItem->image)) {
                    // Check if it's already an absolute URL
                    if (Str::startsWith($curatedItem->image, ['http://', 'https://'])) {
                    $imgSrc = $curatedItem->image;
                    } else {
                    // Build the path: storage/products/{slug}/{filename}
                    $imgSrc = asset('storage/products/' . $curatedItem->slug . '/' . basename($curatedItem->image));
                    }
                    }

                    // LOGIC: Item đầu tiên (index 0) chiếm 2 cột 2 dòng
                    $classes = ($index === 0)
                    ? 'col-span-2 row-span-2 md:h-full relative group'
                    : 'col-span-1 row-span-1 relative group';
                    @endphp

                    <div class="{{ $classes }} overflow-hidden bg-neutral-100">
                        {{-- Ảnh --}}
                        <img src="{{ $imgSrc }}"
                            class="w-full h-full object-cover transition duration-[1.5s] ease-out group-hover:scale-105"
                            loading="lazy">

                        {{-- Badges --}}
                        @if($index === 0)
                        <div
                            class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold uppercase px-3 py-1.5 z-10">
                            New Drop
                        </div>
                        @elseif($curatedItem->is_new)
                        <div class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full z-10"></div>
                        @endif

                        {{-- Info Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            <div
                                class="translate-y-4 group-hover:translate-y-0 transition-transform duration-300 text-white">
                                <h3 class="text-sm md:text-lg font-bold uppercase tracking-widest">
                                    {{ $curatedItem->name }}
                                </h3>
                                <p class="text-xs md:text-sm font-light mt-1 opacity-90">
                                    ₫{{ number_format($curatedItem->price, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('products.show', $curatedItem->id) }}"
                                    class="inline-block mt-3 text-[10px] font-bold uppercase border-b border-white pb-0.5">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                        {{-- Link bao trùm --}}
                        <a href="{{ route('products.show', $curatedItem->id) }}" class="absolute inset-0 z-20"></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </main>
    @include('partials.wishlist-script')
</x-app-layout>