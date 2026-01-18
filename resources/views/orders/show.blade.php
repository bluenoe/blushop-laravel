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
                        <span class="px-3 py-1 border border-neutral-200 bg-neutral-50 text-[10px] font-bold uppercase tracking-wider rounded-full
                            @if($order->status === 'cancelled') bg-red-50 border-red-200 text-red-600 @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                    <p class="text-sm text-neutral-500 font-light">
                        Placed on <span class="text-black font-medium">{{ $order->created_at->format('F d, Y') }}</span>
                        at {{ $order->created_at->format('H:i') }}
                    </p>
                    @if($order->status === 'cancelled' && $order->cancellation_reason)
                    <p class="text-sm text-red-600 mt-2">
                        <span class="font-medium">Reason:</span> {{ $order->cancellation_reason }}
                    </p>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    @if($order->isCancellable())
                    <button x-data @click="$dispatch('open-cancel-modal')"
                        class="inline-flex items-center gap-2 px-6 py-3 border border-red-200 text-red-600 text-[10px] font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white hover:border-red-600 transition">
                        Cancel Order
                    </button>
                    @endif
                    <button onclick="window.print()"
                        class="hidden md:inline-flex items-center gap-2 px-6 py-3 border border-neutral-200 text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border-black transition">
                        Print Invoice
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-24">

                {{-- LEFT: ITEMS LIST --}}
                <div class="md:col-span-8 space-y-8">
                    @foreach($order->orderItems as $item)
                    <div class="flex gap-6 group">
                        {{-- Image --}}
                        <div class="w-24 h-32 bg-neutral-100 flex-shrink-0 overflow-hidden relative">
                            @php
                            $productRef = $item->product;
                            $slug = $productRef->slug ?? '';
                            $imgRaw = $productRef->image ?? null;
                            $detailImgSrc = 'https://placehold.co/96x128?text=No+Image';

                            if ($slug && $imgRaw) {
                            if (Str::startsWith($imgRaw, ['http://', 'https://'])) {
                            $detailImgSrc = $imgRaw;
                            } else {
                            $detailImgSrc = asset('storage/products/' . $slug . '/' . basename($imgRaw));
                            }
                            }
                            @endphp
                            <img src="{{ $detailImgSrc }}" alt="{{ $productRef->name ?? 'Product' }}"
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
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

        {{-- CANCEL ORDER MODAL --}}
        @if($order->isCancellable())
        <div x-data="{
                open: false,
                reason: '',
                reasonDetails: '',
                loading: false,
                error: '',
                reasons: [
                    'Đổi ý, không muốn mua nữa',
                    'Tìm thấy giá tốt hơn',
                    'Đặt trùng đơn hàng',
                    'Muốn thay đổi sản phẩm/size/màu',
                    'Thời gian giao hàng quá lâu',
                    'Khác'
                ],
                async submitCancel() {
                    if (!this.reason) {
                        this.error = 'Vui lòng chọn lý do hủy đơn hàng.';
                        return;
                    }
                    this.loading = true;
                    this.error = '';
                    
                    try {
                        const response = await fetch('{{ route('orders.cancel', $order) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                reason: this.reason,
                                reason_details: this.reasonDetails
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            window.location.reload();
                        } else {
                            this.error = data.message || 'Có lỗi xảy ra. Vui lòng thử lại.';
                        }
                    } catch (err) {
                        this.error = 'Có lỗi xảy ra. Vui lòng thử lại.';
                    } finally {
                        this.loading = false;
                    }
                }
            }" @open-cancel-modal.window="open = true" x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center">
            {{-- Backdrop --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @click="open = false"
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

            {{-- Modal Content --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative bg-white w-full max-w-md mx-4 p-8 shadow-2xl">
                {{-- Close button --}}
                <button @click="open = false"
                    class="absolute top-4 right-4 text-neutral-400 hover:text-black transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                {{-- Header --}}
                <div class="mb-6">
                    <h2 class="text-xl font-bold tracking-tight">Hủy đơn hàng</h2>
                    <p class="text-sm text-neutral-500 mt-1">Bạn có chắc muốn hủy đơn hàng #{{ $order->id }}?</p>
                </div>

                {{-- Error Message --}}
                <div x-show="error" x-cloak
                    class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded">
                    <span x-text="error"></span>
                </div>

                {{-- Reason Select --}}
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 mb-2">
                        Lý do hủy đơn <span class="text-red-500">*</span>
                    </label>
                    <select x-model="reason"
                        class="w-full px-4 py-3 border border-neutral-200 text-sm focus:outline-none focus:border-black transition">
                        <option value="">-- Chọn lý do --</option>
                        <template x-for="r in reasons" :key="r">
                            <option :value="r" x-text="r"></option>
                        </template>
                    </select>
                </div>

                {{-- Details Textarea (shown when "Khác" is selected) --}}
                <div x-show="reason === 'Khác'" x-cloak class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 mb-2">
                        Chi tiết (tùy chọn)
                    </label>
                    <textarea x-model="reasonDetails" rows="3" maxlength="1000" placeholder="Nhập lý do cụ thể..."
                        class="w-full px-4 py-3 border border-neutral-200 text-sm focus:outline-none focus:border-black transition resize-none"></textarea>
                </div>

                {{-- Warning --}}
                <div class="mb-6 p-3 bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded">
                    <strong>Lưu ý:</strong> Sau khi hủy, đơn hàng sẽ không thể khôi phục.
                </div>

                {{-- Actions --}}
                <div class="flex gap-3">
                    <button @click="open = false"
                        class="flex-1 px-6 py-3 border border-neutral-200 text-[10px] font-bold uppercase tracking-widest hover:bg-neutral-100 transition">
                        Không, giữ lại
                    </button>
                    <button @click="submitCancel()" :disabled="loading"
                        class="flex-1 px-6 py-3 bg-red-600 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading">Xác nhận hủy</span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Đang xử lý...
                        </span>
                    </button>
                </div>
            </div>
        </div>
        @endif

    </main>
</x-app-layout>