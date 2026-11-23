{{--
    Komponen Alert/Notifikasi
    Props:
      - type: 'success' | 'error' | 'warning'
      - message: string pesan yang ditampilkan
    Contoh penggunaan:
      <x-alert type="success" message="Data berhasil disimpan." />
--}}
@props(['type' => 'success', 'message'])

@php
    // Tentukan warna berdasarkan tipe notifikasi
    $styles = match($type) {
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
        'error'   => 'bg-rose-50 border-rose-200 text-rose-700',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-700',
        default   => 'bg-sky-50 border-sky-200 text-sky-700',
    };

    $icon = match($type) {
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        'error'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />',
        default   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126Z" />',
    };
@endphp

<div class="flex items-start gap-3 p-4 mb-6 rounded-xl border {{ $styles }}" x-data="{ show: true }" x-show="show" x-transition>
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        {!! $icon !!}
    </svg>
    <p class="text-sm font-medium flex-1">{{ $message }}</p>
    {{-- Tombol tutup notifikasi --}}
    <button x-on:click="show = false" class="opacity-60 hover:opacity-100 transition-opacity ml-auto">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</div>
