@extends('layouts.app')

@section('title', 'Edit Data Bendungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('bendungan.index') }}">Bendungan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
@endsection

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white pt-3">
        <h6 class="fw-bold text-primary mb-0"><i class="fas fa-edit me-2"></i> Form Edit Bendungan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('bendungan.update', $bendungan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Bendungan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_bendungan" class="form-control" value="{{ old('nama_bendungan', $bendungan->nama_bendungan) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kabupaten / Kota <span class="text-danger">*</span></label>
                    <select name="kabupaten_id" class="form-select" required>
                        @foreach($kabupatens as $kab)
                            <option value="{{ $kab->id }}" {{ $bendungan->kabupaten_id == $kab->id ? 'selected' : '' }}>{{ $kab->nama_kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $bendungan->kecamatan) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nama Sungai / DAS</label>
                    <input type="text" name="sungai" class="form-control" value="{{ old('sungai', $bendungan->sungai) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kapasitas Tampung (m³)</label>
                    <input type="number" step="0.01" name="kapasitas_tampung" class="form-control" value="{{ old('kapasitas_tampung', $bendungan->kapasitas_tampung) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tinggi Bendungan (m)</label>
                    <input type="number" step="0.01" name="tinggi_bendungan" class="form-control" value="{{ old('tinggi_bendungan', $bendungan->tinggi_bendungan) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Mulai Operasi</label>
                    <input type="number" name="tahun_mulai_operasi" class="form-control" value="{{ old('tahun_mulai_operasi', $bendungan->tahun_mulai_operasi) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="Baik" {{ $bendungan->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ $bendungan->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $bendungan->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status Fungsi</label>
                    <select name="status_fungsi" class="form-select">
                        <option value="Berfungsi" {{ $bendungan->status_fungsi == 'Berfungsi' ? 'selected' : '' }}>Berfungsi</option>
                        <option value="Tidak Berfungsi" {{ $bendungan->status_fungsi == 'Tidak Berfungsi' ? 'selected' : '' }}>Tidak Berfungsi</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan / Catatan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $bendungan->keterangan) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('bendungan.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-warning px-4"><i class="fas fa-save me-1"></i> Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection