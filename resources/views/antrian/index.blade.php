@extends('layouts.app')

@section('title', 'Kelola Antrian')
@section('page-title', 'Kelola Antrian Pasien')

@section('content')
    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center border-0 shadow-sm" style="border-left: 4px solid #6c757d !important;">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-secondary">{{ $stats['menunggu'] }}</div>
                    <small class="text-muted">Menunggu</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center border-0 shadow-sm" style="border-left: 4px solid #0dcaf0 !important;">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-info">{{ $stats['dipanggil'] }}</div>
                    <small class="text-muted">Dipanggil</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center border-0 shadow-sm" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-primary">{{ $stats['dilayani'] }}</div>
                    <small class="text-muted">Dilayani</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center border-0 shadow-sm" style="border-left: 4px solid #198754 !important;">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-success">{{ $stats['selesai'] }}</div>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2 align-items-center">
            <form action="{{ route('antrian.index') }}" method="GET" class="d-flex gap-2">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
                <button class="btn btn-outline-primary"><i class="bi bi-filter"></i></button>
            </form>
            <a href="{{ route('antrian.monitor') }}" class="btn btn-outline-dark" target="_blank">
                <i class="bi bi-tv me-1"></i> Monitor
            </a>
        </div>
        <div class="d-flex gap-2">
            @if($stats['total'] > 0)
                <form action="{{ route('antrian.destroyAll') }}" method="POST"
                    onsubmit="return confirm('Hapus SEMUA antrian hari ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Hapus Semua</button>
                </form>
            @endif
            <a href="{{ route('antrian.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Daftarkan Pasien
            </a>
        </div>
    </div>

    {{-- Tabel Antrian --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Nama Pasien</th>
                        <th>Layanan & Medis</th>
                        <th>Prioritas (RBR)</th>
                        <th>Keluhan</th>
                        <th>Waktu Daftar</th>
                        <th>Estimasi (TBS)</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrians as $a)
                        <tr class="{{ $a->warna_row }}">
                            <td>
                                <span class="badge bg-dark fs-6">{{ $a->no_antrian }}</span>
                            </td>
                            <td>
                                <strong>{{ $a->nama_pasien }}</strong>
                                @if($a->umur)<br><small class="text-muted">{{ $a->umur }} th</small>@endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $a->jenis_layanan ?? '-' }}</span><br>
                                @if($a->tensi_sistolik || $a->tensi_diastolik)
                                    <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-activity"></i> Tensi: {{ $a->tensi_sistolik ?? '-' }}/{{ $a->tensi_diastolik ?? '-' }}</small><br>
                                @endif
                                @if($a->berat_badan)
                                    <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-speedometer2"></i> BB: {{ $a->berat_badan }} kg</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $warnaBg = match ($a->prioritas?->kode) {
                                        'GAWAT' => 'danger',
                                        'MENDESAK' => 'warning text-dark',
                                        default => 'success',
                                    };
                                @endphp
                                <span class="badge bg-{{ $warnaBg }}">
                                    {{ $a->prioritas?->nama }}
                                </span>
                                @if($a->is_override)
                                    <span class="text-danger ms-1" title="Prioritas diubah manual oleh Bidan (Hak Veto)"><i class="bi bi-exclamation-circle-fill"></i></span>
                                @endif
                                <br><small class="text-muted">{{ $a->prioritas?->estimasi_waktu }} menit</small>
                            </td>
                            <td class="small" style="max-width: 200px;">{{ Str::limit($a->keluhan, 50) }}</td>
                            <td>{{ $a->waktu_daftar }}</td>
                            <td>
                                <strong>{{ $a->estimasi_dilayani ?? '-' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $a->status_badge }}">{{ ucfirst($a->status) }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center gap-1">
                                    <div>
                                        @if($a->status === 'menunggu')
                                            <form action="{{ route('antrian.panggil', $a) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-info text-white" title="Panggil">
                                                    <i class="bi bi-megaphone"></i> Panggil
                                                </button>
                                            </form>
                                            <form action="{{ route('antrian.batal', $a) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Batalkan antrian ini?')">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-outline-dark" title="Batal">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </form>
                                        @elseif($a->status === 'dipanggil')
                                            <form action="{{ route('antrian.layani', $a) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-primary" title="Layani">
                                                    <i class="bi bi-play-circle"></i> Layani
                                                </button>
                                            </form>
                                        @elseif($a->status === 'dilayani')
                                            @if($a->patient_id)
                                                <a href="{{ route('patients.show', $a->patient_id) }}" class="btn btn-sm btn-outline-primary" title="Buka Rekam Medis" target="_blank">
                                                    <i class="bi bi-folder2-open"></i> Input RM
                                                </a>
                                            @endif
                                            <form action="{{ route('antrian.selesai', $a) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-success" title="Selesai">
                                                    <i class="bi bi-check-circle"></i> Selesai
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('antrian.destroy', $a) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus data antrian ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                                <p class="mt-2 mb-0">Belum ada antrian untuk tanggal ini</p>
                                <a href="{{ route('antrian.create') }}" class="btn btn-primary mt-3">
                                    <i class="bi bi-plus-circle me-1"></i> Daftarkan Pasien Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    {{-- Legend --}}
    <div class="mt-3 d-flex gap-3 small text-muted align-items-center">
        <span><span class="badge bg-danger">&nbsp;</span> Gawat Darurat</span>
        <span><span class="badge bg-warning">&nbsp;</span> Mendesak</span>
        <span><span class="badge bg-success">&nbsp;</span> Biasa</span>
        <span class="ms-3"><i class="bi bi-exclamation-circle-fill text-danger"></i> Hak Veto (Manual)</span>
    </div>
@endsection