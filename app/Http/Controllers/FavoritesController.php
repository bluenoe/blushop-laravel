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

        return view('favorites', [
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
        if (!isset($favorites[$product->id])) {
            $favorites[$product->id] = [
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image,
            ];
        }

        $request->session()->put('favorites', $favorites);
        return back()->with('success', 'Added to favorites');
    }

    /**
     * Remove a product from favorites.
     */
    public function remove(Request $request, int $id)
    {
        $favorites = $this->favorites($request);

        if (isset($favorites[$id])) {
            unset($favorites[$id]);
            $request->session()->put('favorites', $favorites);
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