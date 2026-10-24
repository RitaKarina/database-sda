<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daerah_irigasi_kelembagaans', function (Blueprint $table): void {
            $table->string('jenis_kelembagaan', 10)->nullable()->after('daerah_irigasi_id');
        });

        $legacyRows = DB::table('daerah_irigasis')
            ->select('id', 'ip3a', 'gp3a', 'p3a')
            ->get();

        foreach ($legacyRows as $legacyRow) {
            foreach (['IP3A' => 'ip3a', 'GP3A' => 'gp3a', 'P3A' => 'p3a'] as $jenis => $field) {
                $nama = trim((string) ($legacyRow->{$field} ?? ''));

                if ($nama === '') {
                    continue;
                }

                $institution = DB::table('daerah_irigasi_kelembagaans')
                    ->where('daerah_irigasi_id', $legacyRow->id)
                    ->where('nama_kelembagaan', $nama)
                    ->whereNull('jenis_kelembagaan')
                    ->orderBy('id')
                    ->first();

                if ($institution) {
                    DB::table('daerah_irigasi_kelembagaans')
                        ->where('id', $institution->id)
                        ->update(['jenis_kelembagaan' => $jenis]);
                }
            }
        }

        $untypedRows = DB::table('daerah_irigasi_kelembagaans')
            ->whereNull('jenis_kelembagaan')
            ->get(['id', 'nama_kelembagaan']);

        foreach ($untypedRows as $institution) {
            if (preg_match('/^(IP3A|GP3A|P3A)(?=$|[\s:-])/i', trim($institution->nama_kelembagaan), $matches)) {
                DB::table('daerah_irigasi_kelembagaans')
                    ->where('id', $institution->id)
                    ->update(['jenis_kelembagaan' => strtoupper($matches[1])]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('daerah_irigasi_kelembagaans', function (Blueprint $table): void {
            $table->dropColumn('jenis_kelembagaan');
        });
    }
};
