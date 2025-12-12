<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (Shop page)
     * Logic: Lấy từ file 1 (Filter, Sort, Search)
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

        // Search by keyword
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Price range filters
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        // Sorting
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

        // Boolean filters
        if ($request->boolean('on_sale')) {
            $avg = (float) Product::query()->avg('price');
            $query->where('price', '<=', $avg * 0.8);
        }
        if ($request->boolean('featured')) {
            $query->inRandomOrder();
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = Category::query()
            ->select(['id', 'name', 'slug'])
            ->where('name', '!=', 'Uncategorized')
            ->orderBy('name')
            ->get();

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
            'priceMinBound' => (float) Product::query()->min('price'),
            'priceMaxBound' => (float) Product::query()->max('price'),
        ]);
    }

    /**
     * Trang chi tiết sản phẩm.
     * Logic: Ưu tiên file 2 (Deep load relations) + Merge wishedIds từ file 1.
     */
    public function show(Product $product)
    {
        // 1. Load relationships (Logic xịn từ file 2)
        $product->load([
            'images' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            },
            'colors' => function ($query) {
                $query->where('is_active', true)->orderBy('name');
            },
            'sizes' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'category',
            'reviews' => function ($query) {
                $query->with('user')->latest()->limit(20);
            },
            'completeLookProducts' => function ($query) {
                $query->with(['images' => function ($q) {
                    $q->orderBy('sort_order')->limit(1);
                }])->where('is_active', true)->limit(4);
            }
        ]);

        // 2. Calculations (File 2)
        $product->avg_rating = $product->reviews->avg('rating') ?? 0;
        $product->avg_fit = $product->reviews->avg('fit_rating') ?? 3;

        // 3. Related Products (File 2)
        $relatedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['images' => function ($query) {
                $query->orderBy('sort_order')->limit(1);
            }])
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // 4. Analytics (File 2)
        $this->trackProductView($product);

        // 5. [MERGE QUAN TRỌNG] Lấy wishlist ID để hiển thị nút tim (File 1)
        $wishedIds = auth()->check()
            ? auth()->user()->wishlist()->pluck('products.id')->toArray()
            : [];

        return view('products.show', compact('product', 'relatedProducts', 'wishedIds'));
    }

    /**
     * Helper: Track views (File 2)
     */
    private function trackProductView(Product $product)
    {
        $product->increment('views_count');
    }

    /**
     * Trang hàng mới về (File 1)
     */
    public function newArrivals()
    {
        $products = Product::latest()->paginate(12);
        return view('products.new-arrivals', compact('products'));
    }
}
// End of File