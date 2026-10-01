<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perencanaans', function (Blueprint $table) {
            $table->id();
            $table->string('usulan_kegiatan');
            $table->string('status_ded')->default('Belum Ada'); // Ada / Belum Ada
            $table->string('status_rc')->default('Belum Ada');  // Readiness Criteria
            $table->string('kategori_perencanaan'); // Renstra, RPJMD, Renja
            $table->integer('tahun_perencanaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perencanaans');
    }
};