<?php

namespace App\Http\Controllers;

use App\Models\DaerahIrigasi;
use App\Models\Embung;
use Illuminate\Contracts\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        $daerahIrigasi = DaerahIrigasi::query()
            ->select([
                'id',
                'nama_di',
                'kabupaten',
                'kecamatan',
                'luas_fungsional',
                'kewenangan',
                'status_fungsi',
            ])
            ->latest('id')
            ->paginate(10, ['*'], 'di_page');

        $embung = Embung::query()
            ->select([
                'id',
                'nama_embung',
                'kabupaten',
                'kecamatan',
                'desa',
                'volume_tampungan',
                'luas_genangan',
                'status_fungsi',
            ])
            ->orderBy('nama_embung')
            ->paginate(10, ['*'], 'embung_page');

        return view('public.home', [
            'totalDaerahIrigasi' => DaerahIrigasi::query()->count(),
            'totalEmbung' => Embung::query()->count(),
            'daerahIrigasi' => $daerahIrigasi,
            'embung' => $embung,
        ]);
    }
}
