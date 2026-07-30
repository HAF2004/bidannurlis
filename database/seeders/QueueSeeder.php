<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prioritas;
use App\Models\Pengaturan;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════════════
        // RULE-BASED REASONING: Data aturan prioritas
        // ═══════════════════════════════════════════

        Prioritas::updateOrCreate(['kode' => 'GAWAT'], [
            'nama' => 'Gawat Darurat',
            'kode' => 'GAWAT',
            'warna' => 'merah',
            'urutan' => 1,
            'estimasi_waktu' => 30,
            'gejala' => 'persalinan mulas,pendarahan,pengen ngeden',
            'deskripsi' => 'Kondisi gawat darurat (15-30 menit + rujukan). Pasien didahulukan.',
        ]);

        Prioritas::updateOrCreate(['kode' => 'MENDESAK'], [
            'nama' => 'Mendesak',
            'kode' => 'MENDESAK',
            'warna' => 'kuning',
            'urutan' => 2,
            'estimasi_waktu' => 10,
            'gejala' => 'perut kenceng,perut sakit bagian bawah,mual muntah parah,keluar air,hipertensi,darah tinggi',
            'deskripsi' => 'Kondisi mendesak (rata-rata 10 menit).',
        ]);

        Prioritas::updateOrCreate(['kode' => 'BIASA'], [
            'nama' => 'Biasa',
            'kode' => 'BIASA',
            'warna' => 'hijau',
            'urutan' => 3,
            'estimasi_waktu' => 10,
            'gejala' => 'kb,berobat umum,periksa hamil,imunisasi,periksa perkembangan anak',
            'deskripsi' => 'Kunjungan rutin (rata-rata 10 menit).',
        ]);

        // ═══════════════════════════════════════════
        // TIME-BASED SCHEDULING: Pengaturan jam praktik
        // ═══════════════════════════════════════════

        Pengaturan::set('jam_buka', '08:00');
        Pengaturan::set('jam_tutup', '17:00');
        Pengaturan::set('nama_praktik', 'Praktik Bidan Nurlis');
    }
}
