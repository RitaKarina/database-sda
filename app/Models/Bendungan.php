<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bendungan extends Model
{
    use HasFactory;

    protected $table = 'bendungans';

    protected $fillable = [
        'nama_bendungan',
        'kabupaten_id',
        'kecamatan',
        'sungai',
        'kapasitas_tampung',
        'tinggi_bendungan',
        'tahun_mulai_operasi',
        'kondisi',
        'status_fungsi',
        'keterangan',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}