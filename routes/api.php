
<?php

use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RekapController;

// Route::apiResource('bukus', BukuController::class);
// Route::post('/buku', [BukuController::class, 'store']);

// Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
// Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);

// Gunakan middleware 'web' dan 'auth' agar mengenali session login Breeze
Route::middleware(['web', 'auth'])->group(function () {
    
    // Khusus yang punya permission 'kelola data buku' (Admin & Petugas)
    Route::middleware(['permission:kelola data buku'])->group(function () {
        Route::post('/buku', [BukuController::class, 'store']);
        Route::put('/buku/{buku}', [BukuController::class, 'update']);
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy']);
    });

    // Untuk semua user yang punya permission 'lihat daftar buku' (Admin, Petugas, Siswa)
    Route::middleware(['permission:lihat daftar buku'])->group(function () {
        Route::get('/buku', [BukuController::class, 'index']);
        Route::get('/buku/{buku}', [BukuController::class, 'show']);
    });
});





