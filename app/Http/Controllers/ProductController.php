<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Nhớ import model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm.
     */
    public function index(Request $request)
    {
        // 1. Base Query: Chỉ select cột cần thiết
        $query = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'image', 'category_id', 'is_new', 'is_bestseller', 'is_on_sale']) // Thêm slug
            ->with(['category:id,name,slug']);

        // 2. Filter: Category (Hỗ trợ cả danh mục Cha và Con)
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            // Logic: Lấy sp thuộc danh mục này HOẶC danh mục con của nó
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                // Nếu là cha, lấy hết ID của con
                $childIds = $category->children()->pluck('id');
                // Gộp ID cha và ID con
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
        // Dùng trực tiếp cột trong DB thay vì tính toán AVG (Nhanh hơn gấp 100 lần)
        if ($request->boolean('on_sale')) {
            $query->where('is_on_sale', true);
        }
        if ($request->boolean('in_stock')) {
            // Giả sử bà có cột quantity hoặc status, nếu chưa có thì tạm bỏ qua
            $query->where('status', '!=', 'out_of_stock');
        }
        if ($request->boolean('featured')) { // Filter từ checkbox sidebar
            $query->where('is_bestseller', true);
        }

        // 6. Sort
        $sort = (string) $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            // Featured sort thì ưu tiên bestseller lên đầu
            'featured' => $query->orderBy('is_bestseller', 'desc')->orderBy('id', 'desc'),
            default => $query->latest('id'),
        };

        // 7. Pagination (Dùng 12 như đã thống nhất)
        $products = $query->paginate(12)->withQueryString();

        // 8. Categories Tree (Cho Sidebar)
        // Lấy danh mục Cha (parent_id null) kèm theo Con (children)
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
            'categories' => $categories, // Truyền cây thư mục sang view
            'breadcrumbs' => $breadcrumbs,
            // Hardcode range giá để tối ưu performance (hoặc cache lại)
            'priceMinBound' => 0,
            'priceMaxBound' => 5000000,
        ]);
    }

    public function show(int $id)
    {
        $product = Product::with(['category', 'completeLookProducts'])
            ->withCount('reviews')
            ->findOrFail($id);

        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(5);

        // Related Products (Logic giữ nguyên - Rất tốt)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();
        }

        // Complete Look (Logic giữ nguyên - Rất tốt)
        if ($product->completeLookProducts->isEmpty()) {
            $fakeLooks = Product::where('id', '!=', $id)
                ->where('category_id', '!=', $product->category_id)
                ->inRandomOrder()
                ->take(4)
                ->get();
            $product->setRelation('completeLookProducts', $fakeLooks);
        }

        // Wishlist check
        $wishedIds = auth()->check()
            ? auth()->user()->wishlist()->pluck('products.id')->toArray()
            : [];

        return view('products.show', compact('product', 'reviews', 'relatedProducts', 'wishedIds'));
    }

    public function autocomplete(Request $request)
    {
        $term = trim((string) $request->input('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json(['data' => []]);
        }

        // Escape ký tự đặc biệt để tránh lỗi SQL Injection qua LIKE
        $safeTerm = str_replace(['%', '_'], ['\\%', '\\_'], $term);

        $products = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'image']) // Thêm slug
            ->where('name', 'like', '%' . $safeTerm . '%')
            ->orderBy('name')
            ->limit(8)
            ->get();

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                // Fix: Đảm bảo đường dẫn ảnh chuẩn
                'image' => $product->image ? Storage::url('products/' . $product->image) : null,
                // Best Practice: Dùng route show với ID hoặc Slug
                'url' => route('products.show', $product->id),
            ];
        });

        return response()->json(['data' => $results]);
    }
}
