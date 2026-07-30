<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotherController;
use App\Http\Controllers\AncVisitController;
use App\Http\Controllers\MidwifeExamController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PostpartumVisitController;
use App\Http\Controllers\FamilyPlanningController;
use App\Http\Controllers\BirthPlanController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\GeneralTreatmentController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\KbRegisterController;
use App\Http\Controllers\BirthReportController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// PUBLIC ROUTES (Tanpa Login)
// ==========================================
Route::get('/monitor-antrian', [QueueController::class, 'monitor'])->name('antrian.monitor');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==========================================
    // ANTRIAN (Queue Management — RBR + TBS)
    // ==========================================
    Route::get('/antrian', [QueueController::class, 'index'])->name('antrian.index');
    Route::get('/antrian/create', [QueueController::class, 'create'])->name('antrian.create');
    Route::post('/antrian', [QueueController::class, 'store'])->name('antrian.store');
    Route::get('/antrian/riwayat', [QueueController::class, 'riwayat'])->name('antrian.riwayat');
    Route::patch('/antrian/{antrian}/panggil', [QueueController::class, 'panggil'])->name('antrian.panggil');
    Route::patch('/antrian/{antrian}/layani', [QueueController::class, 'layani'])->name('antrian.layani');
    Route::patch('/antrian/{antrian}/selesai', [QueueController::class, 'selesai'])->name('antrian.selesai');
    Route::patch('/antrian/{antrian}/batal', [QueueController::class, 'batal'])->name('antrian.batal');
    Route::post('/antrian/suggest-prioritas', [QueueController::class, 'suggestPrioritas'])->name('antrian.suggest');
    Route::delete('/antrian/{antrian}', [QueueController::class, 'destroy'])->name('antrian.destroy');
    Route::delete('/antrian-hapus-semua', [QueueController::class, 'destroyAll'])->name('antrian.destroyAll');

    // ==========================================
    // PASIEN (Patient Management)
    // ==========================================
    Route::resource('patients', PatientController::class);

    // Berobat Umum
    Route::post('/patients/{patient}/treatment', [GeneralTreatmentController::class, 'store'])->name('treatment.store');
    Route::put('/treatment/{treatment}', [GeneralTreatmentController::class, 'update'])->name('treatment.update');
    Route::delete('/treatment/{treatment}', [GeneralTreatmentController::class, 'destroy'])->name('treatment.destroy');

    // Imunisasi
    Route::post('/patients/{patient}/immunization', [ImmunizationController::class, 'store'])->name('immunization.store');
    Route::put('/immunization/{immunization}', [ImmunizationController::class, 'update'])->name('immunization.update');
    Route::delete('/immunization/{immunization}', [ImmunizationController::class, 'destroy'])->name('immunization.destroy');

    // KB Register
    Route::post('/patients/{patient}/kb-register', [KbRegisterController::class, 'store'])->name('kb-register.store');
    Route::put('/kb-register/{kbRegister}', [KbRegisterController::class, 'update'])->name('kb-register.update');
    Route::delete('/kb-register/{kbRegister}', [KbRegisterController::class, 'destroy'])->name('kb-register.destroy');

    // KB Visit
    Route::post('/kb-register/{kbRegister}/visit', [KbRegisterController::class, 'storeVisit'])->name('kb-visit.store');

    // Birth Report (Lahiran/Partus)
    Route::post('/patients/{patient}/birth-report', [BirthReportController::class, 'store'])->name('birth-report.store');
    Route::put('/birth-report/{birthReport}', [BirthReportController::class, 'update'])->name('birth-report.update');
    Route::delete('/birth-report/{birthReport}', [BirthReportController::class, 'destroy'])->name('birth-report.destroy');

    // Print Pasien
    Route::get('/patients/{patient}/print', [PrintController::class, 'patientReport'])->name('patients.print');

    // ==========================================
    // KEHAMILAN (Mother / Kartu Ibu)
    // ==========================================
    Route::resource('mothers', MotherController::class);

    // ANC Visits
    Route::post('/mothers/{mother}/anc', [AncVisitController::class, 'store'])->name('anc.store');
    Route::put('/anc/{ancVisit}', [AncVisitController::class, 'update'])->name('anc.update');
    Route::delete('/anc/{ancVisit}', [AncVisitController::class, 'destroy'])->name('anc.destroy');

    // Midwife Exam (Pemeriksaan Bidan)
    Route::post('/mothers/{mother}/midwife-exam', [MidwifeExamController::class, 'store'])->name('midwife-exam.store');

    // Delivery (Persalinan)
    Route::post('/mothers/{mother}/delivery', [DeliveryController::class, 'store'])->name('delivery.store');
    Route::put('/delivery/{delivery}', [DeliveryController::class, 'update'])->name('delivery.update');

    // Postpartum Visits (Nifas)
    Route::post('/mothers/{mother}/postpartum', [PostpartumVisitController::class, 'store'])->name('postpartum.store');
    Route::put('/postpartum/{postpartumVisit}', [PostpartumVisitController::class, 'update'])->name('postpartum.update');
    Route::delete('/postpartum/{postpartumVisit}', [PostpartumVisitController::class, 'destroy'])->name('postpartum.destroy');

    // Family Planning (KB)
    Route::post('/mothers/{mother}/kb', [FamilyPlanningController::class, 'store'])->name('kb.store');
    Route::put('/kb/{familyPlanning}', [FamilyPlanningController::class, 'update'])->name('kb.update');
    Route::delete('/kb/{familyPlanning}', [FamilyPlanningController::class, 'destroy'])->name('kb.destroy');

    // Birth Plan (Rencana Persalinan)
    Route::post('/mothers/{mother}/birth-plan', [BirthPlanController::class, 'store'])->name('birth-plan.store');
    Route::put('/birth-plan/{birthPlan}', [BirthPlanController::class, 'update'])->name('birth-plan.update');
    Route::delete('/birth-plan/{birthPlan}', [BirthPlanController::class, 'destroy'])->name('birth-plan.destroy');

    // Print Kartu Ibu
    Route::get('/mothers/{mother}/print', [PrintController::class, 'preview'])->name('print.preview');
});
