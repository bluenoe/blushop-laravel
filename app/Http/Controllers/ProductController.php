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
        $product = Product::with(['category', 'images'])
            ->withCount('reviews')
            ->findOrFail($id);

        // 2. Xử lý Variants (Nước hoa)
        $product->load(['variants' => function ($q) {
            $q->where('is_active', true)->orderBy('capacity_ml', 'asc');
        }]);

        // [LOGIC ẢNH VARIANT] Force URL không cần check file_exists (để Frontend luôn đổi ảnh)
        $variantsData = $product->variants->map(function ($variant) use ($product) {
            $suffix = '-' . $variant->capacity_ml;
            $extension = pathinfo($product->image, PATHINFO_EXTENSION);
            $filename = pathinfo($product->image, PATHINFO_FILENAME);
            $variantImageName = $filename . $suffix . '.' . $extension;

            // Nếu là size nhỏ (30/50ml) dùng ảnh gốc, size lớn dùng ảnh variant
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

        // 3. [MỚI - QUAN TRỌNG] Tính toán ảnh mặc định ban đầu để gửi sang View
        // (Giúp bà không cần sửa logic phức tạp ở file Blade nữa)
        $defaultImage = null;
        $defaultColor = null;

        if ($product->variants->isNotEmpty()) {
            // A. Nước hoa: Luôn lấy ảnh đại diện chính làm mặc định
            $defaultImage = Storage::url('products/' . $product->image);
        } else {
            // B. Quần áo: Lấy ảnh main hoặc ảnh đầu tiên trong thư viện
            $defImgObj = $product->images->firstWhere('is_main', 1) ?? $product->images->first();
            if ($defImgObj) {
                $path = Str::startsWith($defImgObj->image_path, 'products/')
                    ? $defImgObj->image_path
                    : 'products/' . $defImgObj->image_path;
                $defaultImage = Storage::url($path);
                $defaultColor = $defImgObj->color;
            } else {
                // Fallback: nếu quần áo chưa up thư viện ảnh thì lấy ảnh đại diện
                $defaultImage = $product->image ? Storage::url('products/' . $product->image) : 'https://placehold.co/600x800';
            }
        }

        // 4. Logic cho Quần áo (Color mapping)
        $variantImages = $product->images
            ->whereNotNull('color')
            ->mapWithKeys(function ($item) {
                $path = Str::startsWith($item->image_path, 'products/')
                    ? $item->image_path
                    : 'products/' . $item->image_path;
                return [$item->color => Storage::url($path)];
            });
        $availableColors = $variantImages->keys()->toArray();

        // 5. Logic Gợi ý sản phẩm
        $catName = optional($product->category)->name ?? '';
        $isFemale = Str::contains($catName, ['Women', 'Nữ', 'Ladies', 'Girl', 'Female', 'Her']);

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

        $reviews = $product->reviews()->with('user')->latest()->paginate(5);
        $wishedIds = auth()->check() ? auth()->user()->wishlist()->pluck('products.id')->toArray() : [];
        $defaultVariant = $product->variants->first();

        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'completeLook' => $completeLook,
            'wishedIds' => $wishedIds,
            'variantImages' => $variantImages,
            'availableColors' => $availableColors,
            'defaultVariant' => $defaultVariant,
            'variantsJson' => $variantsData->toJson(),
            // Truyền 2 biến này sang để View đỡ phải tính toán
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

    public function newArrivals()
    {
        $products = Product::latest()->take(20)->get();
        return view('products.new-arrivals', compact('products'));
    }
}
