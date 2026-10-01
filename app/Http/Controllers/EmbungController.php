<?php

namespace App\Http\Controllers;

use App\Models\Embung;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

class EmbungController extends Controller
{
    public function index(Request $request)
{
    $kabupatens = Kabupaten::all();

    $query = Embung::with('kabupaten');

    // Filter Pencarian Nama
    if ($request->filled('search')) {
        $query->where('nama_embung', 'like', '%' . $request->search . '%');
    }

    // Filter Kabupaten
    if ($request->filled('kabupaten_id')) {
        $query->where('kabupaten_id', $request->kabupaten_id);
    }

    $embungs = $query->latest()->get();

    return view('embung.index', compact('embungs', 'kabupatens'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_embung' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'nullable|string|max:255',
            'volume_tampungan' => 'nullable|numeric',
            'luas_genangan' => 'nullable|numeric',
            'sumber_air' => 'nullable|string|max:255',
            'tahun_pembangunan' => 'nullable|numeric|digits:4',
            'kondisi' => 'required|string',
            'status_fungsi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Embung::create($validated);

        return redirect()->route('embung.index')->with('success', 'Data Embung berhasil ditambahkan!');
    }

    public function show($id)
    {
        $embung = Embung::with('kabupaten')->findOrFail($id);
        return view('embung.show', compact('embung'));
    }

    public function edit($id)
    {
        $embung = Embung::findOrFail($id);
        $kabupatens = Kabupaten::all();
        return view('embung.edit', compact('embung', 'kabupatens'));
    }

    public function update(Request $request, $id)
    {
        $embung = Embung::findOrFail($id);

        $validated = $request->validate([
            'nama_embung' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'nullable|string|max:255',
            'volume_tampungan' => 'nullable|numeric',
            'luas_genangan' => 'nullable|numeric',
            'sumber_air' => 'nullable|string|max:255',
            'tahun_pembangunan' => 'nullable|numeric|digits:4',
            'kondisi' => 'required|string',
            'status_fungsi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $embung->update($validated);

        return redirect()->route('embung.index')->with('success', 'Data Embung berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $embung = Embung::findOrFail($id);
        $embung->delete();

        return redirect()->route('embung.index')->with('success', 'Data Embung berhasil dihapus!');
    }
}