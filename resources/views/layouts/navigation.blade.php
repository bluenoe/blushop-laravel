@php
// Tui lấy dữ liệu danh mục ở đây để tránh lỗi cú pháp trong @foreach
// và tối ưu query (chỉ gọi 1 lần dùng cho cả desktop và mobile)
$categories = \App\Models\Category::query()
->where('slug', '!=', 'uncategorized')
->orderBy('name')
->get();
@endphp

<nav x-data="{ 
        mobileMenuOpen: false, 
        searchOpen: false, 
        shopHover: false,
        scrolled: false 
    }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    @keydown.window.escape="searchOpen = false; mobileMenuOpen = false; shopHover = false"
    :class="{ 'bg-white/90 backdrop-blur-md shadow-sm': scrolled, 'bg-white': !scrolled }"
    class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-gray-100">

    {{-- PRIMARY HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">

            {{-- 1. MOBILE MENU BUTTON (LEFT) --}}
            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 -ml-2 text-gray-900 hover:opacity-70 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- 2. DESKTOP NAV LINKS (CENTER - SPLIT) --}}
            <div class="hidden sm:flex items-center gap-8 md:gap-12">
                {{-- Mega Menu Trigger --}}
                <div class="relative h-full flex items-center" @mouseenter="shopHover = true"
                    @mouseleave="shopHover = false">
                    <a href="{{ route('products.index') }}"
                        class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:text-gray-500 transition py-8 border-b-2 border-transparent hover:border-black">
                        Shop
                    </a>
                </div>

                {{-- Other Links --}}
                <a href="#new-arrivals"
                    class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:text-gray-500 transition">
                    New In
                </a>
                <a href="{{ route('about') }}"
                    class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:text-gray-500 transition">
                    About
                </a>
            </div>

            {{-- 3. LOGO (CENTER ABSOLUTE) --}}
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                <a href="{{ route('home') }}" class="block group">
                    <span
                        class="font-bold text-2xl sm:text-3xl tracking-tighter group-hover:opacity-80 transition">BLUSHOP.</span>
                </a>
            </div>

            {{-- 4. ICONS (RIGHT) --}}
            <div class="flex items-center gap-4 sm:gap-6">
                {{-- Search Toggle --}}
                <button @click="searchOpen = !searchOpen; $nextTick(() => $refs.searchInput.focus())"
                    class="text-gray-900 hover:opacity-60 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                {{-- Account (Desktop Only) --}}
                <div class="hidden sm:block relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="text-gray-900 hover:opacity-60 transition flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                    {{-- Account Dropdown --}}
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
                <a href="{{ route('cart.index') }}" class="relative text-gray-900 hover:opacity-60 transition">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    {{-- Minimalist Badge --}}
                    @php($cartQty = collect(session('cart', []))->sum('quantity'))
                    <span x-show="$store.cart && $store.cart.count > 0 || {{ $cartQty > 0 ? 'true' : 'false' }}"
                        class="absolute -top-1 -right-1 w-4 h-4 bg-black text-white text-[9px] flex items-center justify-center rounded-full"
                        x-text="$store.cart ? $store.cart.count : '{{ $cartQty }}'">
                        {{ $cartQty }}
                    </span>
                </a>
            </div>
        </div>
    </div>

    {{-- MEGA MENU (DESKTOP ONLY) --}}
    <div x-show="shopHover" @mouseenter="shopHover = true" @mouseleave="shopHover = false"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-xl z-40 hidden sm:block">

        <div class="max-w-7xl mx-auto px-8 py-10">
            <div class="grid grid-cols-4 gap-8">
                {{-- Column 1: Categories --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">Categories</h3>
                    <ul class="space-y-4">
                        @foreach($categories->take(5) as $c)
                        <li>
                            <a href="{{ route('products.index', ['category' => $c->slug]) }}"
                                class="text-sm text-gray-900 hover:underline decoration-1 underline-offset-4">
                                {{ $c->name }}
                            </a>
                        </li>
                        @endforeach
                        <li>
                            <a href="{{ route('products.index') }}"
                                class="text-sm font-bold text-black mt-2 inline-block">View All Products &rarr;</a>
                        </li>
                    </ul>
                </div>

                {{-- Column 2: Collections --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">Edits</h3>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-sm text-gray-900 hover:underline decoration-1 underline-offset-4">Campus
                                Essentials</a></li>
                        <li><a href="#"
                                class="text-sm text-gray-900 hover:underline decoration-1 underline-offset-4">Desk
                                Setup</a></li>
                        <li><a href="#"
                                class="text-sm text-gray-900 hover:underline decoration-1 underline-offset-4">Minimalist
                                Tech</a></li>
                        <li><a href="#"
                                class="text-sm text-red-600 hover:underline decoration-1 underline-offset-4">Sale - Last
                                Chance</a></li>
                    </ul>
                </div>

                {{-- Column 3 & 4: Featured Image --}}
                <div class="col-span-2 relative h-64 bg-gray-100 overflow-hidden group">
                    <img src="{{ asset('images/menu-featured.jpg') }}"
                        onerror="this.src='https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop'"
                        alt="New Collection"
                        class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <p class="text-xs uppercase tracking-widest mb-2">Just Landed</p>
                        <h4 class="text-xl font-bold">The Monochrome Collection</h4>
                    </div>
                    <a href="#" class="absolute inset-0"></a>
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
            <form action="{{ route('products.index') }}" method="GET">
                <input x-ref="searchInput" type="text" name="q" placeholder="Type to search..."
                    class="w-full text-2xl font-light border-none border-b border-gray-200 focus:ring-0 focus:border-black p-4 placeholder-gray-300">
            </form>
            <button @click="searchOpen = false"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black">
                <span class="text-xs uppercase tracking-widest">Close</span>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU (SLIDE OVER) --}}
    <div x-show="mobileMenuOpen" class="sm:hidden fixed inset-0 z-50 flex">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="mobileMenuOpen = false" x-show="mobileMenuOpen"
            x-transition.opacity></div>

        {{-- Panel --}}
        <div class="relative w-4/5 max-w-xs bg-white h-full shadow-2xl flex flex-col" x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <span class="font-bold text-xl tracking-tighter">MENU</span>
                <button @click="mobileMenuOpen = false">
                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <a href="{{ route('home') }}" class="block text-lg font-medium">Home</a>

                {{-- Mobile Shop Accordion --}}
                <div x-data="{ expanded: true }">
                    <button @click="expanded = !expanded"
                        class="flex items-center justify-between w-full text-lg font-medium mb-4">
                        <span>Shop</span>
                        <svg class="w-4 h-4 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul x-show="expanded" x-collapse class="pl-4 space-y-3 border-l border-gray-200">
                        @foreach($categories as $c)
                        <li><a href="{{ route('products.index', ['category' => $c->slug]) }}"
                                class="text-gray-600 hover:text-black">{{ $c->name }}</a></li>
                        @endforeach
                        <li><a href="{{ route('products.index') }}" class="font-medium text-black">View All</a></li>
                    </ul>
                </div>

                <a href="{{ route('contact.index') }}" class="block text-lg font-medium">Contact</a>
                <a href="{{ route('about') }}" class="block text-lg font-medium">About</a>
            </div>

            <div class="p-6 border-t border-gray-100 bg-gray-50">
                @auth
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">
                        {{ Str::substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-xs text-gray-500 underline">Edit Profile</a>
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
</nav>