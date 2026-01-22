<x-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

        @if ($items->isEmpty())
            <div class="p-6 rounded border bg-white">
                <p class="text-gray-600">Your cart is empty.</p>
            </div>
        @else
            <div class="bg-white border rounded-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-3">Product</th>
                            <th class="text-right p-3">Price</th>
                            <th class="text-right p-3">Qty</th>
                            <th class="text-right p-3">Total</th>
                            <th class="text-right p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $item->product->name ?? 'Unknown product' }}
                                </td>
                                <td class="p-3 text-right">
                                    ₱{{ number_format($item->product->price ?? 0, 2) }}
                                </td>
                                <td class="p-3 text-right">
                                    {{ $item->quantity }}
                                </td>
                                <td class="p-3 text-right font-semibold">
                                    ₱{{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}
                                </td>
                                <td class="p-3 text-right font-semibold">
                                    <form action="{{ route('cart.items.destroy', $item->id )}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <div class="w-full sm:w-80 bg-white border rounded-lg p-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-bold">₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

</x-layout>
