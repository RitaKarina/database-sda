<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ntb.png') }}">
    <title>@yield('title', 'SI SDA') - Sistem Informasi SDA</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { min-height: 100vh; background-color: #f8f9fa; }
        .sidebar { width: 260px; min-height: 100vh; background-color: #212529; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.75); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: #0d6efd; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3 text-white">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <x-logo size="48" class="me-2 flex-shrink-0" shadow />
            <span class="fs-6 fw-bold text-uppercase">DATABASE SUMBER DAYA AIR</span>
        </a>
        <hr class="border-secondary">

        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard', '/') ? 'active' : '' }}">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>
            </li>

            <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold px-2" style="font-size: 0.75rem;">Infrastruktur SDA</li>
            <li class="nav-item mb-1">
                <a href="{{ route('daerah-irigasi.index') }}" class="nav-link {{ request()->is('daerah-irigasi*') ? 'active' : '' }}">
                    <i class="fas fa-water me-2"></i> Daerah Irigasi
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('embung.index') }}" class="nav-link {{ request()->is('embung*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-water me-2"></i> Embung & Tampungan Air
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('bendungan.index') }}" class="nav-link {{ request()->is('bendungan*') ? 'active' : '' }}">
                    <i class="fas fa-archway me-2"></i> Data Bendungan
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('sungai.index') }}" class="nav-link {{ request()->is('sungai*') ? 'active' : '' }}">
                    <i class="fas fa-stream me-2"></i> Data Sungai / DAS
                </a>
            </li>

            <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold px-2" style="font-size: 0.75rem;">Manajemen & Kegiatan</li>
            <li class="nav-item mb-1">
                <a href="{{ route('paket-pekerjaan.index') }}" class="nav-link {{ request()->is('paket-pekerjaan*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase me-2"></i> Paket Pekerjaan
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('kelembagaan.index') }}" class="nav-link {{ request()->is('kelembagaan*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Organisasi Personalia
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('perencanaan.index') }}" class="nav-link {{ request()->is('perencanaan*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list me-2"></i> Data Perencanaan
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('realisasi.index') }}" class="nav-link {{ request()->is('realisasi*') ? 'active' : '' }}">
                    <i class="fas fa-coins me-2"></i> Realisasi Fisik & Keuangan
                </a>
            </li>
        </ul>
        @auth
            <div class="mt-auto pt-3">
                <hr class="border-secondary">
                <div class="small text-white-50 mb-2">Masuk sebagai</div>
                <div class="fw-semibold mb-3">{{ auth()->user()->name }}</div>
                <a href="{{ route('public.home') }}" class="btn btn-outline-light btn-sm w-100 mb-2">
                    <i class="fas fa-globe me-1"></i> Halaman Publik
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm w-100">
                        <i class="fas fa-arrow-right-from-bracket me-1"></i> Keluar
                    </button>
                </form>
            </div>
        @endauth
    </div>

    <!-- Main Content Area -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>