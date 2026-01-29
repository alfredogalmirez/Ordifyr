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

<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 bg-white/80 backdrop-blur border-r border-slate-200">
            {{-- Brand (same as your navbar brand) --}}
            <div class="h-16 px-4 flex items-center border-b border-slate-200">
                <a href="/admin/dashboard" class="flex items-center gap-2 font-semibold tracking-tight">
                    <span
                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm">
                        O
                    </span>
                    <div class="leading-tight">
                        <div>Ordifyr</div>
                        <div class="text-xs font-normal text-slate-500 -mt-0.5">Admin Panel</div>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="p-3 space-y-1 text-sm">
                <a href="/admin"
                    class="flex items-center gap-3 rounded-xl px-3 py-2
                    {{ request()->is('admin') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white border border-slate-200">
                        🏠
                    </span>
                    <span>Dashboard</span>
                </a>

                <a href="/admin/products"
                    class="flex items-center gap-3 rounded-xl px-3 py-2
                    {{ request()->is('admin/products*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white border border-slate-200">
                        📦
                    </span>
                    <span>Products</span>
                </a>
            </nav>

            {{-- Bottom area --}}
            <div class="p-4 mt-auto border-t border-slate-200">
                <a href="/"
                    class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                    ← Back to shop
                </a>

                <form method="POST" action="/logout" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full text-left rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col">

            {{-- Topbar (same feel as your navbar) --}}
            <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="flex h-16 items-center justify-between">
                        <div>
                            <div class="text-sm text-slate-500">Admin</div>
                            <div class="font-semibold tracking-tight">{{ $title }}</div>
                        </div>

                        <div class="flex items-center gap-2 text-sm">
                            {{-- Put page actions here --}}
                            {{ $actions ?? '' }}
                        </div>
                    </div>
                </div>
            </header>

            <x-flash-message />

            {{-- Content --}}
            <main class="mx-auto w-full max-w-6xl px-4 py-8">
                {{ $slot }}
            </main>

            {{-- Footer (optional, same as yours) --}}
            <footer class="border-t border-slate-200 bg-white">
                <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-slate-500">
                    © {{ date('Y') }} Ordifyr. by Alfredo Almirez
                </div>
            </footer>
        </div>

    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
