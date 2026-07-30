<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'no_rm',
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'nama_orangtua',
        'telp_hp',
        'gol_darah',
        'no_bpjs',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function generalTreatments(): HasMany
    {
        return $this->hasMany(GeneralTreatment::class);
    }

    public function immunizations(): HasMany
    {
        return $this->hasMany(Immunization::class);
    }

    public function kbRegisters(): HasMany
    {
        return $this->hasMany(KbRegister::class);
    }

    public function birthReports(): HasMany
    {
        return $this->hasMany(BirthReport::class);
    }

    public function getUmurAttribute(): ?string
    {
        if (!$this->tanggal_lahir)
            return null;
        $age = $this->tanggal_lahir->age;
        if ($age < 1) {
            $months = $this->tanggal_lahir->diffInMonths(now());
            return $months . ' bln';
        }
        return $age . ' th';
    }
}
