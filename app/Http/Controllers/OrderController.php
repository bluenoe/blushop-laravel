<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show list of orders for the authenticated user.
     */
    public function index()
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with(['orderItems.product'])
            ->latest('created_at')
            ->get();

        return view('orders', [
            'orders' => $orders,
        ]);
    }
}
