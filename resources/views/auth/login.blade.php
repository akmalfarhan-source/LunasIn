<x-guest-layout>
    {{-- Status session (misal: setelah reset password) --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Masuk</h1>
        <p class="text-slate-500 text-sm mt-1">Selamat datang kembali di LunasIn.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="contoh@email.com"
                class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                       {{ $errors->has('email') ? 'border-rose-400' : '' }}"
            >
            @error('email')
                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                       {{ $errors->has('password') ? 'border-rose-400' : '' }}"
            >
            @error('password')
                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ingat saya --}}
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-sky-500 focus:ring-sky-200">
                <span class="text-sm text-slate-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-sky-500 hover:text-sky-600">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        {{-- Tombol masuk --}}
        <button type="submit"
            class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm text-sm">
            Masuk
        </button>

        {{-- Link ke register --}}
        <p class="text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-sky-500 hover:text-sky-600 font-medium">Daftar sekarang</a>
        </p>

        {{-- Info akun demo --}}
        <div class="mt-4 p-3 bg-sky-50 rounded-xl border border-sky-200">
            <p class="text-xs text-sky-700 font-medium mb-1">🎯 Akun Demo</p>
            <p class="text-xs text-sky-600">Email: <code class="bg-sky-100 px-1 rounded">demo@lunasin.test</code></p>
            <p class="text-xs text-sky-600">Password: <code class="bg-sky-100 px-1 rounded">password</code></p>
        </div>
    </form>
</x-guest-layout>
