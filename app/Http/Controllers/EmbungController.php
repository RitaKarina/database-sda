<?php

namespace App\Http\Controllers;

use App\Models\Embung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EmbungController extends Controller
{
    public function index(Request $request)
    {
        $query = Embung::query();

        if ($request->filled('search')) {
            $query->where('nama_embung', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('kabupaten_id')) {
            $query->where('kabupaten', 'like', '%'.$request->kabupaten_id.'%');
        }

        $embungs = $query->paginate(10);

        // Daftar Kabupaten untuk Filter di View
        $kabupatens = [
            'Lombok Timur', 'Lombok Barat', 'Lombok Tengah', 'Lombok Utara',
            'Kota Mataram', 'Bima', 'Kota Bima', 'Dompu', 'Sumbawa', 'Sumbawa Barat',
        ];

        return view('embung.index', compact('embungs', 'kabupatens'));
    }

    public function create()
    {
        $wilayahNtb = [
            'Lombok Timur' => ['Aikmel', 'Jerowaru', 'Keruak', 'Labuhan Haji', 'Masbagik', 'Montong Gading', 'Pringgabayang', 'Pringgasela', 'Sakra', 'Sakra Barat', 'Sakra Timur', 'Sambelia', 'Selong', 'Sembalun', 'Sikur', 'Suralaga', 'Terara', 'Wanasaba'],
            'Lombok Barat' => ['Batu Layar', 'Gerung', 'Gunungsari', 'Kediri', 'Kuripan', 'Labuapi', 'Lembar', 'Lingsar', 'Narmada', 'Sekotong'],
            'Lombok Tengah' => ['Batukliwon', 'Janapria', 'Jonggat', 'Kopang', 'Praya', 'Praya Barat', 'Praya Barat Daya', 'Praya Timur', 'Pringgarata', 'Pujut'],
            'Lombok Utara' => ['Bayan', 'Gangga', 'Kayangan', 'Pemenang', 'Tanjung'],
            'Kota Mataram' => ['Ampenan', 'Cakranegara', 'Mataram', 'Sandubaya', 'Sekarbela', 'Selaparang'],
            'Bima' => ['Ambalawi', 'Belo', 'Bolo', 'Donggo', 'Langgudu', 'Lambitu', 'Lambu', 'Mada Pangga', 'Monta', 'Palibelo', 'Parado', 'Sape', 'Soromandi', 'Tambora', 'Wawo', 'Woha'],
            'Kota Bima' => ['Asakota', 'Mpunda', 'Raba', 'Rasanae Barat', 'Rasanae Timur'],
            'Dompu' => ['Dompu', 'Huu', 'Kempo', 'Kilo', 'Manga Fara', 'Pajo', 'Pekat', 'Woja'],
            'Sumbawa' => ['Alang', 'Badang', 'Batu Lanteh', 'Empang', 'Lape', 'Lopok', 'Lunyuk', 'Moyo Hilir', 'Moyo Utara', 'Moyo Hulu', 'Plampang', 'Rhee', 'Ropang', 'Samber', 'Sekongkang', 'Sumbawa', 'Tarano', 'Utan'],
            'Sumbawa Barat' => ['Brang Rea', 'Brang Ene', 'Jilung', 'Maluk', 'Poto Tano', 'Seteluk', 'Sekongkang', 'Taliwang'],
        ];

        return view('embung.create', compact('wilayahNtb'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_embung' => 'required|string|max:255',
            'kabupaten' => 'nullable',
            'kecamatan' => 'nullable',
            'desa' => 'nullable|string|max:255',
            'volume_tampungan' => 'nullable|numeric',
            'luas_genangan' => 'nullable|numeric',
            'sumber_air' => 'nullable|string|max:255',
            'tahun_pembangunan' => 'nullable|numeric',
            'kondisi' => 'nullable|string|max:255',
            'status_fungsi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kabupatenText = is_array($request->kabupaten) ? implode(', ', $request->kabupaten) : $request->kabupaten;
        $kecamatanText = is_array($request->kecamatan) ? implode(', ', $request->kecamatan) : $request->kecamatan;

        $data = [
            'nama_embung' => $request->nama_embung,
            'desa' => $request->desa,
            'volume_tampungan' => $request->volume_tampungan,
            'luas_genangan' => $request->luas_genangan,
            'sumber_air' => $request->sumber_air,
            'tahun_pembangunan' => $request->tahun_pembangunan,
            'kondisi' => $request->kondisi,
            'status_fungsi' => $request->status_fungsi,
            'keterangan' => $request->keterangan,
        ];

        if (Schema::hasColumn('embungs', 'kabupaten')) {
            $data['kabupaten'] = $kabupatenText;
        }
        if (Schema::hasColumn('embungs', 'kecamatan')) {
            $data['kecamatan'] = $kecamatanText;
        }

        Embung::create($data);

        return redirect()->route('embung.index')->with('success', 'Data Embung berhasil disimpan!');
    }
}
