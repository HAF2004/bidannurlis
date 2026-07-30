<?php

namespace Database\Seeders;

use App\Models\Mother;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FormMatchingSampleSeeder extends Seeder
{
    public function run(): void
    {
        $bidan = User::where('role', 'bidan')->first();

        // Data from the physical form image
        $mother = Mother::create([
            'puskesmas' => 'Puskemas Cimahi Selatan',
            'no_registrasi' => '3640044502020000',
            'nama_ibu' => 'Suharini',
            'nama_suami' => 'Viky Suwandi',
            'tgl_lahir' => Carbon::createFromFormat('d/m/Y', '05/07/1984'),
            'umur' => 28,
            'alamat' => 'Jl. C. Mandiri',
            'rt' => '5',
            'rw' => '1',
            'desa_kelurahan' => 'Serua Indah',
            'kecamatan' => 'Ciputat',
            'kabupaten' => 'Tangsel',
            'provinsi' => 'Banten',
            'agama' => 'Islam',
            'pendidikan' => 'SMK',
            'pekerjaan_ibu' => '-',
            'pekerjaan_suami' => 'Wiraswasta',
            'tgl_register' => null,
            'tgl_menikah' => Carbon::createFromFormat('d/m/Y', '10/10/2010'),
            'jamkes' => '00022223551133',
            'gol_darah' => 'AB',
            'telp_hp' => '08566137999',
            'posyandu' => '-',
            'nama_kader' => '-',
            'nama_dukun' => '-',
            // Riwayat Obstetrik
            'gravida' => 3,
            'partus' => 2,
            'abortus' => 0,
            'hidup' => 2,
            'created_by' => $bidan?->id,
        ]);

        // Pemeriksaan Bidan
        $mother->midwifeExam()->create([
            'tanggal_periksa' => Carbon::createFromFormat('d/m/Y', '13/10/2025'),
            'tanggal_hpht' => Carbon::createFromFormat('d/m/Y', '13/10/2025'),
            'taksiran_persalinan' => Carbon::createFromFormat('d/m/Y', '20/07/2026'),
            'tgl_persalinan_sebelumnya' => null,
            'bb_sebelum_hamil' => null,
            'tinggi_badan' => null,
            'lila' => null,
            'status_gizi' => 'Normal',
            'buku_kia' => 'Memiliki',
            'riwayat_komplikasi_kebidanan' => null,
            'riwayat_kronis_dan_alergi' => null,
        ]);

        // Rencana Persalinan (3 rows from form)
        $mother->birthPlans()->createMany([
            [
                'tanggal' => Carbon::createFromFormat('d/m/Y', '01/01/2014'),
                'penolong' => 'Bidan',
                'tempat' => 'Rumah',
                'pendamping' => 'Suami',
                'transportasi' => 'Suami',
                'pendonor_darah' => 'Keluarga',
            ],
            [
                'tanggal' => Carbon::createFromFormat('d/m/Y', '01/01/2018'),
                'penolong' => 'Bidan',
                'tempat' => 'Rumah',
                'pendamping' => 'Suami',
                'transportasi' => 'Suami',
                'pendonor_darah' => 'Teman',
            ],
            [
                'tanggal' => Carbon::createFromFormat('d/m/Y', '01/01/2021'),
                'penolong' => 'Bidan',
                'tempat' => 'RSIA',
                'pendamping' => 'Keluarga',
                'transportasi' => 'Keluarga',
                'pendonor_darah' => 'Keluarga',
            ],
        ]);

        // Persalinan
        $mother->deliveries()->create([
            'kala1_aktif_tanggal' => Carbon::createFromFormat('d/m/Y', '20/07/2026'),
            'kala1_aktif_jam' => '08:30',
            'kala2_tanggal' => Carbon::createFromFormat('d/m/Y', '20/07/2026'),
            'kala2_jam' => '14:15',
            'bayi_lahir_tanggal' => Carbon::createFromFormat('d/m/Y', '20/07/2026'),
            'bayi_lahir_jam' => '14:20',
            'plasenta_lahir_tanggal' => Carbon::createFromFormat('d/m/Y', '20/07/2026'),
            'plasenta_lahir_jam' => '14:35',
            'perdarahan_kala_iv_cc' => 150,
            'usia_kehamilan_minggu' => 39,
            'keadaan_ibu' => 'Hidup',
            'keadaan_bayi' => 'Hidup',
            'berat_bayi_gram' => 3200,
            'panjang_badan_cm' => 49,
            'jenis_kelamin' => 'Laki-laki',
            'lingkar_kepala_cm' => 34,
            'presentasi' => 'Belakang Kepala',
            'tempat_persalinan' => 'RSIA',
            'penolong' => 'Bidan',
            'cara_persalinan' => 'Normal',
            'manajemen_aktif_kala_iii' => ['Injeksi Oksitosin', 'Peregangan Tali Pusat Terkendali', 'Masase Fundus Uteri'],
            'imd' => '< 1 jam',
            'menggunakan_partograf' => true,
            'catat_buku_kia' => true,
            'komplikasi_persalinan' => [],
            'penanganan_komplikasi' => 'Tidak',
            'penanganan_keterangan' => null,
            'dirujuk_ke' => 'Tidak Dirujuk',
            'keadaan_tiba' => 'Hidup',
            'keadaan_pulang' => 'Hidup',
            'alamat_bersalin' => 'RSIA Bunda Ciputat',
        ]);

        // Pemeriksaan Nifas (KF1, KF2, KF3)
        $mother->postpartumVisits()->createMany([
            [
                'tanggal' => Carbon::createFromFormat('d/m/Y', '20/07/2026'),
                'hari_ke' => 1,
                'kf' => 'KF1',
                'td_mmhg' => '120/80',
                'suhu_c' => 36.8,
                'pelayanan' => ['Catat di Buku KIA', 'Fe/TTD', 'Vit A'],
                'komplikasi' => [],
                'penanganan_komplikasi_kebidanan' => null,
                'dirujuk_ke' => null,
                'keadaan_tiba' => 'H',
                'keadaan_pulang' => 'H',
            ],
            [
                'tanggal' => Carbon::createFromFormat('d/m/Y', '27/07/2026'),
                'hari_ke' => 7,
                'kf' => 'KF2',
                'td_mmhg' => '115/75',
                'suhu_c' => 36.5,
                'pelayanan' => ['Catat di Buku KIA', 'Fe/TTD'],
                'komplikasi' => [],
                'penanganan_komplikasi_kebidanan' => null,
                'dirujuk_ke' => null,
                'keadaan_tiba' => 'H',
                'keadaan_pulang' => 'H',
            ],
            [
                'tanggal' => Carbon::createFromFormat('d/m/Y', '20/08/2026'),
                'hari_ke' => 30,
                'kf' => 'KF3',
                'td_mmhg' => '110/70',
                'suhu_c' => 36.6,
                'pelayanan' => ['Catat di Buku KIA'],
                'komplikasi' => [],
                'penanganan_komplikasi_kebidanan' => null,
                'dirujuk_ke' => null,
                'keadaan_tiba' => 'H',
                'keadaan_pulang' => 'H',
            ],
        ]);

        // KB Paska Salin
        $mother->familyPlannings()->create([
            'metode_kb' => 'Suntik',
            'tanggal' => Carbon::createFromFormat('d/m/Y', '20/08/2026'),
            'rencana' => 'Suntik 3 bulan',
            'pelaksanaan' => 'Dilakukan',
        ]);
    }
}
