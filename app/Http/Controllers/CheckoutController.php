<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout (tóm tắt giỏ hàng) — chỉ cho user đã đăng nhập.
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi checkout.');
        }

        // Tính tổng
        $total = 0.0;
        foreach ($cart as $item) {
            $total += ((float) $item['price']) * ((int) $item['quantity']);
        }

        return view('checkout', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Đặt hàng: validate, tính tổng, lưu DB, xoá giỏ, điều hướng tới lịch sử.
     */
    public function place(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng trống. Không thể đặt hàng.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        // Tính lại tổng từ server-side (không trust client)
        $total = 0.0;
        foreach ($cart as $pid => $item) {
            $total += ((float) $item['price']) * ((int) $item['quantity']);
        }
        // Lưu đơn hàng
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'payment_status' => 'pending',
            'status' => 'pending',
            'shipping_address' => $data['address'],
        ]);

        // Lưu các dòng sản phẩm
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => (int) $productId,
                'quantity' => (int) $item['quantity'],
                'price_at_purchase' => (float) $item['price'],
            ]);
        }

        // Xoá giỏ sau khi đặt hàng
        $request->session()->forget('cart');

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order placed successfully.');
    }
}
