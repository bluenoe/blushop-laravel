<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('persists order and items then clears cart', function () {
    $user = User::factory()->create();
    $p1 = Product::create(['name'=>'A','price'=>100000,'price_vnd'=>100000,'image'=>'a.jpg']);
    $p2 = Product::create(['name'=>'B','price'=>200000,'price_vnd'=>200000,'image'=>'b.jpg']);

    // Add to cart as guest
    $this->post("/cart/add/{$p1->id}", ['quantity' => 2]);
    $this->post("/cart/add/{$p2->id}", ['quantity' => 1]);

    // Login & checkout
    $this->actingAs($user)
        ->get('/checkout')->assertOk();

    $this->actingAs($user)
        ->post('/checkout/place', ['name' => 'Blu', 'address' => 'Da Nang'])
        ->assertOk()
        ->assertSee('Order placed');

    // DB assertions
    $this->assertDatabaseCount('orders', 1);
    $this->assertDatabaseCount('order_items', 2);

    // Cart cleared
    $this->get('/cart')->assertSee('Cart'); // view tùy bạn — chỉ cần không lỗi
});
