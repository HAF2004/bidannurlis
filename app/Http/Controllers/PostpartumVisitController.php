<?php

namespace App\Http\Controllers;

use App\Models\PostpartumVisit;
use App\Models\Mother;
use Illuminate\Http\Request;

class PostpartumVisitController extends Controller
{
    /**
     * Store a new postpartum visit.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'hari_ke' => 'nullable|integer',
            'kf' => 'nullable|in:KF1,KF2,KF3',
            'td_mmhg' => 'nullable|string',
            'suhu_c' => 'nullable|numeric',
            'pelayanan' => 'nullable|array',
            'komplikasi' => 'nullable|array',
            'penanganan_komplikasi_kebidanan' => 'nullable|string',
            'dirujuk_ke' => 'nullable|string',
            'keadaan_tiba' => 'nullable|in:H,M',
            'keadaan_pulang' => 'nullable|in:H,M',
        ]);

        $validated['mother_id'] = $mother->id;

        PostpartumVisit::create($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data pemeriksaan nifas berhasil disimpan.');
    }

    /**
     * Update postpartum visit.
     */
    public function update(Request $request, PostpartumVisit $postpartumVisit)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'hari_ke' => 'nullable|integer',
            'kf' => 'nullable|in:KF1,KF2,KF3',
            'td_mmhg' => 'nullable|string',
            'suhu_c' => 'nullable|numeric',
            'pelayanan' => 'nullable|array',
            'komplikasi' => 'nullable|array',
            'penanganan_komplikasi_kebidanan' => 'nullable|string',
            'dirujuk_ke' => 'nullable|string',
            'keadaan_tiba' => 'nullable|in:H,M',
            'keadaan_pulang' => 'nullable|in:H,M',
        ]);

        $postpartumVisit->update($validated);

        return redirect()->route('mothers.show', $postpartumVisit->mother_id)
            ->with('success', 'Data pemeriksaan nifas berhasil diperbarui.');
    }

    /**
     * Delete postpartum visit.
     */
    public function destroy(PostpartumVisit $postpartumVisit)
    {
        $motherId = $postpartumVisit->mother_id;
        $postpartumVisit->delete();

        return redirect()->route('mothers.show', $motherId)
            ->with('success', 'Data pemeriksaan nifas berhasil dihapus.');
    }
}
