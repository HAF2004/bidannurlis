<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'no_antrian',
        'patient_id',
        'nama_pasien',
        'umur',
        'no_hp',
        'tanggal',
        'prioritas_id',
        'keluhan',
        'waktu_daftar',
        'estimasi_dilayani',
        'waktu_dipanggil',
        'waktu_dilayani',
        'waktu_selesai',
        'durasi_aktual',
        'status',
        'catatan_bidan',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ─── Relasi ───

    public function prioritas()
    {
        return $this->belongsTo(Prioritas::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    // ─── Scopes ───

    public function scopeHariIni($query)
    {
        return $query->where('tanggal', today());
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['menunggu', 'dipanggil', 'dilayani']);
    }

    /**
     * Scope: urut antrian berdasarkan prioritas (RBR) lalu waktu daftar (TBS)
     * Prioritas urutan kecil = darurat = didahulukan
     */
    public function scopeUrutAntrian($query)
    {
        return $query->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
            ->orderBy('prioritas.urutan', 'asc')
            ->orderBy('antrian.waktu_daftar', 'asc')
            ->select('antrian.*');
    }

    // ─── Helpers ───

    /**
     * Generate nomor antrian otomatis: A001, A002, dst per hari
     */
    public static function generateNomor(): string
    {
        $lastToday = self::where('tanggal', today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastToday) {
            $lastNum = intval(substr($lastToday->no_antrian, 1));
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }

        return 'A' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Ambil rata-rata durasi aktual layanan per prioritas (untuk TBS adaptif)
     * Jika belum ada data historis, fallback ke estimasi_waktu dari tabel prioritas
     */
    public static function getDurasiEfektif(int $prioritasId): int
    {
        $prioritas = Prioritas::find($prioritasId);

        // Cari rata-rata durasi aktual dari 30 data terakhir untuk prioritas ini
        $rataRata = self::where('prioritas_id', $prioritasId)
            ->where('status', 'selesai')
            ->whereNotNull('durasi_aktual')
            ->where('durasi_aktual', '>', 0)
            ->orderBy('id', 'desc')
            ->take(30)
            ->avg('durasi_aktual');

        if ($rataRata && $rataRata > 0) {
            return (int) round($rataRata);
        }

        // Fallback ke estimasi default dari tabel prioritas
        return $prioritas ? $prioritas->estimasi_waktu : 15;
    }

    /**
     * Tentukan titik waktu mulai antrian:
     * = MAX(sekarang, jam buka praktik, selesainya pasien terakhir yang dilayani)
     */
    public static function getWaktuMulaiBerikutnya(): Carbon
    {
        $sekarang = now();

        // Jam buka praktik
        $jamBuka = Pengaturan::get('jam_buka', '08:00');
        $waktuBuka = today()->setTimeFromTimeString($jamBuka);

        // Waktu paling awal = max(sekarang, jam buka)
        $waktuMulai = $sekarang->greaterThan($waktuBuka) ? $sekarang->copy() : $waktuBuka->copy();

        // Cek apakah ada pasien yang sedang dilayani — jika ya, slot berikutnya
        // dimulai setelah pasien itu selesai (berdasarkan estimasi durasi)
        $sedangDilayani = self::hariIni()
            ->where('status', 'dilayani')
            ->latest('waktu_dilayani')
            ->first();

        if ($sedangDilayani && $sedangDilayani->waktu_dilayani) {
            $durasi = self::getDurasiEfektif($sedangDilayani->prioritas_id);
            $selesaiDilayani = today()
                ->setTimeFromTimeString($sedangDilayani->waktu_dilayani)
                ->addMinutes($durasi);

            if ($selesaiDilayani->greaterThan($waktuMulai)) {
                $waktuMulai = $selesaiDilayani->copy();
            }
        }

        return $waktuMulai;
    }

    /**
     * TIME-BASED SCHEDULING (TBS) — OPTIMIZED
     *
     * Hitung estimasi jam dilayani untuk pasien baru.
     * Menggunakan durasi efektif (rata-rata aktual jika tersedia).
     * Memperhitungkan: jam buka, pasien sedang dilayani, dan urutan prioritas.
     */
    public static function hitungEstimasi(int $prioritasId): string
    {
        $prioritasBaru = Prioritas::find($prioritasId);
        $waktuMulai = self::getWaktuMulaiBerikutnya();

        // Ambil semua antrian menunggu/dipanggil hari ini, urut prioritas
        $antrianAktif = self::hariIni()
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
            ->orderBy('prioritas.urutan', 'asc')
            ->orderBy('antrian.waktu_daftar', 'asc')
            ->select('antrian.*', 'prioritas.urutan')
            ->get();

        // Hitung total waktu pasien yang akan dilayani sebelum pasien baru
        $totalMenit = 0;
        foreach ($antrianAktif as $a) {
            if (
                $a->urutan < $prioritasBaru->urutan ||
                $a->urutan == $prioritasBaru->urutan
            ) {
                // Gunakan durasi efektif (adaptif dari data aktual)
                $totalMenit += self::getDurasiEfektif($a->prioritas_id);
            }
        }

        return $waktuMulai->addMinutes($totalMenit)->format('H:i');
    }

    /**
     * RECALCULATE TBS — OPTIMIZED
     *
     * Recalculate semua estimasi antrian hari ini.
     * Dipanggil setelah ada perubahan status (panggil, layani, selesai, batal).
     * Menggunakan waktu mulai berikutnya dan durasi efektif.
     */
    public static function recalculateEstimasi(): void
    {
        $antrianAktif = self::hariIni()
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
            ->orderBy('prioritas.urutan', 'asc')
            ->orderBy('antrian.waktu_daftar', 'asc')
            ->select('antrian.*')
            ->get();

        $waktuMulai = self::getWaktuMulaiBerikutnya();
        $totalMenit = 0;

        foreach ($antrianAktif as $a) {
            $estimasi = $waktuMulai->copy()->addMinutes($totalMenit)->format('H:i');

            self::withoutTimestamps(function () use ($a, $estimasi) {
                self::where('id', $a->id)->update(['estimasi_dilayani' => $estimasi]);
            });

            $totalMenit += self::getDurasiEfektif($a->prioritas_id);
        }
    }

    /**
     * Catat timestamp dan hitung durasi aktual saat status berubah
     */
    public function catatWaktu(string $statusBaru): void
    {
        $data = ['status' => $statusBaru];

        switch ($statusBaru) {
            case 'dipanggil':
                $data['waktu_dipanggil'] = now()->format('H:i:s');
                break;

            case 'dilayani':
                $data['waktu_dilayani'] = now()->format('H:i:s');
                break;

            case 'selesai':
                $data['waktu_selesai'] = now()->format('H:i:s');

                // Hitung durasi aktual (dari dilayani → selesai) dalam menit
                if ($this->waktu_dilayani) {
                    $mulai = today()->setTimeFromTimeString($this->waktu_dilayani);
                    $akhir = now();
                    $data['durasi_aktual'] = (int) round($mulai->diffInMinutes($akhir));
                }
                break;

            case 'batal':
                $data['waktu_selesai'] = now()->format('H:i:s');
                break;
        }

        $this->update($data);
    }

    // ─── Accessors ───

    /**
     * Warna badge berdasarkan prioritas
     */
    public function getWarnaBadgeAttribute(): string
    {
        return match ($this->prioritas?->kode) {
            'GAWAT' => 'danger',
            'MENDESAK' => 'warning',
            default => 'success',
        };
    }

    /**
     * Warna baris tabel
     */
    public function getWarnaRowAttribute(): string
    {
        return match ($this->prioritas?->kode) {
            'GAWAT' => 'table-danger',
            'MENDESAK' => 'table-warning',
            default => '',
        };
    }

    /**
     * Label status dengan badge
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'secondary',
            'dipanggil' => 'info',
            'dilayani' => 'primary',
            'selesai' => 'success',
            'batal' => 'dark',
            default => 'secondary',
        };
    }
}
