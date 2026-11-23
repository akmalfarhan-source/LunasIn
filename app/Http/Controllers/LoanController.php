<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Tampilkan daftar transaksi dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        // Mulai query dari transaksi milik user yang login
        $query = auth()->user()->loans()->with('contact', 'payments');

        // Filter berdasarkan jenis (hutang/piutang)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                // Terlambat: belum lunas dan sudah lewat jatuh tempo
                $query->overdue();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Pencarian berdasarkan nama kontak
        if ($request->filled('search')) {
            $query->whereHas('contact', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        return view('loans.index', compact('loans'));
    }

    /**
     * Tampilkan form tambah transaksi baru.
     */
    public function create()
    {
        // Ambil semua kontak milik user untuk dropdown
        $contacts = auth()->user()->contacts()->orderBy('name')->get();

        return view('loans.create', compact('contacts'));
    }

    /**
     * Simpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'type'       => 'required|in:hutang,piutang',
            'amount'     => 'required|numeric|min:1',
            'loan_date'  => 'required|date',
            'due_date'   => 'required|date|after_or_equal:loan_date',
            'note'       => 'nullable|string|max:500',
        ], [
            'contact_id.required'       => 'Kontak wajib dipilih.',
            'contact_id.exists'         => 'Kontak tidak valid.',
            'type.required'             => 'Jenis transaksi wajib dipilih.',
            'type.in'                   => 'Jenis transaksi tidak valid.',
            'amount.required'           => 'Nominal wajib diisi.',
            'amount.numeric'            => 'Nominal harus berupa angka.',
            'amount.min'                => 'Nominal harus lebih dari 0.',
            'loan_date.required'        => 'Tanggal pinjam wajib diisi.',
            'loan_date.date'            => 'Format tanggal pinjam tidak valid.',
            'due_date.required'         => 'Tanggal jatuh tempo wajib diisi.',
            'due_date.date'             => 'Format tanggal jatuh tempo tidak valid.',
            'due_date.after_or_equal'   => 'Tanggal jatuh tempo tidak boleh sebelum tanggal pinjam.',
            'note.max'                  => 'Catatan maksimal 500 karakter.',
        ]);

        // Pastikan kontak yang dipilih benar-benar milik user yang login
        $contact = Contact::findOrFail($validated['contact_id']);
        abort_if($contact->user_id !== auth()->id(), 403, 'Kontak tidak valid.');

        // Tambahkan user_id ke data yang akan disimpan
        $validated['user_id'] = auth()->id();

        Loan::create($validated);

        return redirect()->route('loans.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Tampilkan detail transaksi beserta riwayat pembayaran.
     */
    public function show(Loan $loan)
    {
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        // Muat relasi contact dan payments sekaligus untuk efisiensi
        $loan->load('contact', 'payments');

        return view('loans.show', compact('loan'));
    }

    /**
     * Tampilkan form edit transaksi.
     */
    public function edit(Loan $loan)
    {
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        $contacts = auth()->user()->contacts()->orderBy('name')->get();

        return view('loans.edit', compact('loan', 'contacts'));
    }

    /**
     * Simpan perubahan transaksi ke database.
     */
    public function update(Request $request, Loan $loan)
    {
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'type'       => 'required|in:hutang,piutang',
            'amount'     => 'required|numeric|min:1',
            'status'     => 'required|in:belum_lunas,lunas',
            'loan_date'  => 'required|date',
            'due_date'   => 'required|date|after_or_equal:loan_date',
            'note'       => 'nullable|string|max:500',
        ], [
            'contact_id.required'       => 'Kontak wajib dipilih.',
            'amount.required'           => 'Nominal wajib diisi.',
            'amount.numeric'            => 'Nominal harus berupa angka.',
            'amount.min'                => 'Nominal harus lebih dari 0.',
            'status.required'           => 'Status wajib dipilih.',
            'status.in'                 => 'Status tidak valid.',
            'loan_date.required'        => 'Tanggal pinjam wajib diisi.',
            'due_date.required'         => 'Tanggal jatuh tempo wajib diisi.',
            'due_date.after_or_equal'   => 'Tanggal jatuh tempo tidak boleh sebelum tanggal pinjam.',
        ]);

        // Pastikan kontak yang dipilih milik user yang login
        $contact = Contact::findOrFail($validated['contact_id']);
        abort_if($contact->user_id !== auth()->id(), 403, 'Kontak tidak valid.');

        // Jika user mengubah status menjadi lunas dan masih ada sisa, catat pelunasan
        if ($validated['status'] === 'lunas' && $loan->remaining > 0) {
            $loan->payments()->create([
                'amount'  => $loan->remaining,
                'paid_at' => now(),
                'note'    => 'Pelunasan dari edit transaksi',
            ]);
        }

        $loan->update($validated);

        return redirect()->route('loans.show', $loan)
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Tandai transaksi langsung lunas dengan mencatat pelunasan seluruh sisa.
     */
    public function markPaid(Loan $loan)
    {
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        if ($loan->remaining > 0) {
            $loan->payments()->create([
                'amount'  => $loan->remaining,
                'paid_at' => now(),
                'note'    => 'Pelunasan langsung',
            ]);
        }

        $loan->update(['status' => 'lunas']);

        return back()->with('success', 'Transaksi berhasil ditandai lunas.');
    }

    /**
     * Hapus transaksi beserta semua pembayarannya (cascade).
     */
    public function destroy(Loan $loan)
    {
        abort_if($loan->user_id !== auth()->id(), 403, 'Akses ditolak.');

        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
