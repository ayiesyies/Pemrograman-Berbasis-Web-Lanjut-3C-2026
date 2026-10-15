<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// Halaman Beranda (ditambahkan name 'home')
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Web Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');