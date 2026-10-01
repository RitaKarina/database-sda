<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelembagaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga'); // P3A / GP3A / IP3A / Komisi Irigasi
            $table->string('jenis_lembaga'); // Komisi Irigasi, P3A, GP3A, IP3A
            $table->string('nomor_sk')->nullable();
            $table->string('status_keaktifan')->default('Aktif');
            $table->text('tusi')->nullable(); // Tugas dan Fungsi
            $table->text('data_rtt')->nullable(); // Rencana Tata Tanam
            $table->text('data_raat')->nullable(); // Rencana Alokasi Air Tahunan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelembagaans');
    }
};