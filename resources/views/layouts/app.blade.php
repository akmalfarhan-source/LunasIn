<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LunasIn') }} - {{ $title ?? 'Dashboard' }}</title>

    {{-- Google Font Inter untuk tampilan yang bersih dan modern --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- Latar halaman biru sangat muda (sky-50) --}}
<body class="bg-[#F0F9FF] font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        {{-- ============================================================ --}}
        {{-- OVERLAY GELAP (hanya muncul di HP saat sidebar terbuka) --}}
        {{-- ============================================================ --}}
        <div
            x-show="sidebarOpen"
            x-on:click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-20 lg:hidden"
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        {{-- ============================================================ --}}
        {{-- SIDEBAR KIRI --}}
        {{-- Desktop: selalu tampil | HP: geser masuk saat sidebarOpen=true --}}
        {{-- ============================================================ --}}
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-sky-100 shadow-sm flex flex-col
                   transform transition-transform duration-200 ease-in-out
                   lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            {{-- Logo Resmi LunasIn --}}
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-5 border-b border-sky-100 hover:bg-sky-50/50 transition-colors">
                <x-application-logo variant="blue" size="w-9 h-9" textSize="text-lg" :show-text="true" />
            </a>

            {{-- Navigasi --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('dashboard') ? 'bg-sky-500 text-white shadow-sm' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('loans.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('loans.*') ? 'bg-sky-500 text-white shadow-sm' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                    </svg>
                    Transaksi
                </a>

                <a href="{{ route('contacts.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('contacts.*') ? 'bg-sky-500 text-white shadow-sm' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    Kontak
                </a>
            </nav>

            {{-- Info user dan tombol logout --}}
            <div class="p-4 border-t border-sky-100">
                {{-- Link ke halaman profil --}}
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 p-2 -mx-2 mb-2 rounded-xl hover:bg-sky-50 transition-colors group cursor-pointer"
                   title="Pengaturan Profil">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden border border-sky-200">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-sky-100 text-sky-600 font-bold text-sm flex items-center justify-center">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-700 truncate group-hover:text-sky-600 transition-colors">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 group-hover:text-sky-500 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-slate-500 hover:bg-rose-50 hover:text-rose-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ============================================================ --}}
        {{-- AREA KONTEN UTAMA --}}
        {{-- ============================================================ --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Header (hamburger di HP) --}}
            <header class="lg:hidden bg-white border-b border-sky-100 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button x-on:click="sidebarOpen = true" class="text-slate-600 hover:text-sky-600 transition-colors p-1 rounded-lg">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <x-application-logo variant="blue" size="w-7 h-7" textSize="text-lg" :show-text="true" :tagline="false" />
                    </a>
                </div>
                {{-- Link profil di HP --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center p-1 rounded-full hover:bg-sky-50 transition-colors" title="Profil">
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-sky-200 flex items-center justify-center">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-sky-100 text-sky-600 font-bold text-xs flex items-center justify-center">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </a>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif
                @if(session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
