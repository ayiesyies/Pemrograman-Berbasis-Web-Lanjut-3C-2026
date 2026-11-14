<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin (Password di-hash)
        $admin = User::firstOrCreate(
            ['email' => 'admin@perpustakaan.com'],
            ['name' => 'Admin Utama', 'password' => Hash::make('password250441100041')]
        );
        $admin->assignRole('admin');

        // Akun Petugas
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@perpustakaan.com'],
            ['name' => 'Petugas Perpustakaan', 'password' => Hash::make('password123')]
        );
        $petugas->assignRole('petugas');

        // Akun Siswa
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@perpustakaan.com'],
            ['name' => 'Siswa Perpustakaan', 'password' => Hash::make('password123')]
        );
        $siswa->assignRole('siswa');
    }
}