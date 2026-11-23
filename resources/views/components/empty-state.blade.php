{{--
    Komponen Empty State (tampilan saat data kosong)
    Props:
      - title: Judul pesan (string)
      - description: Deskripsi tambahan (string, opsional)
      - actionLabel: Label tombol aksi (string, opsional)
      - actionHref: URL tombol aksi (string, opsional)
    Contoh:
      <x-empty-state
          title="Belum ada transaksi"
          description="Mulai catat hutang atau piutang pertamamu sekarang."
          action-label="+ Catat Transaksi"
          action-href="{{ route('loans.create') }}"
      />
--}}
@props(['title', 'description' => '', 'actionLabel' => null, 'actionHref' => null])

<div class="text-center py-16 px-4">
    {{-- Ikon ilustrasi --}}
    <div class="w-16 h-16 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-sky-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
        </svg>
    </div>
    <h3 class="text-base font-semibold text-slate-700 mb-1">{{ $title }}</h3>
    @if($description)
        <p class="text-sm text-slate-400 mb-6 max-w-xs mx-auto">{{ $description }}</p>
    @endif
    @if($actionLabel && $actionHref)
        <x-btn href="{{ $actionHref }}">
            {{ $actionLabel }}
        </x-btn>
    @endif
</div>
