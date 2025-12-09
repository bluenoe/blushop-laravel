<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BluAdmin') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet" />

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Ẩn thanh cuộn nhưng vẫn cuộn được (cho menu đẹp hơn) */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white text-neutral-900 selection:bg-black selection:text-white"
    x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex flex-col md:flex-row">

        {{-- ==========================================
        SIDEBAR - Structure: Flex Column (Header - Nav - Footer)
        ========================================== --}}
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-neutral-100 transform transition-transform duration-300 ease-in-out 
                      md:translate-x-0 md:sticky md:top-0 md:h-screen flex flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- 1. SIDEBAR HEADER (Logo) --}}
            <div class="h-20 flex-shrink-0 flex items-center px-8 border-b border-neutral-100">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-tighter uppercase">
                    Blu<span class="font-light text-neutral-400">Admin.</span>
                </a>
            </div>

            {{-- 2. SIDEBAR BODY (Scrollable Navigation) --}}
            <div class="flex-1 overflow-y-auto py-6 px-4 hide-scrollbar">
                <nav class="space-y-1">

                    {{-- GROUP: OVERVIEW --}}
                    <div class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 font-bold mb-4 px-2">Overview
                    </div>

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-2 py-3 text-sm font-medium rounded-md group transition-colors 
                       {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white' : 'text-neutral-600 hover:bg-neutral-50 hover:text-black' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- GROUP: MANAGEMENT --}}
                    <div class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 font-bold mt-8 mb-4 px-2">
                        Management</div>

                    {{-- Link: Products --}}
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-2 py-3 text-sm font-medium rounded-md group transition-colors 
                       {{ request()->routeIs('admin.products.*') ? 'bg-black text-white' : 'text-neutral-600 hover:bg-neutral-50 hover:text-black' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Products
                    </a>

                    {{-- Link: Categories --}}
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 px-2 py-3 text-sm font-medium rounded-md group transition-colors 
                       {{ request()->routeIs('admin.categories.*') ? 'bg-black text-white' : 'text-neutral-600 hover:bg-neutral-50 hover:text-black' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Categories
                    </a>

                    {{-- Link: Orders --}}
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-2 py-3 text-sm font-medium rounded-md group transition-colors 
                       {{ request()->routeIs('admin.orders.*') ? 'bg-black text-white' : 'text-neutral-600 hover:bg-neutral-50 hover:text-black' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Orders
                    </a>

                    {{-- Link: Customers --}}
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-2 py-3 text-sm font-medium rounded-md group transition-colors 
                       {{ request()->routeIs('admin.users.*') ? 'bg-black text-white' : 'text-neutral-600 hover:bg-neutral-50 hover:text-black' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Customers
                    </a>
                </nav>
            </div>

            {{-- 3. SIDEBAR FOOTER (User Profile) --}}
            <div class="flex-shrink-0 p-6 border-t border-neutral-100 bg-white">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:opacity-70 transition">
                    <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center">
                        <span class="text-xs font-bold">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-neutral-400 truncate">Store Manager</p>
                    </div>
                </a>
            </div>

        </aside>

        {{-- ==========================================
        MAIN CONTENT
        ========================================== --}}
        <main class="flex-1 min-h-screen bg-white md:bg-neutral-50/50 relative">

            {{-- Mobile Header --}}
            <header
                class="md:hidden h-16 bg-white border-b border-neutral-100 flex items-center justify-between px-6 sticky top-0 z-40">
                <span class="font-bold tracking-tight">BLU ADMIN</span>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 -mr-2 text-neutral-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </header>

            {{-- Overlay for mobile sidebar --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
                class="fixed inset-0 bg-black/20 z-40 md:hidden"></div>

            {{-- Slot Content --}}
            <div class="p-6 md:p-12 lg:p-16 max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>

</html>