<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class LandingController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index()
    {
        // Fetch 4 random products for the Featured section
        $featured = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('landing', [
            'featured' => $featured,
            'wishedIds' => Auth::check()
                ? Auth::user()->wishlistedProducts()->pluck('id')->all()
                : [],
        ]);
    }
}