@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 mb-2 fw-semibold" style="font-size: 0.8rem;">ADMINISTRASI</span>
                    <h2 class="mb-0 fw-extrabold" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Dashboard Ringkasan
                    </h2>
                </div>
            </div>

            {{-- BLOK STATISTIK UTAMA (Tampilan Premium Terang) --}}
            <div class="row g-4 mb-5">
                {{-- Card Total Antrian --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-premium border-0 border-start border-primary border-4 h-100 card-hover">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <div class="rounded-3 bg-primary-subtle p-3 text-primary d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold d-block">TOTAL HARI INI</span>
                                <span class="h2 fw-extrabold mb-0 d-block text-dark" style="font-family: 'Outfit', sans-serif;">{{ $totalAntrianHariIni }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Menunggu --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-premium border-0 border-start border-warning border-4 h-100 card-hover">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <div class="rounded-3 bg-warning-subtle p-3 text-warning d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold d-block">MENUNGGU</span>
                                <span class="h2 fw-extrabold mb-0 d-block text-dark" style="font-family: 'Outfit', sans-serif;">{{ $antrianMenunggu }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Dilayani --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-premium border-0 border-start border-success border-4 h-100 card-hover">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <div class="rounded-3 bg-success-subtle p-3 text-success d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="fas fa-headset fa-2x"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold d-block">DILAYANI</span>
                                <span class="h2 fw-extrabold mb-0 d-block text-dark" style="font-family: 'Outfit', sans-serif;">{{ $antrianDipanggil }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Loket Aktif --}}
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-premium border-0 border-start border-info border-4 h-100 card-hover">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <div class="rounded-3 bg-info-subtle p-3 text-info d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                <i class="fas fa-door-open fa-2x"></i>
                            </div>
                            <div>
                                <span class="text-muted small fw-bold d-block">LOKET AKTIF</span>
                                <span class="h2 fw-extrabold mb-0 d-block text-dark" style="font-family: 'Outfit', sans-serif;">{{ $loketAktif }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Konten Bawah --}}
            <div class="row g-4">
                {{-- BLOK ANTRIAN TERBARU --}}
                <div class="col-lg-6">
                    <div class="card shadow-premium border-0 h-100 card-hover">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="card-title text-dark fw-extrabold mb-4 d-flex align-items-center border-bottom border-light pb-3" style="font-family: 'Outfit', sans-serif;">
                                <i class="fas fa-list-ol me-3 text-primary"></i>5 Antrian Terdepan
                            </h4>
                            <div class="list-group list-group-flush" id="waiting-list-admin">
                                @forelse ($antrianTerbaru as $antrian)
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-light px-0 bg-transparent">
                                        <div>
                                            <h5 class="mb-1 fw-extrabold text-primary" style="font-family: 'Outfit', sans-serif;">{{ $antrian->nomor_antrian }}</h5>
                                            <p class="mb-0 text-muted small"><i class="far fa-clock me-1"></i>Diambil pada: {{ $antrian->created_at->format('H:i:s') }}</p>
                                        </div>
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.7rem;">Menunggu</span>
                                    </div>
                                @empty
                                    <div class="text-center py-5 text-muted small fw-semibold">Tidak ada antrian yang sedang menunggu.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BLOK AKSI CEPAT --}}
                <div class="col-lg-6">
                    <div class="card shadow-premium border-0 h-100 card-hover">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="card-title text-dark fw-extrabold mb-4 d-flex align-items-center border-bottom border-light pb-3" style="font-family: 'Outfit', sans-serif;">
                                <i class="fas fa-bolt me-3 text-primary"></i>Aksi Pengelolaan
                            </h4>
                            <p class="text-muted small mb-4">Navigasi pintas untuk mengelola loket meja layanan, otorisasi staf, serta mencetak laporan.</p>
                            
                            <div class="d-grid gap-3">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <a href="{{ route('lokets.index') }}" class="btn btn-outline-primary w-100 py-3 rounded-4 fw-bold scale-hover d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-cogs"></i> Kelola Loket
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary w-100 py-3 rounded-4 fw-bold scale-hover d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-users-cog"></i> Kelola Pengguna
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-primary w-100 py-3 rounded-4 fw-bold scale-hover d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-chart-line"></i> Laporan Kinerja
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{ route('settings.index') }}" class="btn btn-outline-primary w-100 py-3 rounded-4 fw-bold scale-hover d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-print"></i> Pengaturan Karcis
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="border-top border-light my-3 pt-3">
                                    <form action="{{ route('antrians.reset') }}" method="POST" onsubmit="return confirm('PERINGATAN: Seluruh data antrian akan dihapus permanen! Anda yakin ingin mereset?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100 py-3 rounded-4 fw-bold scale-hover d-flex align-items-center justify-content-center gap-2 border-0 text-white" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                            <i class="fas fa-trash-alt"></i> Reset Seluruh Antrian Hari Ini
                                        </button>
                                    </form>
                                </div>
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
    const socket = io("http://localhost:3000");

    socket.on('antrian.baru', () => { refreshDashboard(); });
    socket.on('antrian.dipanggil', () => { refreshDashboard(); });
    socket.on('antrian.selesai', () => { refreshDashboard(); });

    function refreshDashboard() {
        $.get("{{ route('api.antrian.monitor_data') }}", function(res) {
            // Update Statistik
            $('.h2').eq(1).text(res.antrians_menunggu.length);
            
            // Update List Menunggu
            const $list = $('#waiting-list-admin');
            $list.empty();
            
            if (res.antrians_menunggu.length === 0) {
                $list.append('<div class="text-center py-5 text-muted small fw-semibold">Tidak ada antrian yang sedang menunggu.</div>');
            } else {
                res.antrians_menunggu.slice(0, 5).forEach(w => {
                    const time = w.created_at ? new Date(w.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit', second:'2-digit'}) : '--:--:--';
                    $list.append(`
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-light px-0 bg-transparent">
                            <div>
                                <h5 class="mb-1 fw-extrabold text-primary" style="font-family: 'Outfit', sans-serif;">${w.nomor_antrian}</h5>
                                <p class="mb-0 text-muted small"><i class="far fa-clock me-1"></i>Diambil pada: ${time}</p>
                            </div>
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.7rem;">Menunggu</span>
                        </div>
                    `);
                });
            }
        });
    }
</script>
@endsection