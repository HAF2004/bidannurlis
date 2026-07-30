<?php

namespace App\Services;

use App\Models\Prioritas;
use Illuminate\Support\Str;

class RuleBasedReasoningService
{
    /**
     * Determine priority based on medical rules (RBR).
     *
     * @param string|null $jenisLayanan
     * @param string|null $keluhan
     * @param int|null $tensiSistolik
     * @param int|null $tensiDiastolik
     * @return Prioritas
     */
    public function determinePriority($jenisLayanan, $keluhan, $tensiSistolik, $tensiDiastolik): Prioritas
    {
        $prioritasGawat = Prioritas::where('kode', 'GAWAT')->first();
        $prioritasMendesak = Prioritas::where('kode', 'MENDESAK')->first();
        $prioritasBiasa = Prioritas::where('kode', 'BIASA')->first();

        // Safe fallback in case DB is empty
        if (!$prioritasBiasa) {
            return new Prioritas();
        }

        $keluhanStr = Str::lower($keluhan ?? '');
        $jenisLayananStr = Str::lower($jenisLayanan ?? '');

        // Aturan 1: Kondisi GAWAT (Merah)
        $keywordGawat = ['pendarahan', 'mulas', 'ngeden', 'pecah ketuban', 'darah banyak', 'kejang'];
        foreach ($keywordGawat as $keyword) {
            if (Str::contains($keluhanStr, $keyword)) {
                return $prioritasGawat;
            }
        }
        
        if (Str::contains($jenisLayananStr, 'persalinan') && Str::contains($keluhanStr, 'mulas')) {
             return $prioritasGawat;
        }

        // Aturan 2: Kondisi MENDESAK (Kuning)
        $keywordMendesak = ['kenceng', 'sakit bagian bawah', 'mual', 'muntah', 'keluar air', 'hipertensi'];
        foreach ($keywordMendesak as $keyword) {
            if (Str::contains($keluhanStr, $keyword)) {
                return $prioritasMendesak;
            }
        }

        // Aturan Khusus Pengecekan Silang (Tensi)
        // Ibu dengan tensi darah tinggi (Sistolik >= 140 atau Diastolik >= 90) otomatis naik prioritas
        if ((!is_null($tensiSistolik) && $tensiSistolik >= 140) || (!is_null($tensiDiastolik) && $tensiDiastolik >= 90)) {
            return $prioritasMendesak;
        }

        // Aturan 3: Kondisi BIASA (Hijau)
        // KB, Periksa Hamil Rutin, Berobat Umum tanpa keluhan gawat
        return $prioritasBiasa;
    }
}
