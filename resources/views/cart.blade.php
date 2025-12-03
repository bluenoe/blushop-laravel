{{--
Cart page
UI-only Tailwind refresh to match landing page theme.
--}}

<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        {{-- Flash messages --}}
        <div>
            @if(session('success'))
            <div class="mb-3 rounded-md border border-green-200 bg-green-50 text-green-700 p-3">
                {{ session('success') }}
            </div>
            @endif
            @if(session('warning'))
            <div class="mb-3 rounded-md border border-yellow-200 bg-yellow-50 text-yellow-700 p-3">
                {{ session('warning') }}
            </div>
            @endif
        </div>

        <h2 class="text-2xl sm:text-3xl font-bold text-ink mb-6">Your Cart</h2>

        @php
        $cart = $cart ?? [];
        $total = $total ?? 0;
        @endphp

        @if(empty($cart))
        <div class="rounded-md border border-blue-200 bg-blue-50 text-blue-700 p-4">
            Giỏ hàng đang trống. Vào
            <a class="underline font-medium text-indigo-600" href="{{ route('home') }}">trang chủ</a>
            để chọn sản phẩm nhé.
        </div>
        @else
        <div class="overflow-x-auto rounded-xl border border-beige bg-white shadow-soft">
            <table class="min-w-full divide-y divide-beige">
                <thead class="bg-warm">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Img</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Product
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Qty</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600">Subtotal
                        </th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-beige">
                    @foreach($cart as $id => $item)
                    @php
                    $subtotal = (float)$item['price'] * (int)$item['quantity'];
                    @endphp
                    <tr class="hover:bg-beige transition">
                        <td class="px-4 py-3">
                            <img src="{{ Storage::url('products/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                class="w-14 h-14 object-cover rounded-lg">
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-ink">{{ $item['name'] }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $id }}</div>
                        </td>
                        <td class="px-4 py-3 text-ink">₫{{ number_format((float)$item['price'],
                            0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('cart.update', $id) }}"
                                class="flex items-center gap-2">
                                @csrf
                                <input type="number" name="quantity" min="1" value="{{ (int)$item['quantity'] }}"
                                    class="w-24 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
                                <button
                                    class="inline-flex items-center rounded-md border border-indigo-600 text-indigo-600 px-3 py-1 text-sm hover:bg-indigo-50 transition"
                                    type="submit">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-3 font-semibold text-ink">₫{{
                            number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('cart.remove', $id) }}">
                                @csrf
                                <button
                                    class="inline-flex items-center rounded-md border border-red-600 text-red-600 px-3 py-1 text-sm hover:bg-red-50 transition"
                                    type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-right font-bold text-ink">Total
                        </td>
                        <td class="px-4 py-3 font-bold text-ink">₫{{ number_format($total, 0,
                            ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                <button
                    class="inline-flex items-center rounded-md border border-beige text-ink px-4 py-2 hover:bg-beige transition"
                    type="submit">Clear Cart</button>
            </form>
            <a href="{{ route('home') }}"
                class="inline-flex items-center rounded-md border border-beige text-ink px-4 py-2 hover:bg-beige transition">Continue
                Shopping</a>
            <a href="{{ route('checkout.index') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 transition {{ empty($cart) ? 'opacity-50 pointer-events-none' : '' }}">
                Go to Checkout
            </a>
        </div>
        @endif
    </section>
</x-app-layout>