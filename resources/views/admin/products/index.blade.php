<x-admin-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">Products</h1>
                <p class="text-gray-600 text-sm">Manage product stock, pricing, and availability.</p>
            </div>

            <x-slot:actions>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-purple-800 text-white hover:bg-purple-900">
                    + Add Product
                </a>
            </x-slot:actions>
        </div>

        <div class="bg-white border rounded-lg overflow-hidden">
            <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Total products: <span class="font-semibold">—</span>
                </div>

                <input type="text" placeholder="Search product..."
                    class="w-64 px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring">
            </div>

            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left p-3">Name</th>
                        <th class="text-right p-3">Price</th>
                        <th class="text-right p-3">Stock</th>
                        <th class="text-center p-3">Status</th>
                        <th class="text-right p-3">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($products as $product)
                        {{-- TEMP rows (UI only) --}}
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="p-3 text-right">₱{{ number_format($product->price, 2) }}</td>
                            <td class="p-3 text-right">{{ $product->stock }}</td>
                            <td class="p-3 text-center">
                                @if ($product->stock > 5)
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                        In stock
                                    </span>
                                @elseif ($product->stock <= 5)
                                    <span class="ml-1 px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Low stock</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                        Out of stock
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 text-right">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg border hover:bg-gray-50">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-600">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4 border-t text-sm text-gray-600">
            </div>
        </div>
    </div>
</x-admin-layout>
