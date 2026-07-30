<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Mother;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Store a new delivery record.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'kala1_aktif_tanggal' => 'nullable|date',
            'kala1_aktif_jam' => 'nullable|string',
            'kala2_tanggal' => 'nullable|date',
            'kala2_jam' => 'nullable|string',
            'bayi_lahir_tanggal' => 'nullable|date',
            'bayi_lahir_jam' => 'nullable|string',
            'plasenta_lahir_tanggal' => 'nullable|date',
            'plasenta_lahir_jam' => 'nullable|string',
            'usia_kehamilan_minggu' => 'nullable|integer',
            'perdarahan_kala_iv_cc' => 'nullable|integer',
            'keadaan_ibu' => 'nullable|in:Hidup,Mati',
            'keadaan_bayi' => 'nullable|in:Hidup,Mati',
            'berat_bayi_gram' => 'nullable|integer',
            'panjang_badan_cm' => 'nullable|numeric',
            'lingkar_kepala_cm' => 'nullable|numeric',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'presentasi' => 'nullable|string',
            'tempat_persalinan' => 'nullable|string',
            'penolong' => 'nullable|string',
            'cara_persalinan' => 'nullable|string',
            'manajemen_aktif_kala_iii' => 'nullable|array',
            'imd' => 'nullable|in:< 1 jam,> 1 jam',
            'menggunakan_partograf' => 'nullable|boolean',
            'catat_buku_kia' => 'nullable|boolean',
            'komplikasi_persalinan' => 'nullable|array',
            'dirujuk_ke' => 'nullable|string',
        ]);

        $validated['mother_id'] = $mother->id;

        Delivery::create($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data persalinan berhasil disimpan.');
    }

    /**
     * Update delivery record.
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validated = $request->validate([
            'kala1_aktif_tanggal' => 'nullable|date',
            'kala1_aktif_jam' => 'nullable|string',
            'kala2_tanggal' => 'nullable|date',
            'kala2_jam' => 'nullable|string',
            'bayi_lahir_tanggal' => 'nullable|date',
            'bayi_lahir_jam' => 'nullable|string',
            'plasenta_lahir_tanggal' => 'nullable|date',
            'plasenta_lahir_jam' => 'nullable|string',
            'usia_kehamilan_minggu' => 'nullable|integer',
            'perdarahan_kala_iv_cc' => 'nullable|integer',
            'keadaan_ibu' => 'nullable|in:Hidup,Mati',
            'keadaan_bayi' => 'nullable|in:Hidup,Mati',
            'berat_bayi_gram' => 'nullable|integer',
            'panjang_badan_cm' => 'nullable|numeric',
            'lingkar_kepala_cm' => 'nullable|numeric',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'presentasi' => 'nullable|string',
            'tempat_persalinan' => 'nullable|string',
            'penolong' => 'nullable|string',
            'cara_persalinan' => 'nullable|string',
            'manajemen_aktif_kala_iii' => 'nullable|array',
            'imd' => 'nullable|in:< 1 jam,> 1 jam',
            'menggunakan_partograf' => 'nullable|boolean',
            'catat_buku_kia' => 'nullable|boolean',
            'komplikasi_persalinan' => 'nullable|array',
            'dirujuk_ke' => 'nullable|string',
        ]);

        $delivery->update($validated);

        return redirect()->route('mothers.show', $delivery->mother_id)
            ->with('success', 'Data persalinan berhasil diperbarui.');
    }
}
