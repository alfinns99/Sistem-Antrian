@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-premium border-0 overflow-hidden card-hover">
                <div class="card-body p-4 p-md-5 bg-white">
                    <div class="text-center mb-5 border-bottom border-light pb-4">
                        <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-user-plus fa-lg"></i>
                        </div>
                        <h3 class="fw-extrabold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">Daftar Akun Baru</h3>
                        <p class="text-muted small mb-0">Buat akun pengelola untuk dapat mengakses sistem antrian online.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name Input --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">NAMA LENGKAP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control border-light @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" style="background-color: #f8fafc;" placeholder="Nama Lengkap" required autocomplete="name" autofocus>
                            </div>
                            @error('name')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username Input --}}
                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-id-card"></i></span>
                                <input id="username" type="text" class="form-control border-light @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" style="background-color: #f8fafc;" placeholder="Masukkan username" required autocomplete="username">
                            </div>
                            @error('username')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Input --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control border-light @error('password') is-invalid @enderror" name="password" style="background-color: #f8fafc;" placeholder="Masukkan password" required autocomplete="new-password">
                            </div>
                            @error('password')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password Input --}}
                        <div class="mb-5">
                            <label for="password-confirm" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">KONFIRMASI PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control border-light" name="password_confirmation" style="background-color: #f8fafc;" placeholder="Ulangi password" required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Tombol Register --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                                <i class="fas fa-user-plus me-2 text-white"></i> DAFTAR SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
