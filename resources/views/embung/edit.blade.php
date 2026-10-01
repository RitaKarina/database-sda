@extends('layouts.app')

@section('title', 'Edit Data Embung')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('embung.index') }}">Embung</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
@endsection

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white pt-3">
        <h6 class="fw-bold text-primary mb-0"><i class="fas fa-edit me-2"></i> Form Edit Embung</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('embung.update', $embung->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Embung <span class="text-danger">*</span></label>
                    <input type="text" name="nama_embung" class="form-control" value="{{ old('nama_embung', $embung->nama_embung) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kabupaten / Kota <span class="text-danger">*</span></label>
                    <select name="kabupaten_id" class="form-select" required>
                        @foreach($kabupatens as $kab)
                            <option value="{{ $kab->id }}" {{ $embung->kabupaten_id == $kab->id ? 'selected' : '' }}>{{ $kab->nama_kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $embung->kecamatan) }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Desa / Kelurahan</label>
                    <input type="text" name="desa" class="form-control" value="{{ old('desa', $embung->desa) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Volume Tampungan (m³)</label>
                    <input type="number" step="0.01" name="volume_tampungan" class="form-control" value="{{ old('volume_tampungan', $embung->volume_tampungan) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Luas Genangan (Ha)</label>
                    <input type="number" step="0.01" name="luas_genangan" class="form-control" value="{{ old('luas_genangan', $embung->luas_genangan) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sumber Air</label>
                    <input type="text" name="sumber_air" class="form-control" value="{{ old('sumber_air', $embung->sumber_air) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tahun Pembangunan</label>
                    <input type="number" name="tahun_pembangunan" class="form-control" value="{{ old('tahun_pembangunan', $embung->tahun_pembangunan) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="Baik" {{ $embung->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ $embung->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $embung->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status Fungsi</label>
                    <select name="status_fungsi" class="form-select">
                        <option value="Aktif" {{ $embung->status_fungsi == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $embung->status_fungsi == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan / Catatan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $embung->keterangan) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('embung.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-warning px-4"><i class="fas fa-save me-1"></i> Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection