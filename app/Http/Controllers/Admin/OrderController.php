<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Order::query()->with('user');

        if ($request->has('status') && $request->status != 'all') {
            $statusEnum = OrderStatusEnum::tryFrom($request->status);
            if ($statusEnum) {
                $query->where('status', $statusEnum);
            }
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

    // 3. Tiến hành tuần tự các bước
    public function advanceStatus(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                // Lock the order record to prevent race conditions
                $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();

                if ($lockedOrder->status->isTerminal()) {
                    throw new \Exception('Cannot advance a terminal state order.');
                }

                $nextState = $lockedOrder->status->next();
                if (!$nextState) {
                    throw new \Exception('No further states available for advancement.');
                }

                $lockedOrder->update(['status' => $nextState]);
            });

            return back()->with('success', 'Order moved to ' . $order->fresh()->status->label());
        } catch (\Exception $e) {
             return back()->with('error', $e->getMessage());
        }
    }

    // 4. Hủy đơn hàng hoặc Cập nhật thủ công (Fallback for Super Admin)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $newStatus = OrderStatusEnum::tryFrom($request->status);
        if (!$newStatus) {
            return back()->with('error', 'Invalid status provided.');
        }

        try {
            DB::transaction(function () use ($order, $newStatus) {
                $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();
                $lockedOrder->update(['status' => $newStatus]);
            });

            return back()->with('success', 'Order status manually overridden to ' . $newStatus->label());
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }
}
