<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
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
        if (str_contains($eventType, 'paid')) {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
                'paymongo_event_id' => $eventId,
                'paymongo_payment_id' => data_get($payload, 'data.attributes.data.id'),
            ]);
        } elseif (str_contains($eventType, 'failed')) {
            $order->update([
                'status' => 'failed',
                'paymongo_event_id' => $eventId,
            ]);
        } elseif (str_contains($eventType, 'expired')) {
            $order->update([
                'status' => 'expired',
                'paymongo_event_id' => $eventId,
            ]);
        } else {
            // Store event id anyway so you can inspect and not reprocess
            $order->update(['paymongo_event_id' => $eventId]);
        }

        return response()->json(['ok' => true], 200);
    }
}
