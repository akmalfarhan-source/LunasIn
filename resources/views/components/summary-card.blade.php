{{--
    Komponen Kartu Ringkasan Dashboard
    Props:
      - title: Judul kartu (string)
      - value: Nilai yang ditampilkan besar (string)
      - subtitle: Keterangan di bawah nilai (string, opsional)
      - color: 'sky' | 'rose' | 'emerald' (default: sky)
    Slot: ikon SVG yang ditampilkan di sisi kanan kartu
    Contoh:
      <x-summary-card title="Total Hutang" :value="rupiah($total)" color="rose">
          <svg>...</svg>
      </x-summary-card>
--}}
@props(['title', 'value', 'subtitle' => '', 'color' => 'sky'])

@php
    $colors = [
        'sky'     => ['bg' => 'bg-sky-100',     'text' => 'text-sky-600',     'icon' => 'bg-sky-50 border-sky-200'],
        'rose'    => ['bg' => 'bg-rose-100',    'text' => 'text-rose-600',    'icon' => 'bg-rose-50 border-rose-200'],
        'emerald' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-50 border-emerald-200'],
        'amber'   => ['bg' => 'bg-amber-100',   'text' => 'text-amber-600',   'icon' => 'bg-amber-50 border-amber-200'],
    ];
    $c = $colors[$color] ?? $colors['sky'];
@endphp

<div class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-slate-500 mb-1">{{ $title }}</p>
            <p class="text-2xl font-bold text-slate-800 truncate">{{ $value }}</p>
            @if($subtitle)
                <p class="text-xs text-slate-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        {{-- Ikon di sisi kanan --}}
        @if($slot->isNotEmpty())
            <div class="w-12 h-12 rounded-xl {{ $c['icon'] }} border flex items-center justify-center flex-shrink-0">
                <div class="{{ $c['text'] }} w-6 h-6">
                    {{ $slot }}
                </div>
            </div>
        @endif
    </div>
</div>
