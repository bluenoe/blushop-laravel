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

        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Your Cart</h2>

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
            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Img</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Subtotal</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cart as $id => $item)
                            @php
                                $subtotal = (float)$item['price'] * (int)$item['quantity'];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                <td class="px-4 py-3">
                                    <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded-lg">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $item['name'] }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $id }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">₫{{ number_format((float)$item['price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="quantity" min="1" value="{{ (int)$item['quantity'] }}"
                                               class="w-24 rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                        <button class="inline-flex items-center rounded-md border border-indigo-600 text-indigo-600 px-3 py-1 text-sm hover:bg-indigo-50 dark:hover:bg-indigo-900 transition" type="submit">Update</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">₫{{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('cart.remove', $id) }}">
                                        @csrf
                                        <button class="inline-flex items-center rounded-md border border-red-600 text-red-600 px-3 py-1 text-sm hover:bg-red-50 dark:hover:bg-red-900 transition" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-900 dark:text-gray-100">Total</td>
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-gray-100">₫{{ number_format($total, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button class="inline-flex items-center rounded-md border border-gray-400 text-gray-700 px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-900 transition" type="submit">Clear Cart</button>
                </form>
                <a href="{{ route('home') }}" class="inline-flex items-center rounded-md border border-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-900 transition">Continue Shopping</a>
                <a href="{{ route('checkout.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 transition {{ empty($cart) ? 'opacity-50 pointer-events-none' : '' }}">
                    Go to Checkout
                </a>
            </div>
        @endif
    </section>
</x-app-layout>
