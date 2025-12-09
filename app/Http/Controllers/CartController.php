<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cart', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Add item to cart (AJAX & Normal).
     */
    public function add(Request $request, int $id)
    {
        // 1. Validate
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
        ]);

        $quantity = (int) $request->input('quantity', 1);
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        // 2. Logic thêm/cập nhật
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => (float) $product->price,
                "image" => $product->image,
                "size" => $request->input('size'),
                "color" => $request->input('color')
            ];
        }

        Session::put('cart', $cart);

        // 3. Phản hồi
        // Nếu là AJAX (từ nút Quick Add hoặc trang Detail dùng fetch)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Added to bag',
                'cart_count' => count($cart), // Hoặc collect($cart)->sum('quantity') nếu muốn tổng số lượng
            ]);
        }

        // Nếu request thường (fallback)
        return redirect()->back()->with('success', 'Product added to bag successfully!');
    }

    /**
     * Update item quantity (AJAX mainly).
     */
    public function update(Request $request)
    {
        // Nhận ID từ body JSON hoặc route param đều được
        $id = $request->input('id');
        $quantity = (int) $request->input('quantity');

        if ($id && $quantity > 0) {
            $cart = Session::get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                Session::put('cart', $cart);

                // Tính toán số liệu mới để trả về
                $itemSubtotal = $cart[$id]['price'] * $quantity;
                $total = $this->calculateTotal($cart);

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Quantity updated',
                        'item_subtotal' => number_format($itemSubtotal, 0, ',', '.'),
                        'total' => number_format($total, 0, ',', '.'),
                        'cart_count' => count($cart)
                    ]);
                }
            }
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    /**
     * Remove item from cart (AJAX mainly).
     */
    public function remove(Request $request)
    {
        $id = $request->input('id') ?? $request->route('id'); // Support both POST body and Route param

        if ($id) {
            $cart = Session::get('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }

            // Tính lại tổng sau khi xóa
            $total = $this->calculateTotal($cart);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed',
                    'total' => number_format($total, 0, ',', '.'),
                    'cart_count' => count($cart),
                    'is_empty' => empty($cart)
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from bag');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Shopping bag cleared');
    }

    /**
     * Helper: Calculate Cart Total
     */
    private function calculateTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
