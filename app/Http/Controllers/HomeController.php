<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm ngẫu nhiên (hoặc dùng latest() để lấy mới nhất)
        $featured = Product::inRandomOrder()->limit(8)->get();

        // Truyền biến $featured sang view 'home'
        return view('home', compact('featured'));
    }
}
