<?php

namespace App\Http\Controllers;

use App\Models\BirthPlan;
use App\Models\Mother;
use Illuminate\Http\Request;

class BirthPlanController extends Controller
{
    /**
     * Store a new birth plan.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'penolong' => 'nullable|string',
            'tempat' => 'nullable|string',
            'pendamping' => 'nullable|string',
            'transportasi' => 'nullable|string',
            'pendonor_darah' => 'nullable|string',
        ]);

        $validated['mother_id'] = $mother->id;

        BirthPlan::create($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data rencana persalinan berhasil disimpan.');
    }

    /**
     * Update birth plan.
     */
    public function update(Request $request, BirthPlan $birthPlan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'penolong' => 'nullable|string',
            'tempat' => 'nullable|string',
            'pendamping' => 'nullable|string',
            'transportasi' => 'nullable|string',
            'pendonor_darah' => 'nullable|string',
        ]);

        $birthPlan->update($validated);

        return redirect()->route('mothers.show', $birthPlan->mother_id)
            ->with('success', 'Data rencana persalinan berhasil diperbarui.');
    }

    /**
     * Delete birth plan.
     */
    public function destroy(BirthPlan $birthPlan)
    {
        $motherId = $birthPlan->mother_id;
        $birthPlan->delete();

        return redirect()->route('mothers.show', $motherId)
            ->with('success', 'Data rencana persalinan berhasil dihapus.');
    }
}
