<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daerah_irigasi_kelembagaans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('daerah_irigasi_id')->constrained('daerah_irigasis')->cascadeOnDelete();
            $table->string('nama_kelembagaan');
            $table->string('ruas')->nullable();
            $table->timestamps();
        });

        $now = now();
        $legacyRows = DB::table('daerah_irigasis')
            ->select('id', 'ip3a', 'gp3a', 'p3a')
            ->get();
        $rows = [];

        foreach ($legacyRows as $legacyRow) {
            foreach (['ip3a', 'gp3a', 'p3a'] as $field) {
                $nama = trim((string) ($legacyRow->{$field} ?? ''));

                if ($nama !== '') {
                    $rows[] = [
                        'daerah_irigasi_id' => $legacyRow->id,
                        'nama_kelembagaan' => $nama,
                        'ruas' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('daerah_irigasi_kelembagaans')->insert($chunk);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('daerah_irigasi_kelembagaans');
    }
};
