<x-layout title="Order">
    <div class="max-w-4xl mx-auto py-12">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                Order {{ $order->reference_number ?? ('#' . $order->id) }}
            </h1>

            <div class="mt-2 flex items-center gap-3 text-sm">
                <span class="text-slate-600">Status</span>

                @php
                    $status = strtolower($order->status);
                @endphp

                @if ($status === 'paid')
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                        Paid
                    </span>
                @elseif ($status === 'pending' || $status === 'awaiting_payment')
                    <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-700">
                        Awaiting payment
                    </span>
                @elseif ($status === 'failed' || $status === 'cancelled')
                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                        {{ ucfirst($status) }}
                    </span>
                @else
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                        {{ ucfirst($status) }}
                    </span>
                @endif
            </div>
        </div>

        {{-- Items --}}
        <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-bold tracking-tight text-slate-900">
                    Items
                </h2>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach ($order->items as $item)
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="font-semibold text-slate-900">
                                {{ $item->product?->name ?? 'Item' }}
                            </div>
                            <div class="text-sm text-slate-500">
                                Qty: {{ $item->quantity }}
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-slate-500">
                                ₱{{ number_format(($item->price_cents ?? 0) / 100, 2) }} each
                            </div>
                            <div class="text-lg font-bold text-slate-900">
                                ₱{{ number_format(($item->line_total_cents ?? 0) / 100, 2) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Total --}}
            <div class="p-6 bg-slate-50 flex items-center justify-between">
                <span class="font-semibold text-slate-700">
                    Total
                </span>
                <span class="text-xl font-extrabold text-slate-900">
                    ₱{{ number_format(($order->amount_cents ?? 0) / 100, 2) }}
                </span>
            </div>
        </div>

        {{-- Footer hint --}}
        <div class="mt-6 text-xs text-slate-500">
            Payment confirmation may take a moment. This page will update once confirmed.
        </div>
    </div>
</x-layout>
