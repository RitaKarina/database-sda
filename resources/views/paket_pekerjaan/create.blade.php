@extends('layouts.app')

@section('title', 'Tambah Paket Pekerjaan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Tambah Paket Pekerjaan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('paket-pekerjaan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Paket Pekerjaan</label>
                    <input type="text" name="nama_paket" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kabupaten</label>
                    <select name="kabupaten_id" class="form-select">
                        <option value="">-- Pilih Kabupaten --</option>
                        @foreach($kabupatens as $kab)
                            <option value="{{ $kab->id }}">{{ $kab->nama_kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tahun Anggaran</label>
                    <input type="number" name="tahun_anggaran" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pagu Anggaran (Rp)</label>
                    <input type="number" name="pagu_anggaran" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nilai Kontrak (Rp)</label>
                    <input type="number" name="nilai_kontrak" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kontraktor / Pelaksana</label>
                    <input type="text" name="kontraktor" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sumber Dana</label>
                    <select name="sumber_dana" class="form-select">
                        <option value="APBD">APBD</option>
                        <option value="APBN">APBN</option>
                        <option value="DAK">DAK</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Pekerjaan</label>
                    <select name="status_pekerjaan" class="form-select">
                        <option value="Selesai">Selesai</option>
                        <option value="Sedang Berjalan">Sedang Berjalan</option>
                        <option value="Terkontrak">Terkontrak</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save me-1"></i> Simpan</button>
                <a href="{{ route('paket-pekerjaan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection