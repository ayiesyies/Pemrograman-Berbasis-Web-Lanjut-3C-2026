<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\BukuResource; // 1. Tambahkan Import API Resource
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjaman');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $bukus = $query->latest()->paginate(10)->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Daftar data buku berhasil diambil',
            // 2. Bungkus item buku dengan BukuResource::collection
            'data' => BukuResource::collection($bukus->items()),
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

    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Buku berhasil ditambahkan',
            // 3. Bungkus response store dengan BukuResource
            'data' => new BukuResource($buku->load('kategori'))
        ], 201);
    }

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
            // 4. Bungkus response show dengan BukuResource
            'data' => new BukuResource($buku)
        ], 200);
    }

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
            // 5. Bungkus response update dengan BukuResource
            'data' => new BukuResource($buku->fresh()->load('kategori'))
        ], 200);
    }

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