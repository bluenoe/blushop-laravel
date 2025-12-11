<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy sản phẩm nổi bật cho phần "Featured Collection"
        // Logic: Lấy 8 sản phẩm mới nhất (hoặc bà có thể where('is_featured', true) nếu có cột đó)
        $featured = Product::with('category') // Eager load category để tối ưu query
            ->latest() // Sắp xếp mới nhất lên đầu (hợp với tiêu đề "New Season")
            ->take(8)  // Lấy 8 cái thôi
            ->get();

        // 2. (Tuỳ chọn) Nếu muốn phần Category cũng dynamic luôn
        // Nhưng thường Landing Page thì phần Category Banner hay để cứng để chỉnh ảnh cho đẹp.
        // Nên tui chỉ tập trung vào biến $featured nhé.

        return view('home', compact('featured'));
    }
}
