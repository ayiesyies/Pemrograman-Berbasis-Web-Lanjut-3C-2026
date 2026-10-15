<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Buku;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $rekap = Kategori::withCount('bukus')->get()->map(function ($kategori) {
            return [
                'kategori_id'   => $kategori->id,
                'nama_kategori' => $kategori->nama_kategori,
                'total_buku'    => $kategori->bukus_count,
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data rekap jumlah buku per kategori berhasil diambil',
            'data'    => $rekap
        ], 200);
    }

    public function peminjamanPerBuku()
    {
        $rekap = Buku::withCount('peminjaman')->get()->map(function ($buku) {
            return [
                'buku_id'          => $buku->id,
                'judul'            => $buku->judul,
                'total_peminjaman' => $buku->peminjaman_count,
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data rekap total peminjaman per buku berhasil diambil',
            'data'    => $rekap
        ], 200);
    }
}