<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Ordifyr' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <!-- Navbar -->
    <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex h-16 items-center justify-between">
                <a href="/" class="flex items-center gap-2 font-semibold tracking-tight">
                    <span
                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm">
                        O
                    </span>
                    <span>Ordifyr</span>
                </a>

                <nav class="flex items-center gap-2 text-sm">
                    <a href="/products"
                        class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                        Products
                    </a>

                    @auth
                        <a href="/dashboard"
                            class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                            Dashboard
                        </a>

                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit"
                                class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="/login"
                            class="rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900">
                            Login
                        </a>
                        <a href="/register"
                            class="rounded-lg bg-indigo-600 px-3 py-2 font-medium text-white shadow-sm hover:bg-indigo-500">
                            Register
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <x-flash-message />

    <!-- Page -->
    <main class="mx-auto max-w-6xl px-4 py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-slate-500">
            © {{ date('Y') }} Ordifyr. by Alfredo Almirez
        </div>
    </footer>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
