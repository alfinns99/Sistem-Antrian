@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            {{-- Breadcrumb/Back button --}}
            <div class="mb-4">
                <a class="btn btn-light rounded-pill px-3 shadow-premium-sm border border-light text-secondary scale-hover fw-bold" href="{{ route('users.index') }}">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-premium border-0 overflow-hidden card-hover">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5 border-bottom border-light pb-4">
                        <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-user-plus fa-lg"></i>
                        </div>
                        <h3 class="fw-extrabold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">Tambah Pengguna Baru</h3>
                        <p class="text-muted small mb-0">Masukkan informasi kredensial untuk mendaftarkan staf operator loket atau administrator baru.</p>
                    </div>

                    {{-- Menampilkan Ringkasan Error Validasi --}}
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fs-5 text-danger"></i>
                        <div class="fw-bold text-danger-emphasis">Ups! Mohon periksa kembali isian form Anda.</div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        {{-- Nama Pengguna --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">NAMA LENGKAP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user"></i></span>
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control border-light @error('name') is-invalid @enderror" 
                                    placeholder="Nama Lengkap" 
                                    value="{{ old('name') }}" 
                                    style="background-color: #f8fafc;"
                                    required
                                >
                            </div>
                            @error('name')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user-tag"></i></span>
                                <input 
                                    type="text" 
                                    name="username" 
                                    class="form-control border-light @error('username') is-invalid @enderror" 
                                    placeholder="Masukkan username" 
                                    value="{{ old('username') }}" 
                                    style="background-color: #f8fafc;"
                                    required
                                >
                            </div>
                            @error('username')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="form-control border-light @error('password') is-invalid @enderror" 
                                    placeholder="Masukkan password" 
                                    style="background-color: #f8fafc;"
                                    required
                                >
                            </div>
                            @error('password')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">KONFIRMASI PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-lock"></i></span>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    class="form-control border-light" 
                                    placeholder="Ulangi password" 
                                    style="background-color: #f8fafc;"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Peran (Role) --}}
                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">PERAN HAK AKSES</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-user-tag"></i></span>
                                <select 
                                    name="role" 
                                    id="role-select"
                                    class="form-select border-light @error('role') is-invalid @enderror" 
                                    style="background-color: #f8fafc;"
                                    required
                                >
                                    <option value="pengguna" {{ old('role') == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            @error('role')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pilihan Loket (Hanya muncul jika Petugas) --}}
                        <div id="loket-wrapper" class="mb-5" style="{{ old('role') == 'petugas' ? '' : 'display:none;' }}">
                            <label for="loket_id" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">LOKET TUGAS OPERATOR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-door-open"></i></span>
                                <select 
                                    name="loket_id" 
                                    class="form-select border-light @error('loket_id') is-invalid @enderror" 
                                    style="background-color: #f8fafc;"
                                >
                                    <option value="">-- Tanpa Loket --</option>
                                    @foreach($lokets as $loket)
                                        <option value="{{ $loket->id }}" {{ old('loket_id') == $loket->id ? 'selected' : '' }}>
                                            {{ $loket->nama_loket }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('loket_id')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <script>
                            document.getElementById('role-select').addEventListener('change', function() {
                                const loketWrapper = document.getElementById('loket-wrapper');
                                if (this.value === 'petugas') {
                                    loketWrapper.style.display = 'block';
                                } else {
                                    loketWrapper.style.display = 'none';
                                }
                            });
                        </script>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                                <i class="fas fa-save me-2"></i> SIMPAN PENGGUNA BARU
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection