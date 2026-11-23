<x-app-layout>
    <x-slot name="title">Transaksi</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Transaksi</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar semua hutang dan piutang Anda.</p>
        </div>
        <x-btn href="{{ route('loans.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Catat Transaksi
        </x-btn>
    </div>

    {{-- ============================================================ --}}
    {{-- FILTER DAN PENCARIAN --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('loans.index') }}" class="flex flex-col sm:flex-row gap-3">

            {{-- Pencarian nama kontak --}}
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama kontak..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border-slate-200 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors">
            </div>

            {{-- Filter jenis (otomatis filter saat opsi dipilih) --}}
            <select name="type" onchange="this.form.submit()" class="text-sm rounded-xl border-slate-200 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 py-2.5 pl-3 pr-8 transition-colors cursor-pointer">
                <option value="">Semua Jenis</option>
                <option value="hutang" {{ request('type') === 'hutang' ? 'selected' : '' }}>Hutang</option>
                <option value="piutang" {{ request('type') === 'piutang' ? 'selected' : '' }}>Piutang</option>
            </select>

            {{-- Filter status (otomatis filter saat opsi dipilih) --}}
            <select name="status" onchange="this.form.submit()" class="text-sm rounded-xl border-slate-200 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 py-2.5 pl-3 pr-8 transition-colors cursor-pointer">
                <option value="">Semua Status</option>
                <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
            </select>
        </form>
    </div>

    {{-- ============================================================ --}}
    {{-- TABEL TRANSAKSI --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
        @if($loans->isEmpty())
            <x-empty-state
                title="Belum ada transaksi"
                description="Catat hutang atau piutang pertamamu sekarang."
                action-label="+ Catat Transaksi"
                action-href="{{ route('loans.create') }}"
            />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Kontak</th>
                            <th class="px-6 py-3 text-left font-medium">Jenis</th>
                            <th class="px-6 py-3 text-right font-medium">Nominal</th>
                            <th class="px-6 py-3 text-right font-medium">Sisa</th>
                            <th class="px-6 py-3 text-left font-medium">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left font-medium">Status</th>
                            <th class="px-6 py-3 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($loans as $loan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('loans.show', $loan) }}" class="font-medium text-slate-800 hover:text-sky-600">
                                    {{ $loan->contact->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4"><x-badge :type="$loan->type" /></td>
                            <td class="px-6 py-4 text-right text-slate-600">{{ rupiah($loan->amount) }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-slate-800">{{ rupiah($loan->remaining) }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $loan->due_date->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4"><x-badge :status="$loan->display_status" /></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if($loan->status !== 'lunas')
                                    <form method="POST" action="{{ route('loans.mark-paid', $loan) }}"
                                          x-data
                                          x-on:submit.prevent="if(confirm('Tandai transaksi {{ addslashes($loan->contact->name) }} lunas? Sisa sebesar {{ rupiah($loan->remaining) }} akan dilunaskan.')) $el.submit()">
                                        @csrf
                                        <button type="submit"
                                                class="text-slate-400 hover:text-emerald-600 transition-colors p-1 rounded-lg hover:bg-emerald-50"
                                                title="Tandai Lunas">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('loans.show', $loan) }}"
                                       class="text-slate-400 hover:text-sky-500 transition-colors p-1 rounded-lg hover:bg-sky-50"
                                       title="Detail">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('loans.edit', $loan) }}"
                                       class="text-slate-400 hover:text-sky-500 transition-colors p-1 rounded-lg hover:bg-sky-50"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('loans.destroy', $loan) }}"
                                          x-data
                                          x-on:submit.prevent="if(confirm('Hapus transaksi ini beserta semua riwayat pembayarannya?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-slate-400 hover:text-rose-500 transition-colors p-1 rounded-lg hover:bg-rose-50"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($loans->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $loans->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
