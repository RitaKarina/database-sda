@extends('layouts.app')

@section('content')
@php
    $selectedKabupaten = old('kabupaten', is_array($di->kabupaten) ? $di->kabupaten : (filled($di->kabupaten) ? [$di->kabupaten] : []));
    $selectedKecamatan = old('kecamatan', is_array($di->kecamatan) ? $di->kecamatan : (filled($di->kecamatan) ? [$di->kecamatan] : []));
    $institutionTypes = ['IP3A', 'GP3A', 'P3A'];
    $institutionRows = old('kelembagaan');
    if (! is_array($institutionRows)) {
        $institutionRows = array_fill_keys($institutionTypes, []);
        foreach ($di->kelembagaans as $institution) {
            $jenis = $institution->jenis_kelembagaan;
            if (! in_array($jenis, $institutionTypes, true) && preg_match('/^(IP3A|GP3A|P3A)(?=$|[\s:-])/i', trim($institution->nama_kelembagaan), $matches)) {
                $jenis = strtoupper($matches[1]);
            }
            if (in_array($jenis, $institutionTypes, true)) {
                $institutionRows[$jenis][] = [
                    'nama_kelembagaan' => $institution->nama_kelembagaan,
                    'ruas' => $institution->ruas,
                ];
            }
        }
    }
    if (! is_array($selectedKabupaten)) {
        $selectedKabupaten = [];
    }
    if (! is_array($selectedKecamatan)) {
        $selectedKecamatan = [];
    }
    foreach ($institutionTypes as $jenis) {
        if (! isset($institutionRows[$jenis]) || ! is_array($institutionRows[$jenis]) || $institutionRows[$jenis] === []) {
            $institutionRows[$jenis] = [['nama_kelembagaan' => '', 'ruas' => '']];
        }
    }
@endphp

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-warning me-2"></i> Edit Data Daerah Irigasi: {{ $di->nama_di }}</h5>
        <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan input:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('daerah-irigasi.update', $di->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-info-circle-fill me-2"></i>Informasi Utama</h5>
                <div class="row g-3">
                    <div class="col-md-6"><label for="nama_di" class="form-label fw-semibold">Nama Daerah Irigasi (DI)</label><input type="text" name="nama_di" id="nama_di" class="form-control" value="{{ old('nama_di', $di->nama_di) }}" required></div>
                    <div class="col-md-6"><label for="kode_di" class="form-label fw-semibold">Kode DI</label><input type="text" name="kode_di" id="kode_di" class="form-control" value="{{ old('kode_di', $di->kode_di) }}"></div>
                    <div class="col-md-6"><label for="sumber_dana_penanganan" class="form-label fw-semibold">Sumber Dana Penanganan</label><input type="text" name="sumber_dana_penanganan" id="sumber_dana_penanganan" class="form-control" value="{{ old('sumber_dana_penanganan', $di->sumber_dana_penanganan) }}" maxlength="255"></div>
                    <div class="col-md-4"><label for="ip" class="form-label fw-semibold">Indeks Pertanaman (IP)</label><input type="number" step="0.01" name="ip" id="ip" class="form-control" value="{{ old('ip', $di->ip) }}"></div>
                    <div class="col-md-4"><label for="iksi" class="form-label fw-semibold">IKSI</label><input type="number" step="0.01" name="iksi" id="iksi" class="form-control" value="{{ old('iksi', $di->iksi) }}"></div>
                    <div class="col-md-4"><label for="tahun_dokumen_perencanaan" class="form-label fw-semibold">Tahun Dokumen Perencanaan</label><input type="text" name="tahun_dokumen_perencanaan" id="tahun_dokumen_perencanaan" class="form-control" value="{{ old('tahun_dokumen_perencanaan', $di->tahun_dokumen_perencanaan) }}"></div>
                    <div class="col-md-6"><label for="status_fungsi" class="form-label fw-semibold">Riwayat Penanganan (Tahun)</label><select name="status_fungsi" id="status_fungsi" class="form-select"><option value="">-- Pilih Tahun --</option>@for ($year = 2019; $year <= 2035; $year++)<option value="{{ $year }}" {{ old('status_fungsi', $di->status_fungsi) == (string) $year ? 'selected' : '' }}>{{ $year }}</option>@endfor</select></div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-rulers me-2"></i>Informasi Luas Daerah Irigasi</h5>
                <div class="row g-3">
                    <div class="col-md-4"><label for="luas_baku_igt" class="form-label fw-semibold">Luas Baku IGT (Ha)</label><input type="number" step="0.01" name="luas_baku_igt" id="luas_baku_igt" class="form-control" value="{{ old('luas_baku_igt', $di->luas_baku_igt ?? $di->luas_baku) }}"></div>
                    <div class="col-md-4"><label for="luas_potensial_igt" class="form-label fw-semibold">Luas Potensial IGT (Ha)</label><input type="number" step="0.01" name="luas_potensial_igt" id="luas_potensial_igt" class="form-control" value="{{ old('luas_potensial_igt', $di->luas_potensial_igt ?? $di->luas_potensial) }}"></div>
                    <div class="col-md-4"><label for="luas_fungsional_igt" class="form-label fw-semibold">Luas Fungsional IGT (Ha)</label><input type="number" step="0.01" name="luas_fungsional_igt" id="luas_fungsional_igt" class="form-control" value="{{ old('luas_fungsional_igt', $di->luas_fungsional_igt ?? $di->luas_fungsional) }}"></div>
                    <div class="col-md-4"><label for="luas_baku_permen_14" class="form-label fw-semibold">Luas Baku Permen 14 (Ha)</label><input type="text" inputmode="decimal" name="luas_baku_permen_14" id="luas_baku_permen_14" class="form-control" value="{{ old('luas_baku_permen_14', $di->luas_baku_permen_14) }}" pattern="[0-9]+([.,][0-9]{1,2})?" title="Gunakan angka dengan titik atau koma desimal, maksimal 2 angka di belakang koma."></div>
                    <div class="col-md-4"><label for="luas_fungsional_irigasi_teknis" class="form-label fw-semibold">Luas Fungsional Irigasi Teknis (Ha)</label><input type="text" inputmode="decimal" name="luas_fungsional_irigasi_teknis" id="luas_fungsional_irigasi_teknis" class="form-control" value="{{ old('luas_fungsional_irigasi_teknis', $di->luas_fungsional_irigasi_teknis) }}" pattern="[0-9]+([.,][0-9]{1,2})?" title="Gunakan angka dengan titik atau koma desimal, maksimal 2 angka di belakang koma."></div>
                    <div class="col-md-4"><label for="luas_fungsional_irigasi_non_teknis" class="form-label fw-semibold">Luas Fungsional Irigasi Non Teknis (Ha)</label><input type="text" inputmode="decimal" name="luas_fungsional_irigasi_non_teknis" id="luas_fungsional_irigasi_non_teknis" class="form-control" value="{{ old('luas_fungsional_irigasi_non_teknis', $di->luas_fungsional_irigasi_non_teknis) }}" pattern="[0-9]+([.,][0-9]{1,2})?" title="Gunakan angka dengan titik atau koma desimal, maksimal 2 angka di belakang koma."></div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Wilayah Administrasi</h5>
                <label class="form-label fw-bold d-block">Kabupaten / Kota</label>
                <div class="row g-2 border rounded p-3 bg-light mb-3">
                    @foreach($wilayahNtb as $kabupatenName => $kecamatanList)
                        @php $slugKab = \Illuminate\Support\Str::slug($kabupatenName); @endphp
                        <div class="col-md-3 col-6"><div class="form-check"><input class="form-check-input check-kabupaten" type="checkbox" name="kabupaten[]" value="{{ $kabupatenName }}" id="kab_{{ $slugKab }}" data-target="group_{{ $slugKab }}" {{ in_array($kabupatenName, $selectedKabupaten, true) ? 'checked' : '' }}><label class="form-check-label fw-semibold" for="kab_{{ $slugKab }}">{{ $kabupatenName }}</label></div></div>
                    @endforeach
                </div>
                <div id="container-kecamatan">
                    @foreach($wilayahNtb as $kabupatenName => $kecamatanList)
                        @php $slugKab = \Illuminate\Support\Str::slug($kabupatenName); @endphp
                        <div class="kecamatan-group border rounded p-3 mb-3 bg-white d-none" id="group_{{ $slugKab }}">
                            <h6 class="fw-bold text-secondary border-bottom pb-2 mb-2"><i class="bi bi-map me-1"></i> Pilih Kecamatan di {{ $kabupatenName }}:</h6>
                            <div class="row g-2">
                                @foreach($kecamatanList as $kec)
                                    <div class="col-md-3 col-6"><div class="form-check"><input class="form-check-input check-kecamatan" type="checkbox" name="kecamatan[]" value="{{ $kec }}" id="kec_{{ \Illuminate\Support\Str::slug($kabupatenName . '-' . $kec) }}" {{ in_array($kec, $selectedKecamatan, true) ? 'checked' : '' }}><label class="form-check-label" for="kec_{{ \Illuminate\Support\Str::slug($kabupatenName . '-' . $kec) }}">{{ $kec }}</label></div></div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row g-3">
                    <div class="col-md-6"><label for="kewenangan" class="form-label fw-semibold">Kewenangan</label><input type="text" name="kewenangan" id="kewenangan" class="form-control" value="{{ old('kewenangan', $di->kewenangan) }}"></div>
                    <div class="col-md-6"><label for="sumber_air" class="form-label fw-semibold">Sumber Air</label><input type="text" name="sumber_air" id="sumber_air" class="form-control" value="{{ old('sumber_air', $di->sumber_air) }}"></div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-people-fill me-2"></i>Organisasi Personalia</h5>
                <div class="row g-3">
                    <div class="col-md-4"><label for="nama_pengamat" class="form-label fw-semibold">Nama Pengamat</label><input type="text" name="nama_pengamat" id="nama_pengamat" class="form-control" value="{{ old('nama_pengamat', $di->nama_pengamat) }}"></div>
                    <div class="col-md-4"><label for="pengamat" class="form-label fw-semibold">Pengamat</label><input type="text" name="pengamat" id="pengamat" class="form-control" value="{{ old('pengamat', $di->pengamat) }}"></div>
                    <div class="col-md-4"><label for="juru_pengairan" class="form-label fw-semibold">Juru Pengairan</label><input type="text" name="juru_pengairan" id="juru_pengairan" class="form-control" value="{{ old('juru_pengairan', $di->juru_pengairan) }}"></div>
                    <div class="col-md-4"><label for="petugas_operasi_bendungan" class="form-label fw-semibold">Petugas Operasi Bendungan</label><input type="text" name="petugas_operasi_bendungan" id="petugas_operasi_bendungan" class="form-control" value="{{ old('petugas_operasi_bendungan', $di->petugas_operasi_bendungan) }}"></div>
                    <div class="col-md-4"><label for="petugas_pintu_bendung_air" class="form-label fw-semibold">Petugas Pintu Bendung Air</label><input type="text" name="petugas_pintu_bendung_air" id="petugas_pintu_bendung_air" class="form-control" value="{{ old('petugas_pintu_bendung_air', $di->petugas_pintu_bendung_air) }}"></div>
                    <div class="col-md-4"><label for="kebutuhan_pengamat" class="form-label fw-semibold">Kebutuhan Pengamat</label><input type="number" step="1" min="0" name="kebutuhan_pengamat" id="kebutuhan_pengamat" class="form-control" value="{{ old('kebutuhan_pengamat', $di->kebutuhan_pengamat) }}"></div>
                    <div class="col-md-4"><label for="ketersediaan_pengamat" class="form-label fw-semibold">Ketersediaan</label><input type="number" step="1" min="0" name="ketersediaan_pengamat" id="ketersediaan_pengamat" class="form-control" value="{{ old('ketersediaan_pengamat', $di->ketersediaan_pengamat) }}"></div>
                    <div class="col-md-8"><label class="form-label fw-semibold">Status Ketersediaan</label><div class="d-flex align-items-center gap-2 mt-2"><span id="pengamat-status-badge" class="badge {{ ($di->status_ketersediaan_pengamat ?? 'Belum diisi') == 'Sudah Terpenuhi' ? 'bg-success' : (($di->status_ketersediaan_pengamat ?? 'Belum diisi') == 'Belum Terpenuhi' ? 'bg-warning text-dark' : 'bg-secondary') }}">{{ $di->status_ketersediaan_pengamat ?? 'Belum diisi' }}</span><input type="hidden" name="status_ketersediaan_pengamat" id="status_ketersediaan_pengamat" value="{{ old('status_ketersediaan_pengamat', $di->status_ketersediaan_pengamat ?? 'Belum diisi') }}"></div></div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-building me-2"></i>Kelembagaan dan Ruas Kewenangan</h5>
                @foreach($institutionTypes as $jenis)
                    <section class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-primary mb-0">{{ $jenis }}</h6>
                            <button type="button" class="btn btn-outline-primary btn-sm add-kelembagaan" data-type="{{ $jenis }}"><i class="bi bi-plus-circle me-1"></i>Tambah Kelembagaan</button>
                        </div>
                        <div id="kelembagaan-rows-{{ $jenis }}">
                            @foreach($institutionRows[$jenis] as $index => $row)
                                <div class="row g-3 align-items-end kelembagaan-row mb-3">
                                    <div class="col-md-5">
                                        <label for="kelembagaan_{{ $jenis }}_{{ $index }}_nama" class="form-label fw-semibold">Nama Kelembagaan</label>
                                        <input type="text" name="kelembagaan[{{ $jenis }}][{{ $index }}][nama_kelembagaan]" id="kelembagaan_{{ $jenis }}_{{ $index }}_nama" class="form-control" value="{{ is_array($row) ? ($row['nama_kelembagaan'] ?? '') : '' }}" maxlength="255">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="kelembagaan_{{ $jenis }}_{{ $index }}_ruas" class="form-label fw-semibold">Ruas Kewenangan</label>
                                        <input type="text" name="kelembagaan[{{ $jenis }}][{{ $index }}][ruas]" id="kelembagaan_{{ $jenis }}_{{ $index }}_ruas" class="form-control" value="{{ is_array($row) ? ($row['ruas'] ?? '') : '' }}" maxlength="255">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger w-100 remove-kelembagaan">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    <template id="kelembagaan-template-{{ $jenis }}">
                        <div class="row g-3 align-items-end kelembagaan-row mb-3">
                            <div class="col-md-5">
                                <label for="kelembagaan_{{ $jenis }}___INDEX___nama" class="form-label fw-semibold">Nama Kelembagaan</label>
                                <input type="text" name="kelembagaan[{{ $jenis }}][__INDEX__][nama_kelembagaan]" id="kelembagaan_{{ $jenis }}___INDEX___nama" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-5">
                                <label for="kelembagaan_{{ $jenis }}___INDEX___ruas" class="form-label fw-semibold">Ruas Kewenangan</label>
                                <input type="text" name="kelembagaan[{{ $jenis }}][__INDEX__][ruas]" id="kelembagaan_{{ $jenis }}___INDEX___ruas" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger w-100 remove-kelembagaan">Hapus</button>
                            </div>
                        </div>
                    </template>
                @endforeach
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-tools me-2"></i>Data Teknis & Infrastruktur</h5>
                <div class="row g-3">
                    <div class="col-md-4"><label for="bendung_buah" class="form-label fw-semibold">Bendung (Buah)</label><input type="number" name="bendung_buah" id="bendung_buah" class="form-control" value="{{ old('bendung_buah', $di->bendung_buah) }}"></div>
                    <div class="col-md-8"><label for="bendung" class="form-label fw-semibold">Nama / Keterangan Bendung</label><input type="text" name="bendung" id="bendung" class="form-control" value="{{ old('bendung', $di->bendung) }}"></div>
                    <div class="col-md-12"><label class="form-label fw-semibold">Saluran Primer (m)</label><div class="row g-2"><div class="col-md-3"><input type="number" step="0.01" name="saluran_primer_m" class="form-control" placeholder="Total (m)" value="{{ old('saluran_primer_m', $di->saluran_primer_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_primer_baik_m" class="form-control" placeholder="Baik (m)" value="{{ old('saluran_primer_baik_m', $di->saluran_primer_baik_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_primer_sedang_m" class="form-control" placeholder="Sedang (m)" value="{{ old('saluran_primer_sedang_m', $di->saluran_primer_sedang_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_primer_buruk_m" class="form-control" placeholder="Buruk (m)" value="{{ old('saluran_primer_buruk_m', $di->saluran_primer_buruk_m) }}"></div></div></div>
                    <div class="col-md-12"><label class="form-label fw-semibold">Saluran Sekunder (m)</label><div class="row g-2"><div class="col-md-3"><input type="number" step="0.01" name="saluran_sekunder_m" class="form-control" placeholder="Total (m)" value="{{ old('saluran_sekunder_m', $di->saluran_sekunder_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_sekunder_baik_m" class="form-control" placeholder="Baik (m)" value="{{ old('saluran_sekunder_baik_m', $di->saluran_sekunder_baik_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_sekunder_sedang_m" class="form-control" placeholder="Sedang (m)" value="{{ old('saluran_sekunder_sedang_m', $di->saluran_sekunder_sedang_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_sekunder_buruk_m" class="form-control" placeholder="Buruk (m)" value="{{ old('saluran_sekunder_buruk_m', $di->saluran_sekunder_buruk_m) }}"></div></div></div>
                    <div class="col-md-12"><label class="form-label fw-semibold">Saluran Tersier (m)</label><div class="row g-2"><div class="col-md-3"><input type="number" step="0.01" name="saluran_tersier_m" class="form-control" placeholder="Total (m)" value="{{ old('saluran_tersier_m', $di->saluran_tersier_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_tersier_baik_m" class="form-control" placeholder="Baik (m)" value="{{ old('saluran_tersier_baik_m', $di->saluran_tersier_baik_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_tersier_sedang_m" class="form-control" placeholder="Sedang (m)" value="{{ old('saluran_tersier_sedang_m', $di->saluran_tersier_sedang_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_tersier_buruk_m" class="form-control" placeholder="Buruk (m)" value="{{ old('saluran_tersier_buruk_m', $di->saluran_tersier_buruk_m) }}"></div></div></div>
                    <div class="col-md-12"><label class="form-label fw-semibold">Saluran Pembuang (m)</label><div class="row g-2"><div class="col-md-3"><input type="number" step="0.01" name="saluran_pembuang_m" class="form-control" placeholder="Total (m)" value="{{ old('saluran_pembuang_m', $di->saluran_pembuang_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_pembuang_baik_m" class="form-control" placeholder="Baik (m)" value="{{ old('saluran_pembuang_baik_m', $di->saluran_pembuang_baik_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_pembuang_sedang_m" class="form-control" placeholder="Sedang (m)" value="{{ old('saluran_pembuang_sedang_m', $di->saluran_pembuang_sedang_m) }}"></div><div class="col-md-3"><input type="number" step="0.01" name="saluran_pembuang_buruk_m" class="form-control" placeholder="Buruk (m)" value="{{ old('saluran_pembuang_buruk_m', $di->saluran_pembuang_buruk_m) }}"></div></div></div>
                    <div class="col-md-6"><label for="bangunan_pengatur_buah" class="form-label fw-semibold">Bangunan Pengatur (Buah)</label><input type="number" name="bangunan_pengatur_buah" id="bangunan_pengatur_buah" class="form-control" value="{{ old('bangunan_pengatur_buah', $di->bangunan_pengatur_buah) }}"></div>
                    <div class="col-md-6"><label for="bangunan_pelengkap_buah" class="form-label fw-semibold">Bangunan Pelengkap (Buah)</label><input type="number" name="bangunan_pelengkap_buah" id="bangunan_pelengkap_buah" class="form-control" value="{{ old('bangunan_pelengkap_buah', $di->bangunan_pelengkap_buah) }}"></div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-map-fill me-2"></i>Peta Skema & Lokasi Irigasi</h5>
                <div class="row g-3 mb-3"><div class="col-md-6"><label for="latitude" class="form-label fw-semibold">Latitude</label><input type="text" name="latitude" id="latitude" class="form-control bg-light" value="{{ old('latitude', $di->latitude) }}" readonly></div><div class="col-md-6"><label for="longitude" class="form-label fw-semibold">Longitude</label><input type="text" name="longitude" id="longitude" class="form-control bg-light" value="{{ old('longitude', $di->longitude) }}" readonly></div></div>
                <div id="map" style="height: 360px; border-radius: 8px;" class="border mb-3"></div>
                <div class="mt-3">
                    <label for="peta_skema" class="form-label fw-semibold">Upload Peta Skema Bangunan dan Jaringan (JPG/PNG)</label>
                    <input type="file" name="peta_skema" id="peta_skema" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    <small class="text-muted">Format JPG, PNG, atau WebP; ukuran maksimum 10 MB.</small>
                    <div id="scheme-preview" class="mt-3 {{ $di->peta_skema_path ? '' : 'd-none' }}">
                        <img id="scheme-preview-image" src="{{ $di->peta_skema_path ? Storage::url($di->peta_skema_path) : '' }}" data-original-url="{{ $di->peta_skema_path ? Storage::url($di->peta_skema_path) : '' }}" class="img-fluid border rounded mb-2" style="max-height: 320px" alt="Preview peta skema {{ $di->nama_di }}">
                        <div class="d-flex gap-2">
                            <a id="scheme-preview-link" class="btn btn-sm btn-outline-primary" href="{{ $di->peta_skema_path ? Storage::url($di->peta_skema_path) : '#' }}" target="_blank" rel="noopener">Lihat Peta Skema</a>
                            <a id="scheme-download-link" class="btn btn-sm btn-outline-secondary" href="{{ $di->peta_skema_path ? Storage::url($di->peta_skema_path) : '#' }}" download="{{ $di->peta_skema_path ? basename($di->peta_skema_path) : '' }}">Unduh Peta Skema</a>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="skema_ruas" class="form-label fw-semibold">Upload Skema Ruas Kewenangan IP3A, GP3A, P3A</label>
                    <input type="file" name="skema_ruas" id="skema_ruas" class="form-control" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png">
                    <small class="text-muted">Format PDF, JPG, atau PNG; ukuran maksimum 10 MB. File lama tetap digunakan jika tidak memilih file baru.</small>
                    @if ($di->skema_ruas_path)
                        <div class="mt-2">
                            <a href="{{ Storage::url($di->skema_ruas_path) }}" target="_blank" rel="noopener">Lihat skema ruas saat ini</a>
                            <span class="text-muted mx-1">|</span>
                            <a href="{{ Storage::url($di->skema_ruas_path) }}" download="{{ basename($di->skema_ruas_path) }}">Unduh skema ruas</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 text-end"><button type="submit" class="btn btn-warning text-dark fw-bold"><i class="fas fa-save me-1"></i> Simpan Perubahan</button></div>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kabupatenCheckboxes = document.querySelectorAll('.check-kabupaten');
        const updateKecamatanGroups = function () {
            kabupatenCheckboxes.forEach(function (checkbox) {
                const group = document.getElementById(checkbox.dataset.target);
                if (!group) {
                    return;
                }
                group.classList.toggle('d-none', !checkbox.checked);
                if (!checkbox.checked) {
                    group.querySelectorAll('.check-kecamatan').forEach(function (kecamatan) {
                        kecamatan.checked = false;
                    });
                }
            });
        };
        kabupatenCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', updateKecamatanGroups);
        });
        updateKecamatanGroups();

        document.querySelectorAll('.add-kelembagaan').forEach(function (button) {
            const jenis = button.dataset.type;
            const institutionRows = document.getElementById('kelembagaan-rows-' + jenis);
            const institutionTemplate = document.getElementById('kelembagaan-template-' + jenis);
            let institutionIndex = Array.from(institutionRows.querySelectorAll('[name^="kelembagaan["]')).reduce(function (maxIndex, input) {
                const match = input.name.match(/\[(\d+)\]\[(?:nama_kelembagaan|ruas)\]$/);
                return match ? Math.max(maxIndex, Number(match[1])) : maxIndex;
            }, -1) + 1;
            button.addEventListener('click', function () {
                institutionRows.insertAdjacentHTML('beforeend', institutionTemplate.innerHTML.replaceAll('__INDEX__', institutionIndex));
                institutionIndex += 1;
            });
            institutionRows.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-kelembagaan');
                if (removeButton) {
                    removeButton.closest('.kelembagaan-row').remove();
                }
            });
        });

        const kebutuhanInput = document.getElementById('kebutuhan_pengamat');
        const ketersediaanInput = document.getElementById('ketersediaan_pengamat');
        const statusInput = document.getElementById('status_ketersediaan_pengamat');
        const statusBadge = document.getElementById('pengamat-status-badge');
        function updatePengamatStatus(){const kebutuhan = parseFloat(kebutuhanInput?.value || 0); const ketersediaan = parseFloat(ketersediaanInput?.value || 0); if (kebutuhan > 0 || ketersediaan > 0) { const status = ketersediaan >= kebutuhan ? 'Sudah Terpenuhi' : 'Belum Terpenuhi'; statusInput.value = status; statusBadge.className = 'badge ' + (ketersediaan >= kebutuhan ? 'bg-success' : 'bg-warning text-dark'); statusBadge.textContent = status; } else { statusInput.value = 'Belum diisi'; statusBadge.className = 'badge bg-secondary'; statusBadge.textContent = 'Belum diisi'; }}
        [kebutuhanInput, ketersediaanInput].forEach(function (element) { if (element) element.addEventListener('input', updatePengamatStatus); });
        updatePengamatStatus();
        const schemeInput = document.getElementById('peta_skema');
        const ruasSchemeInput = document.getElementById('skema_ruas');
        const schemePreview = document.getElementById('scheme-preview');
        const schemeImage = document.getElementById('scheme-preview-image');
        const schemePreviewLink = document.getElementById('scheme-preview-link');
        const schemeDownloadLink = document.getElementById('scheme-download-link');
        const originalSchemeUrl = schemeImage.dataset.originalUrl;
        let previewUrl = null;

        ruasSchemeInput.addEventListener('change', function () {
            ruasSchemeInput.setCustomValidity('');
            if (ruasSchemeInput.files[0]?.size > 10 * 1024 * 1024) {
                ruasSchemeInput.value = '';
                ruasSchemeInput.setCustomValidity('Ukuran file skema ruas tidak boleh melebihi 10 MB.');
                ruasSchemeInput.reportValidity();
            }
        });

        schemeInput.addEventListener('change', function () {
            schemeInput.setCustomValidity('');
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            const file = schemeInput.files[0];
            if (!file) {
                if (originalSchemeUrl) {
                    schemeImage.src = originalSchemeUrl;
                    schemePreviewLink.href = originalSchemeUrl;
                    schemeDownloadLink.href = originalSchemeUrl;
                    schemePreview.classList.remove('d-none');
                } else {
                    schemePreview.classList.add('d-none');
                }
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                schemeInput.value = '';
                schemeInput.setCustomValidity('Ukuran file skema tidak boleh melebihi 10 MB.');
                schemeInput.reportValidity();
                schemePreview.classList.add('d-none');
                return;
            }
            previewUrl = URL.createObjectURL(file);
            schemeImage.src = previewUrl;
            schemePreviewLink.href = previewUrl;
            schemeDownloadLink.href = previewUrl;
            schemeDownloadLink.download = file.name;
            schemePreview.classList.remove('d-none');
        });
        const defaultLat = parseFloat('{{ old('latitude', $di->latitude ?? -8.5) }}') || -8.5; const defaultLng = parseFloat('{{ old('longitude', $di->longitude ?? 117.4) }}') || 117.4; const map = L.map('map').setView([defaultLat, defaultLng], 8); L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map); let marker = null; const setMarker = function (lat, lng) { if (marker) map.removeLayer(marker); marker = L.marker([lat, lng]).addTo(map); document.getElementById('latitude').value = lat.toFixed(6); document.getElementById('longitude').value = lng.toFixed(6); }; if (document.getElementById('latitude').value && document.getElementById('longitude').value) setMarker(parseFloat(document.getElementById('latitude').value), parseFloat(document.getElementById('longitude').value)); map.on('click', function (event) { setMarker(event.latlng.lat, event.latlng.lng); });
    });
</script>
@endsection
