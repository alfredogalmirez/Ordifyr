<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymongoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // 1) Identify event type
        $eventType = data_get($payload, 'data.attributes.type');
        $eventId   = data_get($payload, 'data.id');

        // 2) Find checkout_session_id from payload (depends on event)
        $checkoutSessionId =
            data_get($payload, 'data.attributes.data.attributes.checkout_session_id')
            ?? data_get($payload, 'data.attributes.data.attributes.checkout_session.id')
            ?? data_get($payload, 'data.attributes.data.attributes.checkout_session');

        if (!$eventType || !$eventId) {
            return response()->json(['ok' => false, 'msg' => 'Invalid webhook payload'], 400);
        }

        // 3) Idempotency: ignore same event twice
        if (Order::where('paymongo_event_id', $eventId)->exists()) {
            return response()->json(['ok' => true, 'msg' => 'Duplicate event ignored'], 200);
        }

        if (!$checkoutSessionId) {
            Log::warning('PayMongo webhook missing checkoutSessionId', $payload);
            return response()->json(['ok' => false, 'msg' => 'Missing checkout session id'], 400);
        }

        $order = Order::where('paymongo_checkout_session_id', $checkoutSessionId)->first();

        if (!$order) {
            Log::warning('PayMongo webhook order not found', ['checkout_session_id' => $checkoutSessionId]);
            return response()->json(['ok' => false, 'msg' => 'Order not found'], 404);
        }

        // 4) Update order based on event
        // NOTE: eventType exact values depend on PayMongo event names in your dashboard.
        // We'll handle common intent: paid/failed/expired.
        switch ($eventType) {
            case 'checkout_session.payment.paid':
                if ($order->status === 'paid') {

                    $order->update(['paymongo_event_id' => $eventId]);
                    break;
                }

                DB::transaction(function () use ($order, $payload, $eventId) {

                    // Lock the order row to prevent races
                    $order = Order::where('id', $order->id)->lockForUpdate()->first();

                    // Reload items + product and lock products while updating stock
                    $items = $order->items()->with('product')->get();

                    // 1) Validate stock again (stock might have changed since snapshot)
                    foreach ($items as $it) {
                        if (!$it->product) {
                            throw new \RuntimeException("Order item missing product.");
                        }

                        // lock product row
                        $product = $it->product()->lockForUpdate()->first();

                        if ($it->quantity <= 0) {
                            throw new \RuntimeException("Invalid quantity.");
                        }

                        if ($product->stock < $it->quantity) {
                            // You can decide what status to set here. Some stores mark as "on_hold" or "paid_needs_review".
                            throw new \RuntimeException("Insufficient stock for product {$product->id}.");
                        }
                    }

                    // 2) Deduct stock
                    foreach ($items as $it) {
                        $product = $it->product()->lockForUpdate()->first();
                        $product->decrement('stock', $it->quantity);
                    }

                    $order->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'paymongo_event_id' => $eventId,
                        'paymongo_payment_id' => data_get($payload, 'data.attributes.data.id'),
                    ]);

                    // 4) Clear cart (if your cart is per-user)
                    // Assumes you have Cart model with relation items()
                    $cart = \App\Models\Cart::where('user_id', $order->user_id)->first();

                    if ($cart) {
                        $cart->items()->delete();
                        // optional: delete cart itself
                        // $cart->delete();
                    }
                });
                break;
            case 'checkout_session.payment.failed':
                $order->update([
                    'status' => 'failed',
                    'paymongo_event_id' => $eventId,
                ]);
                break;
            case 'checkout_session.expired':
                $order->update([
                    'status' => 'expired',
                    'paymongo_event_id' => $eventId,
                ]);
                break;
            default:
                Log::info('Unhandled PayMongo event', [
                    'event_type' => $eventType,
                    'order_id' => $order->id,
                ]);

                $order->update(['paymongo_event_id' => $eventId]);
        }

        return response()->json(['ok' => true], 200);
    }

    public function success(Request $request)
    {
        $order = Order::where('id', $request->query('order_id'))
            ->where('user_id', $request->user->id)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    public function cancel(Request $request)
    {
        $order = Order::where('id', $request->query('order_id'))
            ->where('user_id', $request->user()->id)
            ->first();

        if ($order && $order->status === 'awaiting_payment') {
            $order->update(['status' => 'cancelled']);
        }

        return view('checkout.cancel', compact('order'));
    }
}
