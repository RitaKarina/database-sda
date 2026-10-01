<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kabupaten;
use App\Models\DaerahIrigasi;
use App\Models\Embung;
use App\Models\PaketPekerjaan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $kab1 = Kabupaten::create(['nama_kabupaten' => 'Sumbawa']);
        $kab2 = Kabupaten::create(['nama_kabupaten' => 'Sumbawa Barat']);

        $di1 = DaerahIrigasi::create([
            'kabupaten_id' => $kab1->id,
            'nama_di' => 'DI Batu Bulan',
            'kecamatan' => 'Moyo Hulu',
            'luas_layanan' => 5120.50,
            'luas_potensial' => 5500.00,
            'luas_fungsional' => 5000.00,
            'kewenangan' => 'Provinsi',
            'sumber_air' => 'Sungai Brang Moyo',
            'bendung' => 'Bendung Batu Bulan',
            'kondisi_jaringan' => 'Baik',
            'tahun_terakhir_rehabilitasi' => 2023,
            'tahun_e_paksi' => 2024,
            'status_fungsi' => 'Aktif'
        ]);

        $embung1 = Embung::create([
            'kabupaten_id' => $kab2->id,
            'nama_embung' => 'Embung Jereweh',
            'kecamatan_desa' => 'Jereweh / Dasan Anyar',
            'koordinat' => '-8.8500, 116.8500',
            'luas_genangan' => 25.50,
            'volume_tampungan' => 150000,
            'tahun_pembangunan' => 2018,
            'sumber_anggaran' => 'APBD Provinsi',
            'fungsi' => 'Irigasi, Air Baku',
            'kondisi' => 'Baik',
            'status_op' => 'Sudah OP',
            'tahun_terakhir_pemeliharaan' => 2022
        ]);

        PaketPekerjaan::create([
            'daerah_irigasi_id' => $di1->id,
            'nama_paket' => 'Rehabilitasi Jaringan Irigasi DI Batu Bulan',
            'tahun_anggaran' => 2026,
            'nilai_kontrak' => 2500000000,
            'status' => 'Berjalan'
        ]);
    }
}