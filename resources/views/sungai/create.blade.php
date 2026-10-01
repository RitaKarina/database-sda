@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-dark"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Sungai Baru</h2>
        <a href="{{ route('sungai.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

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

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('sungai.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_sungai" class="form-label fw-semibold">Nama Sungai <span class="text-danger">*</span></label>
                    <input type="text" name="nama_sungai" id="nama_sungai" class="form-control" placeholder="Contoh: Sungai Brang Biji" value="{{ old('nama_sungai') }}" required>
                </div>

                <div class="mb-3">
                    <label for="panjang_km" class="form-label fw-semibold">Panjang Sungai (km)</label>
                    <input type="number" step="0.01" name="panjang_km" id="panjang_km" class="form-control" placeholder="Contoh: 12.5" value="{{ old('panjang_km') }}">
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label fw-semibold">Kecamatan / Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Sumbawa" value="{{ old('lokasi') }}">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('sungai.index') }}" class="btn btn-light border">Batal</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection