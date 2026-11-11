@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold">Daftar Buku</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div id="alertBox" class="alert d-none" role="alert"></div>

    @can('kelola data buku')
    <div class="card card-custom mb-4">
        <div class="card-header bg-white fw-bold" id="formTitle">Tambah Buku Baru</div>
        <div class="card-body">
            <form id="bukuForm">
                <input type="hidden" id="bukuId">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label small fw-semibold">ID Kategori</label>
                        <input type="number" class="form-control" id="kategori_id" placeholder="Contoh: 1" required>
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="form-label small fw-semibold">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" required placeholder="Masukkan judul buku">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Penulis</label>
                        <input type="text" class="form-control" id="penulis" required placeholder="Nama penulis">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" required placeholder="Contoh: 2024">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan Buku</button>
                    <button type="button" class="btn btn-secondary d-none" id="btnBatal" onclick="resetForm()">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endcan

    <div class="card card-custom p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th width="240">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelBukuBody">
                    @forelse ($bukus as $index => $buku)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $buku->kategori->nama ?? $buku->kategori_id ?? '-' }}</td>
                            
                            {{-- PERBAIKAN A1: Menggunakan HTML Escaping bawaan Blade ({{ }}) --}}
                            <td class="fw-bold">{{ $buku->judul }}</td>
                            
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <button class="btn btn-sm btn-info text-white me-1" onclick="showDetail({{ $buku->id }})">Detail</button>

                                    {{-- TOMBOL PINJAM BUKU (Siswa) --}}
                                    @hasrole('siswa')
                                        <form action="{{ route('peminjaman.store', $buku->id) }}" method="POST" class="d-inline me-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">Pinjam</button>
                                        </form>
                                    @endhasrole

                                    @can('kelola data buku')
                                        <button class="btn btn-sm btn-warning me-1" onclick="editBuku({{ $buku->id }})">Ubah</button>
                                        
                                        {{-- PERBAIKAN A3: Menggunakan Form POST + @csrf + @method('DELETE') --}}
                                        <form action="/buku/{{ $buku->id }}/hapus" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="detailModalLabel">📖 Detail Buku</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless m-0">
                    <tr>
                        <th width="130" class="text-muted">Judul Buku</th>
                        <td>: <span id="detailJudul" class="fw-bold text-dark"></span></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Kategori</th>
                        <td>: <span id="detailKategori"></span></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Penulis</th>
                        <td>: <span id="detailPenulis"></span></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Tahun Terbit</th>
                        <td>: <span id="detailTahun"></span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
const API_URL = '/api/buku';
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

async function showDetail(id) {
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            headers: { 
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        if (!response.ok) throw new Error('Detail buku tidak dapat dimuat.');
        
        const resData = await response.json();
        const buku = resData.data || resData;

        const namaKategori = (typeof buku.kategori === 'object' && buku.kategori !== null) 
            ? (buku.kategori.nama || buku.kategori.nama_kategori || 'Kategori ' + buku.kategori_id)
            : (buku.kategori || buku.kategori_id || '-');

        document.getElementById('detailJudul').innerText = buku.judul;
        document.getElementById('detailKategori').innerText = namaKategori;
        document.getElementById('detailPenulis').innerText = buku.penulis;
        document.getElementById('detailTahun').innerText = buku.tahun_terbit;

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    } catch (error) {
        showAlert(error.message, 'danger');
    }
}

const bukuForm = document.getElementById('bukuForm');
if (bukuForm) {
    bukuForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const id = document.getElementById('bukuId').value;
        const isEdit = Boolean(id);
        const url = isEdit ? `${API_URL}/${id}` : API_URL;
        const method = isEdit ? 'PUT' : 'POST';

        const payload = {
            kategori_id: document.getElementById('kategori_id').value,
            judul: document.getElementById('judul').value,
            penulis: document.getElementById('penulis').value,
            tahun_terbit: document.getElementById('tahun_terbit').value
        };

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (!response.ok) {
                const errorMsg = result.errors ? Object.values(result.errors).flat().join('<br>') : (result.message || 'Gagal menyimpan data');
                throw new Error(errorMsg);
            }

            showAlert(isEdit ? 'Buku berhasil diperbarui!' : 'Buku berhasil ditambahkan!', 'success');
            resetForm();
            location.reload();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    });
}

async function editBuku(id) {
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            headers: { 
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        if (!response.ok) throw new Error('Data buku tidak ditemukan.');
        
        const resData = await response.json();
        const buku = resData.data || resData;

        document.getElementById('bukuId').value = buku.id;
        document.getElementById('kategori_id').value = buku.kategori_id || '';
        document.getElementById('judul').value = buku.judul;
        document.getElementById('penulis').value = buku.penulis;
        document.getElementById('tahun_terbit').value = buku.tahun_terbit;

        document.getElementById('formTitle').innerText = 'Ubah Data Buku';
        document.getElementById('btnSubmit').innerText = 'Perbarui Buku';
        document.getElementById('btnBatal').classList.remove('d-none');
    } catch (error) {
        showAlert(error.message, 'danger');
    }
}

function resetForm() {
    if (bukuForm) bukuForm.reset();
    document.getElementById('bukuId').value = '';
    document.getElementById('formTitle').innerText = 'Tambah Buku Baru';
    document.getElementById('btnSubmit').innerText = 'Simpan Buku';
    document.getElementById('btnBatal').classList.add('d-none');
}

function showAlert(message, type) {
    const alertBox = document.getElementById('alertBox');
    if (!alertBox) return;
    alertBox.className = `alert alert-${type}`;
    alertBox.innerHTML = message;
    alertBox.classList.remove('d-none');
    setTimeout(() => alertBox.classList.add('d-none'), 4000);
}
</script>
@endsection