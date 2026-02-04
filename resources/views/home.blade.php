<x-layout>
    {{-- HERO --}}
    <section class="py-24 max-w-3xl">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight mb-6">
            Buy fast.<br>
            Pay with GCash.<br>
            Done.
        </h1>

        <p class="text-lg text-slate-600 mb-8">
            Ordifyr is built for quick purchases — no account drama, no checkout pain, no nonsense.
        </p>

        <div class="flex flex-wrap gap-3">
            <a href="/products"
                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                Browse products
            </a>

            <a href="/cart"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-700 hover:bg-slate-100 transition">
                Cart ({{ $cartCount ?? 0 }})
            </a>
        </div>

        <p class="text-xs text-slate-500 mt-6">
            Still improving things. Expect changes.
        </p>
    </section>

    {{-- VALUE PROPS --}}
    <section class="grid gap-4 sm:grid-cols-3 pb-20">
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="font-semibold mb-1">GCash only</div>
            <p class="text-sm text-slate-600">No cards. No setup. Pay and go.</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="font-semibold mb-1">Fast checkout</div>
            <p class="text-sm text-slate-600">Under a minute if you know what you want.</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="font-semibold mb-1">Built with care</div>
            <p class="text-sm text-slate-600">Not a dropshipping clone.</p>
        </div>
    </section>

    {{-- FEATURED --}}
    <section class="pb-24">
        <div class="flex items-end justify-between mb-6">
            <h2 class="text-2xl font-bold tracking-tight">Featured</h2>
            <a href="/products" class="text-sm font-medium text-indigo-600 hover:underline">
                View all
            </a>
        </div>

        @if (($products ?? collect())->isEmpty())
            <div class="rounded-2xl border border-slate-200 bg-white p-8">
                <div class="font-semibold mb-1">No products yet</div>
                <p class="text-sm text-slate-600">Add products in the admin side, then they’ll appear here.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <a href="{{ url('/products/' . $product->slug) }}"
                        class="block rounded-2xl border border-slate-200 bg-white p-4 hover:-translate-y-0.5 hover:shadow-md transition">
                        {{-- Image placeholder (replace with real image later) --}}
                        <div class="aspect-square rounded-xl bg-slate-100 mb-3 overflow-hidden">
                            @if (!empty($product->image))
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover">
                            @endif
                        </div>

                        <div class="text-lg font-extrabold">
                            ₱{{ number_format($product->price_cents / 100, 2) }}
                        </div>

                        <div class="text-sm text-slate-800 leading-tight mt-1">
                            {{ $product->name }}
                        </div>

                        <div class="mt-2 flex items-center justify-between">
                            <div class="text-xs text-slate-500">
                                Stock: {{ $product->stock }}
                            </div>

                            @if ($product->stock > 0 && $product->stock < 5)
                                <span class="text-xs font-semibold text-red-600">
                                    Low stock
                                </span>
                            @elseif ($product->stock <= 0)
                                <span class="text-xs font-semibold text-slate-500">
                                    Out of stock
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- HOW IT WORKS --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-8">
        <h2 class="text-2xl font-bold tracking-tight mb-6">How it works</h2>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="rounded-xl bg-slate-50 p-5">
                <div class="font-semibold mb-1">1) Browse</div>
                <p class="text-sm text-slate-600">Pick what you want. Check stock.</p>
            </div>

            <div class="rounded-xl bg-slate-50 p-5">
                <div class="font-semibold mb-1">2) Add to cart</div>
                <p class="text-sm text-slate-600">Review your cart before checkout.</p>
            </div>

            <div class="rounded-xl bg-slate-50 p-5">
                <div class="font-semibold mb-1">3) Pay with GCash</div>
                <p class="text-sm text-slate-600">You’ll be redirected to PayMongo’s secure page.</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="/products"
                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white hover:bg-indigo-500 transition">
                Shop now
            </a>
        </div>
    </section>
</x-layout>
