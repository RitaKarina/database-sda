<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiFisikKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'paket_pekerjaan_id',
        'tahun',
        'realisasi_fisik_persen',
        'realisasi_keuangan_rp',
        'keterangan'
    ];

    public function paketPekerjaan()
    {
        return $this->belongsTo(PaketPekerjaan::class);
    }
}