@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-premium border-0 overflow-hidden card-hover">
                <div class="card-header bg-light border-bottom border-light py-3 px-4">
                    <h5 class="mb-0 text-dark fw-bold" style="font-family: 'Outfit', sans-serif;"><i class="fas fa-print me-2 text-primary"></i>Pengaturan Kustomisasi Tiket</h5>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-premium-sm rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-3 fs-5 text-success"></i>
                        <div class="fw-semibold text-success-emphasis">{{ session('success') }}</div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">HEADER BARIS 1 (NAMA INSTANSI)</label>
                            <input type="text" name="ticket_header" class="form-control border-light" style="background-color: #f8fafc;" value="{{ $settings['ticket_header'] ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">HEADER BARIS 2 (ALAMAT / INFO TAMBAHAN)</label>
                            <input type="text" name="ticket_header_2" class="form-control border-light" style="background-color: #f8fafc;" value="{{ $settings['ticket_header_2'] ?? '' }}">
                            <div class="form-text mt-2 small text-muted"><i class="fas fa-info-circle me-1"></i> Muncul tepat di bawah Nama Instansi.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">FOOTER TIKET (PESAN PENUTUP)</label>
                            <input type="text" name="ticket_footer" class="form-control border-light" style="background-color: #f8fafc;" value="{{ $settings['ticket_footer'] ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;">CATATAN TAMBAHAN (OPSIONAL)</label>
                            <textarea name="ticket_note" class="form-control border-light" style="background-color: #f8fafc;" rows="3">{{ $settings['ticket_note'] ?? '' }}</textarea>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold scale-hover border-0 shadow-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
                                <i class="fas fa-save me-2"></i> SIMPAN PENGATURAN TIKET
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Live Ticket Preview Mockup --}}
            <div class="card mt-4 border-0 shadow-premium bg-light card-hover">
                <div class="card-body p-4 text-center">
                    <h6 class="text-secondary text-uppercase fw-extrabold mb-3 small" style="font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;"><i class="fas fa-eye me-1"></i> Live Preview (Simulasi Kertas Thermal)</h6>
                    
                    <div class="ticket-virtual mx-auto p-4 shadow-premium border border-light scale-hover text-center" style="width: 260px; line-height: 1.3; background: #ffffff;">
                        <div style="font-family: 'Inter', sans-serif;">
                            <div class="fw-extrabold text-dark" style="font-size: 15px; font-family: 'Outfit', sans-serif; letter-spacing: -0.2px;">{{ $settings['ticket_header'] ?? 'HEADER INSTANSI 1' }}</div>
                            <div class="text-muted" style="font-size: 10px;">{{ $settings['ticket_header_2'] ?? 'Info Alamat Tambahan' }}</div>
                            
                            <div class="ticket-dashed-line"></div>
                            
                            <div class="text-muted fw-bold" style="font-size: 8px; letter-spacing: 0.5px;">NOMOR ANTRIAN</div>
                            <div class="text-primary fw-extrabold" style="font-size: 38px; font-family: 'Outfit', sans-serif; line-height: 1; margin: 4px 0; letter-spacing: -1px;">001</div>
                            <div class="text-muted" style="font-size: 8px;">{{ date('d-m-Y') }} | {{ date('H:i:s') }}</div>
                            
                            <div class="ticket-dashed-line"></div>
                            
                            <div class="fw-bold text-dark" style="font-size: 11px; font-family: 'Outfit', sans-serif;">{{ $settings['ticket_footer'] ?? 'Terima Kasih Atas Kunjungan Anda' }}</div>
                            @if(!empty($settings['ticket_note']))
                                <div class="text-secondary mt-1 small" style="font-size: 9px;">{{ $settings['ticket_note'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
