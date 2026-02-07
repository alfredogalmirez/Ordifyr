<x-layout>
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-3xl font-extrabold tracking-tight mb-8">
            Your cart
        </h1>

        @if ($items->isEmpty())
            <div class="rounded-2xl bg-white p-8 shadow-sm">
                <p class="text-slate-600">
                    Your cart is empty.
                </p>

                <a href="/products" class="inline-block mt-4 font-semibold text-indigo-600 hover:underline">
                    Browse products →
                </a>
            </div>
        @else
            {{-- CART ITEMS --}}
            <div class="space-y-4">
                @foreach ($items as $item)
                    <div
                        class="rounded-2xl bg-white p-5 shadow-sm flex flex-col gap-4
            sm:grid sm:grid-cols-[1fr_140px_160px] sm:items-center">

                        {{-- Product info --}}
                        <div>
                            <div class="font-semibold text-slate-900">
                                {{ $item->product->name ?? 'Unknown product' }}
                            </div>
                            <div class="text-sm text-slate-500">
                                ₱{{ number_format($item->product->price ?? 0, 2) }} each
                            </div>
                        </div>

                        {{-- Quantity controls --}}
                        <div class="flex items-center gap-2">
                            <form action="{{ route('cart.items.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="button" value="-"
                                    onclick="
                                    let input = document.getElementById('qty-{{ $item->id }}');
                                    input.value = Math.max(1, parseInt(input.value) - 1 )
                                    this.form.submit();
                                "
                                    class="h-9 w-9 rounded-lg bg-slate-100 text-lg hover:bg-slate-200 disabled:opacity-40"
                                    {{ $item->quantity === 1 ? 'disabled' : '' }}>

                                <input type="number" name="quantity" id="qty-{{ $item->id }}" inputmode="numeric"
                                    min="1" value="{{ $item->quantity }}"
                                    class="h-9 w-14 rounded-lg border border-slate-200 text-center font-semibold tabular-nums
                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                    onchange="this.form.submit()"
                                    onkeydown="if(event.key==='Enter'){ event.preventDefault(); this.form.submit(); }">

                                <input type="button" value="+"
                                    onclick="
                                let input = document.getElementById('qty-{{ $item->id }}');
                                input.value = parseInt(input.value) + 1;
                                this.form.submit();
                                "
                                    class="h-9
                                    w-9 rounded-lg bg-slate-100 text-lg hover:bg-slate-200">
                            </form>
                        </div>

                        {{-- Total + delete --}}
                        <div class="flex items-center gap-6 justify-between sm:justify-end">
                            <div class="text-lg font-bold">
                                ₱{{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}
                            </div>

                            <form action="{{ route('cart.items.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm font-medium text-red-600 hover:underline">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- SUMMARY --}}
            <div class="mt-10 flex flex-col sm:flex-row sm:justify-end gap-4">
                <div class="w-full sm:w-80 rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex justify-between text-slate-600 mb-2">
                        <span>Subtotal</span>
                        <span class="font-semibold text-slate-900">
                            ₱{{ number_format($subtotal, 2) }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-500">
                        Shipping and fees calculated at checkout.
                    </p>
                </div>

                <form method="POST" action="{{ route('checkout.start') }}">
                    @csrf
                    <button
                        class="h-14 px-8 rounded-xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-500 transition">
                        Proceed to checkout
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-layout>
