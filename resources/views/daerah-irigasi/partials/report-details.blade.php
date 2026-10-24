@php
    $sections = [
        'Informasi Utama' => [
            'nama_di' => 'Nama Daerah Irigasi',
            'kode_di' => 'Kode DI',
            'sumber_dana_penanganan' => 'Sumber Dana Penanganan',
            'luas_baku' => 'Luas Baku (Ha)',
            'luas_baku_igt' => 'Luas Baku IGT (Ha)',
            'luas_baku_permen_14' => 'Luas Baku Permen 14 (Ha)',
            'luas_potensial' => 'Luas Potensial (Ha)',
            'luas_potensial_igt' => 'Luas Potensial IGT (Ha)',
            'luas_fungsional' => 'Luas Fungsional (Ha)',
            'luas_fungsional_igt' => 'Luas Fungsional IGT (Ha)',
            'luas_fungsional_irigasi_teknis' => 'Luas Fungsional Irigasi Teknis (Ha)',
            'luas_fungsional_irigasi_non_teknis' => 'Luas Fungsional Irigasi Non Teknis (Ha)',
            'ip' => 'Indeks Pertanaman (IP)',
            'iksi' => 'IKSI',
            'tahun_dokumen_perencanaan' => 'Tahun Dokumen Perencanaan',
            'tahun_epaksi' => 'Tahun e-PAKSI',
            'status_fungsi' => 'Riwayat Penanganan (Tahun)',
            'kelengkapan_data' => 'Kelengkapan Data (%)',
        ],
        'Wilayah Administrasi' => [
            'kabupaten' => 'Kabupaten / Kota',
            'kecamatan' => 'Kecamatan',
            'kewenangan' => 'Kewenangan',
            'sumber_air' => 'Sumber Air',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ],
        'Organisasi Personalia' => [
            'nama_pengamat' => 'Nama Pengamat',
            'pengamat' => 'Pengamat',
            'pengamat_pengairan' => 'Pengamat Pengairan',
            'juru_pengairan' => 'Juru Pengairan',
            'petugas_operasi_bendungan' => 'Petugas Operasi Bendungan',
            'petugas_pintu_bendung_air' => 'Petugas Pintu Bendung Air',
            'kebutuhan_pengamat' => 'Kebutuhan Pengamat',
            'ketersediaan_pengamat' => 'Ketersediaan Pengamat',
            'status_ketersediaan_pengamat' => 'Status Ketersediaan Pengamat',
        ],
        'Data Teknis dan Infrastruktur' => [
            'bendung_buah' => 'Bendung (Buah)',
            'bendung' => 'Nama / Keterangan Bendung',
            'saluran_primer_m' => 'Saluran Primer Total (m)',
            'saluran_primer_km' => 'Saluran Primer (km)',
            'saluran_primer_baik_m' => 'Saluran Primer Baik (m)',
            'saluran_primer_sedang_m' => 'Saluran Primer Sedang (m)',
            'saluran_primer_buruk_m' => 'Saluran Primer Buruk (m)',
            'saluran_sekunder_m' => 'Saluran Sekunder Total (m)',
            'saluran_sekunder_km' => 'Saluran Sekunder (km)',
            'saluran_sekunder_baik_m' => 'Saluran Sekunder Baik (m)',
            'saluran_sekunder_sedang_m' => 'Saluran Sekunder Sedang (m)',
            'saluran_sekunder_buruk_m' => 'Saluran Sekunder Buruk (m)',
            'saluran_tersier_m' => 'Saluran Tersier Total (m)',
            'saluran_tersier_baik_m' => 'Saluran Tersier Baik (m)',
            'saluran_tersier_sedang_m' => 'Saluran Tersier Sedang (m)',
            'saluran_tersier_buruk_m' => 'Saluran Tersier Buruk (m)',
            'saluran_suplai_m' => 'Saluran Suplai (m)',
            'saluran_suplai_km' => 'Saluran Suplai (km)',
            'saluran_pembuang_m' => 'Saluran Pembuang Total (m)',
            'saluran_pembuang_km' => 'Saluran Pembuang (km)',
            'saluran_pembuang_baik_m' => 'Saluran Pembuang Baik (m)',
            'saluran_pembuang_sedang_m' => 'Saluran Pembuang Sedang (m)',
            'saluran_pembuang_buruk_m' => 'Saluran Pembuang Buruk (m)',
            'bangunan_pengatur_buah' => 'Bangunan Pengatur (Buah)',
            'bangunan_pelengkap_buah' => 'Bangunan Pelengkap (Buah)',
            'saluran_pasangan_m' => 'Saluran Pasangan (m)',
            'saluran_pasangan_km' => 'Saluran Pasangan (km)',
        ],
    ];
@endphp

<div class="report-record">
    <h2 class="record-title">{{ $item->nama_di ?: 'Daerah Irigasi' }}</h2>
    @foreach ($sections as $sectionTitle => $fields)
        <h3 class="section-title">{{ $sectionTitle }}</h3>
        <table class="report-table">
            <tbody>
                @foreach ($fields as $field => $label)
                    @php
                        $value = data_get($item, $field);
                        if (is_array($value)) {
                            $value = implode(', ', $value);
                        }
                    @endphp
                    <tr>
                        <th>{{ $label }}</th>
                        <td>{{ filled($value) ? $value : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <h3 class="section-title">Kelembagaan dan Ruas Kewenangan</h3>
    @if ($item->kelembagaans->isNotEmpty())
        <table class="report-table">
            <thead>
                <tr><th>Jenis Kelembagaan</th><th>Nama Kelembagaan</th><th>Ruas Kewenangan</th></tr>
            </thead>
            <tbody>
                @foreach ($item->kelembagaans as $institution)
                    <tr>
                        <td>{{ $institution->jenis_kelembagaan ?: 'Belum diklasifikasikan' }}</td>
                        <td>{{ $institution->nama_kelembagaan }}</td>
                        <td>{{ $institution->ruas ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>-</p>
    @endif

    <h3 class="section-title">Skema Ruas Kewenangan IP3A, GP3A, P3A</h3>
    @if ($item->skema_ruas_path)
        <p class="map-link">
            <a href="{{ Storage::url($item->skema_ruas_path) }}" target="_blank" rel="noopener">
                {{ basename($item->skema_ruas_path) }} (lihat / unduh)
            </a>
        </p>
    @else
        <p>-</p>
    @endif

    <h3 class="section-title">Peta Skema Jaringan dan Bangunan</h3>
    @if ($item->peta_skema_path)
        <p class="map-link">File: {{ basename($item->peta_skema_path) }} | {{ Storage::url($item->peta_skema_path) }}</p>
        <img class="scheme-preview" src="{{ Storage::url($item->peta_skema_path) }}" alt="Peta skema {{ $item->nama_di }}">
    @else
        <p>-</p>
    @endif
</div>