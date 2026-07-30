<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel prioritas — Master aturan Rule-Based Reasoning (RBR)
        Schema::create('prioritas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);             // Gawat Darurat, Mendesak, Biasa
            $table->string('kode', 10);              // GAWAT, MENDESAK, BIASA
            $table->string('warna', 10);             // merah, kuning, hijau
            $table->integer('urutan');                // 1 = tertinggi (didahulukan)
            $table->integer('estimasi_waktu');        // Menit per layanan (Time-Based)
            $table->text('gejala');                   // Daftar gejala pemicu (comma-separated)
            $table->text('deskripsi')->nullable();    // Penjelasan tambahan
            $table->timestamps();
        });

        // Tabel antrian — Data antrian pasien harian
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->string('no_antrian', 10);        // A001, A002, dst
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->string('nama_pasien', 100);
            $table->integer('umur')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->date('tanggal');                  // Tanggal antrian
            $table->foreignId('prioritas_id')->constrained('prioritas');
            $table->text('keluhan')->nullable();
            $table->time('waktu_daftar');             // Jam mendaftar
            $table->time('estimasi_dilayani')->nullable(); // Jam estimasi dilayani (TBS)
            $table->enum('status', ['menunggu', 'dipanggil', 'dilayani', 'selesai', 'batal'])
                ->default('menunggu');
            $table->text('catatan_bidan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['tanggal', 'status']);     // Index untuk query harian
        });

        // Tabel pengaturan — Konfigurasi sistem
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 50)->unique();
            $table->string('setting_value', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrian');
        Schema::dropIfExists('prioritas');
        Schema::dropIfExists('pengaturan');
    }
};
