<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('family_plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained()->cascadeOnDelete();

            // Metode KB (checkbox group)
            $table->enum('metode_kb', [
                'MAL',
                'Kondom',
                'Pil',
                'Suntik',
                'AKDR',
                'Implan',
                'MOW',
                'MOP'
            ])->nullable();

            $table->date('tanggal')->nullable();
            $table->string('rencana')->nullable();
            $table->string('pelaksanaan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_plannings');
    }
};
