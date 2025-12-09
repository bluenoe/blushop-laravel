<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        // Sau này sẽ thêm logic lấy thống kê (Stats) ở đây
        // Ví dụ: $totalOrders = Order::count();

        return view('admin.dashboard');
    }
}
