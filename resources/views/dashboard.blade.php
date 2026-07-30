@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Queue Quick Access --}}
    <div class="card mb-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #1e40af, #3b82f6); color: white;">
        <div class="card-body d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="bi bi-list-ol me-2"></i>Antrian Hari Ini</h5>
                <span class="me-3"><strong>{{ $stats['antrian_hari_ini'] }}</strong> total</span>
                <span><strong>{{ $stats['antrian_menunggu'] }}</strong> menunggu</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('antrian.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-circle me-1"></i>
                    Daftar Antrian</a>
                <a href="{{ route('antrian.index') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-list me-1"></i>
                    Kelola</a>
            </div>
        </div>
    </div>

    {{-- Stats Row 1 --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_pasien'] }}</div>
                <div class="stat-label"><i class="bi bi-people me-1"></i>Total Pasien</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card accent">
                <div class="stat-value">{{ $stats['berobat_bulan_ini'] }}</div>
                <div class="stat-label"><i class="bi bi-clipboard2-pulse me-1"></i>Berobat Bulan Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #0891b2, #0e7490);">
                <div class="stat-value">{{ $stats['imunisasi_bulan_ini'] }}</div>
                <div class="stat-label"><i class="bi bi-shield-plus me-1"></i>Imunisasi Bulan Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #d946ef, #a21caf);">
                <div class="stat-value">{{ $stats['kb_aktif'] }}</div>
                <div class="stat-label"><i class="bi bi-heart me-1"></i>Peserta KB</div>
            </div>
        </div>
    </div>

    {{-- Stats Row 2 --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="stat-value">{{ $stats['total_ibu'] }}</div>
                <div class="stat-label"><i class="bi bi-gender-female me-1"></i>Data Kehamilan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card accent">
                <div class="stat-value">{{ $stats['pemeriksaan_bulan_ini'] }}</div>
                <div class="stat-label"><i class="bi bi-calendar-check me-1"></i>ANC Bulan Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['persalinan_bulan_ini'] }}</div>
                <div class="stat-label"><i class="bi bi-person-hearts me-1"></i>Persalinan Bulan Ini</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #6366f1, #4338ca);">
                <div class="stat-value">{{ $stats['pasien_bulan_ini'] }}</div>
                <div class="stat-label"><i class="bi bi-person-plus me-1"></i>Pasien Baru Bulan Ini</div>
            </div>
        </div>
    </div>

    {{-- Recent Data --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-1"></i>Pasien Terbaru</span>
                    <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>L/P</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPatients as $patient)
                                <tr>
                                    <td>
                                        <strong>{{ $patient->nama }}</strong>
                                        @if($patient->no_rm)<br><small class="text-muted">{{ $patient->no_rm }}</small>@endif
                                    </td>
                                    <td><span
                                            class="badge {{ $patient->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }}">{{ $patient->jenis_kelamin }}</span>
                                    </td>
                                    <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('patients.show', $patient) }}"
                                            class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-clipboard2-pulse me-1"></i>Berobat Umum Terbaru</span>
                </div>
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
                                    <td class="small">{{ Str::limit($t->diagnosa, 30) ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data</td>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-gender-female me-1"></i>Ibu Hamil Terbaru</span>
                    <a href="{{ route('mothers.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal Daftar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMothers as $mother)
                                <tr>
                                    <td><strong>{{ $mother->nama_ibu }}</strong></td>
                                    <td>{{ $mother->created_at->format('d/m/Y') }}</td>
                                    <td><a href="{{ route('mothers.show', $mother) }}"
                                            class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><i class="bi bi-calendar-check me-1"></i>Kunjungan ANC Terbaru</div>
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
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data ANC</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('patients.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-person-plus me-2"></i>Tambah Pasien Baru
        </a>
        <a href="{{ route('mothers.create') }}" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-gender-female me-2"></i>Tambah Data Kehamilan
        </a>
    </div>
@endsection