<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\Patient;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    /**
     * Show print preview for Kartu Ibu (single page with left/right layout)
     */
    public function preview(Mother $mother)
    {
        $mother->load([
            'midwifeExam',
            'deliveries',
            'postpartumVisits',
            'familyPlannings',
            'birthPlans',
            'ancVisits' => fn($q) => $q->orderBy('tanggal_kunjungan'),
        ]);

        return view('print.kartu-ibu', compact('mother'));
    }

    /**
     * Print patient report with all service history
     */
    public function patientReport(Patient $patient)
    {
        $patient->load([
            'generalTreatments' => fn($q) => $q->orderBy('tanggal_kunjungan'),
            'immunizations' => fn($q) => $q->orderBy('tanggal'),
            'kbRegisters.visits',
            'birthReports' => fn($q) => $q->orderBy('tanggal_partus'),
        ]);

        return view('print.patient-report', compact('patient'));
    }
}
