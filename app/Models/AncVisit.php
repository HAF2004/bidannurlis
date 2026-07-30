<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AncVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'mother_id',
        'no_urut',
        'tanggal_kunjungan',
        'usia_kehamilan_minggu',
        'trimester',
        'anamnesis',
        'bb_kg',
        'td_sistol',
        'td_diastol',
        'suhu_c',
        'tfu_cm',
        'refleks_patella',
        'djj',
        'kepala_thd',
        'presentasi',
        'jumlah_janin',
        'tbj_gram',
        'konseling',
        'status_imunisasi_tt',
        'injeksi_tt',
        'fe_tablet',
        'catat_buku_kia',
        'pmt_bumil',
        'pmk_bumil_kek',
        'kelas_ibu',
        'hb',
        'anemia',
        'gula_darah',
        'thalasemia',
        'protein_urin',
        'hiv',
        'sifilis',
        'hbsag',
        'datang_dengan_hiv',
        'ditawarkan_tes_hiv',
        'hasil_hiv',
        'mendapatkan_arv',
        'p4hiv_arv',
        'p4hiv_profilaksis_anak',
        'malaria',
        'diberikan_kelambu',
        'hasil_malaria',
        'obat_malaria',
        'tb',
        'hasil_tb',
        'obat_tb',
        'ankylostoma',
        'ims',
        'diperiksa_ims',
        'diagnosis_ims',
        'penanganan_obat',
        'komplikasi',
        'dirujuk_ke',
        'keadaan_datang',
        'keadaan_pulang',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'catat_buku_kia' => 'boolean',
        'pmt_bumil' => 'boolean',
        'pmk_bumil_kek' => 'boolean',
        'kelas_ibu' => 'boolean',
        'injeksi_tt' => 'boolean',
        'datang_dengan_hiv' => 'boolean',
        'ditawarkan_tes_hiv' => 'boolean',
        'mendapatkan_arv' => 'boolean',
        'diberikan_kelambu' => 'boolean',
        'diperiksa_ims' => 'boolean',
    ];

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }
}
