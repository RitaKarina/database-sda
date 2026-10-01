@extends('layouts.app')

@section('title', 'Detail Bendungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('bendungan.index') }}">Bendungan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-archway text-primary me-2"></i> {{ $bendungan->nama_bendungan }}</h5>
    <div>
        <a href="{{ route('bendungan.edit', $bendungan->id) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit me-1"></i> Edit Data</a>
        <a href="{{ route('bendungan.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white pt-3 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i> Informasi Detail Bendungan</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><td width="30%" class="text-muted">Kabupaten / Kota</td><td>: {{ $bendungan->kabupaten->nama_kabupaten ?? '-' }}</td></tr>
            <tr><td class="text-muted">Kecamatan</td><td>: {{ $bendungan->kecamatan }}</td></tr>
            <tr><td class="text-muted">Nama Sungai / DAS</td><td>: {{ $bendungan->sungai ?? '-' }}</td></tr>
            <tr><td class="text-muted">Kapasitas Tampung</td><td>: {{ number_format($bendungan->kapasitas_tampung, 2) }} m³</td></tr>
            <tr><td class="text-muted">Tinggi Bendungan</td><td>: {{ number_format($bendungan->tinggi_bendungan, 2) }} Meter</td></tr>
            <tr><td class="text-muted">Tahun Mulai Operasi</td><td>: {{ $bendungan->tahun_mulai_operasi ?? '-' }}</td></tr>
            <tr><td class="text-muted">Kondisi</td><td>: <span class="badge bg-{{ $bendungan->kondisi == 'Baik' ? 'success' : 'warning' }}">{{ $bendungan->kondisi }}</span></td></tr>
            <tr><td class="text-muted">Status Fungsi</td><td>: <span class="badge bg-info">{{ $bendungan->status_fungsi }}</span></td></tr>
            <tr><td class="text-muted">Keterangan</td><td>: {{ $bendungan->keterangan ?? '-' }}</td></tr>
        </table>
    </div>
</div>
@endsection