@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header -->
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
        <h3 class="fw-bold m-0">Laporan Rekap Perpustakaan 📊</h3>
        <p class="m-0 mt-1 text-white-50">Ringkasan statistik dan aktivitas transaksi peminjaman perpustakaan.</p>
    </div>

    <!-- Cards Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-custom p-3 border-0 shadow-sm text-center">
                <span class="text-muted small fw-semibold">Total Koleksi Buku</span>
                <h3 class="fw-bold text-primary m-0 mt-2">120</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-3 border-0 shadow-sm text-center">
                <span class="text-muted small fw-semibold">Peminjaman Aktif</span>
                <h3 class="fw-bold text-warning m-0 mt-2">15</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-3 border-0 shadow-sm text-center">
                <span class="text-muted small fw-semibold">Total Selesai Dikembalikan</span>
                <h3 class="fw-bold text-success m-0 mt-2">85</h3>
            </div>
        </div>
    </div>
</div>
@endsection