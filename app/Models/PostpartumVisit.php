<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostpartumVisit extends Model
{
    protected $fillable = [
        'mother_id',
        'tanggal',
        'hari_ke',
        'kf',
        'td_mmhg',
        'suhu_c',
        'pelayanan',
        'komplikasi',
        'penanganan_komplikasi_kebidanan',
        'dirujuk_ke',
        'keadaan_tiba',
        'keadaan_pulang',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'pelayanan' => 'array',
            'komplikasi' => 'array',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}
