<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku ke tampilan index.
     */
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    /**
     * Perbaikan A2: Pencarian buku aman dari SQL Injection.
     * Menggunakan Eloquent ORM (Parameter Binding otomatis) tanpa penggabungan string mentah.
     */
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        // Aman dari SQL Injection menggunakan Eloquent Parameter Binding
        $buku = Buku::where('judul', $judul)->get();

        return response()->json($buku);
    }

    /**
     * Perbaikan A3: Menghapus data buku (dipanggil via metode DELETE + CSRF Token).
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function create()
{
    return view('buku.create');
}

public function store(Request $request)
{
    // ... biarkan kode validasi & simpan data buku milikmu tetap di sini ...

    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
}
}