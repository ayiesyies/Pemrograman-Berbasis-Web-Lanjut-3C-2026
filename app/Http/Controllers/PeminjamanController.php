<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman (Admin & Petugas)
     */
    public function index()
    {
        if (auth()->user()->hasRole('siswa')) {
            return $this->riwayat();
        }

        try {
            $peminjamanList = Peminjaman::with(['user', 'buku'])->latest()->get();
            // Ambil data user ber-role siswa dan daftar buku untuk dropdown form
            $users = User::role('siswa')->get();
            $bukuList = Buku::all();
        } catch (\Exception $e) {
            $peminjamanList = collect([]);
            $users = collect([]);
            $bukuList = collect([]);
        }

        return view('peminjaman.index', compact('peminjamanList', 'users', 'bukuList'));
    }

    /**
     * Menyimpan transaksi peminjaman baru dari Admin/Petugas
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'buku_id'        => 'required',
            'tanggal_pinjam' => 'required|date',
            'status'         => 'required|in:menunggu,disetujui,dipinjam',
        ]);

        // Cek pengajuan ganda aktif
        $existing = Peminjaman::where('user_id', $request->user_id)
            ->where('buku_id', $request->buku_id)
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Siswa tersebut sedang meminjam atau mengajukan buku ini.');
        }

        Peminjaman::create([
            'user_id'        => $request->user_id,
            'buku_id'        => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status'         => $request->status,
        ]);

        return back()->with('success', 'Transaksi peminjaman baru berhasil ditambahkan!');
    }

    /**
     * Mengajukan peminjaman buku baru (Khusus Siswa Mandiri)
     */
    public function store($bukuId)
    {
        $existing = Peminjaman::where('user_id', auth()->id())
            ->where('buku_id', $bukuId)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah mengajukan atau sedang meminjam buku ini.');
        }

        Peminjaman::create([
            'user_id'        => auth()->id(),
            'buku_id'        => $bukuId,
            'tanggal_pinjam' => now()->toDateString(),
            'status'         => 'menunggu',
        ]);

        return redirect()->route('peminjaman.riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    /**
     * Memperbarui status peminjaman
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,dikembalikan'
        ]);

        $peminjaman = Peminjaman::find($id);
        if ($peminjaman) {
            $dataUpdate = ['status' => $request->status];

            if ($request->status === 'dikembalikan') {
                $dataUpdate['tanggal_kembali'] = now()->toDateString();
            }

            $peminjaman->update($dataUpdate);
        }

        return back()->with('success', "Status peminjaman berhasil diubah menjadi: " . ucfirst($request->status));
    }

    /**
     * Menampilkan riwayat peminjaman khusus Siswa
     */
    public function riwayat()
    {
        try {
            $peminjamanList = Peminjaman::with('buku')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        } catch (\Exception $e) {
            $peminjamanList = collect([]);
        }

        return view('peminjaman.riwayat', compact('peminjamanList'));
    }

    /**
     * Perbaikan A4 (IDOR): Validasi otorisasi kepemilikan transaksi peminjaman.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ((int) $peminjaman->user_id !== (int) auth()->id() && !auth()->user()->hasAnyRole(['admin', 'petugas'])) {
            abort(403, 'Akses ditolak! Anda tidak memiliki izin untuk melihat transaksi peminjaman ini.');
        }

        return view('peminjaman.show', compact('peminjaman'));
    }
}