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
     * Hiển thị danh sách sản phẩm (Filter, Search, Sort).
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'image', 'category_id', 'is_new', 'is_bestseller', 'is_on_sale'])
            ->with(['category:id,name,slug']);

        // 1. Filter Category
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $childIds = $category->children()->pluck('id');
                $allIds = $childIds->push($category->id);
                $query->whereIn('category_id', $allIds);
            }
        }

        // 2. Filter Search
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // 3. Filter Price
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->input('price_max'));
        }

        // 4. Sort
        $sort = (string) $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'featured' => $query->orderBy('is_bestseller', 'desc')->orderBy('id', 'desc'),
            default => $query->latest('id'),
        };

        $products = $query->paginate(12)->withQueryString();

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
        ]);
    }

    /**
     * Hiển thị chi tiết sản phẩm (Logic Hybrid: Quần áo + Nước hoa).
     */
    public function show(int $id)
    {
        // 1. Lấy thông tin sản phẩm
        // Eager load luôn relationship 'completeLookProducts' để tối ưu query
        $product = Product::with(['category', 'images', 'completeLookProducts'])
            ->withCount('reviews')
            ->findOrFail($id);

        // 2. Xử lý Variants (Nước hoa)
        $product->load(['variants' => function ($q) {
            $q->where('is_active', true)->orderBy('capacity_ml', 'asc');
        }]);

        // Logic ảnh Variant (Giữ nguyên logic của bà)
        $variantsData = $product->variants->map(function ($variant) use ($product) {
            $suffix = '-' . $variant->capacity_ml;
            $extension = pathinfo($product->image, PATHINFO_EXTENSION);
            $filename = pathinfo($product->image, PATHINFO_FILENAME);
            $variantImageName = $filename . $suffix . '.' . $extension;

            if ($variant->capacity_ml == 50 || $variant->capacity_ml == 30) {
                $imageUrl = Storage::url('products/' . $product->image);
            } else {
                $imageUrl = Storage::url('products/' . $variantImageName);
            }

            return [
                'id' => $variant->id,
                'capacity_ml' => $variant->capacity_ml,
                'price' => $variant->price,
                'sku' => $variant->sku,
                'stock_quantity' => $variant->stock_quantity,
                'image' => $imageUrl,
            ];
        });

        // 3. Logic ảnh mặc định (Giữ nguyên logic của bà)
        $defaultImage = null;
        $defaultColor = null;

        if ($product->variants->isNotEmpty()) {
            $defaultImage = Storage::url('products/' . $product->image);
        } else {
            $defImgObj = $product->images->firstWhere('is_main', 1) ?? $product->images->first();
            if ($defImgObj) {
                $path = Str::startsWith($defImgObj->image_path, 'products/') ? $defImgObj->image_path : 'products/' . $defImgObj->image_path;
                $defaultImage = Storage::url($path);
                $defaultColor = $defImgObj->color;
            } else {
                $defaultImage = $product->image ? Storage::url('products/' . $product->image) : 'https://placehold.co/600x800';
            }
        }

        // 4. Logic Color mapping (Giữ nguyên)
        $variantImages = $product->images
            ->whereNotNull('color')
            ->mapWithKeys(function ($item) {
                $path = Str::startsWith($item->image_path, 'products/') ? $item->image_path : 'products/' . $item->image_path;
                return [$item->color => Storage::url($path)];
            });
        $availableColors = $variantImages->keys()->toArray();

        // =========================================================
        // FIX 1: COMPLETE THE LOOK (Ưu tiên DB Relation -> Fallback Random)
        // =========================================================

        // Lấy từ bảng trung gian (complete_look_product) mà đã định nghĩa trong Model
        $completeLook = $product->completeLookProducts;

        //  Logic Fallback 
        if ($completeLook->isEmpty()) {
            $completeLook = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $id) // Trừ sản phẩm đang xem
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        // =========================================================
        // FIX 2: CURATED FOR YOU (Logic Random - Recommendation)
        // =========================================================

        $curated = Product::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $reviews = $product->reviews()->with('user')->latest()->paginate(5);
        $wishedIds = auth()->check() ? auth()->user()->wishlist()->pluck('products.id')->toArray() : [];
        $defaultVariant = $product->variants->first();

        // Truyền biến $curated vào view
        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'completeLook' => $completeLook,
            'curated' => $curated,
            'wishedIds' => $wishedIds,
            'variantImages' => $variantImages,
            'availableColors' => $availableColors,
            'defaultVariant' => $defaultVariant,
            'variantsJson' => $variantsData->toJson(),
            'defaultImage' => $defaultImage,
            'defaultColor' => $defaultColor,
        ]);
    }

    public function autocomplete(Request $request)
    {
        $term = trim((string) $request->input('q', ''));
        if (mb_strlen($term) < 2) return response()->json(['data' => []]);

        $safeTerm = str_replace(['%', '_'], ['\\%', '\\_'], $term);
        $products = Product::select(['id', 'name', 'slug', 'price', 'image'])
            ->where('name', 'like', '%' . $safeTerm . '%')
            ->limit(8)->get();

        $results = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'image' => $p->image ? Storage::url('products/' . $p->image) : null,
                'url' => route('products.show', $p->id),
            ];
        });

        return response()->json(['data' => $results]);
    }

    private function getSidebarCategories()
    {
        return Category::whereNull('parent_id')
            ->where('slug', '!=', 'uncategorized')
            ->with('children')
            ->orderBy('name')
            ->get();
    }

    public function newArrivals()
    {
        // Logic: Lấy 12 sản phẩm mới nhất
        $products = Product::latest()->paginate(12);

        // Data giao diện
        $categories = $this->getSidebarCategories();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'New Arrivals', 'url' => ''],
        ];

        // Tái sử dụng view products.index, thêm biến pageTitle để đổi tiêu đề
        return view('products.new-arrivals', [
            'products' => $products,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'New Arrivals'
        ]);
    }

    public function bestSellers()
    {
        // Logic: Sắp xếp theo cột sold_count mới tạo (cao xuống thấp)
        // Nếu sold_count bằng nhau thì lấy cái mới hơn
        $products = Product::orderBy('sold_count', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(12);

        $categories = $this->getSidebarCategories();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Best Sellers', 'url' => ''],
        ];

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Best Sellers'
        ]);
    }

    public function onSale()
    {
        // Logic: Lấy sản phẩm đang có cờ sale hoặc có giá sale
        $products = Product::where('is_on_sale', true)
            ->latest()
            ->paginate(12);

        $categories = $this->getSidebarCategories();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'On Sale', 'url' => ''],
        ];

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'On Sale'
        ]);
    }
}
