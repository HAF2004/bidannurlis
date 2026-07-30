<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained()->cascadeOnDelete();

            // Fase Persalinan
            $table->date('kala1_aktif_tanggal')->nullable();
            $table->time('kala1_aktif_jam')->nullable();
            $table->date('kala2_tanggal')->nullable();
            $table->time('kala2_jam')->nullable();
            $table->date('bayi_lahir_tanggal')->nullable();
            $table->time('bayi_lahir_jam')->nullable();
            $table->date('plasenta_lahir_tanggal')->nullable();
            $table->time('plasenta_lahir_jam')->nullable();
            $table->decimal('perdarahan_kala_iv_cc', 8, 2)->nullable();

            // Kehamilan & Kondisi
            $table->integer('usia_kehamilan_minggu')->nullable();
            $table->enum('keadaan_ibu', ['Hidup', 'Mati'])->nullable();
            $table->enum('keadaan_bayi', ['Hidup', 'Mati'])->nullable();

            // Data Bayi
            $table->integer('berat_bayi_gram')->nullable();
            $table->decimal('panjang_badan_cm', 5, 2)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->decimal('lingkar_kepala_cm', 5, 2)->nullable();

            // Presentasi (checkbox group)
            $table->enum('presentasi', [
                'Puncak Kepala',
                'Belakang Kepala',
                'Lintang/Oblique',
                'Menumbung',
                'Bokong',
                'Dahi',
                'Muka',
                'Kaki',
                'Campuran'
            ])->nullable();

            // Tempat Persalinan (checkbox group)
            $table->enum('tempat_persalinan', [
                'Rumah',
                'Polindes',
                'Pustu',
                'Puskesmas',
                'RB',
                'RSIA',
                'RS',
                'RS ODHA'
            ])->nullable();

            // Penolong (checkbox group)
            $table->enum('penolong', [
                'Keluarga',
                'Dukun',
                'Bidan',
                'Dr Spesialis',
                'Dr Lainnya',
                'Tidak Ada'
            ])->nullable();

            // Cara Persalinan (checkbox group)
            $table->enum('cara_persalinan', [
                'Normal',
                'Vakum',
                'Forseps',
                'Seksio Sesarea'
            ])->nullable();

            // Manajemen Aktif Kala III (multi-select, stored as JSON)
            $table->json('manajemen_aktif_kala_iii')->nullable();

            // Pelayanan Persalinan
            $table->enum('imd', ['< 1 jam', '> 1 jam'])->nullable();
            $table->boolean('menggunakan_partograf')->default(false);
            $table->boolean('catat_buku_kia')->default(false);

            // Komplikasi (multi-select, stored as JSON)
            $table->json('komplikasi_persalinan')->nullable();

            // Penanganan Komplikasi
            $table->enum('penanganan_komplikasi', ['Ya', 'Tidak'])->nullable();
            $table->text('penanganan_keterangan')->nullable();

            // Rujukan
            $table->enum('dirujuk_ke', [
                'Puskesmas',
                'RB',
                'RSIA/RSB',
                'RS',
                'RS ODHA',
                'Tidak Dirujuk'
            ])->nullable();
            $table->enum('keadaan_tiba', ['Hidup', 'Mati'])->nullable();
            $table->enum('keadaan_pulang', ['Hidup', 'Mati'])->nullable();

            $table->text('alamat_bersalin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
