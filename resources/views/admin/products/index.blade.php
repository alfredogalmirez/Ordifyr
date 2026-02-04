<x-admin-layout title="Products">
    {{-- Top title --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Products</h1>
            <p class="text-sm text-slate-600 mt-1">Manage stock, pricing, and availability.</p>
        </div>

        <x-slot:actions>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold bg-indigo-900 text-white shadow-sm hover:bg-slate-800 transition">
                + Add product
            </a>
        </x-slot:actions>
    </div>

    {{-- Card --}}
    <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
        {{-- Toolbar --}}
        <div class="p-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between bg-white">
            <div class="text-sm text-slate-600">
                Total products: <span class="font-semibold text-slate-900">{{ $products->total() ?? $products->count() }}</span>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="w-full sm:w-auto">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search product..."
                    class="w-full sm:w-72 rounded-xl bg-slate-100 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-600/30"
                />
            </form>
        </div>

        {{-- Table (clean, minimal lines) --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">Name</th>
                        <th class="text-right px-5 py-3 font-semibold">Price</th>
                        <th class="text-right px-5 py-3 font-semibold">Stock</th>
                        <th class="text-center px-5 py-3 font-semibold">Status</th>
                        <th class="text-right px-5 py-3 font-semibold">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-900">{{ $product->name }}</div>
                                <div class="text-xs text-slate-500">ID: {{ $product->id }}</div>
                            </td>

                            <td class="px-5 py-4 text-right font-semibold text-slate-900">
                                ₱{{ number_format($product->price_cents / 100, 2) }}
                            </td>

                            <td class="px-5 py-4 text-right text-slate-700">
                                {{ $product->stock }}
                            </td>

                            <td class="px-5 py-4 text-center">
                                @php
                                    $stock = (int) $product->stock;
                                @endphp

                                @if ($stock <= 0)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        Out of stock
                                    </span>
                                @elseif ($stock < 5)
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        Low stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        In stock
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center rounded-xl px-4 py-2 text-xs font-semibold bg-white shadow-sm hover:bg-slate-50 transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer / pagination --}}
        <div class="p-5">
            @if (method_exists($products, 'links'))
                {{ $products->withQueryString()->links() }}
            @endif
        </div>
    </div>
</x-admin-layout>
