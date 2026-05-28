@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="card shadow-premium border-0 overflow-hidden card-hover">
                <div class="card-body p-4 bg-white">
                    <div class="text-center mb-4 border-bottom border-light pb-3">
                        <h3 class="fw-extrabold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">Login Pengelola</h3>
                        <p class="text-muted small mb-0">Silakan masukkan username dan password untuk masuk ke panel operator atau administratif.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Username Input --}}
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; font-size: 0.725rem;">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted" style="padding: 0.5rem 0.75rem;"><i class="fas fa-user" style="font-size: 0.85rem;"></i></span>
                                <input id="username" type="text" class="form-control border-light @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" style="background-color: #f8fafc; padding: 0.5rem 0.75rem;" placeholder="Masukkan username" required autocomplete="username" autofocus>
                            </div>
                            @error('username')
                                <div class="text-danger mt-1.5 small fw-semibold" style="font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Input --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; font-size: 0.725rem;">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted" style="padding: 0.5rem 0.75rem;"><i class="fas fa-lock" style="font-size: 0.85rem;"></i></span>
                                <input id="password" type="password" class="form-control border-light @error('password') is-invalid @enderror" name="password" style="background-color: #f8fafc; padding: 0.5rem 0.75rem;" placeholder="Masukkan password" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <div class="text-danger mt-1.5 small fw-semibold" style="font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember Me & Forgot Password --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted fw-semibold" for="remember" style="font-size: 0.75rem;">
                                        {{ __('Ingat Saya') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                @if (Route::has('password.request'))
                                    <a class="text-primary fw-bold text-decoration-none" href="{{ route('password.request') }}" style="font-size: 0.75rem;">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol Login --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2.5 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #3d78f7 0%, #60a5fa 100%); color: #ffffff !important; font-size: 0.9rem;">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection