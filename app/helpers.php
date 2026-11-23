<?php

/*
|--------------------------------------------------------------------------
| Helper Global - LunasIn
|--------------------------------------------------------------------------
| File ini berisi fungsi-fungsi helper global yang bisa dipanggil
| dari mana saja (Controller, View, dll.) tanpa perlu import.
| Sudah didaftarkan via autoload di composer.json.
*/

if (!function_exists('rupiah')) {
    /**
     * Format angka menjadi format Rupiah Indonesia.
     * Contoh: rupiah(1500000) → "Rp 1.500.000"
     *
     * @param  float|int $amount  Jumlah yang akan diformat
     * @return string             String dalam format Rupiah
     */
    function rupiah(float|int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
