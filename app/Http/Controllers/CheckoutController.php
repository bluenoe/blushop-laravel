<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            $total += ((float)$item['price']) * ((int)$item['quantity']);
        }

        return view('checkout', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Đặt hàng giả lập: validate, tính tổng, xoá giỏ, hiển thị success.
     */
    public function place(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng trống. Không thể đặt hàng.');
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        // Tính lại tổng từ server-side (không trust client)
        $total = 0.0;
        foreach ($cart as $item) {
            $total += ((float)$item['price']) * ((int)$item['quantity']);
        }

        // Giả lập mã đơn hàng
        $orderCode = 'BLU-' . Str::upper(Str::random(8));

        // Xoá giỏ sau khi "đặt hàng" thành công
        $request->session()->forget('cart');

        // Trả về trang success (không lưu DB đơn hàng ở Day 4)
        return view('checkout_success', [
            'name'      => $data['name'],
            'address'   => $data['address'],
            'total'     => $total,
            'orderCode' => $orderCode,
        ]);
    }
}
