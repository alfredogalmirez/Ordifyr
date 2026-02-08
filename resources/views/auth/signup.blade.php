<x-guest-layout>
    <div class="max-w-md mx-auto py-12">
        <div class="rounded-2xl bg-white p-8 shadow-sm border border-slate-200/60">
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                Create your account
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                Sign up to start ordering on Ordifyr.
            </p>

            {{-- GLOBAL ERROR (optional) --}}
            @if ($errors->any())
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Please fix the errors below and try again.
                </div>
            @endif

            <form method="POST" action="{{ route('signup.store') }}" class="mt-6 space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">
                        Name
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-900
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                        placeholder="e.g. Alfredo Almirez"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-900
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">
                        Password
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-900
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">
                        Confirm Password
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="mt-1 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-900
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                        placeholder="••••••••"
                    >
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="pt-2 flex items-center justify-between">
                    <a href=""
                       class="text-sm font-semibold text-indigo-600 hover:underline">
                        Already have an account?
                    </a>

                    <button
                        type="submit"
                        class="h-11 rounded-xl bg-indigo-600 px-5 text-sm font-semibold text-white shadow-sm
                               hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        Create account
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-slate-500">
            By signing up, you agree to our Terms & Privacy Policy.
        </p>
    </div>
</x-guest-layout>
