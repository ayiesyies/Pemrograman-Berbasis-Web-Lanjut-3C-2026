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

    // Manajemen Profil
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

    // Buku (Dapat diakses seluruh user yang login, termasuk siswa)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku-cari', [BukuController::class, 'cari'])->name('buku.cari');

    // Kelola Buku: Tambah, Ubah, dan Hapus (Hanya Admin & Petugas via Gate kelola-buku)
    Route::middleware(['can:kelola-buku'])->group(function () {
        // Tambah Buku
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

        // Ubah Buku
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');

        // Hapus Buku
        Route::delete('/buku/{buku}/hapus', [BukuController::class, 'destroy'])->name('buku.hapus');
    });

    // Peminjaman & Riwayat
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::put('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::post('/peminjaman/pinjam/{bukuId}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/admin-store', [PeminjamanController::class, 'storeAdmin'])->name('peminjaman.storeAdmin');

    // Area Khusus Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Area Khusus Petugas & Admin
    Route::middleware(['role:petugas|admin'])->group(function () {
        Route::get('/petugas/dashboard', function () {
            return view('petugas.dashboard');
        })->name('petugas.dashboard');
    });

    // Laporan Perpustakaan (Berdasarkan Permission)
    Route::middleware(['can:lihat laporan perpustakaan'])->group(function () {
        Route::get('/laporan', function () { return view('laporan.index'); })->name('laporan.index');
    });
        
    // Route::get('/uji-error', function () {
    // throw new \RuntimeException('Pengujian halaman error produksi');

    // });
});


require __DIR__.'/auth.php';