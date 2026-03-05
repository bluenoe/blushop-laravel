<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Requests\PhoneNumberRequest;

class CheckoutController extends Controller
{

    public function store(PhoneNumberRequest $request)
    {
        $validated = $request->validated();
        $cleanPhone = $validated['phone'];
        $fullPhone = '+84' . $cleanPhone;
    }

    /**
     * Hiển thị trang checkout (tóm tắt giỏ hàng) — chỉ cho user đã đăng nhập.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi checkout.');
        }

        // Tính tổng
        $total = 0.0;
        foreach ($cart as $item) {
            $total += ((float) $item['price']) * ((int) $item['quantity']);
        }

        // Get user's default address for auto-fill
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $defaultAddress = $user?->defaultAddress;

        return view('checkout', [
            'cart' => $cart,
            'total' => $total,
            'defaultAddress' => $defaultAddress,
        ]);
    }

    /**
     * Place order: validate, check stock, deduct atomically, save DB, clear cart.
     *
     * Uses DB transaction + pessimistic locking (lockForUpdate) to prevent
     * overselling under concurrent requests.
     */
    public function place(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng trống. Không thể đặt hàng.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Save/Update user's shipping address (outside transaction — not critical)
        UserAddress::updateOrCreate(
            [
                'user_id' => $user->id,
                'is_default' => true,
            ],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
            ]
        );

        // ─── BEGIN TRANSACTION ───────────────────────────────────────
        DB::beginTransaction();

        try {
            $total = 0.0;
            $stockErrors = [];
            $resolvedItems = [];

            foreach ($cart as $rowId => $item) {
                $productId = (int) ($item['product_id'] ?? $rowId);
                $requestedQty = (int) $item['quantity'];

                // Pessimistic lock: prevent concurrent modifications
                $product = Product::where('id', $productId)->lockForUpdate()->first();

                if (!$product) {
                    $stockErrors[] = "Product \"{$item['name']}\" is no longer available.";
                    continue;
                }

                // Pre-order stock check
                if ($product->stock < $requestedQty) {
                    $stockErrors[] = "Product \"{$product->name}\" only has {$product->stock} items left in stock (you requested {$requestedQty}).";
                    continue;
                }

                // Use DB price for total calculation (never trust session price)
                $price = (float) ($product->base_price ?? $product->price ?? $item['price']);
                $total += $price * $requestedQty;

                $resolvedItems[] = [
                    'product' => $product,
                    'quantity' => $requestedQty,
                    'price' => $price,
                ];
            }

            // If any stock errors, abort transaction and redirect back
            if (!empty($stockErrors)) {
                DB::rollBack();
                return redirect()->route('cart.index')
                    ->with('error', implode("\n", $stockErrors));
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'payment_status' => 'pending',
                'status' => 'pending',
                'shipping_address' => $data['address'] . ', ' . $data['city'],
            ]);

            // Create order items and atomically deduct stock
            foreach ($resolvedItems as $resolved) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $resolved['product']->id,
                    'quantity' => $resolved['quantity'],
                    'price_at_purchase' => $resolved['price'],
                ]);

                // Atomic decrement — prevents race conditions
                $resolved['product']->decrement('stock', $resolved['quantity']);
            }

            DB::commit();
            // ─── END TRANSACTION ─────────────────────────────────────────

            // Dispatch OrderPlaced event (triggers async email via queue)
            OrderPlaced::dispatch($order);

            // Clear cart after successful order
            $request->session()->forget('cart');
            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', 'An error occurred while placing your order. Please try again.');
        }
    }

    /**
     * Hiển thị trang thành công sau khi đặt hàng.
     */
    public function success(\App\Models\Order $order): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}

