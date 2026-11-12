@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold">Tambah Buku Baru</h3>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali ke Daftar Buku</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-custom">
        <div class="card-header bg-white fw-bold">Form Tambah Buku</div>
        <div class="card-body">
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label small fw-semibold">ID Kategori</label>
                        <input type="number" name="kategori_id" class="form-control" value="{{ old('kategori_id') }}" placeholder="Contoh: 1" required>
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="form-label small fw-semibold">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Masukkan judul buku" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}" placeholder="Nama penulis" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}" placeholder="Contoh: 2024" required>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Buku</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection