{{--
═══════════════════════════════════════════════════════════════
BluShop Order Detail v2 - Digital Invoice
Concept: High Contrast Header, Clean Grid Line Items
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">

        <div class="max-w-5xl mx-auto px-6 py-20 lg:py-32">

            {{-- NAVIGATION --}}
            <div class="mb-12">
                <a href="{{ route('orders.index') }}"
                    class="group inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 hover:text-black transition">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    Back to History
                </a>
            </div>

            {{-- HEADER: BIG INFO --}}
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-16 border-b border-black pb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <h1 class="text-4xl md:text-6xl font-bold tracking-tighter">Order #{{ $order->id }}</h1>
                        <span
                            class="px-3 py-1 border border-neutral-200 bg-neutral-50 text-[10px] font-bold uppercase tracking-wider rounded-full">
                            {{ $order->status }}
                        </span>
                    </div>
                    <p class="text-sm text-neutral-500 font-light">
                        Placed on <span class="text-black font-medium">{{ $order->created_at->format('F d, Y') }}</span>
                        at {{ $order->created_at->format('H:i') }}
                    </p>
                </div>

                {{-- Action --}}
                <button onclick="window.print()"
                    class="hidden md:inline-flex items-center gap-2 px-6 py-3 border border-neutral-200 text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border-black transition">
                    Print Invoice
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-24">

                {{-- LEFT: ITEMS LIST --}}
                <div class="md:col-span-8 space-y-8">
                    @foreach($order->orderItems as $item)
                    <div class="flex gap-6 group">
                        {{-- Image --}}
                        <div class="w-24 h-32 bg-neutral-100 flex-shrink-0 overflow-hidden relative">
                            @if($item->product && $item->product->image)
                            <img src="{{ Storage::url('products/'.$item->product->image) }}"
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-neutral-300">N/A
                            </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 flex flex-col justify-between py-1">
                            <div>
                                <h3 class="text-sm font-bold uppercase tracking-wide mb-1">
                                    <a href="{{ route('products.show', $item->product_id) }}" class="hover:underline">
                                        {{ $item->product->name ?? 'Archived Product' }}
                                    </a>
                                </h3>
                                <div class="flex items-center gap-4 text-xs text-neutral-500 font-mono">
                                    <span>Size: {{ $item->size ?? 'OS' }}</span>
                                    <span>Qty: {{ $item->quantity }}</span>
                                </div>
                            </div>
                            <div class="text-sm font-mono font-medium">
                                ₫{{ number_format($item->price_at_purchase, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- RIGHT: SUMMARY & INFO --}}
                <div class="md:col-span-4 space-y-12">

                    {{-- Summary Box --}}
                    <div class="bg-neutral-50 p-8 border border-neutral-100">
                        <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-6">Summary</h3>

                        <div class="space-y-3 text-sm border-b border-dashed border-neutral-300 pb-6 mb-6">
                            <div class="flex justify-between">
                                <span class="text-neutral-500">Subtotal</span>
                                <span class="font-mono">₫{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-500">Shipping</span>
                                <span class="font-mono">Free</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end">
                            <span class="text-sm font-bold uppercase tracking-wide">Total</span>
                            <span class="text-xl font-bold font-mono">₫{{ number_format($order->total_amount, 0, ',',
                                '.') }}</span>
                        </div>
                    </div>

                    {{-- Address Info --}}
                    <div>
                        <h3
                            class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-4 border-b border-neutral-100 pb-2">
                            Shipping Details
                        </h3>
                        <div class="text-sm text-neutral-600 leading-relaxed font-light">
                            <p class="font-medium text-black mb-1">{{ Auth::user()->name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p class="mt-2 text-xs text-neutral-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    {{-- Support CTA --}}
                    <div class="pt-6">
                        <a href="{{ route('contact.index') }}"
                            class="text-xs text-neutral-400 hover:text-black underline underline-offset-4 decoration-1 transition">
                            Need help with this order?
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </main>
</x-app-layout>