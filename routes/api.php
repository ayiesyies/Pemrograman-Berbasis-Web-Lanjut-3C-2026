
<?php

use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RekapController;

Route::apiResource('bukus', BukuController::class);
Route::post('/buku', [BukuController::class, 'store']);

Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
