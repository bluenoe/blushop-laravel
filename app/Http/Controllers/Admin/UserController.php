<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get search query from request (supports both 'search' and 'query' params)
        $search = $request->input('search') ?? $request->input('query');

        // Build the base query (exclude admins)
        $query = User::where('is_admin', false)
            ->withCount('orders');

        // Apply search filters if search term is provided
        if ($search && trim($search) !== '') {
            $searchTerm = '%' . trim($search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone_number', 'like', $searchTerm);
            });
        }

        // Order by latest and paginate, appending search param for pagination links
        $users = $query->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.users.index', compact('users', 'search'));
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
