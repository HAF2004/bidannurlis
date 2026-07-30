<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KbVisit extends Model
{
    protected $fillable = [
        'kb_register_id',
        'tanggal',
        'metode_kb',
        'keluhan',
        'tindakan',
        'komplikasi_berat',
        'kegagalan',
        'pencabutan',
        'sumber_biaya',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'komplikasi_berat' => 'boolean',
        'kegagalan' => 'boolean',
        'pencabutan' => 'boolean',
    ];

    public function kbRegister(): BelongsTo
    {
        return $this->belongsTo(KbRegister::class);
    }
}
