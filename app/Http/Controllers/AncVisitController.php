<?php

namespace App\Http\Controllers;

use App\Models\AncVisit;
use App\Models\Mother;
use Illuminate\Http\Request;

class AncVisitController extends Controller
{
    /**
     * Store a newly created ANC visit.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'usia_kehamilan_minggu' => 'nullable|integer|min:1|max:45',
            'trimester' => 'nullable|in:I,II,III',
            'anamnesis' => 'nullable',
            'bb_kg' => 'nullable|numeric',
            'td_sistol' => 'nullable|integer',
            'td_diastol' => 'nullable|integer',
            'suhu_c' => 'nullable|numeric',
            'tfu_cm' => 'nullable|numeric',
            'refleks_patella' => 'nullable|in:+,-',
            'djj' => 'nullable|integer',
            'presentasi' => 'nullable',
            'jumlah_janin' => 'nullable|integer|min:1',
            'tbj_gram' => 'nullable|integer',
            'status_imunisasi_tt' => 'nullable',
            'fe_tablet' => 'nullable|integer',
            'catat_buku_kia' => 'nullable|boolean',
            'pmt_bumil' => 'nullable|boolean',
            'kelas_ibu' => 'nullable|boolean',
            'hb' => 'nullable|numeric',
            'gula_darah' => 'nullable',
            'protein_urin' => 'nullable',
            'hiv' => 'nullable',
            'sifilis' => 'nullable',
            'hbsag' => 'nullable',
            'komplikasi' => 'nullable',
            'dirujuk_ke' => 'nullable',
            'keadaan_datang' => 'nullable|in:hidup,mati',
            'keadaan_pulang' => 'nullable|in:hidup,mati',
            'keterangan' => 'nullable',
        ]);

        $validated['mother_id'] = $mother->id;
        $validated['no_urut'] = $mother->ancVisits()->count() + 1;

        AncVisit::create($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data ANC berhasil disimpan.');
    }

    /**
     * Update the specified ANC visit.
     */
    public function update(Request $request, AncVisit $ancVisit)
    {
        $validated = $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'usia_kehamilan_minggu' => 'nullable|integer|min:1|max:45',
            'trimester' => 'nullable|in:I,II,III',
            'anamnesis' => 'nullable',
            'bb_kg' => 'nullable|numeric',
            'td_sistol' => 'nullable|integer',
            'td_diastol' => 'nullable|integer',
            'suhu_c' => 'nullable|numeric',
            'tfu_cm' => 'nullable|numeric',
            'refleks_patella' => 'nullable|in:+,-',
            'djj' => 'nullable|integer',
            'presentasi' => 'nullable',
            'jumlah_janin' => 'nullable|integer|min:1',
            'tbj_gram' => 'nullable|integer',
            'status_imunisasi_tt' => 'nullable',
            'fe_tablet' => 'nullable|integer',
            'hb' => 'nullable|numeric',
            'komplikasi' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        $ancVisit->update($validated);

        return redirect()->route('mothers.show', $ancVisit->mother_id)
            ->with('success', 'Data ANC berhasil diperbarui.');
    }

    /**
     * Remove the specified ANC visit.
     */
    public function destroy(AncVisit $ancVisit)
    {
        $motherId = $ancVisit->mother_id;
        $ancVisit->delete();

        return redirect()->route('mothers.show', $motherId)
            ->with('success', 'Data ANC berhasil dihapus.');
    }
}
