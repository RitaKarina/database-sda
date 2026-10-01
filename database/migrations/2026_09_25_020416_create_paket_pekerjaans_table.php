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
        Schema::create('paket_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupatens')->onDelete('cascade');
            $table->integer('tahun_anggaran'); // 5 tahun terakhir
            $table->decimal('pagu_anggaran', 15, 2)->default(0);
            $table->decimal('nilai_kontrak', 15, 2)->default(0);
            $table->string('kontraktor')->nullable();
            $table->string('sumber_dana')->default('APBD'); // APBD / APBN
            $table->string('status_pekerjaan')->default('Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_pekerjaans');
    }
};