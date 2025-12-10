{{--
═══════════════════════════════════════════════════════════════
BluShop Wishlist v2 - Curated Collection
Concept: Editorial Grid, Minimalist Actions
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">
        <div class="max-w-[1400px] mx-auto px-6 py-20 lg:py-32">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-start">

                {{-- LEFT: ACCOUNT NAVIGATION (Đồng bộ 100% với trang Orders & Profile) --}}
                <div class="lg:col-span-3 lg:sticky lg:top-32">
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold tracking-tighter">My Account.</h2>
                        <p class="text-sm text-neutral-400 mt-2 font-light">Welcome back, {{ Auth::user()->name }}</p>
                    </div>

                    <nav class="space-y-1 border-l-2 border-neutral-100 pl-6">
                        <a href="{{ route('profile.edit') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">
                            Settings
                        </a>
                        <a href="{{ route('orders.index') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">
                            Order History
                        </a>
                        {{-- Active State cho Wishlist --}}
                        <a href="{{ route('wishlist.index') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-black border-l-2 border-black -ml-[26px] pl-6 transition">
                            Wishlist
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="pt-8">
                            @csrf
                            <button type="submit"
                                class="text-xs text-red-500 uppercase tracking-widest hover:text-red-700 hover:underline underline-offset-4">
                                Log Out
                            </button>
                        </form>
                    </nav>
                </div>

                {{-- RIGHT: WISHLIST GRID --}}
                <div class="lg:col-span-9">

                    <div class="flex justify-between items-end mb-12">
                        <h1 class="text-3xl font-bold tracking-tighter">Saved Items <span
                                class="text-neutral-300 text-lg align-top ml-1">{{ $products->total() }}</span></h1>

                        @if($products->isNotEmpty())
                        <form action="{{ route('wishlist.clear') }}" method="POST"
                            onsubmit="return confirm('Clear entire wishlist?')">
                            @csrf
                            <button type="submit"
                                class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-red-600 transition border-b border-transparent hover:border-red-600 pb-0.5">
                                Clear All
                            </button>
                        </form>
                        @endif
                    </div>

                    @if($products->isEmpty())
                    <div
                        class="flex flex-col items-center justify-center py-32 border border-neutral-100 bg-neutral-50 text-center px-6">
                        <p class="text-neutral-400 mb-2 font-light text-lg">Your wishlist is currently empty.</p>
                        <p class="text-neutral-300 text-sm mb-8 max-w-md">Save items you love here to track their
                            availability or purchase later.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block px-10 py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1">
                            Explore Collection
                        </a>
                    </div>
                    @else
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-12">
                        @foreach($products as $product)
                        <div class="group relative flex flex-col">

                            {{-- Remove Button (Absolute Top Right) --}}
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST"
                                class="absolute top-2 right-2 z-20">
                                @csrf
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center bg-white/80 backdrop-blur-sm text-neutral-400 hover:text-black hover:bg-white transition rounded-full">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>

                            {{-- Image --}}
                            <a href="{{ route('products.show', $product->id) }}"
                                class="block aspect-[3/4] overflow-hidden bg-neutral-100 relative mb-4">
                                @if($product->image)
                                <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-300 text-xs">NO
                                    IMG</div>
                                @endif

                                {{-- Hover Overlay: Quick Add --}}
                                <div
                                    class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition duration-300 z-10">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full py-3 bg-white text-black text-[10px] font-bold uppercase tracking-widest hover:bg-neutral-100 shadow-lg">
                                            Add to Bag
                                        </button>
                                    </form>
                                </div>
                            </a>

                            {{-- Info --}}
                            <div class="space-y-1">
                                <h3 class="text-sm font-bold text-neutral-900 leading-tight">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <div class="flex justify-between items-baseline">
                                    <p class="text-xs text-neutral-500">{{ $product->category->name ?? 'Essentials' }}
                                    </p>
                                    <p class="text-sm font-mono font-medium text-neutral-900">₫{{
                                        number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>

                    <div class="mt-16 pt-8 border-t border-neutral-100">
                        {{ $products->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</x-app-layout>