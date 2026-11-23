<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Simpan pembayaran/cicilan baru untuk sebuah transaksi.
     */
    public function store(Request $request, Loan $loan)
    {
        // Pastikan transaksi ini milik user yang login
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        // Hitung sisa sebelum pembayaran ini
        $remaining = $loan->remaining;

        $validated = $request->validate([
            'amount'  => [
                'required', 'numeric', 'min:1',
                // Nominal tidak boleh melebihi sisa
                "max:{$remaining}",
            ],
            'paid_at' => 'required|date',
            'note'    => 'nullable|string|max:500',
        ], [
            'amount.required' => 'Nominal pembayaran wajib diisi.',
            'amount.numeric'  => 'Nominal harus berupa angka.',
            'amount.min'      => 'Nominal harus lebih dari 0.',
            'amount.max'      => 'Nominal pembayaran tidak boleh melebihi sisa transaksi.',
            'paid_at.required'=> 'Tanggal pembayaran wajib diisi.',
            'paid_at.date'    => 'Format tanggal tidak valid.',
        ]);

        $validated['loan_id'] = $loan->id;

        Payment::create($validated);

        // Perbarui status transaksi (otomatis lunas jika sisa = 0)
        $loan->refreshStatus();

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    /**
     * Hapus catatan pembayaran dan perbarui status transaksi.
     */
    public function destroy(Loan $loan, Payment $payment)
    {
        // Pastikan transaksi milik user yang login
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        // Pastikan pembayaran ini memang milik transaksi tersebut
        abort_if($payment->loan_id !== $loan->id, 403, 'Akses ditolak.');

        $payment->delete();

        // Perbarui status: jika sisa > 0 setelah dihapus, status kembali belum_lunas
        $loan->refreshStatus();

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
