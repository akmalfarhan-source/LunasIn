<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard dengan ringkasan data keuangan user.
     */
    public function index()
    {
        $user = auth()->user();

        // =====================================================
        // KARTU RINGKASAN (hanya transaksi belum lunas)
        // =====================================================

        // Total hutang: jumlah sisa (remaining) dari semua transaksi hutang yang belum lunas
        // Kita gunakan koleksi dan sum accessor 'remaining' karena accessor tidak bisa di-query langsung
        $totalHutang = $user->loans()
            ->with('payments')
            ->where('type', 'hutang')
            ->where('status', 'belum_lunas')
            ->get()
            ->sum('remaining');

        // Total piutang: jumlah sisa dari semua transaksi piutang yang belum lunas
        $totalPiutang = $user->loans()
            ->with('payments')
            ->where('type', 'piutang')
            ->where('status', 'belum_lunas')
            ->get()
            ->sum('remaining');

        // Selisih bersih: piutang dikurangi hutang
        $selisihBersih = $totalPiutang - $totalHutang;

        // =====================================================
        // DAFTAR JATUH TEMPO 7 HARI KE DEPAN
        // =====================================================
        $dueSoon = $user->loans()
            ->with('contact', 'payments')
            ->dueSoon()
            ->orderBy('due_date')
            ->get();

        // =====================================================
        // DAFTAR TERLAMBAT
        // =====================================================
        $overdue = $user->loans()
            ->with('contact', 'payments')
            ->overdue()
            ->orderBy('due_date')
            ->get();

        // =====================================================
        // 5 TRANSAKSI TERBARU
        // =====================================================
        $recentLoans = $user->loans()
            ->with('contact', 'payments')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalHutang', 'totalPiutang', 'selisihBersih',
            'dueSoon', 'overdue', 'recentLoans'
        ));
    }
}
