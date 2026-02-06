<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function store(Request $request){

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

    return back()->with('success', 'Item removed from cart.');
    }


    public function update(Request $request, CartItem $cartItem){
        if($cartItem->cart->user_id !== Auth::id()){
            abort(403, 'Unauthorized action');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);


        $cartItem->update([
            'quantity' => $validated['quantity']
        ]);

        return back()->with('success', 'Quantity updated.');
    }
}
