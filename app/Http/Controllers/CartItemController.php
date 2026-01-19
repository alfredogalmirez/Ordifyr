<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

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

        return back()->with('success', 'Added to cart!');
    }
}
