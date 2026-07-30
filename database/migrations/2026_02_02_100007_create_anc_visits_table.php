<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anc_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained()->onDelete('cascade');
            $table->integer('no_urut')->nullable();
            $table->date('tanggal_kunjungan');
            $table->integer('usia_kehamilan_minggu')->nullable();
            $table->enum('trimester', ['I', 'II', 'III'])->nullable();

            // Anamnesis
            $table->text('anamnesis')->nullable();

            // Pemeriksaan Ibu
            $table->decimal('bb_kg', 5, 2)->nullable();
            $table->integer('td_sistol')->nullable();
            $table->integer('td_diastol')->nullable();
            $table->decimal('suhu_c', 4, 1)->nullable();
            $table->decimal('tfu_cm', 5, 2)->nullable();
            $table->enum('refleks_patella', ['+', '-'])->nullable();
            $table->integer('djj')->nullable();
            $table->string('presentasi')->nullable();
            $table->integer('jumlah_janin')->default(1);
            $table->integer('tbj_gram')->nullable();

            // Pelayanan
            $table->string('status_imunisasi_tt')->nullable();
            $table->integer('fe_tablet')->nullable();
            $table->boolean('catat_buku_kia')->default(false);
            $table->boolean('pmt_bumil')->default(false);
            $table->boolean('kelas_ibu')->default(false);

            // Laboratorium
            $table->decimal('hb', 4, 1)->nullable();
            $table->string('gula_darah')->nullable();
            $table->string('protein_urin')->nullable();
            $table->string('hiv')->nullable();
            $table->string('sifilis')->nullable();
            $table->string('hbsag')->nullable();

            // Integrasi Program
            $table->string('p4hiv_arv')->nullable();
            $table->string('p4hiv_profilaksis_anak')->nullable();
            $table->string('malaria')->nullable();
            $table->string('tb')->nullable();
            $table->string('ims')->nullable();
            $table->text('diagnosis_ims')->nullable();
            $table->text('penanganan_obat')->nullable();

            // Komplikasi & Rujukan
            $table->text('komplikasi')->nullable();
            $table->string('dirujuk_ke')->nullable();
            $table->enum('keadaan_datang', ['hidup', 'mati'])->default('hidup');
            $table->enum('keadaan_pulang', ['hidup', 'mati'])->default('hidup');

            // Keterangan
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anc_visits');
    }
};
