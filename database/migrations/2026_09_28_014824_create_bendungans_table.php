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
        Schema::create('bendungans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bendungan');
            $table->foreignId('kabupaten_id')->constrained('kabupatens')->onDelete('cascade');
            $table->string('kecamatan');
            $table->string('sungai')->nullable(); // Nama sungai / DAS
            $table->decimal('kapasitas_tampung', 15, 2)->nullable(); // m3
            $table->decimal('tinggi_bendungan', 8, 2)->nullable(); // meter
            $table->integer('tahun_mulai_operasi')->nullable();
            $table->string('kondisi')->default('Baik'); // Baik, Rusak Ringan, Rusak Berat
            $table->string('status_fungsi')->default('Berfungsi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bendungans');
    }
};