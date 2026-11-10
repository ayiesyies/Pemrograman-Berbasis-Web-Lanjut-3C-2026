<x-guest-layout>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card card-custom p-4">
                
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark m-0">Daftar Akun Baru</h4>
                    <p class="text-muted small m-0 mt-1">Pendaftaran Anggota Siswa</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama Anda">
                        @error('name')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="nama@contoh.com">
                        @error('email')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-secondary">Kata Sandi</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-custom-blue w-100 py-2 fw-semibold">
                        Daftar
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <p class="small text-muted m-0">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">Masuk</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>