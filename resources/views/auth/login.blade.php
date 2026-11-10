<x-guest-layout>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card card-custom p-4">
                
                <!-- Header Form -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-lock" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m0 5.996V14H3s-1 0-1-1 1-4 6-4c.564 0 1.077.078 1.557.22.22-.505.58-.94 1.04-1.272C8.947 7.34 8.486 7.3 8 7.3c-4.418 0-6 2.149-6 4.6V13a1 1 0 0 0 1 1h5.004C8.002 13.662 8 13.333 8 13m4-4.5a1.5 1.5 0 0 1 1.5 1.5v.5h.5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5h.5v-.5A1.5 1.5 0 0 1 12 8.5zm.5 2v-.5a.5.5 0 0 0-1 0v.5z"/>
                        </svg>
                    </div>
                    <h4 class="fw-bold text-dark m-0">Masuk Akun</h4>
                    <p class="text-muted small m-0 mt-1">Perpustakaan Digital</p>
                </div>

                <!-- Session Alert Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show small mb-3" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@contoh.com">
                        @error('email')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label small fw-semibold text-secondary m-0">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small text-primary" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                        <label class="form-check-label small text-muted" for="remember_me">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <button type="submit" class="btn btn-custom-blue w-100 py-2 fw-semibold">
                        Masuk
                    </button>
                </form>

                <!-- Link Register -->
                <div class="text-center mt-4 pt-3 border-top">
                    <p class="small text-muted m-0">
                        Belum memiliki akun? 
                        <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold">Daftar Sekarang</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>