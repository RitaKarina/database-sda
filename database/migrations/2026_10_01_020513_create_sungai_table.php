<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sungai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sungai');
            $table->decimal('panjang_km', 8, 2)->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sungai');
    }
};