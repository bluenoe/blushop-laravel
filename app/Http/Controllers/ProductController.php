<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm ra trang chủ.
     * - Clean: chỉ lấy các field cần thiết.
     * - Ngắn gọn: function nhỏ, không dead code.
     */
    public function index(Request $request)
    {
        // Có thể phân trang ở Day 5 nếu muốn; Day 2: lấy hết để demo.
        $products = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->latest('id')
            ->get();

        return view('home', [
            'products' => $products,
        ]);
    }
}
