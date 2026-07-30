<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mother;
use App\Models\AncVisit;
use App\Models\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyMotherSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $admin = User::first();
        
        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $pendidikans = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3', 'Tidak Sekolah'];
        $pekerjaans = ['Wiraswasta', 'PNS', 'Karyawan Swasta', 'Guru', 'Buruh', 'Ibu Rumah Tangga', 'Pelajar/Mahasiswa', 'Tidak Bekerja'];
        $gol_darahs = ['A', 'B', 'AB', 'O'];

        for ($i = 1; $i <= 20; $i++) {
            $mother = Mother::create([
                'puskesmas' => 'Puskesmas Pamulang',
                'no_registrasi' => 'DMY-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . rand(1000, 9999),
                'nama_ibu' => $faker->name('female'),
                'nama_suami' => $faker->name('male'),
                'tgl_lahir' => $faker->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
                'umur' => $faker->numberBetween(18, 40),
                'alamat' => 'Jl. Kav. Keuangan Raya No.' . $faker->numberBetween(1, 100),
                'rt' => str_pad($faker->numberBetween(1, 15), 2, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'desa_kelurahan' => 'Kedaung',
                'kecamatan' => 'Pamulang',
                'kabupaten' => 'Tangerang Selatan',
                'provinsi' => 'Banten',
                'agama' => $faker->randomElement($agamas),
                'pendidikan' => $faker->randomElement($pendidikans),
                'pekerjaan_ibu' => $faker->randomElement($pekerjaans),
                'pekerjaan_suami' => $faker->randomElement($pekerjaans),
                'tgl_register' => Carbon::now()->subMonths(rand(1, 8)),
                'tgl_menikah' => $faker->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),
                'jamkes' => $faker->boolean(70) ? $faker->numerify('000#########') : '-',
                'gol_darah' => $faker->randomElement($gol_darahs),
                'telp_hp' => $faker->numerify('08##########'),
                'posyandu' => 'Posyandu Mawar',
                'nama_kader' => $faker->name('female'),
                'nama_dukun' => '-',
                'gravida' => $faker->numberBetween(1, 4),
                'partus' => $faker->numberBetween(0, 3),
                'abortus' => $faker->numberBetween(0, 1),
                'hidup' => $faker->numberBetween(0, 3),
                'created_by' => $admin ? $admin->id : 1,
            ]);

            // Create some ANC Visits for the mother
            $numVisits = rand(2, 5);
            $ukStart = rand(8, 14);
            
            for ($v = 1; $v <= $numVisits; $v++) {
                $uk = $ukStart + ($v * 4);
                AncVisit::create([
                    'mother_id' => $mother->id,
                    'no_urut' => $v,
                    'tanggal_kunjungan' => Carbon::now()->subWeeks(rand(1, 20)),
                    'usia_kehamilan_minggu' => $uk,
                    'trimester' => $uk <= 12 ? 'I' : ($uk <= 27 ? 'II' : 'III'),
                    'bb_kg' => rand(50, 70) + (rand(0, 9) / 10),
                    'td_sistol' => rand(100, 130),
                    'td_diastol' => rand(60, 85),
                    'suhu_c' => 36 + (rand(0, 9) / 10),
                    'tfu_cm' => $uk > 12 ? $uk - rand(0, 2) : null,
                    'djj' => $uk > 12 ? rand(120, 160) : null,
                    'hb' => rand(10, 14) + (rand(0, 9) / 10),
                    'anamnesis' => 'Keluhan: ' . $faker->randomElement(['Mual', 'Pusing', 'Sering kencing', 'Tidak ada keluhan']),
                    'kepala_thd' => $faker->randomElement(['Masuk PAP', 'Belum Masuk PAP']),
                    'presentasi' => 'Kepala',
                    'jumlah_janin' => 1,
                    'status_imunisasi_tt' => 'T' . rand(1, 5),
                    'injeksi_tt' => $faker->boolean,
                    'fe_tablet' => rand(10, 30),
                    'catat_buku_kia' => true,
                    'keadaan_datang' => 'hidup',
                    'keadaan_pulang' => 'hidup',
                ]);
            }
        }
    }
}
