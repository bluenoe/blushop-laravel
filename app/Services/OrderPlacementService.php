<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class OrderPlacementService
{
    public function place(User $user, array $input, CartService $cart): Order
    {
        if ($cart->isEmpty()) {
            throw new RuntimeException('Cart is empty');
        }

        $snap = $cart->snapshot();
        $total = $cart->totalVnd();

        return DB::transaction(function () use ($user, $input, $snap, $total, $cart) {
            $order = Order::create([
                'user_id'   => $user->id,
                'code'      => 'ORD-'.Str::upper(Str::random(8)),
                'name'      => $input['name'],
                'address'   => $input['address'],
                'total_vnd' => $total,
                'status'    => 'pending',
            ]);

            foreach ($snap as $row) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $row['product_id'],
                    'price_vnd'    => $row['price_vnd'],
                    'quantity'     => $row['quantity'],
                    'subtotal_vnd' => $row['subtotal_vnd'],
                ]);
            }

            $cart->clear();

            return $order;
        });
    }
}
