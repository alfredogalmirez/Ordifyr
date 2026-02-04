<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Ordifyr' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased">
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
                        <a href="{{ route('cart.show') }}"
                            class="relative inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100">
                            {{-- Cart icon (Heroicons outline: shopping-cart) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-gray-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25h10.97a.75.75 0 0 0 .73-.563l1.5-6A.75.75 0 0 0 19.97 6.75H6.122M7.5 14.25 5.106 5.273M7.5 14.25l-.75 3.75a.75.75 0 0 0 .75.75h10.5a.75.75 0 0 0 .75-.75l-.75-3.75M9 20.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm9 0a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                            </svg>

                            {{-- Badge (count) --}}
                            @if (($cartCount ?? 0) > 0)
                                <span
                                    class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-red-600 text-white text-[11px] leading-[18px] text-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <div x-data="{ open: false }" class="relative">
                            <!-- Trigger -->
                            <button @click="open = !open"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900 focus:outline-none">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white text-sm font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" x-transition @click.outside="open = false"
                                class="absolute right-0 mt-2 w-44 rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                                <a href="{{ route('cart.show') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                    My Orders
                                </a>

                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
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
    <main class="mx-auto max-w-6xl px-4 py-8 flex-1">
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
