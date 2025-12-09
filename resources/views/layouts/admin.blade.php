<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BluShop Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar for that minimalist feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #d4d4d4;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a3a3a3;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white text-neutral-900" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
        class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm lg:hidden"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-neutral-50 border-r border-neutral-200 transition-transform duration-300 ease-out lg:static lg:translate-x-0">

        <div class="h-16 flex items-center px-8 border-b border-neutral-200 bg-white">
            <span class="text-2xl font-black tracking-tighter uppercase">BLU<span
                    class="text-neutral-400">.ADMIN</span></span>
        </div>

        <nav class="p-6 space-y-1">
            <div class="px-3 mb-4 mt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400">Overview</div>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-3 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-black bg-white shadow-sm border border-neutral-200' : 'text-neutral-500 hover:text-black hover:bg-neutral-100' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <div class="px-3 mb-4 mt-8 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400">Management
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="flex items-center px-3 py-2.5 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.orders*') ? 'text-black bg-white shadow-sm border border-neutral-200' : 'text-neutral-500 hover:text-black hover:bg-neutral-100' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Orders
            </a>

            <a href="#"
                class="flex items-center px-3 py-2.5 text-sm font-medium text-neutral-500 hover:text-black hover:bg-neutral-100 transition-colors duration-200">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                Products
            </a>
            <a href="#"
                class="flex items-center px-3 py-2.5 text-sm font-medium text-neutral-500 hover:text-black hover:bg-neutral-100 transition-colors duration-200">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Customers
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 w-full p-6 border-t border-neutral-200">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-black text-white flex items-center justify-center text-xs font-bold">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-neutral-900 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-neutral-500 truncate tracking-wide">STORE OWNER</p>
                </div>
            </div>
        </div>
    </aside>

    <div class="lg:ml-64 min-h-screen flex flex-col">
        <header
            class="h-16 bg-white/80 backdrop-blur-md border-b border-neutral-100 sticky top-0 z-30 px-6 flex items-center justify-between">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-neutral-500 hover:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <div class="flex-1"></div>
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" target="_blank"
                    class="text-xs font-bold uppercase tracking-widest text-neutral-500 hover:text-black transition-colors">
                    View Store ↗
                </a>
            </div>
        </header>

        <main class="flex-1 p-6 lg:p-10">
            @yield('content')
        </main>
    </div>
</body>

</html>