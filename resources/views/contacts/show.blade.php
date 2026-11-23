<x-app-layout>
    <x-slot name="title">{{ $contact->name }}</x-slot>

    <div class="mb-6">
        <a href="{{ route('contacts.index') }}" class="text-sm text-sky-500 hover:text-sky-600 flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Kontak
        </a>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $contact->name }}</h1>
                @if($contact->phone)
                    <p class="text-slate-500 text-sm mt-1">📱 {{ $contact->phone }}</p>
                @endif
                @if($contact->note)
                    <p class="text-slate-400 text-sm mt-1">{{ $contact->note }}</p>
                @endif
            </div>
            <x-btn href="{{ route('contacts.edit', $contact) }}" color="secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                </svg>
                Edit
            </x-btn>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-700">Daftar Transaksi</h2>
        </div>
        @if($contact->loans->isEmpty())
            <x-empty-state
                title="Belum ada transaksi"
                description="Belum ada transaksi dengan kontak ini."
                action-label="+ Catat Transaksi"
                action-href="{{ route('loans.create') }}"
            />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Jenis</th>
                            <th class="px-6 py-3 text-right font-medium">Nominal</th>
                            <th class="px-6 py-3 text-right font-medium">Sisa</th>
                            <th class="px-6 py-3 text-left font-medium">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left font-medium">Status</th>
                            <th class="px-6 py-3 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($contact->loans as $loan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3"><x-badge :type="$loan->type" /></td>
                            <td class="px-6 py-3 text-right text-slate-600">{{ rupiah($loan->amount) }}</td>
                            <td class="px-6 py-3 text-right font-medium text-slate-800">{{ rupiah($loan->remaining) }}</td>
                            <td class="px-6 py-3 text-slate-500">{{ $loan->due_date->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-3"><x-badge :status="$loan->status" /></td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('loans.show', $loan) }}" class="text-sky-500 hover:text-sky-600 font-medium text-xs">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
