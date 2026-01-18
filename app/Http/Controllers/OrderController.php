<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelOrderRequest;
use App\Services\OrderCancellationService;
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

    /**
     * Cancel an order (AJAX endpoint)
     */
    public function cancel(Order $order, CancelOrderRequest $request, OrderCancellationService $service)
    {
        // Authorization: Ensure user owns this order
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy đơn hàng này.',
            ], 403);
        }

        try {
            $service->cancel(
                $order,
                $request->validated('reason'),
                $request->validated('reason_details')
            );

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy thành công.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
