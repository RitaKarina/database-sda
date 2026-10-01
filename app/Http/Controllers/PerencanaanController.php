<?php

namespace App\Http\Controllers;

use App\Models\Perencanaan;
use Illuminate\Http\Request;

class PerencanaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perencanaan::query();

        if ($request->filled('search')) {
            $query->where('usulan_kegiatan', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori_perencanaan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_perencanaan', $request->tahun);
        }

        $perencanaans = $query->latest()->paginate(10);

        return view('perencanaan.index', compact('perencanaans'));
    }

    public function create()
    {
        return view('perencanaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usulan_kegiatan' => 'required|string|max:255',
            'kategori_perencanaan' => 'required',
            'tahun_perencanaan' => 'required|integer',
            'status_ded' => 'required',
            'status_rc' => 'required',
        ]);

        Perencanaan::create($request->all());

        return redirect()->route('perencanaan.index')->with('success', 'Data Perencanaan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $perencanaan = Perencanaan::findOrFail($id);
        $perencanaan->delete();

        return redirect()->route('perencanaan.index')->with('success', 'Data Perencanaan berhasil dihapus!');
    }
}