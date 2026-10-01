<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaerahIrigasi extends Model
{
    use HasFactory;

    protected $table = 'daerah_irigasis';

    protected $fillable = [
        'nama_di',
        'kode_di',
        'kabupaten',
        'kecamatan',
        'luas_baku',
        'luas_potensial',
        'luas_fungsional',
        'ip',
        'iksi',
        'tahun_dokumen_perencanaan',
        'kewenangan',
        'sumber_air',
        'bendung',
        'tahun_rehabilitasi',
        'tahun_epaksi',
        'status_fungsi',
        'saluran_primer',
        'saluran_sekunder',
        'saluran_tersier',
        'bangunan_bagi',
        'bangunan_sadap',
        'bangunan_pelengkap',
        'panjang_saluran_total',
    ];

    protected $casts = [
        'kabupaten' => 'array',
        'kecamatan' => 'array',
    ];
}