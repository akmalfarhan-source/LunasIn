{{--
    Komponen Badge Status
    Props:
      - status: 'belum_lunas' | 'lunas' | 'terlambat' | 'hampir_jatuh_tempo'
      - type: 'hutang' | 'piutang' (opsional, untuk badge jenis)
    Contoh: <x-badge status="lunas" />
            <x-badge :type="$loan->type" />
--}}
@props(['status' => null, 'type' => null])

@if($status)
    @php
        $style = match($status) {
            'lunas'              => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'terlambat'          => 'bg-red-100 text-red-700 ring-red-200',
            'hampir_jatuh_tempo' => 'bg-amber-100 text-amber-700 ring-amber-200',
            default              => 'bg-slate-100 text-slate-600 ring-slate-200', // belum_lunas
        };
        $label = match($status) {
            'lunas'              => 'Lunas',
            'belum_lunas'        => 'Belum Lunas',
            'terlambat'          => 'Terlambat',
            'hampir_jatuh_tempo' => 'Hampir Jatuh Tempo',
            default              => $status,
        };
    @endphp
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 {{ $style }}">
        {{ $label }}
    </span>
@endif

@if($type)
    @php
        $typeStyle = match($type) {
            'hutang'  => 'bg-rose-100 text-rose-700 ring-rose-200',
            'piutang' => 'bg-sky-100 text-sky-700 ring-sky-200',
            default   => 'bg-slate-100 text-slate-600',
        };
        $typeLabel = match($type) {
            'hutang'  => 'Hutang',
            'piutang' => 'Piutang',
            default   => $type,
        };
    @endphp
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 {{ $typeStyle }}">
        {{ $typeLabel }}
    </span>
@endif
