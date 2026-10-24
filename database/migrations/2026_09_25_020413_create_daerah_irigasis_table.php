<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daerah_irigasis', function (Blueprint $table) {
            $table->id();

            // Data Umum
            $table->string('nama_di');
            $table->string('kode_di')->nullable();
            $table->decimal('luas_baku', 12, 2)->nullable();
            $table->decimal('luas_potensial', 12, 2)->nullable();
            $table->decimal('luas_fungsional', 12, 2)->nullable();
            $table->decimal('ip', 8, 2)->nullable();
            $table->decimal('iksi', 8, 2)->nullable();
            $table->string('tahun_dokumen_perencanaan')->nullable();
            $table->string('tahun_epaksi')->nullable();
            $table->string('status_fungsi')->nullable();
            $table->json('kabupaten')->nullable();
            $table->json('kecamatan')->nullable();
            $table->string('kewenangan')->nullable();
            $table->string('sumber_air')->nullable();

            // Data Kelembagaan
            $table->string('pengamat_pengairan')->nullable();
            $table->string('p3a')->nullable();
            $table->string('gp3a')->nullable();
            $table->string('ip3a')->nullable();

            // Data Infrastruktur & Saluran
            $table->integer('bendung_buah')->nullable();
            $table->string('bendung')->nullable();
            $table->decimal('saluran_primer_m', 12, 2)->nullable();
            $table->decimal('saluran_primer_km', 12, 2)->nullable();
            $table->decimal('saluran_sekunder_m', 12, 2)->nullable();
            $table->decimal('saluran_sekunder_km', 12, 2)->nullable();
            $table->decimal('saluran_suplai_m', 12, 2)->nullable();
            $table->decimal('saluran_suplai_km', 12, 2)->nullable();
            $table->decimal('saluran_pembuang_m', 12, 2)->nullable();
            $table->decimal('saluran_pembuang_km', 12, 2)->nullable();
            $table->integer('bangunan_pengatur_buah')->nullable();
            $table->integer('bangunan_pelengkap_buah')->nullable();
            $table->decimal('saluran_pasangan_m', 12, 2)->nullable();
            $table->decimal('saluran_pasangan_km', 12, 2)->nullable();

            // Koordinat Lokasi
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daerah_irigasis');
    }
};
