@extends('layout')

@section('content')
<div class="mb-3 space-y-2">
    @if(session('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif
    @if(session('warning'))
        <x-ui.alert type="warning">{{ session('warning') }}</x-ui.alert>
    @endif
</div>

<h2 class="text-xl font-semibold mb-3">Checkout</h2>

@php
$cart = $cart ?? [];
$total = $total ?? 0;
@endphp

@if(empty($cart))
    <x-ui.alert type="info">
        Giỏ hàng trống. <a href="{{ route('home') }}" class="underline">Tiếp tục mua sắm</a>.
    </x-ui.alert>
@else
<div class="mb-4 overflow-x-auto">
    <table class="min-w-full divide-y divide-beige">
        <thead class="bg-warm">
            <tr>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-600">Img</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-600">Product</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-600">Price</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-600">Qty</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-600">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-beige">
            @foreach($cart as $id => $item)
                @php $subtotal = (float)$item['price'] * (int)$item['quantity']; @endphp
                <tr>
                    <td class="px-3 py-2"><img src="{{ Storage::url('products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded"/></td>
                    <td class="px-3 py-2 font-semibold">{{ $item['name'] }}</td>
                    <td class="px-3 py-2">₫{{ number_format((float)$item['price'], 0, ',', '.') }}</td>
                    <td class="px-3 py-2">{{ (int)$item['quantity'] }}</td>
                    <td class="px-3 py-2 font-semibold">₫{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="bg-warm">
                <td colspan="4" class="px-3 py-2 text-right font-bold">Total</td>
                <td class="px-3 py-2 font-bold">₫{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

<x-ui.card class="shadow-soft">
    <div class="p-5">
        <h5 class="text-lg font-semibold mb-3">Your Info</h5>
        <form method="POST" action="{{ route('checkout.place') }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                       class="mt-1 block w-full rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft" required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium">Address</label>
                <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft" required>{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2 flex gap-2">
                <x-ui.button href="{{ route('cart.index') }}" variant="secondary">Back to Cart</x-ui.button>
                <x-ui.button type="submit" variant="primary">Place Order</x-ui.button>
            </div>
        </form>
    </div>
</x-ui.card>
@endif
@endsection