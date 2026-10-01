<?php

namespace App\Http\Controllers;

use App\Models\DaerahIrigasi;
use App\Models\Embung;
use App\Models\Bendungan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIrigasi = DaerahIrigasi::count();
        $totalEmbung = Embung::count();
        $totalBendungan = Bendungan::count();

        // Hitung kondisi gabungan Embung & Bendungan
        $kondisiBaik = Embung::where('kondisi', 'Baik')->count() + Bendungan::where('kondisi', 'Baik')->count();
        $kondisiRusakRingan = Embung::where('kondisi', 'Rusak Ringan')->count() + Bendungan::where('kondisi', 'Rusak Ringan')->count();
        $kondisiRusakBerat = Embung::where('kondisi', 'Rusak Berat')->count() + Bendungan::where('kondisi', 'Rusak Berat')->count();

        return view('dashboard', compact(
            'totalIrigasi', 
            'totalEmbung', 
            'totalBendungan',
            'kondisiBaik',
            'kondisiRusakRingan',
            'kondisiRusakBerat'
        ));
    }
}