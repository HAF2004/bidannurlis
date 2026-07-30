<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\BirthReport;
use Illuminate\Http\Request;

class BirthReportController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'tanggal_partus' => 'required|date',
            'jam_partus' => 'nullable|string|max:10',
            'nama_ibu' => 'required|string|max:255',
            'alamat_ibu' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'nama_suami' => 'nullable|string|max:255',
            'umur_ibu' => 'nullable|integer',
            'alamat_bidan' => 'nullable|string',
            'anak_ke' => 'nullable|integer',
            'jenis_partus' => 'required|in:Normal,SC,Vakum,Forseps',
            'keadaan_bayi' => 'required|in:Hidup,Mati',
            'jenis_kelamin_bayi' => 'nullable|in:L,P',
            'bb_bayi_gram' => 'nullable|integer',
            'pb_bayi_cm' => 'nullable|integer',
            'keadaan_ibu' => 'nullable|string|max:255',
            'bb_ibu_kg' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
            'mother_id' => 'nullable|exists:mothers,id',
        ]);

        $data['patient_id'] = $patient->id;
        $data['created_by'] = auth()->id();
        BirthReport::create($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Laporan partus berhasil disimpan.');
    }

    public function update(Request $request, BirthReport $birthReport)
    {
        $data = $request->validate([
            'tanggal_partus' => 'required|date',
            'jam_partus' => 'nullable|string|max:10',
            'nama_ibu' => 'required|string|max:255',
            'alamat_ibu' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'nama_suami' => 'nullable|string|max:255',
            'umur_ibu' => 'nullable|integer',
            'anak_ke' => 'nullable|integer',
            'jenis_partus' => 'required|in:Normal,SC,Vakum,Forseps',
            'keadaan_bayi' => 'required|in:Hidup,Mati',
            'jenis_kelamin_bayi' => 'nullable|in:L,P',
            'bb_bayi_gram' => 'nullable|integer',
            'pb_bayi_cm' => 'nullable|integer',
            'keadaan_ibu' => 'nullable|string|max:255',
            'bb_ibu_kg' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $birthReport->update($data);

        return redirect()->route('patients.show', $birthReport->patient_id)
            ->with('success', 'Laporan partus berhasil diperbarui.');
    }

    public function destroy(BirthReport $birthReport)
    {
        $patientId = $birthReport->patient_id;
        $birthReport->delete();

        return redirect()->route('patients.show', $patientId)
            ->with('success', 'Laporan partus berhasil dihapus.');
    }
}
