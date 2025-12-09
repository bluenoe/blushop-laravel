<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // Nhớ import cái này
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 1. Hiển thị Form tạo mới
    public function create()
    {
        // Lấy danh mục để chọn (nếu bà chưa có model Category thì tạm thời xóa dòng này và truyền mảng rỗng)
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 2. Xử lý Lưu sản phẩm
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'sku' => 'nullable|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Tạo Slug tự động từ tên (VD: Ao Thun -> ao-thun)
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);

        // Xử lý Upload ảnh
        if ($request->hasFile('image')) {
            // Lưu vào storage/app/public/products
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = basename($path);
        }

        // Tạo sản phẩm
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // 3. Hiển thị Form chỉnh sửa
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 4. Xử lý Cập nhật
    public function update(Request $request, Product $product)
    {
        // Validate
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            // SKU check unique nhưng TRỪ sản phẩm hiện tại ra (để không báo lỗi chính nó)
            'sku' => 'nullable|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        // Nếu user đổi tên -> Cập nhật Slug
        if ($request->name !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        }

        // Xử lý Upload ảnh mới (nếu có)
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu cần (Optional)
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = basename($path);
        }

        // Cập nhật
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
}
