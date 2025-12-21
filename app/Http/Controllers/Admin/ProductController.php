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

    // 4. Xử lý Cập nhật - Using Explicit Assignment (Fail-Safe)
    public function update(Request $request, Product $product)
    {
        // 1. Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku'  => 'required|string|unique:products,sku,' . $product->id,
            'category' => 'required|string|in:men,women,fragrance',
            'base_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // 2. Explicit Property Assignment (Prevents Silent Failures)
        $product->name = $validated['name'];
        $product->sku = $validated['sku'];
        $product->category = $validated['category'];
        $product->base_price = $validated['base_price'];
        $product->stock = $validated['stock'] ?? 0;
        $product->description = $validated['description'] ?? null;

        // 3. Handle Slug - Update if name changed
        if ($validated['name'] !== $product->getOriginal('name')) {
            $product->slug = Str::slug($validated['name']) . '-' . Str::random(4);
        }

        // 4. Handle Boolean Toggles (Checkboxes)
        // HTML forms don't send unchecked checkboxes, so use has() instead of input()
        $product->is_active = $request->has('is_active');
        $product->is_new = $request->has('is_new');
        $product->is_bestseller = $request->has('is_bestseller');
        $product->is_on_sale = $request->has('is_on_sale');

        // 5. Image Handling (Smart Path: storage/products/{slug}/{filename})
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Use the current or updated slug for the folder path
            $targetSlug = $product->slug;
            
            // Delete old image if exists
            if ($product->getOriginal('image') && $product->getOriginal('slug')) {
                $oldPath = 'products/' . $product->getOriginal('slug') . '/' . $product->getOriginal('image');
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            // Store new image in slug-based folder
            $file->storeAs('products/' . $targetSlug, $filename, 'public');
            $product->image = $filename;
        }

        // 6. SAVE - Explicit save() instead of update() for clarity
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // 5. Delete Product with Image Cleanup
    public function destroy(Product $product)
    {
        // 1. Delete associated image folder from storage
        if ($product->slug) {
            $folderPath = 'products/' . $product->slug;
            if (Storage::disk('public')->exists($folderPath)) {
                // Delete entire product folder (includes all images)
                Storage::disk('public')->deleteDirectory($folderPath);
            }
        }

        // 2. Delete the product record (soft delete if using SoftDeletes)
        $product->delete();

        // 3. Return with success message
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
