@extends('layouts.app')

@section('title', 'Tambah Data Embung')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('embung.index') }}">Embung</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
@endsection

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white pt-3">
        <h6 class="fw-bold text-primary mb-0"><i class="fas fa-plus-circle me-2"></i> Form Tambah Embung</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('embung.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Embung <span class="text-danger">*</span></label>
                    <input type="text" name="nama_embung" class="form-control" required placeholder="Contoh: Embung Rababaka">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kabupaten / Kota <span class="text-danger">*</span></label>
                    <select name="kabupaten_id" class="form-select" required>
                        <option value="">-- Pilih Kabupaten --</option>
                        @foreach($kabupatens as $kab)
                            <option value="{{ $kab->id }}">{{ $kab->nama_kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="kecamatan" class="form-control" required placeholder="Nama Kecamatan">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Desa / Kelurahan</label>
                    <input type="text" name="desa" class="form-control" placeholder="Nama Desa">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Volume Tampungan (m³)</label>
                    <input type="number" step="0.01" name="volume_tampungan" class="form-control" placeholder="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Luas Genangan (Ha)</label>
                    <input type="number" step="0.01" name="luas_genangan" class="form-control" placeholder="0.00">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sumber Air</label>
                    <input type="text" name="sumber_air" class="form-control" placeholder="Contoh: Sungai / Hujan">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tahun Pembangunan</label>
                    <input type="number" name="tahun_pembangunan" class="form-control" placeholder="YYYY">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status Fungsi</label>
                    <select name="status_fungsi" class="form-select">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan / Catatan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('embung.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection