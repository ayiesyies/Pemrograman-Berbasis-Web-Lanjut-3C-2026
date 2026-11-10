@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="card card-custom p-4">
        <h3 class="fw-bold mb-3">Detail Transaksi Peminjaman #{{ $peminjaman->id }}</h3>
        
        <table class="table table-bordered">
            <tr>
                <th width="200">ID Transaksi</th>
                <td>{{ $peminjaman->id }}</td>
            </tr>
            <tr>
                <th>Nama Peminjam (User ID)</th>
                <td>{{ $peminjaman->user->name ?? $peminjaman->user_id }}</td>
            </tr>
            <tr>
                <th>Judul Buku</th>
                <td>{{ $peminjaman->buku->judul ?? $peminjaman->buku_id }}</td>
            </tr>
            <tr>
                <th>Tanggal Pinjam</th>
                <td>{{ $peminjaman->tanggal_pinjam }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td><span class="badge bg-primary">{{ ucfirst($peminjaman->status) }}</span></td>
            </tr>
        </table>

        <a href="{{ route('buku.index') }}" class="btn btn-secondary mt-2">Kembali</a>
    </div>
</div>
@endsection