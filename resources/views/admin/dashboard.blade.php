@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header Banner -->
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0e4c68 0%, #0099e5 100%);">
        <h3 class="fw-bold m-0">Selamat Datang, Admin Perpustakaan! 👑</h3>
        <p class="m-0 mt-1 text-white-50">Halaman kontrol utama untuk mengelola pengguna, koleksi buku, transaksi, dan laporan perpustakaan.</p>
    </div>

    <!-- Cards Quick Menu -->
    <div class="row g-3">
        <!-- Kelola Pengguna -->
        <div class="col-md-3">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Manajemen Akun</span>
                <h5 class="fw-bold my-2">Kelola User</h5>
                <a href="{{ route('admin.users') }}" class="btn btn-danger btn-sm mt-auto">Kelola Pengguna</a>
            </div>
        </div>

        <!-- Kelola Data Buku -->
        <div class="col-md-3">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Koleksi & Data Buku</span>
                <h5 class="fw-bold my-2">Kelola Buku</h5>
                <a href="{{ route('buku.index') }}" class="btn btn-custom-blue btn-sm mt-auto">Akses Buku</a>
            </div>
        </div>

        <!-- Transaksi Peminjaman -->
        <div class="col-md-3">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Transaksi Peminjaman</span>
                <h5 class="fw-bold my-2">Persetujuan</h5>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-custom-blue btn-sm mt-auto">Akses Peminjaman</a>
            </div>
        </div>

        <!-- Laporan Perpustakaan -->
        <div class="col-md-3">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Laporan Perpustakaan</span>
                <h5 class="fw-bold my-2">Rekap Data</h5>
                <a href="{{ route('laporan.index') }}" class="btn btn-info text-white btn-sm mt-auto">Lihat Laporan</a>
            </div>
        </div>
    </div>
</div>
@endsection