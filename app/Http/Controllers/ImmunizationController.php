<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Immunization;
use Illuminate\Http\Request;

class ImmunizationController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis_vaksin' => 'required|string|max:100',
            'dosis' => 'nullable|integer',
            'batch_no' => 'nullable|string|max:50',
            'lokasi_penyuntikan' => 'nullable|string|max:100',
            'petugas' => 'nullable|string|max:100',
            'reaksi_kipi' => 'nullable|string',
            'bb_kg' => 'nullable|numeric',
            'tb_cm' => 'nullable|numeric',
            'umur_saat_imunisasi' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'mother_id' => 'nullable|exists:mothers,id',
        ]);

        $data['patient_id'] = $patient->id;
        $data['created_by'] = auth()->id();
        Immunization::create($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data imunisasi berhasil disimpan.');
    }

    public function update(Request $request, Immunization $immunization)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'jenis_vaksin' => 'required|string|max:100',
            'dosis' => 'nullable|integer',
            'batch_no' => 'nullable|string|max:50',
            'lokasi_penyuntikan' => 'nullable|string|max:100',
            'petugas' => 'nullable|string|max:100',
            'reaksi_kipi' => 'nullable|string',
            'bb_kg' => 'nullable|numeric',
            'tb_cm' => 'nullable|numeric',
            'umur_saat_imunisasi' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $immunization->update($data);

        return redirect()->route('patients.show', $immunization->patient_id)
            ->with('success', 'Data imunisasi berhasil diperbarui.');
    }

    public function destroy(Immunization $immunization)
    {
        $patientId = $immunization->patient_id;
        $immunization->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Data imunisasi berhasil dihapus.');
    }
}
