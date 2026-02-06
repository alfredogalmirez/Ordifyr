<x-layout title="Checkout">
    <div class="max-w-4xl mx-auto p-4 sm:p-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold">Checkout</h1>
                <p class="text-gray-600 text-sm mt-1">Review your order before paying.</p>
            </div>
            <a href="/cart" class="px-4 py-2 rounded-lg border bg-white">
                Back to cart
            </a>
        </div>

        {{-- Flash --}}
        @if (session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Items --}}
            <div class="lg:col-span-2 rounded-xl border bg-white overflow-hidden">
                <div class="p-4 border-b">
                    <h2 class="font-semibold">Items</h2>
                </div>

                <div class="divide-y">
                    @if (!$cart || $cart->items->isEmpty())
                        <p>Your Cart is empty.</p>
                    @else
                        @foreach ($cart->items as $item)
                            @php
                                $priceCents = $item->product ? (int) $item->product->getRawOriginal('price_cents') : 0;
                                $lineTotalCents = $priceCents * $item->quantity;
                            @endphp

                            <div class="p-4 flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold">
                                        {{ $item->product?->name ?? 'Unavailable product' }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Qty: {{ $item->quantity }}
                                        @if ($item->product)
                                            · Stock: {{ $item->product->stock }}
                                        @endif
                                    </p>
                                </div>

                                <div class="text-right">
                                    @if ($item->product)
                                        <p class="text-sm text-gray-600">
                                            ₱{{ number_format($priceCents / 100, 2) }} each
                                        </p>
                                        <p class="font-semibold">
                                            ₱{{ number_format($lineTotalCents / 100, 2) }}
                                        </p>
                                    @else
                                        <p class="text-sm text-red-600">Unavailable</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Summary + Pay --}}
            <div class="rounded-xl border bg-white p-4 h-fit">
                <h2 class="font-semibold mb-4">Order summary</h2>

                @php
                    // If you passed subtotalCents from controller, use that.
                    // Otherwise compute here (controller is better).
                    $subtotalCents = $subtotalCents ?? 0;
                @endphp

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">₱{{ number_format($subtotalCents / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">₱0.00</span>
                    </div>

                    <div class="border-t pt-3 flex justify-between text-base">
                        <span class="font-semibold">Total</span>
                        <span class="font-bold">₱{{ number_format($subtotalCents / 100, 2) }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('checkout.pay') }}" class="mt-5">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                        Pay with QRPh
                    </button>
                </form>

                <p class="text-xs text-gray-500 mt-3">
                    You’ll be redirected to PayMongo to complete payment.
                </p>
            </div>
        </div>
    </div>
</x-layout>
