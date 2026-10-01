<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RealisasiFisikKeuangan; // Sesuaikan dengan nama Model Anda

class RealisasiFisikKeuanganController extends Controller
{
    /**
     * Menampilkan daftar realisasi & filter tahun.
     */
    public function index(Request $request)
    {
        $query = RealisasiFisikKeuangan::query();

        // Filter berdasarkan tahun jika ada request
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $realisasiList = $query->latest()->get();

        // Mengembalikan view 'realisasi.index' atau 'realisasi' sesuai struktur view Anda
        return view('realisasi.index', compact('realisasiList'));
    }

    /**
     * Menyimpan data realisasi baru dari form / modal popup.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket'         => 'required|string|max:255',
            'pagu'               => 'required|numeric',
            'tahun'              => 'required|integer',
            'realisasi_fisik'    => 'nullable|numeric',
            'realisasi_keuangan' => 'nullable|numeric',
        ]);

        RealisasiFisikKeuangan::create([
            'nama_paket'         => $request->nama_paket,
            'pagu'               => $request->pagu,
            'tahun'              => $request->tahun,
            'realisasi_fisik'    => $request->realisasi_fisik ?? 0,
            'realisasi_keuangan' => $request->realisasi_keuangan ?? 0,
        ]);

        return redirect()->route('realisasi.index')->with('success', 'Data realisasi berhasil ditambahkan!');
    }

    /**
     * Menghapus data realisasi.
     */
    public function destroy($id)
    {
        $realisasi = RealisasiFisikKeuangan::findOrFail($id);
        $realisasi->delete();

        return redirect()->route('realisasi.index')->with('success', 'Data realisasi berhasil dihapus!');
    }
}