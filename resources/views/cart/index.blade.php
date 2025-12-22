{{--
═══════════════════════════════════════════════════════════════
BluShop Cart v5.0 - RowID Fix & Header Sync
Concept: Clean Product List, Sticky Summary Sidebar
Updated by Senior Mentor for rowId compatibility
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900" x-data="{
             total: '{{ number_format($total ?? 0, 0, ',', '.') }}',
             isEmpty: {{ empty($cart) ? 'true' : 'false' }},
             
             updateQty(rowId, newQty) {
                 if (newQty < 1) return;
                 
                 // Gửi request lên server
                 fetch('{{ route('cart.update') }}', {
                     method: 'PATCH',
                     headers: {
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     // LƯU Ý: Gửi 'rowId' chứ không phải 'id'
                     body: JSON.stringify({ rowId: rowId, quantity: newQty })
                 })
                 .then(res => res.json())
                 .then(data => {
                     if(data.success) {
                         // Cập nhật Subtotal của dòng đó (dùng rowId làm ID DOM)
                         // Escape ký tự đặc biệt trong rowId nếu cần, nhưng thường document.getElementById xử được
                         const subEl = document.getElementById('subtotal-' + rowId);
                         if(subEl) subEl.innerText = '₫' + data.item_subtotal;
                         
                         this.total = data.total;
                         
                         // CẬP NHẬT HEADER (Bắn sự kiện Global)
                         window.dispatchEvent(new CustomEvent('cart-updated', { 
                            detail: { count: data.cart_count } 
                         }));
                         
                         // Hiển thị thông báo (nếu có Toast component)
                         $dispatch('notify', { message: 'Quantity Updated' });
                     }
                 });
             },

             removeItem(rowId) {
                 if(!confirm('Remove this item?')) return;
                 
                 fetch('{{ route('cart.remove') }}', {
                     method: 'DELETE',
                     headers: {
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     // Gửi rowId để xóa đúng biến thể
                     body: JSON.stringify({ rowId: rowId })
                 })
                 .then(res => res.json())
                 .then(data => {
                     if(data.success) {
                         // Xóa dòng khỏi giao diện
                         const rowEl = document.getElementById('row-' + rowId);
                         if(rowEl) rowEl.remove();
                         
                         this.total = data.total;
                         this.isEmpty = data.is_empty;
                         
                         // CẬP NHẬT HEADER (Bắn sự kiện Global)
                         window.dispatchEvent(new CustomEvent('cart-updated', { 
                            detail: { count: data.cart_count } 
                         }));

                         $dispatch('notify', { message: 'Item Removed' });
                         
                         if(data.is_empty) window.location.reload();
                     }
                 });
             }
         }">

        <div class="max-w-[1400px] mx-auto px-6 py-12 lg:py-20">

            {{-- Header Cart: Chuẩn hóa chiều cao --}}
            <div class="mb-12">
                {{-- 1. Breadcrumb: Luôn nằm dòng riêng, padding cố định --}}
                <nav class="flex items-center gap-3 text-[10px] uppercase tracking-widest text-neutral-400 mb-4 h-5">
                    <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
                    <span class="text-neutral-300">/</span> {{-- Dùng dấu gạch chéo text cho gọn, đỡ lệch icon --}}
                    <span class="text-black font-bold">Cart</span>
                </nav>

                {{-- 2. Title & Border --}}
                <div class="flex items-end justify-between border-b border-neutral-100 pb-6">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tighter uppercase leading-none">
                        Shopping Bag
                    </h1>
                </div>
            </div>

            <template x-if="isEmpty">
                {{-- Giữ nguyên phần empty --}}
                <div class="py-24 text-center">
                    <p class="text-neutral-400 mb-6 text-lg font-light">Your bag is currently empty.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition">
                        Start Shopping
                    </a>
                </div>
            </template>

            <template x-if="!isEmpty">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24 items-start">

                    {{-- LEFT: PRODUCT LIST --}}
                    <div class="lg:col-span-7 space-y-8">
                        {{-- LƯU Ý: Key ở đây là $rowId (Ví dụ: 1_M_Black) --}}
                        @foreach($cart as $rowId => $item)
                        <div id="row-{{ $rowId }}"
                            class="flex gap-6 py-6 border-b border-neutral-100 last:border-0 group">

                            {{-- Image --}}
                            @php
                            // Build correct image path with slug
                            $slug = $item['slug'] ?? '';
                            $imgName = $item['image'] ?? null;
                            $imgSrc = 'https://placehold.co/128x160?text=No+Image';

                            if ($imgName && $slug) {
                            if (Str::startsWith($imgName, ['http://', 'https://'])) {
                            $imgSrc = $imgName;
                            } else {
                            $imgSrc = asset('storage/products/' . $slug . '/' . basename($imgName));
                            }
                            }
                            @endphp
                            <div
                                class="w-24 h-32 sm:w-32 sm:h-40 bg-neutral-100 flex-shrink-0 relative overflow-hidden">
                                {{-- Link về trang chi tiết thì phải dùng product_id gốc --}}
                                <a href="{{ route('products.show', $item['product_id'] ?? $item['id'] ?? 0) }}">
                                    <img src="{{ $imgSrc }}" alt="{{ $item['name'] }}"
                                        class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                                </a>
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-sm font-bold uppercase tracking-wide">
                                            <a href="{{ route('products.show', $item['product_id'] ?? $item['id'] ?? 0) }}"
                                                class="hover:underline">
                                                {{ $item['name'] }}
                                            </a>
                                        </h3>
                                        {{-- ID cho Subtotal cũng phải theo rowId --}}
                                        <span id="subtotal-{{ $rowId }}" class="text-sm font-medium">
                                            ₫{{ number_format((float)$item['price'] * (int)$item['quantity'], 0, ',',
                                            '.') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-neutral-500 mb-1">Price: ₫{{
                                        number_format((float)$item['price'], 0, ',', '.') }}</p>

                                    {{-- Hiển thị Size/Color nếu có --}}
                                    @if(isset($item['size']) && $item['size'] !== 'Freesize')
                                    <p class="text-xs text-neutral-500">Size: {{ $item['size'] }}</p>
                                    @endif
                                    @if(isset($item['color']) && $item['color'] !== 'Default')
                                    <p class="text-xs text-neutral-500">Color: {{ $item['color'] }}</p>
                                    @endif
                                </div>

                                <div class="flex justify-between items-end mt-4">
                                    {{-- Quantity Control (AJAX) --}}
                                    <div class="flex items-center border border-neutral-200"
                                        x-data="{ qty: {{ $item['quantity'] }} }">
                                        <button type="button"
                                            @click="qty > 1 ? qty-- : null; updateQty('{{ $rowId }}', qty)"
                                            class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:bg-neutral-50 transition"
                                            :disabled="qty <= 1">-</button>
                                        <span class="w-8 text-center text-sm font-medium" x-text="qty"></span>
                                        <button type="button" @click="qty++; updateQty('{{ $rowId }}', qty)"
                                            class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:bg-neutral-50 transition">+</button>
                                    </div>

                                    {{-- Remove (AJAX) - Using Event Delegation for reliability --}}
                                    <button type="button"
                                        class="js-remove-cart-item text-[10px] uppercase tracking-widest text-neutral-400 hover:text-red-600 underline transition"
                                        data-rowid="{{ $rowId }}">
                                        Remove
                                    </button>
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

                    {{-- RIGHT: SUMMARY --}}
                    <div class="lg:col-span-5 lg:sticky lg:top-32 space-y-8 bg-neutral-50 p-8">
                        <h2 class="text-lg font-bold uppercase tracking-widest mb-6">Order Summary</h2>

                        <div class="space-y-4 text-sm text-neutral-600">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-medium" x-text="'₫' + total"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping estimate</span>
                                <span class="text-neutral-400">Calculated at checkout</span>
                            </div>
                        </div>

                        <div class="border-t border-neutral-200 pt-6 mt-6">
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-base font-bold uppercase tracking-widest">Total</span>
                                <span class="text-xl font-bold" x-text="'₫' + total"></span>
                            </div>
                            <p class="text-[10px] text-neutral-400 mt-1">Including VAT</p>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                            class="block w-full py-4 bg-black text-white text-center font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                            Proceed to Checkout
                        </a>

                        {{-- Payment Icons (Fixed & Synced) --}}
                        <div class="mt-8 pt-6 border-t border-neutral-200">
                            <p class="text-[10px] text-center uppercase tracking-widest text-neutral-400 mb-4">We Accept
                            </p>
                            <div class="flex justify-center gap-2">
                                {{-- Visa Card --}}
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
            </template>
        </div>
    </main>
    {{-- Vanilla JS Event Delegation for Remove Button (Fallback for Alpine scope issues) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('🟢 Cart JS Loaded - Event Delegation Active');

            // Event Delegation: Listen on document, filter by class
            document.body.addEventListener('click', function (e) {
                const btn = e.target.closest('.js-remove-cart-item');
                if (!btn) return;

                e.preventDefault();
                e.stopPropagation();

                const rowId = btn.dataset.rowid;
                console.log('🔴 Remove clicked! rowId:', rowId);

                // Skip confirm (browser blocking it) - just delete directly
                console.log('🔴 Sending DELETE request...');

                fetch('{{ route("cart.remove") }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ rowId: rowId })
                })
                    .then(res => {
                        console.log('🔴 Response status:', res.status);
                        if (!res.ok) throw new Error('Server error: ' + res.status);
                        return res.json();
                    })
                    .then(data => {
                        console.log('🔴 Response data:', data);
                        if (data.success) {
                            // Remove row from DOM
                            const rowEl = document.getElementById('row-' + rowId);
                            if (rowEl) {
                                rowEl.style.transition = 'opacity 0.3s, transform 0.3s';
                                rowEl.style.opacity = '0';
                                rowEl.style.transform = 'translateX(-20px)';
                                setTimeout(() => rowEl.remove(), 300);
                            }

                            // Update cart header via custom event
                            window.dispatchEvent(new CustomEvent('cart-updated', {
                                detail: { count: data.cart_count }
                            }));

                            // Reload if cart is empty
                            if (data.is_empty) {
                                setTimeout(() => window.location.reload(), 500);
                            }
                        } else {
                            alert('Failed to remove item');
                        }
                    })
                    .catch(err => {
                        console.error('🔴 Error:', err);
                        alert('Network error: ' + err.message);
                    });
            });
        });
    </script>
</x-app-layout>