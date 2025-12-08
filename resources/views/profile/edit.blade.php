<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">
        {{-- Header --}}
        <div class="pt-24 pb-8 px-6 border-b border-neutral-100">
            <div class="max-w-[1400px] mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tighter mb-2">My Account</h1>
                <p class="text-neutral-500 font-light text-sm">Welcome back, {{ Auth::user()->name }}</p>
            </div>
        </div>

        {{-- Main Layout --}}
        <div class="max-w-[1400px] mx-auto px-6 py-12" x-data="{ tab: 'account' }">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                {{-- SIDEBAR NAVIGATION --}}
                <aside class="lg:col-span-3">
                    <nav class="sticky top-32 space-y-1">
                        {{-- Account --}}
                        <button @click="tab='account'"
                            class="w-full text-left px-4 py-3 text-xs font-bold uppercase tracking-widest transition border-l-2"
                            :class="tab==='account' ? 'border-black text-black' : 'border-transparent text-neutral-400 hover:text-black'">
                            Profile & Settings
                        </button>

                        {{-- Orders --}}
                        <button @click="tab='orders'"
                            class="w-full text-left px-4 py-3 text-xs font-bold uppercase tracking-widest transition border-l-2"
                            :class="tab==='orders' ? 'border-black text-black' : 'border-transparent text-neutral-400 hover:text-black'">
                            Order History
                        </button>

                        {{-- Wishlist --}}
                        <button @click="tab='wishlist'"
                            class="w-full text-left px-4 py-3 text-xs font-bold uppercase tracking-widest transition border-l-2"
                            :class="tab==='wishlist' ? 'border-black text-black' : 'border-transparent text-neutral-400 hover:text-black'">
                            Wishlist
                        </button>

                        {{-- Password --}}
                        <button @click="tab='password'"
                            class="w-full text-left px-4 py-3 text-xs font-bold uppercase tracking-widest transition border-l-2"
                            :class="tab==='password' ? 'border-black text-black' : 'border-transparent text-neutral-400 hover:text-black'">
                            Security
                        </button>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="pt-8">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 text-xs font-bold uppercase tracking-widest text-red-600 hover:text-red-800 transition">
                                Log Out
                            </button>
                        </form>
                    </nav>
                </aside>

                {{-- CONTENT AREA --}}
                <div class="lg:col-span-9 min-h-[500px]">

                    {{-- TAB: ACCOUNT --}}
                    <div x-show="tab==='account'" x-transition.opacity>
                        <div class="max-w-2xl">
                            <h2 class="text-xl font-bold mb-8">Personal Information</h2>
                            @include('profile.partials.update-profile-information-form')

                            <div class="mt-16 pt-16 border-t border-neutral-100">
                                <h2 class="text-xl font-bold mb-4 text-red-600">Danger Zone</h2>
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>

                    {{-- TAB: ORDERS (Placeholder) --}}
                    <div x-show="tab==='orders'" x-cloak x-transition.opacity>
                        <h2 class="text-xl font-bold mb-8">Order History</h2>
                        <div class="border border-neutral-100 bg-neutral-50 p-12 text-center">
                            <p class="text-neutral-500 font-light">You haven't placed any orders yet.</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-block mt-4 text-xs font-bold uppercase tracking-widest border-b border-black pb-1">Start
                                Shopping</a>
                        </div>
                    </div>

                    {{-- TAB: WISHLIST --}}
                    <div x-show="tab==='wishlist'" x-cloak x-transition.opacity>
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-xl font-bold">My Wishlist</h2>
                            @if(($products ?? collect())->isNotEmpty())
                            <form method="POST" action="{{ route('wishlist.clear') }}">
                                @csrf
                                <button type="submit"
                                    class="text-xs text-neutral-400 hover:text-red-600 underline">Clear All</button>
                            </form>
                            @endif
                        </div>

                        @if(($products ?? collect())->isEmpty())
                        <div class="border border-neutral-100 bg-neutral-50 p-12 text-center">
                            <p class="text-neutral-500 font-light">Your wishlist is empty.</p>
                        </div>
                        @else
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            @foreach(($products ?? collect()) as $product)
                            <x-cart :product="$product" :is-wished="in_array($product->id, ($wishedIds ?? []))" />
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- TAB: PASSWORD --}}
                    <div x-show="tab==='password'" x-cloak x-transition.opacity>
                        <div class="max-w-2xl">
                            <h2 class="text-xl font-bold mb-8">Change Password</h2>
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    @include('partials.wishlist-script')
</x-app-layout>