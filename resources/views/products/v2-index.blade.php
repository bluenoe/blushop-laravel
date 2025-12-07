{{--
═══════════════════════════════════════════════════════════════
BluShop Product Listing v3 - Editorial Grid
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

        {{-- 1. HEADER & TOOLBAR --}}
        <div
            class="sticky top-[64px] sm:top-[80px] z-30 bg-white/95 backdrop-blur-sm border-b border-neutral-100 transition-all duration-300">
            <div class="max-w-[1600px] mx-auto px-6 py-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                    {{-- Left: Title & Breadcrumb --}}
                    <div>
                        <div
                            class="flex items-center gap-2 text-[10px] uppercase tracking-widest text-neutral-500 mb-1">
                            <a href="{{ route('home') }}" class="hover:text-black">Home</a>
                            <span>/</span>
                            <span class="text-black">Shop</span>
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight uppercase">
                            @if(request('category'))
                            {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Category' }}
                            @else
                            All Products
                            @endif
                            <sup class="text-xs font-normal text-neutral-400 ml-1">{{ $products->total() }}</sup>
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

        {{-- 2. PRODUCT GRID --}}
        <section class="max-w-[1600px] mx-auto px-6 pb-24 pt-8">
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
                <div class="group relative flex flex-col">
                    {{-- Image Wrapper --}}
                    <div class="relative aspect-[3/4] overflow-hidden bg-neutral-100 mb-4 cursor-pointer">
                        <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-105 filter grayscale-[10%] group-hover:grayscale-0">
                        </a>

                        {{-- Badges --}}
                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                            @if($product->is_new)
                            <span
                                class="bg-white/90 backdrop-blur text-black text-[10px] font-bold uppercase px-2 py-1">New</span>
                            @endif
                            @if($product->is_on_sale)
                            <span class="bg-black text-white text-[10px] font-bold uppercase px-2 py-1">Sale</span>
                            @endif
                        </div>

                        {{-- Quick Add Overlay (Desktop) --}}
                        <div
                            class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition duration-300 ease-out hidden lg:block">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="w-full py-3 bg-white/90 backdrop-blur text-black text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                                    Quick Add +
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Product Info --}}
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <h3 class="text-sm font-bold text-neutral-900 leading-tight">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            @if($product->category)
                            <p class="text-[10px] text-neutral-400 uppercase tracking-wider mt-1">{{
                                $product->category->name }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-medium text-neutral-900">₫{{ number_format($product->price)
                                }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="mt-20 flex justify-center border-t border-neutral-100 pt-12">
                {{ $products->withQueryString()->links('pagination::simple-tailwind') }}
            </div>
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

                    {{-- Categories Group --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest mb-4">Categories</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="" class="hidden"
                                    onchange="this.form.submit()" {{ !request('category') ? 'checked' : '' }}>
                                <span
                                    class="w-4 h-4 border border-neutral-300 rounded-full flex items-center justify-center group-hover:border-black transition">
                                    <span
                                        class="w-2 h-2 rounded-full bg-black opacity-0 {{ !request('category') ? 'opacity-100' : '' }}"></span>
                                </span>
                                <span
                                    class="text-sm text-neutral-600 group-hover:text-black {{ !request('category') ? 'font-bold text-black' : '' }}">All
                                    Products</span>
                            </label>

                            @foreach($categories as $cat)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="{{ $cat->slug }}" class="hidden"
                                    onchange="this.form.submit()" {{ request('category')==$cat->slug ? 'checked' : ''
                                }}>
                                <span
                                    class="w-4 h-4 border border-neutral-300 rounded-full flex items-center justify-center group-hover:border-black transition">
                                    <span
                                        class="w-2 h-2 rounded-full bg-black opacity-0 {{ request('category') == $cat->slug ? 'opacity-100' : '' }}"></span>
                                </span>
                                <span
                                    class="text-sm text-neutral-600 group-hover:text-black {{ request('category') == $cat->slug ? 'font-bold text-black' : '' }}">{{
                                    $cat->name }}</span>
                            </label>
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