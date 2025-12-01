<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BluShop Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js" defer></script>
</head>

<body class="bg-warm text-ink dark:bg-slate-950 dark:text-slate-100 min-h-screen"
    x-data="{ sidebarOpen: false, theme: (localStorage.getItem('admin:theme') || 'light') }"
    x-init="document.body.classList.toggle('dark', theme === 'dark'); $watch('theme', v => { localStorage.setItem('admin:theme', v); document.body.classList.toggle('dark', v === 'dark') })">
    <div class="flex min-h-screen bg-warm dark:bg-slate-950">
        <!-- Sidebar -->
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            class="fixed z-40 inset-y-0 left-0 w-64 transform transition-transform duration-200 bg-white border-r border-beige md:static md:translate-x-0 dark:bg-slate-900 dark:border-slate-700">
            <div class="px-4 py-4 border-b border-beige">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="h-10 w-auto sm:h-12" />
                    <span class="font-semibold text-ink">BluShop Admin</span>
                </a>
            </div>
            <nav class="px-2 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-ink {{ request()->routeIs('admin.dashboard') ? 'bg-beige' : 'hover:bg-beige' }} dark:text-slate-200 {{ request()->routeIs('admin.dashboard') ? 'dark:bg-slate-800' : 'dark:hover:bg-slate-800' }}">
                    <i data-lucide="layout-dashboard" class="h-5 w-5 text-gray-600 dark:text-slate-200"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-ink {{ request()->routeIs('admin.products.*') ? 'bg-beige' : 'hover:bg-beige' }} dark:text-slate-200 {{ request()->routeIs('admin.products.*') ? 'dark:bg-slate-800' : 'dark:hover:bg-slate-800' }}">
                    <i data-lucide="package" class="h-5 w-5 text-gray-600 dark:text-slate-200"></i>
                    <span>Products</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-ink {{ request()->routeIs('admin.categories.*') ? 'bg-beige' : 'hover:bg-beige' }} dark:text-slate-200 {{ request()->routeIs('admin.categories.*') ? 'dark:bg-slate-800' : 'dark:hover:bg-slate-800' }}">
                    <i data-lucide="grid-2x2" class="h-5 w-5 text-gray-600 dark:text-slate-200"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-ink {{ request()->routeIs('admin.users.*') ? 'bg-beige' : 'hover:bg-beige' }} dark:text-slate-200 {{ request()->routeIs('admin.users.*') ? 'dark:bg-slate-800' : 'dark:hover:bg-slate-800' }}">
                    <i data-lucide="users" class="h-5 w-5 text-gray-600 dark:text-slate-200"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-md text-ink {{ request()->routeIs('admin.orders.*') ? 'bg-beige' : 'hover:bg-beige' }} dark:text-slate-200 {{ request()->routeIs('admin.orders.*') ? 'dark:bg-slate-800' : 'dark:hover:bg-slate-800' }}">
                    <i data-lucide="receipt" class="h-5 w-5 text-gray-600 dark:text-slate-200"></i>
                    <span>Orders</span>
                </a>
            </nav>
        </aside>

        <!-- Content area -->
        <div class="flex-1 md:ml-64 bg-warm dark:bg-slate-950">
            <!-- Topbar -->
            <header
                class="sticky top-0 z-30 bg-warm/95 backdrop-blur border-b border-beige dark:bg-slate-900/95 dark:border-slate-700">
                <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                    <button
                        class="md:hidden inline-flex items-center px-3 py-2 text-gray-700 hover:text-ink dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800"
                        @click="sidebarOpen = !sidebarOpen" aria-label="Toggle navigation">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-3">
                        <button @click="theme = theme === 'dark' ? 'light' : 'dark'"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:text-ink hover:bg-beige focus:outline-none dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800"
                            aria-label="Toggle theme">
                            <template x-if="theme === 'dark'">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                                </svg>
                            </template>
                            <template x-if="theme !== 'dark'">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 2v2m0 16v2M2 12h2m16 0h2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                                </svg>
                            </template>
                        </button>

                        <x-dropdown align="right" width="48" contentClasses="py-1 bg-warm">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-3">
                                    @php($u = auth()->user())
                                    @if($u && $u->avatarUrl())
                                    <img data-avatar-sync="true" src="{{ $u->avatarUrl() }}" alt="User avatar"
                                        class="h-8 w-8 rounded-full object-cover ring-1 ring-beige dark:ring-slate-700" />
                                    @else
                                    <div data-avatar-placeholder="true"
                                        data-class="h-8 w-8 rounded-full object-cover ring-1 ring-beige"
                                        class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold">
                                        {{ Str::of($u?->name ?? 'A')->substr(0, 1)->upper() }}
                                    </div>
                                    @endif
                                    <span class="text-sm font-medium text-ink dark:text-white">{{ $u?->name ?? 'Admin
                                        User' }}</span>
                                    <svg class="ml-1 h-4 w-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.dashboard')">Settings</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Logout</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <div class="max-w-7xl mx-auto px-4 py-2">
                @php( $__crumbs = array_merge([
                ['label' => 'Admin', 'url' => route('admin.dashboard')],
                ], ($breadcrumb ?? [])) )
                <x-breadcrumbs :items="$__crumbs" />
            </div>

            <!-- Flash toast/messages -->
            <div class="max-w-7xl mx-auto px-4">
                @if(session('success'))
                <div class="mt-4 rounded-md border border-green-200 bg-green-50 text-green-700 px-4 py-2">{{
                    session('success') }}</div>
                @endif
                @if(session('warning'))
                <div class="mt-4 rounded-md border border-yellow-200 bg-yellow-50 text-yellow-700 px-4 py-2">{{
                    session('warning') }}</div>
                @endif
                @if($errors->any())
                <div class="mt-4 rounded-md border border-red-200 bg-red-50 text-red-700 px-4 py-2">
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
    <script>document.addEventListener('DOMContentLoaded', function () { try { if (window.lucide) { lucide.createIcons(); } } catch (e) { } });</script>
</body>

</html>