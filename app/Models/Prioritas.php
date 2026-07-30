<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioritas extends Model
{
    protected $table = 'prioritas';

    protected $fillable = [
        'nama',
        'kode',
        'warna',
        'urutan',
        'estimasi_waktu',
        'gejala',
        'deskripsi',
    ];

    /**
     * Relasi: satu prioritas punya banyak antrian
     */
    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }

    /**
     * Ambil gejala sebagai array
     */
    public function getGejalaArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->gejala));
    }

    /**
     * RULE-BASED REASONING: Cocokkan keluhan dengan aturan prioritas
     * Mengembalikan prioritas yang paling cocok berdasarkan urutan tertinggi
     */
    public static function matchKeluhan(string $keluhan): self
    {
        $keluhan = strtolower($keluhan);

        // Cek dari prioritas tertinggi (urutan terkecil) ke terendah
        $priorities = self::orderBy('urutan', 'asc')->get();

        foreach ($priorities as $priority) {
            $gejalaList = array_map('trim', explode(',', strtolower($priority->gejala)));

            foreach ($gejalaList as $gejala) {
                if (!empty($gejala) && str_contains($keluhan, $gejala)) {
                    return $priority;
                }
            }
        }

        // Default: Biasa (urutan tertinggi/paling rendah prioritasnya)
        return $priorities->last() ?? self::where('kode', 'BIASA')->first();
    }
}
