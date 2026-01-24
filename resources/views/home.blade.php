<x-layout>
    <section class="text-center py-20">
        <h1 class="text-4xl font-bold mb-4">
            Welcome to Ordifyr
        </h1>

        <p class="text-gray-600 mb-6">
            Simple shopping. Fast checkout. No hassle.
        </p>

        <div class="flex justify-center gap-4">
            <a href="/products" class="btn-primary">Browse Products</a>
            <a href="/cart" class="btn-secondary">
                View Cart ({{ $cartCount }})
            </a>
        </div>
    </section>
</x-layout>
