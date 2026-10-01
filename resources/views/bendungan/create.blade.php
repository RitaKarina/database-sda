@extends('layouts.app')

@section('title', 'Tambah Data Bendungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('bendungan.index') }}">Bendungan</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
@endsection

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white pt-3">
        <h6 class="fw-bold text-primary mb-0"><i class="fas fa-plus-circle me-2"></i> Form Tambah Bendungan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('bendungan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Bendungan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_bendungan" class="form-control" required placeholder="Contoh: Bendungan Pandan Duri">
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
                    <label class="form-label">Nama Sungai / DAS</label>
                    <input type="text" name="sungai" class="form-control" placeholder="Nama Sungai">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kapasitas Tampung (m³)</label>
                    <input type="number" step="0.01" name="kapasitas_tampung" class="form-control" placeholder="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tinggi Bendungan (m)</label>
                    <input type="number" step="0.01" name="tinggi_bendungan" class="form-control" placeholder="0.00">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Mulai Operasi</label>
                    <input type="number" name="tahun_mulai_operasi" class="form-control" placeholder="YYYY">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status Fungsi</label>
                    <select name="status_fungsi" class="form-select">
                        <option value="Berfungsi">Berfungsi</option>
                        <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan / Catatan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('bendungan.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
