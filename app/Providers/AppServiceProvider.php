<?php

namespace App\Providers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Policies\PeminjamanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Menggunakan hasAnyRole() sesuai package Spatie Laravel-Permission
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasAnyRole(['admin', 'petugas']);
        });

        // Mendaftarkan PeminjamanPolicy
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);
    }
}





