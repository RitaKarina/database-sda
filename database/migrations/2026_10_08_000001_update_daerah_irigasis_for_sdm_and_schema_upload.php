<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daerah_irigasis', function (Blueprint $table) {
            $table->string('nama_pengamat')->nullable()->after('sumber_air');
            $table->string('pengamat')->nullable()->after('nama_pengamat');
            $table->string('juru_pengairan')->nullable()->after('pengamat');
            $table->string('petugas_operasi_bendungan')->nullable()->after('juru_pengairan');
            $table->string('petugas_pintu_bendung_air')->nullable()->after('petugas_operasi_bendungan');
            $table->decimal('kebutuhan_pengamat', 10, 2)->nullable()->after('petugas_pintu_bendung_air');
            $table->decimal('ketersediaan_pengamat', 10, 2)->nullable()->after('kebutuhan_pengamat');
            $table->string('status_ketersediaan_pengamat')->nullable()->after('ketersediaan_pengamat');

            $table->decimal('luas_baku_igt', 12, 2)->nullable()->after('luas_baku');
            $table->decimal('luas_potensial_igt', 12, 2)->nullable()->after('luas_potensial');
            $table->decimal('luas_fungsional_igt', 12, 2)->nullable()->after('luas_fungsional');
            $table->decimal('luas_fungsional_teknis_igt', 12, 2)->nullable()->after('luas_fungsional_igt');
            $table->decimal('luas_irigasi_teknik', 12, 2)->nullable()->after('luas_fungsional_teknis_igt');
            $table->decimal('luas_irigasi_non_teknik', 12, 2)->nullable()->after('luas_irigasi_teknik');

            $table->decimal('saluran_tersier_m', 12, 2)->nullable()->after('saluran_sekunder_m');
            $table->decimal('saluran_tersier_baik_m', 12, 2)->nullable()->after('saluran_tersier_m');
            $table->decimal('saluran_tersier_sedang_m', 12, 2)->nullable()->after('saluran_tersier_baik_m');
            $table->decimal('saluran_tersier_buruk_m', 12, 2)->nullable()->after('saluran_tersier_sedang_m');
            $table->decimal('saluran_primer_baik_m', 12, 2)->nullable()->after('saluran_primer_m');
            $table->decimal('saluran_primer_sedang_m', 12, 2)->nullable()->after('saluran_primer_baik_m');
            $table->decimal('saluran_primer_buruk_m', 12, 2)->nullable()->after('saluran_primer_sedang_m');
            $table->decimal('saluran_sekunder_baik_m', 12, 2)->nullable()->after('saluran_sekunder_m');
            $table->decimal('saluran_sekunder_sedang_m', 12, 2)->nullable()->after('saluran_sekunder_baik_m');
            $table->decimal('saluran_sekunder_buruk_m', 12, 2)->nullable()->after('saluran_sekunder_sedang_m');
            $table->decimal('saluran_pembuang_baik_m', 12, 2)->nullable()->after('saluran_pembuang_m');
            $table->decimal('saluran_pembuang_sedang_m', 12, 2)->nullable()->after('saluran_pembuang_baik_m');
            $table->decimal('saluran_pembuang_buruk_m', 12, 2)->nullable()->after('saluran_pembuang_sedang_m');

            $table->string('peta_skema_path')->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('daerah_irigasis', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pengamat',
                'pengamat',
                'juru_pengairan',
                'petugas_operasi_bendungan',
                'petugas_pintu_bendung_air',
                'kebutuhan_pengamat',
                'ketersediaan_pengamat',
                'status_ketersediaan_pengamat',
                'luas_baku_igt',
                'luas_potensial_igt',
                'luas_fungsional_igt',
                'luas_fungsional_teknis_igt',
                'luas_irigasi_teknik',
                'luas_irigasi_non_teknik',
                'saluran_tersier_m',
                'saluran_tersier_baik_m',
                'saluran_tersier_sedang_m',
                'saluran_tersier_buruk_m',
                'saluran_primer_baik_m',
                'saluran_primer_sedang_m',
                'saluran_primer_buruk_m',
                'saluran_sekunder_baik_m',
                'saluran_sekunder_sedang_m',
                'saluran_sekunder_buruk_m',
                'saluran_pembuang_baik_m',
                'saluran_pembuang_sedang_m',
                'saluran_pembuang_buruk_m',
                'peta_skema_path',
            ]);
        });
    }
};
