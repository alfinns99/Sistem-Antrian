@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Status Info di Bagian Atas --}}
            <div class="card shadow-premium border-0 rounded-4 mb-4">
                <div class="card-body py-3 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 bg-white">
                    <div class="d-flex align-items-center">
                        <span class="pulse-status pulse-success me-2"></span>
                        <span class="text-secondary small fw-medium">
                            Status Operasional &bull; Loket: <strong>{{ strtoupper($loketSaya->nama_loket) }}</strong> ({{ strtoupper($loketSaya->status) }})
                        </span>
                    </div>
                    <div class="text-muted small fw-semibold">
                        <i class="far fa-calendar-alt me-1"></i> Terakhir Update: {{ now()->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            {{-- Flash Alert Messages --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-premium-sm rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-3 fs-5 text-success"></i>
                <div class="fw-semibold text-success-emphasis">{{ session('success') }}</div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-premium-sm rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-3 fs-5 text-danger"></i>
                <div class="fw-semibold text-danger-emphasis">{{ session('error') }}</div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row g-4 mb-4">
                {{-- Kiri: Antrian Saat Ini --}}
                <div class="col-md-5">
                    <div class="card shadow-premium border-0 h-100 overflow-hidden card-hover">
                        <div class="card-header bg-light text-center py-3 border-bottom border-light">
                            <h6 class="mb-0 fw-extrabold text-secondary" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">ANTRIAN MEJA SAYA</h6>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center py-5">
                            @if ($antrianSaatIni)
                                <span class="text-muted small fw-bold mb-1" style="font-size: 0.75rem;">SEDANG DILAYANI</span>
                                <div class="display-1 fw-extrabold text-primary mb-3" style="font-family: 'Outfit', sans-serif; letter-spacing: -2px;">{{ $antrianSaatIni->nomor_antrian }}</div>
                                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill fw-bold mb-4" style="font-size: 0.8rem;"><i class="fas fa-spinner fa-spin me-1"></i> AKTIF</span>
                                
                                <div class="d-grid gap-2 w-100 px-4">
                                    <form action="{{ route('antrians.recall', $antrianSaatIni->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning w-100 rounded-pill py-2.5 shadow-premium-sm fw-bold scale-hover border-0 text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                            <i class="fas fa-bullhorn me-2"></i> PANGGIL ULANG
                                        </button>
                                    </form>
                                    <form action="{{ route('antrians.finish', $antrianSaatIni->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2.5 shadow-premium-sm fw-bold scale-hover border-0 text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                            <i class="fas fa-check-circle me-2"></i> SELESAIKAN
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center py-4 px-3">
                                    <i class="fas fa-user-clock fa-4x text-light mb-4" style="color: #cbd5e1 !important;"></i>
                                    <h4 class="text-dark fw-extrabold mb-1" style="font-family: 'Outfit', sans-serif;">SIAP MELAYANI</h4>
                                    <p class="text-muted small px-3">Ketuk tombol "PANGGIL BERIKUTNYA" untuk mulai memanggil antrian pertama.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kanan: Aksi & Sisa Antrian --}}
                <div class="col-md-7">
                    <style>
                        @keyframes pulseBtn {
                            0% {
                                transform: translate(-50%, -50%) scale(0.95);
                                opacity: 0.15;
                            }
                            50% {
                                transform: translate(-50%, -50%) scale(1.18);
                                opacity: 0.32;
                            }
                            100% {
                                transform: translate(-50%, -50%) scale(0.95);
                                opacity: 0.15;
                            }
                        }
                        .pulse-btn-bg {
                            animation: pulseBtn 3s infinite ease-in-out;
                        }
                        .scale-hover-btn {
                            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
                        }
                        .scale-hover-btn:hover:not(:disabled) {
                            transform: translateY(-3px) scale(1.04);
                            box-shadow: 0 15px 35px -5px rgba(61, 120, 247, 0.6), 0 10px 24px -6px rgba(79, 70, 229, 0.45) !important;
                        }
                        .scale-hover-btn:active:not(:disabled) {
                            transform: translateY(1px) scale(0.98);
                            box-shadow: 0 8px 20px -6px rgba(61, 120, 247, 0.4) !important;
                        }
                    </style>

                    <div class="card shadow-premium border-0 h-100 p-4 p-md-5 d-flex flex-column justify-content-between align-items-center card-hover text-center" style="background: radial-gradient(120% 120% at 50% 10%, #ffffff 40%, rgba(61, 120, 247, 0.04) 100%);">
                        
                        <div class="w-100">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 mb-2 fw-semibold" style="font-size: 0.75rem;">KONTROL UTAMA</span>
                            <h4 class="fw-extrabold mb-4 text-dark" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">Panggil Antrian FIFO</h4>
                        </div>
                        
                        {{-- Zona Panggilan Premium --}}
                        <div class="d-flex flex-column align-items-center justify-content-center my-3 w-100">
                            <form action="{{ route('antrians.call_next') }}" method="POST" class="w-100 text-center">
                                @csrf
                                
                                @if(!$antrianSaatIni)
                                    {{-- Tombol AKTIF (Siap panggil) --}}
                                    <div class="position-relative d-inline-block call-button-wrapper mb-2">
                                        {{-- Efek Pendaran di Belakang --}}
                                        <div class="position-absolute start-50 top-50 translate-middle rounded-circle bg-primary opacity-20 pulse-btn-bg" style="width: 140%; height: 140%; filter: blur(25px); pointer-events: none; z-index: 1;"></div>
                                        
                                        <button type="submit" 
                                            class="btn btn-lg rounded-pill px-5 py-3.5 fw-bold scale-hover-btn border-0 text-white position-relative" 
                                            style="font-size: 1.2rem; background: linear-gradient(135deg, #3d78f7 0%, #4f46e5 100%); box-shadow: 0 12px 30px -5px rgba(61, 120, 247, 0.5), 0 8px 20px -6px rgba(79, 70, 229, 0.4); z-index: 2; letter-spacing: 0.5px;">
                                            <i class="fas fa-play-circle me-2 fs-5 align-middle"></i>
                                            <span class="align-middle">PANGGIL BERIKUTNYA</span>
                                        </button>
                                    </div>
                                @else
                                    {{-- Tombol NONAKTIF (Ada antrian berjalan) --}}
                                    <div class="position-relative d-inline-block mb-2">
                                        <button type="button" 
                                            class="btn btn-lg rounded-pill px-5 py-3.5 fw-bold border-0 cursor-not-allowed text-muted" 
                                            style="font-size: 1.2rem; background: #e2e8f0; color: #94a3b8 !important; letter-spacing: 0.5px; opacity: 0.7; pointer-events: none;"
                                            disabled>
                                            <i class="fas fa-pause-circle me-2 fs-5 align-middle"></i>
                                            <span class="align-middle">PANGGIL BERIKUTNYA</span>
                                        </button>
                                    </div>
                                    <div class="badge bg-danger-subtle text-danger px-3 py-2 rounded-4 fw-bold d-inline-flex align-items-center gap-1.5 mt-2 shadow-premium-sm" style="font-size: 0.75rem;">
                                        <i class="fas fa-exclamation-circle text-danger"></i>
                                        <span>Selesaikan antrian aktif terlebih dahulu</span>
                                    </div>
                                @endif
                            </form>
                        </div>
                        
                        {{-- Info Sisa Antrian --}}
                        <div class="w-100 border-top border-light pt-4 mt-3">
                            <span class="text-muted small fw-bold d-block mb-2" style="font-size: 0.725rem; letter-spacing: 0.5px;">SISA ANTRIAN MENUNGGU</span>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fw-bold small"><i class="fas fa-users"></i> Antrian</span>
                                <div id="count-waiting-petugas" class="display-5 fw-extrabold text-dark" style="font-family: 'Outfit', sans-serif; letter-spacing: -1px;">{{ count($antrianMenunggu) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const socket = io();

    socket.on('antrian.baru', (data) => {
        $('#count-waiting-petugas').text(data.total_menunggu);
    });

    socket.on('antrian.dipanggil', (data) => {
        setTimeout(fetchWaitingCount, 500);
    });

    socket.on('antrian.reset', () => {
        window.location.reload();
    });

    function fetchWaitingCount() {
        $.get("{{ route('api.antrian.monitor_data') }}", function(res) {
            $('#count-waiting-petugas').text(res.antrians_menunggu.length);
        });
    }
</script>
@endsection
