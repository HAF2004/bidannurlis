<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthPlan extends Model
{
    protected $fillable = [
        'mother_id',
        'tanggal',
        'penolong',
        'tempat',
        'pendamping',
        'transportasi',
        'pendonor_darah',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}
