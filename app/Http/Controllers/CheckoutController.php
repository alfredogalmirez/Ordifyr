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
            return redirect('/products')->with('error', 'Your cart is empty.');
        }

        if ($cart->items->isEmpty()) {
            return redirect('/products')->with('error', 'Add item first.');
        }

        $subtotal = 0;

        foreach ($cart->items as $item) {
            if ($item->quantity <= 0) {
                return redirect('/products')
                    ->with('error', 'One of the items has an invalid quantity.');
            }

            if (!$item->product) {
                return redirect('/products')
                    ->with('error', 'Remove unavailable items.');
            }

            if ($item->quantity > $item->product->stock) {
                return redirect('/products')
                    ->with('error', "Not enought stock for {$item->product->name}.");
            }

            if (!is_numeric($item->product->price_cents) || $item->product->price_cents <= 0) {
                return redirect('/products')->with('error', "Invalid price for {$item->product->name}.");
            }


            $subtotal += $item->product->price_cents * $item->quantity;
        }

        if ($subtotal <= 0) {
            return redirect('/products')->with('error', 'Something is wrong.');
        }

        return redirect()->route('checkout.index');
    }

    public function index(Request $request)
    {

        $userId = $request->user()->id;

        $cart = Cart::with(['items.product'])->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/products')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;

        foreach ($cart->items as $item) {
            if (!$item->product) {
                return redirect('/products')->with('error', 'Remove unavailable items.');
            }

            if ($item->quantity <= 0) {
                return redirect('/products')->with('error', 'One of the items has an invalid quantity.');
            }

            $subtotal += $item->product->price_cents * $item->quantity;
        }

        if ($subtotal <= 0) {
            return redirect('/products')->with('error', 'Something is wrong.');
        }

        return view('checkout.index', compact('cart', 'subtotal'));
    }
}
