<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KbRegister extends Model
{
    protected $fillable = [
        'patient_id',
        'no_register',
        'tanggal_daftar',
        'nama_suami',
        'nik_suami',
        'nik_istri',
        'no_hp',
        'metode_kb',
        'status_peserta',
        'informed_consent',
        'pasca_persalinan',
        'pasca_keguguran',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'informed_consent' => 'boolean',
        'pasca_persalinan' => 'boolean',
        'pasca_keguguran' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(KbVisit::class);
    }
}
