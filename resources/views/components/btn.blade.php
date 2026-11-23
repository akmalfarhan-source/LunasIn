{{--
    Komponen Tombol Utama
    Props:
      - type: 'submit' | 'button' | 'reset' (default: submit)
      - color: 'primary' | 'danger' | 'secondary' (default: primary)
      - href: jika diisi, render sebagai <a> bukan <button>
    Contoh:
      <x-btn>Simpan</x-btn>
      <x-btn color="danger">Hapus</x-btn>
      <x-btn href="{{ route('loans.create') }}">+ Catat Transaksi</x-btn>
--}}
@props(['type' => 'submit', 'color' => 'primary', 'href' => null])

@php
    $styles = match($color) {
        'danger'    => 'bg-rose-500 hover:bg-rose-600 text-white focus:ring-rose-200',
        'secondary' => 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 focus:ring-slate-200',
        'success'   => 'bg-emerald-500 hover:bg-emerald-600 text-white focus:ring-emerald-200',
        default     => 'bg-sky-500 hover:bg-sky-600 text-white focus:ring-sky-200', // primary
    };
    $base = 'inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium shadow-sm focus:outline-none focus:ring-2 transition-colors disabled:opacity-60 disabled:cursor-not-allowed';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $styles"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $styles"]) }}>
        {{ $slot }}
    </button>
@endif
