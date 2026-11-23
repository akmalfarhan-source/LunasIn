<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel loans untuk menyimpan data transaksi hutang dan piutang.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            // Relasi ke user dan kontak
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            // Jenis: hutang (saya meminjam) atau piutang (saya meminjamkan)
            $table->enum('type', ['hutang', 'piutang']);
            // Nominal pinjaman, presisi tinggi untuk nilai besar
            $table->decimal('amount', 15, 2);
            $table->date('loan_date');  // Tanggal pinjam
            $table->date('due_date');   // Tanggal jatuh tempo
            // Status: belum_lunas (default) atau lunas
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->text('note')->nullable(); // Catatan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel loans.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
