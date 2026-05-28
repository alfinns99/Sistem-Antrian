@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            {{-- Header Area --}}
            <div class="mb-2">
                <p class="text-muted mx-auto fs-5 mb-0" style="max-width: 500px;">Silakan klik tombol di bawah untuk mengambil nomor antrian Anda.</p>
            </div>

            {{-- Simulasi Kertas Tiket Virtual (Tampil Saat Sukses) --}}
            <div id="print-success-wrapper" class="row justify-content-center mb-3" style="display: none;">
                <div class="col-md-6">
                    <div class="ticket-virtual shadow-premium-lg p-4 mx-auto border border-light scale-hover" style="max-width: 320px; transition: all 0.3s ease;">
                        <div class="text-center">
                            <i class="fas fa-check-circle text-success fa-2x mb-3 animate-bounce"></i>
                            <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1.5px;">Nomor Anda</h6>
                            <h2 class="display-3 fw-extrabold text-primary mb-0" id="print-nomor" style="font-family: 'Outfit', sans-serif; letter-spacing: -1px;">---</h2>
                            
                            <div class="ticket-dashed-line"></div>
                            
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">ANTRIAN DIAMBIL</h5>
                            <p class="text-muted small mb-0">Sedang mencetak tiket...</p>
                            <p class="text-secondary small mt-1" style="font-size: 0.75rem;"><i class="fas fa-print me-1"></i> Mohon tunggu beberapa saat.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Form Kios Card --}}
            <div id="kiosk-main-card" class="row justify-content-center mt-3 mb-5">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-premium border-0 overflow-hidden card-hover">
                        <div class="card-body p-4 text-center">
                            <form id="form-ambil-antrian">
                                @csrf
                                <button type="submit" id="btn-ambil" class="btn kiosk-btn w-100 py-4 shadow-lg scale-hover d-flex align-items-center justify-content-center mx-auto" style="border-radius: 1.25rem; border: 0;">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <i class="fas fa-ticket-alt fa-2x text-white"></i>
                                        <span class="h4 fw-extrabold mb-0 text-white" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">AMBIL TIKET ANTRIAN</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                        
                        {{-- Stats Bar inside Kios Card --}}
                        <div class="card-footer bg-white py-4 border-top border-light">
                            <div class="row g-0">
                                <div class="col-6 border-end border-light">
                                    <span class="text-muted small d-block mb-1 fw-semibold"><i class="fas fa-users me-1 text-primary"></i> Menunggu</span>
                                    <div id="count-menunggu" class="display-6 fw-extrabold text-primary mb-0" style="font-family: 'Outfit', sans-serif;">{{ $antrians->where('status', 'menunggu')->count() }}</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small d-block mb-1 fw-semibold"><i class="fas fa-user-check me-1 text-success"></i> Dilayani</span>
                                    <div id="current-serving" class="display-6 fw-extrabold text-success mb-0" style="font-family: 'Outfit', sans-serif;">{{ $antrianSaatIni->nomor_antrian ?? '--' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Navigation Action links --}}
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="{{ route('monitor.index') }}" class="btn btn-light shadow-premium-sm text-secondary rounded-pill px-4 py-2 fw-semibold scale-hover" target="_blank" style="font-size: 0.85rem;">
                    <i class="fas fa-desktop me-2 text-primary"></i> Layar Monitor
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Iframe Tersembunyi untuk Cetak --}}
<iframe id="print-frame" style="display:none;"></iframe>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const socket = io("http://localhost:3000");

    socket.on('antrian.baru', (data) => {
        $('#count-menunggu').text(data.total_menunggu);
    });

    socket.on('antrian.dipanggil', (data) => {
        $('#current-serving').text(data.antrian.nomor_antrian);
        setTimeout(fetchStats, 500); 
    });

    socket.on('antrian.reset', () => { window.location.reload(); });

    function fetchStats() {
        $.get("{{ route('api.antrian.monitor_data') }}", function(res) {
            $('#count-menunggu').text(res.antrians_menunggu.length);
        });
    }

    $('#form-ambil-antrian').on('submit', function(e) {
        e.preventDefault();
        const $btn = $('#btn-ambil');
        $btn.prop('disabled', true).addClass('opacity-50');

        $.ajax({
            url: "{{ route('antrians.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    $('#print-nomor').text(res.antrian.nomor_antrian);
                    
                    // Sembunyikan card utama & tampilkan tiket virtual dengan animasi
                    $('#kiosk-main-card').stop(true, true).fadeOut(200, function() {
                        $('#print-success-wrapper').stop(true, true).fadeIn(300);
                    });
                    
                    const printUrl = "{{ url('/antrians') }}/" + res.antrian.id + "/print";
                    $('#print-frame').attr('src', printUrl);
                    
                    setTimeout(() => {
                        $('#print-success-wrapper').stop(true, true).fadeOut(200, function() {
                            $('#kiosk-main-card').stop(true, true).fadeIn(300);
                            $btn.prop('disabled', false).removeClass('opacity-50');
                        });
                    }, 3000);
                }
            },
            error: function() {
                alert('Gagal mengambil antrian. Silakan coba lagi.');
                $btn.prop('disabled', false).removeClass('opacity-50');
            }
        });
    });
</script>
@endsection