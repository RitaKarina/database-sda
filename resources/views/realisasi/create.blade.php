@extends('layouts.app')

@section('title', 'Input Realisasi')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> Input Realisasi Fisik & Keuangan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('realisasi.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Pilih Paket Pekerjaan</label>
                    <select name="paket_pekerjaan_id" class="form-select" required>
                        <option value="">-- Pilih Paket Pekerjaan --</option>
                        @foreach($pakets as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_paket }} (Tahun {{ $p->tahun_anggaran }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tahun Realisasi</label>
                    <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Realisasi Fisik (%)</label>
                    <input type="number" step="0.01" name="realisasi_fisik_persen" class="form-control" placeholder="Contoh: 95.50" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Realisasi Keuangan (Rp)</label>
                    <input type="number" name="realisasi_keuangan_rp" class="form-control" placeholder="Contoh: 150000000" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save me-1"></i> Simpan Realisasi</button>
                <a href="{{ route('realisasi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection