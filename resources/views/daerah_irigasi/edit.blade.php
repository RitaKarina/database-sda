@extends('layouts.app')

@section('title', 'Edit Daerah Irigasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('daerah-irigasi.index') }}">Daerah Irigasi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
@endsection

@section('content')
<form action="{{ route('daerah-irigasi.update', $di->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Card Data Utama & Teknis -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white pt-3">
            <h6 class="fw-bold text-primary mb-0"><i class="fas fa-edit me-2"></i> Edit Information Utama & Teknis</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Daerah Irigasi (DI) <span class="text-danger">*</span></label>
                    <input type="text" name="nama_di" class="form-control" value="{{ old('nama_di', $di->nama_di) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kabupaten / Kota <span class="text-danger">*</span></label>
                    <select name="kabupaten_id" class="form-select" required>
                        @foreach($kabupatens as $kab)
                            <option value="{{ $kab->id }}" {{ $di->kabupaten_id == $kab->id ? 'selected' : '' }}>{{ $kab->nama_kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $di->kecamatan) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Luas Layanan (Ha)</label>
                    <input type="number" step="0.01" name="luas_layanan" class="form-control" value="{{ old('luas_layanan', $di->luas_layanan) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Luas Potensial (Ha)</label>
                    <input type="number" step="0.01" name="luas_potensial" class="form-control" value="{{ old('luas_potensial', $di->luas_potensial) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Luas Fungsional (Ha)</label>
                    <input type="number" step="0.01" name="luas_fungsional" class="form-control" value="{{ old('luas_fungsional', $di->luas_fungsional) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kewenangan</label>
                    <select name="kewenangan" class="form-select">
                        <option value="Provinsi" {{ $di->kewenangan == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                        <option value="Pusat" {{ $di->kewenangan == 'Pusat' ? 'selected' : '' }}>Pusat</option>
                        <option value="Kabupaten/Kota" {{ $di->kewenangan == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sumber Air</label>
                    <input type="text" name="sumber_air" class="form-control" value="{{ old('sumber_air', $di->sumber_air) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Bendung</label>
                    <input type="text" name="bendung" class="form-control" value="{{ old('bendung', $di->bendung) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Kondisi Jaringan</label>
                    <select name="kondisi_jaringan" class="form-select">
                        <option value="Baik" {{ $di->kondisi_jaringan == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ $di->kondisi_jaringan == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $di->kondisi_jaringan == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Fungsi</label>
                    <select name="status_fungsi" class="form-select">
                        <option value="Aktif" {{ $di->status_fungsi == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $di->status_fungsi == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Rehab Terakhir</label>
                    <input type="number" name="tahun_terakhir_rehabilitasi" class="form-control" value="{{ old('tahun_terakhir_rehabilitasi', $di->tahun_terakhir_rehabilitasi) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun e-PAKSI</label>
                    <input type="number" name="tahun_e_paksi" class="form-control" value="{{ old('tahun_e_paksi', $di->tahun_e_paksi) }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Card Data Jaringan -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white pt-3">
            <h6 class="fw-bold text-success mb-0"><i class="fas fa-network-wired me-2"></i> Detail Data Jaringan Irigasi</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Panjang Saluran Primer (m)</label>
                    <input type="number" step="0.01" name="saluran_primer_panjang" class="form-control" value="{{ old('saluran_primer_panjang', $di->jaringanIrigasi->saluran_primer_panjang ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kondisi Primer</label>
                    <select name="saluran_primer_kondisi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Baik" {{ ($di->jaringanIrigasi->saluran_primer_kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ ($di->jaringanIrigasi->saluran_primer_kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ ($di->jaringanIrigasi->saluran_primer_kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Panjang Saluran Sekunder (m)</label>
                    <input type="number" step="0.01" name="saluran_sekunder_panjang" class="form-control" value="{{ old('saluran_sekunder_panjang', $di->jaringanIrigasi->saluran_sekunder_panjang ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kondisi Sekunder</label>
                    <select name="saluran_sekunder_kondisi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Baik" {{ ($di->jaringanIrigasi->saluran_sekunder_kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ ($di->jaringanIrigasi->saluran_sekunder_kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ ($di->jaringanIrigasi->saluran_sekunder_kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Panjang Saluran Tersier (m)</label>
                    <input type="number" step="0.01" name="saluran_tersier_panjang" class="form-control" value="{{ old('saluran_tersier_panjang', $di->jaringanIrigasi->saluran_tersier_panjang ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kondisi Tersier</label>
                    <select name="saluran_tersier_kondisi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Baik" {{ ($di->jaringanIrigasi->saluran_tersier_kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ ($di->jaringanIrigasi->saluran_tersier_kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ ($di->jaringanIrigasi->saluran_tersier_kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jumlah Bangunan Bagi (Unit)</label>
                    <input type="number" name="bangunan_bagi_jumlah" class="form-control" value="{{ old('bangunan_bagi_jumlah', $di->jaringanIrigasi->bangunan_bagi_jumlah ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kondisi Bangunan Bagi</label>
                    <select name="bangunan_bagi_kondisi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Baik" {{ ($di->jaringanIrigasi->bangunan_bagi_kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ ($di->jaringanIrigasi->bangunan_bagi_kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ ($di->jaringanIrigasi->bangunan_bagi_kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Jumlah Bangunan Sadap (Unit)</label>
                    <input type="number" name="bangunan_sadap_jumlah" class="form-control" value="{{ old('bangunan_sadap_jumlah', $di->jaringanIrigasi->bangunan_sadap_jumlah ?? '') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kondisi Bangunan Sadap</label>
                    <select name="bangunan_sadap_kondisi" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Baik" {{ ($di->jaringanIrigasi->bangunan_sadap_kondisi ?? '') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ ($di->jaringanIrigasi->bangunan_sadap_kondisi ?? '') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ ($di->jaringanIrigasi->bangunan_sadap_kondisi ?? '') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-secondary px-4">Batal</a>
        <button type="submit" class="btn btn-warning px-4"><i class="fas fa-save me-1"></i> Update Data</button>
    </div>
</form>
@endsection