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
        // 1. Lấy sản phẩm (Không dùng select cứng nữa để tránh lỗi thiếu cột)
        $products = Product::with('variants') // Load kèm variants để lấy ảnh/giá
            ->inRandomOrder()
            ->take(8)
            ->get();

        // 2. Map dữ liệu để tương thích với View cũ
        $products->each(function ($product) {
            $defaultVariant = $product->variants->first();

            // Gán ngược lại vào thuộc tính ảo để View gọi $product->price không bị lỗi
            $product->price = $defaultVariant ? $defaultVariant->price : $product->base_price;

            // Lấy ảnh từ variant đầu tiên (bảng products mới không còn cột image)
            $path = $defaultVariant ? $defaultVariant->image_path : null;
            $product->image = $path ? \Illuminate\Support\Facades\Storage::url($path) : 'https://placehold.co/400x600';

            // Xử lý category (vì DB mới dùng enum string 'men'/'women')
            $product->category_name = ucfirst($product->category);
        });

        // 3. Social Feed (Logic giả lập ảnh từ sản phẩm)
        $socialFeed = $products->take(6)->map(function ($product) {
            return [
                'image' => $product->image,
                'link'  => route('products.show', $product->id),
                'handle' => '@blu.shop'
            ];
        });

        return view('landing', compact('products', 'socialFeed'));
    }
}
