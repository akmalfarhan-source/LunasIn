<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi massal (mass assignment).
     */
    protected $fillable = ['user_id', 'name', 'phone', 'note'];

    // =========================================================
    // RELASI
    // =========================================================

    /**
     * Kontak dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu kontak bisa punya banyak transaksi (loans).
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // =========================================================
    // HELPER
    // =========================================================

    /**
     * Cek apakah kontak masih punya transaksi yang belum lunas.
     * Digunakan sebelum menghapus kontak.
     */
    public function hasActiveLoan(): bool
    {
        return $this->loans()->where('status', 'belum_lunas')->exists();
    }
}
