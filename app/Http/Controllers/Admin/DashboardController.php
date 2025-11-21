<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::query()->count();
        $totalOrders = Order::query()->count();
        $totalProducts = Product::query()->count();
        $revenue = (float) Order::query()->sum('total_amount');

        // Monthly revenue for last 12 months
        $rawMonthly = Order::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyMap = $rawMonthly->keyBy('month');
        $labels = [];
        $series = [];
        for ($i = 11; $i >= 0; $i--) {
            $ym = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $series[] = (float) optional($monthlyMap->get($ym))->revenue ?? 0.0;
        }

        return view('admin.dashboard', [
            'stats' => [
                'users' => $totalUsers,
                'orders' => $totalOrders,
                'products' => $totalProducts,
                'revenue' => $revenue,
            ],
            'chart' => [
                'labels' => $labels,
                'series' => $series,
            ],
        ]);
    }
}
