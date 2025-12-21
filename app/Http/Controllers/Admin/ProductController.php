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
        // 1. Validate dữ liệu đầu vào - using correct field names
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'required|string|in:men,women,fragrance', // Enum values
            'base_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // 2. Create Slug automatically from name
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);

        // 3. Handle Image Upload (Smart Path: storage/products/{slug}/{filename})
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store in slug-based folder
            $file->storeAs('products/' . $validated['slug'], $filename, 'public');
            $validated['image'] = $filename;
        }

        // 4. Set defaults
        $validated['is_active'] = true;
        $validated['stock'] = $validated['stock'] ?? 0;

        // 5. Create product
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
        // 1. Validation - using correct field names
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku'  => 'required|string|unique:products,sku,' . $product->id,
            'category' => 'required|string|in:men,women,fragrance', // Enum values
            'base_price' => 'required|numeric|min:0', // Form input name matches DB column
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // 2. Data Preparation
        $data = $request->except(['image', '_token', '_method']);
        
        // Ensure base_price is set from validated input
        $data['base_price'] = $validated['base_price'];

        // 3. Handle slug update if name changed
        if ($request->name !== $product->name) {
            $data['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        }

        // 4. Image Handling (Smart Path: storage/products/{slug}/{filename})
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Use the current or new slug for the folder path
            $slug = $data['slug'] ?? $product->slug;
            
            // Delete old image if exists
            if ($product->image && $product->slug) {
                $oldPath = 'products/' . $product->slug . '/' . $product->image;
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            // Store new image in slug-based folder
            $file->storeAs('products/' . $slug, $filename, 'public');
            $data['image'] = $filename;
        }

        // 5. Update Product
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
}
