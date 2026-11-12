<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    /**
     * Menentukan apakah pengguna dapat melihat detail data peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas diperbolehkan melihat semua transaksi peminjaman
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya diperbolehkan melihat peminjaman miliknya sendiri
        return (int) $user->id === (int) $peminjaman->user_id;
    }
}