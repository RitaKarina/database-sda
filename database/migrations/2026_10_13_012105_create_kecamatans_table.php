<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table): void {
            $table->id();
            $table->string('kode_kecamatan')->unique();
            $table->string('kabupaten')->index();
            $table->string('nama_kecamatan');
            $table->timestamps();
            $table->unique(['kabupaten', 'nama_kecamatan']);
        });

        $wilayah = [
            '5201' => ['Lombok Barat', [
                '5201010' => 'Sekotong', '5201011' => 'Lembar', '5201020' => 'Gerung',
                '5201030' => 'Labuapi', '5201040' => 'Kediri', '5201041' => 'Kuripan',
                '5201050' => 'Narmada', '5201051' => 'Lingsar', '5201060' => 'Gunungsari',
                '5201061' => 'Batulayar',
            ]],
            '5202' => ['Lombok Tengah', [
                '5202010' => 'Praya Barat', '5202011' => 'Praya Barat Daya', '5202020' => 'Pujut',
                '5202030' => 'Praya Timur', '5202040' => 'Janapria', '5202050' => 'Kopang',
                '5202060' => 'Praya', '5202061' => 'Praya Tengah', '5202070' => 'Jonggat',
                '5202080' => 'Pringgarata', '5202090' => 'Batukliang', '5202091' => 'Batukliang Utara',
            ]],
            '5203' => ['Lombok Timur', [
                '5203010' => 'Keruak', '5203011' => 'Jerowaru', '5203020' => 'Sakra',
                '5203021' => 'Sakra Barat', '5203022' => 'Sakra Timur', '5203030' => 'Terara',
                '5203031' => 'Montong Gading', '5203040' => 'Sikur', '5203050' => 'Masbagik',
                '5203051' => 'Pringgasela', '5203060' => 'Sukamulia', '5203061' => 'Suralaga',
                '5203070' => 'Selong', '5203071' => 'Labuhan Haji', '5203080' => 'Pringgabaya',
                '5203081' => 'Suela', '5203090' => 'Aikmel', '5203091' => 'Wanasaba',
                '5203092' => 'Sembalun', '5203093' => 'Lenek', '5203100' => 'Sambelia',
            ]],
            '5204' => ['Sumbawa', [
                '5204020' => 'Lunyuk', '5204021' => 'Orong Telu', '5204050' => 'Alas',
                '5204051' => 'Alas Barat', '5204052' => 'Buer', '5204061' => 'Utan',
                '5204062' => 'Rhee', '5204070' => 'Batu Lanteh', '5204080' => 'Sumbawa',
                '5204081' => 'Labuhan Badas', '5204082' => 'Unter Iwes', '5204090' => 'Moyo Hilir',
                '5204091' => 'Moyo Utara', '5204100' => 'Moyo Hulu', '5204110' => 'Ropang',
                '5204111' => 'Lenangguar', '5204112' => 'Lantung', '5204121' => 'Lape',
                '5204122' => 'Lopok', '5204130' => 'Plampang', '5204131' => 'Labangka',
                '5204132' => 'Maronge', '5204140' => 'Empang', '5204141' => 'Tarano',
            ]],
            '5205' => ['Dompu', [
                '5205010' => "Hu'u", '5205011' => 'Pajo', '5205020' => 'Dompu',
                '5205030' => 'Woja', '5205040' => 'Kilo', '5205050' => 'Kempo',
                '5205051' => 'Manggelewa', '5205060' => 'Pekat',
            ]],
            '5206' => ['Bima', [
                '5206010' => 'Monta', '5206011' => 'Parado', '5206020' => 'Bolo',
                '5206021' => 'Madapangga', '5206030' => 'Woha', '5206040' => 'Belo',
                '5206041' => 'Palibelo', '5206050' => 'Wawo', '5206051' => 'Langgudu',
                '5206052' => 'Lambitu', '5206060' => 'Sape', '5206061' => 'Lambu',
                '5206070' => 'Wera', '5206071' => 'Ambalawi', '5206080' => 'Donggo',
                '5206081' => 'Soromandi', '5206090' => 'Sanggar', '5206091' => 'Tambora',
            ]],
            '5207' => ['Sumbawa Barat', [
                '5207010' => 'Sekongkang', '5207020' => 'Jereweh', '5207021' => 'Maluk',
                '5207030' => 'Taliwang', '5207031' => 'Brang Ene', '5207040' => 'Brang Rea',
                '5207050' => 'Seteluk', '5207051' => 'Poto Tano',
            ]],
            '5208' => ['Lombok Utara', [
                '5208010' => 'Pemenang', '5208020' => 'Tanjung', '5208030' => 'Gangga',
                '5208040' => 'Kayangan', '5208050' => 'Bayan',
            ]],
            '5271' => ['Kota Mataram', [
                '5271010' => 'Ampenan', '5271011' => 'Sekarbela', '5271020' => 'Mataram',
                '5271021' => 'Selaparang', '5271030' => 'Cakranegara', '5271031' => 'Sandubaya',
            ]],
            '5272' => ['Kota Bima', [
                '5272010' => 'Rasanae Barat', '5272011' => 'Mpunda', '5272020' => 'Rasanae Timur',
                '5272021' => 'Raba', '5272030' => 'Asakota',
            ]],
        ];

        $now = now();
        $rows = [];

        foreach ($wilayah as [$kabupaten, $kecamatanList]) {
            foreach ($kecamatanList as $kodeKecamatan => $namaKecamatan) {
                $rows[] = [
                    'kode_kecamatan' => $kodeKecamatan,
                    'kabupaten' => $kabupaten,
                    'nama_kecamatan' => $namaKecamatan,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('kecamatans')->insert($chunk);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
