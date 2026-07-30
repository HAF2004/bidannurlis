<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MidwifeExam extends Model
{
    protected $fillable = [
        'mother_id',
        'tanggal_periksa',
        'tanggal_hpht',
        'taksiran_persalinan',
        'tgl_persalinan_sebelumnya',
        'bb_sebelum_hamil',
        'tinggi_badan',
        'lila',
        'status_gizi',
        'buku_kia',
        'riwayat_komplikasi_kebidanan',
        'riwayat_kronis_dan_alergi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_periksa' => 'date',
            'tanggal_hpht' => 'date',
            'taksiran_persalinan' => 'date',
            'tgl_persalinan_sebelumnya' => 'date',
            'bb_sebelum_hamil' => 'decimal:2',
            'tinggi_badan' => 'decimal:2',
            'lila' => 'decimal:2',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}
