<x-admin-layout title="Edit Product">
    <div class="max-w-3xl mx-auto">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Edit product</h1>
                <p class="text-sm text-slate-600 mt-1">
                    Update name, price, and stock for
                    <span class="font-semibold text-slate-900">{{ $product->name }}</span>.
                </p>
            </div>

            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold bg-white shadow-sm hover:bg-slate-50 transition">
                ← Back
            </a>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
            <form method="POST" action="{{ route('admin.products.update', $product) }}"
                enctype="multipart/form-data"
                class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PATCH')

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Product name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full rounded-xl bg-slate-100 px-4 py-3 text-slate-900 placeholder:text-slate-500
                               focus:outline-none focus:ring-2 focus:ring-indigo-600/30"
                        placeholder="Enter product name" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price + Stock --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Price (₱)</label>
                        <input type="number" name="price" step="0.01" min="0"
                            value="{{ old('price', $product->price ?? ($product->price_cents / 100)) }}"
                            class="w-full rounded-xl bg-slate-100 px-4 py-3 text-slate-900 placeholder:text-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-600/30"
                            placeholder="0.00" required>
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Stock</label>
                        <input type="number" name="stock" min="0" step="1"
                            value="{{ old('stock', $product->stock) }}"
                            class="w-full rounded-xl bg-slate-100 px-4 py-3 text-slate-900 placeholder:text-slate-500
                                   focus:outline-none focus:ring-2 focus:ring-indigo-600/30"
                            placeholder="0" required>
                        @error('stock')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Product image</label>

                    @if ($product->image)
                        <div class="mb-4 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="h-20 w-20 rounded-2xl object-cover shadow-sm">
                            <div class="text-sm">
                                <div class="font-semibold text-slate-900">Current image</div>
                                <div class="text-xs text-slate-500">Upload a new one to replace it.</div>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="image" accept="image/*"
                        class="block w-full rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-700
                               file:mr-4 file:rounded-xl file:border-0
                               file:bg-indigo-900 file:px-4 file:py-2
                               file:text-sm file:font-semibold file:text-white
                               hover:file:bg-indigo-800 transition">

                    <p class="mt-2 text-xs text-slate-500">
                        JPG, PNG, or WEBP. Max 2MB.
                    </p>

                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status panel --}}
                <div class="rounded-2xl bg-slate-50 p-4 flex items-center justify-between">
                    <div class="text-sm text-slate-700">
                        Current status:
                        @php $stock = (int) $product->stock; @endphp

                        @if ($stock <= 0)
                            <span class="ml-2 inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                Out of stock
                            </span>
                        @elseif ($stock < 5)
                            <span class="ml-2 inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                Low stock
                            </span>
                        @else
                            <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                In stock
                            </span>
                        @endif
                    </div>

                    <div class="text-xs text-slate-500">
                        Product ID: {{ $product->id }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-2 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold bg-white shadow-sm hover:bg-slate-50 transition">
                        Cancel
                    </a>

                    <button type="submit"
                        class="inline-flex items-center rounded-xl px-5 py-2.5 text-sm font-semibold bg-indigo-700 text-white shadow-sm hover:bg-indigo-600 transition">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
