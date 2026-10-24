<?php

namespace Database\Seeders;

use App\Models\DaerahIrigasi;
use App\Models\Embung;
use App\Models\Kabupaten;
use App\Models\PaketPekerjaan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $kab1 = Kabupaten::firstOrCreate(['nama_kabupaten' => 'Sumbawa']);
        $kab2 = Kabupaten::firstOrCreate(['nama_kabupaten' => 'Sumbawa Barat']);

        $di1 = DaerahIrigasi::firstOrCreate(
            ['nama_di' => 'DI Batu Bulan'],
            [
                'kabupaten' => [$kab1->nama_kabupaten],
                'kecamatan' => ['Moyo Hulu'],
                'luas_baku' => 5120.50,
                'luas_potensial' => 5500.00,
                'luas_fungsional' => 5000.00,
                'kewenangan' => 'Provinsi',
                'sumber_air' => 'Sungai Brang Moyo',
                'bendung' => 'Bendung Batu Bulan',
                'tahun_epaksi' => '2024',
                'status_fungsi' => 'Aktif',
            ]
        );

        $embung1 = Embung::firstOrCreate(
            ['nama_embung' => 'Embung Jereweh'],
            [
                'kabupaten_id' => $kab2->id,
                'kabupaten' => $kab2->nama_kabupaten,
                'kecamatan' => 'Jereweh',
                'desa' => 'Dasan Anyar',
                'luas_genangan' => 25.50,
                'volume_tampungan' => 150000,
                'tahun_pembangunan' => 2018,
                'kondisi' => 'Baik',
                'status_fungsi' => 'Sudah OP',
                'keterangan' => 'Fungsi: Irigasi, Air Baku',
            ]
        );

        PaketPekerjaan::firstOrCreate(
            ['nama_paket' => 'Rehabilitasi Jaringan Irigasi DI Batu Bulan'],
            [
                'kabupaten_id' => $kab1->id,
                'tahun_anggaran' => 2026,
                'pagu_anggaran' => 2500000000,
                'nilai_kontrak' => 2500000000,
                'sumber_dana' => 'APBD',
                'status_pekerjaan' => 'Berjalan',
            ]
        );
    }
}
