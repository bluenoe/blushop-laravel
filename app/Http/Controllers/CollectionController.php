<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function show($slug)
    {
        // Giả sử bà có model Category hoặc Collection
        $category = Category::where('slug', $slug)->firstOrFail();

        // Eager load các relation cần thiết để tránh N+1 query
        // Chỉ lấy khoảng 12-16 items ban đầu thôi (Page speed quan trọng)
        $products = Product::where('category_id', $category->id)
            ->with(['images', 'variants']) // Load ảnh và biến thể
            ->active() // Scope chỉ lấy sp đang bán
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('collections.show', compact('category', 'products'));
    }
}
