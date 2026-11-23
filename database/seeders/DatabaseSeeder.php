<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Isi database dengan data demo untuk presentasi.
     */
    public function run(): void
    {
        // ============================================================
        // AKUN DEMO
        // ============================================================
        $user = User::create([
            'name'     => 'Demo User',
            'email'    => 'demo@lunasin.test',
            'password' => Hash::make('password'),
        ]);

        // ============================================================
        // KONTAK (4-5 kontak dengan nama Indonesia)
        // ============================================================
        $budi = Contact::create([
            'user_id' => $user->id,
            'name'    => 'Budi Santoso',
            'phone'   => '08123456789',
            'note'    => 'Teman kantor',
        ]);

        $siti = Contact::create([
            'user_id' => $user->id,
            'name'    => 'Siti Rahayu',
            'phone'   => '08987654321',
            'note'    => 'Tetangga',
        ]);

        $andi = Contact::create([
            'user_id' => $user->id,
            'name'    => 'Andi Wijaya',
            'phone'   => '08567891234',
            'note'    => 'Saudara',
        ]);

        $dewi = Contact::create([
            'user_id' => $user->id,
            'name'    => 'Dewi Lestari',
            'phone'   => null,
            'note'    => 'Teman kuliah',
        ]);

        $reza = Contact::create([
            'user_id' => $user->id,
            'name'    => 'Reza Firmansyah',
            'phone'   => '08234567890',
            'note'    => 'Rekan bisnis',
        ]);

        // ============================================================
        // TRANSAKSI (6-8 transaksi campuran)
        // ============================================================

        // 1. Hutang ke Budi - SUDAH LUNAS (ada riwayat pembayaran lengkap)
        $hutangBudiLunas = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $budi->id,
            'type'       => 'hutang',
            'amount'     => 1000000,
            'loan_date'  => now()->subMonths(3),
            'due_date'   => now()->subMonths(1),
            'status'     => 'lunas',
            'note'       => 'Pinjam buat beli laptop',
        ]);
        Payment::create([
            'loan_id' => $hutangBudiLunas->id,
            'amount'  => 500000,
            'paid_at' => now()->subMonths(2),
            'note'    => 'Cicilan pertama',
        ]);
        Payment::create([
            'loan_id' => $hutangBudiLunas->id,
            'amount'  => 500000,
            'paid_at' => now()->subMonths(1)->subDays(5),
            'note'    => 'Pelunasan',
        ]);

        // 2. Piutang ke Siti - SUDAH LUNAS
        $piutangSitiLunas = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $siti->id,
            'type'       => 'piutang',
            'amount'     => 500000,
            'loan_date'  => now()->subMonths(2),
            'due_date'   => now()->subMonths(1),
            'status'     => 'lunas',
            'note'       => 'Pinjam buat keperluan dapur',
        ]);
        Payment::create([
            'loan_id' => $piutangSitiLunas->id,
            'amount'  => 500000,
            'paid_at' => now()->subDays(35),
            'note'    => 'Lunas sekaligus',
        ]);

        // 3. Hutang ke Andi - TERLAMBAT (jatuh tempo sudah lewat)
        $hutangAndiTerlambat = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $andi->id,
            'type'       => 'hutang',
            'amount'     => 2000000,
            'loan_date'  => now()->subMonths(2),
            'due_date'   => now()->subDays(10), // Sudah lewat 10 hari!
            'status'     => 'belum_lunas',
            'note'       => 'Pinjam buat biaya kos',
        ]);
        Payment::create([
            'loan_id' => $hutangAndiTerlambat->id,
            'amount'  => 500000,
            'paid_at' => now()->subDays(30),
            'note'    => 'Cicilan pertama',
        ]);

        // 4. Piutang ke Dewi - HAMPIR JATUH TEMPO (5 hari lagi)
        $piutangDewiHampir = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $dewi->id,
            'type'       => 'piutang',
            'amount'     => 750000,
            'loan_date'  => now()->subMonths(1),
            'due_date'   => now()->addDays(5), // Jatuh tempo 5 hari lagi
            'status'     => 'belum_lunas',
            'note'       => 'Pinjam buat beli buku',
        ]);

        // 5. Hutang ke Reza - Baru dicatat, jatuh tempo 2 bulan lagi
        $hutangRezaBaru = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $reza->id,
            'type'       => 'hutang',
            'amount'     => 3000000,
            'loan_date'  => now()->subDays(5),
            'due_date'   => now()->addMonths(2),
            'status'     => 'belum_lunas',
            'note'       => 'Modal usaha kecil',
        ]);
        Payment::create([
            'loan_id' => $hutangRezaBaru->id,
            'amount'  => 1000000,
            'paid_at' => now()->subDays(2),
            'note'    => 'Cicilan awal',
        ]);

        // 6. Piutang ke Budi - Belum lunas, jatuh tempo 3 minggu lagi
        $piutangBudi = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $budi->id,
            'type'       => 'piutang',
            'amount'     => 1500000,
            'loan_date'  => now()->subDays(10),
            'due_date'   => now()->addDays(21),
            'status'     => 'belum_lunas',
            'note'       => 'Pinjam buat renovasi rumah',
        ]);
        Payment::create([
            'loan_id' => $piutangBudi->id,
            'amount'  => 300000,
            'paid_at' => now()->subDays(5),
            'note'    => 'Pembayaran awal',
        ]);

        // 7. Piutang ke Reza - TERLAMBAT
        $piutangRezaTerlambat = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $reza->id,
            'type'       => 'piutang',
            'amount'     => 2500000,
            'loan_date'  => now()->subMonths(3),
            'due_date'   => now()->subDays(15), // Terlambat 15 hari
            'status'     => 'belum_lunas',
            'note'       => 'Investasi bersama',
        ]);

        // 8. Hutang ke Siti - Hampir jatuh tempo 3 hari lagi
        $hutangSitiHampir = Loan::create([
            'user_id'    => $user->id,
            'contact_id' => $siti->id,
            'type'       => 'hutang',
            'amount'     => 800000,
            'loan_date'  => now()->subDays(27),
            'due_date'   => now()->addDays(3),
            'status'     => 'belum_lunas',
            'note'       => 'Bayar iuran RT',
        ]);
        Payment::create([
            'loan_id' => $hutangSitiHampir->id,
            'amount'  => 200000,
            'paid_at' => now()->subDays(10),
            'note'    => 'Cicilan 1',
        ]);
        Payment::create([
            'loan_id' => $hutangSitiHampir->id,
            'amount'  => 300000,
            'paid_at' => now()->subDays(3),
            'note'    => 'Cicilan 2',
        ]);
    }
}
