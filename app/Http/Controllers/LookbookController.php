<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LookbookController extends Controller
{
    /**
     * Display the lookbook page with featured products.
     */
    public function index()
    {
        // Fetch 3 products, eager load category to prevent N+1 queries
        $lookbookProducts = Product::with('category')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('pages.lookbook', compact('lookbookProducts'));
    }
}
