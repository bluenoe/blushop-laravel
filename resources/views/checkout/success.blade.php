{{--
═══════════════════════════════════════════════════════════════
BluShop Success Page v2 - Digital Receipt Concept
Concept: High Contrast, Monospace Data, Editorial Typography
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white text-neutral-900 min-h-screen">

        <div class="max-w-[1400px] mx-auto px-6 pt-24 pb-20 lg:pt-32">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-start">

                {{-- LEFT COLUMN: EMOTIONAL CONFIRMATION --}}
                <div class="lg:col-span-7 space-y-12" data-reveal>
                    {{-- Status Badge --}}
                    <div class="inline-flex items-center gap-2 border border-black px-4 py-2 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Order Confirmed</span>
                    </div>

                    {{-- Big Statement --}}
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold tracking-tighter leading-[0.9]">
                        Thank You, <br>
                        <span class="font-serif italic font-light text-neutral-500 ml-2">{{ explode(' ',
                            $order->user->name ?? 'Customer')[0] }}.</span>
                    </h1>

                    <p
                        class="text-lg md:text-xl font-light text-neutral-600 max-w-lg leading-relaxed border-l-2 border-black pl-6">
                        We've received your order. You will receive an automated email notification with tracking
                        information once your package has been dispatched.
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center px-10 py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-1">
                            Continue Shopping
                        </a>
                        <a href="{{ route('orders.index') }}"
                            class="inline-flex items-center justify-center px-10 py-4 border border-neutral-200 text-neutral-900 text-xs font-bold uppercase tracking-widest hover:border-black hover:bg-neutral-50 transition">
                            View Order History
                        </a>
                    </div>
                </div>

                {{-- RIGHT COLUMN: DIGITAL RECEIPT (THE "INVOICE") --}}
                <div class="lg:col-span-5 bg-neutral-50 p-8 md:p-10 border border-neutral-100 relative" data-reveal
                    style="transition-delay: 200ms">

                    {{-- Receipt Header --}}
                    <div class="flex justify-between items-end mb-8 border-b border-neutral-200 pb-6">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 mb-1">Order Reference</p>
                            <p class="text-2xl font-mono font-bold tracking-tight">#{{ $order->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 mb-1">Date</p>
                            <p class="text-sm font-mono">{{ $order->created_at->format('d.m.Y') }}</p>
                        </div>
                    </div>

                    {{-- Shipping Info --}}
                    <div class="mb-10 space-y-6">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 mb-2">Shipping To</p>
                            <p class="text-sm font-medium">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-sm text-neutral-500 font-light mt-1">{{ $order->shipping_address }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 mb-2">Contact</p>
                            <p class="text-sm font-mono text-neutral-600">{{ $order->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Item Summary (Collapsed View) --}}
                    <div class="space-y-4 mb-8">
                        <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 mb-4">Items Summary</p>

                        {{-- Chỉ hiện tối đa 3 sản phẩm để giữ layout đẹp --}}
                        @foreach($order->orderItems->take(3) as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-16 bg-white border border-neutral-100 overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->image)
                                <img src="{{ Storage::url('products/' . $item->product->image) }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-neutral-100 text-[8px]">
                                    IMG</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold truncate">{{ $item->product->name ?? 'Product Item' }}</p>
                                <p class="text-xs text-neutral-500 font-mono">Qty: {{ $item->quantity }}</p>
                            </div>
                            <p class="text-sm font-mono">₫{{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                        </div>
                        @endforeach

                        @if($order->orderItems->count() > 3)
                        <p class="text-xs text-neutral-400 italic text-center pt-2">+ {{ $order->orderItems->count() - 3
                            }} more items...</p>
                        @endif
                    </div>

                    {{-- Total Block --}}
                    <div class="border-t border-dashed border-neutral-300 pt-6">
                        <div class="flex justify-between items-end">
                            <span class="text-sm font-bold uppercase tracking-widest">Total Paid</span>
                            <span class="text-2xl font-mono font-bold">₫{{ number_format($order->total_amount, 0, ',',
                                '.') }}</span>
                        </div>
                    </div>

                    {{-- Decoration: Barcode (Fake visual) --}}
                    <div class="mt-10 pt-6 border-t border-neutral-100">
                        <div
                            class="h-8 w-full bg-[url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAQBAMAAAC8xVNFAAAABlBMVEX///8AAABVwtN+AAAAAnRSTlMA/1uRIrUAAAA2SURBVCjPY2AgCjAwMDBwcDBwQnAAhRkYOIB8BoxkIDA0MDAQMCDKMRJpECPJIEZSjCSLhgAAXb4F0W53uMcAAAAASUVORK5CYII=')] bg-repeat-x opacity-20">
                        </div>
                        <p class="text-[10px] text-center font-mono text-neutral-300 mt-2 tracking-[0.5em]">{{
                            $order->id }}</p>
                    </div>

                </div>

            </div>
        </div>

    </main>

    {{-- Script Reveal Effect --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Hiệu ứng xuất hiện từ từ giống trang Home
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-1000', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>