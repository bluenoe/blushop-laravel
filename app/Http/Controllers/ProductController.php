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
        // 1. Fetch Product
        $product = Product::with(['category', 'images'])
            ->withCount('reviews')
            ->findOrFail($id);

        // 2. Xử lý Variants (Nước hoa) - LOGIC MỚI QUAN TRỌNG
        // Eager load và sort variants
        $product->load(['variants' => function ($q) {
            $q->where('is_active', true)->orderBy('capacity_ml', 'asc');
        }]);

        // Biến đổi Variants thành mảng dữ liệu thông minh (Kèm link ảnh nếu có)
        $variantsData = $product->variants->map(function ($variant) use ($product) {
            // Tạo tên file dự đoán: VD "santal-33-le-labo-100.jpg"
            $suffix = '-' . $variant->capacity_ml;
            $variantImageName = str_replace('.jpg', '', $product->image) . $suffix . '.jpg';

            // Check xem file ảnh riêng cho size này có tồn tại không?
            // Lưu ý: path 'products/' phải khớp với nơi bà lưu ảnh trong storage/app/public/products/
            $hasSpecificImage = Storage::disk('public')->exists('products/' . $variantImageName);

            // Nếu có thì lấy, không thì null (Frontend sẽ giữ nguyên ảnh cũ)
            $imageUrl = $hasSpecificImage
                ? Storage::url('products/' . $variantImageName)
                : null;

            return [
                'id' => $variant->id,
                'capacity_ml' => $variant->capacity_ml,
                'price' => $variant->price,
                'sku' => $variant->sku,
                'stock_quantity' => $variant->stock_quantity,
                'image' => $imageUrl, // Key quan trọng để đổi ảnh
            ];
        });

        // Chọn variant mặc định (Size nhỏ nhất)
        $defaultVariant = $product->variants->first();

        // 3. Xử lý Color (Quần áo)
        $variantImages = $product->images
            ->whereNotNull('color')
            ->mapWithKeys(function ($item) {
                $path = Str::startsWith($item->image_path, 'products/')
                    ? $item->image_path
                    : 'products/' . $item->image_path;
                return [$item->color => Storage::url($path)];
            });
        $availableColors = $variantImages->keys()->toArray();

        // 4. Gender Detection & Recommendations
        $catName = optional($product->category)->name ?? '';
        $isFemale = Str::contains($catName, ['Women', 'Nữ', 'Ladies', 'Girl', 'Female', 'Her']);

        // Complete The Look (Chỉ lấy Apparel)
        $completeLook = Product::query()
            ->where('type', 'apparel')
            ->where('id', '!=', $id)
            ->whereHas('category', function ($q) use ($isFemale) {
                $genderKeywords = $isFemale ? ['Women', 'Nữ'] : ['Men', 'Nam'];
                $q->where(function ($sub) use ($genderKeywords) {
                    foreach ($genderKeywords as $k) $sub->orWhere('name', 'like', "%{$k}%");
                });
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Reviews & Wishlist
        $reviews = $product->reviews()->with('user')->latest()->paginate(5);
        $wishedIds = auth()->check() ? auth()->user()->wishlist()->pluck('products.id')->toArray() : [];

        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'completeLook' => $completeLook,
            'wishedIds' => $wishedIds,
            'variantImages' => $variantImages,
            'availableColors' => $availableColors,
            'defaultVariant' => $defaultVariant,
            'variantsJson' => $variantsData->toJson(), // Trả về JSON đã xử lý ảnh
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

    public function newArrivals()
    {
        $products = Product::latest()->take(20)->get();
        return view('products.new-arrivals', compact('products'));
    }
}
