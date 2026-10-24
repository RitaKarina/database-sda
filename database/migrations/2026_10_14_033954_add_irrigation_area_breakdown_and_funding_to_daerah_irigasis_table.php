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
        Schema::table('daerah_irigasis', function (Blueprint $table) {
            $table->decimal('luas_baku_permen_14', 12, 2)->nullable();
            $table->decimal('luas_fungsional_irigasi_teknis', 12, 2)->nullable();
            $table->decimal('luas_fungsional_irigasi_non_teknis', 12, 2)->nullable();
            $table->string('sumber_dana_penanganan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daerah_irigasis', function (Blueprint $table) {
            $table->dropColumn([
                'luas_baku_permen_14',
                'luas_fungsional_irigasi_teknis',
                'luas_fungsional_irigasi_non_teknis',
                'sumber_dana_penanganan',
            ]);
        });
    }
};
