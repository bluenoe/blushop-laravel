<nav id="main-nav" x-data="{ open: false }" class="bg-warm border-b border-beige sticky top-0 z-40 transition-shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-10 sm:h-12 lg:h-14">

            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    {{-- Brand wordmark (text-based) --}}
                    <a href="{{ route('home') }}" aria-label="BluShop Home" class="inline-flex items-center">
                        <x-blu-logo class="text-2xl md:text-3xl" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    {{-- Thêm các link có sẵn trong web.php cho đúng flow --}}
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        {{ __('Shop') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        {{ __('Cart') }}
                    </x-nav-link>
                    {{-- Favorites link removed: wishlist is now in Profile sidebar */}
                    <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">
                        {{ __('Contact') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>
                    <x-nav-link :href="route('faq')" :active="request()->routeIs('faq')">
                        {{ __('FAQ') }}
                    </x-nav-link>

                    {{-- Nếu sau này có dashboard thì mở lại --}}
                    {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link> --}}
                </div>
            </div>

            <!-- Right: cart icon + settings dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center justify-center h-9 w-9 rounded-full border border-beige bg-white text-ink hover:bg-beige focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-transform duration-150 hover:scale-[1.03]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 7V6a4 4 0 1 1 8 0v1" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6 21h12a2 2 0 0 0 2-2l-1-11H5l-1 11a2 2 0 0 0 2 2Z" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M10 11a2 2 0 0 0 4 0" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    @php($cartQty = collect(session('cart', []))->sum('quantity'))
                    @if($cartQty > 0)
                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-[11px] px-1.5"
                        x-text="$store.cart && $store.cart.count">{{ $cartQty }}</span>
                    @else
                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-[11px] px-1.5"
                        x-show="$store.cart && $store.cart.count > 0" x-text="$store.cart && $store.cart.count"></span>
                    @endif
                </a>
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-warm hover:text-ink focus:outline-none transition ease-in-out duration-150">
                            @php($u = Auth::user())
                            @if ($u && $u->avatar)
                            <img data-avatar-sync="true" src="{{ $u->avatarUrl() }}" alt="User avatar"
                                class="h-10 w-10 rounded-full object-cover ring-1 ring-beige mr-3 transform transition hover:scale-105 hover:ring-indigo-500" />
                            @else
                            <div data-avatar-placeholder="true"
                                data-class="h-10 w-10 rounded-full object-cover ring-1 ring-beige mr-3 transform transition hover:scale-105 hover:ring-indigo-500"
                                class="h-10 w-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold mr-3">
                                {{ Str::of($u->name)->substr(0, 1)->upper() }}
                            </div>
                            @endif
                            <div>{{ $u->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Route::has('profile.edit'))
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        @endif
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">Register</a>
                </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-ink hover:bg-beige focus:outline-none focus:bg-beige focus:text-ink transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-warm">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('Shop') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Cart') }}
            </x-responsive-nav-link>
            {{-- Favorites link removed from mobile navigation */}
            <x-responsive-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('faq')" :active="request()->routeIs('faq')">
                {{ __('FAQ') }}
            </x-responsive-nav-link>
            {{-- <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link> --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-beige">
            @auth
            <div class="px-4 flex items-center gap-3">
                @php($u = Auth::user())
                @if ($u && $u->avatar)
                <img data-avatar-sync="true" src="{{ $u->avatarUrl() }}" alt="User avatar"
                    class="h-10 w-10 rounded-full object-cover ring-1 ring-beige transform transition hover:scale-105 hover:ring-indigo-500" />
                @else
                <div data-avatar-placeholder="true"
                    data-class="h-10 w-10 rounded-full object-cover ring-1 ring-beige transform transition hover:scale-105 hover:ring-indigo-500"
                    class="h-10 w-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold">
                    {{ Str::of($u->name)->substr(0, 1)->upper() }}
                </div>
                @endif
                <div>
                    <div class="font-medium text-base text-ink">{{ $u->name }}</div>
                    <div class="font-medium text-sm text-gray-600">{{ $u->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                @if (Route::has('profile.edit'))
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="px-4">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
            @endauth
        </div>
    </div>
</nav>