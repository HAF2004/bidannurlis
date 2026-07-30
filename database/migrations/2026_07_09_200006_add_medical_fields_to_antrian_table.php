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
        Schema::table('antrian', function (Blueprint $table) {
            $table->string('jenis_layanan', 50)->nullable()->after('prioritas_id'); // Persalinan, KB, ANC, Imunisasi, Anak, Umum
            $table->integer('tensi_sistolik')->nullable()->after('keluhan');
            $table->integer('tensi_diastolik')->nullable()->after('tensi_sistolik');
            $table->decimal('berat_badan', 5, 2)->nullable()->after('tensi_diastolik');
            $table->boolean('is_override')->default(false)->after('berat_badan')->comment('True jika prioritas diubah manual oleh bidan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrian', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_layanan',
                'tensi_sistolik',
                'tensi_diastolik',
                'berat_badan',
                'is_override'
            ]);
        });
    }
};
