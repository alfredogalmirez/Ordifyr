<x-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Checkout</h1>

        <div class="bg-white border rounded-lg overflow-hidden">
            <div class="p-4 border-b bg-gray-50">
                <p class="font-semibold">Review your order</p>
                <p class="text-sm text-gray-600">Please confirm quantities and totals before paying.</p>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-3">Product</th>
                        <th class="text-right p-3">Price</th>
                        <th class="text-right p-3">Qty</th>
                        <th class="text-right p-3">Line total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($cart->items as $item)
                        @php
                            $product = $item->product;
                        @endphp

                        @if ($product)
                            @php
                                $price = $product->price_cents;
                                $lineTotal = $price * $item->quantity;
                            @endphp

                            <tr>
                                <td class="p-3">
                                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">In stock: {{ $product->stock }}</div>
                                </td>
                                <td class="p-3 text-right">₱{{ number_format($price / 100, 2) }}</td>
                                <td class="p-3 text-right">{{ $item->quantity }}</td>
                                <td class="p-3 text-right font-medium">₱{{ number_format($lineTotal / 100, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="p-4 border-t">
                <div class="flex justify-end">
                    <div class="w-full max-w-sm space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span>₱{{ number_format($subtotal / 100, 2) }}</span>
                        </div>

                        {{-- Optional placeholders for later --}}
                        <div class="flex justify-between text-gray-500 text-sm">
                            <span>Shipping</span>
                            <span>Calculated later</span>
                        </div>

                        <div class="flex justify-between text-gray-900 font-semibold text-lg pt-2 border-t">
                            <span>Total</span>
                            <span>₱{{ number_format($subtotal / 100, 2) }}</span>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <a href="/cart"
                               class="w-1/2 text-center px-4 py-3 rounded-lg border bg-white hover:bg-gray-50">
                                Back to cart
                            </a>

                            {{-- For now this can point to a placeholder route --}}
                            <form method="POST" action="{{ route('checkout.start') }}" class="w-1/2">
                                @csrf
                                <button class="w-full px-4 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                                    Confirm & Pay
                                </button>
                            </form>
                        </div>

                        <p class="text-xs text-gray-500 pt-2">
                            You’ll be redirected to the payment page next.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
