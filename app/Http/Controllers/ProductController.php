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

        // 2. [QUAN TRỌNG] Xử lý Variants để tìm ảnh riêng (VD: santal-33-100.jpg)
        // Load variants và sắp xếp size nhỏ trước
        $product->load(['variants' => function ($q) {
            $q->where('is_active', true)->orderBy('capacity_ml', 'asc');
        }]);

        // Biến đổi Variants thành JSON có chứa link ảnh (Key 'image' là quan trọng nhất)
        $variantsData = $product->variants->map(function ($variant) use ($product) {
            // Logic tạo tên ảnh dự đoán: slug gốc + dung tích.jpg
            // VD: santal-33-le-labo-100.jpg
            $suffix = '-' . $variant->capacity_ml;

            // Xử lý chuỗi tên ảnh gốc để chèn suffix vào trước đuôi .jpg
            $extension = pathinfo($product->image, PATHINFO_EXTENSION); // lấy đuôi jpg/png
            $filename = pathinfo($product->image, PATHINFO_FILENAME); // lấy tên file không đuôi

            $variantImageName = $filename . $suffix . '.' . $extension;


            // Nếu ảnh 50ml (ảnh gốc) thì lấy ảnh gốc, còn lại thì lấy ảnh variant
            if ($variant->capacity_ml == 50 || $variant->capacity_ml == 30) {
                // Thường chai nhỏ nhất dùng ảnh gốc cho đẹp
                $imageUrl = \Illuminate\Support\Facades\Storage::url('products/' . $product->image);
            } else {
                $imageUrl = \Illuminate\Support\Facades\Storage::url('products/' . $variantImageName);
            }

            return [
                'id' => $variant->id,
                'capacity_ml' => $variant->capacity_ml,
                'price' => $variant->price,
                'sku' => $variant->sku,
                'stock_quantity' => $variant->stock_quantity,
                'image' => $imageUrl, // Luôn có dữ liệu, không bao giờ null
            ];
        });

        // 3. Chọn variant mặc định
        $defaultVariant = $product->variants->first();

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

        // 5. Logic Gợi ý sản phẩm (Complete Look & Curated)
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

        // Reviews & Wishlist
        $reviews = $product->reviews()->with('user')->latest()->paginate(5);
        $wishedIds = auth()->check() ? auth()->user()->wishlist()->pluck('products.id')->toArray() : [];

        // Trả về View với biến variantsJson đã được xử lý ảnh
        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'completeLook' => $completeLook,
            'wishedIds' => $wishedIds,
            'variantImages' => $variantImages,
            'availableColors' => $availableColors,
            'defaultVariant' => $defaultVariant,
            'variantsJson' => $variantsData->toJson(), // <-- Đây là mấu chốt
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
