{{--
═══════════════════════════════════════════════════════════════
BluShop Account - Order History v2
Concept: Clean Sidebar, Horizontal Product Strip, Monospace Data
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">
        <div class="max-w-[1400px] mx-auto px-6 py-20 lg:py-32">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-start">

                {{-- LEFT: ACCOUNT NAVIGATION --}}
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
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-black border-l-2 border-black -ml-[26px] pl-6 transition">
                            Order History
                        </a>
                        <a href="{{ route('wishlist.index') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">
                            Wishlist
                        </a>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="pt-8">
                            @csrf
                            <button type="submit"
                                class="text-xs text-red-500 uppercase tracking-widest hover:text-red-700 hover:underline underline-offset-4">
                                Log Out
                            </button>
                        </form>
                    </nav>
                </div>

                {{-- RIGHT: ORDER CONTENT --}}
                <div class="lg:col-span-9">

                    @if($orders->isEmpty())
                    <div
                        class="flex flex-col items-center justify-center py-32 border border-neutral-100 bg-neutral-50">
                        <p class="text-neutral-400 mb-6 font-light text-lg">No archival data found.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-block px-10 py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1">
                            Discover Collection
                        </a>
                    </div>
                    @else
                    <div class="space-y-12">
                        @foreach($orders as $order)
                        <div class="group relative border-b border-neutral-200 pb-12 last:border-0">

                            {{-- Order Header Data --}}
                            <div class="flex flex-wrap justify-between items-end mb-8 gap-6">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="px-2 py-1 border border-neutral-200 text-[10px] font-bold uppercase tracking-wider rounded-sm
                                                {{ $order->status === 'completed' ? 'bg-black text-white border-black' : 'text-neutral-500' }}">
                                            {{ $order->status }}
                                        </span>
                                        <span class="text-xs font-mono text-neutral-400">#{{ $order->id }}</span>
                                    </div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-neutral-400">
                                        Placed on {{ $order->created_at->format('F d, Y') }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-1">Total
                                    </p>
                                    <p class="text-xl font-mono font-medium tracking-tight">₫{{
                                        number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            {{-- Product Visual Strip --}}
                            <div class="grid grid-cols-4 md:grid-cols-6 gap-4 mb-8">
                                @foreach($order->orderItems->take(5) as $item)
                                @php
                                $productRef = $item->product;
                                $slug = $productRef->slug ?? '';
                                $imgRaw = $productRef->image ?? null;
                                $historyImgSrc = 'https://placehold.co/120x160?text=No+Image';

                                if ($slug && $imgRaw) {
                                if (Str::startsWith($imgRaw, ['http://', 'https://'])) {
                                $historyImgSrc = $imgRaw;
                                } else {
                                $historyImgSrc = asset('storage/products/' . $slug . '/' . basename($imgRaw));
                                }
                                }
                                @endphp
                                @if($productRef)
                                <div
                                    class="aspect-[3/4] bg-neutral-100 relative overflow-hidden group-hover:brightness-95 transition duration-500">
                                    <img src="{{ $historyImgSrc }}"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
                                </div>
                                @endif
                                @endforeach

                                {{-- More Items Indicator --}}
                                @if($order->orderItems->count() > 5)
                                <div
                                    class="aspect-[3/4] bg-neutral-50 flex items-center justify-center border border-neutral-100">
                                    <span class="text-xs font-mono text-neutral-400">+{{ $order->orderItems->count() - 5
                                        }}</span>
                                </div>
                                @endif
                            </div>

                            {{-- Action --}}
                            <div>
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:opacity-60 transition">
                                    View Invoice
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>

                        </div>
                        @endforeach
                    </div>

                    <div class="mt-16 pt-8 border-t border-neutral-100">
                        {{ $orders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</x-app-layout>