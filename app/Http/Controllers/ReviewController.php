<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to submit a review');
        }

        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'fit_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', // 5MB max
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product');
        }

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        // Create review
        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'fit_rating' => $validated['fit_rating'],
            'comment' => $validated['comment'],
            'image' => $imagePath,
            'is_verified_purchase' => $this->isVerifiedPurchase(Auth::id(), $product->id),
        ]);

        // Update product average rating
        $this->updateProductRating($product);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    /**
     * Check if user has purchased this product
     */
    private function isVerifiedPurchase($userId, $productId)
    {
        // Check if user has completed order with this product
        return \DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->where('order_items.product_id', $productId)
            ->where('orders.status', 'completed')
            ->exists();
    }

    /**
     * Update product average rating
     */
    private function updateProductRating(Product $product)
    {
        $avgRating = Review::where('product_id', $product->id)->avg('rating');
        $reviewCount = Review::where('product_id', $product->id)->count();

        $product->update([
            'avg_rating' => round($avgRating, 1),
            'review_count' => $reviewCount,
        ]);
    }

    /**
     * Update existing review
     */
    public function update(Request $request, Review $review)
    {
        // Ensure user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'fit_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($review->image) {
                Storage::disk('public')->delete($review->image);
            }
            $validated['image'] = $request->file('image')->store('reviews', 'public');
        }

        // Update review
        $review->update($validated);

        // Update product rating
        $this->updateProductRating($review->product);

        return redirect()->back()->with('success', 'Review updated successfully');
    }

    /**
     * Delete review
     */
    public function destroy(Review $review)
    {
        // Ensure user owns this review or is admin
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action');
        }

        $product = $review->product;

        // Delete image if exists
        if ($review->image) {
            Storage::disk('public')->delete($review->image);
        }

        // Delete review
        $review->delete();

        // Update product rating
        $this->updateProductRating($product);

        return redirect()->back()->with('success', 'Review deleted successfully');
    }

    /**
     * Mark review as helpful
     */
    public function markHelpful(Request $request, Review $review)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login'], 401);
        }

        // Toggle helpful status
        $helpful = $review->helpfulVotes()->where('user_id', Auth::id())->first();

        if ($helpful) {
            $helpful->delete();
            $isHelpful = false;
        } else {
            $review->helpfulVotes()->create(['user_id' => Auth::id()]);
            $isHelpful = true;
        }

        return response()->json([
            'success' => true,
            'is_helpful' => $isHelpful,
            'count' => $review->helpfulVotes()->count()
        ]);
    }
}
