@extends('layouts.app')

@section('content')
<!-- Leaflet CSS untuk Peta -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-dark"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Daerah Irigasi Baru</h2>
        <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-secondary">
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

    <form action="{{ route('daerah-irigasi.store') }}" method="POST">
        @csrf

        {{-- 1. INFORMASI UTAMA --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-info-circle-fill me-2"></i>Informasi Utama</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_di" class="form-label fw-semibold">Nama Daerah Irigasi (DI) <span class="text-danger">*</span></label>
                        <input type="text" name="nama_di" id="nama_di" class="form-control" placeholder="Contoh: Batu Bulan" value="{{ old('nama_di') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="kode_di" class="form-label fw-semibold">Kode DI</label>
                        <input type="text" name="kode_di" id="kode_di" class="form-control" placeholder="Contoh: 52.06.DI.001" value="{{ old('kode_di') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="luas_baku" class="form-label fw-semibold">Luas Baku (Permen 14) [Ha] <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="luas_baku" id="luas_baku" class="form-control" placeholder="0.00" value="{{ old('luas_baku') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="luas_potensial" class="form-label fw-semibold">Luas Potensial [Ha]</label>
                        <input type="number" step="0.01" name="luas_potensial" id="luas_potensial" class="form-control" placeholder="0.00" value="{{ old('luas_potensial') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="luas_fungsional" class="form-label fw-semibold">Luas Fungsional [Ha]</label>
                        <input type="number" step="0.01" name="luas_fungsional" id="luas_fungsional" class="form-control" placeholder="0.00" value="{{ old('luas_fungsional') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="ip" class="form-label fw-semibold">Indeks Pertanaman (IP) [%]</label>
                        <input type="number" step="0.01" name="ip" id="ip" class="form-control" placeholder="Contoh: 150.00" value="{{ old('ip') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="iksi" class="form-label fw-semibold">IKSI (Indeks Kinerja) [%]</label>
                        <input type="number" step="0.01" name="iksi" id="iksi" class="form-control" placeholder="0 - 100%" value="{{ old('iksi') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="tahun_dokumen_perencanaan" class="form-label fw-semibold">Thn Dok. Perencanaan</label>
                        <input type="text" maxlength="4" name="tahun_dokumen_perencanaan" id="tahun_dokumen_perencanaan" class="form-control" placeholder="Contoh: 2022" value="{{ old('tahun_dokumen_perencanaan') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="tahun_epaksi" class="form-label fw-semibold">Tahun e-PAKSI</label>
                        <input type="text" maxlength="4" name="tahun_epaksi" id="tahun_epaksi" class="form-control" placeholder="Contoh: 2023" value="{{ old('tahun_epaksi') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="status_fungsi" class="form-label fw-semibold">Status Fungsi</label>
                        <select name="status_fungsi" id="status_fungsi" class="form-select">
                            <option value="">-- Pilih Status Fungsi --</option>
                            <option value="Berfungsi Baik" {{ old('status_fungsi') == 'Berfungsi Baik' ? 'selected' : '' }}>Berfungsi Baik</option>
                            <option value="Rusak Ringan" {{ old('status_fungsi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Sedang" {{ old('status_fungsi') == 'Rusak Sedang' ? 'selected' : '' }}>Rusak Sedang</option>
                            <option value="Rusak Berat" {{ old('status_fungsi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. WILAYAH ADMINISTRASI --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Wilayah Administrasi</h5>
                
                <label class="form-label fw-bold d-block">Kabupaten / Kota (Centang untuk memilih):</label>
                <div class="row g-2 border rounded p-3 bg-light mb-3">
                    @if(isset($dataKabupaten) && count($dataKabupaten) > 0)
                        @foreach($dataKabupaten as $kabupatenName => $kecamatanList)
                            @php
                                $slugKab = \Illuminate\Support\Str::slug($kabupatenName);
                            @endphp
                            <div class="col-md-3 col-6">
                                <div class="form-check">
                                    <input class="form-check-input check-kabupaten" 
                                           type="checkbox" 
                                           name="kabupaten[]" 
                                           value="{{ $kabupatenName }}" 
                                           id="kab_{{ $slugKab }}"
                                           data-target="group_{{ $slugKab }}"
                                           {{ is_array(old('kabupaten')) && in_array($kabupatenName, old('kabupaten')) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="kab_{{ $slugKab }}">
                                        {{ $kabupatenName }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Area Input Pilihan Kecamatan --}}
                <div id="container-kecamatan">
                    @if(isset($dataKabupaten) && count($dataKabupaten) > 0)
                        @foreach($dataKabupaten as $kabupatenName => $kecamatanList)
                            @php
                                $slugKab = \Illuminate\Support\Str::slug($kabupatenName);
                            @endphp
                            <div class="kecamatan-group border rounded p-3 mb-3 bg-white d-none" id="group_{{ $slugKab }}">
                                <h6 class="fw-bold text-secondary border-bottom pb-2 mb-2">
                                    <i class="bi bi-map me-1"></i> Pilih Kecamatan di {{ $kabupatenName }}:
                                </h6>
                                <div class="row g-2">
                                    @if(is_array($kecamatanList) || is_object($kecamatanList))
                                        @foreach($kecamatanList as $kec)
                                            <div class="col-md-3 col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input check-kecamatan" 
                                                           type="checkbox" 
                                                           name="kecamatan[]" 
                                                           value="{{ $kec }}" 
                                                           data-kabupaten="{{ $kabupatenName }}"
                                                           id="kec_{{ \Illuminate\Support\Str::slug($kec) }}"
                                                           {{ is_array(old('kecamatan')) && in_array($kec, old('kecamatan')) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kec_{{ \Illuminate\Support\Str::slug($kec) }}">
                                                        {{ $kec }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>

        {{-- 3. DATA TEKNIS & INFRASTRUKTUR --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-tools me-2"></i>Data Teknis & Infrastruktur</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="kewenangan" class="form-label fw-semibold">Kewenangan</label>
                        <input type="text" name="kewenangan" id="kewenangan" class="form-control" placeholder="Contoh: Provinsi / Pusat" value="{{ old('kewenangan') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="sumber_air" class="form-label fw-semibold">Sumber Air</label>
                        <input type="text" name="sumber_air" id="sumber_air" class="form-control" placeholder="Contoh: Sungai Brang Biji" value="{{ old('sumber_air') }}">
                    </div>

                    {{-- Bendung --}}
                    <div class="col-md-4">
                        <label for="bendung_buah" class="form-label fw-semibold">Bendung (Buah)</label>
                        <input type="number" step="1" name="bendung_buah" id="bendung_buah" class="form-control" placeholder="0" value="{{ old('bendung_buah') }}">
                    </div>
                    <div class="col-md-8">
                        <label for="bendung" class="form-label fw-semibold">Nama / Keterangan Bendung</label>
                        <input type="text" name="bendung" id="bendung" class="form-control" placeholder="Contoh: Bendung Batu Bulan" value="{{ old('bendung') }}">
                    </div>

                    {{-- Saluran Primer --}}
                    <div class="col-md-6">
                        <label for="saluran_primer_m" class="form-label fw-semibold">Saluran Primer (m)</label>
                        <input type="number" step="0.01" name="saluran_primer_m" id="saluran_primer_m" class="form-control" placeholder="0.00" value="{{ old('saluran_primer_m') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="saluran_primer_km" class="form-label fw-semibold">Saluran Primer (km)</label>
                        <input type="number" step="0.001" name="saluran_primer_km" id="saluran_primer_km" class="form-control" placeholder="0.000" value="{{ old('saluran_primer_km') }}">
                    </div>

                    {{-- Saluran Sekunder --}}
                    <div class="col-md-6">
                        <label for="saluran_sekunder_m" class="form-label fw-semibold">Saluran Sekunder (m)</label>
                        <input type="number" step="0.01" name="saluran_sekunder_m" id="saluran_sekunder_m" class="form-control" placeholder="0.00" value="{{ old('saluran_sekunder_m') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="saluran_sekunder_km" class="form-label fw-semibold">Saluran Sekunder (km)</label>
                        <input type="number" step="0.001" name="saluran_sekunder_km" id="saluran_sekunder_km" class="form-control" placeholder="0.000" value="{{ old('saluran_sekunder_km') }}">
                    </div>

                    {{-- Saluran Suplai --}}
                    <div class="col-md-6">
                        <label for="saluran_suplai_m" class="form-label fw-semibold">Saluran Suplai (m)</label>
                        <input type="number" step="0.01" name="saluran_suplai_m" id="saluran_suplai_m" class="form-control" placeholder="0.00" value="{{ old('saluran_suplai_m') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="saluran_suplai_km" class="form-label fw-semibold">Saluran Suplai (km)</label>
                        <input type="number" step="0.001" name="saluran_suplai_km" id="saluran_suplai_km" class="form-control" placeholder="0.000" value="{{ old('saluran_suplai_km') }}">
                    </div>

                    {{-- Saluran Pembuang --}}
                    <div class="col-md-6">
                        <label for="saluran_pembuang_m" class="form-label fw-semibold">Saluran Pembuang (m)</label>
                        <input type="number" step="0.01" name="saluran_pembuang_m" id="saluran_pembuang_m" class="form-control" placeholder="0.00" value="{{ old('saluran_pembuang_m') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="saluran_pembuang_km" class="form-label fw-semibold">Saluran Pembuang (km)</label>
                        <input type="number" step="0.001" name="saluran_pembuang_km" id="saluran_pembuang_km" class="form-control" placeholder="0.000" value="{{ old('saluran_pembuang_km') }}">
                    </div>

                    {{-- Bangunan Pengatur & Pelengkap --}}
                    <div class="col-md-6">
                        <label for="bangunan_pengatur_buah" class="form-label fw-semibold">Bangunan Pengatur (Buah)</label>
                        <input type="number" step="1" name="bangunan_pengatur_buah" id="bangunan_pengatur_buah" class="form-control" placeholder="0" value="{{ old('bangunan_pengatur_buah') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="bangunan_pelengkap_buah" class="form-label fw-semibold">Bangunan Pelengkap (Buah)</label>
                        <input type="number" step="1" name="bangunan_pelengkap_buah" id="bangunan_pelengkap_buah" class="form-control" placeholder="0" value="{{ old('bangunan_pelengkap_buah') }}">
                    </div>

                    {{-- Saluran Pasangan --}}
                    <div class="col-md-6">
                        <label for="saluran_pasangan_m" class="form-label fw-semibold">Saluran Pasangan (m)</label>
                        <input type="number" step="0.01" name="saluran_pasangan_m" id="saluran_pasangan_m" class="form-control" placeholder="0.00" value="{{ old('saluran_pasangan_m') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="saluran_pasangan_km" class="form-label fw-semibold">Saluran Pasangan (km)</label>
                        <input type="number" step="0.001" name="saluran_pasangan_km" id="saluran_pasangan_km" class="form-control" placeholder="0.000" value="{{ old('saluran_pasangan_km') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. PETA INTERAKTIF SKEMA / LOKASI --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-map-fill me-2"></i>Peta Skema & Lokasi Irigasi</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="latitude" class="form-label fw-semibold">Latitude (Garis Lintang)</label>
                        <input type="text" name="latitude" id="latitude" class="form-control bg-light" placeholder="Klik pada peta di bawah..." value="{{ old('latitude') }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="longitude" class="form-label fw-semibold">Longitude (Garis Bujur)</label>
                        <input type="text" name="longitude" id="longitude" class="form-control bg-light" placeholder="Klik pada peta di bawah..." value="{{ old('longitude') }}" readonly>
                    </div>
                </div>

                {{-- Tampilan Peta --}}
                <div id="map" style="height: 380px; border-radius: 8px; z-index: 1;" class="border"></div>
                <small class="text-muted mt-2 d-block">
                    <i class="bi bi-info-circle me-1"></i><strong>Petunjuk:</strong> Peta otomatis mengarah ke Wilayah/Kecamatan yang dicentang. Klik titik pasti pada peta untuk mengisi Latitude & Longitude.
                </small>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('daerah-irigasi.index') }}" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Data</button>
        </div>
    </form>
</div>

<!-- Leaflet JS untuk Peta -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Inisialisasi Peta
    var initialLat = "{{ old('latitude', '-8.500000') }}";
    var initialLng = "{{ old('longitude', '117.400000') }}";
    
    var defaultLat = parseFloat(initialLat) || -8.500000;
    var defaultLng = parseFloat(initialLng) || 117.400000;
    var defaultZoom = "{{ old('latitude') }}" ? 13 : 9;

    var map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
        marker = L.marker([defaultLat, defaultLng]).addTo(map);
    }

    // Klik Peta Manual
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng]).addTo(map);
    });

    // 2. Fungsi Geocoding (Peta Bergerak Otomatis)
    function zoomToLocation(locationName, zoomLevel) {
        var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(locationName);

        fetch(url)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data && data.length > 0) {
                    var lat = parseFloat(data[0].lat);
                    var lon = parseFloat(data[0].lon);
                    map.flyTo([lat, lon], zoomLevel);
                }
            })
            .catch(function(error) { console.error('Gagal mengambil data lokasi:', error); });
    }

    // 3. Logic Checkbox Kabupaten
    var checkKabupatenList = document.querySelectorAll(".check-kabupaten");

    function toggleKecamatanGroup(checkbox) {
        var targetId = checkbox.getAttribute("data-target");
        var targetGroup = document.getElementById(targetId);

        if (targetGroup) {
            if (checkbox.checked) {
                targetGroup.classList.remove("d-none");
                zoomToLocation(checkbox.value + ", NTB, Indonesia", 10);
            } else {
                targetGroup.classList.add("d-none");
                var subCheckboxes = targetGroup.querySelectorAll("input[type='checkbox']");
                for (var i = 0; i < subCheckboxes.length; i++) {
                    subCheckboxes[i].checked = false;
                }
            }
        }
    }

    for (var i = 0; i < checkKabupatenList.length; i++) {
        var cbKab = checkKabupatenList[i];
        toggleKecamatanGroup(cbKab);

        cbKab.addEventListener("change", function () {
            toggleKecamatanGroup(this);
        });
    }

    // 4. Logic Checkbox Kecamatan
    var checkKecamatanList = document.querySelectorAll(".check-kecamatan");

    for (var j = 0; j < checkKecamatanList.length; j++) {
        checkKecamatanList[j].addEventListener("change", function () {
            if (this.checked) {
                var namaKec = this.value;
                var namaKab = this.getAttribute("data-kabupaten");
                
                zoomToLocation('Kecamatan ' + namaKec + ', ' + namaKab + ', NTB, Indonesia', 13);
            }
        });
    }
});
</script>
@endsection