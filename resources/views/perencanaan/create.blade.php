@extends('layouts.app')

@section('title', 'Tambah Perencanaan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Tambah Usulan & Perencanaan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('perencanaan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Usulan Kegiatan</label>
                    <input type="text" name="usulan_kegiatan" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kategori Dokumen</label>
                    <select name="kategori_perencanaan" class="form-select">
                        <option value="Renstra">Renstra</option>
                        <option value="RPJMD">RPJMD</option>
                        <option value="Renja">Renja</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tahun Perencanaan</label>
                    <input type="number" name="tahun_perencanaan" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status DED</label>
                    <select name="status_ded" class="form-select">
                        <option value="Ada">Ada</option>
                        <option value="Belum Ada">Belum Ada</option>
                        <option value="Proses Penyusunan">Proses Penyusunan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status RC (Readiness Criteria)</label>
                    <select name="status_rc" class="form-select">
                        <option value="Ada">Ada</option>
                        <option value="Belum Ada">Belum Ada</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save me-1"></i> Simpan</button>
                <a href="{{ route('perencanaan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection