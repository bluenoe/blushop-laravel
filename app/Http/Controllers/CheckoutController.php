<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout (tóm tắt giỏ hàng) — chỉ cho user đã đăng nhập.
     */
    public function index(Request $request): View|RedirectResponse
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

        // Get user's default address for auto-fill
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $defaultAddress = $user?->defaultAddress;

        return view('checkout', [
            'cart' => $cart,
            'total' => $total,
            'defaultAddress' => $defaultAddress,
        ]);
    }

    /**
     * Đặt hàng: validate, tính tổng, lưu DB, xoá giỏ, điều hướng tới lịch sử.
     */
    public function place(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng trống. Không thể đặt hàng.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Save/Update user's shipping address
        UserAddress::updateOrCreate(
            [
                'user_id' => $user->id,
                'is_default' => true,
            ],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
            ]
        );

        // Tính lại tổng từ server-side (không trust client)
        $total = 0.0;
        foreach ($cart as $pid => $item) {
            $total += ((float) $item['price']) * ((int) $item['quantity']);
        }

        // Lưu đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'payment_status' => 'pending',
            'status' => 'pending',
            'shipping_address' => $data['address'] . ', ' . $data['city'],
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
        return redirect()->route('checkout.success', $order->id);
    }

    /**
     * Hiển thị trang thành công sau khi đặt hàng.
     */
    public function success(\App\Models\Order $order): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // TRẢ VỀ VIEW, KHÔNG REDIRECT
        return view('checkout.success', compact('order'));
    }
}

