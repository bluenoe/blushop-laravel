<?php 
 
 namespace App\Http\Controllers; 
 
 use App\Http\Requests\CheckoutPlaceRequest; 
 use App\Services\CartService; 
 use App\Services\OrderPlacementService; 
 use App\Support\Money; 
 use Illuminate\Support\Facades\Auth; 
 use RuntimeException; 
 
 class CheckoutController extends Controller 
 { 
     public function __construct( 
         private CartService $cart, 
         private OrderPlacementService $placer 
     ) { 
         $this->middleware('auth')->only(['index','place']); 
     } 
 
     public function index() 
     { 
         if ($this->cart->isEmpty()) { 
             return redirect('/cart')->with('warning', 'Cart is empty.'); 
         } 
 
         $items = $this->cart->snapshot(); 
         $total = $this->cart->totalVnd(); 
 
         return view('checkout', [ 
             'items' => $items, 
             'total_vnd' => $total, 
             'total_fmt' => Money::formatVnd($total), 
         ]); 
     } 
 
     public function place(CheckoutPlaceRequest $request) 
     { 
         if ($this->cart->isEmpty()) { 
             return redirect('/cart')->with('warning', 'Cart is empty.'); 
         } 
 
         try { 
             $order = $this->placer->place( 
                 Auth::user(), 
                 $request->only(['name','address']), 
                 $this->cart 
             ); 
         } catch (RuntimeException $e) { 
             return redirect('/cart')->with('error', $e->getMessage()); 
         } 
 
         return view('checkout_success', [ 
             'orderCode' => $order->code, 
             'total_vnd' => $order->total_vnd, 
             'total_fmt' => Money::formatVnd($order->total_vnd), 
         ])->with('success', 'Order placed!'); 
     } 
 }
