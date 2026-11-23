<x-app-layout>
    <x-slot name="title">Edit Profil</x-slot>

    {{-- ============================================================ --}}
    {{-- HEADER HALAMAN PROFIL --}}
    {{-- ============================================================ --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Profil</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola data akun, informasi login, dan foto profil Anda.</p>
    </div>

    <div class="max-w-3xl space-y-6">

        {{-- ============================================================ --}}
        {{-- KARTU 1: INFORMASI PROFIL & FOTO PROFIL --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 sm:p-8">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-800">Informasi Pribadi & Foto Profil</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui nama lengkap, alamat email, dan foto profil akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Area Upload Foto Profil --}}
                <div x-data="{
                    preview: '{{ $user->avatar_url }}',
                    updatePreview(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.preview = URL.createObjectURL(file);
                        }
                    }
                }" class="flex flex-col sm:flex-row sm:items-center gap-5 p-4 rounded-xl bg-[#F0F9FF] border border-sky-100">
                    {{-- Avatar Display / Preview --}}
                    <div class="relative flex-shrink-0">
                        <template x-if="preview">
                            <img :src="preview" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-sky-300 shadow-sm">
                        </template>
                        <template x-if="!preview">
                            <div class="w-20 h-20 rounded-full bg-sky-200 text-sky-700 font-bold text-2xl flex items-center justify-center border-2 border-sky-300 shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </template>
                    </div>

                    <div class="flex-1 space-y-2">
                        <label for="avatar" class="block text-sm font-semibold text-slate-700">Unggah Foto Baru</label>
                        <input
                            type="file"
                            id="avatar"
                            name="avatar"
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            x-on:change="updatePreview"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-500 file:text-white hover:file:bg-sky-600 file:cursor-pointer transition-colors"
                        >
                        <p class="text-[11px] text-slate-400">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.</p>
                        @error('avatar')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror

                        @if($user->avatar)
                            <div class="pt-1">
                                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-rose-500 hover:text-rose-600 font-medium">
                                    <input type="checkbox" name="remove_avatar" value="1" class="rounded border-slate-300 text-rose-500 focus:ring-rose-200">
                                    Hapus foto profil saat ini
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Nama Lengkap --}}
                <x-form-input
                    name="name"
                    label="Nama Lengkap"
                    placeholder="Contoh: Akmal Wijaya"
                    :value="$user->name"
                    required
                />

                {{-- Alamat Email --}}
                <x-form-input
                    name="email"
                    label="Alamat Email"
                    type="email"
                    placeholder="nama@email.com"
                    :value="$user->email"
                    required
                />

                <div class="flex items-center gap-3 pt-2">
                    <x-btn type="submit">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Simpan Profil
                    </x-btn>
                </div>
            </form>
        </div>

        {{-- ============================================================ --}}
        {{-- KARTU 2: PERBARUI KATA SANDI --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 sm:p-8">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-800">Perbarui Kata Sandi</h2>
                <p class="text-slate-500 text-sm mt-1">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Kata Sandi Saat Ini --}}
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                               {{ $errors->updatePassword->has('current_password') ? 'border-rose-400' : '' }}"
                    >
                    @if($errors->updatePassword->has('current_password'))
                        <p class="mt-1.5 text-xs text-rose-500">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                {{-- Kata Sandi Baru --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                               {{ $errors->updatePassword->has('password') ? 'border-rose-400' : '' }}"
                    >
                    @if($errors->updatePassword->has('password'))
                        <p class="mt-1.5 text-xs text-rose-500">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                {{-- Konfirmasi Kata Sandi Baru --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi baru"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
                               {{ $errors->updatePassword->has('password_confirmation') ? 'border-rose-400' : '' }}"
                    >
                    @if($errors->updatePassword->has('password_confirmation'))
                        <p class="mt-1.5 text-xs text-rose-500">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="pt-2">
                    <x-btn type="submit">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Perbarui Kata Sandi
                    </x-btn>
                </div>
            </form>
        </div>

        {{-- ============================================================ --}}
        {{-- KARTU 3: HAPUS AKUN --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-rose-100 shadow-sm p-6 sm:p-8" x-data="{ openDeleteModal: false }">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-rose-600">Hapus Akun</h2>
                <p class="text-slate-500 text-sm mt-1">Setelah akun dihapus, seluruh data transaksi, kontak, dan catatan pembayaran akan terhapus secara permanen.</p>
            </div>

            <x-btn type="button" color="danger" x-on:click="openDeleteModal = true">
                Hapus Akun Saya
            </x-btn>

            {{-- Modal Konfirmasi Hapus Akun --}}
            <div
                x-show="openDeleteModal"
                class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/50"
                x-transition
                style="display: none;"
            >
                <div
                    class="bg-white rounded-2xl p-6 sm:p-8 max-w-md w-full shadow-xl space-y-4"
                    x-on:click.outside="openDeleteModal = false"
                >
                    <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus Akun</h3>
                    <p class="text-sm text-slate-500">
                        Apakah Anda yakin ingin menghapus akun ini? Masukkan kata sandi Anda untuk mengonfirmasi.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                        @csrf
                        @method('DELETE')

                        <input
                            type="password"
                            name="password"
                            placeholder="Kata sandi Anda"
                            required
                            class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-rose-400 focus:ring-2 focus:ring-rose-200"
                        >
                        @if($errors->userDeletion->has('password'))
                            <p class="text-xs text-rose-500">{{ $errors->userDeletion->first('password') }}</p>
                        @endif

                        <div class="flex justify-end gap-3 pt-2">
                            <x-btn type="button" color="secondary" x-on:click="openDeleteModal = false">
                                Batal
                            </x-btn>
                            <x-btn type="submit" color="danger">
                                Ya, Hapus Akun
                            </x-btn>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
