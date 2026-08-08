@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Data Pasien</span>
            <a href="{{ route('patients.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pasien
            </a>
        </div>
        <div class="card-body">
            <!-- Search & Filter -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIK, atau alamat..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"
                        placeholder="Dari tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"
                        placeholder="Sampai tanggal">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
                @if(request()->hasAny(['search', 'from_date', 'to_date']))
                    <div class="col-md-2">
                        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                @endif
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>L/P</th>
                            <th>Umur</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $patient->no_rm ?? '-' }}</span></td>
                                <td>
                                    <strong>{{ $patient->nama }}</strong>
                                    @if($patient->nik)
                                        <br><small class="text-muted">NIK: {{ $patient->nik }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $patient->jenis_kelamin }}
                                    </span>
                                </td>
                                <td>{{ $patient->umur ?? '-' }}</td>
                                <td class="small">
                                    @if($patient->desa_kelurahan || $patient->kecamatan)
                                        {{ $patient->desa_kelurahan }}, {{ $patient->kecamatan }}
                                    @else
                                        {{ $patient->alamat ?? '-' }}
                                    @endif
                                </td>
                                <td class="small">{{ $patient->telp_hp ?? '-' }}</td>
                                <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary"
                                            title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-secondary"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('patients.print', $patient) }}" class="btn btn-outline-secondary"
                                            title="Cetak" target="_blank">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline ms-1"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada data pasien.
                                    <a href="{{ route('patients.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $patients->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection