<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch products belonging to this category OR any of its child categories
        $products = Product::whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhereHas('parent', function ($p) use ($slug) {
                      $p->where('slug', $slug);
                  });
            })
            ->with(['variants', 'category'])
            ->latest()
            ->paginate(12);

        return view('collections.show', compact('category', 'products'));
    }
}
