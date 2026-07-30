<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('anc_visits', function (Blueprint $table) {
            // Pemeriksaan Bayi extra
            $table->string('kepala_thd')->nullable()->after('djj');
            $table->text('konseling')->nullable()->after('jumlah_janin');

            // Pelayanan extra
            $table->boolean('injeksi_tt')->default(false)->after('status_imunisasi_tt');
            $table->boolean('pmk_bumil_kek')->default(false)->after('pmt_bumil');

            // Laboratorium extra
            $table->enum('anemia', ['+', '-'])->nullable()->after('hb');
            $table->string('thalasemia')->nullable()->after('gula_darah');

            // Integrasi Program - PPIA detail
            $table->boolean('datang_dengan_hiv')->default(false)->after('hbsag');
            $table->boolean('ditawarkan_tes_hiv')->default(false)->after('datang_dengan_hiv');
            $table->enum('hasil_hiv', ['+', '-'])->nullable()->after('ditawarkan_tes_hiv');
            $table->boolean('mendapatkan_arv')->default(false)->after('hasil_hiv');

            // Malaria detail
            $table->boolean('diberikan_kelambu')->default(false)->after('malaria');
            $table->enum('hasil_malaria', ['+', '-'])->nullable()->after('diberikan_kelambu');
            $table->string('obat_malaria')->nullable()->after('hasil_malaria');

            // TB detail
            $table->enum('hasil_tb', ['+', '-'])->nullable()->after('tb');
            $table->string('obat_tb')->nullable()->after('hasil_tb');

            // Ankylostoma
            $table->enum('ankylostoma', ['+', '-'])->nullable()->after('obat_tb');

            // IMS detail
            $table->boolean('diperiksa_ims')->default(false)->after('ims');
        });
    }

    public function down(): void
    {
        Schema::table('anc_visits', function (Blueprint $table) {
            $table->dropColumn([
                'kepala_thd',
                'konseling',
                'injeksi_tt',
                'pmk_bumil_kek',
                'anemia',
                'thalasemia',
                'datang_dengan_hiv',
                'ditawarkan_tes_hiv',
                'hasil_hiv',
                'mendapatkan_arv',
                'diberikan_kelambu',
                'hasil_malaria',
                'obat_malaria',
                'hasil_tb',
                'obat_tb',
                'ankylostoma',
                'diperiksa_ims',
            ]);
        });
    }
};
