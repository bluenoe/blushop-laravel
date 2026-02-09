{{--
═══════════════════════════════════════════════════════════════
BluShop Product Listing v3.1 - Fixed Spacing
Concept: Clean Grid, Off-canvas Filters, Minimalist Typography
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    {{-- Main Container with Alpine data for Filters --}}
    <div x-data="{ 
            filterOpen: false, 
            sortOpen: false,
            activeSort: '{{ request('sort', 'newest') }}'
         }" class="bg-white min-h-screen text-neutral-900">

        {{-- 1. HEADER & TOOLBAR (STICKY) --}}
        <div
            class="sticky top-[64px] sm:top-[80px] z-30 bg-white/95 backdrop-blur-md border-b border-neutral-100 transition-all duration-300">
            <div class="max-w-[1600px] mx-auto px-6 py-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                    {{-- Left: Title & Breadcrumb --}}
                    <div>
                        <div
                            class="flex items-center gap-2 text-[10px] uppercase tracking-widest text-neutral-500 mb-1 pt-3">
                            <a href="{{ route('home') }}" class="hover:text-black">Home</a>
                            <span>/</span>
                            <span class="text-black">Shop</span>
                        </div>
                        <h1
                            class="text-2xl font-bold tracking-tight uppercase {{ (isset($isSectional) && $isSectional) ? 'sr-only' : '' }}">
                            @if(request('category'))
                            {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Category' }}
                            @else
                            {{ $pageTitle ?? 'Shop' }}
                            @endif
                            @if(!isset($isSectional) || !$isSectional)
                            <sup class="text-xs font-normal text-neutral-400 ml-1">{{ $products->total() }}</sup>
                            @endif
                        </h1>
                    </div>

                    {{-- Right: Filter & Sort Actions --}}
                    <div
                        class="flex items-center gap-4 md:gap-8 border-t md:border-t-0 border-neutral-100 pt-3 md:pt-0 w-full md:w-auto justify-between md:justify-end">

                        {{-- Filter Trigger --}}
                        <button @click="filterOpen = true"
                            class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest hover:text-neutral-500 transition group">
                            <span class="w-2 h-2 rounded-full bg-black group-hover:bg-neutral-400 transition"></span>
                            Filter
                            @if(request()->anyFilled(['price_min', 'price_max', 'in_stock', 'on_sale']))
                            <span class="ml-1 text-neutral-400">(Active)</span>
                            @endif
                        </button>

                        {{-- Sort Dropdown --}}
                        <div class="relative">
                            <button @click="sortOpen = !sortOpen" @click.outside="sortOpen = false"
                                class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest hover:text-neutral-500 transition">
                                Sort By
                                <svg class="w-3 h-3 transition-transform duration-200"
                                    :class="sortOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="sortOpen" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white border border-neutral-100 shadow-xl z-50 py-2">
                                <form id="sortForm" action="{{ route('products.index') }}" method="GET">
                                    {{-- Keep existing filters when sorting --}}
                                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach

                                    @foreach([
                                    'newest' => 'Newest Arrivals',
                                    'price_asc' => 'Price: Low to High',
                                    'price_desc' => 'Price: High to Low',
                                    'featured' => 'Featured'
                                    ] as $key => $label)
                                    <button type="submit" name="sort" value="{{ $key }}"
                                        class="block w-full text-left px-4 py-2 text-xs uppercase tracking-widest hover:bg-neutral-50 transition"
                                        :class="activeSort === '{{ $key }}' ? 'font-bold text-black' : 'text-neutral-500'">
                                        {{ $label }}
                                    </button>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. CONTENT AREA --}}
        <section class="max-w-[1600px] mx-auto px-6 pb-24 pt-20 sm:pt-28">

            @if(isset($isSectional) && $isSectional)
            {{-- ================= EDITORIAL VIEW ================= --}}

            {{-- 1. THE SCENT (Fragrance) --}}
            <div class="mb-40">
                {{-- Editorial Header --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16 items-end border-b border-black/10 pb-8">
                    <div>
                        <span
                            class="block text-[10px] items-center gap-2 uppercase tracking-[0.2em] text-neutral-500 mb-4">
                            Section 01 / Olfactory
                        </span>
                        <h2 class="font-serif text-5xl md:text-7xl text-neutral-900 leading-[0.9]">
                            The Scent
                        </h2>
                    </div>
                    <div class="flex flex-col md:items-end justify-between h-full">
                        <p class="font-serif italic text-xl text-neutral-500 max-w-sm text-right">
                            "Curated notes for the modern soul. An atmosphere, not just a fragrance."
                        </p>
                        <a href="{{ route('products.index', ['category' => 'fragrance']) }}"
                            class="mt-8 text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-500 hover:border-neutral-500 transition">
                            Explore Collection
                        </a>
                    </div>
                </div>

                {{-- Minimal Row --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 md:gap-x-8 gap-y-12">
                    @foreach($fragranceProducts->take(4) as $product)
                    @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>

            {{-- 2. THE SILHOUETTE (Women) --}}
            <div class="relative -mx-6 px-6 py-32 bg-neutral-50 mb-40">
                <div class="max-w-[1600px] mx-auto">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-16">
                        <div>
                            <span
                                class="block text-[10px] items-center gap-2 uppercase tracking-[0.2em] text-neutral-500 mb-4">
                                Section 02 / Apparel
                            </span>
                            <h2 class="font-serif text-5xl md:text-7xl text-neutral-900 leading-[0.9]">
                                The Silhouette
                            </h2>
                        </div>
                        <a href="{{ route('products.index', ['category' => 'women']) }}"
                            class="hidden md:block text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-500 hover:border-neutral-500 transition">
                            View Women's
                        </a>
                    </div>

                    {{-- Asymmetrical Masonry Layout --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {{-- Feature Item (Left) --}}
                        @if($womenProducts->isNotEmpty())
                        <div class="md:col-span-1 md:row-span-2">
                            @include('partials.product-card', ['product' => $womenProducts->first()])
                        </div>
                        @endif

                        {{-- Grid Items (Right - 2x2) --}}
                        <div class="md:col-span-2 grid grid-cols-2 gap-8">
                            @foreach($womenProducts->skip(1)->take(4) as $product)
                            @include('partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-12 md:hidden text-center">
                        <a href="{{ route('products.index', ['category' => 'women']) }}"
                            class="inline-block border-b border-black pb-1 text-xs font-bold uppercase tracking-widest">View
                            All</a>
                    </div>
                </div>
            </div>

            {{-- 3. THE STRUCTURE (Men) --}}
            <div class="mb-24">
                <div class="text-center mb-20">
                    <span class="block text-[10px] uppercase tracking-[0.2em] text-neutral-500 mb-4">
                        Section 03 / Tailoring
                    </span>
                    <h2 class="font-serif text-5xl md:text-7xl text-neutral-900 mb-6">
                        The Structure
                    </h2>
                    <a href="{{ route('products.index', ['category' => 'men']) }}"
                        class="inline-block text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-500 hover:border-neutral-500 transition">
                        View Men's
                    </a>
                </div>

                {{-- Bold 3-Column Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-16">
                    @foreach($menProducts->take(6) as $product)
                    @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>

            @else
            {{-- ================= STANDARD GRID VIEW ================= --}}
            @if(($products ?? collect())->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <p class="text-neutral-400 mb-4 text-lg font-light">No products found matching your criteria.</p>
                <a href="{{ route('products.index') }}"
                    class="px-8 py-3 border border-black text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                    Clear All Filters
                </a>
            </div>
            @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12">
                @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="mt-20 flex justify-center border-t border-neutral-100 pt-12">
                {{ $products->withQueryString()->links('pagination::simple-tailwind') }}
            </div>
            @endif
            @endif

            @endif
        </section>

        {{-- 3. FILTER DRAWER (SLIDE-OVER) --}}
        <div x-cloak x-show="filterOpen" class="fixed inset-0 z-[60] flex justify-end" role="dialog" aria-modal="true">

            {{-- Backdrop --}}
            <div x-show="filterOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                @click="filterOpen = false"></div>

            {{-- Panel --}}
            <div x-show="filterOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="relative w-full max-w-md bg-white h-full shadow-2xl overflow-y-auto flex flex-col">

                {{-- Drawer Header --}}
                <div
                    class="flex items-center justify-between p-6 border-b border-neutral-100 sticky top-0 bg-white z-10">
                    <h2 class="text-lg font-bold uppercase tracking-widest">Filters</h2>
                    <button @click="filterOpen = false" class="text-neutral-500 hover:text-black transition">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Drawer Content --}}
                <form action="{{ route('products.index') }}" method="GET" class="p-6 flex-1 space-y-8">
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    {{-- Categories Group (Accordion Style) --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest mb-4">Categories</h3>
                        <div class="space-y-1">

                            {{-- 1. Link "All Products" --}}
                            <a href="{{ route('products.index') }}"
                                class="block py-1 text-sm {{ !request('category') ? 'font-bold text-black' : 'text-neutral-500 hover:text-black' }}">
                                All Products
                            </a>

                            {{-- 2. Vòng lặp Danh mục Cha --}}
                            @foreach($categories as $parent)
                            {{-- Kiểm tra xem danh mục này có đang được active không (để tự động mở) --}}
                            @php
                            // Kiểm tra xem user đang chọn danh mục cha này HOẶC con của nó
                            $isActive = (request('category') == $parent->slug) || $parent->children->contains('slug',
                            request('category'));
                            $hasChildren = $parent->children->count() > 0;
                            @endphp

                            @if($hasChildren)
                            {{-- HAS CHILDREN: Use accordion pattern --}}
                            <div x-data="{ expanded: {{ $isActive ? 'true' : 'false' }} }">
                                {{-- Dòng tiêu đề Cha (Bấm để đóng/mở) --}}
                                <button @click="expanded = !expanded" type="button"
                                    class="flex items-center justify-between w-full py-1 text-sm group text-left">
                                    <span
                                        class="{{ $isActive ? 'font-bold text-black' : 'text-neutral-600 group-hover:text-black' }}">
                                        {{ $parent->name }}
                                    </span>
                                    {{-- Mũi tên chỉ xuống/lên --}}
                                    <svg class="w-3 h-3 transition-transform duration-200 text-neutral-400"
                                        :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- List con (Xổ xuống) --}}
                                <div x-show="expanded" x-collapse
                                    class="pl-3 mt-1 space-y-1 border-l border-neutral-200 ml-1">

                                    {{-- Link chọn chính danh mục Cha --}}
                                    <a href="{{ route('products.index', ['category' => $parent->slug]) }}"
                                        class="block py-1 text-sm {{ request('category') == $parent->slug ? 'font-bold text-black' : 'text-neutral-500 hover:text-black' }}">
                                        Shop All {{ $parent->name }}
                                    </a>

                                    {{-- Loop danh mục Con --}}
                                    @foreach($parent->children as $child)
                                    <a href="{{ route('products.index', ['category' => $child->slug]) }}"
                                        class="block py-1 text-sm {{ request('category') == $child->slug ? 'font-bold text-black' : 'text-neutral-500 hover:text-black' }}">
                                        {{ $child->name }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            {{-- NO CHILDREN: Render as direct link --}}
                            <a href="{{ route('products.index', ['category' => $parent->slug]) }}"
                                class="block py-1 text-sm {{ $isActive ? 'font-bold text-black' : 'text-neutral-600 hover:text-black' }}">
                                {{ $parent->name }}
                            </a>
                            @endif
                            @endforeach

                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="border-t border-neutral-100 pt-8">
                        <h3 class="text-xs font-bold uppercase tracking-widest mb-4">Price Range</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] uppercase text-neutral-400">Min</label>
                                <div class="relative mt-1">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-neutral-500">₫</span>
                                    <input type="number" name="price_min" value="{{ request('price_min') }}"
                                        class="w-full pl-7 pr-3 py-2 border border-neutral-200 focus:border-black focus:ring-0 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase text-neutral-400">Max</label>
                                <div class="relative mt-1">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-neutral-500">₫</span>
                                    <input type="number" name="price_max" value="{{ request('price_max') }}"
                                        class="w-full pl-7 pr-3 py-2 border border-neutral-200 focus:border-black focus:ring-0 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Attributes --}}
                    <div class="border-t border-neutral-100 pt-8">
                        <h3 class="text-xs font-bold uppercase tracking-widest mb-4">Availability & Status</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : ''
                                    }} class="w-4 h-4 border-neutral-300 text-black focus:ring-black">
                                <span class="text-sm text-neutral-600">In Stock Only</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : ''
                                    }} class="w-4 h-4 border-neutral-300 text-black focus:ring-black">
                                <span class="text-sm text-neutral-600">On Sale</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : ''
                                    }} class="w-4 h-4 border-neutral-300 text-black focus:ring-black">
                                <span class="text-sm text-neutral-600">Featured Items</span>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-8 space-y-3">
                        <button type="submit"
                            class="w-full py-4 bg-black text-white font-bold uppercase text-xs tracking-widest hover:opacity-90 transition">
                            Apply Filters
                        </button>
                        <a href="{{ route('products.index') }}"
                            class="block w-full text-center py-4 border border-neutral-200 text-neutral-500 font-bold uppercase text-xs tracking-widest hover:border-black hover:text-black transition">
                            Clear All
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @include('partials.wishlist-script')
</x-app-layout>