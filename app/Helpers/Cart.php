<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Cart
{
    /**
     * Đếm số lượng sản phẩm trong giỏ hàng
     */
    public static function count()
    {
        // Lấy giỏ hàng từ session 'cart', mặc định là mảng rỗng
        $cart = Session::get('cart', []);

        // Nếu giỏ hàng không phải mảng (lỗi dữ liệu), trả về 0
        if (!is_array($cart)) {
            return 0;
        }

        // Cách 1: Đếm số loại sản phẩm (Unique items)
        // Ví dụ: Mua 10 cái áo A và 5 cái áo B -> Trả về số 2 (2 loại)
        // return count($cart);

        // Cách 2: (Góc nhìn ngược chiều) Nếu bà muốn đếm tổng số lượng (Total quantity)
        // Ví dụ: Mua 10 cái áo A + 5 cái áo B -> Trả về 15
        return array_reduce($cart, function ($total, $item) {
            return $total + ($item['quantity'] ?? 1);
        }, 0);
    }

    /**
     * Lấy toàn bộ giỏ hàng (Để dùng sau này)
     */
    public static function get()
    {
        return Session::get('cart', []);
    }
}
