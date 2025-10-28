<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'products' => Product::query()->count(),
            'users'    => User::query()->count(),
            'orders'   => 0, // placeholder (no orders table in this project)
        ];

        return view('admin.dashboard', compact('stats'));
    }
}