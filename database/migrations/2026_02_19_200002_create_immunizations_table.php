<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('immunizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('mother_id')->nullable()->constrained()->onDelete('set null');
            $table->date('tanggal');
            $table->string('jenis_vaksin'); // BCG, Polio 0-4, DPT-HB-Hib 1-3, Campak, MR, dll
            $table->integer('dosis')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('lokasi_penyuntikan')->nullable();
            $table->string('petugas')->nullable();
            $table->text('reaksi_kipi')->nullable();
            $table->decimal('bb_kg', 5, 1)->nullable();
            $table->decimal('tb_cm', 5, 1)->nullable();
            $table->string('umur_saat_imunisasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('immunizations');
    }
};
