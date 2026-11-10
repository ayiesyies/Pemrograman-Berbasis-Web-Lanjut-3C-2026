<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'akses dashboard admin',             
            'akses dashboard petugas',           
            'lihat daftar buku',                 
            'kelola data buku',                  
            'kelola data pengguna',              
            'kelola role pengguna',              
            'kelola peminjaman',                 
            'kelola pengembalian',               
            'mengajukan peminjaman buku',        
            'memproses persetujuan peminjaman',  
            'mencatat pengembalian buku',        
            'melihat status peminjaman sendiri', 
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',        
            'lihat profil sendiri',              
            'ubah profil sendiri',              
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Role
        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $petugas = Role::firstOrCreate(['name' => 'petugas']);
        $siswa   = Role::firstOrCreate(['name' => 'siswa']);

       
        $admin->syncPermissions([
            'akses dashboard admin',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // Penetapan Permission untuk Petugas (13 Permission)
        $petugas->syncPermissions([
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'mengajukan peminjaman buku',
            'memproses persetujuan peminjaman',
            'mencatat pengembalian buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // Penetapan Permission untuk Siswa (6 Permission)
        $siswa->syncPermissions([
            'lihat daftar buku',
            'mengajukan peminjaman buku',
            'melihat status peminjaman sendiri',
            'melihat riwayat peminjaman sendiri',
            'lihat profil sendiri',
            'ubah profil sendiri',
        ]);

        // Pembuatan Akun Default untuk Testing Login
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@perpustakaan.com'],
            ['name' => 'Administrator', 'password' => Hash::make('password123')]
        );
        $userAdmin->syncRoles([$admin]);

        $userPetugas = User::firstOrCreate(
            ['email' => 'petugas@perpustakaan.com'],
            ['name' => 'Petugas Perpustakaan', 'password' => Hash::make('password123')]
        );
        $userPetugas->syncRoles([$petugas]);

        $userSiswa = User::firstOrCreate(
            ['email' => 'siswa@perpustakaan.com'],
            ['name' => 'Siswa Perpustakaan', 'password' => Hash::make('password123')]
        );
        $userSiswa->syncRoles([$siswa]);
    }
}