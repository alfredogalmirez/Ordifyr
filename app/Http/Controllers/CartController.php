<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Request $request){
        $cart = Cart::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->first();

        $items = $cart?->items ?? collect();

        $subtotal = $items->sum(function ($item) {

            return ($item->product->price ?? 0) * $item->quantity;
        });

        return view('cart.show', compact('items', 'subtotal'));
    }
}
