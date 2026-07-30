<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('midwife_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained()->cascadeOnDelete();

            // Tanggal Pemeriksaan
            $table->date('tanggal_periksa')->nullable();
            $table->date('tanggal_hpht')->nullable();
            $table->date('taksiran_persalinan')->nullable();
            $table->date('tgl_persalinan_sebelumnya')->nullable();

            // Pengukuran
            $table->decimal('bb_sebelum_hamil', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('lila', 5, 2)->nullable();

            // Status
            $table->enum('status_gizi', ['KEK', 'Normal'])->nullable();
            $table->enum('buku_kia', ['Memiliki', 'Tidak Memiliki'])->nullable();

            // Riwayat
            $table->text('riwayat_komplikasi_kebidanan')->nullable();
            $table->text('riwayat_kronis_dan_alergi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('midwife_exams');
    }
};
