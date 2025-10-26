@extends('layout')

@section('content')
<div class="row g-4">
    <div class="col-12 col-md-5">
        <div class="card shadow-sm">
            <img
                src="{{ asset('images/' . $product->image) }}"
                class="card-img-top"
                alt="{{ $product->name }}"
                style="object-fit: cover; height: 340px;"
            >
        </div>
    </div>
    <div class="col-12 col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title">{{ $product->name }}</h3>
                <p class="text-muted">ID: {{ $product->id }}</p>
                <h4 class="text-primary mb-3">₫{{ number_format((float)$product->price, 0, ',', '.') }}</h4>
                @if($product->description)
                    <p class="mb-4">{{ $product->description }}</p>
                @endif

                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="row g-2 align-items-center">
                    @csrf
                    <div class="col-auto">
                        <label for="qty" class="form-label mb-0">Qty</label>
                    </div>
                    <div class="col-auto" style="max-width: 120px;">
                        <input
                            type="number"
                            min="1"
                            name="quantity"
                            id="qty"
                            value="1"
                            class="form-control @error('quantity') is-invalid @enderror"
                            required
                        >
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            Add to Cart
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
