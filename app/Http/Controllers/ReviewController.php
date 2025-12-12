<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'fit_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048', // Tối đa 2MB
        ]);

        $data = [
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'fit_rating' => $request->fit_rating,
            'comment' => $request->comment,
        ];

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            // Lưu vào storage/app/public/reviews
            $path = $request->file('image')->store('reviews', 'public');
            $data['image'] = $path;
        }

        Review::create($data);

        return back()->with('success', 'Thank you for your review!');
    }
}
