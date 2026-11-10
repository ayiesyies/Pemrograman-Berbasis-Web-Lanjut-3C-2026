@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0e4c68 0%, #0099e5 100%);">
        <h3 class="fw-bold m-0">Profil Saya 👤</h3>
        <p class="m-0 mt-1 text-white-50">Kelola dan perbarui informasi profil akun kamu.</p>
    </div>

    <div class="card card-custom p-4 border-0 shadow-sm col-md-8 mx-auto">
        <form>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Email</label>
                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Role / Hak Akses</label>
                <input type="text" class="form-control text-capitalize" value="{{ auth()->user()->getRoleNames()->first() ?? 'Siswa' }}" readonly>
            </div>
        </form>
    </div>
</div>
@endsection