<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Xem giỏ hàng.
     */
    public function index(Request $request)
    {
        $cart = $this->cart($request);
        $total = $this->total($cart);

        return view('cart', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Thêm sản phẩm vào giỏ.
     * - quantity >= 1 (mặc định 1 nếu không gửi lên)
     */
    public function add(Request $request, int $id)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);
        $qty = (int) ($data['quantity'] ?? 1);

        $product = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->findOrFail($id);

        $cart = $this->cart($request);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $qty,
                'image' => $product->image,
            ];
        }

        $request->session()->put('cart', $cart);

        $count = collect($cart)->sum('quantity');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => (int) $count,
                'product_id' => $product->id,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    /**
     * Cập nhật số lượng 1 item trong giỏ.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->cart($request);

        if (! isset($cart[$id])) {
            return redirect()->route('cart.index')->with('warning', 'Sản phẩm không có trong giỏ.');
        }

        $cart[$id]['quantity'] = (int) $data['quantity'];
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng.');
    }

    /**
     * Xoá 1 item khỏi giỏ.
     */
    public function remove(Request $request, int $id)
    {
        $cart = $this->cart($request);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Đã xoá sản phẩm khỏi giỏ.');
        }

        return redirect()->route('cart.index')->with('warning', 'Sản phẩm không có trong giỏ.');
    }

    /**
     * Xoá toàn bộ giỏ.
     */
    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Đã xoá toàn bộ giỏ hàng.');
    }

    // ----------------- Helpers (private, ngắn gọn) -----------------

    private function cart(Request $request): array
    {
        /** @var array<string, array{name:string,price:float,quantity:int,image:string}> $cart */
        $cart = $request->session()->get('cart', []);

        return $cart;
    }

    private function total(array $cart): float
    {
        $sum = 0.0;
        foreach ($cart as $item) {
            $sum += ((float) $item['price']) * ((int) $item['quantity']);
        }

        return $sum;
    }
}
