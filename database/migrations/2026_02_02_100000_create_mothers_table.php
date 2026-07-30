<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mothers', function (Blueprint $table) {
            $table->id();

            // Identitas Utama
            $table->string('puskesmas')->nullable();
            $table->string('no_registrasi', 20)->nullable()->unique();
            $table->string('nama_ibu');
            $table->string('nama_suami')->nullable();

            // Data Pribadi
            $table->date('tgl_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();

            // Data Tambahan
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('pekerjaan_suami', 100)->nullable();

            // Tanggal-tanggal
            $table->date('tgl_register')->nullable();
            $table->date('tgl_menikah')->nullable();

            // Kesehatan & Kontak
            $table->string('jamkes', 50)->nullable();
            $table->enum('gol_darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('telp_hp', 20)->nullable();

            // Kader & Dukun
            $table->string('posyandu')->nullable();
            $table->string('nama_kader')->nullable();
            $table->string('nama_dukun')->nullable();

            // Riwayat Obstetrik (embedded)
            $table->integer('gravida')->default(0);
            $table->integer('partus')->default(0);
            $table->integer('abortus')->default(0);
            $table->integer('hidup')->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mothers');
    }
};
