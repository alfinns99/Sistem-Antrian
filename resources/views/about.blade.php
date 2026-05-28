@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Hero Section --}}
            <div class="card shadow-premium border-0 overflow-hidden mb-5 text-center position-relative p-5 text-white" 
                 style="background: linear-gradient(135deg, #3d78f7 0%, #4f46e5 100%); border-radius: 1.5rem;">
                
                {{-- Decorative circles --}}
                <div class="position-absolute rounded-circle" style="width: 250px; height: 250px; background: rgba(255, 255, 255, 0.05); top: -80px; left: -80px;"></div>
                <div class="position-absolute rounded-circle" style="width: 400px; height: 400px; background: rgba(255, 255, 255, 0.03); bottom: -150px; right: -150px;"></div>

                <div class="position-relative z-index-2 py-4">
                    <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1.5 mb-3 fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">SISTEM ANTRIAN DIGITAL</span>
                    <h1 class="display-4 fw-extrabold mb-3" style="font-family: 'Outfit', sans-serif; letter-spacing: -1.5px;">Antrian Pintar Terintegrasi</h1>
                    <p class="lead opacity-90 mx-auto mb-0" style="max-width: 650px; font-weight: 500;">
                        Solusi antrian multi-loket modern dengan sinkronisasi waktu nyata (*real-time socket sync*), sistem panggilan suara pintar, dan estetika visual *SaaS clean light-mode* yang mewah.
                    </p>
                </div>
            </div>

            {{-- Feature Grid --}}
            <h3 class="fw-extrabold mb-4 text-dark" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">Fitur Utama Sistem</h3>
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card shadow-premium border-0 h-100 p-4 card-hover bg-white text-center">
                        <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="fas fa-bolt fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-family: 'Outfit', sans-serif;">Real-Time Socket Sync</h5>
                        <p class="text-muted small mb-0">Sinkronisasi nomor antrian antar loket dan layar monitor publik secara instan tanpa perlu memuat ulang halaman browser.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-premium border-0 h-100 p-4 card-hover bg-white text-center">
                        <div class="rounded-circle bg-success-subtle text-success mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="fas fa-volume-up fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-family: 'Outfit', sans-serif;">Panggilan Suara Pintar</h5>
                        <p class="text-muted small mb-0">Sistem audio pemanggilan otomatis untuk menuntun pengunjung menuju nomor meja loket yang ditugaskan secara otomatis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-premium border-0 h-100 p-4 card-hover bg-white text-center">
                        <div class="rounded-circle bg-warning-subtle text-warning mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="fas fa-print fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark" style="font-family: 'Outfit', sans-serif;">Tiket Thermal Kustom</h5>
                        <p class="text-muted small mb-0">Halaman cetak tiket modular dengan layout kertas struk virtual yang realistis dan konfigurasi teks header/footer dinamis.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                {{-- Kiri: Tech Stack --}}
                <div class="col-md-6">
                    <div class="card shadow-premium border-0 h-100 p-4 p-md-5 bg-white card-hover">
                        <h4 class="fw-extrabold mb-4 text-dark" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;"><i class="fas fa-layer-group text-primary me-2"></i>Teknologi yang Digunakan</h4>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between border-light">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger-subtle text-danger rounded-pill p-2.5 me-3"><i class="fab fa-laravel fa-lg"></i></span>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Laravel Framework</h6>
                                        <small class="text-muted">Aplikasi Core & REST API</small>
                                    </div>
                                </div>
                                <span class="badge bg-light text-secondary rounded-pill border border-light px-3 py-1">v12.x</span>
                            </li>
                            <li class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between border-light">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success-subtle text-success rounded-pill p-2.5 me-3"><i class="fab fa-node-js fa-lg"></i></span>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Socket.io & Node.js</h6>
                                        <small class="text-muted">Layanan Server Real-Time</small>
                                    </div>
                                </div>
                                <span class="badge bg-light text-secondary rounded-pill border border-light px-3 py-1">Node v20+</span>
                            </li>
                            <li class="list-group-item px-0 py-3 d-flex align-items-center justify-content-between border-light">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill p-2.5 me-3"><i class="fab fa-bootstrap fa-lg"></i></span>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Bootstrap 5 & Vite</h6>
                                        <small class="text-muted">Tampilan Responsif & Bundler</small>
                                    </div>
                                </div>
                                <span class="badge bg-light text-secondary rounded-pill border border-light px-3 py-1">Premium UI</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Kanan: Detail Sistem --}}
                <div class="col-md-6">
                    <div class="card shadow-premium border-0 h-100 p-4 p-md-5 bg-white card-hover d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="fw-extrabold mb-3 text-dark" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;"><i class="fas fa-info-circle text-primary me-2"></i>Tentang Aplikasi</h4>
                            <p class="text-muted small">
                                Sistem Antrian Digital ini dirancang untuk menggantikan sistem pemanggilan antrian konvensional menjadi serba digital dan otomatis. Dengan model otorisasi pengguna multi-peran (Admin, Petugas Loket, dan Pengunjung Publik), aplikasi ini memisahkan operasional administratif, pelayanan loket, dan visualisasi monitor publik secara rapi.
                            </p>
                            <p class="text-muted small">
                                Ditunjang oleh visualisasi premium light-mode, fontase modern Outfit, bayangan lembut, dan efek interaktif, aplikasi ini memberikan pengalaman pengguna (UX) berkualitas tinggi setingkat aplikasi SaaS komersial.
                            </p>
                        </div>
                        
                        <div class="border-top border-light pt-3 mt-4 text-center">
                            <span class="text-secondary small fw-bold">SISTEM ANTRIAN &bull; Versi 1.0.0</span>
                            <p class="text-muted small mb-0">Dibuat dengan dedikasi penuh ❤️ oleh AlfinNS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
