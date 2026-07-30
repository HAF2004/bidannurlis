<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('birth_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal')->nullable();

            // Penolong (checkbox group)
            $table->enum('penolong', [
                'Dr Spesialis',
                'Dr Umum',
                'Bidan',
                'Dukun',
                'Keluarga',
                'Lain-lain'
            ])->nullable();

            // Tempat (checkbox group)
            $table->enum('tempat', [
                'Rumah',
                'Poskesdes',
                'Pustu',
                'Puskesmas',
                'RB',
                'RSIA',
                'RS',
                'RS ODHA'
            ])->nullable();

            // Pendamping (checkbox group)
            $table->enum('pendamping', [
                'Suami',
                'Keluarga',
                'Teman',
                'Tetangga',
                'Lain-lain'
            ])->nullable();

            // Transportasi (checkbox group)
            $table->enum('transportasi', [
                'Suami',
                'Keluarga',
                'Teman',
                'Tetangga',
                'Lain-lain'
            ])->nullable();

            // Pendonor Darah (checkbox group)
            $table->enum('pendonor_darah', [
                'Suami',
                'Keluarga',
                'Teman',
                'Tetangga',
                'Lain-lain'
            ])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birth_plans');
    }
};
