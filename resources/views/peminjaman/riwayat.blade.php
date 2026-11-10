@extends('layouts.app')

@section('content')
<div class="container my-4">
    <!-- Header Banner -->
    <div class="card border-0 text-white p-4 mb-4 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0e4c68 0%, #0099e5 100%);">
        <h3 class="fw-bold m-0">Riwayat Peminjaman Saya 📚</h3>
        <p class="m-0 mt-1 text-white-50">Daftar buku yang pernah dan sedang Kamu pinjam.</p>
    </div>

    <!-- Tabel Riwayat Peminjaman -->
    <div class="card card-custom p-4 border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamanList as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $item->buku->judul ?? 'Judul Buku Tidak Ditemukan' }}</td>
                            <td>{{ $item->tanggal_pinjam ?? $item->created_at->format('Y-m-d') }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>
                                @if($item->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui / Dipinjam</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($item->status == 'dikembalikan')
                                    <span class="badge bg-secondary">Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Kamu belum memiliki riwayat peminjaman buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection