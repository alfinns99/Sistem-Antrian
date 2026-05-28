@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            {{-- Header --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-5">
                <div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1.5 mb-2 fw-semibold" style="font-size: 0.8rem;">MANAJEMEN</span>
                    <h2 class="mb-0 fw-extrabold" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
                        <i class="fas fa-list-alt me-2 text-primary"></i>Kelola Loket
                    </h2>
                </div>
                <a class="btn btn-primary rounded-pill px-4 py-2.5 shadow-premium-sm fw-bold scale-hover d-flex align-items-center gap-2 border-0" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);" href="{{ route('lokets.create') }}">
                    <i class="fas fa-plus text-white"></i> Tambah Loket Baru
                </a>
            </div>

            {{-- Notifikasi Sukses --}}
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-premium-sm rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-3 fs-5 text-success"></i>
                <div class="fw-semibold text-success-emphasis">{{ $message }}</div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Card Table --}}
            <div class="card shadow-premium border-0 overflow-hidden card-hover">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="bg-light border-bottom border-light">
                                <tr>
                                    <th scope="col" class="py-3 px-4 text-secondary fw-extrabold small" style="width: 8%; font-family: 'Outfit', sans-serif;">NO</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="width: 25%; font-family: 'Outfit', sans-serif;">NAMA LOKET</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="width: 20%; font-family: 'Outfit', sans-serif;">STATUS</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="font-family: 'Outfit', sans-serif;">DESKRIPSI</th>
                                    <th scope="col" class="py-3 text-center text-secondary fw-extrabold small" style="width: 18%; font-family: 'Outfit', sans-serif;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @forelse ($lokets as $loket)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3.5 px-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                                    <td class="py-3.5 fw-bold text-primary">{{ $loket->nama_loket }}</td>
                                    
                                    {{-- TAMPILAN STATUS LOKET --}}
                                    <td class="py-3.5">
                                        @if ($loket->status === 'aktif')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">
                                                <i class="fas fa-check me-1"></i> Aktif
                                            </span>
                                        @elseif ($loket->status === 'istirahat')
                                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">
                                                <i class="fas fa-coffee me-1"></i> Istirahat
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">
                                                <i class="fas fa-times me-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-3.5 text-muted" style="max-width: 300px;">
                                        <div class="text-truncate small">{{ $loket->deskripsi ?: '-' }}</div>
                                    </td>
                                    <td class="py-3.5 text-center">
                                        <form action="{{ route('lokets.destroy', $loket->id) }}" method="POST" class="d-flex justify-content-center gap-2">
                                            {{-- Tombol Edit --}}
                                            <a class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center scale-hover shadow-premium-sm border border-light" style="width: 34px; height: 34px; background: white;" href="{{ route('lokets.edit', $loket->id) }}" data-bs-toggle="tooltip" title="Edit/Ubah Status">
                                                <i class="fas fa-edit text-warning" style="font-size: 0.85rem;"></i>
                                            </a>
                                            
                                            @csrf
                                            @method('DELETE')
                                            {{-- Tombol Hapus --}}
                                            <button type="submit" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center scale-hover shadow-premium-sm border border-light" style="width: 34px; height: 34px; background: white;" onclick="return confirm('Apakah Anda yakin ingin menghapus loket {{ $loket->nama_loket }}?')" data-bs-toggle="tooltip" title="Hapus Loket">
                                                <i class="fas fa-trash-alt text-danger" style="font-size: 0.85rem;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-30"></i>
                                        <p class="mb-0 text-muted fw-bold">Tidak ada loket terdaftar saat ini.</p>
                                        <p class="text-muted small">Silakan tambahkan loket baru untuk memulai layanan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection