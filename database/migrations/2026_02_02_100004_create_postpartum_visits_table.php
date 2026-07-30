<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('postpartum_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal')->nullable();
            $table->integer('hari_ke')->nullable();
            $table->enum('kf', ['KF1', 'KF2', 'KF3'])->nullable();

            // Tanda Vital
            $table->string('td_mmhg', 20)->nullable();
            $table->decimal('suhu_c', 4, 1)->nullable();

            // Pelayanan (multi-select stored as JSON)
            $table->json('pelayanan')->nullable(); // ['Catat di Buku KIA', 'Fe/TTD', 'Vit A']

            // Komplikasi (multi-select stored as JSON)
            $table->json('komplikasi')->nullable(); // ['PPP', 'Infeksi', 'HDK', 'Lainnya']

            $table->text('penanganan_komplikasi_kebidanan')->nullable();

            // Rujukan
            $table->enum('dirujuk_ke', ['PKM', 'RB', 'RSIA/RSB', 'RS', 'RS ODHA'])->nullable();
            $table->enum('keadaan_tiba', ['H', 'M'])->nullable();
            $table->enum('keadaan_pulang', ['H', 'M'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postpartum_visits');
    }
};
