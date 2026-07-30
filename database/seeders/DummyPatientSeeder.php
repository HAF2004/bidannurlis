<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use App\Models\GeneralTreatment;
use App\Models\Immunization;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyPatientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $admin = User::first(); // get an admin or bidan id
        
        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $pendidikans = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3', 'Tidak Sekolah'];
        $pekerjaans = ['Wiraswasta', 'PNS', 'Karyawan Swasta', 'Guru', 'Buruh', 'Ibu Rumah Tangga', 'Pelajar/Mahasiswa', 'Tidak Bekerja'];
        $status_perkawinans = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
        $gol_darahs = ['A', 'B', 'AB', 'O'];

        $patients = [];
        for ($i = 1; $i <= 20; $i++) {
            $jk = $faker->randomElement(['L', 'P']);
            $patients[] = [
                'no_rm' => 'RM-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nik' => $faker->nik(),
                'nama' => $faker->name($jk == 'L' ? 'male' : 'female'),
                'jenis_kelamin' => $jk,
                'tanggal_lahir' => $faker->dateTimeBetween('-50 years', '-1 years')->format('Y-m-d'),
                'tempat_lahir' => $faker->city(),
                'alamat' => 'Jl. Kav. Keuangan Raya No.' . $faker->numberBetween(1, 100),
                'rt' => str_pad($faker->numberBetween(1, 15), 2, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
                'desa_kelurahan' => 'Kedaung',
                'kecamatan' => 'Pamulang',
                'kabupaten' => 'Tangerang Selatan',
                'provinsi' => 'Banten',
                'agama' => $faker->randomElement($agamas),
                'pendidikan' => $faker->randomElement($pendidikans),
                'pekerjaan' => $faker->randomElement($pekerjaans),
                'status_perkawinan' => $faker->randomElement($status_perkawinans),
                'nama_orangtua' => $faker->name(),
                'telp_hp' => $faker->numerify('08##########'),
                'gol_darah' => $faker->randomElement($gol_darahs),
                'no_bpjs' => $faker->boolean(70) ? $faker->numerify('000#########') : null,
                'created_by' => $admin ? $admin->id : 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Patient::insert($patients);

        // Tambahkan riwayat berobat dan imunisasi secara acak untuk setiap pasien
        $allPatients = Patient::all();
        foreach ($allPatients as $patient) {
            // Berobat Umum (0-3 kali)
            $jmlBerobat = rand(0, 3);
            for ($j = 0; $j < $jmlBerobat; $j++) {
                GeneralTreatment::create([
                    'patient_id' => $patient->id,
                    'tanggal_kunjungan' => $faker->dateTimeBetween('-1 years', 'now'),
                    'keluhan' => $faker->randomElement(['Demam', 'Batuk Pilek', 'Pusing', 'Sakit Perut', 'Diare']),
                    'td_sistol' => rand(100, 140),
                    'td_diastol' => rand(70, 90),
                    'suhu' => 36 + (rand(0, 30) / 10),
                    'bb_kg' => rand(40, 80),
                    'diagnosa' => $faker->randomElement(['ISPA', 'Dispepsia', 'Myalgia', 'Febris', 'Gastroenteritis']),
                    'tindakan' => 'Pemeriksaan Fisik',
                    'resep_obat' => $faker->randomElement(['Paracetamol 3x1', 'Antasida 3x1', 'Amoxicillin 3x1', 'Oralit']),
                    'created_by' => $admin ? $admin->id : 1,
                ]);
            }

            // Imunisasi (0-2 kali, lebih mungkin jika umur < 5 tahun)
            $umur = Carbon::parse($patient->tanggal_lahir)->age;
            if ($umur < 5 || rand(1, 10) > 7) {
                $jmlImunisasi = rand(1, 2);
                for ($j = 0; $j < $jmlImunisasi; $j++) {
                    Immunization::create([
                        'patient_id' => $patient->id,
                        'tanggal' => $faker->dateTimeBetween('-2 years', 'now'),
                        'jenis_vaksin' => $faker->randomElement(['BCG', 'Polio 1', 'DPT-HB-Hib 1', 'Campak', 'Hepatitis B']),
                        'dosis' => rand(1, 3),
                        'batch_no' => strtoupper($faker->bothify('VAK-####')),
                        'lokasi_penyuntikan' => $faker->randomElement(['Paha Kiri', 'Paha Kanan', 'Lengan Kiri']),
                        'bb_kg' => rand(3, 15) + (rand(0, 9) / 10),
                        'tb_cm' => rand(50, 90),
                        'petugas' => 'Bidan Nurlis',
                        'reaksi_kipi' => $faker->randomElement(['Tidak Ada', 'Demam Ringan', 'Bengkak Ringan', 'Tidak Ada']),
                        'created_by' => $admin ? $admin->id : 1,
                    ]);
                }
            }
        }
    }
}
