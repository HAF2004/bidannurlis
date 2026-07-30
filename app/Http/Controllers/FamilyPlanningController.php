<?php

namespace App\Http\Controllers;

use App\Models\FamilyPlanning;
use App\Models\Mother;
use Illuminate\Http\Request;

class FamilyPlanningController extends Controller
{
    /**
     * Store a new family planning record.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'metode_kb' => 'nullable|string',
            'rencana' => 'nullable|string',
            'pelaksanaan' => 'nullable|string',
        ]);

        $validated['mother_id'] = $mother->id;

        FamilyPlanning::create($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data KB berhasil disimpan.');
    }

    /**
     * Update family planning record.
     */
    public function update(Request $request, FamilyPlanning $familyPlanning)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'metode_kb' => 'nullable|string',
            'rencana' => 'nullable|string',
            'pelaksanaan' => 'nullable|string',
        ]);

        $familyPlanning->update($validated);

        return redirect()->route('mothers.show', $familyPlanning->mother_id)
            ->with('success', 'Data KB berhasil diperbarui.');
    }

    /**
     * Delete family planning record.
     */
    public function destroy(FamilyPlanning $familyPlanning)
    {
        $motherId = $familyPlanning->mother_id;
        $familyPlanning->delete();

        return redirect()->route('mothers.show', $motherId)
            ->with('success', 'Data KB berhasil dihapus.');
    }
}
