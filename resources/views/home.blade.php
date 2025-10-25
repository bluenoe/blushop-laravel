@extends('layout')

@section('content')
    <div class="py-4">
        <div class="text-center mb-4">
            <h1 class="display-6">Welcome to <span class="text-primary">BluShop</span> 🛍️</h1>
            <p class="text-muted">A 5-day Laravel mini e-commerce — products, cart (session), auth, checkout, contact.</p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Day 1 is live!</h5>
                <p class="card-text mb-0">
                    ✅ Layout + Navbar + Footer (Bootstrap 5).<br>
                    ✅ Routes skeleton sẵn sàng cho Product / Cart / Checkout / Contact.<br>
                    ⏭️ Ngày 2 sẽ có database + product list UI (cards).
                </p>
            </div>
        </div>
    </div>
@endsection
