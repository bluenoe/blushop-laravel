{{--
═══════════════════════════════════════════════════════════════
BluShop Shopping Cart v3.1 - Payment Icons Fixed
Concept: Clean Product List, Sticky Summary Sidebar
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">

        <div class="max-w-[1400px] mx-auto px-6 py-12 lg:py-20">

            {{-- Header --}}
            <div class="mb-12 flex items-baseline justify-between border-b border-neutral-100 pb-6 pt-2">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tighter uppercase">Shopping Bag</h1>
                <span class="text-sm text-neutral-500">{{ count($cart ?? []) }} Items</span>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div
                class="mb-8 p-4 bg-neutral-50 border border-neutral-200 text-sm text-neutral-600 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(empty($cart))
            {{-- Empty State --}}
            <div class="py-24 text-center">
                <p class="text-neutral-400 mb-6 text-lg font-light">Your bag is currently empty.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition">
                    Start Shopping
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-start">

                {{-- LEFT: PRODUCT LIST --}}
                <div class="lg:col-span-7 space-y-8">
                    @foreach($cart as $id => $item)
                    @php $subtotal = (float)$item['price'] * (int)$item['quantity']; @endphp

                    <div class="flex gap-6 py-6 border-b border-neutral-100 last:border-0 group">
                        {{-- Image --}}
                        <div class="w-24 h-32 sm:w-32 sm:h-40 bg-neutral-100 flex-shrink-0 relative overflow-hidden">
                            <a href="{{ route('products.show', $id) }}">
                                <img src="{{ Storage::url('products/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            </a>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-sm font-bold uppercase tracking-wide">
                                        <a href="{{ route('products.show', $id) }}" class="hover:underline">{{
                                            $item['name'] }}</a>
                                    </h3>
                                    <span class="text-sm font-medium">₫{{ number_format($subtotal, 0, ',', '.')
                                        }}</span>
                                </div>
                                <p class="text-xs text-neutral-500 mb-1">Price: ₫{{ number_format((float)$item['price'],
                                    0, ',', '.') }}</p>
                                @if(isset($item['size'])) <p class="text-xs text-neutral-500">Size: {{ $item['size'] }}
                                </p> @endif
                            </div>

                            <div class="flex justify-between items-end mt-4">
                                {{-- Quantity Control --}}
                                <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center">
                                    @csrf
                                    <div class="flex items-center border border-neutral-200">
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                            class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:bg-neutral-50 transition"
                                            {{ $item['quantity'] <=1 ? 'disabled' : '' }}>-</button>
                                        <span class="w-8 text-center text-sm font-medium">{{ $item['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                            class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:bg-neutral-50 transition">+</button>
                                    </div>
                                </form>

                                {{-- Remove --}}
                                <form method="POST" action="{{ route('cart.remove', $id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-red-600 underline transition">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="pt-6">
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            <button type="submit" class="text-xs text-neutral-400 hover:text-black transition">Clear
                                Shopping Bag</button>
                        </form>
                    </div>
                </div>

                {{-- RIGHT: SUMMARY (STICKY) --}}
                <div class="lg:col-span-5 lg:sticky lg:top-32 space-y-8 bg-neutral-50 p-8">
                    <h2 class="text-lg font-bold uppercase tracking-widest mb-6">Order Summary</h2>

                    <div class="space-y-4 text-sm text-neutral-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>₫{{ number_format($total ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping estimate</span>
                            <span class="text-neutral-400">Calculated at checkout</span>
                        </div>
                    </div>

                    <div class="border-t border-neutral-200 pt-6 mt-6">
                        <div class="flex justify-between items-end mb-1">
                            <span class="text-base font-bold uppercase tracking-widest">Total</span>
                            <span class="text-xl font-bold">₫{{ number_format($total ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[10px] text-neutral-400 mt-1">Including VAT</p>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                        class="block w-full py-4 bg-black text-white text-center font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                        Proceed to Checkout
                    </a>

                    <div class="text-center mt-4">
                        <a href="{{ route('products.index') }}"
                            class="text-xs text-neutral-500 hover:text-black underline underline-offset-4">Continue
                            Shopping</a>
                    </div>

                    {{-- Payment Icons (Synced with Footer) --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200">
                        <p class="text-[10px] text-center uppercase tracking-widest text-neutral-400 mb-4">We Accept</p>
                        <div class="flex justify-center gap-2">
                            {{-- Visa --}}
                            <div
                                class="bg-white border border-neutral-200 rounded px-2 py-1.5 hover:border-neutral-400 transition">
                                <svg class="h-6 w-auto" viewBox="0 0 48 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="white" />
                                    <path
                                        d="M20.146 21.845h-2.882l1.803-11.177h2.882l-1.803 11.177zm-5.55-11.177l-2.762 7.644-.323-1.644-1.074-5.527s-.13-.473-.755-.473H5.528l-.044.14s1.147.239 2.488.992l2.065 7.957h3.005l4.604-11.089h-3.001zM38.67 21.845h2.647l-2.309-11.177h-2.432c-.502 0-.627.388-.627.388l-4.313 10.789h3.005l.596-1.658h3.667l.346 1.658zm-3.184-3.944l1.506-4.161.862 4.161h-2.368zm-6.288-5.175l.417-2.421s-1.292-.489-2.647-.489c-1.463 0-4.938.64-4.938 3.754 0 2.933 4.087 2.968 4.087 4.51 0 1.542-3.667 1.265-4.875.293l-.43 2.507s1.305.64 3.302.64c1.998 0 5.063-.835 5.063-3.884 0-2.946-4.13-3.238-4.13-4.51 0-1.272 2.993-1.056 4.151-.4z"
                                        fill="#1434CB" />
                                </svg>
                            </div>

                            {{-- Mastercard --}}
                            <div
                                class="bg-white border border-neutral-200 rounded px-2 py-1.5 hover:border-neutral-400 transition">
                                <svg class="h-6 w-auto" viewBox="0 0 48 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="white" />
                                    <circle cx="18" cy="16" r="8" fill="#EB001B" />
                                    <circle cx="30" cy="16" r="8" fill="#F79E1B" />
                                    <path
                                        d="M24 9.6c-1.6 1.4-2.6 3.4-2.6 5.6s1 4.2 2.6 5.6c1.6-1.4 2.6-3.4 2.6-5.6s-1-4.2-2.6-5.6z"
                                        fill="#FF5F00" />
                                </svg>
                            </div>

                            {{-- PayPal --}}
                            <div
                                class="bg-white border border-neutral-200 rounded px-2 py-1.5 hover:border-neutral-400 transition">
                                <svg class="h-6 w-auto" viewBox="0 0 48 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="white" />
                                    <path
                                        d="M20.905 9h-5.526c-.384 0-.712.28-.772.662l-2.274 14.42c-.046.29.175.554.47.554h2.73c.384 0 .712-.28.772-.662l.614-3.893c.06-.382.388-.662.772-.662h1.778c3.702 0 5.842-1.792 6.397-5.347.25-1.553.011-2.773-.708-3.626-.791-.938-2.195-1.446-4.063-1.446zm.649 5.266c-.305 2.002-1.833 2.002-3.31 2.002h-.841l.59-3.738c.035-.229.234-.399.464-.399h.39c1.017 0 1.977 0 2.472.579.297.347.385.86.235 1.556z"
                                        fill="#003087" />
                                    <path
                                        d="M33.905 14.217h-2.738c-.23 0-.429.17-.464.399l-.119.755-.189-.274c-.586-.85-1.892-1.134-3.197-1.134-2.99 0-5.543 2.266-6.039 5.445-.258 1.586.11 3.1 1.008 4.153.826.967 2.004 1.368 3.407 1.368 2.409 0 3.745-1.548 3.745-1.548l-.121.753c-.046.29.175.554.47.554h2.467c.384 0 .712-.28.772-.662l1.456-9.219c.046-.29-.175-.554-.47-.554zm-3.816 5.24c-.261 1.544-1.506 2.581-3.096 2.581-.796 0-1.434-.256-1.844-.74-.408-.48-.562-1.164-.434-1.925.25-1.531 1.514-2.602 3.076-2.602.78 0 1.413.258 1.829.746.418.492.583 1.18.469 1.94z"
                                        fill="#009CDE" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            @endif
        </div>
    </main>
</x-app-layout>