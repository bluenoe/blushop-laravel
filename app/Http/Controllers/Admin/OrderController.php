<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Danh sách đơn hàng
    public function index(Request $request)
    {
        $query = Order::query()->with('user'); // Eager load user để tối ưu

        // Filter theo Status (nếu có)
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // 2. Chi tiết đơn hàng (Hàm bị thiếu gây ra lỗi đây nè)
    public function show(Order $order)
    {
        // Load thêm chi tiết sản phẩm trong đơn để hiển thị
        $order->load(['items.product', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    // 3. Cập nhật trạng thái
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }
}
