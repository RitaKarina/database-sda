@extends('layouts.app')

@section('content')
<!-- Pustaka Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-dark">Data Daerah Irigasi</h2>
        <a href="{{ route('daerah-irigasi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Data
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama Daerah Irigasi</th>
                            <th>Kabupaten & Kecamatan</th>
                            <th>Luas Baku (Ha)</th>
                            <th>Luas Fungsional (Ha)</th>
                            <th>IP (%)</th>
                            <th>Nilai IKSI</th>
                            <th>Thn Dok. Perencanaan</th>
                            <th style="width: 130px;">Kelengkapan Data</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daerahIrigasis as $index => $di)
                            @php
                                // Perhitungan Persentase Kelengkapan Data
                                $fields = [
                                    $di->nama_di, $di->kode_di, $di->kabupaten, $di->kecamatan, 
                                    $di->luas_baku, $di->luas_fungsional, $di->ip, $di->iksi,
                                    $di->kewenangan, $di->sumber_air
                                ];
                                $filled = count(array_filter($fields, fn($value) => !empty($value)));
                                $persenKelengkapan = round(($filled / count($fields)) * 100);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-semibold text-primary">
                                    <a href="{{ route('daerah-irigasi.show', $di->id) }}" class="text-decoration-none">
                                        {{ $di->nama_di }}
                                    </a>
                                </td>
                                <td>
                                    {{ is_array($di->kabupaten) ? implode(', ', $di->kabupaten) : ($di->kabupaten ?? '-') }} <br>
                                    <small class="text-muted">
                                        {{ is_array($di->kecamatan) ? implode(', ', $di->kecamatan) : ($di->kecamatan ?? '-') }}
                                    </small>
                                </td>
                                <td class="text-end">{{ number_format($di->luas_baku ?? 0, 2) }}</td>
                                <td class="text-end">{{ number_format($di->luas_fungsional ?? 0, 2) }}</td>
                                <td class="text-center">{{ $di->ip ?? '-' }}</td>
                                <td class="text-center">{{ $di->iksi ?? $di->nilai_iksi ?? '-' }}</td>
                                <td class="text-center">{{ $di->tahun_dokumen_perencanaan ?? '-' }}</td>
                                
                                {{-- Kelengkapan Data --}}
                                <td>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold" style="font-size: 0.75rem;">{{ $persenKelengkapan }}%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar 
                                            @if($persenKelengkapan >= 80) bg-success 
                                            @elseif($persenKelengkapan >= 50) bg-warning 
                                            @else bg-danger 
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ $persenKelengkapan }}%;">
                                        </div>
                                    </div>
                                </td>

                                {{-- Aksi Berupa Ikon --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Detail -->
                                        <a href="{{ route('daerah-irigasi.show', $di->id) }}" class="btn btn-sm btn-outline-info" title="Detail Data">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('daerah-irigasi.edit', $di->id) }}" class="btn btn-sm btn-outline-warning text-dark" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Export / Print -->
                                        <a href="{{ route('daerah-irigasi.export', $di->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Export / Cetak Dokumen">
                                            <i class="bi bi-printer-fill"></i>
                                        </a>

                                        <!-- Hapus -->
                                        <form action="{{ route('daerah-irigasi.destroy', $di->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">Belum ada data Daerah Irigasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $daerahIrigasis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection