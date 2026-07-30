<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotherController extends Controller
{
    /**
     * Display a listing of the mothers.
     */
    public function index(Request $request)
    {
        $query = Mother::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_ibu', 'like', "%{$search}%")
                    ->orWhere('no_registrasi', 'like', "%{$search}%");
            });
        }

        // Date filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $mothers = $query->latest()->paginate(15);

        return view('mothers.index', compact('mothers'));
    }

    /**
     * Show the form for creating a new mother.
     */
    public function create()
    {
        return view('mothers.create');
    }

    /**
     * Store a newly created mother in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'puskesmas' => 'nullable|max:255',
            'no_registrasi' => 'nullable|unique:mothers',
            'nama_ibu' => 'required|max:255',
            'nama_suami' => 'nullable|max:255',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'rt' => 'nullable|max:5',
            'rw' => 'nullable|max:5',
            'desa_kelurahan' => 'nullable|max:255',
            'kecamatan' => 'nullable|max:255',
            'kabupaten' => 'nullable|max:255',
            'provinsi' => 'nullable|max:255',
            'agama' => 'nullable|max:50',
            'pendidikan' => 'nullable|max:50',
            'pekerjaan_ibu' => 'nullable|max:100',
            'pekerjaan_suami' => 'nullable|max:100',
            'tgl_register' => 'nullable|date',
            'tgl_menikah' => 'nullable|date',
            'jamkes' => 'nullable|max:50',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'telp_hp' => 'nullable|max:20',
            'posyandu' => 'nullable|max:255',
            'nama_kader' => 'nullable|max:255',
            'nama_dukun' => 'nullable|max:255',
            // Obstetric (embedded)
            'gravida' => 'nullable|integer|min:0',
            'partus' => 'nullable|integer|min:0',
            'abortus' => 'nullable|integer|min:0',
            'hidup' => 'nullable|integer|min:0',
        ]);

        // Calculate age from tgl_lahir
        if (!empty($validated['tgl_lahir'])) {
            $validated['umur'] = \Carbon\Carbon::parse($validated['tgl_lahir'])->age;
        }

        $validated['created_by'] = Auth::id();

        $mother = Mother::create($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data ibu berhasil disimpan.');
    }

    /**
     * Display the specified mother.
     */
    public function show(Mother $mother)
    {
        $mother->load([
            'midwifeExam',
            'deliveries',
            'postpartumVisits',
            'familyPlannings',
            'birthPlans',
            'ancVisits' => fn($q) => $q->orderBy('tanggal_kunjungan'),
        ]);

        return view('mothers.show', compact('mother'));
    }

    /**
     * Show the form for editing the specified mother.
     */
    public function edit(Mother $mother)
    {
        return view('mothers.edit', compact('mother'));
    }

    /**
     * Update the specified mother in storage.
     */
    public function update(Request $request, Mother $mother)
    {
        $validated = $request->validate([
            'puskesmas' => 'nullable|max:255',
            'no_registrasi' => 'nullable|unique:mothers,no_registrasi,' . $mother->id,
            'nama_ibu' => 'required|max:255',
            'nama_suami' => 'nullable|max:255',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'rt' => 'nullable|max:5',
            'rw' => 'nullable|max:5',
            'desa_kelurahan' => 'nullable|max:255',
            'kecamatan' => 'nullable|max:255',
            'kabupaten' => 'nullable|max:255',
            'provinsi' => 'nullable|max:255',
            'agama' => 'nullable|max:50',
            'pendidikan' => 'nullable|max:50',
            'pekerjaan_ibu' => 'nullable|max:100',
            'pekerjaan_suami' => 'nullable|max:100',
            'tgl_register' => 'nullable|date',
            'tgl_menikah' => 'nullable|date',
            'jamkes' => 'nullable|max:50',
            'gol_darah' => 'nullable|in:A,B,AB,O',
            'telp_hp' => 'nullable|max:20',
            'posyandu' => 'nullable|max:255',
            'nama_kader' => 'nullable|max:255',
            'nama_dukun' => 'nullable|max:255',
            // Obstetric (embedded)
            'gravida' => 'nullable|integer|min:0',
            'partus' => 'nullable|integer|min:0',
            'abortus' => 'nullable|integer|min:0',
            'hidup' => 'nullable|integer|min:0',
        ]);

        // Calculate age from tgl_lahir
        if (!empty($validated['tgl_lahir'])) {
            $validated['umur'] = \Carbon\Carbon::parse($validated['tgl_lahir'])->age;
        }

        $mother->update($validated);

        return redirect()->route('mothers.show', $mother)
            ->with('success', 'Data ibu berhasil diperbarui.');
    }

    /**
     * Remove the specified mother from storage.
     */
    public function destroy(Mother $mother)
    {
        $mother->delete();

        return redirect()->route('mothers.index')
            ->with('success', 'Data ibu berhasil dihapus.');
    }
}
