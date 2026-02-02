<x-layout title="Order">
    <div class="max-w-4xl mx-auto p-4 sm:p-6">
        <h1 class="text-2xl font-bold mb-2">
            Order {{ $order->reference_number ?? ('#'.$order->id) }}
        </h1>

        <p class="text-gray-600 mb-6">
            Status:
            <span class="font-semibold">{{ strtoupper($order->status) }}</span>
        </p>

        <div class="rounded-xl border bg-white overflow-hidden">
            <div class="p-4 border-b font-semibold">Items</div>

            <div class="divide-y">
                @foreach($order->items as $item)
                    <div class="p-4 flex justify-between">
                        <div>
                            <div class="font-semibold">{{ $item->product?->name ?? 'Item' }}</div>
                            <div class="text-sm text-gray-600">Qty: {{ $item->quantity }}</div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-gray-600">
                                ₱{{ number_format(($item->price_cents ?? 0) / 100, 2) }} each
                            </div>
                            <div class="font-semibold">
                                ₱{{ number_format(($item->line_total_cents ?? 0) / 100, 2) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 border-t flex justify-between">
                <span class="font-semibold">Total</span>
                <span class="font-bold">
                    ₱{{ number_format(($order->amount_cents ?? 0) / 100, 2) }}
                </span>
            </div>
        </div>
    </div>
</x-layout>
