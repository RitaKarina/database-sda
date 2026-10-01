<?php

namespace App\Http\Controllers;

use App\Models\PaketPekerjaan;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

class PaketPekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $kabupatens = Kabupaten::all();
        $query = PaketPekerjaan::with('kabupaten');

        if ($request->filled('search')) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tahun_anggaran')) {
            $query->where('tahun_anggaran', $request->tahun_anggaran);
        }

        $pakets = $query->latest()->get();
        return view('paket_pekerjaan.index', compact('pakets', 'kabupatens'));
    }

    public function create()
    {
        $kabupatens = Kabupaten::all();
        return view('paket_pekerjaan.create', compact('kabupatens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kabupaten_id' => 'nullable|exists:kabupatens,id',
            'tahun_anggaran' => 'required|numeric|digits:4',
            'pagu_anggaran' => 'required|numeric',
            'nilai_kontrak' => 'required|numeric',
            'kontraktor' => 'nullable|string|max:255',
            'sumber_dana' => 'required|string',
            'status_pekerjaan' => 'required|string',
        ]);

        PaketPekerjaan::create($validated);
        return redirect()->route('paket-pekerjaan.index')->with('success', 'Data Paket Pekerjaan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $paket = PaketPekerjaan::findOrFail($id);
        $paket->delete();
        return redirect()->route('paket-pekerjaan.index')->with('success', 'Data berhasil dihapus!');
    }
}