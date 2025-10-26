@extends('layout')

@section('content')
    <div class="text-center py-5">
        <h1 class="h3 fw-bold mb-2">🎉 Order Placed Successfully!</h1>
        <p class="text-muted">Cảm ơn <strong>{{ $name }}</strong>. Đơn hàng của bạn đã được ghi nhận.</p>

        <div class="card mx-auto shadow-sm" style="max-width: 520px;">
            <div class="card-body">
                <p class="mb-1"><strong>Order Code:</strong> {{ $orderCode }}</p>
                <p class="mb-1"><strong>Ship To:</strong> {{ $address }}</p>
                <p class="mb-0"><strong>Total Paid:</strong> ₫{{ number_format($total, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a class="btn btn-primary" href="{{ route('home') }}">Continue Shopping</a>
        </div>
    </div>
@endsection
