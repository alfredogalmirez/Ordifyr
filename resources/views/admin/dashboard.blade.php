<x-admin-layout>
    <div class="min-h-screen bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                        Admin
                    </h1>
                    <p class="text-sm text-slate-600 mt-1">
                        Overview, quick actions, and alerts.
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="/admin/products"
                        class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold bg-indigo-900 text-white shadow-sm hover:bg-indigo-800 transition">
                        Products
                    </a>
                    <a href="/admin/orders"
                        class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold bg-white text-slate-800 shadow-sm hover:bg-slate-50 transition">
                        Orders
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Products</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-2">
                        {{ $stats['totalProducts'] ?? 0 }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">All products currently in the catalog.</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Low Stock Items</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-2">
                        {{ $stats['lowStockCount'] ?? 0 }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">Items below your low-stock threshold.</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Orders</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-2">
                        {{ $stats['totalOrders'] ?? 0 }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">All orders recorded in the system.</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Pending Orders</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-2">
                        {{ $stats['pendingOrders'] ?? 0 }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">Orders waiting for confirmation/process.</p>
                </div>
            </div>

            {{-- Main --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-8">

                {{-- Low Stock List (no table grid vibe) --}}
                <div class="lg:col-span-2 rounded-2xl bg-white shadow-sm overflow-hidden">
                    <div class="p-5 flex items-center justify-between">
                        <h2 class="text-lg font-bold tracking-tight text-slate-900">
                            Low stock products
                        </h2>
                        <a href="/admin/products" class="text-sm font-semibold text-indigo-600 hover:underline">
                            Manage →
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse(($lowStockProducts ?? []) as $product)
                            <div class="p-5 flex items-center justify-between hover:bg-slate-50 transition">
                                <div>
                                    <div class="font-semibold text-slate-900">
                                        {{ $product->name }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        Stock running low — consider restock.
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span
                                        class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $product->stock }}
                                    </span>

                                    <a href="/admin/products/{{ $product->id }}/edit"
                                        class="inline-flex items-center rounded-xl px-4 py-2 text-xs font-semibold bg-white shadow-sm hover:bg-slate-50 transition">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500">
                                No low stock products.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
                    <div class="p-5">
                        <h2 class="text-lg font-bold tracking-tight text-slate-900">Quick actions</h2>
                        <p class="text-sm text-slate-600 mt-1">Common admin tasks.</p>
                    </div>

                    <div class="p-5 space-y-3">
                        <a href="/admin/products/create"
                            class="block w-full text-center rounded-xl px-4 py-3 text-sm font-semibold bg-indigo-900 text-white shadow-sm hover:bg-slate-800 transition">
                            + Add product
                        </a>

                        <a href="/admin/products"
                            class="block w-full text-center rounded-xl px-4 py-3 text-sm font-semibold bg-white text-slate-800 shadow-sm hover:bg-slate-50 transition">
                            Update stock
                        </a>

                        <a href="/admin/orders"
                            class="block w-full text-center rounded-xl px-4 py-3 text-sm font-semibold bg-white text-slate-800 shadow-sm hover:bg-slate-50 transition">
                            Review orders
                        </a>

                        <div class="mt-4 rounded-xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-600">
                                Tip: set your low-stock threshold to 5 so this list stays meaningful.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-admin-layout>
