@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold">Kelola Peminjaman Buku</h3>
        <!-- Tombol Buka Modal Peminjaman Baru -->
        <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahPeminjaman">
            + Tambah Peminjaman Baru
        </button>
    </div>

    <!-- Alert Flash Message -->
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

    <!-- Tabel Kelola Peminjaman -->
    <div class="card card-custom p-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle m-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Siswa</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamanList as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $item->user->name ?? 'User Hilang' }}</td>
                            <td class="fw-bold text-primary">{{ $item->buku->judul ?? 'Buku Hilang' }}</td>
                            <td class="text-center">{{ $item->tanggal_pinjam }}</td>
                            <td class="text-center">{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge px-3 py-2 
                                    @if($item->status == 'disetujui' || $item->status == 'dipinjam') bg-success 
                                    @elseif($item->status == 'menunggu') bg-warning text-dark 
                                    @elseif($item->status == 'ditolak') bg-danger 
                                    @else bg-secondary @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if($item->status == 'menunggu')
                                        <!-- Tombol Setujui -->
                                        <form action="{{ route('peminjaman.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="btn btn-sm btn-success fw-semibold">Setujui</button>
                                        </form>

                                        <!-- Tombol Tolak -->
                                        <form action="{{ route('peminjaman.updateStatus', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="btn btn-sm btn-danger fw-semibold">Tolak</button>
                                        </form>
                                    @elseif($item->status == 'disetujui' || $item->status == 'dipinjam')
                                        <!-- Tombol Kembalikan -->
                                        <form action="{{ route('peminjaman.updateStatus', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dikembalikan">
                                            <button type="submit" class="btn btn-sm btn-warning text-dark fw-semibold">Kembalikan</button>
                                        </form>
                                    @else
                                        <span class="text-muted small fw-bold">- Selesai -</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Peminjaman Baru -->
<div class="modal fade" id="modalTambahPeminjaman" tabindex="-1" aria-labelledby="modalTambahPeminjamanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalTambahPeminjamanLabel">➕ Tambah Peminjaman Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('peminjaman.storeAdmin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Pilih Siswa -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Siswa / Peminjam</label>
                        <select name="user_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Siswa --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Buku -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Buku</label>
                        <select name="buku_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Buku --</option>
                            @foreach($bukuList as $buku)
                                <option value="{{ $buku->id }}">{{ $buku->judul }} - (Penulis: {{ $buku->penulis }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Status Peminjaman -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Peminjaman</label>
                        <select name="status" class="form-select" required>
                            <option value="disetujui" selected>Disetujui (Langsung Pinjam)</option>
                            <option value="menunggu">Menunggu Konfirmasi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection