@extends('layout')

@section('content')
    <div class="py-3">
        <div class="text-center mb-4">
            <h1 class="h3 fw-bold">Products</h1>
            <p class="text-muted mb-0">Pick your favorites — session cart coming in Day 3 👀</p>
        </div>

        @if(($products ?? collect())->isEmpty())
            <div class="alert alert-warning">
                No products yet. Did you run seeder? <code>php artisan db:seed --class=ProductSeeder</code>
            </div>
        @else
            <div class="row g-3">
                @foreach($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <img
                                src="{{ asset('images/' . $product->image) }}"
                                class="card-img-top"
                                alt="{{ $product->name }}"
                                style="object-fit: cover; height: 180px;"
                            >
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1" style="min-height: 3rem;">
                                    {{ $product->name }}
                                </h5>
                                <p class="card-text fw-semibold mb-3">
                                    ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('product.show', $product->id) }}"
                                   class="btn btn-primary mt-auto">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
