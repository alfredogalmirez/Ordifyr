<div
    class="fixed top-4 right-4 z-50 space-y-2"
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
>
    @if (session('success'))
        <div
            x-show="show"
            x-transition.opacity.duration.300ms
            class="w-80 rounded-md bg-green-600 text-white px-4 py-3 shadow-lg"
        >
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            x-show="show"
            x-transition.opacity.duration.300ms
            class="w-80 rounded-md bg-red-600 text-white px-4 py-3 shadow-lg"
        >
            {{ session('error') }}
        </div>
    @endif
</div>
