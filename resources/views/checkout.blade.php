{{--
═══════════════════════════════════════════════════════════════
BluShop Checkout v3 - High-End Minimalist
Concept: Split Layout, Underline Inputs, Sticky Summary
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">

        {{-- Flash Messages (Minimal) --}}
        @if(session('success') || session('warning') || $errors->any())
        <div class="fixed top-20 right-6 z-50 max-w-sm w-full space-y-2">
            @if(session('success'))
            <div class="p-4 bg-black text-white text-sm shadow-xl flex items-center gap-3">
                <svg class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('warning'))
            <div class="p-4 bg-neutral-100 text-neutral-900 border border-neutral-200 text-sm shadow-xl">
                {{ session('warning') }}
            </div>
            @endif
            @if($errors->any())
            <div class="p-4 bg-red-50 text-red-600 border border-red-100 text-sm shadow-xl">
                Please check the form for errors.
            </div>
            @endif
        </div>
        @endif

        <div class="max-w-[1400px] mx-auto px-6 py-12 lg:py-20">

            {{-- Header --}}
            <div class="mb-12 flex items-center gap-4 text-[10px] uppercase tracking-widest text-neutral-400 pt-3">
                <a href="{{ route('cart.index') }}" class="hover:text-black transition">Cart</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-black font-bold">Checkout</span>
            </div>

            @if(empty($cart))
            <div class="py-24 text-center">
                <h1 class="text-2xl font-bold mb-4">Your bag is empty.</h1>
                <a href="{{ route('products.index') }}"
                    class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition">
                    Continue Shopping
                </a>
            </div>
            @else

            {{-- MAIN FORM WRAPPER --}}
            <form action="{{ route('checkout.place') }}" method="POST"
                class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-start">
                @csrf

                {{-- LEFT: SHIPPING INFO --}}
                <div class="lg:col-span-7 space-y-16">

                    {{-- 1. Contact Info --}}
                    <div>
                        <h2
                            class="text-lg font-bold uppercase tracking-widest mb-8 border-b border-black pb-2 inline-block">
                            Shipping Information</h2>

                        <div class="space-y-8">
                            {{-- Full Name --}}
                            <div class="relative z-0 w-full group">
                                <input type="text" name="name" id="name" required
                                    class="block py-3 px-0 w-full text-base text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                    placeholder=" " value="{{ old('name', auth()->user()->name ?? '') }}" />
                                <label for="name"
                                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                    Full Name
                                </label>
                                @error('name') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Phone & Email Row --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative z-0 w-full group">
                                    <input type="tel" name="phone" id="phone" required
                                        class="block py-3 px-0 w-full text-base text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                        placeholder=" "
                                        value="{{ old('phone', auth()->user()->phone_number ?? '') }}" />
                                    <label for="phone"
                                        class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                        Phone Number
                                    </label>
                                    @error('phone') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div class="relative z-0 w-full group">
                                    <input type="email" name="email" id="email"
                                        class="block py-3 px-0 w-full text-base text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                        placeholder=" " value="{{ old('email', auth()->user()->email ?? '') }}" />
                                    <label for="email"
                                        class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                        Email (Optional)
                                    </label>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="relative z-0 w-full group">
                                <textarea name="address" id="address" rows="2" required
                                    class="block py-3 px-0 w-full text-base text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer resize-none"
                                    placeholder=" ">{{ old('address') }}</textarea>
                                <label for="address"
                                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                    Delivery Address
                                </label>
                                @error('address') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Note --}}
                            <div class="relative z-0 w-full group">
                                <input type="text" name="note" id="note"
                                    class="block py-3 px-0 w-full text-base text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                    placeholder=" " value="{{ old('note') }}" />
                                <label for="note"
                                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                    Order Note (Optional)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Payment Method (Visual Only) --}}
                    <div>
                        <h2
                            class="text-lg font-bold uppercase tracking-widest mb-8 border-b border-black pb-2 inline-block">
                            Payment Method</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label
                                class="relative border border-neutral-200 p-4 cursor-pointer hover:border-black transition group">
                                <input type="radio" name="payment_method" value="cod" checked class="peer sr-only">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold uppercase tracking-wide group-hover:text-black">Cash
                                        on Delivery</span>
                                    <div
                                        class="w-4 h-4 rounded-full border border-neutral-300 peer-checked:bg-black peer-checked:border-black">
                                    </div>
                                </div>
                                <p class="text-xs text-neutral-500 mt-2">Pay in cash when you receive your order.</p>
                                {{-- Selected Border --}}
                                <div
                                    class="absolute inset-0 border-2 border-black opacity-0 peer-checked:opacity-100 pointer-events-none">
                                </div>
                            </label>

                            <label
                                class="relative border border-neutral-200 p-4 cursor-pointer hover:border-black transition group">
                                <input type="radio" name="payment_method" value="banking" class="peer sr-only">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold uppercase tracking-wide group-hover:text-black">Bank
                                        Transfer</span>
                                    <div
                                        class="w-4 h-4 rounded-full border border-neutral-300 peer-checked:bg-black peer-checked:border-black">
                                    </div>
                                </div>
                                <p class="text-xs text-neutral-500 mt-2">Transfer via QR Code (VietQR).</p>
                                <div
                                    class="absolute inset-0 border-2 border-black opacity-0 peer-checked:opacity-100 pointer-events-none">
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: ORDER SUMMARY (STICKY) --}}
                <div class="lg:col-span-5 lg:sticky lg:top-32 bg-neutral-50 p-8">
                    <h2 class="text-lg font-bold uppercase tracking-widest mb-6">Your Order</h2>

                    {{-- Items List --}}
                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar mb-6">
                        @foreach($cart as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-20 bg-neutral-200 flex-shrink-0 relative overflow-hidden">
                                <img src="{{ Storage::url('products/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                    class="w-full h-full object-cover">
                                <span
                                    class="absolute top-0 right-0 bg-black text-white text-[9px] w-5 h-5 flex items-center justify-center font-bold">
                                    {{ $item['quantity'] }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold uppercase tracking-wide line-clamp-1">{{ $item['name'] }}
                                </h3>
                                @if(isset($item['size']))
                                <p class="text-[10px] text-neutral-500 uppercase tracking-widest">{{ $item['size'] }}
                                    @if(isset($item['color'])) / {{ $item['color'] }} @endif</p>
                                @endif
                                <p class="text-sm mt-1">₫{{ number_format((float)$item['price'] *
                                    (int)$item['quantity'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Calculations --}}
                    <div class="border-t border-neutral-200 pt-6 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-600">Subtotal</span>
                            <span class="font-medium">₫{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-600">Shipping</span>
                            <span class="text-xs uppercase font-bold tracking-widest">Free</span>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="border-t border-neutral-200 pt-6 mt-6 mb-8">
                        <div class="flex justify-between items-end">
                            <span class="text-base font-bold uppercase tracking-widest">Total</span>
                            <span class="text-2xl font-bold">₫{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="block w-full py-4 bg-black text-white text-center font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                        Place Order
                    </button>

                    <div class="mt-6 text-center">
                        <a href="{{ route('cart.index') }}"
                            class="text-xs text-neutral-500 hover:text-black underline underline-offset-4">Modify
                            Cart</a>
                    </div>

                    {{-- Security Badge --}}
                    <div
                        class="mt-8 pt-6 border-t border-neutral-200 flex items-center justify-center gap-2 text-neutral-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="text-[10px] uppercase tracking-widest">Secure SSL Encryption</span>
                    </div>
                </div>

            </form>
            @endif
        </div>
    </main>
</x-app-layout>