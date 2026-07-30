<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralTreatment extends Model
{
    protected $fillable = [
        'patient_id',
        'tanggal_kunjungan',
        'keluhan',
        'riwayat_penyakit',
        'td_sistol',
        'td_diastol',
        'suhu',
        'nadi',
        'napas',
        'bb_kg',
        'tb_cm',
        'pemeriksaan_fisik',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
