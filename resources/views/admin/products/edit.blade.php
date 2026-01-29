<x-admin-layout>
    <div class="max-w-3xl mx-auto p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">Edit Product</h1>
                <p class="text-gray-600 text-sm">
                    Update name, price, and stock for <span class="font-medium text-gray-900">{{ $product->name }}</span>.
                </p>
            </div>

            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg border bg-white hover:bg-gray-50">
                Back
            </a>
        </div>

        <div class="bg-white border rounded-xl overflow-hidden">

            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="p-6 space-y-5">
                @csrf
                @method('PATCH')

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-1">Product Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring"
                        placeholder="Enter product name"
                        required
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price + Stock --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Price (₱)</label>
                        <input
                            type="number"
                            name="price"
                            step="0.01"
                            min="0"
                            value="{{ old('price', $product->price) }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring"
                            placeholder="0.00"
                            required
                        >
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Stock</label>
                        <input
                            type="number"
                            name="stock"
                            min="0"
                            step="1"
                            value="{{ old('stock', $product->stock) }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:outline-none focus:ring"
                            placeholder="0"
                            required
                        >
                        @error('stock')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-4 rounded-xl border bg-gray-50 flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Current status:
                        @if ($product->stock == 0)
                            <span class="ml-1 px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Out of stock</span>
                        @elseif ($product->stock <= 5)
                            <span class="ml-1 px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Low stock</span>
                        @else
                            <span class="ml-1 px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">In stock</span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">
                        Product ID: {{ $product->id }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-2 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2 rounded-lg border bg-white hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-purple-800 text-white border-4 hover:bg-purple-900">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
