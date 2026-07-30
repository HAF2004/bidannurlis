<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Prioritas;
use App\Models\Pengaturan;
use App\Models\Patient;
use App\Models\Mother;
use App\Services\RuleBasedReasoningService;
use App\Services\TimeBasedSchedulingService;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Halaman utama manajemen antrian (Bidan)
     */
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', today()->format('Y-m-d'));

        // Ambil antrian urut berdasarkan RBR (prioritas) + TBS (waktu)
        $antrians = Antrian::with('prioritas', 'patient')
            ->where('tanggal', $tanggal)
            ->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
            ->orderBy('prioritas.urutan', 'asc')
            ->orderBy('antrian.waktu_daftar', 'asc')
            ->select('antrian.*')
            ->get();

        // Statistik hari ini
        $stats = [
            'total' => $antrians->count(),
            'menunggu' => $antrians->where('status', 'menunggu')->count(),
            'dipanggil' => $antrians->where('status', 'dipanggil')->count(),
            'dilayani' => $antrians->where('status', 'dilayani')->count(),
            'selesai' => $antrians->where('status', 'selesai')->count(),
            'batal' => $antrians->where('status', 'batal')->count(),
        ];

        return view('antrian.index', compact('antrians', 'stats', 'tanggal'));
    }

    /**
     * Form pendaftaran pasien ke antrian
     */
    public function create()
    {
        $prioritas = Prioritas::orderBy('urutan')->get();
        $patients = Patient::orderBy('nama')->get(['id', 'nama', 'nik', 'tanggal_lahir', 'telp_hp', 'no_rm']);
        $mothers = Mother::orderBy('nama_ibu')->get(['id', 'nama_ibu', 'no_registrasi', 'umur', 'telp_hp']);
        $nomorAntrian = Antrian::generateNomor();

        return view('antrian.create', compact('prioritas', 'patients', 'mothers', 'nomorAntrian'));
    }

    /**
     * Simpan antrian baru — RBR + TBS dieksekusi di sini
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_pasien' => 'required|string|max:100',
            'umur' => 'nullable|integer|min:0|max:150',
            'no_hp' => 'nullable|string|max:20|regex:/^[0-9]*$/',
            'jenis_layanan' => 'required|string',
            'tensi_sistolik' => 'nullable|integer',
            'tensi_diastolik' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'is_override' => 'nullable',
            'keluhan' => 'nullable|string',
            'prioritas_id' => 'required_if:is_override,1|exists:prioritas,id',
            'patient_id' => 'nullable|exists:patients,id',
            'waktu_daftar' => 'nullable|date_format:H:i',
        ];
        
        $messages = [
            'prioritas_id.required_if' => 'Silakan pilih tingkat prioritas (Merah/Kuning/Hijau) jika Hak Veto diaktifkan.',
            'umur.max' => 'Umur tidak masuk akal (maksimal 150).',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
        ];

        $data = $request->validate($rules, $messages);

        // ═══════════════════════════════════════════════
        // STEP 1: RULE-BASED REASONING (RBR)
        // ═══════════════════════════════════════════════
        $isOverride = $request->has('is_override');
        $prioritasId = null;

        if ($isOverride && isset($data['prioritas_id'])) {
            $prioritas = Prioritas::find($data['prioritas_id']);
        } else {
            $rbrService = new RuleBasedReasoningService();
            $prioritas = $rbrService->determinePriority(
                $data['jenis_layanan'], 
                $data['keluhan'], 
                $data['tensi_sistolik'], 
                $data['tensi_diastolik']
            );
        }

        // ═══════════════════════════════════════════════
        // STEP 3: Simpan ke database
        // ═══════════════════════════════════════════════
        $antrian = new Antrian([
            'no_antrian' => Antrian::generateNomor(),
            'patient_id' => $data['patient_id'] ?? null,
            'nama_pasien' => $data['nama_pasien'],
            'umur' => $data['umur'],
            'no_hp' => $data['no_hp'],
            'tanggal' => today(),
            'prioritas_id' => $prioritas->id,
            'jenis_layanan' => $data['jenis_layanan'],
            'tensi_sistolik' => $data['tensi_sistolik'],
            'tensi_diastolik' => $data['tensi_diastolik'],
            'berat_badan' => $data['berat_badan'],
            'is_override' => $isOverride,
            'keluhan' => $data['keluhan'],
            'waktu_daftar' => $data['waktu_daftar'] ?? now()->format('H:i'), // Gunakan input atau fallback ke sekarang
            'status' => 'menunggu',
            'created_by' => auth()->id(),
        ]);
        
        // ═══════════════════════════════════════════════
        // STEP 2: TIME-BASED SCHEDULING (TBS)
        // Hitung estimasi waktu dilayani
        // ═══════════════════════════════════════════════
        $tbsService = new TimeBasedSchedulingService();
        $estimasi = $tbsService->calculateEstimatedTime($antrian);
        $antrian->estimasi_dilayani = $estimasi->format('H:i:s');
        
        $antrian->save();

        // Recalculate estimasi semua antrian (karena ada penyisipan prioritas)
        $tbsService->recalculateAllEstimates(today());

        return redirect()->route('antrian.index')
            ->with('success', "Pasien {$antrian->nama_pasien} terdaftar dengan No. Antrian {$antrian->no_antrian} — Prioritas: {$prioritas->nama} — Estimasi dilayani: {$estimasi}");
    }

    /**
     * Panggil pasien (status: menunggu → dipanggil)
     */
    public function panggil(Antrian $antrian)
    {
        $antrian->catatWaktu('dipanggil');
        (new TimeBasedSchedulingService())->recalculateAllEstimates($antrian->tanggal);
        return redirect()->route('antrian.index')
            ->with('success', "Pasien {$antrian->nama_pasien} ({$antrian->no_antrian}) dipanggil!");
    }

    /**
     * Layani pasien (status: dipanggil → dilayani)
     */
    public function layani(Antrian $antrian)
    {
        $antrian->catatWaktu('dilayani');
        (new TimeBasedSchedulingService())->recalculateAllEstimates($antrian->tanggal);
        return redirect()->route('antrian.index')
            ->with('success', "Pasien {$antrian->nama_pasien} sedang dilayani.");
    }

    /**
     * Selesai dilayani (status: dilayani → selesai)
     */
    public function selesai(Antrian $antrian)
    {
        $antrian->catatWaktu('selesai');
        (new TimeBasedSchedulingService())->recalculateAllEstimates($antrian->tanggal);

        // Tampilkan durasi aktual jika tersedia
        $msg = "Layanan untuk {$antrian->nama_pasien} selesai.";
        if ($antrian->durasi_aktual) {
            $msg .= " (durasi aktual: {$antrian->durasi_aktual} menit)";
        }

        return redirect()->route('antrian.index')->with('success', $msg);
    }

    /**
     * Batalkan antrian
     */
    public function batal(Antrian $antrian)
    {
        $antrian->catatWaktu('batal');
        (new TimeBasedSchedulingService())->recalculateAllEstimates($antrian->tanggal);

        return redirect()->route('antrian.index')
            ->with('success', "Antrian {$antrian->no_antrian} dibatalkan.");
    }

    /**
     * Monitor Antrian — Halaman publik (tanpa login)
     * Auto-refresh, tampilan layar besar
     */
    public function monitor()
    {
        $tanggal = today();
        $namaPraktik = Pengaturan::get('nama_praktik', 'Praktik Bidan');

        // Pasien yang sedang dipanggil
        $dipanggil = Antrian::with('prioritas')
            ->where('tanggal', $tanggal)
            ->where('status', 'dipanggil')
            ->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
            ->orderBy('prioritas.urutan', 'asc')
            ->select('antrian.*')
            ->first();

        // Pasien yang sedang dilayani
        $dilayani = Antrian::with('prioritas')
            ->where('tanggal', $tanggal)
            ->where('status', 'dilayani')
            ->get();

        // Daftar menunggu (urut RBR + TBS)
        $menunggu = Antrian::with('prioritas')
            ->where('tanggal', $tanggal)
            ->where('status', 'menunggu')
            ->join('prioritas', 'antrian.prioritas_id', '=', 'prioritas.id')
            ->orderBy('prioritas.urutan', 'asc')
            ->orderBy('antrian.waktu_daftar', 'asc')
            ->select('antrian.*')
            ->get();

        return view('antrian.monitor', compact('dipanggil', 'dilayani', 'menunggu', 'namaPraktik', 'tanggal'));
    }

    /**
     * Riwayat antrian
     */
    public function riwayat(Request $request)
    {
        $tanggal = $request->get('tanggal', today()->format('Y-m-d'));

        $antrians = Antrian::with('prioritas')
            ->where('tanggal', $tanggal)
            ->orderBy('created_at', 'asc')
            ->get();

        $stats = [
            'total' => $antrians->count(),
            'selesai' => $antrians->where('status', 'selesai')->count(),
            'batal' => $antrians->where('status', 'batal')->count(),
        ];

        return view('antrian.riwayat', compact('antrians', 'stats', 'tanggal'));
    }

    /**
     * Hapus satu antrian
     */
    public function destroy(Antrian $antrian)
    {
        $nama = $antrian->nama_pasien;
        $antrian->delete();
        (new TimeBasedSchedulingService())->recalculateAllEstimates(today());

        return redirect()->route('antrian.index')
            ->with('success', "Antrian {$nama} dihapus.");
    }

    /**
     * Hapus semua antrian hari ini
     */
    public function destroyAll()
    {
        $count = Antrian::hariIni()->count();
        Antrian::hariIni()->delete();

        return redirect()->route('antrian.index')
            ->with('success', "{$count} data antrian hari ini dihapus.");
    }

    /**
     * API: Suggest prioritas berdasarkan keluhan (RBR via AJAX)
     */
    public function suggestPrioritas(Request $request)
    {
        $keluhan = $request->input('keluhan', '');
        $jenisLayanan = $request->input('jenis_layanan', '');
        $tensiSistolik = $request->input('tensi_sistolik');
        $tensiDiastolik = $request->input('tensi_diastolik');

        $rbrService = new RuleBasedReasoningService();
        $prioritas = $rbrService->determinePriority($jenisLayanan, $keluhan, $tensiSistolik, $tensiDiastolik);

        if (!$prioritas || !$prioritas->id) {
            return response()->json(['prioritas_id' => null]);
        }

        return response()->json([
            'prioritas_id' => $prioritas->id,
            'nama' => $prioritas->nama,
            'kode' => $prioritas->kode,
            'warna' => $prioritas->warna,
            'estimasi' => $prioritas->estimasi_waktu,
        ]);
    }
}
