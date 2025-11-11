<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BluShop Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#0b1220] text-gray-200 min-h-screen" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed z-40 inset-y-0 left-0 w-64 transform transition-transform duration-200 bg-[#0d1426] border-r border-gray-700 md:static md:translate-x-0">
            <div class="px-4 py-4 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="h-10 w-auto sm:h-12" />
                    <span class="font-semibold text-gray-100">BluShop Admin</span>
                </a>
            </div>
            <nav class="px-2 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-[#111a33] text-gray-200">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#111a33] text-gray-200">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#111a33] text-gray-200">Categories</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#111a33] text-gray-200">Users</a>
                <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-md hover:bg-[#111a33] text-gray-200">Orders</a>
            </nav>
        </aside>

        <!-- Content area -->
        <div class="flex-1 md:ml-64">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 bg-[#0b1220]/95 backdrop-blur border-b border-gray-700">
                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                    <button class="md:hidden inline-flex items-center px-3 py-2 text-gray-300 hover:text-white" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle navigation">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-400">Signed in as</span>
                        <span class="text-sm font-medium text-gray-100">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="ml-4 inline-flex items-center px-3 py-1.5 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100 text-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Flash toast/messages -->
            <div class="max-w-7xl mx-auto px-4">
                @if(session('success'))
                    <div class="mt-4 rounded-md bg-emerald-900/40 border border-emerald-700 text-emerald-200 px-4 py-2">{{ session('success') }}</div>
                @endif
                @if(session('warning'))
                    <div class="mt-4 rounded-md bg-amber-900/40 border border-amber-700 text-amber-200 px-4 py-2">{{ session('warning') }}</div>
                @endif
                @if($errors->any())
                    <div class="mt-4 rounded-md bg-red-900/40 border border-red-700 text-red-200 px-4 py-2">
                        <ul class="list-disc ml-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Main content -->
            <main class="max-w-7xl mx-auto px-4 py-8">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>