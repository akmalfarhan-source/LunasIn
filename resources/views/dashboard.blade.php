<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- ============================================================ --}}
    {{-- HEADER HALAMAN --}}
    {{-- ============================================================ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-slate-500 text-sm mt-1">Berikut ringkasan keuangan pinjam-meminjam Anda.</p>
        </div>
        {{-- Tombol utama yang mudah ditemukan --}}
        <x-btn href="{{ route('loans.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Catat Transaksi
        </x-btn>
    </div>

    {{-- ============================================================ --}}
    {{-- 3 KARTU RINGKASAN --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

        {{-- Total Hutang Saya --}}
        <x-summary-card title="Total Hutang Saya" :value="rupiah($totalHutang)" subtitle="Yang belum lunas" color="rose">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
            </svg>
        </x-summary-card>

        {{-- Total Piutang Saya --}}
        <x-summary-card title="Total Piutang Saya" :value="rupiah($totalPiutang)" subtitle="Yang belum lunas" color="sky">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
            </svg>
        </x-summary-card>

        {{-- Selisih Bersih --}}
        <x-summary-card
            title="Selisih Bersih"
            :value="rupiah(abs($selisihBersih))"
            :subtitle="$selisihBersih >= 0 ? 'Piutang lebih besar' : 'Hutang lebih besar'"
            :color="$selisihBersih >= 0 ? 'emerald' : 'rose'"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
            </svg>
        </x-summary-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- ============================================================ --}}
        {{-- DAFTAR HAMPIR JATUH TEMPO (7 hari ke depan) --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-6 py-4 border-b border-slate-100">
                <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                <h2 class="font-semibold text-slate-700 text-sm">Jatuh Tempo 7 Hari Ke Depan</h2>
                @if($dueSoon->count() > 0)
                    <span class="ml-auto bg-amber-100 text-amber-700 text-xs font-medium px-2 py-0.5 rounded-full">
                        {{ $dueSoon->count() }}
                    </span>
                @endif
            </div>
            @if($dueSoon->isEmpty())
                <p class="text-sm text-slate-400 text-center py-8">Tidak ada yang hampir jatuh tempo 🎉</p>
            @else
                <ul class="divide-y divide-slate-50">
                    @foreach($dueSoon as $loan)
                    <li class="px-6 py-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('loans.show', $loan) }}" class="text-sm font-medium text-slate-700 hover:text-sky-600 truncate block">
                                {{ $loan->contact->name }}
                            </a>
                            <p class="text-xs text-slate-400">
                                <x-badge :type="$loan->type" /> · Jatuh tempo {{ $loan->due_date->translatedFormat('d M Y') }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold text-amber-600 flex-shrink-0">{{ rupiah($loan->remaining) }}</span>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- DAFTAR TERLAMBAT --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-2 px-6 py-4 border-b border-slate-100">
                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                <h2 class="font-semibold text-slate-700 text-sm">Terlambat</h2>
                @if($overdue->count() > 0)
                    <span class="ml-auto bg-red-100 text-red-700 text-xs font-medium px-2 py-0.5 rounded-full">
                        {{ $overdue->count() }}
                    </span>
                @endif
            </div>
            @if($overdue->isEmpty())
                <p class="text-sm text-slate-400 text-center py-8">Tidak ada transaksi terlambat 👍</p>
            @else
                <ul class="divide-y divide-slate-50">
                    @foreach($overdue as $loan)
                    <li class="px-6 py-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('loans.show', $loan) }}" class="text-sm font-medium text-slate-700 hover:text-sky-600 truncate block">
                                {{ $loan->contact->name }}
                            </a>
                            <p class="text-xs text-red-400">
                                <x-badge :type="$loan->type" /> · Jatuh tempo {{ $loan->due_date->translatedFormat('d M Y') }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold text-red-500 flex-shrink-0">{{ rupiah($loan->remaining) }}</span>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- 5 TRANSAKSI TERBARU --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-700 text-sm">Transaksi Terbaru</h2>
            <a href="{{ route('loans.index') }}" class="text-sm text-sky-500 hover:text-sky-600 font-medium">Lihat semua →</a>
        </div>
        @if($recentLoans->isEmpty())
            <x-empty-state
                title="Belum ada transaksi"
                description="Catat hutang atau piutang pertamamu sekarang."
                action-label="+ Catat Transaksi"
                action-href="{{ route('loans.create') }}"
            />
        @else
            {{-- Tabel responsif: horizontal scroll di layar kecil --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Kontak</th>
                            <th class="px-6 py-3 text-left font-medium">Jenis</th>
                            <th class="px-6 py-3 text-right font-medium">Nominal</th>
                            <th class="px-6 py-3 text-right font-medium">Sisa</th>
                            <th class="px-6 py-3 text-left font-medium">Status</th>
                            <th class="px-6 py-3 text-left font-medium">Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentLoans as $loan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3">
                                <a href="{{ route('loans.show', $loan) }}" class="font-medium text-slate-700 hover:text-sky-600">
                                    {{ $loan->contact->name }}
                                </a>
                            </td>
                            <td class="px-6 py-3"><x-badge :type="$loan->type" /></td>
                            <td class="px-6 py-3 text-right text-slate-600">{{ rupiah($loan->amount) }}</td>
                            <td class="px-6 py-3 text-right font-medium text-slate-800">{{ rupiah($loan->remaining) }}</td>
                            <td class="px-6 py-3"><x-badge :status="$loan->display_status" /></td>
                            <td class="px-6 py-3 text-slate-500">{{ $loan->due_date->translatedFormat('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
