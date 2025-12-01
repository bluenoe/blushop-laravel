<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BluShop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @auth
    <script>
        window.__INITIAL_AVATAR_URL = @json(Auth:: user() -> avatarUrl());
    </script>
    @endauth
    @php($cartQty = collect(session('cart', []))->sum('quantity'))
    <script>window.__CART_COUNT = {{ (int) $cartQty }};</script>
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-warm">
        {{-- Navigation (updated to include Home link to /) --}}
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-warm border-b border-beige shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-ink">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        {{-- Global Footer --}}
        @include('components.footer')
    </div>
</body>

</html>