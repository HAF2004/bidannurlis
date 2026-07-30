<?php

namespace App\Http\Controllers;

use App\Models\MidwifeExam;
use App\Models\Mother;
use Illuminate\Http\Request;

class MidwifeExamController extends Controller
{
    /**
     * Store or update midwife exam data.
     */
    public function store(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'tanggal_periksa' => 'required|date',
            'tanggal_hpht' => 'nullable|date',
            'taksiran_persalinan' => 'nullable|date',
            'tgl_persalinan_sebelumnya' => 'nullable|date',
            'bb_sebelum_hamil' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            'status_gizi' => 'nullable|in:KEK,Normal',
            'buku_kia' => 'nullable|in:Memiliki,Tidak Memiliki',
            'riwayat_komplikasi_kebidanan' => 'nullable|string',
            'riwayat_kronis_dan_alergi' => 'nullable|string',
        ]);

        $validated['mother_id'] = $mother->id;

        // Create or update (one exam per mother)
        MidwifeExam::updateOrCreate(
            ['mother_id' => $mother->id],
            $validated
        );

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data pemeriksaan bidan berhasil disimpan.');
    }
}
