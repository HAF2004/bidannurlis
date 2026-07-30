<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Immunization extends Model
{
    protected $fillable = [
        'patient_id',
        'mother_id',
        'tanggal',
        'jenis_vaksin',
        'dosis',
        'batch_no',
        'lokasi_penyuntikan',
        'petugas',
        'reaksi_kipi',
        'bb_kg',
        'tb_cm',
        'umur_saat_imunisasi',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}
