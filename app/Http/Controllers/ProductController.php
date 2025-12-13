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

        // Filter: Category
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            $query->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // Filter: Search
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Filter: Price
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        // Sort
        $sort = (string) $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'featured' => $query->inRandomOrder(),
            default => $query->latest('id'),
        };

        if ($request->boolean('on_sale')) {
            $avg = (float) Product::query()->avg('price');
            $query->where('price', '<=', $avg * 0.8);
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = \App\Models\Category::where('name', '!=', 'Uncategorized')->orderBy('name')->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
        ];

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => (string) $request->input('category', ''),
            'wishedIds' => auth()->check() ? auth()->user()->wishlist()->pluck('products.id')->all() : [],
            'breadcrumbs' => $breadcrumbs,
            'priceMinBound' => (float) Product::min('price'),
            'priceMaxBound' => (float) Product::max('price'),
        ]);
    }

    /**
     * TRANG CHI TIẾT SẢN PHẨM 
     */
    public function show(int $id)
    {
        // 1. Lấy thông tin sản phẩm chính
        $product = Product::with(['category', 'completeLookProducts'])
            ->withCount('reviews') // Chỉ đếm số lượng để hiện con số tổng
            ->findOrFail($id);

        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(5); // <--- QUAN TRỌNG: Chỉ lấy 5 cái

        // 2. RELATED PRODUCTS (Sản phẩm liên quan)
        // Logic: Lấy cùng danh mục, trừ sản phẩm hiện tại ra
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4) // Lấy 4 sản phẩm
            ->get();

        // Nếu không có sản phẩm cùng danh mục, lấy random đại (để demo không bị trống)
        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();
        }

        // 3. COMPLETE THE LOOK (Gợi ý phối đồ)
        // Logic: Lấy từ quan hệ DB trước. Nếu rỗng -> Lấy random (Fake data) để hiển thị cho đẹp
        $product->load('completeLookProducts');

        if ($product->completeLookProducts->isEmpty()) {
            // Fake data: Lấy 4 sản phẩm bất kỳ làm gợi ý
            $fakeLooks = Product::where('id', '!=', $id)
                ->where('category_id', '!=', $product->category_id) // Khác danh mục cho phong phú
                ->inRandomOrder()
                ->take(4)
                ->get();

            // Gán data fake vào quan hệ để Blade hiển thị được
            $product->setRelation('completeLookProducts', $fakeLooks);
        }

        // 4. Wishlist check
        $wishedIds = auth()->check()
            ? auth()->user()->wishlist()->pluck('products.id')->toArray()
            : [];

        // Gửi toàn bộ dữ liệu sang View
        return view('products.show', compact('product', 'reviews', 'relatedProducts', 'wishedIds'));
    }

    public function newArrivals()
    {
        $products = Product::latest()->paginate(12);
        return view('products.new-arrivals', compact('products'));
    }
}
