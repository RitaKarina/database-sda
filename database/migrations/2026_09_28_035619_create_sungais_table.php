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
        Schema::create('sungais', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sungai');
        $table->foreignId('kabupaten_id')->constrained('kabupatens')->onDelete('cascade');
        $table->decimal('panjang_sungai', 8, 2)->nullable(); // km
        $table->decimal('luas_das', 10, 2)->nullable(); // km2
        $table->string('orfe_sungai')->nullable();
        $table->string('status_kewenangan')->default('Provinsi');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sungais');
    }
};
