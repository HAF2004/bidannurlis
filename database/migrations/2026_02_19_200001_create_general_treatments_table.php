<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('general_treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->text('keluhan')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->integer('td_sistol')->nullable();
            $table->integer('td_diastol')->nullable();
            $table->decimal('suhu', 4, 1)->nullable();
            $table->integer('nadi')->nullable();
            $table->integer('napas')->nullable();
            $table->decimal('bb_kg', 5, 1)->nullable();
            $table->decimal('tb_cm', 5, 1)->nullable();
            $table->text('pemeriksaan_fisik')->nullable();
            $table->text('diagnosa')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('resep_obat')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_treatments');
    }
};
