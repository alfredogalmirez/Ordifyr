@props([
    'title' => 'Admin Panel',
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Ordifyr Admin' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-[#f8fafc] text-slate-900 antialiased">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 bg-white shadow-sm">
            {{-- Brand --}}
            <div class="h-16 px-4 flex items-center">
                <a href="/admin" class="flex items-center gap-2 font-semibold tracking-tight">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm">
                        O
                    </span>

                    <div class="leading-tight">
                        <div class="text-slate-900">Ordifyr</div>
                        <div class="text-xs font-normal text-slate-500 -mt-0.5">Admin</div>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="px-3 pb-3 pt-2 space-y-1 text-sm">
                <a href="/admin"
                    class="flex items-center gap-3 rounded-xl px-3 py-2 transition
                    {{ request()->is('admin') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                        🏠
                    </span>
                    <span>Dashboard</span>
                </a>

                <a href="/admin/products"
                    class="flex items-center gap-3 rounded-xl px-3 py-2 transition
                    {{ request()->is('admin/products*') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                        📦
                    </span>
                    <span>Products</span>
                </a>

                <a href="/admin/orders"
                    class="flex items-center gap-3 rounded-xl px-3 py-2 transition
                    {{ request()->is('admin/orders*') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                        🧾
                    </span>
                    <span>Orders</span>
                </a>
            </nav>

            {{-- Bottom area --}}
            <div class="mt-auto p-4">
                <div class="rounded-2xl bg-slate-50 p-3">
                    <a href="/"
                        class="block rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-white hover:shadow-sm transition">
                        ← Back to shop
                    </a>

                    {{-- Logout dropdown (prevents accidental click) --}}
                    <div x-data="{ open: false }" class="relative mt-2">
                        <button
                            @click="open = !open"
                            class="w-full text-left rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-white hover:shadow-sm transition flex items-center justify-between"
                        >
                            <span>Account</span>
                            <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-transition
                            @click.outside="open = false"
                            class="absolute left-0 right-0 mt-2 rounded-2xl bg-white shadow-lg overflow-hidden"
                        >
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">

            {{-- Topbar --}}
            <header class="bg-white shadow-sm">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="flex h-16 items-center justify-between">
                        <div>
                            <div class="text-xs text-slate-500">Admin</div>
                            <div class="font-semibold tracking-tight text-slate-900">{{ $title }}</div>
                        </div>

                        <div class="flex items-center gap-2 text-sm">
                            {{ $actions ?? '' }}
                        </div>
                    </div>
                </div>
            </header>

            <x-flash-message />

            {{-- Content --}}
            <main class="mx-auto w-full max-w-6xl px-4 py-10 flex-1">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-white shadow-sm">
                <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-slate-500">
                    © {{ date('Y') }} Ordifyr. by Alfredo Almirez
                </div>
            </footer>
        </div>
    </div
