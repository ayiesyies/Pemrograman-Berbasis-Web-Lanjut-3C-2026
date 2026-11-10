<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku ke tampilan index.
     * Mengirimkan variabel $bukus agar Blade dapat merender perulangan (Celah A1).
     */
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    /**
     * Celah A2: Pencarian buku rentan SQL Injection.
     * Menggabungkan variabel $judul langsung ke dalam string kueri SQL.
     */
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        // Celah A2: Penggabungan string langsung tanpa binding
        $buku = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");

        return response()->json($buku);
    }

    /**
     * Celah A3: Menghapus data buku.
     * Dipanggil oleh rute GET /buku/{buku}/hapus dari berkas jebakan.html.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}