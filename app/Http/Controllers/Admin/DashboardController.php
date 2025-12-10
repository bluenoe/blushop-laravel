<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Tổng doanh thu (Chỉ tính đơn đã hoàn thành hoặc shipped)
        $revenue = Order::whereIn('status', ['completed', 'shipped'])->sum('total_amount');

        // 2. Tổng đơn hàng
        $totalOrders = Order::count();
        $processingOrders = Order::where('status', 'processing')->count();

        // 3. Giá trị trung bình đơn hàng (AOV)
        $aov = $totalOrders > 0 ? $revenue / $totalOrders : 0;

        // 4. Đơn hàng gần đây (5 đơn mới nhất)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('revenue', 'totalOrders', 'processingOrders', 'aov', 'recentOrders'));
    }
}
