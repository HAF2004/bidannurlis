<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mother extends Model
{
    protected $fillable = [
        // Identitas
        'puskesmas',
        'no_registrasi',
        'nama_ibu',
        'nama_suami',
        // Data Pribadi
        'tgl_lahir',
        'umur',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        // Data Tambahan
        'agama',
        'pendidikan',
        'pekerjaan_ibu',
        'pekerjaan_suami',
        // Tanggal
        'tgl_register',
        'tgl_menikah',
        // Kesehatan
        'jamkes',
        'gol_darah',
        'telp_hp',
        // Kader & Dukun
        'posyandu',
        'nama_kader',
        'nama_dukun',
        // Riwayat Obstetrik
        'gravida',
        'partus',
        'abortus',
        'hidup',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
            'tgl_register' => 'date',
            'tgl_menikah' => 'date',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function midwifeExam(): HasOne
    {
        return $this->hasOne(MidwifeExam::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    public function postpartumVisits(): HasMany
    {
        return $this->hasMany(PostpartumVisit::class);
    }

    public function familyPlannings(): HasMany
    {
        return $this->hasMany(FamilyPlanning::class);
    }

    public function birthPlans(): HasMany
    {
        return $this->hasMany(BirthPlan::class);
    }

    public function ancVisits(): HasMany
    {
        return $this->hasMany(AncVisit::class);
    }
}
