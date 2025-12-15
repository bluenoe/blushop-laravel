<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Smooth scroll behavior for in-page links -->
    <style>
        html,
        body {
            scroll-behavior: smooth !important;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BluShop') }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Truyền biến avatar URL cho JS sử dụng --}}

    @auth
    <script>
        window.__INITIAL_AVATAR_URL = @json(Auth:: user() -> avatarUrl());
    </script>
    @endauth

    {{-- Tính toán số lượng cart 1 lần duy nhất ở đây --}}
    @php
    $cartQty = collect(session('cart', []))->sum('quantity');
    @endphp

    <script>
        window.__CART_COUNT = {{ (int) $cartQty }};

        // Khởi tạo Store ngay khi Alpine load, sử dụng biến window ở trên
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                count: window.__CART_COUNT || 0,

                set(newCount) {
                    this.count = parseInt(newCount);
                }
            });
        });
    </script>

    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-warm">
        {{-- Navigation --}}
        @include('layouts.navigation')

        @isset($header)
        <header class="bg-warm border-b border-beige shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-ink">
                {{ $header }}
            </div>
        </header>
        @endisset

        <main>
            {{ $slot }}
        </main>

        {{-- Global Footer --}}
        @include('components.footer')
    </div>

    {{-- GLOBAL TOAST NOTIFICATION --}}
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            showNotification(event) {
                this.message = event.detail.message;
                this.type = event.detail.type || 'success';
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            }
         }" @notify.window="showNotification($event)"
        class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 pointer-events-none">

        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="pointer-events-auto min-w-[300px] bg-black text-white px-6 py-4 shadow-2xl flex items-center justify-between gap-4"
            :class="type === 'error' ? 'bg-red-600' : 'bg-black'">

            <div class="flex items-center gap-3">
                <template x-if="type === 'success'">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <span class="text-xs font-bold uppercase tracking-widest" x-text="message"></span>
            </div>

            <button @click="show = false" class="text-white/50 hover:text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- BACK TO TOP BUTTON (Updated v2) --}}
    <div x-data="{ 
        show: false,
        init() {
            window.addEventListener('scroll', () => {
                this.show = window.pageYOffset > 300;
            });
        },
        scrollToTop() {
            // Cách 1: Thử dùng native smooth scroll
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }" class="fixed z-50 bottom-6 right-6 lg:bottom-10 lg:right-10 pointer-events-none">

        <button @click="scrollToTop()" x-show="show" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-10 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-90"
            class="pointer-events-auto w-10 h-10 lg:w-12 lg:h-12 bg-black text-white flex items-center justify-center rounded-full shadow-2xl hover:bg-neutral-800 hover:-translate-y-1 transition-all duration-300 focus:outline-none group">

            <svg class="w-4 h-4 lg:w-5 lg:h-5 transition-transform duration-300 group-hover:-translate-y-0.5"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </div>
</body>

</html>