@extends('layouts.app')

@section('title', $patient->nama)
@section('page-title', 'Detail Pasien')

@section('content')
    {{-- Patient Header --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="mb-1">{{ $patient->nama }}
                        <span class="badge bg-light text-dark ms-2">
                            {{ $patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </h4>
                    <div class="text-muted">
                        <span class="me-3"><i class="bi bi-card-text me-1"></i>{{ $patient->no_rm ?? '-' }}</span>
                        @if($patient->nik)<span class="me-3"><i class="bi bi-person-vcard me-1"></i>NIK:
                        {{ $patient->nik }}</span>@endif
                        @if($patient->tanggal_lahir)<span class="me-3"><i
                            class="bi bi-calendar me-1"></i>{{ $patient->tanggal_lahir->format('d/m/Y') }}
                        ({{ $patient->umur }})</span>@endif
                        @if($patient->telp_hp)<span><i class="bi bi-phone me-1"></i>{{ $patient->telp_hp }}</span>@endif
                    </div>
                    @if($patient->alamat)
                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $patient->alamat }}
                            @if($patient->desa_kelurahan), {{ $patient->desa_kelurahan }}@endif
                            @if($patient->kecamatan), {{ $patient->kecamatan }}@endif
                        </small>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="{{ route('patients.print', $patient) }}" class="btn btn-outline-success btn-sm"
                        target="_blank">
                        <i class="bi bi-printer me-1"></i>Print
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs" id="patientTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-berobat" type="button">
                <i class="bi bi-clipboard2-pulse me-1"></i>Berobat Umum
                <span class="badge bg-secondary ms-1">{{ $patient->generalTreatments->count() }}</span>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-imunisasi" type="button">
                <i class="bi bi-shield-plus me-1"></i>Imunisasi
                <span class="badge bg-secondary ms-1">{{ $patient->immunizations->count() }}</span>
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content mt-0">
        {{-- BEROBAT UMUM --}}
        <div class="tab-pane fade show active" id="tab-berobat">
            <div class="card border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Riwayat Berobat Umum</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalBerobat">
                        <i class="bi bi-plus me-1"></i>Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keluhan</th>
                                <th>TD</th>
                                <th>Diagnosa</th>
                                <th>Tindakan</th>
                                <th>Obat</th>
                                <th width="80"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->generalTreatments as $t)
                                <tr>
                                    <td>{{ $t->tanggal_kunjungan->format('d/m/Y') }}</td>
                                    <td class="small">{{ Str::limit($t->keluhan, 40) }}</td>
                                    <td>{{ $t->td_sistol && $t->td_diastol ? $t->td_sistol . '/' . $t->td_diastol : '-' }}</td>
                                    <td class="small">{{ Str::limit($t->diagnosa, 40) }}</td>
                                    <td class="small">{{ Str::limit($t->tindakan, 30) }}</td>
                                    <td class="small">{{ Str::limit($t->resep_obat, 30) }}</td>
                                    <td>
                                        <form action="{{ route('treatment.destroy', $t) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data berobat umum</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- IMUNISASI --}}
        <div class="tab-pane fade" id="tab-imunisasi">
            <div class="card border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Riwayat Imunisasi</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalImunisasi">
                        <i class="bi bi-plus me-1"></i>Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Vaksin</th>
                                <th>Dosis</th>
                                <th>Batch No</th>
                                <th>Petugas</th>
                                <th>KIPI</th>
                                <th width="80"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->immunizations as $imun)
                                <tr>
                                    <td>{{ $imun->tanggal->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $imun->jenis_vaksin }}</span></td>
                                    <td>{{ $imun->dosis ?? '-' }}</td>
                                    <td class="small">{{ $imun->batch_no ?? '-' }}</td>
                                    <td>{{ $imun->petugas ?? '-' }}</td>
                                    <td class="small">{{ $imun->reaksi_kipi ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('immunization.destroy', $imun) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data imunisasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    {{-- =================== MODALS =================== --}}

    {{-- Modal Berobat Umum --}}
    <div class="modal fade" id="modalBerobat" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('treatment.store', $patient) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Berobat Umum</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_kunjungan" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Keluhan</label>
                                <textarea name="keluhan" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-12">
                                <hr class="my-1">
                                <h6 class="text-muted small">Pemeriksaan Fisik</h6>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">TD Sistol</label>
                                <input type="number" name="td_sistol" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">TD Diastol</label>
                                <input type="number" name="td_diastol" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Suhu (°C)</label>
                                <input type="number" name="suhu" class="form-control form-control-sm" step="0.1">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">Nadi</label>
                                <input type="number" name="nadi" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">BB (kg)</label>
                                <input type="number" name="bb_kg" class="form-control form-control-sm" step="0.1">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small">TB (cm)</label>
                                <input type="number" name="tb_cm" class="form-control form-control-sm" step="0.1">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pemeriksaan Fisik Lainnya</label>
                                <textarea name="pemeriksaan_fisik" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Diagnosa</label>
                                <textarea name="diagnosa" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tindakan</label>
                                <textarea name="tindakan" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Resep Obat</label>
                                <textarea name="resep_obat" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Imunisasi --}}
    <div class="modal fade" id="modalImunisasi" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('immunization.store', $patient) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Imunisasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Vaksin <span class="text-danger">*</span></label>
                                <select name="jenis_vaksin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Hepatitis B-0', 'BCG', 'Polio 1', 'Polio 2', 'Polio 3', 'Polio 4', 'DPT-HB-Hib 1', 'DPT-HB-Hib 2', 'DPT-HB-Hib 3', 'IPV 1', 'IPV 2', 'Campak/MR 1', 'Campak/MR 2', 'PCV 1', 'PCV 2', 'PCV 3', 'Rotavirus 1', 'Rotavirus 2', 'Rotavirus 3', 'Japanese Encephalitis', 'Varicella', 'Hepatitis A', 'Influenza', 'HPV', 'Td/TT', 'Lainnya'] as $v)
                                        <option value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Dosis</label>
                                <input type="number" name="dosis" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Batch No</label>
                                <input type="text" name="batch_no" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lokasi Penyuntikan</label>
                                <input type="text" name="lokasi_penyuntikan" class="form-control"
                                    placeholder="Lengan kiri, paha kanan...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Petugas</label>
                                <input type="text" name="petugas" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">BB (kg)</label>
                                <input type="number" name="bb_kg" class="form-control" step="0.1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">TB (cm)</label>
                                <input type="number" name="tb_cm" class="form-control" step="0.1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Umur Saat Imunisasi</label>
                                <input type="text" name="umur_saat_imunisasi" class="form-control"
                                    placeholder="2 bulan, 9 bulan...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reaksi KIPI</label>
                                <textarea name="reaksi_kipi" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection