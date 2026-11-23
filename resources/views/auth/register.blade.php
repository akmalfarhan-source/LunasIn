<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Daftar Akun</h1>
        <p class="text-slate-500 text-sm mt-1">Buat akun LunasIn gratis sekarang.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama Anda"
                class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                       {{ $errors->has('name') ? 'border-rose-400' : '' }}"
            >
            @error('name')
                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
                placeholder="Min. 8 karakter"
                class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                       {{ $errors->has('password') ? 'border-rose-400' : '' }}"
            >
            @error('password')
                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                       {{ $errors->has('password_confirmation') ? 'border-rose-400' : '' }}"
            >
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol daftar --}}
        <button type="submit"
            class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm text-sm">
            Buat Akun
        </button>

        <p class="text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-sky-500 hover:text-sky-600 font-medium">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
