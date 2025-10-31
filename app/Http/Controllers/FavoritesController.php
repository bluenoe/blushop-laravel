<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * View favorites (wishlist).
     */
    public function index(Request $request)
    {
        $favorites = $this->favorites($request);

        $view = $request->routeIs('profile.wishlist') ? 'profile.wishlist' : 'favorites';
        return view($view, [
            'favorites' => $favorites,
        ]);
    }

    /**
     * Add a product to favorites.
     */
    public function add(Request $request, int $id)
    {
        $product = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->findOrFail($id);

        $favorites = $this->favorites($request);
        $favorited = false;
        if (!isset($favorites[$product->id])) {
            $favorites[$product->id] = [
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
            ];
            $favorited = true;
        }

        $request->session()->put('favorites', $favorites);
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'favorited' => $favorited,
                'favorites_count' => count($favorites),
                'message' => $favorited ? 'Added to favorites' : 'Already in favorites',
            ]);
        }
        return back()->with('success', $favorited ? 'Added to favorites' : 'Already in favorites');
    }

    /**
     * Remove a product from favorites.
     */
    public function remove(Request $request, int $id)
    {
        $favorites = $this->favorites($request);
        $removed = false;

        if (isset($favorites[$id])) {
            unset($favorites[$id]);
            $removed = true;
            $request->session()->put('favorites', $favorites);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $removed,
                'removed' => $removed,
                'favorites_count' => count($favorites),
                'message' => $removed ? 'Removed from favorites' : 'Product not in favorites',
            ], $removed ? 200 : 422);
        }

        if ($removed) {
            return back()->with('success', 'Removed from favorites');
        }
        return back()->with('warning', 'Product not in favorites');
    }

    /**
     * Clear all favorites.
     */
    public function clear(Request $request)
    {
        $request->session()->forget('favorites');
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'favorites_count' => 0,
                'message' => 'Cleared favorites',
            ]);
        }
        return back()->with('success', 'Cleared favorites');
    }

    // ----------------- Helpers -----------------
    private function favorites(Request $request): array
    {
        /** @var array<string, array{name:string,price:float,image:string}> $favorites */
        $favorites = $request->session()->get('favorites', []);
        return $favorites;
    }
}