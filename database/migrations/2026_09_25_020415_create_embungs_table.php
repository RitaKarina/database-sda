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
            $table->unsignedBigInteger('kabupaten_id')->nullable();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->decimal('volume_tampungan', 15, 2)->nullable();
            $table->decimal('luas_genangan', 15, 2)->nullable();
            $table->string('sumber_air')->nullable();
            $table->integer('tahun_pembangunan')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('status_fungsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('embungs');
    }
};
