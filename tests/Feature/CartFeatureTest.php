<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can add update remove and clear cart', function () {
    $p = Product::create(['name'=>'A','price'=>50000,'price_vnd'=>50000,'image'=>'a.jpg']);

    // Add
    $this->post("/cart/add/{$p->id}", ['quantity' => 2])->assertRedirect('/cart');
    $this->get('/cart')->assertSee('50.000₫'); // format của 1 item (tuỳ view)

    // Update
    $this->post("/cart/update/{$p->id}", ['quantity' => 3])->assertRedirect('/cart');

    // Remove
    $this->post("/cart/remove/{$p->id}")->assertRedirect('/cart');

    // Clear (no error even if empty)
    $this->post('/cart/clear')->assertRedirect('/cart');
});
