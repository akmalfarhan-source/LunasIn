<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LunasIn') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F0F9FF] min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    {{-- Kartu split screen modern --}}
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl shadow-sky-950/5 border border-sky-100 overflow-hidden flex flex-col md:flex-row">

        {{-- ============================================================ --}}
        {{-- SISI KIRI: Branding & Highlight Fitur --}}
        {{-- ============================================================ --}}
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-sky-500 via-sky-600 to-sky-700 p-10 flex-col justify-between relative overflow-hidden">
            {{-- Dekorasi blur lembut --}}
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Top: Logo Resmi LunasIn (Diselaraskan Identik dengan Dashboard) --}}
            <div class="relative z-10">
                <a href="/" class="inline-flex items-center hover:opacity-95 transition-opacity">
                    <x-application-logo variant="white" size="w-9 h-9" textSize="text-lg" :show-text="true" />
                </a>
            </div>

            {{-- Middle: Pesan Nilai & Card Fitur Rapi --}}
            <div class="relative z-10 my-8 space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white leading-snug mb-2.5">
                        Kelola hutang & piutang<br>dengan rapi dan mudah.
                    </h2>
                    <p class="text-sky-100 text-sm leading-relaxed">
                        Catat pinjaman, pantau jatuh tempo, dan kelola sisa pembayaran secara transparan.
                    </p>
                </div>

                {{-- Card Fitur Translucent Rapi --}}
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 space-y-3.5 shadow-sm">
                    <div class="flex items-center gap-3 text-white">
                        <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="font-medium text-xs sm:text-sm text-sky-50">Catat hutang & piutang otomatis</span>
                    </div>

                    <div class="flex items-center gap-3 text-white">
                        <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="font-medium text-xs sm:text-sm text-sky-50">Riwayat cicilan & status lunas otomatis</span>
                    </div>

                    <div class="flex items-center gap-3 text-white">
                        <div class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0 text-white">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="font-medium text-xs sm:text-sm text-sky-50">Deteksi jatuh tempo & terlambat</span>
                    </div>
                </div>
            </div>

            {{-- Bottom: Footer Informasi Sistem --}}
            <div class="relative z-10 pt-4 border-t border-white/15 flex items-center justify-between text-xs text-sky-200">
                <span class="inline-flex items-center gap-1.5 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Sistem Pencatatan Transaksi
                </span>
                <span class="font-medium text-sky-100 tracking-wide">Transparan & Akurat</span>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- SISI KANAN: Form Login/Register --}}
        {{-- ============================================================ --}}
        <div class="w-full md:w-1/2 p-8 sm:p-10 flex flex-col justify-center">
            {{-- Logo di layar HP --}}
            <div class="flex items-center gap-2.5 mb-8 md:hidden">
                <img src="{{ asset('images/logo-icon.png') }}" alt="LunasIn Logo" class="w-9 h-9 rounded-xl shadow-sm object-contain">
                <div>
                    <span class="text-xl font-bold text-sky-600 leading-none block">Lunas<span class="text-sky-400">In</span></span>
                    <p class="text-[10px] text-slate-400 leading-tight mt-0.5">Catat, ingat, lunas.</p>
                </div>
            </div>

            {{ $slot }}
        </div>
    </div>

</body>
</html>
