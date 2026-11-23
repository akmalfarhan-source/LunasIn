@props([
    'variant' => 'blue', // 'blue' (ikon biru di dalam latar putih/terang) atau 'white' (ikon putih di dalam latar biru)
    'size' => 'w-9 h-9',
    'textSize' => 'text-lg',
    'showText' => false,
    'tagline' => true
])

@php
    $bgColor = $variant === 'white' ? '#ffffff' : '#0ea5e9';
    $strokeColor = $variant === 'white' ? '#0284c7' : '#ffffff';
    $textColor = $variant === 'white' ? 'text-white' : 'text-sky-600';
    $inColor = $variant === 'white' ? 'text-sky-200' : 'text-sky-400';
    $subColor = $variant === 'white' ? 'text-sky-100' : 'text-slate-400';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    {{-- Ikon Vektor Bersih & Tajam Resmi LunasIn --}}
    <svg class="{{ $size }} flex-shrink-0 drop-shadow-sm" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="100" height="100" rx="28" fill="{{ $bgColor }}" />
        <path d="M 35.4 26 L 35.4 69 C 35.4 75 39 78.5 45 78.5 C 47.5 78.5 50 77 52 74.5 L 70.4 43" fill="none" stroke="{{ $strokeColor }}" stroke-width="8.6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>

    @if($showText)
        <div class="flex flex-col">
            <span class="{{ $textSize }} font-bold {{ $textColor }} leading-none tracking-tight">
                Lunas<span class="{{ $inColor }}">In</span>
            </span>
            @if($tagline)
                <span class="text-[10px] {{ $subColor }} font-medium leading-tight mt-0.5">Catat, ingat, lunas.</span>
            @endif
        </div>
    @endif
</div>
