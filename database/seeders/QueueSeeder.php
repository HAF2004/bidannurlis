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
            'gejala' => 'perdarahan,kejang,eklampsia,pre-eklampsia berat,ketuban pecah dini,tali pusat menumbung,retensio plasenta,syok,tidak sadar,sesak napas berat,partus lama,gawat janin,prolaps tali pusat,atonia uteri',
            'deskripsi' => 'Kondisi kegawatdaruratan obstetri/neonatal yang memerlukan penanganan segera atau rujukan.',
        ]);

        Prioritas::updateOrCreate(['kode' => 'MENDESAK'], [
            'nama' => 'Mendesak',
            'kode' => 'MENDESAK',
            'warna' => 'kuning',
            'urutan' => 2,
            'estimasi_waktu' => 10,
            'gejala' => 'kontraksi teratur,his teratur,mulas teratur,demam tinggi,nyeri perut hebat,tekanan darah tinggi,hipertensi,mual muntah hebat,hiperemesis,keluar darah,flek,keputihan berbau,gerakan janin berkurang,bengkak kaki tangan wajah,sakit kepala hebat,pandangan kabur',
            'deskripsi' => 'Kondisi yang memerlukan penanganan segera namun bukan kegawatdaruratan.',
        ]);

        Prioritas::updateOrCreate(['kode' => 'BIASA'], [
            'nama' => 'Biasa',
            'kode' => 'BIASA',
            'warna' => 'hijau',
            'urutan' => 3,
            'estimasi_waktu' => 10,
            'gejala' => 'kontrol kehamilan,pemeriksaan rutin,ANC,imunisasi,KB,konsultasi,periksa nifas,periksa bayi,tumbuh kembang anak,suntik KB,pasang IUD,pil KB,berobat umum,batuk pilek,demam ringan,cek laboratorium',
            'deskripsi' => 'Kunjungan rutin, pemeriksaan berkala, atau konsultasi umum.',
        ]);

        // ═══════════════════════════════════════════
        // TIME-BASED SCHEDULING: Pengaturan jam praktik
        // ═══════════════════════════════════════════

        Pengaturan::set('jam_buka', '08:00');
        Pengaturan::set('jam_tutup', '17:00');
        Pengaturan::set('nama_praktik', 'Praktik Bidan Nurlis');
    }
}
