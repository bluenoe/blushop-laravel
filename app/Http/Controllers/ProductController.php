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
        $query = Product::query()->select(['id', 'name', 'price', 'image']);

        // Search by keyword (name or description)
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Price range filters
        if ($request->filled('price_min')) {
            $min = (float) $request->input('price_min');
            $query->where('price', '>=', $min);
        }
        if ($request->filled('price_max')) {
            $max = (float) $request->input('price_max');
            $query->where('price', '<=', $max);
        }

        // Sorting: newest (default), price_asc, price_desc
        $sort = (string) $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->latest('id');
                break;
        }

        $products = $query->get();

        return view('home', ['products' => $products]);
    }

    /**
     * Trang chi tiết sản phẩm (ảnh, mô tả, giá, form add to cart).
     */
    public function show(int $id)
    {
        $product = Product::query()->findOrFail($id);

        // Fetch related products: simple strategy - random others
        $relatedProducts = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
