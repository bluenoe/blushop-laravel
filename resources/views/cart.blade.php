{{--
═══════════════════════════════════════════════════════════════
BluShop Cart v4 - AJAX & Auto-Hide Notification
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900" x-data="{
              total: '{{ number_format($total ?? 0, 0, ',', '.') }}',
              isEmpty: {{ empty($cart) ? 'true' : 'false' }},
              
              updateQty(id, newQty) {
                  if (newQty < 1) return;
                  fetch('{{ route('cart.update') }}', {
                      method: 'PATCH',
                      headers: {
                          'Content-Type': 'application/json',
                          'Accept': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({ id: id, quantity: newQty })
                  })
                  .then(res => res.json())
                  .then(data => {
                      if(data.success) {
                          // Cập nhật DOM trực tiếp
                          document.getElementById('subtotal-'+id).innerText = '₫' + data.item_subtotal;
                          this.total = data.total;
                          $dispatch('notify', { message: 'Quantity Updated' });
                      }
                  });
              },

              removeItem(id) {
                  if(!confirm('Remove this item?')) return;
                  fetch('{{ route('cart.remove') }}', {
                      method: 'DELETE',
                      headers: {
                          'Content-Type': 'application/json',
                          'Accept': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({ id: id })
                  })
                  .then(res => res.json())
                  .then(data => {
                      if(data.success) {
                          // Xóa dòng đó khỏi giao diện
                          document.getElementById('row-'+id).remove();
                          this.total = data.total;
                          this.isEmpty = data.is_empty;
                          $dispatch('notify', { message: 'Item Removed' });
                          
                          // Nếu giỏ trống thì reload để hiện Empty State
                          if(data.is_empty) window.location.reload();
                      }
                  });
              }
          }">

        <div class="max-w-[1400px] mx-auto px-6 py-12 lg:py-20">

            {{-- Header --}}
            <div class="mb-12 flex items-baseline justify-between border-b border-neutral-100 pb-6">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tighter uppercase">Shopping Bag</h1>
            </div>

            <template x-if="isEmpty">
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
                        @foreach($cart as $id => $item)
                        <div id="row-{{ $id }}" class="flex gap-6 py-6 border-b border-neutral-100 last:border-0 group">
                            {{-- Image --}}
                            <div
                                class="w-24 h-32 sm:w-32 sm:h-40 bg-neutral-100 flex-shrink-0 relative overflow-hidden">
                                <a href="{{ route('products.show', $id) }}">
                                    <img src="{{ Storage::url('products/' . $item['image']) }}"
                                        alt="{{ $item['name'] }}"
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
                                        {{-- Subtotal: ID để JS cập nhật --}}
                                        <span id="subtotal-{{ $id }}" class="text-sm font-medium">
                                            ₫{{ number_format((float)$item['price'] * (int)$item['quantity'], 0, ',',
                                            '.') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-neutral-500 mb-1">Price: ₫{{
                                        number_format((float)$item['price'], 0, ',', '.') }}</p>
                                    @if(isset($item['size'])) <p class="text-xs text-neutral-500">Size: {{ $item['size']
                                        }}</p> @endif
                                </div>

                                <div class="flex justify-between items-end mt-4">
                                    {{-- Quantity Control (AJAX) --}}
                                    <div class="flex items-center border border-neutral-200"
                                        x-data="{ qty: {{ $item['quantity'] }} }">
                                        <button type="button"
                                            @click="qty > 1 ? qty-- : null; updateQty('{{ $id }}', qty)"
                                            class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:bg-neutral-50 transition"
                                            :disabled="qty <= 1">-</button>
                                        <span class="w-8 text-center text-sm font-medium" x-text="qty"></span>
                                        <button type="button" @click="qty++; updateQty('{{ $id }}', qty)"
                                            class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:bg-neutral-50 transition">+</button>
                                    </div>

                                    {{-- Remove (AJAX) --}}
                                    <button type="button" @click="removeItem('{{ $id }}')"
                                        class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-red-600 underline transition">
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
                                {{-- Total: Bind với Alpine data --}}
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

                        {{-- Payment Icons (Giữ nguyên phần icon cũ bà đã fix) --}}
                        <div
                            class="flex justify-center gap-2 pt-6 border-t border-neutral-200 opacity-60 grayscale hover:grayscale-0 transition">
                            {{-- ... (Code SVG Icon Visa/Mastercard cũ của bà) ... --}}
                            <svg class="h-6" viewBox="0 0 38 24" fill="none">
                                <path
                                    d="M35 0H3C1.3 0 0 1.3 0 3V21C0 22.7 1.3 24 3 24H35C36.7 24 38 22.7 38 21V3C38 1.3 36.7 0 35 0Z"
                                    fill="#2566AF" />
                                <path
                                    d="M12.9 14.5L14.7 4.1H18.2L16.4 14.5H12.9ZM22.3 9.4C22.3 6.9 19 6.7 19 5.8C19 5.5 19.3 5.3 20 5.2C20.3 5.2 21.3 5.2 22.3 5.7L22.7 3.5C22.1 3.3 21.3 3.1 20.3 3.1C17.6 3.1 15.6 4.5 15.6 6.6C15.6 9.4 19.5 9.5 19.5 10.7C19.5 11.1 19.1 11.4 18.2 11.4C17.1 11.4 16.5 11.2 16 11L15.5 13.2C16.1 13.5 17.2 13.7 18.3 13.7C21.1 13.7 22.3 12.3 22.3 9.4ZM28.5 14.5H31.4L29.5 4.1H26.6C26 4.1 25.5 4.4 25.3 5L21.6 14.5H25.1L25.8 12.5H29.1L29.4 14.5ZM26.7 10L27.6 7.4L28.4 10H26.7ZM10.5 4.1L8.3 10.1C8.1 10.6 8 10.7 7.7 10.8C7.4 10.9 6.8 11 6.2 11H5L5.2 11.4C6.5 13.8 8.4 14.5 11.1 14.5H14.1L10.5 4.1Z"
                                    fill="white" />
                            </svg>
                            <svg class="h-6" viewBox="0 0 38 24" fill="none">
                                <path
                                    d="M35 0H3C1.3 0 0 1.3 0 3V21C0 22.7 1.3 24 3 24H35C36.7 24 38 22.7 38 21V3C38 1.3 36.7 0 35 0Z"
                                    fill="#1A1F71" />
                                <path
                                    d="M12.9 15.3H8.3C7.9 15.3 7.6 15 7.6 14.6V9.4C7.6 9 7.9 8.7 8.3 8.7H12.9V15.3ZM20.6 8.7C18.6 8.7 17.1 9.6 16.2 10.8V15.3H19.2V11.8C19.2 11.2 19.7 10.8 20.3 10.8H21.5V8.7H20.6ZM25.5 8.7H23.3V15.3H26.3V8.7H25.5ZM24.4 7.6C25.3 7.6 26.1 6.8 26.1 5.9C26.1 5 25.3 4.2 24.4 4.2C23.5 4.2 22.7 5 22.7 5.9C22.7 6.8 23.5 7.6 24.4 7.6ZM30.9 13.1C30.9 12.3 30.6 11.7 30 11.3C29.6 11 29.1 10.9 28.7 10.9C28.2 10.9 27.8 11 27.4 11.2V8.7H24.4V15.3H27.4V12.8C27.4 12.4 27.6 12 28 12C28.4 12 28.6 12.3 28.6 12.7V15.3H31.6V12.4C31.6 12.4 31.6 13.1 30.9 13.1Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>

                </div>
            </template>
        </div>
    </main>
</x-app-layout>