<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;

class CartController extends Controller
{
    protected $product = null;

    public function __construct(Product $product){
        $this->product = $product;
    }

    public function addToCart(Request $request){
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }        
        $product = Product::where('slug', $request->slug)->first();
        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)
                            ->where('order_id', null)
                            ->where('product_id', $product->id)
                            ->first();

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            $cart->save();
            $wishlist = Wishlist::where('user_id', auth()->user()->id)
                                ->where('cart_id', null)
                                ->update(['cart_id' => $cart->id]);
        }
        request()->session()->flash('success', 'Product has been added to cart');
        return back();       
    }  

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'  => 'required',
            'quant' => 'required',
        ]);

        $product = Product::where('slug', $request->slug)->first();
        if ($request->quant[1] < 1 || empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)
                            ->where('order_id', null)
                            ->where('product_id', $product->id)
                            ->first();

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;
            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = $request->quant[1];
            $cart->amount = ($product->price * $request->quant[1]);
            $cart->save();
        }
        request()->session()->flash('success', 'Product has been added to cart.');
        return back();       
    } 

    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success', 'Cart removed successfully');
            return back();  
        }
        request()->session()->flash('error', 'Error please try again');
        return back();       
    }     

    public function cartUpdate(Request $request){
        // Ensure both arrays have the same count
        if (isset($request->quant) && count($request->quant) === count($request->qty_id)) {
            $error = array();
            $success = '';
            foreach ($request->quant as $k => $quant) {
                // Check if the current key exists in both arrays
                if (isset($request->qty_id[$k]) && isset($quant)) {
                    $id = $request->qty_id[$k];
                    $cart = Cart::find($id);
                    if ($quant > 0 && $cart) {
                        $cart->quantity = $quant;
                        $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                        $cart->amount = $after_price * $quant;
                        $cart->save();
                        $success = 'Cart updated successfully!';
                    } else {
                        $error[] = 'Cart Invalid!';
                    }
                } else {
                    $error[] = 'Invalid cart item!';
                }
            }
            return back()->withErrors($error)->with('success', $success);
        } else {
            return back()->with('error', 'Invalid cart data!');
        }
    }
    

    public function checkout(Request $request){
        return view('frontend.pages.checkout');
    }
}
