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
                        <span class="badge {{ $patient->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }} ms-2">
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
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-kb" type="button">
                <i class="bi bi-heart me-1"></i>KB
                <span class="badge bg-secondary ms-1">{{ $patient->kbRegisters->count() }}</span>
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-lahiran" type="button">
                <i class="bi bi-gender-female me-1"></i>Lahiran/Partus
                <span class="badge bg-secondary ms-1">{{ $patient->birthReports->count() }}</span>
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

        {{-- KB --}}
        <div class="tab-pane fade" id="tab-kb">
            <div class="card border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Data Keluarga Berencana</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalKb">
                        <i class="bi bi-plus me-1"></i>Tambah KB
                    </button>
                </div>
                <div class="card-body">
                    @forelse($patient->kbRegisters as $kb)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">
                                        <span class="badge bg-success">{{ $kb->no_register }}</span>
                                        <span class="ms-2">Metode: <strong>{{ $kb->metode_kb ?? '-' }}</strong></span>
                                        <span
                                            class="badge {{ $kb->status_peserta == 'Baru' ? 'bg-warning text-dark' : 'bg-secondary' }} ms-2">
                                            {{ $kb->status_peserta }}
                                        </span>
                                    </h6>
                                    <small class="text-muted">
                                        Terdaftar: {{ $kb->tanggal_daftar->format('d/m/Y') }}
                                        @if($kb->nama_suami) | Suami: {{ $kb->nama_suami }} @endif
                                    </small>
                                </div>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalKbVisit{{ $kb->id }}">
                                        <i class="bi bi-plus me-1"></i>Kunjungan
                                    </button>
                                    <form action="{{ route('kb-register.destroy', $kb) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus data KB?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            @if($kb->visits->count())
                                <table class="table table-sm table-bordered mt-2 mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Metode</th>
                                            <th>Keluhan</th>
                                            <th>Tindakan</th>
                                            <th>Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kb->visits as $v)
                                            <tr>
                                                <td>{{ $v->tanggal->format('d/m/Y') }}</td>
                                                <td>{{ $v->metode_kb ?? '-' }}</td>
                                                <td class="small">{{ $v->keluhan ?? '-' }}</td>
                                                <td class="small">{{ $v->tindakan ?? '-' }}</td>
                                                <td>{{ $v->sumber_biaya ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        {{-- KB Visit Modal --}}
                        <div class="modal fade" id="modalKbVisit{{ $kb->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kb-visit.store', $kb) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Kunjungan KB</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <label class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Metode KB</label>
                                                    <select name="metode_kb" class="form-select">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach(['Pil', 'Suntik 1 Bulan', 'Suntik 3 Bulan', 'Implant', 'IUD', 'Kondom', 'MOW', 'MOP'] as $m)
                                                            <option value="{{ $m }}">{{ $m }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Keluhan</label>
                                                    <textarea name="keluhan" class="form-control" rows="2"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Tindakan</label>
                                                    <textarea name="tindakan" class="form-control" rows="2"></textarea>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Sumber Biaya</label>
                                                    <select name="sumber_biaya" class="form-select">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach(['BPJS Kesehatan', 'APBN', 'APBD', 'Mandiri', 'Lainnya'] as $sb)
                                                            <option value="{{ $sb }}">{{ $sb }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-6 d-flex flex-column justify-content-end gap-1">
                                                    <div class="form-check"><input type="checkbox" name="komplikasi_berat"
                                                            value="1" class="form-check-input"><label
                                                            class="form-check-label">Komplikasi Berat</label></div>
                                                    <div class="form-check"><input type="checkbox" name="kegagalan" value="1"
                                                            class="form-check-input"><label
                                                            class="form-check-label">Kegagalan</label></div>
                                                    <div class="form-check"><input type="checkbox" name="pencabutan" value="1"
                                                            class="form-check-input"><label
                                                            class="form-check-label">Pencabutan</label></div>
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
                    @empty
                        <div class="text-center text-muted py-4">Belum ada data KB</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- LAHIRAN/PARTUS --}}
        <div class="tab-pane fade" id="tab-lahiran">
            <div class="card border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Laporan Partus</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalLahiran">
                        <i class="bi bi-plus me-1"></i>Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Anak Ke</th>
                                <th>Jenis Partus</th>
                                <th>Bayi</th>
                                <th>BB Bayi</th>
                                <th>Keadaan Ibu</th>
                                <th>Keterangan</th>
                                <th width="80"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->birthReports as $br)
                                <tr>
                                    <td>{{ $br->tanggal_partus->format('d/m/Y') }}</td>
                                    <td>{{ $br->anak_ke ?? '-' }}</td>
                                    <td><span class="badge bg-primary">{{ $br->jenis_partus }}</span></td>
                                    <td>
                                        <span
                                            class="badge {{ $br->keadaan_bayi == 'Hidup' ? 'bg-success' : 'bg-danger' }}">{{ $br->keadaan_bayi }}</span>
                                        {{ $br->jenis_kelamin_bayi ?? '' }}
                                    </td>
                                    <td>{{ $br->bb_bayi_gram ? $br->bb_bayi_gram . ' gr' : '-' }}</td>
                                    <td>{{ $br->keadaan_ibu ?? '-' }}</td>
                                    <td class="small">{{ Str::limit($br->keterangan, 30) }}</td>
                                    <td>
                                        <form action="{{ route('birth-report.destroy', $br) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data lahiran</td>
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

    {{-- Modal KB --}}
    <div class="modal fade" id="modalKb" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('kb-register.store', $patient) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Daftar KB Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Daftar <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_daftar" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Peserta <span class="text-danger">*</span></label>
                                <select name="status_peserta" class="form-select" required>
                                    <option value="Baru">Baru</option>
                                    <option value="Lama">Lama</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Metode KB</label>
                                <select name="metode_kb" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Pil', 'Suntik 1 Bulan', 'Suntik 3 Bulan', 'Implant', 'IUD', 'Kondom', 'MOW', 'MOP'] as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nama Suami</label>
                                <input type="text" name="nama_suami" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NIK Suami</label>
                                <input type="text" name="nik_suami" class="form-control" maxlength="16">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="no_hp" class="form-control">
                            </div>
                            <div class="col-12 d-flex gap-4">
                                <div class="form-check"><input type="checkbox" name="informed_consent" value="1"
                                        class="form-check-input"><label class="form-check-label">Informed Consent</label>
                                </div>
                                <div class="form-check"><input type="checkbox" name="pasca_persalinan" value="1"
                                        class="form-check-input"><label class="form-check-label">Pasca Persalinan</label>
                                </div>
                                <div class="form-check"><input type="checkbox" name="pasca_keguguran" value="1"
                                        class="form-check-input"><label class="form-check-label">Pasca Keguguran</label>
                                </div>
                            </div>
                            <div class="col-12">
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

    {{-- Modal Lahiran --}}
    <div class="modal fade" id="modalLahiran" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('birth-report.store', $patient) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Laporan Partus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Partus <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_partus" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jam</label>
                                <input type="text" name="jam_partus" class="form-control" placeholder="08:30">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenis Partus <span class="text-danger">*</span></label>
                                <select name="jenis_partus" class="form-select" required>
                                    @foreach(['Normal', 'SC', 'Vakum', 'Forseps'] as $j)
                                        <option value="{{ $j }}">{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Anak Ke</label>
                                <input type="number" name="anak_ke" class="form-control" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ibu" class="form-control" required
                                    value="{{ $patient->nama }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nama Suami</label>
                                <input type="text" name="nama_suami" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Umur Ibu (th)</label>
                                <input type="number" name="umur_ibu" class="form-control">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Alamat Ibu</label>
                                <input type="text" name="alamat_ibu" class="form-control" value="{{ $patient->alamat }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. Telp</label>
                                <input type="text" name="no_telp" class="form-control" value="{{ $patient->telp_hp }}">
                            </div>

                            <div class="col-12">
                                <hr class="my-1">
                                <h6 class="text-muted small">Keadaan Bayi</h6>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Keadaan <span class="text-danger">*</span></label>
                                <select name="keadaan_bayi" class="form-select" required>
                                    <option value="Hidup">Hidup</option>
                                    <option value="Mati">Mati</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin_bayi" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">BB Bayi (gram)</label>
                                <input type="number" name="bb_bayi_gram" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">PB Bayi (cm)</label>
                                <input type="number" name="pb_bayi_cm" class="form-control">
                            </div>

                            <div class="col-12">
                                <hr class="my-1">
                                <h6 class="text-muted small">Keadaan Ibu</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keadaan Ibu</label>
                                <input type="text" name="keadaan_ibu" class="form-control" placeholder="Baik, Pusing, dll">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">BB Ibu (kg)</label>
                                <input type="number" name="bb_ibu_kg" class="form-control" step="0.1">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"
                                    placeholder="Vit K, HB0, IMD, dll"></textarea>
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