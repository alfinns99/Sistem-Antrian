@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            {{-- Breadcrumb/Back button --}}
            <div class="mb-4">
                <a class="btn btn-light rounded-pill px-3 shadow-premium-sm border border-light text-secondary scale-hover fw-bold" href="{{ route('lokets.index') }}">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-premium border-0 overflow-hidden card-hover">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5 border-bottom border-light pb-4">
                        <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-plus-circle fa-lg"></i>
                        </div>
                        <h3 class="fw-extrabold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">Tambah Loket Baru</h3>
                        <p class="text-muted small mb-0">Daftarkan loket meja pelayanan baru untuk membagi beban antrian kunjungan.</p>
                    </div>

                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fs-5 text-danger"></i>
                        <div class="fw-bold text-danger-emphasis">Ups! Mohon periksa kembali isian form Anda.</div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('lokets.store') }}" method="POST">
                        @csrf
                        
                        {{-- Nama Loket --}}
                        <div class="mb-4">
                            <label for="nama_loket" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">NAMA LOKET / MEJA LAYANAN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-bullhorn"></i></span>
                                <input 
                                    type="text" 
                                    name="nama_loket" 
                                    class="form-control border-light @error('nama_loket') is-invalid @enderror" 
                                    placeholder="Contoh: Loket A, Loket Pembayaran" 
                                    value="{{ old('nama_loket') }}"
                                    style="background-color: #f8fafc;"
                                    required
                                >
                            </div>
                            @error('nama_loket')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Deskripsi --}}
                        <div class="mb-5">
                            <label for="deskripsi" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">DESKRIPSI FUNGSI LOKET</label>
                            <textarea 
                                class="form-control border-light @error('deskripsi') is-invalid @enderror" 
                                name="deskripsi" 
                                rows="4" 
                                placeholder="Jelaskan jenis pelayanan loket ini (contoh: Untuk melayani administrasi berkas umum)"
                                style="background-color: #f8fafc;"
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                                <i class="fas fa-save me-2"></i> SIMPAN LOKET BARU
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection