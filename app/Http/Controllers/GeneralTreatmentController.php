<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\GeneralTreatment;
use Illuminate\Http\Request;

class GeneralTreatmentController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'td_sistol' => 'nullable|integer',
            'td_diastol' => 'nullable|integer',
            'suhu' => 'nullable|numeric',
            'nadi' => 'nullable|integer',
            'napas' => 'nullable|integer',
            'bb_kg' => 'nullable|numeric',
            'tb_cm' => 'nullable|numeric',
            'pemeriksaan_fisik' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $data['patient_id'] = $patient->id;
        $data['created_by'] = auth()->id();
        GeneralTreatment::create($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data berobat umum berhasil disimpan.');
    }

    public function update(Request $request, GeneralTreatment $treatment)
    {
        $data = $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'keluhan' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'td_sistol' => 'nullable|integer',
            'td_diastol' => 'nullable|integer',
            'suhu' => 'nullable|numeric',
            'nadi' => 'nullable|integer',
            'napas' => 'nullable|integer',
            'bb_kg' => 'nullable|numeric',
            'tb_cm' => 'nullable|numeric',
            'pemeriksaan_fisik' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep_obat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $treatment->update($data);

        return redirect()->route('patients.show', $treatment->patient_id)
            ->with('success', 'Data berobat umum berhasil diperbarui.');
    }

    public function destroy(GeneralTreatment $treatment)
    {
        $patientId = $treatment->patient_id;
        $treatment->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Data berobat umum berhasil dihapus.');
    }
}
