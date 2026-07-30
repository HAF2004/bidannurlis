<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\AncVisit;
use App\Models\Delivery;
use App\Models\Patient;
use App\Models\GeneralTreatment;
use App\Models\Immunization;
use App\Models\KbRegister;
use App\Models\BirthReport;
use App\Models\Antrian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $stats = [
            'total_pasien' => Patient::count(),
            'total_ibu' => Mother::count(),
            'pasien_bulan_ini' => Patient::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'berobat_bulan_ini' => GeneralTreatment::whereMonth('tanggal_kunjungan', now()->month)
                ->whereYear('tanggal_kunjungan', now()->year)
                ->count(),
            'imunisasi_bulan_ini' => Immunization::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'pemeriksaan_bulan_ini' => AncVisit::whereMonth('tanggal_kunjungan', now()->month)
                ->whereYear('tanggal_kunjungan', now()->year)
                ->count(),
            'persalinan_bulan_ini' => Delivery::whereMonth('bayi_lahir_tanggal', now()->month)
                ->whereYear('bayi_lahir_tanggal', now()->year)
                ->count(),
            'kb_aktif' => KbRegister::count(),
            'antrian_hari_ini' => Antrian::hariIni()->count(),
            'antrian_menunggu' => Antrian::hariIni()->menunggu()->count(),
        ];

        $recentMothers = Mother::latest()->take(5)->get();
        $recentVisits = AncVisit::with('mother')->latest()->take(5)->get();
        $recentPatients = Patient::latest()->take(5)->get();
        $recentTreatments = GeneralTreatment::with('patient')->latest('tanggal_kunjungan')->take(5)->get();

        return view('dashboard', compact('stats', 'recentMothers', 'recentVisits', 'recentPatients', 'recentTreatments'));
    }
}
