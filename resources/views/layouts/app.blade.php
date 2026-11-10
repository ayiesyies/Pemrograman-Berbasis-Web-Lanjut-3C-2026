<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Perpustakaan Digital</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .btn-custom-blue {
            background-color: #009ce8;
            color: white;
            border: none;
        }
        .btn-custom-blue:hover {
            background-color: #0082c3;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Header Banner -->
    <div class="bg-primary text-white text-center py-4" style="background: linear-gradient(135deg, #0e4c68 0%, #0099e5 100%);">
        <h2 class="fw-bold m-0">Perpustakaan Digital</h2>
        <p class="small m-0 text-white-50">Tempat membaca dan menemukan berbagai buku</p>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <!-- <a class="nav-link {{ request()->is('/') ? 'active text-primary fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a> -->
                    </li>

                    {{-- Menu Daftar Buku (Disembunyikan untuk Admin) --}}
                    @unlessrole('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('buku*') ? 'active text-primary fw-bold' : '' }}" href="{{ route('buku.index') }}">Daftar Buku</a>
                        </li>
                    @endunlessrole

                    {{-- Menu Khusus Siswa --}}
                    @role('siswa')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('riwayat-peminjaman*') ? 'active text-primary fw-bold' : '' }}" href="{{ route('peminjaman.riwayat') }}">Riwayat Peminjaman</a>
                        </li>
                    @endrole

                    {{-- Menu Profil Saya (Dapat diakses oleh Admin, Petugas, dan Siswa) --}}
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile*') ? 'active text-primary fw-bold' : '' }}" href="{{ route('profile.edit') }}">Profil Saya</a>
                        </li>
                    @endauth

                    {{-- Menu Khusus Admin --}}
                    @role('admin')
                        <li class="nav-item">
                            <a class="nav-link text-danger {{ request()->is('admin/dashboard') ? 'fw-bold border-bottom border-danger' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                    @endrole

                    {{-- Menu Khusus Petugas --}}
                    @role('petugas')
                        <li class="nav-item">
                            <a class="nav-link text-info {{ request()->is('petugas/dashboard') ? 'fw-bold' : '' }}" href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
                        </li>
                    @endrole
                </ul>

                <!-- Informasi User & Button Logout -->
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <span class="badge bg-light text-dark border p-2">
                            {{ auth()->user()->name }} 
                            <span class="text-primary">({{ auth()->user()->getRoleNames()->first() ?? 'user' }})</span>
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

