<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketPekerjaan extends Model
{
    protected $guarded = ['id'];

    public function daerahIrigasi()
    {
        return $this->belongsTo(DaerahIrigasi::class);
    }

    public function embung()
    {
        return $this->belongsTo(Embung::class);
    }
}