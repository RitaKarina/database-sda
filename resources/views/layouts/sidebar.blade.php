<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white" style="width: 260px; min-height: 100vh;">
    <!-- Logo / Judul Sistem -->
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="fas fa-water fa-2x me-2 text-primary"></i>
        <span class="fs-5 fw-bold">Sistem SDA</span>
    </a>
    <hr class="border-secondary">

    <!-- Menu Utama Navigasi -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a href="#" class="nav-link text-white active">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        <!-- Header Kelompok Data Master -->
        <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold px-2" style="font-size: 0.75rem;">Data Utama</li>
        
        <li class="nav-item mb-1">
            <a href="{{ route('paket-pekerjaan.index') }}" class="nav-link text-white opacity-75">
                <i class="fas fa-briefcase me-2"></i> Paket Pekerjaan
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('kelembagaan.index') }}" class="nav-link text-white opacity-75">
                <i class="fas fa-users me-2"></i> Kelembagaan
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('perencanaan.index') }}" class="nav-link text-white opacity-75">
                <i class="fas fa-calendar-alt me-2"></i> Perencanaan
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('realisasi.index') }}" class="nav-link text-white opacity-75">
                <i class="fas fa-chart-line me-2"></i> Realisasi
            </a>
        </li>

        <!-- Header Infrastruktur -->
        <li class="mt-3 mb-1 text-uppercase text-secondary fw-bold px-2" style="font-size: 0.75rem;">Infrastruktur</li>

        <li class="nav-item mb-1">
            <a href="{{ route('embung.index') }}" class="nav-link text-white opacity-75">
                <i class="fas fa-water me-2"></i> Embung / Tampungan
            </a>
        </li>
    </ul>

    <hr class="border-secondary">

    <!-- Info User / Profil -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle fa-2x me-2"></i>
            <strong>Administrator</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#">Keluar</a></li>
        </ul>
    </div>
</div>