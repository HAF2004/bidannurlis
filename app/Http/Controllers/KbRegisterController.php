<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\KbRegister;
use App\Models\KbVisit;
use Illuminate\Http\Request;

class KbRegisterController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'tanggal_daftar' => 'required|date',
            'nama_suami' => 'nullable|string|max:255',
            'nik_suami' => 'nullable|string|max:16',
            'nik_istri' => 'nullable|string|max:16',
            'no_hp' => 'nullable|string|max:20',
            'metode_kb' => 'nullable|string|max:50',
            'status_peserta' => 'required|in:Baru,Lama',
            'informed_consent' => 'nullable|boolean',
            'pasca_persalinan' => 'nullable|boolean',
            'pasca_keguguran' => 'nullable|boolean',
            'keterangan' => 'nullable|string',
        ]);

        $data['patient_id'] = $patient->id;
        $data['created_by'] = auth()->id();
        $data['no_register'] = 'KB-' . str_pad(KbRegister::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $data['informed_consent'] = $request->boolean('informed_consent');
        $data['pasca_persalinan'] = $request->boolean('pasca_persalinan');
        $data['pasca_keguguran'] = $request->boolean('pasca_keguguran');

        KbRegister::create($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data KB berhasil disimpan.');
    }

    public function update(Request $request, KbRegister $kbRegister)
    {
        $data = $request->validate([
            'tanggal_daftar' => 'required|date',
            'nama_suami' => 'nullable|string|max:255',
            'metode_kb' => 'nullable|string|max:50',
            'status_peserta' => 'required|in:Baru,Lama',
            'keterangan' => 'nullable|string',
        ]);

        $kbRegister->update($data);

        return redirect()->route('patients.show', $kbRegister->patient_id)
            ->with('success', 'Data KB berhasil diperbarui.');
    }

    public function storeVisit(Request $request, KbRegister $kbRegister)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'metode_kb' => 'nullable|string|max:50',
            'keluhan' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'komplikasi_berat' => 'nullable|boolean',
            'kegagalan' => 'nullable|boolean',
            'pencabutan' => 'nullable|boolean',
            'sumber_biaya' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();
        $data['komplikasi_berat'] = $request->boolean('komplikasi_berat');
        $data['kegagalan'] = $request->boolean('kegagalan');
        $data['pencabutan'] = $request->boolean('pencabutan');

        $kbRegister->visits()->create($data);

        return redirect()->route('patients.show', $kbRegister->patient_id)
            ->with('success', 'Kunjungan KB berhasil disimpan.');
    }

    public function destroy(KbRegister $kbRegister)
    {
        $patientId = $kbRegister->patient_id;
        $kbRegister->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Data KB berhasil dihapus.');
    }
}
