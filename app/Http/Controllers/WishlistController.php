<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Show the user's wishlist.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $products = $user->wishlistedProducts()
            ->select(['products.id', 'products.name', 'products.price', 'products.image', 'products.category_id'])
            ->with(['category:id,name,slug'])
            ->latest('wishlists.created_at')
            ->get();

        $wishedIds = $products->pluck('id')->map(fn ($id) => (int) $id)->all();

        return view('profile.wishlist', [
            'products' => $products,
            'wishedIds' => $wishedIds,
        ]);
    }

    /**
     * Toggle wishlist state for a product.
     */
    public function toggle(Request $request, Product $product)
    {
        $user = $request->user();
        $exists = $user->wishlistedProducts()->where('products.id', $product->id)->exists();

        if ($exists) {
            $user->wishlistedProducts()->detach($product->id);
            $wished = false;
        } else {
            $user->wishlistedProducts()->attach($product->id);
            $wished = true;
        }

        $count = $user->wishlistedProducts()->count();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'wished' => $wished,
                'count' => $count,
                'product_id' => $product->id,
            ]);
        }

        return back()->with('success', $wished ? 'Added to wishlist' : 'Removed from wishlist');
    }

    /**
     * Clear all wishlist items for the user.
     */
    public function clear(Request $request)
    {
        $user = $request->user();
        $user->wishlistedProducts()->detach();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'count' => 0]);
        }

        return back()->with('success', 'Cleared wishlist');
    }
}
