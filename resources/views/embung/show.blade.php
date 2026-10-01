@extends('layouts.app')

@section('title', 'Detail Embung')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('embung.index') }}">Embung</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-water text-primary me-2"></i> {{ $embung->nama_embung }}</h5>
    <div>
        <a href="{{ route('embung.edit', $embung->id) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit me-1"></i> Edit Data</a>
        <a href="{{ route('embung.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white pt-3 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i> Informasi Detail Embung</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><td width="30%" class="text-muted">Kabupaten / Kota</td><td>: {{ $embung->kabupaten->nama_kabupaten ?? '-' }}</td></tr>
            <tr><td class="text-muted">Kecamatan</td><td>: {{ $embung->kecamatan }}</td></tr>
            <tr><td class="text-muted">Desa / Kelurahan</td><td>: {{ $embung->desa ?? '-' }}</td></tr>
            <tr><td class="text-muted">Volume Tampungan</td><td>: {{ number_format($embung->volume_tampungan, 2) }} m³</td></tr>
            <tr><td class="text-muted">Luas Genangan</td><td>: {{ number_format($embung->luas_genangan, 2) }} Ha</td></tr>
            <tr><td class="text-muted">Sumber Air</td><td>: {{ $embung->sumber_air ?? '-' }}</td></tr>
            <tr><td class="text-muted">Tahun Pembangunan</td><td>: {{ $embung->tahun_pembangunan ?? '-' }}</td></tr>
            <tr><td class="text-muted">Kondisi</td><td>: <span class="badge bg-{{ $embung->kondisi == 'Baik' ? 'success' : 'warning' }}">{{ $embung->kondisi }}</span></td></tr>
            <tr><td class="text-muted">Status Fungsi</td><td>: <span class="badge bg-info">{{ $embung->status_fungsi }}</span></td></tr>
            <tr><td class="text-muted">Keterangan</td><td>: {{ $embung->keterangan ?? '-' }}</td></tr>
        </table>
    </div>
</div>
@endsection