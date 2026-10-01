<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('embungs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_embung');
            $table->foreignId('kabupaten_id')->constrained('kabupatens')->onDelete('cascade');
            $table->string('kecamatan_desa');
            
            // Lokasi & Spesifikasi
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->decimal('luas_genangan', 10, 2)->nullable(); // Ha
            $table->decimal('volume_tampungan', 12, 2)->nullable(); // m3
            $table->integer('tahun_pembangunan')->nullable();
            $table->string('sumber_anggaran')->nullable(); // APBD, APBN, dll.
            
            // Fungsi (Array / Text JSON)
            $table->string('fungsi')->default('Irigasi'); // Irigasi, Air Baku, Konservasi, Pengendalian Banjir, Lainnya
            
            // Kondisi & Pemeliharaan
            $table->string('kondisi')->default('Baik'); // Baik, Rusak Ringan, Rusak Berat
            $table->string('status_op')->default('Aktif');
            $table->integer('tahun_terakhir_pemeliharaan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('embungs');
    }
};