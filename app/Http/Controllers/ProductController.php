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
        // 1. Khởi tạo query (Eager load variants để lấy ảnh/giá)
        $query = Product::with('variants');

        // 2. Filter Category (Sửa lại theo cột ENUM 'men', 'women')
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            // Vì DB mới lưu 'men', 'women' trực tiếp, nên ta query thẳng cột category
            $query->where('category', $slug);
        }

        // 3. Filter Search (Tìm kiếm)
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // 4. Filter Price (Sửa thành base_price)
        if ($request->filled('price_min')) {
            $query->where('base_price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('base_price', '<=', (float) $request->input('price_max'));
        }

        // 5. Sort (Sửa logic sort theo base_price)
        $sort = (string) $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('base_price', 'asc'),
            'price_desc' => $query->orderBy('base_price', 'desc'),
            'featured' => $query->orderBy('is_bestseller', 'desc')->orderBy('id', 'desc'),
            default => $query->latest('id'),
        };

        // 6. Pagination & Data Transformation
        $products = $query->paginate(12)->withQueryString();

        // [QUAN TRỌNG] Map dữ liệu mới sang cấu trúc cũ để View không bị lỗi
        $products->getCollection()->transform(function ($product) {
            $defaultVariant = $product->variants->first();

            // Tạo thuộc tính ảo 'price' và 'image' cho View dùng
            $product->price = $defaultVariant ? $defaultVariant->price : $product->base_price;

            $path = $defaultVariant ? $defaultVariant->image_path : null;
            $product->image = $path ? \Illuminate\Support\Facades\Storage::url($path) : 'https://placehold.co/400x600';

            return $product;
        });

        // 7. Data cho Sidebar (Giả lập Category để không bị lỗi View)
        // Vì bảng categories cũ có thể bà chưa xóa, nhưng logic mới dùng Enum
        // Tui hardcode tạm list này cho đúng với data Seeder lúc nãy
        $categories = collect([
            (object)['name' => 'Men', 'slug' => 'men', 'children' => []],
            (object)['name' => 'Women', 'slug' => 'women', 'children' => []],
            (object)['name' => 'Fragrance', 'slug' => 'fragrance', 'children' => []],
        ]);

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
        ];

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Shop All'
        ]);
    }

    /**
     * Hiển thị chi tiết sản phẩm (Logic Hybrid: Quần áo + Nước hoa).
     */
    public function show(int $id)
    {
        // 1. Load sản phẩm kèm Variants và Category
        $product = Product::with(['category', 'variants', 'completeLookProducts'])
            ->withCount('reviews')
            ->findOrFail($id);

        // 2. Chuẩn bị dữ liệu Variants (JSON cho Frontend)
        // Map data từ DB mới sang định dạng mà AlpineJS cần
        $variantsData = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => (float) $variant->price,
                'stock' => $variant->stock,
                // LOGIC MỚI: Lấy ảnh cứng từ DB, không đoán tên nữa
                'image' => $variant->image_path ? Storage::url($variant->image_path) : null,
                // Phân loại attributes
                'color' => $variant->color_name,     // Cho quần áo
                'hex'   => $variant->color_hex,      // Cho quần áo (hiển thị chấm tròn)
                'capacity' => $variant->capacity_ml, // Cho nước hoa
                'size' => $variant->size             // Cho quần áo
            ];
        });

        // 3. Logic lấy danh sách Màu (Unique Colors) để hiển thị nút chọn màu
        // Chỉ lấy những màu nào có trong variants
        $availableColors = $product->variants
            ->whereNotNull('color_name')
            ->unique('color_name')
            ->map(function ($v) {
                return [
                    'name' => $v->color_name,
                    'hex' => $v->color_hex,
                    'image' => $v->image_path ? Storage::url($v->image_path) : null
                ];
            })->values();

        // 4. Xác định loại sản phẩm (Nước hoa hay Quần áo)
        // Nếu có capacity_ml -> Là nước hoa
        $isFragrance = $product->variants->whereNotNull('capacity_ml')->isNotEmpty();

        // 5. Ảnh mặc định ban đầu
        $defaultVariant = $product->variants->first();
        $defaultImage = $defaultVariant && $defaultVariant->image_path
            ? Storage::url($defaultVariant->image_path)
            : ($product->image ? Storage::url('products/' . $product->image) : 'https://placehold.co/600x800');

        // 6. Complete Look & Curated (Giữ nguyên logic cũ của bà)
        $completeLook = $product->completeLookProducts;
        if ($completeLook->isEmpty()) {
            $completeLook = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $id)->inRandomOrder()->take(4)->get();
        }
        $curated = Product::where('id', '!=', $id)->inRandomOrder()->take(5)->get();
        $reviews = $product->reviews()->with('user')->latest()->paginate(5);

        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'completeLook' => $completeLook,
            'curated' => $curated,
            // Các biến mới quan trọng
            'variantsJson' => $variantsData->toJson(),
            'availableColors' => $availableColors, // List màu để render nút
            'isFragrance' => $isFragrance,
            'defaultImage' => $defaultImage,
            'defaultVariant' => $defaultVariant,
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
