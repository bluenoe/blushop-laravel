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
     * Helper: Danh sách danh mục cố định (Vì DB dùng Enum)
     */
    private function getStaticCategories()
    {
        return collect([
            (object)['name' => 'Men', 'slug' => 'men', 'children' => collect([])],
            (object)['name' => 'Women', 'slug' => 'women', 'children' => collect([])],
            (object)['name' => 'Fragrance', 'slug' => 'fragrance', 'children' => collect([])],
        ]);
    }

    /**
     * Hiển thị danh sách sản phẩm (Filter, Search, Sort).
     */
    public function index(Request $request)
    {
        // 1. Khởi tạo query (Eager load variants để Accessor chạy nhanh)
        $query = Product::with('variants');

        // 2. Filter Category (Theo Enum)
        if ($request->filled('category')) {
            $slug = (string) $request->input('category');
            $query->where('category', $slug);
        }

        // 3. Filter Search
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // 4. Filter Price (Dùng base_price cho chuẩn logic mới)
        if ($request->filled('price_min')) {
            $query->where('base_price', '>=', (float) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('base_price', '<=', (float) $request->input('price_max'));
        }

        // 5. Sort
        $sort = (string) $request->input('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('base_price', 'asc'),
            'price_desc' => $query->orderBy('base_price', 'desc'),
            'featured' => $query->orderBy('is_bestseller', 'desc')->orderBy('id', 'desc'),
            default => $query->latest('id'),
        };

        // 6. Pagination
        $products = $query->paginate(12)->withQueryString();

        // 7. Breadcrumbs & Categories
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('products.index')],
        ];

        return view('products.index', [
            'products' => $products,
            'categories' => $this->getStaticCategories(), // Dùng hàm helper cho gọn
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Shop All'
        ]);
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show(int $id)
    {
        // 1. Load sản phẩm
        $product = Product::with(['variants', 'completeLookProducts'])
            ->withCount('reviews')
            ->findOrFail($id);

        // 2. Chuẩn bị JSON cho AlpineJS (Frontend)
        $variantsData = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => (float) $variant->price,

                // [FIX 1] DB tên là stock_quantity, không phải stock
                'stock' => $variant->stock_quantity,

                // Logic ảnh: Lấy từ DB, Accessor hoặc Storage
                'image' => $variant->image_path ? Storage::url($variant->image_path) : null,

                'color' => $variant->color_name,

                // [FIX 2] DB tên là hex_code, không phải color_hex
                'hex'   => $variant->hex_code,

                'capacity' => $variant->capacity_ml,
                'size' => $variant->size
            ];
        });

        // 3. Logic lấy danh sách nút Màu hiển thị
        $availableColors = $product->variants
            ->whereNotNull('color_name')
            ->unique('color_name')
            ->map(function ($v) {
                return [
                    'name' => $v->color_name,
                    'hex' => $v->hex_code, // [FIX 2] Sửa lại tên cột
                    'image' => $v->image_path ? Storage::url($v->image_path) : null
                ];
            })->values();

        // 4. Xác định loại sản phẩm (Nước hoa hay Quần áo)
        // Check kỹ: Có variant VÀ variant đó có dung tích thì mới là nước hoa
        $firstVariant = $product->variants->first();
        $isFragrance = $product->variants->isNotEmpty() && !empty($firstVariant->capacity_ml);

        // 5. Ảnh mặc định
        $defaultVariant = $product->variants->first();
        $defaultImage = $defaultVariant && $defaultVariant->image_path
            ? Storage::url($defaultVariant->image_path)
            : ($product->image ? Storage::url('products/' . $product->image) : 'https://placehold.co/600x800');

        // 6. Complete Look & Curated
        $completeLook = $product->completeLookProducts;
        if ($completeLook->isEmpty()) {
            // [FIX 3] Dùng cột 'category' enum thay vì 'category_id'
            $completeLook = Product::where('category', $product->category)
                ->where('id', '!=', $id)->inRandomOrder()->take(4)->get();
        }

        $curated = Product::where('id', '!=', $id)->inRandomOrder()->take(5)->get();
        $reviews = $product->reviews()->with('user')->latest()->paginate(5);

        return view('products.show', [
            'product' => $product,
            'reviews' => $reviews,
            'completeLook' => $completeLook,
            'curated' => $curated,
            'variantsJson' => $variantsData->toJson(),
            'availableColors' => $availableColors,
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

        // [FIX 4] Select 'base_price' thay vì 'price'
        $products = Product::select(['id', 'name', 'slug', 'base_price', 'image'])
            ->where('name', 'like', '%' . $safeTerm . '%')
            ->limit(8)->get();

        $results = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->base_price, // [FIX 4] Sửa lại cho khớp
                'image' => $p->image_url, // Dùng Accessor image_url
                'url' => route('products.show', $p->id),
            ];
        });

        return response()->json(['data' => $results]);
    }

    // Các hàm trang phụ (New Arrivals, Best Sellers...)
    // Lưu ý: Bà nên dùng getStaticCategories() thay vì query DB 
    // nếu bà đã bỏ bảng categories cũ.

    public function newArrivals()
    {
        $products = Product::latest()->paginate(12);
        return view('products.new-arrivals', [
            'products' => $products,
            'categories' => $this->getStaticCategories(),
            'breadcrumbs' => [['label' => 'Home', 'url' => route('home')], ['label' => 'New Arrivals', 'url' => '']],
            'pageTitle' => 'New Arrivals'
        ]);
    }

    public function bestSellers()
    {
        $products = Product::orderBy('sold_count', 'desc')->paginate(12);
        return view('products.index', [
            'products' => $products,
            'categories' => $this->getStaticCategories(),
            'breadcrumbs' => [['label' => 'Home', 'url' => route('home')], ['label' => 'Best Sellers', 'url' => '']],
            'pageTitle' => 'Best Sellers'
        ]);
    }

    public function onSale()
    {
        $products = Product::where('is_on_sale', true)->latest()->paginate(12);
        return view('products.index', [
            'products' => $products,
            'categories' => $this->getStaticCategories(),
            'breadcrumbs' => [['label' => 'Home', 'url' => route('home')], ['label' => 'On Sale', 'url' => '']],
            'pageTitle' => 'On Sale'
        ]);
    }
}
