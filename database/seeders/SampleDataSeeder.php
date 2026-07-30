<?php

namespace Database\Seeders;

use App\Models\Mother;
use App\Models\AncVisit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $bidan = User::where('role', 'bidan')->first();

        $mothers = [
            [
                'no_registrasi' => 'IBU-2026-001',
                'nik' => '3275014501900001',
                'nama_ibu' => 'Siti Fatimah',
                'nama_suami' => 'Ahmad Hidayat',
                'tgl_lahir' => '1990-01-25',
                'umur' => 36,
                'alamat' => 'Jl. Melati No. 15',
                'rt' => '03',
                'rw' => '05',
                'desa_kelurahan' => 'Sukamaju',
                'kecamatan' => 'Cibeunying',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'agama' => 'Islam',
                'pendidikan' => 'SMA',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'pekerjaan_suami' => 'Wiraswasta',
                'gol_darah' => 'O',
                'telp_hp' => '081234567890',
                'puskesmas' => 'Puskesmas Sukamaju',
                'gravida' => 2,
                'partus' => 1,
                'abortus' => 0,
                'hidup' => 1,
            ],
            [
                'no_registrasi' => 'IBU-2026-002',
                'nik' => '3275024612920002',
                'nama_ibu' => 'Dewi Lestari',
                'nama_suami' => 'Budi Santoso',
                'tgl_lahir' => '1992-12-06',
                'umur' => 33,
                'alamat' => 'Jl. Anggrek Raya No. 8',
                'rt' => '01',
                'rw' => '02',
                'desa_kelurahan' => 'Cibaduyut',
                'kecamatan' => 'Bojongloa',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan_ibu' => 'Guru',
                'pekerjaan_suami' => 'PNS',
                'gol_darah' => 'A',
                'telp_hp' => '082345678901',
                'puskesmas' => 'Puskesmas Cibaduyut',
                'gravida' => 1,
                'partus' => 0,
                'abortus' => 0,
                'hidup' => 0,
            ],
            [
                'no_registrasi' => 'IBU-2026-003',
                'nik' => '3275030303880003',
                'nama_ibu' => 'Rina Wulandari',
                'nama_suami' => 'Dedi Kurniawan',
                'tgl_lahir' => '1988-03-03',
                'umur' => 37,
                'alamat' => 'Jl. Mawar Indah No. 22',
                'rt' => '07',
                'rw' => '03',
                'desa_kelurahan' => 'Antapani',
                'kecamatan' => 'Antapani',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'agama' => 'Kristen',
                'pendidikan' => 'D3',
                'pekerjaan_ibu' => 'Perawat',
                'pekerjaan_suami' => 'Karyawan Swasta',
                'gol_darah' => 'B',
                'telp_hp' => '083456789012',
                'puskesmas' => 'Puskesmas Antapani',
                'gravida' => 3,
                'partus' => 2,
                'abortus' => 0,
                'hidup' => 2,
            ],
            [
                'no_registrasi' => 'IBU-2026-004',
                'nik' => '3275041507950004',
                'nama_ibu' => 'Nur Aisyah',
                'nama_suami' => 'Eko Prasetyo',
                'tgl_lahir' => '1995-07-15',
                'umur' => 30,
                'alamat' => 'Jl. Dahlia No. 5',
                'rt' => '02',
                'rw' => '08',
                'desa_kelurahan' => 'Arcamanik',
                'kecamatan' => 'Arcamanik',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'agama' => 'Islam',
                'pendidikan' => 'SMP',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'pekerjaan_suami' => 'Pedagang',
                'gol_darah' => 'AB',
                'telp_hp' => '084567890123',
                'puskesmas' => 'Puskesmas Arcamanik',
                'gravida' => 1,
                'partus' => 0,
                'abortus' => 0,
                'hidup' => 0,
            ],
            [
                'no_registrasi' => 'IBU-2026-005',
                'nik' => '3275052208930005',
                'nama_ibu' => 'Maya Anggraini',
                'nama_suami' => 'Fajar Nugroho',
                'tgl_lahir' => '1993-08-22',
                'umur' => 32,
                'alamat' => 'Jl. Kenanga No. 11',
                'rt' => '04',
                'rw' => '06',
                'desa_kelurahan' => 'Batununggal',
                'kecamatan' => 'Bandung Kidul',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan_ibu' => 'Apoteker',
                'pekerjaan_suami' => 'Dokter',
                'gol_darah' => 'O',
                'telp_hp' => '085678901234',
                'puskesmas' => 'Puskesmas Batununggal',
                'gravida' => 2,
                'partus' => 1,
                'abortus' => 0,
                'hidup' => 1,
            ],
        ];

        foreach ($mothers as $data) {
            $obsData = [
                'gravida' => $data['gravida'],
                'partus' => $data['partus'],
                'abortus' => $data['abortus'],
                'hidup' => $data['hidup'],
            ];
            unset($data['gravida'], $data['partus'], $data['abortus'], $data['hidup']);

            $data['created_by'] = $bidan?->id;
            $mother = Mother::create($data);
            $mother->obstetricHistory()->create($obsData);

            // Add sample ANC visits
            $ukStart = rand(8, 14);
            for ($i = 0; $i < rand(2, 4); $i++) {
                $uk = $ukStart + ($i * 4);
                $mother->ancVisits()->create([
                    'no_urut' => $i + 1,
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
                ]);
            }
        }
    }
}
