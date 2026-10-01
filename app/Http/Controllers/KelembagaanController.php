<?php

namespace App\Http\Controllers;

use App\Models\Kelembagaan;
use Illuminate\Http\Request;

class KelembagaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelembagaan::query();

        if ($request->filled('search')) {
            $query->where('nama_lembaga', 'like', '%' . $request->search . '%');
        }

        $kelembagaans = $query->latest()->get();
        return view('kelembagaan.index', compact('kelembagaans'));
    }

    public function create()
    {
        return view('kelembagaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'jenis_lembaga' => 'required|string',
            'nomor_sk' => 'nullable|string|max:255',
            'status_keaktifan' => 'required|string',
            'tusi' => 'nullable|string',
            'data_rtt' => 'nullable|string',
            'data_raat' => 'nullable|string',
        ]);

        Kelembagaan::create($validated);
        return redirect()->route('kelembagaan.index')->with('success', 'Data Kelembagaan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $lembaga = Kelembagaan::findOrFail($id);
        $lembaga->delete();
        return redirect()->route('kelembagaan.index')->with('success', 'Data berhasil dihapus!');
    }
}