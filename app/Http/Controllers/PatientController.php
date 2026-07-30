<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query()->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                    ->orWhere('nik', 'like', "%$s%")
                    ->orWhere('no_rm', 'like', "%$s%")
                    ->orWhere('telp_hp', 'like', "%$s%")
                    ->orWhere('alamat', 'like', "%$s%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $patients = $query->paginate(15)->withQueryString();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => 'nullable|string|max:16',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'nullable|string|max:50',
            'nama_orangtua' => 'nullable|string|max:255',
            'telp_hp' => 'nullable|string|max:20',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'no_bpjs' => 'nullable|string|max:20',
        ]);

        $data['created_by'] = auth()->id();
        $data['no_rm'] = 'RM-' . str_pad(Patient::max('id') + 1, 5, '0', STR_PAD_LEFT);

        $patient = Patient::create($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data pasien berhasil disimpan.');
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'generalTreatments' => fn($q) => $q->latest('tanggal_kunjungan'),
            'immunizations' => fn($q) => $q->latest('tanggal'),
            'kbRegisters.visits',
            'birthReports' => fn($q) => $q->latest('tanggal_partus'),
        ]);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => 'nullable|string|max:16',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'status_perkawinan' => 'nullable|string|max:50',
            'nama_orangtua' => 'nullable|string|max:255',
            'telp_hp' => 'nullable|string|max:20',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'no_bpjs' => 'nullable|string|max:20',
        ]);

        $patient->update($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
