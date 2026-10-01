@extends('layouts.app')

@section('title', 'Tambah Kelembagaan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Tambah Kelembagaan SDA</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kelembagaan.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lembaga</label>
                    <input type="text" name="nama_lembaga" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jenis Lembaga</label>
                    <select name="jenis_lembaga" class="form-select">
                        <option value="Komisi Irigasi">Komisi Irigasi</option>
                        <option value="P3A">P3A</option>
                        <option value="GP3A">GP3A</option>
                        <option value="IP3A">IP3A</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status Keaktifan</label>
                    <select name="status_keaktifan" class="form-select">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nomor SK Kelembagaan</label>
                    <input type="text" name="nomor_sk" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Tugas dan Fungsi (Tusi)</label>
                    <textarea name="tusi" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Data RTT (Rencana Tata Tanam)</label>
                    <textarea name="data_rtt" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Data RAAT (Rencana Alokasi Air Tahunan)</label>
                    <textarea name="data_raat" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save me-1"></i> Simpan</button>
                <a href="{{ route('kelembagaan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection