<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to wishlist',
                'redirect' => route('login')
            ], 401);
        }

        // Validate product ID
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $validated['product_id'];
        $userId = Auth::id();

        // Check if item already in wishlist
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $action = 'removed';
            $isWishlisted = false;
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            $action = 'added';
            $isWishlisted = true;
        }

        // Get updated wishlist count
        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'action' => $action,
            'is_wishlisted' => $isWishlisted,
            'wishlist_count' => $wishlistCount,
            'message' => $action === 'added'
                ? 'Product added to wishlist'
                : 'Product removed from wishlist'
        ]);
    }

    /**
     * Display user's wishlist
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your wishlist');
        }

        $wishlistItems = Wishlist::with(['product.images', 'product.category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Remove single item from wishlist
     */
    public function remove($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist'
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Wishlist::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Wishlist cleared successfully');
    }

    /**
     * Move wishlist items to cart
     */
    public function moveToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'wishlist_id' => 'required|exists:wishlists,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $wishlistItem = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->findOrFail($validated['wishlist_id']);

        // Check stock availability
        $quantity = $validated['quantity'] ?? 1;
        if ($wishlistItem->product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        // Add to cart
        \App\Models\Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $wishlistItem->product_id,
                'color_id' => $validated['color_id'],
                'size_id' => $validated['size_id'],
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $quantity),
                'price' => $wishlistItem->product->price,
            ]
        );

        // Remove from wishlist
        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item moved to cart successfully'
        ]);
    }
}
