<x-admin-layout>
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.orders.index') }}"
                class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition mb-2 block">
                &larr; Back to Orders
            </a>
            <h1 class="text-3xl font-bold tracking-tighter">Order #{{ $order->id }}</h1>
            <p class="text-xs text-neutral-400 font-mono mt-1">{{ $order->created_at->format('F j, Y \a\t H:i') }}</p>
        </div>

        {{-- Print Action --}}
        <button onclick="window.print()"
            class="hidden md:inline-flex items-center gap-2 px-4 py-2 border border-neutral-200 text-xs font-bold uppercase tracking-widest hover:bg-neutral-50 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Invoice
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        {{-- LEFT: ITEMS LIST --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="border-t border-neutral-200 pt-8">
                <h2 class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-6">Line Items</h2>

                <div class="space-y-6">
                    {{-- SỬA: Dùng orderItems thay vì items --}}
                    @foreach($order->orderItems as $item)
                    <div class="flex gap-6 items-start">
                        {{-- Image --}}
                        <div class="w-20 h-24 bg-neutral-100 flex-shrink-0 overflow-hidden">
                            @php
                            $itemSlug = $item->product->slug ?? '';
                            $itemImg = $item->product->image ?? null;
                            $itemImgSrc = 'https://placehold.co/100x120?text=No+Image';

                            if ($itemSlug && $itemImg) {
                            if (Str::startsWith($itemImg, ['http://', 'https://'])) {
                            $itemImgSrc = $itemImg;
                            } else {
                            $itemImgSrc = asset('storage/products/' . $itemSlug . '/' . basename($itemImg));
                            }
                            }
                            @endphp
                            <img src="{{ $itemImgSrc }}" class="w-full h-full object-cover"
                                onerror="this.src='https://placehold.co/100x120?text=No+Image'">
                        </div>

                        {{-- Info --}}
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-neutral-900">{{ $item->product->name ?? 'Unknown Item' }}
                                    </h3>
                                    <p class="text-xs text-neutral-500 mt-1 font-mono">
                                        {{-- SỬA: price_at_purchase --}}
                                        {{ number_format($item->price_at_purchase, 0, ',', '.') }} ₫ &times; {{
                                        $item->quantity }}
                                    </p>
                                    @if($item->size)
                                    <p class="text-xs text-neutral-400 mt-1">Size: {{ $item->size }}</p>
                                    @endif
                                </div>
                                <p class="font-mono font-medium text-neutral-900">
                                    {{-- SỬA: Tính tổng tiền --}}
                                    {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }} ₫
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Summary --}}
                <div class="mt-12 border-t border-dashed border-neutral-200 pt-6 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-500">Subtotal</span>
                        {{-- SỬA: total_amount --}}
                        <span class="font-mono">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-500">Shipping</span>
                        <span class="font-mono">Free</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold mt-4 pt-4 border-t border-neutral-200">
                        <span>Total</span>
                        {{-- SỬA: total_amount --}}
                        <span>{{ number_format($order->total_amount, 0, ',', '.') }} ₫</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: CUSTOMER & ACTIONS --}}
        <div class="space-y-8">

            {{-- Status Control Panel --}}
            <div class="bg-neutral-50 p-6 border border-neutral-100">
                <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-4">Fulfillment</h3>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    <label class="block mb-2 text-sm font-medium">Update Status</label>
                    <div class="flex gap-2">
                        <select name="status"
                            class="flex-1 bg-white border border-neutral-300 text-sm py-2 px-3 focus:border-black focus:ring-0 cursor-pointer">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-black text-white text-xs font-bold uppercase px-4 py-2 hover:bg-neutral-800 transition">
                            Update
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-neutral-200/50">
                    <p class="text-xs text-neutral-400 mb-2">Current Status</p>
                    @php
                    $colors = [
                    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                    'completed' => 'bg-green-50 text-green-700 border-green-200',
                    'cancelled' => 'bg-neutral-100 text-neutral-500 border-neutral-200',
                    ];
                    $statusClass = $colors[$order->status] ?? 'bg-white text-neutral-900 border-neutral-200';
                    @endphp
                    <span
                        class="inline-block px-3 py-1 border text-[10px] font-bold uppercase tracking-wider rounded-sm {{ $statusClass }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            {{-- Customer Info --}}
            <div>
                <h3
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-4 border-b border-neutral-100 pb-2">
                    Customer</h3>
                <div class="space-y-1">
                    <p class="font-bold text-lg">{{ $order->user->name ?? 'Guest' }}</p>
                    <p class="text-sm text-neutral-500">{{ $order->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div>
                <h3
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-4 border-b border-neutral-100 pb-2">
                    Shipping To</h3>
                <p class="text-sm text-neutral-600 leading-relaxed">
                    {{ $order->shipping_address ?? 'No Address Provided' }}
                </p>
            </div>

        </div>
    </div>
</x-admin-layout>