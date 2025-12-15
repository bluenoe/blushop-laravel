<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import thêm Str để xử lý chuỗi

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm.
     */
    public function index(Request $request)
    {
        // 1. Base Query: Chỉ select cột cần thiết
        $query = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'image', 'category_id', 'is_new', 'is_bestseller', 'is_on_sale'])
            ->with(['category:id,name,slug']);

        // 2. Filter: Category (Hỗ trợ cả danh mục Cha và Con)
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                $childIds = $category->children()->pluck('id');
                $allIds = $childIds->push($category->id);
                $query->whereIn('category_id', $allIds);
            }
        }

        // 3. Filter: Search
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // 4. Filter: Price
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        // 5. Filter: Status Attributes
        if ($request->boolean('on_sale')) {
            $query->where('is_on_sale', true);
        }
        if ($request->boolean('in_stock')) {
            $query->where('status', '!=', 'out_of_stock');
        }
        if ($request->boolean('featured')) {
            $query->where('is_bestseller', true);
        }

        // 6. Sort
        $sort = (string) $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'featured' => $query->orderBy('is_bestseller', 'desc')->orderBy('id', 'desc'),
            default => $query->latest('id'),
        };

        // 7. Pagination
        $products = $query->paginate(12)->withQueryString();

        // 8. Categories Tree
        $categories = Category::whereNull('parent_id')
            ->where('slug', '!=', 'uncategorized')
            ->with('children')
            ->orderBy('name')
            ->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
        ];

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'priceMinBound' => 0,
            'priceMaxBound' => 5000000,
        ]);
    }

    /**
     * Hiển thị chi tiết sản phẩm với Logic thông minh (Complete Look & Curated)
     */
    public function show(int $id)
    {
        // 1. Fetch Product
        $product = Product::with('category')
            ->withCount('reviews')
            ->findOrFail($id);

        // 2. LOGIC THÔNG MINH: Detect Gender từ Category Name
        // Kiểm tra xem tên danh mục có chứa từ khóa nữ không
        $catName = optional($product->category)->name ?? '';
        $isFemale = Str::contains($catName, ['Women', 'Nữ', 'Ladies', 'Girl', 'Váy', 'Đầm', 'Female']);

        // 3. COMPLETE THE LOOK (Chỉ lấy Apparel + Cùng giới tính)
        $completeLook = Product::query()
            ->where('type', 'apparel') // Chỉ lấy quần áo
            ->where('id', '!=', $id)   // Trừ sản phẩm đang xem
            ->whereHas('category', function ($q) use ($isFemale) {
                // Nếu là đồ Nữ -> Chỉ tìm danh mục có chữ Nữ/Women
                // Nếu là đồ Nam -> Chỉ tìm danh mục có chữ Nam/Men
                if ($isFemale) {
                    $q->where(function ($sub) {
                        $sub->where('name', 'like', '%Women%')
                            ->orWhere('name', 'like', '%Nữ%')
                            ->orWhere('name', 'like', '%Ladies%');
                    });
                } else {
                    $q->where(function ($sub) {
                        $sub->where('name', 'like', '%Men%')
                            ->orWhere('name', 'like', '%Nam%')
                            ->orWhere('name', 'like', '%Man%');
                    });
                }
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Fallback: Nếu không tìm thấy đồ cùng giới tính (do DB ít), lấy random apparel
        if ($completeLook->isEmpty()) {
            $completeLook = Product::where('type', 'apparel')
                ->where('id', '!=', $id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        // 4. CURATED FOR YOU (Chỉ lấy Apparel + Random cả Nam Nữ)
        // Biến này sẽ thay thế cho $relatedProducts ở View cũ
        $curated = Product::query()
            ->where('type', 'apparel')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        // 5. Reviews Logic
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(5);

        // 6. Wishlist Logic
        $wishedIds = auth()->check()
            ? auth()->user()->wishlist()->pluck('products.id')->toArray()
            : [];

        // Trả về view: Lưu ý biến $curated thay cho $relatedProducts để đúng ý đồ của bà
        return view('products.show', compact('product', 'reviews', 'completeLook', 'curated', 'wishedIds'));
    }

    public function autocomplete(Request $request)
    {
        $term = trim((string) $request->input('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json(['data' => []]);
        }

        $safeTerm = str_replace(['%', '_'], ['\\%', '\\_'], $term);

        $products = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'image'])
            ->where('name', 'like', '%' . $safeTerm . '%')
            ->orderBy('name')
            ->limit(8)
            ->get();

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image ? Storage::url('products/' . $product->image) : null,
                'url' => route('products.show', $product->id),
            ];
        });

        return response()->json(['data' => $results]);
    }
}
