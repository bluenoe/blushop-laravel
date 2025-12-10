<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng của khách (My Orders)
     */
    public function index()
    {
        // Chỉ lấy đơn hàng của user hiện tại
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product') // Eager load để lấy ảnh sản phẩm
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng của khách
     */
    public function show(Order $order)
    {
        // Bảo mật: Chặn nếu xem đơn của người khác
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}
