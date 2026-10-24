<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daerah_irigasis', function (Blueprint $table): void {
            $table->string('skema_ruas_path')->nullable()->after('peta_skema_path');
        });
    }

    public function down(): void
    {
        Schema::table('daerah_irigasis', function (Blueprint $table): void {
            $table->dropColumn('skema_ruas_path');
        });
    }
};
