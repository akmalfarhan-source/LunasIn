<x-app-layout>
    <x-slot name="title">Edit Transaksi</x-slot>

    <div class="max-w-lg">
        <div class="mb-6">
            <a href="{{ route('loans.show', $loan) }}" class="text-sm text-sky-500 hover:text-sky-600 flex items-center gap-1 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Detail
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Edit Transaksi</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui data transaksi dengan <strong>{{ $loan->contact->name }}</strong>.</p>
        </div>

        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
            <form method="POST" action="{{ route('loans.update', $loan) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Kontak --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="contact_id" class="block text-sm font-medium text-slate-700">
                            Kontak <span class="text-rose-500">*</span>
                        </label>
                        <a href="{{ route('contacts.create') }}" class="text-xs text-sky-500 hover:text-sky-600 font-medium">
                            + Tambah kontak baru
                        </a>
                    </div>
                    <select
                        id="contact_id"
                        name="contact_id"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors"
                    >
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('contact_id', $loan->contact_id) == $contact->id ? 'selected' : '' }}>
                                {{ $contact->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('contact_id')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Transaksi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Transaksi <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="hutang" class="peer sr-only"
                                {{ old('type', $loan->type) === 'hutang' ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200
                                        peer-checked:border-rose-400 peer-checked:bg-rose-50 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-slate-700">Hutang</p>
                                    <p class="text-xs text-slate-400">Saya meminjam</p>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="piutang" class="peer sr-only"
                                {{ old('type', $loan->type) === 'piutang' ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200
                                        peer-checked:border-sky-400 peer-checked:bg-sky-50 transition-colors">
                                <div>
                                    <p class="text-sm font-medium text-slate-700">Piutang</p>
                                    <p class="text-xs text-slate-400">Saya meminjamkan</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Status Transaksi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Status Transaksi <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="belum_lunas" class="peer sr-only"
                                {{ old('status', $loan->status) === 'belum_lunas' ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200
                                        peer-checked:border-amber-400 peer-checked:bg-amber-50 transition-colors">
                                <span class="w-3 h-3 rounded-full border-2 border-slate-300 peer-checked:bg-amber-400 flex-shrink-0"></span>
                                <div>
                                    <p class="text-sm font-medium text-slate-700">Belum Lunas</p>
                                    <p class="text-xs text-slate-400">Masih ada tagihan</p>
                                </div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="lunas" class="peer sr-only"
                                {{ old('status', $loan->status) === 'lunas' ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200
                                        peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-colors">
                                <span class="w-3 h-3 rounded-full border-2 border-slate-300 peer-checked:bg-emerald-500 flex-shrink-0"></span>
                                <div>
                                    <p class="text-sm font-medium text-slate-700">Lunas</p>
                                    <p class="text-xs text-slate-400">Tandai telah lunas</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nominal --}}
                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nominal <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 font-medium">Rp</span>
                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount', $loan->amount) }}"
                            min="1"
                            step="any"
                            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border-slate-200 focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                                   {{ $errors->has('amount') ? 'border-rose-400' : '' }}"
                        >
                    </div>
                    @error('amount')
                        <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-form-input
                        name="loan_date"
                        label="Tanggal Pinjam"
                        type="date"
                        :value="old('loan_date', $loan->loan_date->format('Y-m-d'))"
                        required
                    />
                    <x-form-input
                        name="due_date"
                        label="Jatuh Tempo"
                        type="date"
                        :value="old('due_date', $loan->due_date->format('Y-m-d'))"
                        required
                    />
                </div>

                <div>
                    <label for="note" class="block text-sm font-medium text-slate-700 mb-1.5">Catatan (opsional)</label>
                    <textarea
                        id="note" name="note" rows="3"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors resize-none"
                    >{{ old('note', $loan->note) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <x-btn type="submit">Simpan Perubahan</x-btn>
                    <x-btn href="{{ route('loans.show', $loan) }}" color="secondary">Batal</x-btn>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
