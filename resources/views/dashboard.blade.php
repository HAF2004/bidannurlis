@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Ringkasan Data --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['total_pasien'] }}</div>
                <small class="text-muted">Total Pasien</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['pasien_bulan_ini'] }}</div>
                <small class="text-muted">Pasien Baru Bulan Ini</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['berobat_bulan_ini'] }}</div>
                <small class="text-muted">Berobat Bulan Ini</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['total_ibu'] }}</div>
                <small class="text-muted">Data Kehamilan</small>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['pemeriksaan_bulan_ini'] }}</div>
                <small class="text-muted">ANC Bulan Ini</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['persalinan_bulan_ini'] }}</div>
                <small class="text-muted">Persalinan Bulan Ini</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['imunisasi_bulan_ini'] }}</div>
                <small class="text-muted">Imunisasi Bulan Ini</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center py-3">
                <div class="fs-3 fw-bold">{{ $stats['antrian_hari_ini'] }}</div>
                <small class="text-muted">Antrian Hari Ini</small>
            </div>
        </div>
    </div>


    {{-- Tabel Data Terbaru --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Pasien Terbaru</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>L/P</th>
                                <th>Tgl Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPatients as $patient)
                                <tr>
                                    <td><small>{{ $patient->no_rm ?? '-' }}</small></td>
                                    <td>{{ $patient->nama }}</td>
                                    <td>{{ $patient->jenis_kelamin }}</td>
                                    <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Berobat Umum Terbaru</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Pasien</th>
                                <th>Tanggal</th>
                                <th>Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTreatments as $t)
                                <tr>
                                    <td>{{ $t->patient->nama ?? '-' }}</td>
                                    <td>{{ $t->tanggal_kunjungan->format('d/m/Y') }}</td>
                                    <td><small>{{ Str::limit($t->diagnosa, 30) ?? '-' }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-0">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Ibu Hamil Terbaru</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tgl Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMothers as $mother)
                                <tr>
                                    <td>{{ $mother->nama_ibu }}</td>
                                    <td>{{ $mother->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Kunjungan ANC Terbaru</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Ibu</th>
                                <th>Tanggal</th>
                                <th>UK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisits as $visit)
                                <tr>
                                    <td>{{ $visit->mother->nama_ibu ?? '-' }}</td>
                                    <td>{{ $visit->tanggal_kunjungan->format('d/m/Y') }}</td>
                                    <td>{{ $visit->usia_kehamilan_minggu ?? '-' }} mg</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada data ANC</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection