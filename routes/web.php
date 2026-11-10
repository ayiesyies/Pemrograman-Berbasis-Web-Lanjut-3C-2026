<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;

// Beranda Utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Seluruh Rute Terproteksi Login
Route::middleware(['auth'])->group(function () {

    // Redirect Dashboard Sesuai Role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('petugas')) return redirect()->route('petugas.dashboard');
        return redirect()->route('buku.index');
    })->name('dashboard');

    // Halaman Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    // Profil Saya (Tampilan & Simpan Perubahan)
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::patch('/profile', function (Request $request) {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    })->name('profile.update');

    // Peminjaman & Riwayat
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    Route::put('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::post('/peminjaman/pinjam/{bukuId}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/admin-store', [PeminjamanController::class, 'storeAdmin'])->name('peminjaman.storeAdmin');

    // Area Khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
        Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Dashboard Petugas
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->middleware('role:petugas|admin')->name('petugas.dashboard');

    // Laporan Perpustakaan
    Route::middleware(['can:lihat laporan perpustakaan'])->group(function () {
        Route::get('/laporan', function () { return view('laporan.index'); })->name('laporan.index');
    });

    // Celah A2: Pencarian SQL Injection via Query String
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');

    // Celah A3: Penghapusan Buku Menggunakan HTTP GET
    Route::get('/buku/{buku}/hapus', [BukuController::class, 'destroy'])->name('buku.hapus.get');

    // Celah A4: Detail Peminjaman Tanpa Cek Otorisasi Kepemilikan (IDOR)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
});

require __DIR__.'/auth.php';


