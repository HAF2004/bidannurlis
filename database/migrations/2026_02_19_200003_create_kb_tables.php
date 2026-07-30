<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kb_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('no_register')->nullable();
            $table->date('tanggal_daftar');
            $table->string('nama_suami')->nullable();
            $table->string('nik_suami', 16)->nullable();
            $table->string('nik_istri', 16)->nullable();
            $table->string('no_hp')->nullable();
            $table->string('metode_kb')->nullable();
            $table->enum('status_peserta', ['Baru', 'Lama'])->default('Baru');
            $table->boolean('informed_consent')->default(false);
            $table->boolean('pasca_persalinan')->default(false);
            $table->boolean('pasca_keguguran')->default(false);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('kb_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kb_register_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('metode_kb')->nullable();
            $table->text('keluhan')->nullable();
            $table->text('tindakan')->nullable();
            $table->boolean('komplikasi_berat')->default(false);
            $table->boolean('kegagalan')->default(false);
            $table->boolean('pencabutan')->default(false);
            $table->string('sumber_biaya')->nullable(); // BPJS, APBN, APBD, Mandiri
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kb_visits');
        Schema::dropIfExists('kb_registers');
    }
};
