@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-graph-up-arrow text-primary me-2"></i>Realisasi Fisik & Keuangan
        </h2>
    </div>

    {{-- Filter Tahun --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ url('/realisasi') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="tahun" class="form-label fw-semibold">Pilih Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="">-- Semua Tahun --</option>
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="{{ url('/realisasi') }}" class="btn btn-light border ms-1">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data Realisasi --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Paket / Kegiatan</th>
                            <th>Pagu Anggaran</th>
                            <th>Realisasi Fisik (%)</th>
                            <th>Realisasi Keuangan (Rp)</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($realisasiList) && count($realisasiList) > 0)
                            @foreach($realisasiList as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_paket ?? $item->kegiatan ?? '-' }}</td>
                                    <td>Rp {{ number_format($item->pagu ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $item->realisasi_fisik ?? 0 }}%</td>
                                    <td>Rp {{ number_format($item->realisasi_keuangan ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $item->tahun ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data realisasi fisik & keuangan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection