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
        $query = Product::query()
            ->select(['id', 'name', 'price', 'image', 'category_id', 'is_new', 'is_bestseller', 'is_on_sale'])
            ->with(['category:id,name,slug']);

        // Category filter by slug
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            $query->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

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

        $sort = (string) $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'featured':
                $query->inRandomOrder();
                break;
            case 'newest':
            default:
                $query->latest('id');
                break;
        }

        if ($request->boolean('on_sale')) {
            $avg = (float) \App\Models\Product::query()->avg('price');
            $threshold = $avg * 0.8;
            $query->where('price', '<=', $threshold);
        }
        if ($request->boolean('featured')) {
            $query->inRandomOrder();
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = \App\Models\Category::query()
            ->select(['id', 'name', 'slug'])
            ->where('name', '!=', 'Uncategorized')
            ->orderBy('name')
            ->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
        ];

        $priceMinBound = (float) \App\Models\Product::query()->min('price');
        $priceMaxBound = (float) \App\Models\Product::query()->max('price');

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => (string) $request->input('category', ''),
            // Qualify column to avoid ambiguous "id" when joining products and wishlists
            'wishedIds' => auth()->check()
                ? auth()->user()->wishlistedProducts()->pluck('products.id')->all()
                : [],
            'breadcrumbs' => $breadcrumbs,
            'priceMinBound' => $priceMinBound,
            'priceMaxBound' => $priceMaxBound,
        ]);
    }

    /**
     * Trang chi tiết sản phẩm (ảnh, mô tả, giá, form add to cart).
     */
    public function show(int $id)
    {
        $product = Product::query()->findOrFail($id);

        // Fetch related products: simple strategy - random others
        $relatedProducts = Product::query()
            ->select(['id', 'name', 'price', 'image', 'is_new', 'is_bestseller', 'is_on_sale'])
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
            ['label' => $product->name],
        ];

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            // Qualify column to avoid ambiguous "id" when joining products and wishlists
            'wishedIds' => auth()->check()
                ? auth()->user()->wishlistedProducts()->pluck('products.id')->all()
                : [],
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
