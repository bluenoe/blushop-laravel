<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:2000',
        ]);

        $product = Product::findOrFail($productId);

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(), // null nếu anonymous allowed
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Cảm ơn review của bạn.');
    }
}
