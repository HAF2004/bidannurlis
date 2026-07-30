<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthReport extends Model
{
    protected $fillable = [
        'patient_id',
        'mother_id',
        'nama_ibu',
        'alamat_ibu',
        'no_telp',
        'nama_suami',
        'umur_ibu',
        'alamat_bidan',
        'anak_ke',
        'tanggal_partus',
        'jam_partus',
        'jenis_partus',
        'keadaan_bayi',
        'jenis_kelamin_bayi',
        'bb_bayi_gram',
        'pb_bayi_cm',
        'keadaan_ibu',
        'bb_ibu_kg',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_partus' => 'date',
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
