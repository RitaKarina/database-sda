<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embung extends Model
{
    use HasFactory;

    protected $table = 'embungs';

    protected $fillable = [
        'nama_embung',
        'kabupaten_id',
        'kecamatan_id',
        'kabupaten',
        'kecamatan',
        'desa',
        'volume_tampungan',
        'luas_genangan',
        'sumber_air',
        'tahun_pembangunan',
        'kondisi',
        'status_fungsi',
        'keterangan',
    ];
}
