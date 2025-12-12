<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product with all related data
     */
    public function show(Product $product)
    {
        // Load all necessary relationships
        $product->load([
            'images' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            },
            'colors' => function ($query) {
                $query->where('is_active', true)->orderBy('name');
            },
            'sizes' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            },
            'category',
            'reviews' => function ($query) {
                $query->with('user')
                    ->latest()
                    ->limit(20);
            },
            'completeLookProducts' => function ($query) {
                $query->with(['images' => function ($q) {
                    $q->orderBy('sort_order')->limit(1);
                }])
                    ->where('is_active', true)
                    ->limit(4);
            }
        ]);

        // Calculate average ratings
        $product->avg_rating = $product->reviews->avg('rating') ?? 0;
        $product->avg_fit = $product->reviews->avg('fit_rating') ?? 3;

        // Get related products (similar category, excluding current product)
        $relatedProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['images' => function ($query) {
                $query->orderBy('sort_order')->limit(1);
            }])
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // Track product view (optional analytics)
        $this->trackProductView($product);

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Track product views for analytics
     */
    private function trackProductView(Product $product)
    {
        // Increment view count
        $product->increment('views_count');

        // Optional: Store in analytics table or cache
        // Analytics::record('product_view', ['product_id' => $product->id]);
    }
}
