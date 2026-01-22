<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function store(Request $request){
        // dd('HIT', $request->all(), Auth::user()->id);
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $validated['product_id'])->first();

        if($cartItem){
           $cartItem->increment('quantity', 1);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity' => 1,
            ]);
        }

        return redirect('/products')->with('success', 'Added to cart!');
    }


    public function destroy(CartItem $cartItem){

    if($cartItem->cart->user_id !== Auth::id()){
        abort(403, 'Unauthorized action');
    }

    $cartItem->delete();

    return redirect('/products')->with('message', 'Item removed from cart.');
    }
}
