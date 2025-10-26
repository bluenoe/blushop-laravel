@extends('layout')

@section('content')
    <div class="mb-3">
        @if(session('success'))
            <div class="alert alert-success mb-2">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning mb-2">{{ session('warning') }}</div>
        @endif
    </div>

    <h2 class="h4 fw-bold mb-3">Your Cart</h2>

    @php
        $cart = $cart ?? [];
        $total = $total ?? 0;
    @endphp

    @if(empty($cart))
        <div class="alert alert-info">
            Giỏ hàng đang trống. Vào <a href="{{ route('home') }}">trang chủ</a> để chọn sản phẩm nhé.
        </div>
    @else
        <div class="table-responsive mb-3">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:64px;">Img</th>
                        <th>Product</th>
                        <th style="width:120px;">Price</th>
                        <th style="width:130px;">Qty</th>
                        <th style="width:140px;">Subtotal</th>
                        <th style="width:120px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        @php
                            $subtotal = (float)$item['price'] * (int)$item['quantity'];
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width:56px; height:56px; object-fit:cover;">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item['name'] }}</div>
                                <small class="text-muted">ID: {{ $id }}</small>
                            </td>
                            <td>₫{{ number_format((float)$item['price'], 0, ',', '.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', $id) }}" class="d-flex gap-2">
                                    @csrf
                                    <input type="number" name="quantity" min="1" value="{{ (int)$item['quantity'] }}" class="form-control" style="max-width: 90px;">
                                    <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                                </form>
                            </td>
                            <td class="fw-semibold">₫{{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $id) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">₫{{ number_format($total, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                <button class="btn btn-outline-secondary" type="submit">Clear Cart</button>
            </form>
            <a href="{{ route('home') }}" class="btn btn-outline-dark">Continue Shopping</a>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary {{ empty($cart) ? 'disabled' : '' }}">
                Go to Checkout
            </a>
        </div>
    @endif
@endsection
