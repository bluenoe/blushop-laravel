<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cart.index', [ // Lưu ý: view thường nằm trong folder cart/index.blade.php
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function add(Request $request, int $id)
    {
        // 1. Validate kỹ hơn
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
        ]);

        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);

        // --- LOGIC QUAN TRỌNG: TẠO ROW ID ---
        // Tạo key độc nhất: ID_Size_Color (Ví dụ: 10_M_Black)
        $size = $request->input('size', 'Freesize'); // Mặc định nếu không chọn là Freesize
        $color = $request->input('color', 'Default');

        // Tạo mã định danh riêng cho biến thể này
        $rowId = $id . '_' . $size . '_' . $color;

        $cart = Session::get('cart', []);

        // 2. Logic thêm/cập nhật dựa trên ROW ID
        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] += $quantity;
        } else {
            $cart[$rowId] = [
                "product_id" => $product->id, // Lưu thêm ID gốc để dễ query sau này
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => (float) $product->price,
                "image" => $product->image,
                "size" => $size,
                "color" => $color,
                "rowId" => $rowId // Lưu chính cái key này vào để tiện xóa/sửa
            ];
        }

        Session::put('cart', $cart);

        // 3. Phản hồi AJAX chuẩn form
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Added {$product->name} ({$size}/{$color}) to bag",
                // Dùng Helper Cart::count() hôm qua tui chỉ, hoặc dùng collect tính tổng quantity
                'cart_count' => collect(session('cart'))->sum('quantity'),
            ]);
        }

        return redirect()->back()->with('success', 'Added to bag!');
    }

    public function update(Request $request)
    {
        // Ở đây ta nhận vào rowId chứ không phải product id
        $rowId = $request->input('rowId');
        $quantity = (int) $request->input('quantity');

        if ($rowId && $quantity > 0) {
            $cart = Session::get('cart', []);

            if (isset($cart[$rowId])) {
                $cart[$rowId]['quantity'] = $quantity;
                Session::put('cart', $cart);

                // Tính toán lại
                $itemSubtotal = $cart[$rowId]['price'] * $quantity;
                $total = $this->calculateTotal($cart);

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Cart updated',
                        'item_subtotal' => number_format($itemSubtotal, 0, ',', '.'),
                        'total' => number_format($total, 0, ',', '.'),
                        'cart_count' => collect(session('cart'))->sum('quantity'),
                    ]);
                }
            }
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        // Nhận rowId (Ví dụ: 10_M_Black)
        $rowId = $request->input('rowId');

        if ($rowId) {
            $cart = Session::get('cart', []);

            if (isset($cart[$rowId])) {
                unset($cart[$rowId]);
                Session::put('cart', $cart);
            }

            $total = $this->calculateTotal($cart);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed',
                    'total' => number_format($total, 0, ',', '.'),
                    'cart_count' => collect(session('cart'))->sum('quantity'),
                    'is_empty' => empty($cart)
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item removed');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index');
    }

    private function calculateTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
