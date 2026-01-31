<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function start(Request $request)
    {

        $userId = $request->user()->id;

        $cart = Cart::with(['items.product'])->where('user_id', $userId)->first();

        if (!$cart) {
            return redirect('/products')->with('message', 'Your cart is empty.');
        }

        if ($cart->items->isEmpty()) {
            return redirect('/products')->with('message', 'Add item first.');
        }

        $totalCents = 0;

        foreach ($cart->items as $item) {
            if ($item->quantity <= 0) {
                return redirect('/products')
                    ->with('message', 'One of the items has an invalid quantity.');
            }

            if (!$item->product) {
                return redirect('/products')
                    ->with('message', 'Remove unavailable items.');
            }

            if ($item->quantity > $item->product->stock) {
                return redirect('/products')
                    ->with('message', "Not enought stock for {$item->product->name}.");
            }

            $totalCents += $item->product->price_cents * $item->quantity;


            if ($totalCents <= 0) {
                return redirect('/products')->with('message', 'Something is wrong.');
            }

            return redirect()->route('checkout.index');
        }
    }

    public function index(Cart $cart){
        return view('checkout.index', compact('cart'));
    }
}
