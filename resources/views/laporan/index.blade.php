@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            {{-- Header --}}
            <div class="mb-5">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 mb-2 fw-semibold" style="font-size: 0.8rem;">LAPORAN</span>
                <h2 class="mb-0 fw-extrabold" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Kinerja & Analisis Antrian
                </h2>
            </div>
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-premium-sm rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-3 fs-5 text-danger"></i>
                    <div class="fw-semibold text-danger-emphasis">{{ session('error') }}</div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- 1. FORM FILTER (Premium White Card) -->
            <div class="card shadow-premium border-0 mb-4 card-hover">
                <div class="card-header bg-white border-bottom border-light p-4">
                    <h5 class="mb-0 text-dark fw-bold" style="font-family: 'Outfit', sans-serif;"><i class="fas fa-filter me-2 text-primary"></i>Filter Laporan</h5>
                </div>
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('laporan.index') }}">
                        <div class="row g-3 align-items-end">
                            {{-- Filter Tanggal Mulai --}}
                            <div class="col-md-3 col-sm-6">
                                <label for="tanggal_mulai" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">TANGGAL MULAI</label>
                                <input 
                                    type="date" 
                                    class="form-control border-light" 
                                    id="tanggal_mulai" 
                                    name="tanggal_mulai" 
                                    style="background-color: #f8fafc;"
                                    value="{{ $tanggalMulai ?? \Carbon\Carbon::now()->subDays(6)->toDateString() }}" 
                                    required
                                >
                            </div>
                            {{-- Filter Tanggal Akhir --}}
                            <div class="col-md-3 col-sm-6">
                                <label for="tanggal_akhir" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">TANGGAL AKHIR</label>
                                <input 
                                    type="date" 
                                    class="form-control border-light" 
                                    id="tanggal_akhir" 
                                    name="tanggal_akhir" 
                                    style="background-color: #f8fafc;"
                                    value="{{ $tanggalAkhir ?? \Carbon\Carbon::now()->toDateString() }}" 
                                    required
                                >
                            </div>
                            {{-- Filter Loket --}}
                            <div class="col-md-4 col-sm-6">
                                <label for="loket_id" class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">PILIH LOKET</label>
                                <select class="form-select border-light" id="loket_id" name="loket_id" style="background-color: #f8fafc;">
                                    <option value="">Semua Loket</option>
                                    @foreach($lokets as $loket)
                                        <option value="{{ $loket->id }}" {{ $loketId == $loket->id ? 'selected' : '' }}>
                                            {{ $loket->nama_loket }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Tombol Submit --}}
                            <div class="col-md-2 col-sm-6">
                                <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                                    <i class="fas fa-search me-1 text-white"></i> Terapkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 2. REKAPITULASI HARIAN -->
            <div class="card shadow-premium border-0 mb-4 card-hover">
                <div class="card-body p-0">
                    <div class="p-4 p-md-5 border-bottom border-light bg-white">
                        <h4 class="card-title text-dark fw-extrabold mb-0 d-flex align-items-center" style="font-family: 'Outfit', sans-serif;">
                            <i class="fas fa-table me-3 text-primary"></i>Rekapitulasi Kunjungan Harian
                        </h4>
                    </div>
                    
                    @if(count($laporanHarian) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="bg-light border-bottom border-light">
                                <tr>
                                    <th scope="col" class="py-3 px-5 text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">TANGGAL</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">LOKET LAYANAN</th>
                                    <th scope="col" class="py-3 text-center text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">TOTAL ANTRIAN</th>
                                    <th scope="col" class="py-3 text-center text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">ANTRIAN SELESAI</th>
                                    <th scope="col" class="py-3 text-center text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">RASIO SELESAI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanHarian as $laporan)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3.5 px-5 fw-bold text-dark">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}</td>
                                    <td class="py-3.5 text-secondary fw-semibold">{{ $laporan->nama_loket }}</td>
                                    <td class="py-3.5 text-center text-primary fw-extrabold" style="font-family: 'Outfit', sans-serif; font-size: 1.05rem;">{{ $laporan->total_antrian }}</td>
                                    <td class="py-3.5 text-center text-success fw-extrabold" style="font-family: 'Outfit', sans-serif; font-size: 1.05rem;">{{ $laporan->total_selesai }}</td>
                                    <td class="py-3.5 text-center">
                                        @php
                                            $persentase = ($laporan->total_antrian > 0) ? round(($laporan->total_selesai / $laporan->total_antrian) * 100, 1) : 0;
                                        @endphp
                                        @if ($persentase >= 80)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">
                                                {{ $persentase }}% (Sangat Baik)
                                            </span>
                                        @elseif ($persentase >= 50)
                                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">
                                                {{ $persentase }}% (Cukup)
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">
                                                {{ $persentase }}% (Rendah)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 bg-transparent">
                        <i class="fas fa-search-minus fa-3x text-muted mb-3 opacity-30"></i>
                        <p class="text-muted fw-bold mb-0">Tidak ada data rekapitulasi untuk filter ini.</p>
                        <p class="text-muted small">Coba ubah rentang tanggal pencarian atau filter loket.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 3. KINERJA WAKTU LAYANAN (Service Time) -->
            <div class="card shadow-premium border-0 card-hover">
                <div class="card-body p-0">
                    <div class="p-4 p-md-5 border-bottom border-light bg-white">
                        <h4 class="card-title text-dark fw-extrabold mb-0 d-flex align-items-center" style="font-family: 'Outfit', sans-serif;">
                            <i class="fas fa-clock me-3 text-primary"></i>Kinerja Waktu Pelayanan Rata-Rata
                        </h4>
                    </div>
                    
                    @if(count($laporanKinerja) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="bg-light border-bottom border-light">
                                <tr>
                                    <th scope="col" class="py-3 px-5 text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">NAMA LOKET TUGAS</th>
                                    <th scope="col" class="py-3 text-center text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">RATA-RATA WAKTU RESPONS DAN LAYANAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanKinerja as $kinerja)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3.5 px-5 fw-bold text-dark">{{ $kinerja->nama_loket }}</td>
                                    <td class="py-3.5 text-center fs-5 text-primary fw-extrabold" style="font-family: 'Outfit', sans-serif;">{{ $kinerja->rata_rata_waktu }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 bg-transparent">
                        <i class="fas fa-hourglass-empty fa-3x text-muted mb-3 opacity-30"></i>
                        <p class="text-muted fw-bold mb-0">Belum ada data kinerja waktu layanan yang dapat dihitung.</p>
                        <p class="text-muted small">Pastikan ada antrian berstatus "selesai" dalam rentang filter di atas.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection