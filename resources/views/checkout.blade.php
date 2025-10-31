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

<h2 class="h4 fw-bold mb-3">Checkout</h2>

@php
$cart = $cart ?? [];
$total = $total ?? 0;
@endphp

@if(empty($cart))
<div class="alert alert-info">
    Giỏ hàng trống. <a href="{{ route('home') }}">Tiếp tục mua sắm</a>.
</div>
@else
<div class="table-responsive mb-4">
    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th style="width:64px;">Img</th>
                <th>Product</th>
                <th style="width:120px;">Price</th>
                <th style="width:100px;">Qty</th>
                <th style="width:140px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $id => $item)
            @php
            $subtotal = (float)$item['price'] * (int)$item['quantity'];
            @endphp
            <tr>
                <td><img src="{{ Storage::url('products/' . $item['image']) }}" alt="{{ $item['name'] }}"
                        style="width:56px; height:56px; object-fit:cover;"></td>
                <td class="fw-semibold">{{ $item['name'] }}</td>
                <td>₫{{ number_format((float)$item['price'], 0, ',', '.') }}</td>
                <td>{{ (int)$item['quantity'] }}</td>
                <td class="fw-semibold">₫{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-end fw-bold">Total</td>
                <td class="fw-bold">₫{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">Your Info</h5>
        <form method="POST" action="{{ route('checkout.place') }}" class="row g-3">
            @csrf
            <div class="col-12 col-md-6">
                <label for="name" class="form-label">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" rows="3"
                    class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-flex gap-2">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Back to Cart</a>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection