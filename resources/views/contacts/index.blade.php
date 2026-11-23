<x-app-layout>
    <x-slot name="title">Kontak</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kontak</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola daftar orang yang terlibat dalam transaksi Anda.</p>
        </div>
        <x-btn href="{{ route('contacts.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Kontak
        </x-btn>
    </div>

    <div class="bg-white rounded-2xl border border-sky-100 shadow-sm overflow-hidden">
        @if($contacts->isEmpty())
            <x-empty-state
                title="Belum ada kontak"
                description="Tambahkan kontak terlebih dahulu sebelum mencatat transaksi."
                action-label="+ Tambah Kontak"
                action-href="{{ route('contacts.create') }}"
            />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Nama</th>
                            <th class="px-6 py-3 text-left font-medium">Nomor Telepon</th>
                            <th class="px-6 py-3 text-left font-medium">Catatan</th>
                            <th class="px-6 py-3 text-center font-medium">Transaksi</th>
                            <th class="px-6 py-3 text-center font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($contacts as $contact)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('contacts.show', $contact) }}" class="font-medium text-slate-800 hover:text-sky-600">
                                    {{ $contact->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $contact->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                {{ $contact->note ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-sky-50 text-sky-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $contact->loans_count }} transaksi
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('contacts.edit', $contact) }}"
                                       class="text-slate-400 hover:text-sky-500 transition-colors p-1 rounded-lg hover:bg-sky-50"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        </svg>
                                    </a>
                                    {{-- Form hapus dengan konfirmasi --}}
                                    <form method="POST" action="{{ route('contacts.destroy', $contact) }}"
                                          x-data
                                          x-on:submit.prevent="if(confirm('Hapus kontak {{ addslashes($contact->name) }}? Tindakan ini tidak dapat dibatalkan.')) $el.submit()">
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
            @if($contacts->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $contacts->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
