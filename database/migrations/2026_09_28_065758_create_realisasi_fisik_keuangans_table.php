<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisasi_fisik_keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pekerjaan_id')->constrained('paket_pekerjaans')->onDelete('cascade');
            $table->integer('tahun');
            $table->decimal('realisasi_fisik_persen', 5, 2)->default(0); // Contoh: 95.50
            $table->decimal('realisasi_keuangan_rp', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasi_fisik_keuangans');
    }
};