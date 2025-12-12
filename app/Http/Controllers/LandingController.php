<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index()
    {
        // Fetch products for the Featured section
        $featured = Product::query()
            // LƯU Ý: Phải select cả 'category_id' để relationship hoạt động
            // Nếu có cột 'slug' thì thêm vào luôn để link cho đẹp
            ->select(['id', 'name', 'price', 'image', 'category_id'])
            ->with('category') // Load kèm danh mục để hiển thị tên (Women/Men)
            ->inRandomOrder()
            ->take(8) // Lấy 8 cái cho đầy đặn grid (giao diện bà set grid 4 cột mà)
            ->get();

        $socialFeed = Product::inRandomOrder()
            ->limit(6) // Lấy 6 ảnh thôi cho bố cục Mosaic
            ->get()
            ->map(function ($product) {
                return [
                    'image' => $product->image, // Tận dụng ảnh sản phẩm
                    'link'  => route('products.show', $product->id),
                    'handle' => '@blu.shop' // Tên Instagram giả
                ];
            });

        return view('landing', [
            'featured' => $featured,
            'socialFeed' => $socialFeed, // <--- Truyền biến này sang View
            'wishedIds' => Auth::check() ? Auth::user()->wishlist()->pluck('products.id')->all() : [],
        ]);
    }
}
