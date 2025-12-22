<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm ngẫu nhiên (hoặc dùng latest() để lấy mới nhất)
        // Eager load category to avoid N+1 queries when displaying category names
        $featured = Product::with('category')->inRandomOrder()->limit(8)->get();

        // Truyền biến $featured sang view 'home'
        return view('home', compact('featured'));
    }
}
