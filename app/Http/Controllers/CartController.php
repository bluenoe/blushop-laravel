<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $subtotal = $this->calculateTotal($cart);
        
        $shippingFee = (float) Setting::getVal('shipping_fee', 30000);
        $freeShippingThreshold = (float) Setting::getVal('free_shipping_threshold', 500000);
        $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingFee;
        $orderTotal = $subtotal + $shipping;

        // Build stock map for real-time JS validation
        $productIds = collect($cart)->pluck('product_id')->unique()->filter()->values()->toArray();
        $stockMap = Product::whereIn('id', $productIds)->pluck('stock', 'id')->toArray();

        return view('cart.index', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'orderTotal' => $orderTotal,
            'freeShippingThreshold' => $freeShippingThreshold,
            'stockMap' => $stockMap,
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

        // --- STOCK CHECK: Prevent adding more than available stock ---
        $size = $request->input('size', 'Freesize');
        $color = $request->input('color', 'Default');
        $rowId = $id . '_' . $size . '_' . $color;
        $cart = Session::get('cart', []);

        // Calculate total quantity (existing in cart + new)
        $existingQty = isset($cart[$rowId]) ? (int) $cart[$rowId]['quantity'] : 0;
        $totalQty = $existingQty + $quantity;

        if ($totalQty > $product->stock) {
            $availableToAdd = $product->stock - $existingQty;
            $message = $availableToAdd <= 0
                ? "Sorry, \"{$product->name}\" is already at max stock in your bag."
                : "Sorry, only {$product->stock} units of \"{$product->name}\" are available.";

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }
            return redirect()->back()->with('error', $message);
        }

        // 2. Logic thêm/cập nhật dựa trên ROW ID
        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] += $quantity;
        } else {
            $cart[$rowId] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => $quantity,
                "price" => (float) ($product->price ?? $product->base_price ?? 0),
                "image" => $product->image,
                "size" => $size,
                "color" => $color,
                "rowId" => $rowId
            ];
        }

        Session::put('cart', $cart);

        // 3. Phản hồi AJAX chuẩn form
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Added {$product->name} ({$size}/{$color}) to bag",
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
                $subtotal = $this->calculateTotal($cart);
                
                $shippingFee = (float) Setting::getVal('shipping_fee', 30000);
                $freeShippingThreshold = (float) Setting::getVal('free_shipping_threshold', 500000);
                $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingFee;
                $total = $subtotal + $shipping;

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Cart updated',
                        'item_subtotal' => number_format($itemSubtotal, 0, ',', '.'),
                        'subtotal' => number_format($subtotal, 0, ',', '.'),
                        'shipping' => $shipping == 0 ? 'Free' : number_format($shipping, 0, ',', '.'),
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

            $subtotal = $this->calculateTotal($cart);
            $shippingFee = (float) Setting::getVal('shipping_fee', 30000);
            $freeShippingThreshold = (float) Setting::getVal('free_shipping_threshold', 500000);
            $shipping = ($subtotal >= $freeShippingThreshold) ? 0 : $shippingFee;
            $total = $subtotal + $shipping;

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed',
                    'subtotal' => number_format($subtotal, 0, ',', '.'),
                    'shipping' => $shipping == 0 ? 'Free' : number_format($shipping, 0, ',', '.'),
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
