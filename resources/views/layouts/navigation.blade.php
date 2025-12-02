<nav id="main-nav"
    x-data="{ open: false, searchOpen: false, toggleSearch(){ this.searchOpen = !this.searchOpen; if(this.searchOpen){ this.$nextTick(() => this.$refs.searchInput && this.$refs.searchInput.focus()); } } }"
    @keydown.window.escape="searchOpen=false" class="bg-warm border-b border-beige sticky top-0 z-40 transition-shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-10 sm:h-12 lg:h-14">

            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    {{-- Brand wordmark (text-based) --}}
                    <a href="{{ route('home') }}" aria-label="BluShop Home" class="inline-flex items-center">
                        <x-blu-logo class="text-2xl md:text-3xl" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:hidden">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    {{-- Thêm các link có sẵn trong web.php cho đúng flow --}}
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        {{ __('Shop') }}
                    </x-nav-link>

                    {{-- Favorites link removed: wishlist is now in Profile sidebar */}
                    <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">
                        {{ __('Contact') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>


                    {{-- Nếu sau này có dashboard thì mở lại --}}
                    {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link> --}}
                </div>
            </div>

            <div class="hidden sm:flex flex-1 items-center justify-center">
                <div class="flex items-center gap-8">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">{{ __('Home') }}</x-nav-link>
                    <div class="relative" x-data="{ shopOpen:false }" @keydown.window.escape="shopOpen=false">
                        <button type="button" @mouseenter="shopOpen=true" @mouseleave="shopOpen=false"
                            @click="shopOpen=!shopOpen"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('products.*') ? 'text-ink' : 'text-gray-700 hover:text-ink' }}">
                            {{ __('Shop') }}
                            <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-cloak x-show="shopOpen" @mouseenter="shopOpen=true" @mouseleave="shopOpen=false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute left-1/2 -translate-x-1/2 mt-2 w-64 rounded-xl border border-beige bg-white shadow-soft">
                            <ul class="py-2">
                                @foreach((\App\Models\Category::query()->select(['name','slug'])->where('slug','!=','uncategorized')->orderBy('name')->get()
                                ?? collect()) as $c)
                                <li>
                                    <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $c->slug])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-beige hover:text-ink">{{
                                        $c->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">{{ __('About')
                        }}</x-nav-link>
                    <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">{{
                        __('Contact') }}</x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <button type="button" @click="toggleSearch()"
                    class="relative inline-flex items-center justify-center h-9 w-9 rounded-full border border-beige bg-white text-ink hover:bg-beige focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-transform duration-150 hover:scale-[1.03]"
                    aria-label="Search">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21 21l-4.3-4.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
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

            <div class="-me-2 flex items-center sm:hidden gap-2">
                <button type="button" @click="toggleSearch()"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-ink hover:bg-beige focus:outline-none focus:bg-beige focus:text-ink transition duration-150 ease-in-out"
                    aria-label="Search">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21 21l-4.3-4.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
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

    <div x-cloak x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="bg-warm overflow-hidden"
        :style="searchOpen ? 'max-height: 96px' : 'max-height: 0px'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 transition-all duration-200 ease-out">
            <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                <input x-ref="searchInput" type="text" name="q" value="{{ request('q') }}"
                    placeholder="Search products..."
                    class="flex-1 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 shadow-soft">
                <button type="submit"
                    class="inline-flex items-center justify-center h-9 px-4 rounded-lg bg-indigo-600 text-white font-semibold shadow-soft hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">Search</button>
            </form>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-data="{ mobileShopOpen:false }" :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-warm">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <div class="px-3 py-2">
                <button type="button" @click="mobileShopOpen = !mobileShopOpen"
                    class="w-full text-left text-sm font-medium text-gray-700 hover:text-ink flex items-center justify-between">
                    <span>{{ __('Shop') }}</span>
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-cloak x-show="mobileShopOpen" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1" class="mt-2">
                    <ul class="space-y-1">
                        @foreach((\App\Models\Category::query()->select(['name','slug'])->where('slug','!=','uncategorized')->orderBy('name')->get()
                        ?? collect()) as $c)
                        <li>
                            <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $c->slug])) }}"
                                class="block px-3 py-2 text-sm text-gray-700 hover:bg-beige hover:text-ink rounded-md">{{
                                $c->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="px-3 py-2">
                <a href="{{ route('cart.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-ink">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 7V6a4 4 0 1 1 8 0v1" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6 21h12a2 2 0 0 0 2-2l-1-11H5l-1 11a2 2 0 0 0 2 2Z" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M10 11a2 2 0 0 0 4 0" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    @php($cartQty = collect(session('cart', []))->sum('quantity'))
                    <span
                        class="inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-[11px] px-1.5"
                        x-show="$store.cart && $store.cart.count > 0" x-text="$store.cart && $store.cart.count"></span>
                    @if($cartQty > 0)
                    <span
                        class="inline-flex items-center justify-center rounded-full bg-rosebeige text-ink text-[11px] px-1.5">{{
                        $cartQty }}</span>
                    @endif
                    <span>{{ __('Cart') }}</span>
                </a>
            </div>
            {{-- Favorites link removed from mobile navigation */}
            <x-responsive-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About') }}
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