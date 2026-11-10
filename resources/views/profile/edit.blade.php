@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0e4c68 0%, #0099e5 100%);">
        <h3 class="fw-bold m-0">Profil Saya 👤</h3>
        <p class="m-0 mt-1 text-white-50">Kelola dan perbarui informasi akun milikmu.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success col-md-8 mx-auto">
            {{ session('success') }}
        </div>
    @endif

    <div class="card card-custom p-4 border-0 shadow-sm col-md-8 mx-auto">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Role / Hak Akses</label>
                <input type="text" class="form-control text-capitalize bg-light" value="{{ auth()->user()->getRoleNames()->first() ?? 'Siswa' }}" disabled>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection