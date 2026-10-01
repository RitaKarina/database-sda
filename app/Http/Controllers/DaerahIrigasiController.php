<?php

namespace App\Http\Controllers;

use App\Models\DaerahIrigasi;
use Illuminate\Http\Request;

class DaerahIrigasiController extends Controller
{
    /**
     * Helper privat untuk menyediakan daftar Kabupaten & Kecamatan.
     */
    private function getDataKabupaten()
    {
        return [
            'Sumbawa' => ['Alas', 'Alas Barat', 'Batu Lanteh', 'Empang', 'Lape', 'Lopok', 'Moyo Hilir', 'Moyo Utara', 'Plimbang', 'Rhee', 'Sumbawa', 'Tarano', 'Utan'],
            'Sumbawa Barat' => ['Brang Ene', 'Brang Rea', 'Jikotang', 'Maluk', 'Poto Tano', 'Sekongkang', 'Seteluk', 'Taliwang'],
            'Bima' => ['Bolo', 'Donggo', 'Langgudu', 'Madapangga', 'Monta', 'Palibelo', 'Sape', 'Wawo', 'Woha'],
            'Dompu' => ['Dompu', 'Hu\'u', 'Kilo', 'Manga Fara', 'Pajo', 'Pekat', 'Woja'],
            'Kota Bima' => ['Asakota', 'Mpunda', 'Raba', 'Rasanae Barat', 'Rasanae Timur'],
            'Lombok Timur' => ['Aikmel', 'Jerowaru', 'Keruak', 'Labuhan Haji', 'Masbagik', 'Pringgabaya', 'Selong', 'Sikur', 'Terara'],
            'Lombok Tengah' => ['Batukliwon', 'Janapria', 'Jonggat', 'Kopang', 'Praya', 'Praya Barat', 'Praya Timur', 'Pujut'],
            'Lombok Barat' => ['Batu Layar', 'Gerung', 'Kediri', 'Kuripan', 'Labuapi', 'Lembar', 'Narmada', 'Sekotong'],
            'Lombok Utara' => ['Bayan', 'Gangga', 'Kayangan', 'Pamenang', 'Tanjung'],
            'Kota Mataram' => ['Ampenan', 'Cakranegara', 'Mataram', 'Sandubaya', 'Sekarbela', 'Selaparang'],
        ];
    }

    /**
     * Menampilkan halaman utama tabel Daerah Irigasi.
     */
    public function index()
    {
        $daerahIrigasis = DaerahIrigasi::latest()->paginate(10);
        return view('daerah_irigasi.index', compact('daerahIrigasis'));
    }

    /**
     * Menampilkan form Tambah Data.
     */
    public function create()
    {
        $dataKabupaten = $this->getDataKabupaten();
        return view('daerah_irigasi.create', compact('dataKabupaten'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_di'                   => 'required|string|max:255',
            'kode_di'                   => 'nullable|string|max:100',
            'kabupaten'                 => 'nullable',
            'kecamatan'                 => 'nullable',
            'luas_baku'                 => 'nullable|numeric',
            'luas_fungsional'           => 'nullable|numeric',
            'ip'                        => 'nullable|numeric',
            'iksi'                      => 'nullable|numeric',
            'tahun_dokumen_perencanaan' => 'nullable|string|max:4',
            'kewenangan'                => 'nullable|string|max:255',
            'sumber_air'                => 'nullable|string|max:255',
            'bendung'                   => 'nullable|string|max:255',
        ]);

        DaerahIrigasi::create($validatedData);

        return redirect()->route('daerah-irigasi.index')
                         ->with('success', 'Data Daerah Irigasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data.
     */
    public function show($id)
    {
        $daerahIrigasi = DaerahIrigasi::findOrFail($id);
        return view('daerah_irigasi.show', compact('daerahIrigasi'));
    }

    /**
     * Menampilkan form Edit Data.
     */
    public function edit($id)
    {
        $daerahIrigasi = DaerahIrigasi::findOrFail($id);
        $dataKabupaten = $this->getDataKabupaten();
        return view('daerah_irigasi.edit', compact('daerahIrigasi', 'dataKabupaten'));
    }

    /**
     * Memperbarui data.
     */
    public function update(Request $request, $id)
    {
        $daerahIrigasi = DaerahIrigasi::findOrFail($id);

        $validatedData = $request->validate([
            'nama_di'                   => 'required|string|max:255',
            'kode_di'                   => 'nullable|string|max:100',
            'kabupaten'                 => 'nullable',
            'kecamatan'                 => 'nullable',
            'luas_baku'                 => 'nullable|numeric',
            'luas_fungsional'           => 'nullable|numeric',
            'ip'                        => 'nullable|numeric',
            'iksi'                      => 'nullable|numeric',
            'tahun_dokumen_perencanaan' => 'nullable|string|max:4',
            'kewenangan'                => 'nullable|string|max:255',
            'sumber_air'                => 'nullable|string|max:255',
            'bendung'                   => 'nullable|string|max:255',
        ]);

        $daerahIrigasi->update($validatedData);

        return redirect()->route('daerah-irigasi.index')
                         ->with('success', 'Data Daerah Irigasi berhasil diperbarui.');
    }

    /**
     * Menghapus data.
     */
    public function destroy($id)
    {
        $daerahIrigasi = DaerahIrigasi::findOrFail($id);
        $daerahIrigasi->delete();

        return redirect()->route('daerah-irigasi.index')
                         ->with('success', 'Data Daerah Irigasi berhasil dihapus.');
    }

    /**
     * Export / Cetak Dokumen PDF.
     */
    public function export($id)
    {
        $daerahIrigasi = DaerahIrigasi::findOrFail($id);
        return view('daerah_irigasi.export_pdf', compact('daerahIrigasi'));
    }
}