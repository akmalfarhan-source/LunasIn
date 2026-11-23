<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel contacts untuk menyimpan data kontak peminjam/pemberi pinjaman.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            // Setiap kontak dimiliki oleh satu user (isolasi data per akun)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');           // Nama kontak
            $table->string('phone')->nullable(); // Nomor telepon (opsional)
            $table->text('note')->nullable();    // Catatan tambahan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel contacts.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
