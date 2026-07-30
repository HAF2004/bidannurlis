<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['setting_key', 'setting_value'];

    /**
     * Ambil nilai pengaturan berdasarkan key
     */
    public static function get(string $key, $default = null): ?string
    {
        $setting = self::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Set nilai pengaturan
     */
    public static function set(string $key, string $value): void
    {
        self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
    }
}
