<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['loan_id', 'amount', 'paid_at', 'note'];

    /**
     * Cast kolom ke tipe yang sesuai.
     */
    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'date',
    ];

    // =========================================================
    // RELASI
    // =========================================================

    /**
     * Pembayaran ini terkait satu transaksi (loan).
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
