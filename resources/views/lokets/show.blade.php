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
                            <i class="fas fa-eye fa-lg"></i>
                        </div>
                        <h3 class="fw-extrabold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">Detail Loket</h3>
                        <p class="text-muted small mb-0">Ubah konfigurasi detail loket pelayanan dan perbarui status operasional.</p>
                    </div>

                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fs-5 text-danger"></i>
                        <div class="fw-bold text-danger-emphasis">Ups! Mohon periksa kembali isian form Anda.</div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('lokets.update', $loket->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- BLOK 1: STATUS LOKET --}}
                        <div class="mb-5">
                            <span class="text-primary fw-extrabold mb-3 d-block small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">
                                <i class="fas fa-signal text-primary"></i> STATUS OPERASIONAL
                            </span>
                            
                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">STATUS LOKET SAAT INI</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-power-off"></i></span>
                                    <select name="status" id="status" class="form-select border-light @error('status') is-invalid @enderror" style="background-color: #f8fafc;" required>
                                        <option value="aktif" {{ (old('status', $loket->status) == 'aktif') ? 'selected' : '' }}>Aktif (Buka)</option>
                                        <option value="istirahat" {{ (old('status', $loket->status) == 'istirahat') ? 'selected' : '' }}>Istirahat</option>
                                        <option value="tutup" {{ (old('status', $loket->status) == 'tutup') ? 'selected' : '' }}>Tutup</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info border-0 rounded-4 p-3 d-flex align-items-center justify-content-between" style="background-color: rgba(6, 182, 212, 0.08);">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-3 text-info fs-5"></i>
                                    <span class="text-info-emphasis fw-bold" style="font-size: 0.85rem;">Antrian Terakhir Dilayani:</span>
                                </div>
                                <span class="badge bg-info text-white rounded-pill px-3 py-2 fw-extrabold" style="font-size: 0.85rem; font-family: 'Outfit', sans-serif;">{{ $loket->nomor_antrian_saat_ini ?: '--' }}</span>
                            </div>
                        </div>
                        
                        {{-- BLOK 2: DETAIL LOKET --}}
                        <div class="border-top border-light pt-4 mb-4">
                            <span class="text-primary fw-extrabold mb-3 d-block small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">
                                <i class="fas fa-tag text-primary"></i> DETAIL LOKET
                            </span>

                            <div class="mb-4">
                                <label for="nama_loket" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">NAMA LOKET / MEJA LAYANAN</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-bullhorn"></i></span>
                                    <input 
                                        type="text" 
                                        name="nama_loket" 
                                        value="{{ old('nama_loket', $loket->nama_loket) }}" 
                                        class="form-control border-light @error('nama_loket') is-invalid @enderror" 
                                        style="background-color: #f8fafc;"
                                        placeholder="Nama Loket" 
                                        required
                                    >
                                </div>
                                @error('nama_loket')
                                    <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-5">
                                <label for="deskripsi" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">DESKRIPSI FUNGSI LOKET</label>
                                <textarea 
                                    class="form-control border-light @error('deskripsi') is-invalid @enderror" 
                                    name="deskripsi" 
                                    rows="4" 
                                    style="background-color: #f8fafc;"
                                    placeholder="Deskripsi"
                                >{{ old('deskripsi', $loket->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="text-danger mt-2 small fw-semibold"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                                <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN LOKET
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection