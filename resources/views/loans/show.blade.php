<x-app-layout>
    <x-slot name="title">Detail Transaksi</x-slot>

    @php
        // Hitung progress pembayaran untuk progress bar
        $totalPaid  = $loan->total_paid;
        $remaining  = $loan->remaining;
        $amount     = $loan->amount;
        // Persentase yang sudah dibayar (0-100)
        $progress   = $amount > 0 ? min(100, ($totalPaid / $amount) * 100) : 0;
    @endphp

    <div class="mb-6">
        <a href="{{ route('loans.index') }}" class="text-sm text-sky-500 hover:text-sky-600 flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Transaksi
        </a>
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-2xl font-bold text-slate-800">{{ $loan->contact->name }}</h1>
                    <x-badge :type="$loan->type" />
                    <x-badge :status="$loan->display_status" />
                </div>
                <p class="text-slate-500 text-sm">
                    {{ ucfirst($loan->type) }} sejak {{ $loan->loan_date->translatedFormat('d M Y') }} ·
                    Jatuh tempo {{ $loan->due_date->translatedFormat('d M Y') }}
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if($loan->status !== 'lunas')
                <form method="POST" action="{{ route('loans.mark-paid', $loan) }}"
                      x-data
                      x-on:submit.prevent="if(confirm('Tandai transaksi ini lunas? Sistem akan mencatat pelunasan sisa sebesar {{ rupiah($loan->remaining) }}.')) $el.submit()">
                    @csrf
                    <x-btn type="submit" color="success">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Tandai Lunas
                    </x-btn>
                </form>
                @endif
                <x-btn href="{{ route('loans.edit', $loan) }}" color="secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                    </svg>
                    Edit
                </x-btn>
                <form method="POST" action="{{ route('loans.destroy', $loan) }}"
                      x-data
                      x-on:submit.prevent="if(confirm('Hapus transaksi ini beserta semua riwayat pembayarannya?')) $el.submit()">
                    @csrf
                    @method('DELETE')
                    <x-btn type="submit" color="danger">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        Hapus
                    </x-btn>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============================================================ --}}
        {{-- KOLOM KIRI: Info transaksi + Form pembayaran --}}
        {{-- ============================================================ --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Kartu info nominal --}}
            <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
                <h2 class="font-semibold text-slate-700 text-sm mb-4">Ringkasan Pembayaran</h2>

                <div class="space-y-3 mb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Nominal Awal</span>
                        <span class="font-medium text-slate-700">{{ rupiah($amount) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Sudah Dibayar</span>
                        <span class="font-medium text-emerald-600">{{ rupiah($totalPaid) }}</span>
                    </div>
                    <div class="border-t border-slate-100 pt-3 flex justify-between text-sm">
                        <span class="font-semibold text-slate-700">Sisa</span>
                        <span class="font-bold text-slate-800 text-base">{{ rupiah($remaining) }}</span>
                    </div>
                </div>

                {{-- Progress bar: menunjukkan persentase yang sudah dibayar --}}
                <div>
                    <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                        <span>Progres Pembayaran</span>
                        <span>{{ number_format($progress, 0) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div
                            class="h-2.5 rounded-full transition-all duration-500
                                   {{ $loan->status === 'lunas' ? 'bg-emerald-500' : 'bg-sky-500' }}"
                            style="width: {{ $progress }}%"
                        ></div>
                    </div>
                    @if($loan->status === 'lunas')
                        <p class="text-xs text-emerald-600 font-medium mt-2 text-center">✓ Lunas!</p>
                    @endif
                </div>

                @if($loan->note)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Catatan</p>
                        <p class="text-sm text-slate-600">{{ $loan->note }}</p>
                    </div>
                @endif
            </div>

            {{-- Form tambah pembayaran (hanya tampil jika belum lunas) --}}
            @if($loan->status === 'belum_lunas')
            <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
                <h2 class="font-semibold text-slate-700 text-sm mb-4">Catat Pembayaran</h2>
                <form method="POST" action="{{ route('loans.payments.store', $loan) }}" class="space-y-4">
                    @csrf

                    {{-- Nominal pembayaran --}}
                    <div>
                        <label for="pay_amount" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nominal <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 font-medium">Rp</span>
                            <input
                                type="number"
                                id="pay_amount"
                                name="amount"
                                value="{{ old('amount') }}"
                                placeholder="0"
                                min="1"
                                max="{{ $remaining }}"
                                step="any"
                                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border-slate-200 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                                       {{ $errors->has('amount') ? 'border-rose-400' : '' }}"
                            >
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Maks: {{ rupiah($remaining) }}</p>
                        @error('amount')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form-input
                        name="paid_at"
                        label="Tanggal Bayar"
                        type="date"
                        :value="old('paid_at', date('Y-m-d'))"
                        required
                    />

                    <div>
                        <label for="pay_note" class="block text-sm font-medium text-slate-700 mb-1.5">Catatan (opsional)</label>
                        <input
                            type="text"
                            id="pay_note"
                            name="note"
                            value="{{ old('note') }}"
                            placeholder="Contoh: transfer BCA"
                            class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors"
                        >
                    </div>

                    <x-btn type="submit" class="w-full justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Catat Pembayaran
                    </x-btn>
                </form>
            </div>
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- KOLOM KANAN: Riwayat pembayaran --}}
        {{-- ============================================================ --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-700">Riwayat Pembayaran</h2>
                </div>

                @if($loan->payments->isEmpty())
                    <x-empty-state
                        title="Belum ada pembayaran"
                        description="Belum ada cicilan yang tercatat untuk transaksi ini."
                    />
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium">Tanggal</th>
                                    <th class="px-6 py-3 text-right font-medium">Nominal</th>
                                    <th class="px-6 py-3 text-left font-medium">Catatan</th>
                                    <th class="px-6 py-3 text-center font-medium">Hapus</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($loan->payments as $payment)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3 text-slate-600">
                                        {{ $payment->paid_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-right font-semibold text-emerald-600">
                                        {{ rupiah($payment->amount) }}
                                    </td>
                                    <td class="px-6 py-3 text-slate-500">
                                        {{ $payment->note ?? '-' }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <form method="POST" action="{{ route('loans.payments.destroy', [$loan, $payment]) }}"
                                              x-data
                                              x-on:submit.prevent="if(confirm('Hapus catatan pembayaran ini?')) $el.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-slate-400 hover:text-rose-500 transition-colors p-1 rounded-lg hover:bg-rose-50"
                                                    title="Hapus pembayaran">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
