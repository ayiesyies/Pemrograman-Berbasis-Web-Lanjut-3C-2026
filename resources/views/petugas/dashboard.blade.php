@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header Banner -->
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0e4c68 0%, #0099e5 100%);">
        <h3 class="fw-bold m-0">Selamat Datang, Petugas Perpustakaan! 👋</h3>
        <p class="m-0 mt-1 text-white-50">Halaman operasional peminjaman, pengembalian, dan kelola koleksi buku perpustakaan.</p>
    </div>

    <!-- Cards Quick Menu -->
    <div class="row g-3">
        <!-- Kelola Data Buku -->
        <div class="col-md-4">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Koleksi & Data Buku</span>
                <h5 class="fw-bold my-2">Kelola Buku</h5>
                @can('kelola data buku')
                    <a href="{{ route('buku.index') }}" class="btn btn-custom-blue btn-sm mt-auto">Akses Buku</a>
                @else
                    <button class="btn btn-sm btn-secondary mt-auto" disabled>Tidak Ada Akses</button>
                @endcan
            </div>
        </div>

        <!-- Transaksi Peminjaman -->
        <div class="col-md-4">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Transaksi Peminjaman</span>
                <h5 class="fw-bold my-2">Persetujuan</h5>
                @can('kelola peminjaman')
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-custom-blue btn-sm mt-auto">Akses Peminjaman</a>
                @else
                    <button class="btn btn-sm btn-secondary mt-auto" disabled>Tidak Ada Akses</button>
                @endcan
            </div>
        </div>

        <!-- Laporan Perpustakaan -->
        <div class="col-md-4">
            <div class="card card-custom p-3 shadow-sm h-100 border-0">
                <span class="text-muted small fw-semibold">Laporan Perpustakaan</span>
                <h5 class="fw-bold my-2">Rekap Data</h5>
                @can('lihat laporan perpustakaan')
                    <a href="{{ route('laporan.index') }}" class="btn btn-info text-white btn-sm mt-auto">Lihat Laporan</a>
                @else
                    <button class="btn btn-sm btn-secondary mt-auto" disabled>Tidak Ada Akses</button>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection