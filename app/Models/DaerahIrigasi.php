<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DaerahIrigasi extends Model
{
    use HasFactory;

    protected $table = 'daerah_irigasis';

    protected $fillable = [
        'nama_di',
        'kode_di',
        'luas_baku',
        'luas_baku_igt',
        'luas_potensial',
        'luas_potensial_igt',
        'luas_fungsional',
        'luas_fungsional_igt',
        'luas_fungsional_teknis_igt',
        'luas_baku_permen_14',
        'luas_fungsional_irigasi_teknis',
        'luas_fungsional_irigasi_non_teknis',
        'sumber_dana_penanganan',
        'luas_irigasi_teknik',
        'luas_irigasi_non_teknik',
        'ip',
        'iksi',
        'tahun_dokumen_perencanaan',
        'tahun_epaksi',
        'status_fungsi',
        'kabupaten',
        'kecamatan',
        'kewenangan',
        'sumber_air',
        'nama_pengamat',
        'pengamat',
        'juru_pengairan',
        'petugas_operasi_bendungan',
        'petugas_pintu_bendung_air',
        'kebutuhan_pengamat',
        'ketersediaan_pengamat',
        'status_ketersediaan_pengamat',
        'p3a',
        'gp3a',
        'ip3a',
        'bendung_buah',
        'bendung',
        'saluran_primer_m',
        'saluran_primer_baik_m',
        'saluran_primer_sedang_m',
        'saluran_primer_buruk_m',
        'saluran_sekunder_m',
        'saluran_sekunder_baik_m',
        'saluran_sekunder_sedang_m',
        'saluran_sekunder_buruk_m',
        'saluran_tersier_m',
        'saluran_tersier_baik_m',
        'saluran_tersier_sedang_m',
        'saluran_tersier_buruk_m',
        'saluran_pembuang_m',
        'saluran_pembuang_baik_m',
        'saluran_pembuang_sedang_m',
        'saluran_pembuang_buruk_m',
        'bangunan_pengatur_buah',
        'bangunan_pelengkap_buah',
        'peta_skema_path',
        'skema_ruas_path',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'kabupaten' => 'array',
        'kecamatan' => 'array',
        'luas_baku' => 'float',
        'luas_baku_igt' => 'float',
        'luas_potensial' => 'float',
        'luas_potensial_igt' => 'float',
        'luas_fungsional' => 'float',
        'luas_fungsional_igt' => 'float',
        'luas_fungsional_teknis_igt' => 'float',
        'luas_baku_permen_14' => 'float',
        'luas_fungsional_irigasi_teknis' => 'float',
        'luas_fungsional_irigasi_non_teknis' => 'float',
        'luas_irigasi_teknik' => 'float',
        'luas_irigasi_non_teknik' => 'float',
        'ip' => 'float',
        'iksi' => 'float',
        'kebutuhan_pengamat' => 'float',
        'ketersediaan_pengamat' => 'float',
    ];

    protected $appends = [
        'kelengkapan_data',
    ];

    public function getKelengkapanDataAttribute(): int
    {
        $fieldsToTrack = [
            'nama_di', 'kode_di', 'luas_baku', 'luas_potensial', 'luas_fungsional',
            'luas_baku_igt', 'luas_potensial_igt', 'luas_fungsional_igt',
            'luas_baku_permen_14', 'luas_fungsional_irigasi_teknis', 'luas_fungsional_irigasi_non_teknis',
            'sumber_dana_penanganan', 'ip', 'iksi', 'tahun_dokumen_perencanaan',
            'tahun_epaksi', 'status_fungsi', 'kabupaten', 'kecamatan', 'kewenangan', 'sumber_air',
            'nama_pengamat', 'pengamat', 'juru_pengairan', 'petugas_operasi_bendungan', 'petugas_pintu_bendung_air',
            'kebutuhan_pengamat', 'ketersediaan_pengamat', 'p3a', 'gp3a', 'ip3a',
            'bendung_buah', 'bendung', 'saluran_primer_m', 'saluran_sekunder_m', 'saluran_tersier_m',
            'saluran_pembuang_m', 'latitude', 'longitude', 'peta_skema_path',
        ];

        $totalFields = count($fieldsToTrack);
        $filledFields = 0;

        foreach ($fieldsToTrack as $field) {
            $value = $this->attributes[$field] ?? null;

            if (! is_null($value) && $value !== '' && $value !== '[]' && $value !== []) {
                $filledFields++;
            }
        }

        return (int) round(($filledFields / $totalFields) * 100);
    }

    public function kelembagaans(): HasMany
    {
        return $this->hasMany(DaerahIrigasiKelembagaan::class);
    }
}
