<?php

namespace Database\Seeders;

use App\Models\Antrian;
use App\Models\Prioritas;
use App\Services\TimeBasedSchedulingService;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AntrianSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data antrian hari ini (atau semua)
        Antrian::truncate();

        $faker = Faker::create('id_ID');
        $prioritasGawat = Prioritas::where('kode', 'GAWAT')->first();
        $prioritasMendesak = Prioritas::where('kode', 'MENDESAK')->first();
        $prioritasBiasa = Prioritas::where('kode', 'BIASA')->first();

        // 1. Biasa
        Antrian::create([
            'no_antrian' => 'A-001',
            'nama_pasien' => $faker->name('female'),
            'umur' => 25,
            'no_hp' => '081234567890',
            'tanggal' => today(),
            'prioritas_id' => $prioritasBiasa->id,
            'jenis_layanan' => 'KB',
            'tensi_sistolik' => 120,
            'tensi_diastolik' => 80,
            'berat_badan' => 60.5,
            'is_override' => false,
            'keluhan' => 'Suntik KB 1 Bulan',
            'waktu_daftar' => now()->subMinutes(60)->format('H:i:s'),
            'status' => 'selesai',
            'waktu_dipanggil' => now()->subMinutes(55)->format('H:i:s'),
            'waktu_dilayani' => now()->subMinutes(54)->format('H:i:s'),
            'waktu_selesai' => now()->subMinutes(45)->format('H:i:s'),
            'created_by' => 1,
        ]);

        // 2. Mendesak
        Antrian::create([
            'no_antrian' => 'A-002',
            'nama_pasien' => $faker->name('female'),
            'umur' => 28,
            'no_hp' => '082345678901',
            'tanggal' => today(),
            'prioritas_id' => $prioritasMendesak->id,
            'jenis_layanan' => 'ANC',
            'tensi_sistolik' => 150,
            'tensi_diastolik' => 100,
            'berat_badan' => 70,
            'is_override' => false,
            'keluhan' => 'Pusing hebat, pandangan berkunang-kunang',
            'waktu_daftar' => now()->subMinutes(30)->format('H:i:s'),
            'status' => 'dilayani',
            'waktu_dipanggil' => now()->subMinutes(10)->format('H:i:s'),
            'waktu_dilayani' => now()->subMinutes(9)->format('H:i:s'),
            'created_by' => 1,
        ]);

        // 3. Biasa (Veto oleh Bidan menjadi Mendesak)
        Antrian::create([
            'no_antrian' => 'A-003',
            'nama_pasien' => $faker->name('female'),
            'umur' => 30,
            'no_hp' => '083456789012',
            'tanggal' => today(),
            'prioritas_id' => $prioritasMendesak->id,
            'jenis_layanan' => 'Anak',
            'tensi_sistolik' => null,
            'tensi_diastolik' => null,
            'berat_badan' => 15,
            'is_override' => true,
            'keluhan' => 'Anak rewel terus menerus menangis',
            'waktu_daftar' => now()->subMinutes(20)->format('H:i:s'),
            'status' => 'menunggu',
            'created_by' => 1,
        ]);

        // 4. Biasa
        Antrian::create([
            'no_antrian' => 'A-004',
            'nama_pasien' => $faker->name('female'),
            'umur' => 22,
            'no_hp' => '084567890123',
            'tanggal' => today(),
            'prioritas_id' => $prioritasBiasa->id,
            'jenis_layanan' => 'Imunisasi',
            'tensi_sistolik' => null,
            'tensi_diastolik' => null,
            'berat_badan' => 12,
            'is_override' => false,
            'keluhan' => 'Imunisasi DPT',
            'waktu_daftar' => now()->subMinutes(15)->format('H:i:s'),
            'status' => 'menunggu',
            'created_by' => 1,
        ]);

        // 5. Gawat Darurat (Masuk belakangan tapi diprioritaskan)
        Antrian::create([
            'no_antrian' => 'A-005',
            'nama_pasien' => $faker->name('female'),
            'umur' => 35,
            'no_hp' => '085678901234',
            'tanggal' => today(),
            'prioritas_id' => $prioritasGawat->id,
            'jenis_layanan' => 'Persalinan',
            'tensi_sistolik' => 140,
            'tensi_diastolik' => 90,
            'berat_badan' => 68,
            'is_override' => false,
            'keluhan' => 'Ketuban pecah, pendarahan',
            'waktu_daftar' => now()->subMinutes(5)->format('H:i:s'),
            'status' => 'menunggu',
            'created_by' => 1,
        ]);

        // Recalculate TBS
        $tbsService = new TimeBasedSchedulingService();
        $tbsService->recalculateAllEstimates(today());
    }
}
