<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;

class CartService
{
    protected string $key = 'cart';

    public function items(): array {
        return session($this->key, []);
    }

    public function count(): int {
        return array_sum(array_column($this->items(), 'quantity'));
    }

    public function add(Product $product, int $qty): void {
        $qty = max(1, $qty);
        $cart = $this->items();

        $id = (string)$product->id;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price_vnd' => (int)$product->price_vnd,
                'quantity' => $qty,
                'image' => $product->image,
            ];
        }

        session([$this->key => $cart]);
    }

    public function update(int $productId, int $qty): void {
        $qty = max(1, $qty);
        $cart = $this->items();
        $id = (string)$productId;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $qty;
            session([$this->key => $cart]);
        }
    }

    public function remove(int $productId): void {
        $cart = $this->items();
        Arr::forget($cart, (string)$productId);
        session([$this->key => $cart]);
    }

    public function clear(): void {
        session()->forget($this->key);
    }

    public function totalVnd(): int {
        $sum = 0;
        foreach ($this->items() as $id => $it) {
            $sum += ((int)$it['price_vnd']) * ((int)$it['quantity']);
        }
        return $sum;
    }

    /** Snapshot cho OrderPlacement */
    public function snapshot(): array {
        $snap = [];
        foreach ($this->items() as $pid => $it) {
            $price = (int)$it['price_vnd'];
            $qty   = (int)$it['quantity'];
            $snap[] = [
                'product_id'   => (int)$pid,
                'name'         => $it['name'],
                'price_vnd'    => $price,
                'quantity'     => $qty,
                'subtotal_vnd' => $price * $qty,
                'image'        => $it['image'] ?? null,
            ];
        }
        return $snap;
    }

    public function isEmpty(): bool {
        return empty($this->items());
    }
}
