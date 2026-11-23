<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel payments untuk menyimpan riwayat cicilan/pembayaran.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Setiap pembayaran terkait satu transaksi (cascade delete: hapus loan → hapus semua pembayarannya)
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2); // Nominal pembayaran
            $table->date('paid_at');           // Tanggal bayar
            $table->text('note')->nullable();  // Catatan pembayaran (opsional)
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel payments.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
