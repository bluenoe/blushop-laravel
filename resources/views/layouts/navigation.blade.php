@php
// Tối ưu query: Lấy category trừ uncategorized
$categories = \App\Models\Category::query()
->where('slug', '!=', 'uncategorized')
->orderBy('name')
->get();
@endphp

<nav x-data="{ 
        mobileMenuOpen: false, 
        searchOpen: false, 
        shopHover: false,
        scrolled: false,
        searchQuery: '',
        searchResults: [],
        searchLoading: false,
        searchTimeout: null,
        highlightedIndex: -1,
        
        init() {
            this.$watch('mobileMenuOpen', value => {
                document.body.classList.toggle('overflow-hidden', value);
            })
        },

        updateSearch(query) {
            this.searchQuery = query;
            this.highlightedIndex = -1;
            if (this.searchTimeout) clearTimeout(this.searchTimeout);

            if (!query || query.length < 2) {
                this.searchResults = [];
                this.searchLoading = false;
                return;
            }

            this.searchLoading = true;
            this.searchTimeout = setTimeout(() => {
                fetch('{{ route('products.autocomplete') }}?q=' + encodeURIComponent(this.searchQuery))
                    .then(res => res.ok ? res.json() : Promise.reject())
                    .then(data => { this.searchResults = Array.isArray(data.data) ? data.data : []; })
                    .catch(() => { this.searchResults = []; })
                    .finally(() => { this.searchLoading = false; });
            }, 250); // Debounce 250ms
        },
        selectResult(index) {
            const item = this.searchResults[index];
            if (item?.url) window.location.href = item.url;
        },
        handleKeydown(event) {
            if (!this.searchResults.length) return;
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                this.highlightedIndex = (this.highlightedIndex + 1) % this.searchResults.length;
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                this.highlightedIndex = this.highlightedIndex <= 0 ? this.searchResults.length - 1 : this.highlightedIndex - 1;
            } else if (event.key === 'Enter' && this.highlightedIndex >= 0) {
                event.preventDefault();
                this.selectResult(this.highlightedIndex);
            }
        }
    }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    @keydown.window.escape="searchOpen = false; mobileMenuOpen = false; shopHover = false"
    :class="{ 'bg-white/95 backdrop-blur-md shadow-sm': scrolled, 'bg-white': !scrolled }"
    class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-gray-100">

    {{-- PRIMARY HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">

            {{-- 1. MOBILE MENU BUTTON --}}
            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 -ml-2 text-gray-900 hover:opacity-70 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- 2. DESKTOP NAV LINKS --}}
            <div class="hidden sm:flex items-center gap-8 md:gap-12">
                {{-- Mega Menu Trigger --}}
                <div class="relative h-full flex items-center" @mouseenter="shopHover = true"
                    @mouseleave="shopHover = false">
                    <a href="{{ route('products.index') }}"
                        class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:text-gray-500 transition py-8 border-b-2 border-transparent hover:border-black">
                        Shop
                    </a>
                </div>

                <a href="{{ route('new-arrivals') }}"
                    class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:text-gray-500 transition">New
                    In</a>
                <a href="{{ route('about') }}"
                    class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:text-gray-500 transition">About</a>
            </div>

            {{-- 3. LOGO --}}
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                <a href="{{ route('home') }}" class="block group">
                    <span
                        class="font-bold text-2xl sm:text-3xl tracking-tighter group-hover:opacity-80 transition">BLUSHOP.</span>
                </a>
            </div>

            {{-- 4. ICONS (Search, Account, Cart) --}}
            <div class="flex items-center gap-4 sm:gap-6">
                {{-- Search --}}
                <button
                    @click="searchOpen = !searchOpen; searchResults = []; searchQuery = ''; $nextTick(() => $refs.searchInput.focus())"
                    class="text-gray-900 hover:opacity-60 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                {{-- Account --}}
                <div class="hidden sm:block relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="text-gray-900 hover:opacity-60 transition flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition.opacity.duration.200ms
                        class="absolute right-0 mt-4 w-48 bg-white border border-gray-100 shadow-xl py-2 z-50">
                        @auth
                        <div class="px-4 py-2 border-b border-gray-50 mb-1">
                            <p class="text-xs text-gray-500">Hello,</p>
                            <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-xs uppercase tracking-wider hover:bg-gray-50">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-xs uppercase tracking-wider hover:bg-gray-50 text-red-600">Log
                                Out</button>
                        </form>
                        @else
                        <a href="{{ route('login') }}"
                            class="block px-4 py-2 text-xs uppercase tracking-wider hover:bg-gray-50">Login</a>
                        <a href="{{ route('register') }}"
                            class="block px-4 py-2 text-xs uppercase tracking-wider hover:bg-gray-50">Register</a>
                        @endauth
                    </div>
                </div>

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative text-gray-900 hover:opacity-60 transition"
                    x-data="{ count: {{ (int) collect(session('cart', []))->sum('quantity') }} }"
                    @cart-updated.window="count = $event.detail.count">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span x-show="count > 0" x-text="count" x-transition.scale
                        class="absolute -top-1 -right-1 w-4 h-4 bg-black text-white text-[9px] flex items-center justify-center rounded-full font-bold"></span>
                </a>
            </div>
        </div>
    </div>

    {{-- MEGA MENU (DESKTOP) --}}
    <div x-show="shopHover" @mouseenter="shopHover = true" @mouseleave="shopHover = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-xl z-40 hidden sm:block">

        <div class="max-w-7xl mx-auto px-8 py-0">
            <div class="grid grid-cols-4 min-h-[400px]">

                {{-- Column 1: MAIN NAVIGATION (Refactored) --}}
                <div class="py-10 pr-8 border-r border-gray-50">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-8">Collections</h3>
                    <ul class="space-y-6">
                        {{-- WOMEN --}}
                        <li class="group">
                            <a href="{{ route('products.index', ['category' => 'women']) }}" class="block">
                                <span
                                    class="text-2xl font-light group-hover:font-medium transition-all duration-300">Women</span>
                                <span
                                    class="block text-xs text-gray-400 mt-1 group-hover:text-black transition-colors">Elegance
                                    & Modern</span>
                            </a>
                        </li>
                        {{-- MEN --}}
                        <li class="group">
                            <a href="{{ route('products.index', ['category' => 'men']) }}" class="block">
                                <span
                                    class="text-2xl font-light group-hover:font-medium transition-all duration-300">Men</span>
                                <span
                                    class="block text-xs text-gray-400 mt-1 group-hover:text-black transition-colors">Minimalist
                                    Essentials</span>
                            </a>
                        </li>
                        {{-- FRAGRANCE --}}
                        <li class="group">
                            <a href="{{ route('products.index', ['category' => 'fragrance']) }}" class="block">
                                <span
                                    class="text-2xl font-light group-hover:font-medium transition-all duration-300">Fragrance</span>
                                <span
                                    class="block text-xs text-gray-400 mt-1 group-hover:text-black transition-colors">Signature
                                    Scents</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 2: CURATED EDITS --}}
                <div class="py-10 px-8">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-8">Curated Edits</h3>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-sm text-gray-900 hover:translate-x-1 transition-transform inline-block">Campus
                                Essentials</a></li>
                        <li><a href="#"
                                class="text-sm text-gray-900 hover:translate-x-1 transition-transform inline-block">Desk
                                Setup</a></li>
                        <li><a href="#"
                                class="text-sm text-gray-900 hover:translate-x-1 transition-transform inline-block">Minimalist
                                Tech</a></li>
                        <li class="pt-4 border-t border-gray-100 mt-4">
                            <a href="#" class="text-sm text-red-600 font-medium hover:underline">Sale - Last Chance</a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3 & 4: PREMIUM SLIDER (Optimized) --}}
                <div class="col-span-2 relative overflow-hidden bg-gray-100 group" x-data="{ 
                        activeSlide: 0,
                        slides: [
                            { img: 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=800&q=80', title: 'The Monochrome', subtitle: 'Effortless Elegance' },
                            { img: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80', title: 'New Arrivals', subtitle: 'Spring / Summer 2025' },
                            { img: 'https://images.unsplash.com/photo-1529139574466-a302d2052574?auto=format&fit=crop&w=800&q=80', title: 'Signature Scents', subtitle: 'Discover Yours' }
                        ],
                        timer: null,
                        init() { this.startAutoSlide(); },
                        startAutoSlide() { this.timer = setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides.length; }, 3000); }, // Tăng tốc lên 3s
                        stopAutoSlide() { clearInterval(this.timer); }
                     }" @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()">

                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-700"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-100" class="absolute inset-0 w-full h-full">
                            <img :src="slide.img" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                            </div>
                            <div class="absolute bottom-10 left-10 text-white">
                                <p x-text="slide.subtitle" class="text-xs uppercase tracking-[0.2em] mb-2 opacity-90">
                                </p>
                                <h3 x-text="slide.title" class="text-3xl font-serif italic tracking-wide"></h3>
                                <button
                                    class="mt-4 px-6 py-2 border border-white text-xs uppercase tracking-widest hover:bg-white hover:text-black transition duration-300">Shop
                                    Now</button>
                            </div>
                        </div>
                    </template>

                    {{-- Dots --}}
                    <div class="absolute bottom-6 right-6 flex gap-2 z-20">
                        <template x-for="(slide, index) in slides">
                            <button @click="activeSlide = index" class="h-1 transition-all duration-300 rounded-full"
                                :class="activeSlide === index ? 'w-8 bg-white' : 'w-2 bg-white/40 hover:bg-white/80'"></button>
                        </template>
                    </div>
                    <a href="#" class="absolute inset-0 z-10"></a>
                </div>
            </div>
        </div>
    </div>

    {{-- SEARCH OVERLAY --}}
    <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        class="absolute top-0 left-0 w-full bg-white z-50 border-b border-gray-100 py-6 px-4">
        <div class="max-w-4xl mx-auto relative">
            <form action="{{ route('products.index') }}" method="GET" @submit="searchResults = []">
                <input x-ref="searchInput" type="text" name="q" placeholder="Type to search..." x-model="searchQuery"
                    @input="updateSearch($event.target.value)" @keydown="handleKeydown($event)" autocomplete="off"
                    class="w-full text-2xl font-light border-none border-b border-gray-200 focus:ring-0 focus:border-black p-4 placeholder-gray-300">
            </form>

            <div x-show="searchQuery.length >= 2" x-transition
                class="absolute left-0 right-0 mt-1 bg-white border border-gray-100 shadow-xl rounded-b-xl max-h-80 overflow-y-auto">
                <template x-if="searchLoading">
                    <div class="px-4 py-3 text-sm text-gray-400">Searching...</div>
                </template>
                <template x-if="!searchLoading && !searchResults.length && searchQuery.length >= 2">
                    <div class="px-4 py-3 text-sm text-gray-400">No products found.</div>
                </template>
                <ul>
                    <template x-for="(item, index) in searchResults" :key="item.id">
                        <li>
                            <button type="button"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-left hover:bg-gray-50"
                                :class="index === highlightedIndex ? 'bg-gray-50' : ''" @click="selectResult(index)">
                                <div class="w-10 h-10 bg-gray-100 flex-shrink-0 overflow-hidden rounded">
                                    <template x-if="item.image"><img :src="item.image"
                                            class="w-full h-full object-cover"></template>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-900" x-text="item.name"></p>
                                    <p class="text-xs text-gray-500"
                                        x-text="item.price ? new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.price) : ''">
                                    </p>
                                </div>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
            <button @click="searchOpen = false"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black text-xs uppercase tracking-widest">Close</button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <template x-teleport="body">
        <div x-show="mobileMenuOpen" style="display: none;" class="fixed inset-0 z-[999] flex justify-start">
            {{-- Backdrop --}}
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
                @click="mobileMenuOpen = false"></div>

            {{-- Slider Drawer --}}
            <div x-show="mobileMenuOpen" x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed inset-y-0 left-0 z-50 h-screen w-3/4 max-w-xs bg-white shadow-2xl flex flex-col overflow-y-auto">

                <div class="p-6 flex justify-between items-center border-b border-gray-100 shrink-0">
                    <span class="font-bold text-xl tracking-tighter">MENU</span>
                    <button @click="mobileMenuOpen = false" class="p-2 -mr-2 text-gray-500 hover:text-black transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto py-8 px-6">
                    {{-- Main Navigation Links (Synced with Desktop) --}}
                    <nav class="space-y-2">
                        {{-- SHOP with Expandable Collections --}}
                        <div x-data="{ expanded: true }">
                            <button @click="expanded = !expanded"
                                class="flex items-center justify-between w-full py-4 text-xl font-medium text-black tracking-tight border-b border-neutral-100 hover:bg-neutral-50 transition-colors">
                                <span>Shop</span>
                                <svg class="w-5 h-5 text-neutral-400 transition-transform duration-300"
                                    :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Collections (Matching Desktop Mega Menu) --}}
                            <ul x-show="expanded" x-collapse
                                class="mt-2 ml-4 space-y-1 border-l-2 border-neutral-100 pl-4">
                                <li>
                                    <a href="{{ route('products.index') }}"
                                        class="block py-3 text-base text-neutral-600 hover:text-black hover:translate-x-1 transition-all duration-200">
                                        All Products
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products.index', ['category' => 'women']) }}"
                                        class="block py-3 text-base text-neutral-600 hover:text-black hover:translate-x-1 transition-all duration-200">
                                        Women
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products.index', ['category' => 'men']) }}"
                                        class="block py-3 text-base text-neutral-600 hover:text-black hover:translate-x-1 transition-all duration-200">
                                        Men
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products.index', ['category' => 'fragrance']) }}"
                                        class="block py-3 text-base text-neutral-600 hover:text-black hover:translate-x-1 transition-all duration-200">
                                        Fragrance
                                    </a>
                                </li>
                            </ul>
                        </div>

                        {{-- NEW IN (Matching Desktop) --}}
                        <a href="{{ route('new-arrivals') }}"
                            class="flex items-center justify-between py-4 text-xl font-medium text-black tracking-tight border-b border-neutral-100 hover:bg-neutral-50 transition-colors">
                            <span>New In</span>
                            <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            </svg>
                        </a>

                        {{-- ABOUT (Matching Desktop) --}}
                        <a href="{{ route('about') }}"
                            class="flex items-center justify-between py-4 text-xl font-medium text-black tracking-tight border-b border-neutral-100 hover:bg-neutral-50 transition-colors">
                            <span>About</span>
                            <svg class="w-5 h-5 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            </svg>
                        </a>
                    </nav>

                    {{-- Secondary Links --}}
                    <div class="mt-8 pt-6 border-t border-neutral-100">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 font-bold mb-4">More</p>
                        <nav class="space-y-1">
                            <a href="{{ route('lookbook') }}"
                                class="block py-3 text-sm text-neutral-500 hover:text-black transition-colors">
                                Lookbook
                            </a>
                            <a href="{{ route('contact.index') }}"
                                class="block py-3 text-sm text-neutral-500 hover:text-black transition-colors">
                                Contact
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 bg-gray-50 mt-auto shrink-0">
                    @auth
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">
                            {{ Str::substr(Auth::user()->name, 0, 1) }}</div>
                        <div>
                            <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-xs text-gray-500 underline">Edit
                                Profile</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="w-full py-3 bg-white border border-gray-300 text-black font-bold uppercase text-xs tracking-widest hover:bg-black hover:text-white transition">Log
                            Out</button>
                    </form>
                    @else
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center py-3 bg-black text-white font-bold uppercase text-xs tracking-widest">Login</a>
                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center py-3 bg-white border border-gray-300 text-black font-bold uppercase text-xs tracking-widest">Register</a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </template>
</nav>