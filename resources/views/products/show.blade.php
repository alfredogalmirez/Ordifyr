<x-layout>
    <a href="/products" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900">
        ← Back to products
    </a>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <!-- Image -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="aspect-[4/3] bg-slate-100">
                <div class="flex h-full items-center justify-center text-slate-400">
                    <span class="text-sm">Image</span>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900">
                        {{ $product->name }}
                    </h1>

                    <p class="mt-2 text-lg font-semibold text-slate-900">
                        ₱{{ number_format($product->price_cents / 100, 2) }}
                    </p>
                </div>

                @if($product->stock > 0)
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">
                        In stock
                    </span>
                @else
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 ring-1 ring-slate-200">
                        Out of stock
                    </span>
                @endif
            </div>

            <div class="mt-4 text-sm text-slate-600">
                <p class="leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>

            <div class="mt-6 flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3 text-sm">
                <span class="text-slate-600">Available stock</span>
                <span class="font-semibold text-slate-900">{{ $product->stock }}</span>
            </div>

            <div class="mt-6 flex gap-3">
                <button
                    class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:cursor-not-allowed disabled:bg-slate-200 disabled:text-slate-500"
                    @if($product->stock <= 0) disabled @endif
                >
                    Add to cart
                </button>

                <button class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Save
                </button>
            </div>

            <p class="mt-3 text-xs text-slate-500">
                *Cart feature will be enabled next.
            </p>
        </div>
    </div>
</x-layout>
