<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Antrian;

// Clear today's queue
Antrian::where('tanggal', today())->delete();

// Fake request 1: normal patient, now
$request1 = [
    'nama_pasien' => 'Pasien Normal',
    'umur' => 25,
    'no_hp' => '081234567890',
    'keluhan' => 'Demam ringan',
    'prioritas_id' => 3, // Biasa
    'waktu_daftar' => now()->format('H:i')
];

$rc1 = new Illuminate\Http\Request();
$rc1->merge($request1);
app('App\Http\Controllers\QueueController')->store($rc1);

// Fake request 2: WA booking, 2 hours from now
$waktuWA = now()->addHours(2)->format('H:i');
$request2 = [
    'nama_pasien' => 'Pasien WA',
    'umur' => 30,
    'no_hp' => '081234567891',
    'keluhan' => 'Kontrol rutin',
    'prioritas_id' => 3, // Biasa
    'waktu_daftar' => $waktuWA
];
$rc2 = new Illuminate\Http\Request();
$rc2->merge($request2);
app('App\Http\Controllers\QueueController')->store($rc2);

// Fake request 3: Normal patient, now
$request3 = [
    'nama_pasien' => 'Pasien Normal 2',
    'umur' => 28,
    'no_hp' => '081234567892',
    'keluhan' => 'Batuk pilek',
    'prioritas_id' => 3, // Biasa
    'waktu_daftar' => now()->addMinutes(5)->format('H:i')
];
$rc3 = new Illuminate\Http\Request();
$rc3->merge($request3);
app('App\Http\Controllers\QueueController')->store($rc3);

// Tampilkan urutan
$antrians = Antrian::where('tanggal', today())
    ->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
    ->orderBy('prioritas.urutan', 'asc')
    ->orderBy('antrian.waktu_daftar', 'asc')
    ->select('antrian.nama_pasien', 'antrian.waktu_daftar', 'prioritas.nama as prioritas', 'antrian.estimasi_dilayani')
    ->get();

foreach ($antrians as $a) {
    echo "Nama: {$a->nama_pasien} | Prio: {$a->prioritas} | Masuk: {$a->waktu_daftar} | Estimasi: {$a->estimasi_dilayani}\n";
}
