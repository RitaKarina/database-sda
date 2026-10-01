<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embung extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_embung', 'kabupaten_id', 'kecamatan_desa',
        'latitude', 'longitude', 'luas_genangan', 'volume_tampungan',
        'tahun_pembangunan', 'sumber_anggaran', 'fungsi',
        'kondisi', 'status_op', 'tahun_terakhir_pemeliharaan'
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}