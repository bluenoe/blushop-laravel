<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BluShop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>window.__CART_COUNT = {{ (int)(collect(session('cart', [])) -> sum('quantity')) }};</script>
    <style>
        body {
            padding-top: 70px;
        }

        footer {
            margin-top: 40px;
            padding: 20px 0;
        }

        .nav-brand-txt {
            font-weight: 700;
            letter-spacing: .3px;
        }

        .badge-cart {
            position: relative;
            top: -10px;
            left: -6px;
        }
    </style>
</head>

<body class="bg-warm text-ink">
    @php
    $cartQty = collect(session('cart', []))->sum('quantity');
    @endphp

    <header x-data="{ open: false }"
        class="fixed top-0 inset-x-0 z-50 bg-warm text-ink border-b border-beige shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a class="nav-brand-txt text-ink" href="{{ route('home') }}"><x-blu-logo
                        class="text-xl sm:text-2xl" /></a>
                <button @click="open = !open" aria-controls="mainNav" :aria-expanded="open"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md hover:bg-beige focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <nav class="hidden md:flex md:items-center md:space-x-6" id="mainNav">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-ink font-medium' : 'text-gray-700 hover:text-ink' }}">Home</a>
                    <a href="{{ route('cart.index') }}"
                        class="{{ request()->routeIs('cart.*') ? 'text-ink font-medium' : 'text-gray-700 hover:text-ink' }}">
                        Cart
                        @if($cartQty > 0)
                        <span
                            class="badge-cart ml-2 inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-xs px-2">{{
                            $cartQty }}</span>
                        @endif
                    </a>
                    <a href="{{ route('contact.index') }}"
                        class="{{ request()->routeIs('contact.*') ? 'text-ink font-medium' : 'text-gray-700 hover:text-ink' }}">Contact</a>
                </nav>
                <div class="hidden md:flex md:items-center md:space-x-4">
                    <a href="{{ route('cart.index') }}"
                        class="relative inline-flex items-center justify-center h-9 w-9 rounded-full border border-beige bg-white text-ink hover:bg-beige focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-transform duration-150 hover:scale-[1.03]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 7V6a4 4 0 1 1 8 0v1" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 21h12a2 2 0 0 0 2-2l-1-11H5l-1 11a2 2 0 0 0 2 2Z" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M10 11a2 2 0 0 0 4 0" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        @if($cartQty > 0)
                        <span
                            class="absolute -top-1 -right-1 inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-[11px] px-1.5"
                            x-text="$store.cart && $store.cart.count">{{ $cartQty }}</span>
                        @else
                        <span
                            class="absolute -top-1 -right-1 inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-[11px] px-1.5"
                            x-show="$store.cart && $store.cart.count > 0"
                            x-text="$store.cart && $store.cart.count"></span>
                        @endif
                    </a>
                    @guest
                    <a href="{{ route('login') }}"
                        class="{{ request()->is('login') ? 'text-ink font-medium' : 'text-gray-700 hover:text-ink' }}">Login</a>
                    <a href="{{ route('register') }}"
                        class="{{ request()->is('register') ? 'text-ink font-medium' : 'text-gray-700 hover:text-ink' }}">Register</a>
                    @endguest
                    @auth
                    <span class="text-sm opacity-80">Hi, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-sm px-3 py-1.5 border border-beige rounded-md hover:bg-beige">Logout</button>
                    </form>
                    @endauth
                </div>
            </div>
            <div x-show="open" x-transition class="md:hidden pt-2 pb-3 space-y-1 bg-warm">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 {{ request()->routeIs('home') ? 'bg-beige text-ink' : 'text-gray-700 hover:bg-beige hover:text-ink' }}">Home</a>
                <a href="{{ route('cart.index') }}"
                    class="block px-3 py-2 {{ request()->routeIs('cart.*') ? 'bg-beige text-ink' : 'text-gray-700 hover:bg-beige hover:text-ink' }}">Cart
                    @if($cartQty > 0)<span
                        class="ml-2 inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-xs px-2">{{
                        $cartQty }}</span>@endif</a>
                <a href="{{ route('contact.index') }}"
                    class="block px-3 py-2 {{ request()->routeIs('contact.*') ? 'bg-beige text-ink' : 'text-gray-700 hover:bg-beige hover:text-ink' }}">Contact</a>
                <div class="pt-2 border-t border-beige mt-2">
                    @guest
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 {{ request()->is('login') ? 'bg-beige text-ink' : 'text-gray-700 hover:bg-beige hover:text-ink' }}">Login</a>
                    <a href="{{ route('register') }}"
                        class="block px-3 py-2 {{ request()->is('register') ? 'bg-beige text-ink' : 'text-gray-700 hover:bg-beige hover:text-ink' }}">Register</a>
                    @endguest
                    @auth
                    <form action="{{ route('logout') }}" method="POST" class="px-3 py-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-ink">Logout</button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 mt-20">
        @yield('content')

    </main>

    @include('components.footer')

</body>

</html>