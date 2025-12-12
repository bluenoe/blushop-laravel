<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm ra trang chủ.
     */
    public function index(Request $request)
    {
        // 1. Khởi tạo Query & Eager Loading
        // Select cụ thể các cột cần thiết để tối ưu hiệu năng
        $query = Product::query()
            ->select(['id', 'name', 'price', 'image', 'category_id', 'is_new', 'is_bestseller', 'is_on_sale'])
            ->with(['category:id,name,slug']);

        // 2. Áp dụng các bộ lọc (Sử dụng 'when' để code gọn gàng hơn)

        // Filter: Category
        $query->when($request->input('category'), function (Builder $q, $slug) {
            $q->whereHas('category', fn($cat) => $cat->where('slug', $slug));
        });

        // Filter: Search Keyword
        $query->when($request->input('q'), function (Builder $q, $keyword) {
            $keyword = trim($keyword);
            $q->where(function ($sub) use ($keyword) {
                $sub->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        });

        // Filter: Price Range
        $query->when($request->input('price_min'), fn($q, $min) => $q->where('price', '>=', (float)$min));
        $query->when($request->input('price_max'), fn($q, $max) => $q->where('price', '<=', (float)$max));

        // Filter: On Sale (Logic tính toán ngưỡng giảm giá)
        // Lưu ý: Logic này hơi nặng nếu DB lớn, nên cân nhắc cache con số avg này.
        if ($request->boolean('on_sale')) {
            $avg = (float) Product::avg('price'); // Query trực tiếp gọn hơn
            $query->where('price', '<=', $avg * 0.8);
        }

        // Filter: Featured
        if ($request->boolean('featured')) {
            $query->inRandomOrder();
        }

        // 3. Xử lý Sắp xếp (Sorting)
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'featured'   => $query->inRandomOrder(),
            default      => $query->latest('id'),
        };

        // 4. Lấy dữ liệu phụ trợ cho View
        $products = $query->paginate(9)->withQueryString();

        $categories = Category::select(['id', 'name', 'slug'])
            ->where('name', '!=', 'Uncategorized')
            ->orderBy('name')
            ->get();

        $priceMinBound = (float) Product::min('price');
        $priceMaxBound = (float) Product::max('price');

        // Breadcrumbs đơn giản
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
        ];

        return view('products.index', [
            'products'       => $products,
            'categories'     => $categories,
            'activeCategory' => (string) $request->input('category', ''),
            'wishedIds'      => $this->getUserWishedProductIds(),
            'breadcrumbs'    => $breadcrumbs,
            'priceMinBound'  => $priceMinBound,
            'priceMaxBound'  => $priceMaxBound,
        ]);
    }

    /**
     * Trang chi tiết sản phẩm.
     * Đã gộp 2 hàm show cũ thành 1 và tối ưu query.
     */
    public function show($id)
    {
        // Eager load các relation cần thiết cho trang chi tiết
        $product = Product::with(['category', 'reviews', 'completeLookProducts'])
            ->findOrFail($id);

        // Lấy sản phẩm tương tự (Sử dụng Scope đã định nghĩa trong Model)
        $relatedProducts = Product::related($product)->get();

        return view('products.show', [
            'product'         => $product,
            'relatedProducts' => $relatedProducts,
            'wishedIds'       => $this->getUserWishedProductIds(),
        ]);
    }

    /**
     * Hiển thị danh sách sản phẩm mới nhất.
     */
    public function newArrivals()
    {
        $products = Product::latest()->paginate(12);

        return view('products.new-arrivals', [
            'products' => $products
        ]);
    }

    /**
     * Helper: Lấy danh sách ID sản phẩm user đã thích.
     * Giúp tránh lặp code (DRY).
     */
    private function getUserWishedProductIds(): array
    {
        if (!Auth::check()) {
            return [];
        }

        // Sử dụng relation wishlist() của User model
        return Auth::user()->wishlist()->pluck('products.id')->all();
    }
}
