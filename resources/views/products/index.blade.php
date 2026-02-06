<x-layout>
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-semibold tracking-tight">Products</h1>
        <p class="text-sm text-slate-600">
            Browse items available in Ordifyr.
        </p>
    </div>

    @if ($products->isEmpty())
        <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 text-slate-600">
            No products available right now.
        </div>
    @else
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <a href="{{ url('/products/' . $product->slug) }}"
                    class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md">

                    {{-- Image --}}
                    <div class="aspect-[4/3] overflow-hidden rounded-xl bg-slate-100">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center text-slate-400">
                                <span class="text-sm">No image</span>
                            </div>
                        @endif
                    </div>


                    <div class="mt-4 flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="truncate text-base font-semibold text-slate-900 group-hover:text-indigo-600">
                                {{ $product->name }}
                            </h2>

                            <p class="mt-1 text-sm font-medium text-slate-800">
                                ₱{{ number_format($product->price_cents / 100, 2) }}
                            </p>
                        </div>

                        @if ($product->stock > 5)
                            <span
                                class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">
                                In stock
                            </span>
                        @elseif($product->stock <= 5)
                            <span
                                class="shrink-0 rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700 ring-1 ring-yellow-200">
                                Low stock
                            </span>
                        @else
                            <span
                                class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-slate-200">
                                Out
                            </span>
                        @endif
                    </div>

                    <p class="mt-3 line-clamp-2 text-sm text-slate-600">
                        {{ $product->description }}
                    </p>

                    <div class="mt-4 flex items-center justify-between text-sm">
                        <span class="text-slate-500">
                            Stock: <span class="font-medium text-slate-700">{{ $product->stock }}</span>
                        </span>

                        <span class="font-medium text-indigo-600">
                            View →
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-layout>
