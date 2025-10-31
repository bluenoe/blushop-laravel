<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Admin: list all orders with optional payment_status filter.
     */
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $query = Order::query()->with(['user', 'orderItems.product'])->latest('created_at');
        if ($status) {
            $query->where('payment_status', $status);
        }
        $orders = $query->get();

        return view('admin.orders', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    /** Approve an order (set paid). */
    public function approve(Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        return back()->with('success', "Order #{$order->id} approved.");
    }

    /** Mark as shipped (no separate status column; implicit shipped). */
    public function ship(Order $order)
    {
        // Without a dedicated shipping status, this action confirms payment.
        if ($order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'paid']);
        }
        return back()->with('success', "Order #{$order->id} marked as shipped.");
    }

    /** Cancel an order. */
    public function cancel(Order $order)
    {
        $order->update(['payment_status' => 'cancelled']);
        return back()->with('success', "Order #{$order->id} cancelled.");
    }
}