<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Antrian') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Vite / Bootstrap JS & CSS --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar-light .navbar-nav .nav-link {
            color: #475569;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .navbar-light .navbar-nav .nav-link:hover, 
        .navbar-light .navbar-nav .show > .nav-link {
            color: #4f46e5 !important;
            background: rgba(79, 70, 229, 0.05);
        }
        
        .dropdown-menu {
            padding: 0.5rem;
            border: 0;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.02);
            border-radius: 0.75rem;
        }
        
        .dropdown-item {
            font-weight: 500;
            color: #334155;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: rgba(79, 70, 229, 0.05);
            color: #4f46e5;
        }
        
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
        
        .footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div id="app" class="d-flex flex-column min-h-screen">
        
        {{-- BLOK NAVIGASI DINAMIS GLASSMORPHISM (Tampilan Premium Terang) --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <nav class="navbar navbar-expand-lg navbar-light glass-panel sticky-top py-3 shadow-premium-sm mb-2">
            <div class="container px-4">
                <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('antrians.index') }}">
                    <i class="fas fa-ticket-alt me-2 text-primary fs-3"></i>
                    <span class="fs-4 text-gradient">SISTEM ANTRIAN</span>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    
                    {{-- Tautan Kiri (Publik) --}}
                    <ul class="navbar-nav me-auto">
                    </ul>

                    {{-- Tautan Kanan (Otentikasi & Manajemen) --}}
                    <ul class="navbar-nav ms-auto gap-1">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-2 text-primary"></i> {{ __('Login') }}
                                </a>
                            </li>
                        @else
                            {{-- TAUTAN ADMIN --}}
                            @if (Auth::user()->role === 'admin')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center fw-bold text-primary" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-shield me-2"></i> Admin Panel
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-users-cog me-2 text-primary"></i> Kelola Pengguna</a></li>
                                        <li><a class="dropdown-item" href="{{ route('lokets.index') }}"><i class="fas fa-cogs me-2 text-primary"></i> Kelola Loket</a></li>
                                        <li><hr class="dropdown-divider bg-light"></li>
                                        <li><a class="dropdown-item" href="{{ route('laporan.index') }}"><i class="fas fa-chart-line me-2 text-primary"></i> Laporan Kinerja</a></li>
                                    </ul>
                                </li>
                            @endif

                            {{-- TAUTAN PETUGAS --}}
                            @if (Auth::user()->role === 'petugas')
                                <li class="nav-item me-lg-2">
                                    <a class="nav-link d-flex align-items-center fw-bold text-primary" href="{{ route('loket.monitor') }}">
                                        <i class="fas fa-headset me-2"></i> Layanan Petugas
                                    </a>
                                </li>
                            @endif

                            {{-- LOGOUT untuk semua pengguna terautentikasi --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-2 text-secondary fs-5"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-home me-2 text-secondary"></i> Home Dashboard</a></li>
                                    <li><hr class="dropdown-divider bg-light"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endif
        {{-- AKHIR BLOK NAVIGASI DINAMIS --}}

        <main class="py-4 flex-grow-1">
            @yield('content')
        </main>

        <footer class="footer py-4 mt-auto">
            <div class="container text-center">
                <span class="text-muted" style="font-size: 0.85rem; font-weight: 500;">
                    <strong>SISTEM ANTRIAN</strong> v1.0.0 &bull; Aplikasi dibuat sepenuh ❤️ oleh <strong>AlfinNS</strong>
                </span>
            </div>
        </footer>
    </div>
</body>
</html>