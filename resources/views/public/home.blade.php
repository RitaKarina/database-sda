@extends('layouts.public')

@section('title', 'Informasi Publik Sumber Daya Air')

@section('navigation')
    <a class="d-none d-md-inline" href="#explore">Jelajahi</a>
@endsection

@section('content')
    <section class="hero py-5 py-lg-6">
        <div class="container hero-content py-lg-4">
            <div class="row align-items-center gy-4">
                <div class="col-lg-8">
                    <div class="eyebrow mb-3">Dinas PUPR Provinsi Nusa Tenggara Barat</div>
                    <h1 class="fw-black mb-3 text-uppercase">SUMBER DAYA AIR</h1>
                    <p class="lead mb-4">
                        Portal informasi publik untuk memantau data sumber daya air, daerah irigasi, embung,
                        dan infrastruktur air strategis di wilayah Provinsi Nusa Tenggara Barat.
                    </p>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="#explore" class="btn btn-hero rounded-pill px-4 py-2 fw-semibold">
                            Jelajahi Data <i class="fa-solid fa-arrow-down ms-2" aria-hidden="true"></i>
                        </a>
                        <span class="hero-chip">
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                            Data publik terverifikasi
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-center">
                    <div class="hero-visual" aria-hidden="true">
                        <div class="water-orb">
                            <i class="fa-solid fa-water"></i>
                        </div>
                        <div class="hero-bubble"></div>
                        <div class="hero-bubble"></div>
                        <div class="hero-bubble"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="explore" class="container py-5">
        <div class="section-head text-center">
            <div class="section-kicker mb-2">Navigasi data</div>
            <h2 class="h2 fw-bold mb-2">Jelajahi Informasi Sumber Daya Air</h2>
            <p class="text-secondary mb-0">
                Ringkasan data publik utama yang tersedia untuk masyarakat dan pengelola informasi infrastruktur air.
            </p>
        </div>

        <div class="bubble-dashboard" aria-label="Menu informasi publik">
            <div class="bubble-menu-view">
                <div class="bubble-stage">
                    <button type="button" class="bubble-item bubble-item--left" data-target="irigasi" aria-label="Daerah Irigasi">
                        <span class="bubble-item__icon"><i class="fa-solid fa-water" aria-hidden="true"></i></span>
                        <span class="bubble-item__name">Daerah Irigasi</span>
                        <span class="bubble-item__value">{{ number_format($totalDaerahIrigasi, 0, ',', '.') }}</span>
                    </button>

                    <button type="button" class="bubble-item bubble-item--main" data-target="main" aria-label="Menu utama sumber daya air">
                        <span class="bubble-item__badge">PUPR</span>
                        <span class="bubble-item__name bubble-item__name--main">Sumber Daya Air</span>
                    </button>

                    <button type="button" class="bubble-item bubble-item--right bubble-item--alt" data-target="embung" aria-label="Embung">
                        <span class="bubble-item__icon"><i class="fa-solid fa-droplet" aria-hidden="true"></i></span>
                        <span class="bubble-item__name">Embung</span>
                        <span class="bubble-item__value">{{ number_format($totalEmbung, 0, ',', '.') }}</span>
                    </button>

                    <button type="button" class="bubble-item bubble-item--lower-left bubble-item--alt" data-target="peta" aria-label="Peta Irigasi">
                        <span class="bubble-item__icon"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i></span>
                        <span class="bubble-item__name">Peta Irigasi</span>
                        <span class="bubble-item__value">Aktif</span>
                    </button>

                    <button type="button" class="bubble-item bubble-item--lower-center" data-target="teknis" aria-label="Data Teknis">
                        <span class="bubble-item__icon"><i class="fa-solid fa-file-lines" aria-hidden="true"></i></span>
                        <span class="bubble-item__name">Data Teknis</span>
                        <span class="bubble-item__value">Tersedia</span>
                    </button>

                    <button type="button" class="bubble-item bubble-item--lower-right bubble-item--alt" data-target="lainnya" aria-label="Informasi Lainnya">
                        <span class="bubble-item__icon"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></span>
                        <span class="bubble-item__name">Informasi Lainnya</span>
                        <span class="bubble-item__value">Publik</span>
                    </button>
                </div>
            </div>

            <div class="bubble-detail-view" aria-live="polite">
                <button type="button" class="bubble-close" aria-label="Kembali ke menu utama">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>

                <div class="bubble-detail-panel is-active" data-panel="irigasi">
                    <div class="detail-header">
                        <span class="section-kicker">Infrastruktur irigasi</span>
                        <h3 class="h3 fw-bold mb-0">Daerah Irigasi</h3>
                    </div>

                    @if ($daerahIrigasi->isEmpty())
                        <div class="empty-state p-4">
                            <div>
                                <i class="fa-regular fa-folder-open fa-2x mb-3" aria-hidden="true"></i>
                                <h3 class="h5">Data Daerah Irigasi belum tersedia</h3>
                                <p class="text-secondary mb-0">Informasi akan ditampilkan setelah tersedia di dalam basis data.</p>
                            </div>
                        </div>
                    @else
                        <div class="detail-table-wrap">
                            <table class="table table-modern align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama DI</th>
                                        <th scope="col">Kabupaten/Kota</th>
                                        <th scope="col">Kecamatan</th>
                                        <th scope="col" class="text-end">Luas fungsional</th>
                                        <th scope="col">Kewenangan</th>
                                        <th scope="col">Status fungsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daerahIrigasi as $di)
                                        <tr>
                                            <th scope="row" class="fw-semibold">{{ $di->nama_di }}</th>
                                            <td>{{ is_array($di->kabupaten) ? implode(', ', $di->kabupaten) : ($di->kabupaten ?: 'Belum tersedia') }}</td>
                                            <td>{{ is_array($di->kecamatan) ? implode(', ', $di->kecamatan) : ($di->kecamatan ?: 'Belum tersedia') }}</td>
                                            <td class="text-end">{{ $di->luas_fungsional !== null ? number_format((float) $di->luas_fungsional, 2, ',', '.') . ' ha' : 'Belum tersedia' }}</td>
                                            <td>{{ $di->kewenangan ?: 'Belum tersedia' }}</td>
                                            <td>
                                                @if ($di->status_fungsi)
                                                    <span class="badge rounded-pill text-bg-success-subtle text-success-emphasis px-3 py-2">{{ $di->status_fungsi }}</span>
                                                @else
                                                    <span class="text-secondary">Belum tersedia</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">{{ $daerahIrigasi->appends(['public_panel' => 'irigasi'])->links('pagination::bootstrap-5') }}</div>
                        @endif
                </div>

                <div class="bubble-detail-panel" data-panel="embung">
                    <div class="detail-header">
                        <span class="section-kicker">Tampungan air</span>
                        <h3 class="h3 fw-bold mb-0">Embung</h3>
                    </div>

                    @if ($embung->isEmpty())
                        <div class="empty-state p-4">
                            <div>
                                <i class="fa-regular fa-folder-open fa-2x mb-3" aria-hidden="true"></i>
                                <h3 class="h5">Data embung belum tersedia</h3>
                                <p class="text-secondary mb-0">Informasi akan ditampilkan setelah tersedia di dalam basis data.</p>
                            </div>
                        </div>
                    @else
                        <div class="detail-card-grid">
                            @foreach ($embung as $item)
                                <article class="detail-card p-4">
                                    <div class="d-flex justify-content-between gap-3 mb-3">
                                        <h4 class="h5 fw-bold mb-0">{{ $item->nama_embung }}</h4>
                                        @if ($item->status_fungsi)
                                            <span class="badge rounded-pill text-bg-success-subtle text-success-emphasis align-self-start">{{ $item->status_fungsi }}</span>
                                        @endif
                                    </div>
                                    <p class="small text-secondary mb-3">
                                        <i class="fa-solid fa-location-dot me-1" aria-hidden="true"></i>
                                        {{ collect([$item->desa, $item->kecamatan, $item->kabupaten])->filter()->implode(', ') ?: 'Lokasi belum tersedia' }}
                                    </p>
                                    <div class="row g-2 small">
                                        <div class="col-6">
                                            <div class="data-label">Volume tampungan</div>
                                            <div class="data-value">{{ $item->volume_tampungan !== null ? number_format((float) $item->volume_tampungan, 2, ',', '.') . ' m³' : 'Belum tersedia' }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="data-label">Luas genangan</div>
                                            <div class="data-value">{{ $item->luas_genangan !== null ? number_format((float) $item->luas_genangan, 2, ',', '.') . ' ha' : 'Belum tersedia' }}</div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="mt-3">{{ $embung->appends(['public_panel' => 'embung'])->links('pagination::bootstrap-5') }}</div>
                    @endif
                </div>

                <div class="bubble-detail-panel" data-panel="peta">
                    <div class="detail-header">
                        <span class="section-kicker">Peta irigasi</span>
                        <h3 class="h3 fw-bold mb-0">Peta Irigasi</h3>
                    </div>
                    <div class="detail-info-card">
                        <p class="text-secondary mb-3">
                            Informasi spasial terkait jaringan irigasi yang diperbolehkan untuk publik tersedia sebagai bagian dari
                            data yang diakses melalui sistem ini.
                        </p>
                        <div class="d-flex align-items-center gap-2 text-success fw-semibold">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <span>Data publik sesuai izin akses</span>
                        </div>
                    </div>
                </div>

                <div class="bubble-detail-panel" data-panel="teknis">
                    <div class="detail-header">
                        <span class="section-kicker">Data teknis</span>
                        <h3 class="h3 fw-bold mb-0">Informasi Data Teknis</h3>
                    </div>
                    <div class="detail-info-card">
                        <p class="text-secondary mb-0">
                            Data teknis yang tersedia untuk publik disajikan secara ringkas, konsisten, dan mudah dipahami pada setiap bagian informasi utama.
                        </p>
                    </div>
                </div>

                <div class="bubble-detail-panel" data-panel="lainnya">
                    <div class="detail-header">
                        <span class="section-kicker">Informasi lainnya</span>
                        <h3 class="h3 fw-bold mb-0">Informasi Lainnya</h3>
                    </div>
                    <div class="detail-info-card">
                        <p class="text-secondary mb-0">
                            Informasi pendukung yang relevan dan diizinkan untuk umum disajikan dalam bentuk ringkasan dan detail yang tetap terhubung dengan data sumber daya air yang akurat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dashboard = document.querySelector('.bubble-dashboard');
            const bubbleItems = document.querySelectorAll('.bubble-item');
            const detailPanels = document.querySelectorAll('.bubble-detail-panel');
            const closeButton = document.querySelector('.bubble-close');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let transitionTimer;

            function setActivePanel(target, animate) {
                if (!dashboard || !target) return;

                window.clearTimeout(transitionTimer);
                bubbleItems.forEach(function (item) {
                    const active = item.dataset.target === target;
                    item.classList.toggle('is-selected', active);
                    item.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                function showPanel() {
                    dashboard.classList.remove('is-opening');
                    dashboard.classList.add('is-detail-active');
                    detailPanels.forEach(function (panel) {
                        panel.classList.toggle('is-active', panel.dataset.panel === target);
                    });
                }

                const headerOffset = document.querySelector('.public-header')?.offsetHeight || 0;
                dashboard.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
                window.scrollBy({ top: -(headerOffset + 12), left: 0, behavior: reduceMotion ? 'auto' : 'smooth' });

                if (animate && !reduceMotion) {
                    dashboard.classList.add('is-opening');
                    transitionTimer = window.setTimeout(showPanel, 260);
                    return;
                }

                showPanel();
            }

            function resetDashboard() {
                if (!dashboard) return;

                window.clearTimeout(transitionTimer);
                dashboard.classList.remove('is-opening');
                dashboard.classList.remove('is-detail-active');
                bubbleItems.forEach(function (item) {
                    item.classList.remove('is-selected');
                    item.setAttribute('aria-pressed', 'false');
                });
                detailPanels.forEach(function (panel) {
                    panel.classList.remove('is-active');
                });
            }

            bubbleItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    const target = item.dataset.target;
                    if (!target || target === 'main') {
                        resetDashboard();
                        return;
                    }

                    setActivePanel(target, true);
                });
            });

            if (closeButton) {
                closeButton.addEventListener('click', resetDashboard);
            }

            const requestedPanel = new URLSearchParams(window.location.search).get('public_panel');
            if (requestedPanel && Array.from(detailPanels).some(function (panel) {
                return panel.dataset.panel === requestedPanel;
            })) {
                setActivePanel(requestedPanel, false);
            }
        });
    </script>
@endpush
