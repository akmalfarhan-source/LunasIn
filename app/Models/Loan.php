<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'user_id', 'contact_id', 'type', 'amount',
        'loan_date', 'due_date', 'status', 'note',
    ];

    /**
     * Cast kolom ke tipe yang sesuai supaya perhitungan lebih mudah.
     */
    protected $casts = [
        'amount'    => 'decimal:2',
        'loan_date' => 'date',
        'due_date'  => 'date',
    ];

    // =========================================================
    // RELASI
    // =========================================================

    /**
     * Transaksi dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Transaksi terkait satu kontak.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Satu transaksi bisa punya banyak pembayaran/cicilan.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('paid_at', 'desc');
    }

    // =========================================================
    // ACCESSOR (Atribut Tambahan)
    // =========================================================

    /**
     * Hitung total pembayaran yang sudah masuk.
     * Diakses via $loan->total_paid
     */
    public function getTotalPaidAttribute(): float
    {
        // sum() mengembalikan null jika belum ada pembayaran, ?? 0 untuk default
        return (float) $this->payments()->sum('amount');
    }

    /**
     * Hitung sisa yang belum dibayar.
     * Diakses via $loan->remaining
     */
    public function getRemainingAttribute(): float
    {
        // Sisa = Nominal awal - Total yang sudah dibayar
        return (float) $this->amount - $this->total_paid;
    }

    /**
     * Tentukan status tampilan dinamis:
     * - lunas: jika status transaksi sudah lunas
     * - terlambat: jika belum lunas dan tanggal jatuh tempo sudah lewat sebelum hari ini
     * - hampir_jatuh_tempo: jika belum lunas dan jatuh tempo antara hari ini s/d 7 hari ke depan
     * - belum_lunas: jika belum lunas dan jatuh tempo masih lebih dari 7 hari ke depan
     * Diakses via $loan->display_status
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->status === 'lunas') {
            return 'lunas';
        }

        $today = Carbon::today();
        $dueDate = $this->due_date->copy()->startOfDay();

        if ($dueDate->lt($today)) {
            return 'terlambat';
        }

        if ($dueDate->between($today, $today->copy()->addDays(7))) {
            return 'hampir_jatuh_tempo';
        }

        return 'belum_lunas';
    }

    // =========================================================
    // SCOPE (Query Tambahan)
    // =========================================================

    /**
     * Scope untuk transaksi yang sudah melewati jatuh tempo dan belum lunas.
     * Contoh: Loan::overdue()->get()
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'belum_lunas')
                     ->where('due_date', '<', Carbon::today());
    }

    /**
     * Scope untuk transaksi yang jatuh tempo dalam 7 hari ke depan dan belum lunas.
     * Contoh: Loan::dueSoon()->get()
     */
    public function scopeDueSoon($query)
    {
        return $query->where('status', 'belum_lunas')
                     ->whereBetween('due_date', [Carbon::today(), Carbon::today()->addDays(7)]);
    }

    // =========================================================
    // METHOD LOGIKA BISNIS
    // =========================================================

    /**
     * Perbarui status transaksi secara otomatis berdasarkan sisa.
     * Dipanggil setelah setiap pembayaran ditambah atau dihapus.
     */
    public function refreshStatus(): void
    {
        // Jika sisa <= 0, tandai lunas; jika tidak, kembalikan ke belum_lunas
        $newStatus = $this->remaining <= 0 ? 'lunas' : 'belum_lunas';
        $this->update(['status' => $newStatus]);
    }
}
