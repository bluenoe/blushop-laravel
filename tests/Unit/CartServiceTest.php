<?php

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('calculates totals correctly', function () {
    $p1 = Product::create(['name'=>'A','price'=>100000,'price_vnd'=>100000,'image'=>'x.jpg']);
    $p2 = Product::create(['name'=>'B','price'=>200000,'price_vnd'=>200000,'image'=>'y.jpg']);

    $cart = app(CartService::class);
    $cart->add($p1, 2); // 200k
    $cart->add($p2, 1); // 200k

    expect($cart->totalVnd())->toBe(400000);
    expect($cart->count())->toBe(3);
});
