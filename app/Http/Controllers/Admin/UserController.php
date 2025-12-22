<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh sách user (trừ Admin ra để đỡ rối)
        // Kèm theo đếm số đơn hàng (orders_count) và tổng tiền (tính sau trong view hoặc dùng withSum nếu muốn)
        $users = User::where('is_admin', false)
            ->withCount('orders')
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Lấy lịch sử đơn hàng của khách này
        $orders = $user->orders()->latest()->paginate(5);

        // Tính tổng chi tiêu (Lifetime Value)
        $totalSpent = $user->orders()->where('status', '!=', 'cancelled')->sum('total_amount');

        return view('admin.users.show', compact('user', 'orders', 'totalSpent'));
    }

    public function destroy(User $user)
    {
        // Xóa khách hàng (Cẩn thận: Thường thì nên Soft Delete)
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Customer deleted successfully.');
    }
}
