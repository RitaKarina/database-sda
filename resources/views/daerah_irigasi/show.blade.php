@extends('layouts.app')

@section('title', 'Detail Daerah Irigasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('daerah-irigasi.index') }}">Daerah Irigasi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-water text-primary me-2"></i> {{ $di->nama_di }}</h5>
    <div>
        <a href="{{ route('daerah-irigasi.edit', $di->id) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit me-1"></i> Edit Data</a>
        <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>
</div>

<div class="row g-4">
    <!-- Informasi Umum & Teknis -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white pt-3 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i> Informasi Teknis & Administratif</div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td width="40%" class="text-muted">Kabupaten / Kota</td><td>: {{ $di->kabupaten->nama_kabupaten ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Kecamatan</td><td>: {{ $di->kecamatan }}</td></tr>
                    <tr><td class="text-muted">Kewenangan</td><td>: <span class="badge bg-info text-dark">{{ $di->kewenangan }}</span></td></tr>
                    <tr><td class="text-muted">Sumber Air</td><td>: {{ $di->sumber_air ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Nama Bendung</td><td>: {{ $di->bendung ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Luas Layanan</td><td>: {{ number_format($di->luas_layanan, 2) }} Ha</td></tr>
                    <tr><td class="text-muted">Luas Potensial</td><td>: {{ number_format($di->luas_potensial, 2) }} Ha</td></tr>
                    <tr><td class="text-muted">Luas Fungsional</td><td>: {{ number_format($di->luas_fungsional, 2) }} Ha</td></tr>
                    <tr><td class="text-muted">Kondisi Jaringan</td><td>: <span class="badge bg-primary">{{ $di->kondisi_jaringan ?? '-' }}</span></td></tr>
                    <tr><td class="text-muted">Status Fungsi</td><td>: {{ $di->status_fungsi ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Tahun Rehab Terakhir</td><td>: {{ $di->tahun_terakhir_rehabilitasi ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Tahun e-PAKSI</td><td>: {{ $di->tahun_e_paksi ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Jaringan Irigasi -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white pt-3 fw-bold text-success"><i class="fas fa-network-wired me-2"></i> Detail Jaringan Irigasi</div>
            <div class="card-body">
                @if($di->jaringanIrigasi)
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr><th>Komponen Jaringan</th><th>Jumlah / Panjang</th><th>Kondisi</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Saluran Primer</td><td>{{ $di->jaringanIrigasi->saluran_primer_panjang ?? 0 }} m</td><td>{{ $di->jaringanIrigasi->saluran_primer_kondisi ?? '-' }}</td></tr>
                            <tr><td>Saluran Sekunder</td><td>{{ $di->jaringanIrigasi->saluran_sekunder_panjang ?? 0 }} m</td><td>{{ $di->jaringanIrigasi->saluran_sekunder_kondisi ?? '-' }}</td></tr>
                            <tr><td>Saluran Tersier</td><td>{{ $di->jaringanIrigasi->saluran_tersier_panjang ?? 0 }} m</td><td>{{ $di->jaringanIrigasi->saluran_tersier_kondisi ?? '-' }}</td></tr>
                            <tr><td>Bangunan Bagi</td><td>{{ $di->jaringanIrigasi->bangunan_bagi_jumlah ?? 0 }} Unit</td><td>{{ $di->jaringanIrigasi->bangunan_bagi_kondisi ?? '-' }}</td></tr>
                            <tr><td>Bangunan Sadap</td><td>{{ $di->jaringanIrigasi->bangunan_sadap_jumlah ?? 0 }} Unit</td><td>{{ $di->jaringanIrigasi->bangunan_sadap_kondisi ?? '-' }}</td></tr>
                            <tr><td>Bangunan Pelengkap</td><td>{{ $di->jaringanIrigasi->bangunan_pelengkap_jumlah ?? 0 }} Unit</td><td>{{ $di->jaringanIrigasi->bangunan_pelengkap_kondisi ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-muted py-4">Data teknis detail jaringan belum diinputkan.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection