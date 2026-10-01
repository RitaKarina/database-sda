<?php

namespace App\Http\Controllers;

use App\Models\Sungai;
use Illuminate\Http\Request;

class SungaiController extends Controller
{
    public function index()
    {
        $sungaiList = Sungai::latest()->get();
        return view('sungai.index', compact('sungaiList'));
    }

    public function create()
    {
        return view('sungai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sungai' => 'required|string|max:255',
            'panjang_km'  => 'nullable|numeric',
            'lokasi'      => 'nullable|string|max:255',
        ], [
            'nama_sungai.required' => 'Nama Sungai wajib diisi.',
            'panjang_km.numeric'   => 'Panjang Sungai harus berupa angka.',
        ]);

        Sungai::create([
            'nama_sungai' => $request->nama_sungai,
            'panjang_km'  => $request->panjang_km,
            'lokasi'      => $request->lokasi,
        ]);

        return redirect()->route('sungai.index')->with('success', 'Data sungai berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $sungai = Sungai::findOrFail($id);
        $sungai->delete();

        return redirect()->route('sungai.index')->with('success', 'Data sungai berhasil dihapus!');
    }
}