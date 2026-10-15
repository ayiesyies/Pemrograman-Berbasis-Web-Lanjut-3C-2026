<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    // Eager loading kategori + hitung jumlah peminjaman
    $query = Buku::with('kategori')
        ->withCount('peminjaman'); // Sesuaikan nama relasi peminjaman kamu

    // a. cari => Berdasarkan judul atau penulis (dengan LIKE)
    if ($request->filled('cari')) {
        $cari = $request->cari;
        $query->where(function ($q) use ($cari) {
            $q->where('judul', 'like', "%{$cari}%")
              ->orWhere('penulis', 'like', "%{$cari}%");
        });
    }

    // b. kategori => Filter berdasarkan kategori_id
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    // c. tahun => Filter berdasarkan tahun_terbit
    if ($request->filled('tahun')) {
        $query->where('tahun_terbit', $request->tahun);
    }

    // Ketentuan Tambahan:
    // a. Urutkan data terbaru lebih dulu (latest())
    // c. Query string terbawa saat berpindah halaman (withQueryString())
    $bukus = $query->latest()->paginate(10)->withQueryString();

    return response()->json([
        'status' => true,
        'message' => 'Daftar data buku berhasil diambil',
        'data' => $bukus->items(),
        'meta' => [
            'current_page' => $bukus->currentPage(),
            'last_page' => $bukus->lastPage(),
            'per_page' => $bukus->perPage(),
            'total' => $bukus->total(),
            'first_page_url' => $bukus->url(1),
            'last_page_url' => $bukus->url($bukus->lastPage()),
            'next_page_url' => $bukus->nextPageUrl(),
            'prev_page_url' => $bukus->previousPageUrl(),
        ]
    ], 200);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku->load('kategori')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjaman'])->find($id);

        if (!$buku) {
            return response()->json([
                'status' => false,
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data buku berhasil ditemukan',
            'data' => $buku
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'status' => false,
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        $buku->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data buku berhasil diperbarui',
            'data' => $buku->fresh()->load('kategori')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'status' => false,
                'message' => 'Data buku tidak ditemukan'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data buku berhasil dihapus'
        ], 200);
    }
}