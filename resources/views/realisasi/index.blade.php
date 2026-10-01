@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan input:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-dark">
            <i class="bi bi-graph-up-arrow text-primary me-2"></i>Realisasi Fisik & Keuangan
        </h2>
        
        {{-- Tombol Tambah Data yang memicu Modal Popup --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahRealisasi">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data Realisasi
        </button>
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
                            <th width="10%" class="text-center">Aksi</th>
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
                                    <td class="text-center">
                                        <form action="{{ route('realisasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
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

{{-- MODAL POPUP FORM TAMBAH DATA --}}
<div class="modal fade" id="modalTambahRealisasi" tabindex="-1" aria-labelledby="modalTambahRealisasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTambahRealisasiLabel">Tambah Data Realisasi Fisik & Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('realisasi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label fw-semibold">Nama Paket / Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_paket" id="nama_paket" class="form-control" placeholder="Contoh: Normalisasi Sungai Brang Biji" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pagu" class="form-label fw-semibold">Pagu Anggaran (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="pagu" id="pagu" class="form-control" placeholder="Contoh: 500000000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun" class="form-label fw-semibold">Tahun Anggaran <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="realisasi_fisik" class="form-label fw-semibold">Realisasi Fisik (%)</label>
                            <input type="number" step="0.01" name="realisasi_fisik" id="realisasi_fisik" class="form-control" placeholder="Contoh: 75.5">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="realisasi_keuangan" class="form-label fw-semibold">Realisasi Keuangan (Rp)</label>
                            <input type="number" name="realisasi_keuangan" id="realisasi_keuangan" class="form-control" placeholder="Contoh: 375000000">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection