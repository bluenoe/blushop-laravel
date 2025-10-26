<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm ra trang chủ.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->latest('id')
            ->get();

        return view('home', ['products' => $products]);
    }

    /**
     * Trang chi tiết sản phẩm (ảnh, mô tả, giá, form add to cart).
     */
    public function show(int $id)
    {
        $product = Product::query()->findOrFail($id);

        return view('product', ['product' => $product]);
    }
}
