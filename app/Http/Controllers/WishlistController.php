<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Lấy user hiện tại
        $user = Auth::user();

        // Lấy danh sách sản phẩm trong wishlist (kèm quan hệ category để hiển thị đẹp)
        // Giả sử đã setup quan hệ belongsToMany giữa User và Product tên là 'wishlist'
        // Hoặc nếu bà dùng bảng 'wishlists' riêng thì query tương ứng.
        // Dưới đây là cách chuẩn Laravel dùng belongsToMany:
        $products = $user->wishlist()->with('category')->latest()->paginate(12);

        return view('wishlist.index', compact('products'));
    }

    // Các hàm toggle/clear giữ nguyên...
    public function toggle($productId)
    {
        $user = Auth::user();
        $user->wishlist()->toggle($productId);
        return back()->with('success', 'Wishlist updated.');
    }
}
