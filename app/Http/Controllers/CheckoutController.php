<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function start(Request $request)
    {

        $userId = $request->user()->id;

        $cart = Cart::with(['items.product'])->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/products')->with('error', 'Your cart is empty.');
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

    public function createOrderFromCart(Request $request)
    {
        $user = $request->user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->load(['items.product']);

        if ($cart->items->isEmpty()) {
            return redirect('/products')->with('error', 'Your cart is empty.');
        }

        $totalCents = 0;

        foreach ($cart->items as $item) {
            if (
                !$item->product ||
                $item->quantity <= 0 ||
                $item->quantity > $item->product->stock
            ) {
                return redirect('/products')->with('error', 'Invalid cart items.');
            }

            $priceCents = (int) $item->product->getRawOriginal('price_cents');

            if ($priceCents <= 0) {
                return redirect('/products')->with('error', 'Invalid product price.');
            }

            $totalCents += $priceCents * $item->quantity;
        }

        if ($totalCents <= 0) {
            return redirect('/products')->with('error', 'Something went wrong.');
        }

        $order = Order::create([
            'user_id' => $user->id,
            'amount_cents' => $totalCents,
            'status' => 'pending',
            'reference_number' => 'ORD-' . now()->timestamp,
        ]);

        foreach ($cart->items as $item) {
            $priceCents = (int) $item->product->getRawOriginal('price_cents');

            $order->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price_cents' => $priceCents,
                'line_total_cents' => $priceCents * $item->quantity,
            ]);
        }

        return $order;
    }

    public function gcash(Request $request)
    {
        $result = $this->createOrderFromCart($request);

        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }


        $order = $result;
        $order->load(['items.product']);

        $secretKey = config('services.paymongo.secret');

        $payload = [
            'data' => [
                'attributes' => [
                    'payment_method_types' => ['gcash'],
                    'send_email_receipt' => false,
                    'show_description' => true,
                    'show_line_items' => true,
                    'cancel_url' => config('app.url') . route('checkout.cancel', [], false) . '?order_id=' . $order->id,
                    'success_url' => config('app.url') . route('checkout.success', [], false) . '?order_id=' . $order->id,

                    // You can either send amount OR line_items (PayMongo supports line_items for checkout)
                    'line_items' => $order->items->map(fn($it) => [
                        'currency' => 'PHP',
                        'amount' => (int) $it->price_cents,     // per-unit cents
                        'name' => $it->product?->name ?? 'Item',
                        'quantity' => (int) $it->quantity,
                    ])->values()->all(),

                    'reference_number' => $order->reference_number ?? ('ORD-' . $order->id),
                    'description' => 'Ordifyr Order #' . $order->id,
                ],
            ],
        ];

        $res = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->post('https://api.paymongo.com/v1/checkout_sessions', $payload);

        if (!$res->successful()) {
            // Optional: mark order failed, log $res->json()
            return redirect()->route('checkout.index')->with('error', 'Payment gateway error. Please try again.');
        }

        $sessionId = $res['data']['id'] ?? null;
        $checkoutUrl = $res['data']['attributes']['checkout_url'] ?? null;

        if (!$sessionId || !$checkoutUrl) {
            return redirect()->route('checkout.index')->with('error', 'Payment gateway returned an invalid response.');
        }

        // Step 3: Save session id on your order
        $order->update([
            'paymongo_checkout_session_id' => $sessionId,
            'status' => 'awaiting_payment',
        ]);


        // Step 4: Redirect user to PayMongo hosted page
        return redirect()->away($checkoutUrl);
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect('/products')->with('error', 'Missing order id.');
        }

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Payment initiated. Waiting for confirmation...');
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect('/products')->with('error', 'Missing order id.');
        }

        return redirect()->route('orders.show', $orderId)
            ->with('error', 'Payment cancelled.');
    }
}
