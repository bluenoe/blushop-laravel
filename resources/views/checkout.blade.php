<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">

        {{-- Flash Messages --}}
        @if(session('success') || session('warning') || $errors->any())
        <div class="fixed top-20 right-6 z-50 max-w-sm w-full space-y-2 pointer-events-none">
            @if(session('success'))
            <div class="pointer-events-auto p-4 bg-black text-white text-sm shadow-xl flex items-center gap-3">
                <svg class="w-4 h-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div
                class="pointer-events-auto p-4 bg-red-50 text-red-600 border border-red-100 text-sm shadow-xl font-medium">
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
                    class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition">Continue
                    Shopping</a>
            </div>
            @else

            {{-- MAIN FORM --}}
            <form action="{{ route('checkout.place') }}" method="POST" novalidate
                class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-start" x-data="{ paymentMethod: 'cod' }">
                @csrf

                {{-- LEFT: SHIPPING INFO --}}
                <div class="lg:col-span-7 space-y-16">

                    {{-- 1. Contact Info --}}
                    <div>
                        <h2
                            class="text-lg font-bold uppercase tracking-widest mb-8 border-b border-black pb-2 inline-block">
                            Shipping Information</h2>

                        <div class="space-y-6">
                            {{-- FULL NAME (Floating Label) --}}
                            <div class="relative z-0 w-full group">
                                <input type="text" name="name" id="name" required
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 
                                    {{ $errors->has('name') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}"
                                    placeholder=" " value="{{ old('name', auth()->user()->name ?? '') }}" />

                                <label for="name"
                                    class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                                    {{ $errors->has('name') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                    Full Name
                                </label>
                                @error('name') <p
                                    class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                    {{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                {{-- PHONE NUMBER (Floating Label) --}}
                                <div class="relative z-0 w-full group">
                                    <input type="tel" name="phone" id="phone" required
                                        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 
                                        {{ $errors->has('phone') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}"
                                        placeholder=" "
                                        value="{{ old('phone', auth()->user()->phone_number ?? '') }}" />

                                    <label for="phone"
                                        class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                                        {{ $errors->has('phone') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                        Phone Number
                                    </label>
                                    @error('phone') <p
                                        class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                        {{ $message }}</p> @enderror
                                </div>

                                {{-- EMAIL (Floating Label) --}}
                                <div class="relative z-0 w-full group">
                                    <input type="email" name="email" id="email"
                                        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 
                                        {{ $errors->has('email') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}"
                                        placeholder=" " value="{{ old('email', auth()->user()->email ?? '') }}" />

                                    <label for="email"
                                        class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                                        {{ $errors->has('email') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                        Email (Optional)
                                    </label>
                                </div>
                            </div>

                            {{-- ADDRESS (Floating Label - Textarea) --}}
                            <div class="relative z-0 w-full group">
                                <textarea name="address" id="address" rows="2" required
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer resize-none transition-colors duration-200 
                                    {{ $errors->has('address') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}"
                                    placeholder=" ">{{ old('address') }}</textarea>

                                <label for="address"
                                    class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                                    {{ $errors->has('address') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                    Delivery Address
                                </label>
                                @error('address') <p
                                    class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                    {{ $message }}</p> @enderror
                            </div>

                            {{-- NOTE (Floating Label) --}}
                            <div class="relative z-0 w-full group">
                                <input type="text" name="note" id="note"
                                    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 border-neutral-300 focus:border-black text-neutral-900"
                                    placeholder=" " value="{{ old('note') }}" />

                                <label for="note"
                                    class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest text-neutral-500 peer-focus:text-black">
                                    Order Note (Optional)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Payment Method --}}
                    <div>
                        <h2
                            class="text-lg font-bold uppercase tracking-widest mb-8 border-b border-black pb-2 inline-block">
                            Payment Method</h2>

                        <div class="space-y-4">
                            {{-- Option 1: COD --}}
                            <label class="relative border p-6 cursor-pointer transition-all duration-300 group block"
                                :class="paymentMethod === 'cod' ? 'border-black bg-neutral-50' : 'border-neutral-200 hover:border-neutral-400'">

                                <input type="radio" name="payment_method" value="cod" class="sr-only"
                                    x-model="paymentMethod">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                            :class="paymentMethod === 'cod' ? 'border-black' : 'border-neutral-300'">
                                            <div class="w-2.5 h-2.5 rounded-full bg-black transform scale-0 transition-transform"
                                                :class="paymentMethod === 'cod' ? 'scale-100' : ''"></div>
                                        </div>
                                        <span class="text-sm font-bold uppercase tracking-widest">Cash on
                                            Delivery</span>
                                    </div>
                                    {{-- Icon Mới: Banknote tối giản --}}
                                    <svg class="w-6 h-6 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="pl-9 mt-2 text-xs text-neutral-500 font-light"
                                    x-show="paymentMethod === 'cod'" x-collapse>
                                    Pay in cash upon delivery. No extra fees.
                                </div>
                            </label>

                            {{-- Option 2: Bank Transfer --}}
                            <label class="relative border p-6 cursor-pointer transition-all duration-300 group block"
                                :class="paymentMethod === 'banking' ? 'border-black bg-neutral-50' : 'border-neutral-200 hover:border-neutral-400'">

                                <input type="radio" name="payment_method" value="banking" class="sr-only"
                                    x-model="paymentMethod">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors"
                                            :class="paymentMethod === 'banking' ? 'border-black' : 'border-neutral-300'">
                                            <div class="w-2.5 h-2.5 rounded-full bg-black transform scale-0 transition-transform"
                                                :class="paymentMethod === 'banking' ? 'scale-100' : ''"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold uppercase tracking-widest">Bank Transfer
                                                (VietQR)</span>
                                            <span
                                                class="text-[9px] text-green-600 font-bold uppercase tracking-wide mt-0.5">Instant
                                                Confirmation</span>
                                        </div>
                                    </div>
                                    {{-- Icon Mới: QR Code tối giản --}}
                                    <svg class="w-6 h-6 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                    </svg>
                                </div>

                                {{-- SLIDE DOWN QR CODE --}}
                                <div class="pl-0 md:pl-9 mt-4" x-show="paymentMethod === 'banking'" x-collapse>
                                    <div
                                        class="bg-white border border-neutral-200 p-4 rounded-sm flex flex-col md:flex-row gap-6 items-center">
                                        <div class="w-32 h-32 flex-shrink-0 bg-neutral-100 p-1">
                                            <img src="https://img.vietqr.io/image/MB-0000000000-compact2.jpg?amount={{ $total }}&addInfo=BLUSHOP%20ORDER&accountName=BLU%20SHOP"
                                                alt="VietQR Payment" class="w-full h-full object-contain">
                                        </div>
                                        <div class="flex-1 space-y-2 text-xs w-full">
                                            <p
                                                class="font-bold text-neutral-900 uppercase tracking-wide border-b border-neutral-100 pb-2 mb-2">
                                                Transfer Details</p>
                                            <div class="flex justify-between"><span
                                                    class="text-neutral-500">Bank:</span><span class="font-bold">MB
                                                    Bank</span></div>
                                            <div class="flex justify-between"><span
                                                    class="text-neutral-500">Account:</span><span
                                                    class="font-bold select-all font-mono">0000 0000 0000</span></div>
                                            <div class="flex justify-between"><span
                                                    class="text-neutral-500">Name:</span><span class="font-bold">BLU
                                                    SHOP</span></div>
                                            <div class="flex justify-between"><span
                                                    class="text-neutral-500">Content:</span><span
                                                    class="font-bold text-black select-all">BLUSHOP ORDER</span></div>
                                            <div class="pt-2 text-[10px] text-neutral-400 italic">* Scan QR or transfer
                                                manually. Order will be processed immediately.</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: ORDER SUMMARY (STICKY) --}}
                <div class="lg:col-span-5 lg:sticky lg:top-32 bg-neutral-50 p-8">
                    <h2 class="text-lg font-bold uppercase tracking-widest mb-6">Your Order</h2>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar mb-6">
                        @foreach($cart as $item)
                        <div class="flex gap-4 group">
                            <div class="w-16 h-20 bg-neutral-200 flex-shrink-0 relative overflow-hidden">
                                <img src="{{ Storage::url('products/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                <span
                                    class="absolute top-0 right-0 bg-black text-white text-[9px] w-5 h-5 flex items-center justify-center font-bold">{{
                                    $item['quantity'] }}</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-bold uppercase tracking-wide line-clamp-1">{{ $item['name'] }}
                                </h3>
                                @if(isset($item['size']))
                                <p class="text-[10px] text-neutral-500 uppercase tracking-widest">{{ $item['size'] }}
                                    @if(isset($item['color'])) / {{ $item['color'] }} @endif</p>
                                @endif
                                <p class="text-sm mt-1 font-medium">₫{{ number_format((float)$item['price'] *
                                    (int)$item['quantity'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-neutral-200 pt-6 space-y-2">
                        <div class="flex justify-between text-sm"><span class="text-neutral-600">Subtotal</span><span
                                class="font-medium">₫{{ number_format($total, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between text-sm"><span class="text-neutral-600">Shipping</span><span
                                class="text-xs uppercase font-bold tracking-widest bg-black text-white px-2 py-0.5">Free</span>
                        </div>
                    </div>

                    <div class="border-t border-black pt-6 mt-6 mb-8">
                        <div class="flex justify-between items-end">
                            <span class="text-base font-bold uppercase tracking-widest">Total</span>
                            <span class="text-2xl font-bold tracking-tight">₫{{ number_format($total, 0, ',', '.')
                                }}</span>
                        </div>
                        <p class="text-[10px] text-neutral-400 mt-2 text-right">Including VAT</p>
                    </div>

                    <button type="submit"
                        class="block w-full py-4 bg-black text-white text-center font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">Place
                        Order</button>

                    <div class="mt-6 text-center">
                        <a href="{{ route('cart.index') }}"
                            class="text-xs text-neutral-500 hover:text-black underline underline-offset-4">Modify
                            Cart</a>
                    </div>

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