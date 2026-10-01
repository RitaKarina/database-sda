<?php

namespace App\Http\Controllers;

use App\Models\Bendungan;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

class BendunganController extends Controller
{
    public function index(Request $request)
{
    $kabupatens = Kabupaten::all();

    $query = Bendungan::with('kabupaten');

    // Filter Pencarian Nama
    if ($request->filled('search')) {
        $query->where('nama_bendungan', 'like', '%' . $request->search . '%');
    }

    // Filter Kabupaten
    if ($request->filled('kabupaten_id')) {
        $query->where('kabupaten_id', $request->kabupaten_id);
    }

    $bendungans = $query->latest()->get();

    return view('bendungan.index', compact('bendungans', 'kabupatens'));
}

    public function create()
    {
        $kabupatens = Kabupaten::all();
        return view('bendungan.create', compact('kabupatens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bendungan' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan' => 'required|string|max:255',
            'sungai' => 'nullable|string|max:255',
            'kapasitas_tampung' => 'nullable|numeric',
            'tinggi_bendungan' => 'nullable|numeric',
            'tahun_mulai_operasi' => 'nullable|numeric|digits:4',
            'kondisi' => 'required|string',
            'status_fungsi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Bendungan::create($validated);

        return redirect()->route('bendungan.index')->with('success', 'Data Bendungan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $bendungan = Bendungan::with('kabupaten')->findOrFail($id);
        return view('bendungan.show', compact('bendungan'));
    }

    public function edit($id)
    {
        $bendungan = Bendungan::findOrFail($id);
        $kabupatens = Kabupaten::all();
        return view('bendungan.edit', compact('bendungan', 'kabupatens'));
    }

    public function update(Request $request, $id)
    {
        $bendungan = Bendungan::findOrFail($id);

        $validated = $request->validate([
            'nama_bendungan' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan' => 'required|string|max:255',
            'sungai' => 'nullable|string|max:255',
            'kapasitas_tampung' => 'nullable|numeric',
            'tinggi_bendungan' => 'nullable|numeric',
            'tahun_mulai_operasi' => 'nullable|numeric|digits:4',
            'kondisi' => 'required|string',
            'status_fungsi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $bendungan->update($validated);

        return redirect()->route('bendungan.index')->with('success', 'Data Bendungan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bendungan = Bendungan::findOrFail($id);
        $bendungan->delete();

        return redirect()->route('bendungan.index')->with('success', 'Data Bendungan berhasil dihapus!');
    }
}