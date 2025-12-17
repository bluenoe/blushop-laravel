<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm.
     */
    public function index(Request $request)
    {
        // 1. Base Query
        $query = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'image', 'category_id', 'is_new', 'is_bestseller', 'is_on_sale'])
            ->with(['category:id,name,slug']);

        // 2. Filter: Category
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
        // [MERGE] Thêm eager load 'variants' và sort theo dung tích
        $product = Product::with(['category', 'images', 'variants' => function ($q) {
            $q->where('is_active', true)->orderBy('capacity_ml', 'asc');
        }])
            ->withCount('reviews')
            ->findOrFail($id);

        // [NEW LOGIC] Xử lý Color & Image Swap cho Frontend (Apparel Logic)
        $variantImages = $product->images
            ->whereNotNull('color')
            ->mapWithKeys(function ($item) {
                $path = Str::startsWith($item->image_path, 'products/')
                    ? $item->image_path
                    : 'products/' . $item->image_path;

                return [$item->color => Storage::url($path)];
            });

        $availableColors = $variantImages->keys()->toArray();

        // [MERGE] Xử lý Logic Nước Hoa (Perfume Logic)
        // Nếu có variants (nước hoa), lấy variant mặc định (size nhỏ nhất)
        $defaultVariant = $product->variants->first();
        // Chuyển variants sang JSON để JS xử lý đổi giá dynamic
        $variantsJson = $product->variants->isNotEmpty() ? $product->variants->toJson() : null;


        // 2. LOGIC THÔNG MINH: Detect Gender từ Category Name
        $catName = optional($product->category)->name ?? '';
        $isFemale = Str::contains($catName, ['Women', 'Nữ', 'Ladies', 'Girl', 'Váy', 'Đầm', 'Female', 'Her']);

        // 3. COMPLETE THE LOOK (Chỉ lấy Apparel + Cùng giới tính)
        $completeLook = Product::query()
            ->where('type', 'apparel')
            ->where('id', '!=', $id)
            ->whereHas('category', function ($q) use ($isFemale) {
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

        // Fallback
        if ($completeLook->isEmpty()) {
            $completeLook = Product::where('type', 'apparel')
                ->where('id', '!=', $id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        // 4. CURATED FOR YOU
        $curated = Product::query()
            ->where('type', 'apparel') // Ưu tiên gợi ý quần áo
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

        // Trả về view
        return view('products.show', compact(
            'product',
            'reviews',
            'completeLook',
            'curated',
            'wishedIds',
            'variantImages',
            'availableColors',
            'defaultVariant', // [New]
            'variantsJson'    // [New]
        ));
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


    /**
     * Hiển thị trang New Arrivals (Sản phẩm mới nhất)
     */
    public function newArrivals()
    {
        // Lấy 20 sản phẩm mới nhất
        $products = \App\Models\Product::latest()->take(20)->get();

        return view('products.new-arrivals', compact('products'));
    }
}
