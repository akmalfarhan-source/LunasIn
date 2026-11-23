<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Tampilkan daftar semua kontak milik user yang login.
     */
    public function index()
    {
        // Ambil kontak milik user yang login, urutkan berdasarkan nama
        $contacts = auth()->user()->contacts()
            ->withCount('loans') // Hitung jumlah transaksi per kontak
            ->orderBy('name')
            ->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Tampilkan form tambah kontak baru.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Simpan kontak baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dengan pesan error Bahasa Indonesia
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'note'  => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama kontak wajib diisi.',
            'name.max'      => 'Nama maksimal 255 karakter.',
            'phone.max'     => 'Nomor telepon maksimal 20 karakter.',
            'note.max'      => 'Catatan maksimal 500 karakter.',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();

        Contact::create($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail kontak beserta daftar transaksinya.
     */
    public function show(Contact $contact)
    {
        // Pastikan kontak ini milik user yang login (keamanan)
        abort_if($contact->user_id !== auth()->id(), 403, 'Akses ditolak.');

        $contact->load(['loans' => function ($query) {
            $query->with('payments')->latest();
        }]);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Tampilkan form edit kontak.
     */
    public function edit(Contact $contact)
    {
        // Pastikan kontak ini milik user yang login
        abort_if($contact->user_id !== auth()->id(), 403, 'Akses ditolak.');

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Simpan perubahan kontak ke database.
     */
    public function update(Request $request, Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403, 'Akses ditolak.');

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'note'  => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama kontak wajib diisi.',
            'name.max'      => 'Nama maksimal 255 karakter.',
            'phone.max'     => 'Nomor telepon maksimal 20 karakter.',
            'note.max'      => 'Catatan maksimal 500 karakter.',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')
            ->with('success', 'Kontak berhasil diperbarui.');
    }

    /**
     * Hapus kontak dari database.
     */
    public function destroy(Contact $contact)
    {
        abort_if($contact->user_id !== auth()->id(), 403, 'Akses ditolak.');

        // Cegah penghapusan jika masih ada transaksi yang belum lunas
        if ($contact->hasActiveLoan()) {
            return redirect()->route('contacts.index')
                ->with('error', 'Kontak tidak dapat dihapus karena masih memiliki transaksi yang belum lunas.');
        }

        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Kontak berhasil dihapus.');
    }
}
