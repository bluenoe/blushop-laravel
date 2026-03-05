<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Order::query()->with('user');

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Apply search using Searchable trait
        $orders = $query->search($search)->latest()->paginate(10)->appends(request()->query());

        return view('admin.orders.index', compact('orders', 'search'));
    }

    // 2. Chi tiết đơn hàng (SỬA LẠI KHÚC NÀY NÈ)
    public function show(Order $order)
    {
        // Sửa 'items.product' thành 'orderItems.product' cho đúng tên trong Model
        $order->load(['orderItems.product', 'user']);

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
