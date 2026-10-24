@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="fas fa-water text-primary me-2"></i> Detail Daerah Irigasi: {{ $di->nama_di }}
        </h5>
        <div>
            <a href="{{ route('daerah-irigasi.edit', $di->id) }}" class="btn btn-warning btn-sm me-1">
                <i class="fas fa-edit me-1"></i> Edit Data
            </a>
            <a href="{{ route('daerah-irigasi.print', $di->id) }}" target="_blank" class="btn btn-secondary btn-sm me-1">
                <i class="fas fa-print me-1"></i> Cetak PDF
            </a>
            <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <!-- Kartu Informasi Teknis & Administratif -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3 fw-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i> Informasi Teknis & Administratif
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%" class="text-muted">Kabupaten / Kota</td>
                            <td>: 
                                @if(is_array($di->kabupaten))
                                    {{ implode(', ', $di->kabupaten) }}
                                @elseif(is_object($di->kabupaten))
                                    {{ $di->kabupaten->nama_kabupaten ?? '-' }}
                                @else
                                    {{ $di->kabupaten ?? '-' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kecamatan</td>
                            <td>: 
                                @if(is_array($di->kecamatan))
                                    {{ implode(', ', $di->kecamatan) }}
                                @elseif(is_object($di->kecamatan))
                                    {{ $di->kecamatan->nama_kecamatan ?? '-' }}
                                @else
                                    {{ $di->kecamatan ?? '-' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kode DI</td>
                            <td>: {{ $di->kode_di ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Sumber Dana Penanganan</td>
                            <td>: {{ $di->sumber_dana_penanganan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kewenangan</td>
                            <td>: <span class="badge bg-info text-dark">{{ $di->kewenangan ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Sumber Air</td>
                            <td>: {{ $di->sumber_air ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Bendung</td>
                            <td>: {{ $di->bendung ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Pengamat Pengairan</td>
                            <td>: {{ $di->pengamat_pengairan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kartu Luas & Kinerja -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white pt-3 fw-bold text-success">
                    <i class="fas fa-chart-line me-2"></i> Luas Area & Indikator Kinerja
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%" class="text-muted">Luas Baku (Ha)</td>
                            <td>: {{ $di->luas_baku !== null ? number_format($di->luas_baku, 2) : '-' }} Ha</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Luas Potensial (Ha)</td>
                            <td>: {{ $di->luas_potensial !== null ? number_format($di->luas_potensial, 2) : '-' }} Ha</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Luas Fungsional (Ha)</td>
                            <td>: {{ $di->luas_fungsional !== null ? number_format($di->luas_fungsional, 2) : '-' }} Ha</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Luas Baku Permen 14 (Ha)</td>
                            <td>: {{ $di->luas_baku_permen_14 !== null ? number_format($di->luas_baku_permen_14, 2) : '-' }} Ha</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Luas Fungsional Irigasi Teknis (Ha)</td>
                            <td>: {{ $di->luas_fungsional_irigasi_teknis !== null ? number_format($di->luas_fungsional_irigasi_teknis, 2) : '-' }} Ha</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Luas Fungsional Irigasi Non Teknis (Ha)</td>
                            <td>: {{ $di->luas_fungsional_irigasi_non_teknis !== null ? number_format($di->luas_fungsional_irigasi_non_teknis, 2) : '-' }} Ha</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Indeks Pertanaman (IP)</td>
                            <td>: {{ $di->ip ?? '-' }}%</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nilai IKSI</td>
                            <td>: {{ $di->iksi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tahun Dok. Perencanaan</td>
                            <td>: {{ $di->tahun_dokumen_perencanaan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kelengkapan Data</td>
                            <td>: 
                                <span class="fw-bold">{{ $di->kelengkapan_data ?? 0 }}%</span>
                                <div class="progress mt-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $di->kelengkapan_data ?? 0 }}%;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-white pt-3 fw-bold text-primary">
            <i class="fas fa-users me-2"></i>Organisasi Personalia
        </div>
        <div class="card-body">
            @if ($di->kelembagaans->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Jenis Kelembagaan</th><th>Nama Kelembagaan</th><th>Ruas Kewenangan</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($di->kelembagaans as $institution)
                                <tr>
                                    <td>{{ $institution->jenis_kelembagaan ?: 'Belum diklasifikasikan' }}</td>
                                    <td>{{ $institution->nama_kelembagaan }}</td>
                                    <td>{{ $institution->ruas ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Belum ada data kelembagaan.</p>
            @endif
            @if ($di->skema_ruas_path)
                <div class="mt-3">
                    <strong>Skema Ruas Kewenangan IP3A, GP3A, P3A:</strong>
                    <a href="{{ Storage::url($di->skema_ruas_path) }}" target="_blank" rel="noopener">Lihat file</a>
                    <span class="text-muted mx-1">|</span>
                    <a href="{{ Storage::url($di->skema_ruas_path) }}" download="{{ basename($di->skema_ruas_path) }}">Unduh</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection