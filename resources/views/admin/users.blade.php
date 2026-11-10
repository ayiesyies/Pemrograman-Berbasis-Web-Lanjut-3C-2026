@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header Welcome -->
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
        <h3 class="fw-bold m-0">Kelola Pengguna & Role 👤</h3>
        <p class="m-0 mt-1 text-white-50">Halaman pengelolaan akun pengguna dan penetapan hak akses (RBAC) sistem perpustakaan.</p>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Daftar Pengguna -->
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Daftar Pengguna Terdaftar</h5>
            <span class="badge bg-primary fs-6">Total: {{ $users->count() }} Pengguna</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role Saat Ini</th>
                        <th width="260">Ubah Role</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    @if($role->name === 'admin')
                                        <span class="badge bg-danger p-2">Admin</span>
                                    @elseif($role->name === 'petugas')
                                        <span class="badge bg-info p-2">Petugas</span>
                                    @else
                                        <span class="badge bg-success p-2">Siswa</span>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <!-- Form Ubah Role -->
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-select form-select-sm" required>
                                        @foreach($roles as $roleOption)
                                            <option value="{{ $roleOption->name }}" {{ $user->hasRole($roleOption->name) ? 'selected' : '' }}>
                                                {{ ucfirst($roleOption->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </form>
                            </td>
                            <td>
                                <!-- Form Hapus User -->
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection