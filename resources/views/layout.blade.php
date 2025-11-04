<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BluShop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { padding-top: 70px; }
        footer { margin-top: 40px; padding: 20px 0; }
        .nav-brand-txt { font-weight: 700; letter-spacing: .3px; }
        .badge-cart { position: relative; top: -10px; left: -6px; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
@php
    $cartQty = collect(session('cart', []))->sum('quantity');
@endphp

<header x-data="{ open: false }" class="fixed top-0 inset-x-0 z-50 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a class="nav-brand-txt text-white" href="{{ route('home') }}">BluShop</a>
            <button @click="open = !open" aria-controls="mainNav" :aria-expanded="open"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <nav class="hidden md:flex md:items-center md:space-x-6" id="mainNav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white' : 'text-gray-300 hover:text-white' }}">Home</a>
                <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                    Cart
                    @if($cartQty > 0)
                        <span class="badge-cart ml-2 inline-flex items-center justify-center rounded-full bg-yellow-400 text-gray-900 text-xs px-2">{{ $cartQty }}</span>
                    @endif
                </a>
                <a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.*') ? 'text-white' : 'text-gray-300 hover:text-white' }}">Contact</a>
            </nav>
            <div class="hidden md:flex md:items-center md:space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="{{ request()->is('login') ? 'text-white' : 'text-gray-300 hover:text-white' }}">Login</a>
                    <a href="{{ route('register') }}" class="{{ request()->is('register') ? 'text-white' : 'text-gray-300 hover:text-white' }}">Register</a>
                @endguest
                @auth
                    <span class="text-sm opacity-80">Hi, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm px-3 py-1.5 border border-white/40 rounded-md hover:bg-white/10">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
        <div x-show="open" x-transition class="md:hidden pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 {{ request()->routeIs('home') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">Home</a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 {{ request()->routeIs('cart.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">Cart @if($cartQty > 0)<span class="ml-2 inline-flex items-center justify-center rounded-full bg-yellow-400 text-gray-900 text-xs px-2">{{ $cartQty }}</span>@endif</a>
            <a href="{{ route('contact.index') }}" class="block px-3 py-2 {{ request()->routeIs('contact.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">Contact</a>
            <div class="pt-2 border-t border-gray-800 mt-2">
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 {{ request()->is('login') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 {{ request()->is('register') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">Register</a>
                @endguest
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="px-3 py-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-300 hover:text-white">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 mt-20">
    @yield('content')
    
</main>

<footer class="text-center bg-gray-100 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4">
        <small class="text-gray-600 dark:text-gray-300">
            &copy; {{ date('Y') }} BluShop — A mini Laravel e-commerce for students. Built with ❤️.
        </small>
    </div>
    
</footer>

</body>
</html>
