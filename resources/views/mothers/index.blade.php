@extends('layouts.app')

@section('title', 'Data Ibu')
@section('page-title', 'Data Ibu')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Data Ibu</span>
            <a href="{{ route('mothers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Ibu
            </a>
        </div>
        <div class="card-body">
            <!-- Search & Filter -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari nama, NIK, atau No. Registrasi..." value="{{ request('search') }}">
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
                        <a href="{{ route('mothers.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                @endif
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Reg</th>
                            <th>Nama Ibu</th>
                            <th>NIK</th>
                            <th>Alamat</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mothers as $mother)
                            <tr>
                                <td>{{ $mother->no_registrasi ?: '-' }}</td>
                                <td>
                                    <strong>{{ $mother->nama_ibu }}</strong>
                                    @if($mother->nama_suami)
                                        <br><small class="text-muted">Suami: {{ $mother->nama_suami }}</small>
                                    @endif
                                </td>
                                <td>{{ $mother->nik ?: '-' }}</td>
                                <td>
                                    @if($mother->desa_kelurahan || $mother->kecamatan)
                                        {{ $mother->desa_kelurahan }}, {{ $mother->kecamatan }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $mother->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('mothers.show', $mother) }}" class="btn btn-outline-primary"
                                            title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('mothers.edit', $mother) }}" class="btn btn-outline-secondary"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('print.preview', $mother) }}" class="btn btn-outline-success"
                                            title="Cetak" target="_blank">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <form action="{{ route('mothers.destroy', $mother) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data ibu.
                                    <a href="{{ route('mothers.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $mothers->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection