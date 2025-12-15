<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        // 1. Validate 
        $validated = $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'fit_rating' => 'required|integer|min:1|max:5',
            'content'    => 'required|string|max:1000',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $product = Product::findOrFail($id);

            // 2. Upload ảnh 
            $imagePath = null;
            if ($request->hasFile('image')) {
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

            // ---------- TÍNH TOÁN VÀ CẬP NHẬT LẠI PRODUCT ----------

            // Tính điểm trung bình mới từ bảng reviews
            $newAvgRating = $product->reviews()->avg('rating');

            // Đếm tổng số review mới
            $newReviewCount = $product->reviews()->count();

            // Cập nhật vào bảng products
            $product->update([
                'avg_rating' => $newAvgRating,
                'reviews_count' => $newReviewCount
            ]);

            // 4. Trả về JSON 
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
