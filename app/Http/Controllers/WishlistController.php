<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Lấy danh sách wishlist
        $products = $user->wishlist()->with('category')->latest()->paginate(12);

        return view('wishlist.index', compact('products'));
    }

    // --- CHỈ GIỮ LẠI MỘT HÀM TOGGLE NÀY THÔI NHÉ ---
    public function toggle($productId)
    {
        $user = Auth::user();

        // 1. Thực hiện toggle
        $changes = $user->wishlist()->toggle($productId);

        // 2. Kiểm tra xem vừa thêm vào hay xóa ra
        // Nếu mảng 'attached' có dữ liệu -> tức là vừa thêm vào
        $isWished = count($changes['attached']) > 0;

        // 3. Trả về JSON (Quan trọng)
        return response()->json([
            'success' => true,
            'wished' => $isWished,
            'message' => $isWished ? 'Added to wishlist' : 'Removed from wishlist'
        ]);
    }

    // Hàm xóa toàn bộ (nếu có dùng ở file JS)
    public function clear()
    {
        Auth::user()->wishlist()->detach();
        return response()->json(['success' => true]);
    }
}
