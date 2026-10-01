<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daerah_irigasis', function (Blueprint $table) {
            $table->id();
            
            // Informasi Utama
            $table->string('nama_di');
            $table->string('kode_di')->nullable();
            
            // Wilayah
            $table->json('kabupaten')->nullable();
            $table->json('kecamatan')->nullable();
            
            // Luas Area
            $table->decimal('luas_baku', 10, 2)->default(0);
            $table->decimal('luas_potensial', 10, 2)->nullable();
            $table->decimal('luas_fungsional', 10, 2)->nullable();
            
            // Indikator Pertanaman & IKSI
            $table->decimal('ip', 5, 2)->nullable(); // Indeks Pertanaman (%)
            $table->decimal('iksi', 5, 2)->nullable(); // Nilai IKSI
            $table->string('tahun_dokumen_perencanaan', 4)->nullable(); // Tahun Dokumen
            
            // Status & Kewenangan
            $table->string('kewenangan')->nullable();
            $table->string('sumber_air')->nullable();
            $table->string('bendung')->nullable();
            $table->integer('tahun_rehabilitasi')->nullable();
            $table->integer('tahun_epaksi')->nullable();
            $table->string('status_fungsi')->nullable();
            
            // Saluran (Km / M)
            $table->decimal('saluran_primer', 10, 2)->nullable();
            $table->decimal('saluran_sekunder', 10, 2)->nullable();
            $table->decimal('saluran_tersier', 10, 2)->nullable();
            $table->decimal('panjang_saluran_total', 10, 2)->nullable();
            
            // Jumlah Bangunan
            $table->integer('bangunan_bagi')->nullable();
            $table->integer('bangunan_sadap')->nullable();
            $table->integer('bangunan_pelengkap')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daerah_irigasis');
    }
};