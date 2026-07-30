<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('birth_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade'); // ibu
            $table->foreignId('mother_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nama_ibu');
            $table->text('alamat_ibu')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('nama_suami')->nullable();
            $table->integer('umur_ibu')->nullable();
            $table->string('alamat_bidan')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->date('tanggal_partus');
            $table->string('jam_partus')->nullable();
            $table->enum('jenis_partus', ['Normal', 'SC', 'Vakum', 'Forseps'])->default('Normal');
            // Keadaan Bayi
            $table->enum('keadaan_bayi', ['Hidup', 'Mati'])->default('Hidup');
            $table->enum('jenis_kelamin_bayi', ['L', 'P'])->nullable();
            $table->integer('bb_bayi_gram')->nullable();
            $table->integer('pb_bayi_cm')->nullable();
            // Keadaan Ibu
            $table->string('keadaan_ibu')->nullable();
            $table->decimal('bb_ibu_kg', 5, 1)->nullable();
            // Keterangan
            $table->text('keterangan')->nullable(); // Vit K, HB0, IMD, dll
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birth_reports');
    }
};
