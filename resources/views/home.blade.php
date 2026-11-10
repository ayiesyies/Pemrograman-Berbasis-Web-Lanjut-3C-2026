@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-custom p-5 text-center">
                <h2 class="fw-bold text-dark mb-3">Selamat Datang di Perpustakaan Arirang</h2>
                <p class="text-muted mb-4">Temukan berbagai koleksi buku untuk menambah pengetahuan dan wawasan.</p>
                <div>
                    <a href="{{ route('buku.index') }}" class="btn btn-custom-blue">Lihat Daftar Buku</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection