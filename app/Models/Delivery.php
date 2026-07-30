<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $fillable = [
        'mother_id',
        // Fase Persalinan
        'kala1_aktif_tanggal',
        'kala1_aktif_jam',
        'kala2_tanggal',
        'kala2_jam',
        'bayi_lahir_tanggal',
        'bayi_lahir_jam',
        'plasenta_lahir_tanggal',
        'plasenta_lahir_jam',
        'perdarahan_kala_iv_cc',
        // Kondisi
        'usia_kehamilan_minggu',
        'keadaan_ibu',
        'keadaan_bayi',
        // Data Bayi
        'berat_bayi_gram',
        'panjang_badan_cm',
        'jenis_kelamin',
        'lingkar_kepala_cm',
        // Checkbox enums
        'presentasi',
        'tempat_persalinan',
        'penolong',
        'cara_persalinan',
        // Multi-select JSON
        'manajemen_aktif_kala_iii',
        // Pelayanan
        'imd',
        'menggunakan_partograf',
        'catat_buku_kia',
        // Komplikasi
        'komplikasi_persalinan',
        'penanganan_komplikasi',
        'penanganan_keterangan',
        // Rujukan
        'dirujuk_ke',
        'keadaan_tiba',
        'keadaan_pulang',
        'alamat_bersalin',
    ];

    protected function casts(): array
    {
        return [
            'kala1_aktif_tanggal' => 'date',
            'kala2_tanggal' => 'date',
            'bayi_lahir_tanggal' => 'date',
            'plasenta_lahir_tanggal' => 'date',
            'manajemen_aktif_kala_iii' => 'array',
            'komplikasi_persalinan' => 'array',
            'menggunakan_partograf' => 'boolean',
            'catat_buku_kia' => 'boolean',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}
