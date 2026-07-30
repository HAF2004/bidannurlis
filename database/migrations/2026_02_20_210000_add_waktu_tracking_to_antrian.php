<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('antrian', function (Blueprint $table) {
            $table->time('waktu_dipanggil')->nullable()->after('estimasi_dilayani');
            $table->time('waktu_dilayani')->nullable()->after('waktu_dipanggil');
            $table->time('waktu_selesai')->nullable()->after('waktu_dilayani');
            $table->integer('durasi_aktual')->nullable()->after('waktu_selesai'); // menit
        });
    }

    public function down(): void
    {
        Schema::table('antrian', function (Blueprint $table) {
            $table->dropColumn(['waktu_dipanggil', 'waktu_dilayani', 'waktu_selesai', 'durasi_aktual']);
        });
    }
};
