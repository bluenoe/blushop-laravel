<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        // Validate request
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        // Check stock availability
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        // For authenticated users, save to database
        if (Auth::check()) {
            $cart = Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $validated['product_id'],
                    'color_id' => $validated['color_id'],
                    'size_id' => $validated['size_id'],
                ],
                [
                    'quantity' => \DB::raw('quantity + ' . $validated['quantity']),
                    'price' => $product->price,
                ]
            );

            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        }
        // For guests, use session
        else {
            $cart = Session::get('cart', []);

            // Create unique key for cart item
            $key = $validated['product_id'] . '-' . $validated['color_id'] . '-' . $validated['size_id'];

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $validated['quantity'];
            } else {
                $cart[$key] = [
                    'product_id' => $validated['product_id'],
                    'product_name' => $product->name,
                    'product_image' => $product->images->first()?->url,
                    'color_id' => $validated['color_id'],
                    'size_id' => $validated['size_id'],
                    'quantity' => $validated['quantity'],
                    'price' => $product->price,
                ];
            }

            Session::put('cart', $cart);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Display cart page
     */
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::with(['product.images', 'color', 'size'])
                ->where('user_id', Auth::id())
                ->get();

            $total = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        } else {
            $cart = Session::get('cart', []);
            $cartItems = collect($cart);
            $total = $cartItems->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->findOrFail($id);

            // Check stock
            if ($cart->product->stock < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock'
                ], 400);
            }

            $cart->update(['quantity' => $validated['quantity']]);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $validated['quantity'];
                Session::put('cart', $cart);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}
