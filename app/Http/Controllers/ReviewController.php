<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        // 1. Validate đúng tên trường như bên View gửi sang
        $validated = $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'fit_rating' => 'required|integer|min:1|max:5', // Thêm cái này
            'content'    => 'required|string|max:1000',      // Đổi 'content' thành 'content'
            'image'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Xử lý ảnh
        ]);

        try {
            $product = Product::findOrFail($id);

            // 2. Xử lý upload ảnh (nếu có)
            $imagePath = null;
            if ($request->hasFile('image')) {
                // Lưu vào thư mục storage/app/public/reviews
                $imagePath = $request->file('image')->store('reviews', 'public');
            }

            // 3. Tạo Review
            Review::create([
                'product_id' => $product->id,
                'user_id'    => auth()->id(),
                'rating'     => $validated['rating'],
                'fit_rating' => $validated['fit_rating'],
                'content'    => $validated['content'],
                'image'      => $imagePath,
            ]);

            // 4. QUAN TRỌNG: Trả về JSON để AlpineJS bên View hiểu được
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!'
            ]);
        } catch (\Exception $e) {
            // Nếu lỗi hệ thống, trả về lỗi 500 để JS bắt được
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
