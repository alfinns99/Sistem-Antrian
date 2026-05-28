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
                        <i class="fas fa-users-cog me-2 text-primary"></i>Kelola Pengguna
                    </h2>
                </div>
                <a class="btn btn-primary rounded-pill px-4 py-2.5 shadow-premium-sm fw-bold scale-hover d-flex align-items-center gap-2 border-0" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);" href="{{ route('users.create') }}">
                    <i class="fas fa-user-plus text-white"></i> Tambah Pengguna Baru
                </a>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-premium-sm rounded-4 border-0 p-3 mb-4 d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-3 fs-5 text-success"></i>
                    <div class="fw-semibold text-success-emphasis">{{ session('success') }}</div>
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
                                    <th scope="col" class="py-3 px-4 text-secondary fw-extrabold small" style="width: 8%; font-family: 'Outfit', sans-serif;">ID</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="width: 25%; font-family: 'Outfit', sans-serif;">NAMA</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="width: 30%; font-family: 'Outfit', sans-serif;">USERNAME</th>
                                    <th scope="col" class="py-3 text-secondary fw-extrabold small" style="width: 15%; font-family: 'Outfit', sans-serif;">PERAN</th>
                                    <th scope="col" class="py-3 text-center text-secondary fw-extrabold small" style="width: 22%; font-family: 'Outfit', sans-serif;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @forelse ($users as $user)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3.5 px-4 fw-bold text-secondary">{{ $user->id }}</td>
                                    <td class="py-3.5 fw-bold text-dark">{{ $user->name }}</td>
                                    <td class="py-3.5 text-muted">{{ $user->username }}</td>
                                    <td class="py-3.5">
                                        @if ($user->role === 'admin')
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">{{ ucfirst($user->role) }}</span>
                                        @elseif ($user->role === 'petugas')
                                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">{{ ucfirst($user->role) }}</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1.5 fw-bold" style="font-size: 0.725rem;">{{ ucfirst($user->role) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center scale-hover shadow-premium-sm border border-light" style="width: 34px; height: 34px; background: white;" data-bs-toggle="tooltip" title="Edit Pengguna">
                                                <i class="fas fa-edit text-warning" style="font-size: 0.85rem;"></i>
                                            </a>
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center scale-hover shadow-premium-sm border border-light" style="width: 34px; height: 34px; background: white;" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?');" data-bs-toggle="tooltip" title="Hapus Pengguna">
                                                    <i class="fas fa-trash-alt text-danger" style="font-size: 0.85rem;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-user-slash fa-3x text-muted mb-3 opacity-30"></i>
                                        <p class="mb-0 text-muted fw-bold">Tidak ada data pengguna terdaftar.</p>
                                        <p class="text-muted small">Silakan tambahkan pengguna baru melalui tombol di atas.</p>
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