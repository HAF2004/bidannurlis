<?php

namespace App\Services;

use App\Models\Antrian;
use Carbon\Carbon;

class TimeBasedSchedulingService
{
    /**
     * Calculate estimated service time for a new queue entry.
     *
     * @param Antrian $newAntrian
     * @return Carbon
     */
    public function calculateEstimatedTime(Antrian $newAntrian): Carbon
    {
        $now = Carbon::now();
        
        // We only care about today's queues
        $today = $newAntrian->tanggal;
        $newUrutan = $newAntrian->prioritas->urutan ?? 3; // 1 = Gawat, 2 = Mendesak, 3 = Biasa
        
        // 1. Get all waiting patients today
        $waitingPatients = Antrian::with('prioritas')
            ->where('tanggal', $today)
            ->where('status', 'menunggu')
            ->where('id', '!=', $newAntrian->id)
            ->get();
            
        $totalWaitMinutes = 0;
        
        foreach ($waitingPatients as $patient) {
            $patientUrutan = $patient->prioritas->urutan ?? 3;
            
            // Should this patient go before the new one?
            // Yes, if their priority is higher (urutan is smaller) OR
            // their priority is the same, but they registered earlier.
            if ($patientUrutan < $newUrutan || 
               ($patientUrutan == $newUrutan && $patient->waktu_daftar <= $newAntrian->waktu_daftar)) {
                
                $totalWaitMinutes += $patient->prioritas->estimasi_waktu ?? 10;
            }
        }
        
        // 2. Check currently served patient. 
        // If a Gawat patient is currently being served, add 5 min observation buffer.
        $currentlyServedGawat = Antrian::where('tanggal', $today)
            ->where('status', 'dilayani')
            ->whereHas('prioritas', function($q) {
                $q->where('kode', 'GAWAT');
            })->exists();
            
        if ($currentlyServedGawat) {
            $totalWaitMinutes += 5; // 5 menit toleransi/buffer
        }
        
        return $now->addMinutes($totalWaitMinutes);
    }
    
    /**
     * Recalculate estimates for all waiting patients 
     * (e.g. after a queue is skipped/cancelled or a Gawat patient arrives).
     */
    public function recalculateAllEstimates($tanggal)
    {
        $waitingPatients = Antrian::with('prioritas')
            ->where('tanggal', $tanggal)
            ->where('status', 'menunggu')
            ->get()
            ->sortBy(function($patient) {
                // Sort by priority first (asc), then waktu_daftar (asc)
                return sprintf('%02d-%s', $patient->prioritas->urutan ?? 3, $patient->waktu_daftar);
            });
            
        $now = Carbon::now();
        $accumulatedMinutes = 0;
        
        $currentlyServedGawat = Antrian::where('tanggal', $tanggal)
            ->where('status', 'dilayani')
            ->whereHas('prioritas', function($q) {
                $q->where('kode', 'GAWAT');
            })->exists();
            
        if ($currentlyServedGawat) {
            $accumulatedMinutes += 5; // 5 menit toleransi/buffer
        }
        
        foreach ($waitingPatients as $patient) {
            $estimatedTime = $now->copy()->addMinutes($accumulatedMinutes);
            $patient->estimasi_dilayani = $estimatedTime->format('H:i:s');
            $patient->save();
            
            $accumulatedMinutes += $patient->prioritas->estimasi_waktu ?? 10;
        }
    }
}
