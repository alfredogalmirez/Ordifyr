<x-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="text-sm text-gray-600 mt-1">Overview, quick actions, and alerts.</p>
                </div>

                <div class="flex gap-2">
                    <a href="/admin/products"
                       class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium bg-gray-900 text-white hover:bg-gray-800">
                        Products
                    </a>
                    <a href="/admin/orders"
                       class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium bg-white border border-gray-200 text-gray-900 hover:bg-gray-50">
                        Orders
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">

                {{-- Card 1 --}}
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Total Products</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">
                        {{ $stats['totalProducts'] ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">All products currently in the catalog.</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Low Stock Items</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">
                        {{ $stats['lowStockCount'] ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">Items below your low-stock threshold.</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">
                        {{ $stats['totalOrders'] ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">All orders recorded in the system.</p>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Pending Orders</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">
                        {{ $stats['pendingOrders'] ?? 0 }}
                    </p>
                    <p class="text-xs text-gray-500 mt-2">Orders waiting for confirmation/process.</p>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-8">

                {{-- Low Stock Table --}}
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="font-semibold text-gray-900">Low Stock Products</h2>

                        {{-- You can change this to a named route later --}}
                        <a href="/admin/products" class="text-sm font-medium text-gray-900 hover:underline">
                            Manage Products →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="text-left px-4 py-3 font-medium">Product</th>
                                    <th class="text-left px-4 py-3 font-medium">Stock</th>
                                    <th class="text-right px-4 py-3 font-medium">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse(($lowStockProducts ?? []) as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                            {{-- Optional: show price --}}
                                            {{-- <p class="text-xs text-gray-500">₱{{ number_format($product->price, 2) }}</p> --}}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-800">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="/admin/products/{{ $product->id }}/edit"
                                               class="inline-flex items-center rounded-lg px-3 py-2 text-xs font-medium bg-white border border-gray-200 text-gray-900 hover:bg-gray-50">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                            No low stock products 🎉
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Quick Actions / Notes --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="font-semibold text-gray-900">Quick Actions</h2>
                        <p class="text-sm text-gray-600 mt-1">Common admin tasks.</p>
                    </div>

                    <div class="p-4 space-y-3">
                        <a href="/admin/products/create"
                           class="block w-full text-center rounded-lg px-3 py-2 text-sm font-medium bg-gray-900 text-white hover:bg-gray-800">
                            + Add Product
                        </a>

                        <a href="/admin/products"
                           class="block w-full text-center rounded-lg px-3 py-2 text-sm font-medium bg-white border border-gray-200 text-gray-900 hover:bg-gray-50">
                            Update Stock
                        </a>

                        <a href="/admin/orders"
                           class="block w-full text-center rounded-lg px-3 py-2 text-sm font-medium bg-white border border-gray-200 text-gray-900 hover:bg-gray-50">
                            Review Orders
                        </a>

                        <div class="mt-4 rounded-lg bg-gray-50 border border-gray-200 p-3">
                            <p class="text-xs text-gray-600">
                                Tip: set a low-stock threshold (ex: 5) and show those items here.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layout>
