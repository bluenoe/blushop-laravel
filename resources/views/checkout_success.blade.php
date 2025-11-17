@extends('layout')

@section('content')
    <div class="text-center py-5">
        <h1 class="text-xl sm:text-2xl font-bold mb-2">🎉 Order Placed Successfully!</h1>
        <p class="text-gray-700">Cảm ơn <strong>{{ $name }}</strong>. Đơn hàng của bạn đã được ghi nhận.</p>

        <x-ui.card class="mx-auto shadow-soft max-w-lg mt-4">
            <div class="p-5 text-left">
                <p class="mb-1"><strong>Order Code:</strong> {{ $orderCode }}</p>
                <p class="mb-1"><strong>Ship To:</strong> {{ $address }}</p>
                <p class="mb-0"><strong>Total Paid:</strong> ₫{{ number_format($total, 0, ',', '.') }}</p>
            </div>
        </x-ui.card>

        <div class="mt-4">
            <x-ui.button href="{{ route('home') }}">Continue Shopping</x-ui.button>
        </div>
    </div>
@endsection
