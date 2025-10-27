<?php 
 
 namespace App\Http\Controllers; 
 
 use App\Http\Requests\CartAddRequest; 
 use App\Http\Requests\CartUpdateRequest; 
 use App\Models\Product; 
 use App\Services\CartService; 
 use App\Support\Money; 
 
 class CartController extends Controller 
 { 
     public function __construct(private CartService $cart) {} 
 
     public function index() 
     { 
         $items = $this->cart->items(); 
         $total = $this->cart->totalVnd(); 
 
         return view('cart', [ 
             'items' => $items, 
             'total_vnd' => $total, 
             'total_fmt' => Money::formatVnd($total), 
         ]); 
     } 
 
     public function add(CartAddRequest $request, int $id) 
     { 
         $product = Product::findOrFail($id); 
         $this->cart->add($product, (int)$request->integer('quantity')); 
         return redirect('/cart')->with('success', 'Added to cart.'); 
     } 
 
     public function update(CartUpdateRequest $request, int $id) 
     { 
         $this->cart->update($id, (int)$request->integer('quantity')); 
         return redirect('/cart')->with('success', 'Quantity updated.'); 
     } 
 
     public function remove(int $id) 
     { 
         $this->cart->remove($id); 
         return redirect('/cart')->with('success', 'Item removed.'); 
     } 
 
     public function clear() 
     { 
         $this->cart->clear(); 
         return redirect('/cart')->with('success', 'Cart cleared.'); 
     } 
 }
