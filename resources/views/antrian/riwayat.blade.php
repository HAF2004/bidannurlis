@extends('layouts.app')

@section('title', 'Riwayat Antrian')
@section('page-title', 'Riwayat Antrian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="{{ route('antrian.riwayat') }}" method="GET" class="d-flex gap-2">
            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
        </form>
        <div class="d-flex gap-3">
            <span class="badge bg-dark fs-6">Total: {{ $stats['total'] }}</span>
            <span class="badge bg-success fs-6">Selesai: {{ $stats['selesai'] }}</span>
            <span class="badge bg-secondary fs-6">Batal: {{ $stats['batal'] }}</span>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No. Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Prioritas</th>
                        <th>Keluhan</th>
                        <th>Waktu Daftar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrians as $a)
                        <tr>
                            <td><span class="badge bg-dark">{{ $a->no_antrian }}</span></td>
                            <td>
                                <strong>{{ $a->nama_pasien }}</strong>
                                @if($a->umur) <small class="text-muted">({{ $a->umur }} th)</small> @endif
                            </td>
                            <td>
                                @php
                                    $warna = match ($a->prioritas?->kode) {
                                        'GAWAT' => 'danger',
                                        'MENDESAK' => 'warning text-dark',
                                        default => 'success',
                                    };
                                @endphp
                                <span class="badge bg-{{ $warna }}">{{ $a->prioritas?->nama }}</span>
                            </td>
                            <td class="small">{{ Str::limit($a->keluhan, 40) }}</td>
                            <td>{{ $a->waktu_daftar }}</td>
                            <td><span class="badge bg-{{ $a->status_badge }}">{{ ucfirst($a->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data antrian untuk tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection