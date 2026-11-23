{{--
    Komponen Input Form dengan Label dan Pesan Error
    Props:
      - name: nama field (wajib)
      - label: label tampilan (string)
      - type: tipe input (default: text)
      - placeholder: placeholder (opsional)
      - value: nilai awal (opsional)
      - required: boolean (opsional)
    Contoh: <x-form-input name="name" label="Nama Kontak" placeholder="Contoh: Budi Santoso" required />
--}}
@props(['name', 'label' => '', 'type' => 'text', 'placeholder' => '', 'value' => '', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full rounded-xl border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 shadow-sm
            focus:border-sky-400 focus:ring-2 focus:ring-sky-200 transition-colors
            ' . ($errors->has($name) ? 'border-rose-400 focus:border-rose-400 focus:ring-rose-200' : '')]) }}
    >
    {{-- Tampilkan pesan error jika ada --}}
    @error($name)
        <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
