<x-app-layout>
    <x-slot name="title">Edit Kontak</x-slot>

    <div class="max-w-lg">
        <div class="mb-6">
            <a href="{{ route('contacts.index') }}" class="text-sm text-sky-500 hover:text-sky-600 flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Kontak
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Edit Kontak</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi kontak <strong>{{ $contact->name }}</strong>.</p>
        </div>

        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
            <form method="POST" action="{{ route('contacts.update', $contact) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <x-form-input
                    name="name"
                    label="Nama Kontak"
                    placeholder="Contoh: Budi Santoso"
                    :value="$contact->name"
                    required
                />

                <x-form-input
                    name="phone"
                    label="Nomor Telepon"
                    type="tel"
                    placeholder="Contoh: 08123456789"
                    :value="$contact->phone"
                />

                <div>
                    <label for="note" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Catatan <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <textarea
                        id="note"
                        name="note"
                        rows="3"
                        placeholder="Tambahkan catatan tentang kontak ini..."
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors resize-none"
                    >{{ old('note', $contact->note) }}</textarea>
                    @error('note')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <x-btn type="submit">Simpan Perubahan</x-btn>
                    <x-btn href="{{ route('contacts.index') }}" color="secondary">Batal</x-btn>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
