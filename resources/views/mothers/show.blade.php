@extends('layouts.app')

@section('title', $mother->nama_ibu)
@section('page-title', 'Detail Data Ibu')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('mothers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="btn-group">
            <a href="{{ route('mothers.edit', $mother) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('print.preview', $mother) }}" class="btn btn-success" target="_blank">
                <i class="bi bi-printer"></i> Cetak Kartu Ibu
            </a>
        </div>
    </div>

    <!-- Header Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="mb-1">{{ $mother->nama_ibu }}</h4>
                    <p class="text-muted mb-2">
                        @if($mother->no_registrasi) No. Reg: {{ $mother->no_registrasi }} @endif
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-geo-alt text-muted"></i>
                        {{ $mother->alamat ?? '' }}
                        @if($mother->rt && $mother->rw) RT {{ $mother->rt }}/RW {{ $mother->rw }}, @endif
                        {{ $mother->desa_kelurahan }}, {{ $mother->kecamatan }}, {{ $mother->kabupaten }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-inline-block text-center me-3">
                        <span class="badge bg-primary fs-5">G{{ $mother->gravida }}</span>
                        <span class="badge bg-success fs-5">P{{ $mother->partus }}</span>
                        <span class="badge bg-warning fs-5">A{{ $mother->abortus }}</span>
                        <span class="badge bg-info fs-5">H{{ $mother->hidup }}</span>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Gol. Darah:</small>
                        <span class="badge bg-danger">{{ $mother->gol_darah ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="motherTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#identitas">Identitas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#anc">
                ANC <span class="badge bg-secondary">{{ $mother->ancVisits->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pemeriksaan">Pemeriksaan Bidan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#persalinan">Persalinan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#nifas">Nifas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kb">KB</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- Tab Identitas -->
        <div class="tab-pane fade show active" id="identitas">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Data Ibu</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Nama Suami</th>
                                    <td>{{ $mother->nama_suami ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ $mother->tgl_lahir?->format('d/m/Y') ?? '-' }} ({{ $mother->umur ?? '-' }} th)
                                    </td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>{{ $mother->agama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan</th>
                                    <td>{{ $mother->pendidikan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Ibu</th>
                                    <td>{{ $mother->pekerjaan_ibu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Suami</th>
                                    <td>{{ $mother->pekerjaan_suami ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tgl. Menikah</th>
                                    <td>{{ $mother->tgl_menikah?->format('d/m/Y') ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Lain</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">No. Telp/HP</th>
                                    <td>{{ $mother->telp_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No. Jamkes</th>
                                    <td>{{ $mother->jamkes ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Puskesmas</th>
                                    <td>{{ $mother->puskesmas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Posyandu</th>
                                    <td>{{ $mother->posyandu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Kader</th>
                                    <td>{{ $mother->nama_kader ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Dukun</th>
                                    <td>{{ $mother->nama_dukun ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Terdaftar</th>
                                    <td>{{ $mother->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab ANC -->
        <div class="tab-pane fade" id="anc">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Riwayat Kunjungan ANC</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAncModal">
                        <i class="bi bi-plus"></i> Tambah ANC
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>UK</th>
                                    <th>BB</th>
                                    <th>TD</th>
                                    <th>TFU</th>
                                    <th>DJJ</th>
                                    <th>Hb</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mother->ancVisits as $anc)
                                    <tr>
                                        <td>{{ $anc->no_urut }}</td>
                                        <td>{{ $anc->tanggal_kunjungan?->format('d/m/Y') }}</td>
                                        <td>{{ $anc->usia_kehamilan_minggu ?? '-' }} mg</td>
                                        <td>{{ $anc->bb_kg ?? '-' }} kg</td>
                                        <td>{{ $anc->td_sistol ?? '-' }}/{{ $anc->td_diastol ?? '-' }}</td>
                                        <td>{{ $anc->tfu_cm ?? '-' }} cm</td>
                                        <td>{{ $anc->djj ?? '-' }}</td>
                                        <td>{{ $anc->hb ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('anc.destroy', $anc) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Hapus?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-3">Belum ada data ANC</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Pemeriksaan Bidan -->
        <div class="tab-pane fade" id="pemeriksaan">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Pemeriksaan Bidan</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMidwifeExamModal">
                        <i class="bi bi-plus"></i> {{ $mother->midwifeExam ? 'Edit' : 'Tambah' }}
                    </button>
                </div>
                <div class="card-body">
                    @if($mother->midwifeExam)
                        @php $exam = $mother->midwifeExam; @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <th>Tanggal Periksa</th>
                                        <td>{{ $exam->tanggal_periksa?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>HPHT</th>
                                        <td>{{ $exam->tanggal_hpht?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Taksiran Persalinan</th>
                                        <td>{{ $exam->taksiran_persalinan?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tgl. Persalinan Sebelumnya</th>
                                        <td>{{ $exam->tgl_persalinan_sebelumnya?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>BB Sebelum Hamil</th>
                                        <td>{{ $exam->bb_sebelum_hamil ?? '-' }} kg</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <th>Tinggi Badan</th>
                                        <td>{{ $exam->tinggi_badan ?? '-' }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>LILA</th>
                                        <td>{{ $exam->lila ?? '-' }} cm</td>
                                    </tr>
                                    <tr>
                                        <th>Status Gizi</th>
                                        <td><span
                                                class="badge {{ $exam->status_gizi == 'KEK' ? 'bg-warning' : 'bg-success' }}">{{ $exam->status_gizi ?? '-' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Buku KIA</th>
                                        <td>{{ $exam->buku_kia ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @if($exam->riwayat_komplikasi_kebidanan || $exam->riwayat_kronis_dan_alergi)
                            <div class="mt-3">
                                <p><strong>Riwayat Komplikasi:</strong> {{ $exam->riwayat_komplikasi_kebidanan ?? '-' }}</p>
                                <p><strong>Penyakit Kronis/Alergi:</strong> {{ $exam->riwayat_kronis_dan_alergi ?? '-' }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-muted text-center py-3">Belum ada data pemeriksaan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Persalinan -->
        <div class="tab-pane fade" id="persalinan">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Riwayat Persalinan</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDeliveryModal">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Kelamin</th>
                                <th>BB Bayi</th>
                                <th>Kondisi Ibu</th>
                                <th>Kondisi Bayi</th>
                                <th>Tempat</th>
                                <th>Penolong</th>
                                <th>Cara</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mother->deliveries as $d)
                                <tr>
                                    <td>{{ $d->bayi_lahir_tanggal?->format('d/m/Y') ?? '-' }} {{ $d->bayi_lahir_jam ?? '' }}
                                    </td>
                                    <td>{{ $d->jenis_kelamin ?? '-' }}</td>
                                    <td>{{ $d->berat_bayi_gram ?? '-' }} gr</td>
                                    <td><span
                                            class="badge {{ $d->keadaan_ibu == 'Hidup' ? 'bg-success' : 'bg-danger' }}">{{ $d->keadaan_ibu }}</span>
                                    </td>
                                    <td><span
                                            class="badge {{ $d->keadaan_bayi == 'Hidup' ? 'bg-success' : 'bg-danger' }}">{{ $d->keadaan_bayi }}</span>
                                    </td>
                                    <td>{{ $d->tempat_persalinan ?? '-' }}</td>
                                    <td>{{ $d->penolong ?? '-' }}</td>
                                    <td>{{ $d->cara_persalinan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">Belum ada data persalinan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Nifas -->
        <div class="tab-pane fade" id="nifas">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Kunjungan Nifas</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNifasModal">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>KF</th>
                                <th>Hari Ke</th>
                                <th>TD</th>
                                <th>Suhu</th>
                                <th>Keadaan Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mother->postpartumVisits as $visit)
                                <tr>
                                    <td>{{ $visit->tanggal?->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-info">{{ $visit->kf }}</span></td>
                                    <td>{{ $visit->hari_ke ?? '-' }}</td>
                                    <td>{{ $visit->td_mmhg ?? '-' }}</td>
                                    <td>{{ $visit->suhu_c ?? '-' }} °C</td>
                                    <td>{{ $visit->keadaan_pulang }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Belum ada data nifas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab KB -->
        <div class="tab-pane fade" id="kb">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>KB Pasca Salin</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addKbModal">
                        <i class="bi bi-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Metode KB</th>
                                <th>Rencana</th>
                                <th>Pelaksanaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mother->familyPlannings as $kb)
                                <tr>
                                    <td>{{ $kb->tanggal?->format('d/m/Y') ?? '-' }}</td>
                                    <td><strong>{{ $kb->metode_kb ?? '-' }}</strong></td>
                                    <td>{{ $kb->rencana ?? '-' }}</td>
                                    <td>{{ $kb->pelaksanaan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data KB</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add ANC -->
    <div class="modal fade" id="addAncModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('anc.store', $mother) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data ANC</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs mb-3" id="ancTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#anc-utama" type="button" role="tab">Pemeriksaan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#anc-pelayanan" type="button" role="tab">Pelayanan & Lab</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#anc-integrasi" type="button" role="tab">Integrasi Program</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="ancTabContent">
                            <!-- Tab Pemeriksaan -->
                            <div class="tab-pane fade show active" id="anc-utama" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Tanggal Kunjungan *</label>
                                        <input type="date" name="tanggal_kunjungan" class="form-control" required value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Usia Kehamilan (minggu)</label>
                                        <input type="number" name="usia_kehamilan_minggu" class="form-control" min="1" max="45">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Trimester</label>
                                        <select name="trimester" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="I">Trimester I</option>
                                            <option value="II">Trimester II</option>
                                            <option value="III">Trimester III</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Anamnesis</label>
                                        <textarea name="anamnesis" class="form-control" rows="1"></textarea>
                                    </div>
                                    
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Pemeriksaan Ibu</h6></div>
                                    <div class="col-md-3"><label class="form-label">BB (kg)</label><input type="number" name="bb_kg" class="form-control" step="0.1"></div>
                                    <div class="col-md-3"><label class="form-label">TD Sistol</label><input type="number" name="td_sistol" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">TD Diastol</label><input type="number" name="td_diastol" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Suhu (°C)</label><input type="number" name="suhu_c" class="form-control" step="0.1"></div>
                                    <div class="col-md-3"><label class="form-label">TFU (cm)</label><input type="number" name="tfu_cm" class="form-control" step="0.1"></div>
                                    <div class="col-md-3">
                                        <label class="form-label">Refleks Patella</label>
                                        <select name="refleks_patella" class="form-select">
                                            <option value="">Pilih</option><option value="+">+</option><option value="-">-</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Pemeriksaan Janin</h6></div>
                                    <div class="col-md-3"><label class="form-label">DJJ (x/mnt)</label><input type="number" name="djj" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">TBJ (gram)</label><input type="number" name="tbj_gram" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Presentasi</label><input type="text" name="presentasi" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Kepala thd</label><input type="text" name="kepala_thd" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Jumlah Janin</label><input type="number" name="jumlah_janin" class="form-control" value="1" min="1"></div>
                                </div>
                            </div>
                            
                            <!-- Tab Pelayanan & Lab -->
                            <div class="tab-pane fade" id="anc-pelayanan" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Pelayanan Khusus</h6></div>
                                    <div class="col-md-3">
                                        <div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="injeksi_tt" value="1"><label class="form-check-label">Injeksi TT</label></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="catat_buku_kia" value="1"><label class="form-check-label">Catat Buku KIA</label></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="pmt_bumil" value="1"><label class="form-check-label">PMT Bumil</label></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="pmk_bumil_kek" value="1"><label class="form-check-label">PMK Bumil KEK</label></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="kelas_ibu" value="1"><label class="form-check-label">Kelas Ibu</label></div>
                                    </div>
                                    <div class="col-md-3"><label class="form-label">Status Imunitas TT</label><input type="text" name="status_imunisasi_tt" class="form-control form-control-sm"></div>
                                    <div class="col-md-3"><label class="form-label">Fe (tablet)</label><input type="number" name="fe_tablet" class="form-control form-control-sm"></div>
                                    <div class="col-md-3"><label class="form-label">Konseling</label><input type="text" name="konseling" class="form-control form-control-sm"></div>
                                    
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Laboratorium</h6></div>
                                    <div class="col-md-3"><label class="form-label">Hb (g/dL)</label><input type="number" name="hb" class="form-control" step="0.1"></div>
                                    <div class="col-md-3">
                                        <label class="form-label">Anemia</label>
                                        <select name="anemia" class="form-select">
                                            <option value="">Pilih</option><option value="+">+</option><option value="-">-</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><label class="form-label">Gula Darah</label><input type="text" name="gula_darah" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Thalasemia</label><input type="text" name="thalasemia" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Protein Urin</label><input type="text" name="protein_urin" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">HBsAg</label><input type="text" name="hbsag" class="form-control"></div>
                                    <div class="col-md-3"><label class="form-label">Sifilis</label><input type="text" name="sifilis" class="form-control"></div>
                                </div>
                            </div>
                            
                            <!-- Tab Integrasi Program -->
                            <div class="tab-pane fade" id="anc-integrasi" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Pencegahan Penularan HIV (PPIA)</h6></div>
                                    <div class="col-md-3"><div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="datang_dengan_hiv" value="1"><label class="form-check-label">Datang dgn HIV +</label></div></div>
                                    <div class="col-md-3"><div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="ditawarkan_tes_hiv" value="1"><label class="form-check-label">Ditawarkan Tes</label></div></div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hasil HIV</label>
                                        <select name="hasil_hiv" class="form-select form-select-sm">
                                            <option value="">Pilih</option><option value="+">+</option><option value="-">-</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="mendapatkan_arv" value="1"><label class="form-check-label">Dapat ARV</label></div></div>
                                    
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Malaria & TB</h6></div>
                                    <div class="col-md-3"><div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="diberikan_kelambu" value="1"><label class="form-check-label">Diberi Kelambu</label></div></div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hasil Malaria</label>
                                        <select name="hasil_malaria" class="form-select form-select-sm">
                                            <option value="">Pilih</option><option value="+">+</option><option value="-">-</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><label class="form-label">Obat Malaria</label><input type="text" name="obat_malaria" class="form-control form-control-sm"></div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hasil TB</label>
                                        <select name="hasil_tb" class="form-select form-select-sm">
                                            <option value="">Pilih</option><option value="+">+</option><option value="-">-</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12"><h6 class="text-muted mt-2 mb-0">Lainnya</h6></div>
                                    <div class="col-md-3">
                                        <label class="form-label">Ankylostoma</label>
                                        <select name="ankylostoma" class="form-select form-select-sm">
                                            <option value="">Pilih</option><option value="+">+</option><option value="-">-</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="diperiksa_ims" value="1"><label class="form-check-label">Diperiksa IMS</label></div></div>
                                    <div class="col-md-6"><label class="form-label">Diagnosis IMS</label><input type="text" name="diagnosis_ims" class="form-control form-control-sm"></div>
                                    <div class="col-12"><label class="form-label">Keterangan Khusus / Komplikasi</label><textarea name="keterangan" class="form-control" rows="1"></textarea></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pemeriksaan Bidan -->
    <div class="modal fade" id="addMidwifeExamModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('midwife-exam.store', $mother) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $mother->midwifeExam ? 'Edit' : 'Tambah' }} Pemeriksaan Bidan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @php $exam = $mother->midwifeExam; @endphp
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Periksa *</label>
                                <input type="date" name="tanggal_periksa" class="form-control" required
                                    value="{{ $exam?->tanggal_periksa?->format('Y-m-d') ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal HPHT</label>
                                <input type="date" name="tanggal_hpht" class="form-control"
                                    value="{{ $exam?->tanggal_hpht?->format('Y-m-d') ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Taksiran Persalinan</label>
                                <input type="date" name="taksiran_persalinan" class="form-control"
                                    value="{{ $exam?->taksiran_persalinan?->format('Y-m-d') ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tgl Persalinan Sebelumnya</label>
                                <input type="date" name="tgl_persalinan_sebelumnya" class="form-control"
                                    value="{{ $exam?->tgl_persalinan_sebelumnya?->format('Y-m-d') ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">BB Sebelum Hamil (kg)</label>
                                <input type="number" name="bb_sebelum_hamil" class="form-control" step="0.1"
                                    value="{{ $exam?->bb_sebelum_hamil ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan" class="form-control"
                                    value="{{ $exam?->tinggi_badan ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">LILA (cm)</label>
                                <input type="number" name="lila" class="form-control" step="0.1"
                                    value="{{ $exam?->lila ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status Gizi</label>
                                <select name="status_gizi" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Normal" {{ $exam?->status_gizi == 'Normal' ? 'selected' : '' }}>Normal
                                    </option>
                                    <option value="KEK" {{ $exam?->status_gizi == 'KEK' ? 'selected' : '' }}>KEK</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Buku KIA</label>
                                <select name="buku_kia" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Memiliki" {{ $exam?->buku_kia == 'Memiliki' ? 'selected' : '' }}>Memiliki
                                    </option>
                                    <option value="Tidak Memiliki" {{ $exam?->buku_kia == 'Tidak Memiliki' ? 'selected' : '' }}>Tidak Memiliki</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Riwayat Komplikasi Kebidanan</label>
                                <textarea name="riwayat_komplikasi_kebidanan" class="form-control"
                                    rows="2">{{ $exam?->riwayat_komplikasi_kebidanan ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Penyakit Kronis/Alergi</label>
                                <textarea name="riwayat_kronis_dan_alergi" class="form-control"
                                    rows="2">{{ $exam?->riwayat_kronis_dan_alergi ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Persalinan -->
    <div class="modal fade" id="addDeliveryModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('delivery.store', $mother) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Persalinan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-0">Waktu Persalinan</h6>
                            </div>
                            <div class="col-md-3"><label class="form-label">Bayi Lahir Tanggal</label><input type="date"
                                    name="bayi_lahir_tanggal" class="form-control" value="{{ date('Y-m-d') }}"></div>
                            <div class="col-md-3"><label class="form-label">Bayi Lahir Jam</label><input type="time"
                                    name="bayi_lahir_jam" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Plasenta Lahir Tanggal</label><input type="date"
                                    name="plasenta_lahir_tanggal" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Plasenta Lahir Jam</label><input type="time"
                                    name="plasenta_lahir_jam" class="form-control"></div>

                            <div class="col-12">
                                <h6 class="text-muted mb-0 mt-2">Data Bayi</h6>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Berat Bayi (gram)</label><input type="number"
                                    name="berat_bayi_gram" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Panjang Badan (cm)</label><input type="number"
                                    name="panjang_badan_cm" class="form-control" step="0.1"></div>
                            <div class="col-md-3"><label class="form-label">Lingkar Kepala (cm)</label><input type="number"
                                    name="lingkar_kepala_cm" class="form-control" step="0.1"></div>

                            <div class="col-12">
                                <h6 class="text-muted mb-0 mt-2">Kondisi</h6>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Keadaan Ibu</label>
                                <select name="keadaan_ibu" class="form-select">
                                    <option value="Hidup">Hidup</option>
                                    <option value="Mati">Mati</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Keadaan Bayi</label>
                                <select name="keadaan_bayi" class="form-select">
                                    <option value="Hidup">Hidup</option>
                                    <option value="Mati">Mati</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Usia Kehamilan (minggu)</label><input
                                    type="number" name="usia_kehamilan_minggu" class="form-control"></div>
                            <div class="col-md-3"><label class="form-label">Perdarahan Kala IV (cc)</label><input
                                    type="number" name="perdarahan_kala_iv_cc" class="form-control"></div>

                            <div class="col-12">
                                <h6 class="text-muted mb-0 mt-2">Detail Persalinan</h6>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tempat Persalinan</label>
                                <select name="tempat_persalinan" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Faskes">Faskes</option>
                                    <option value="Non-faskes">Non-faskes</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Penolong</label>
                                <select name="penolong" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="Bidan">Bidan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cara Persalinan</label>
                                <select name="cara_persalinan" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Vakum">Vakum</option>
                                    <option value="Forseps">Forseps</option>
                                    <option value="Seksio Sesarea">Seksio Sesarea</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">IMD</label>
                                <select name="imd" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="< 1 jam">&lt; 1 jam</option>
                                    <option value="> 1 jam">&gt; 1 jam</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Nifas -->
    <div class="modal fade" id="addNifasModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('postpartum.store', $mother) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kunjungan Nifas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal *</label>
                                <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kunjungan</label>
                                <select name="kf" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="KF1">KF1 (6 jam - 3 hari)</option>
                                    <option value="KF2">KF2 (4 - 28 hari)</option>
                                    <option value="KF3">KF3 (29 - 42 hari)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hari Ke</label>
                                <input type="number" name="hari_ke" class="form-control" min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">TD (mmHg)</label>
                                <input type="text" name="td_mmhg" class="form-control" placeholder="120/80">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Suhu (°C)</label>
                                <input type="number" name="suhu_c" class="form-control" step="0.1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pelayanan</label>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="pelayanan[]"
                                        value="Catat di Buku KIA"><label class="form-check-label">Catat di Buku KIA</label>
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="pelayanan[]"
                                        value="Fe/TTD"><label class="form-check-label">Fe/TTD</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="pelayanan[]"
                                        value="Vit A"><label class="form-check-label">Vit A</label></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Komplikasi</label>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="komplikasi[]"
                                        value="PPP"><label class="form-check-label">PPP</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="komplikasi[]"
                                        value="Infeksi"><label class="form-check-label">Infeksi</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="komplikasi[]"
                                        value="HDK"><label class="form-check-label">HDK</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="komplikasi[]"
                                        value="Lainnya"><label class="form-check-label">Lainnya</label></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keadaan Tiba</label>
                                <select name="keadaan_tiba" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="H">Hidup</option>
                                    <option value="M">Mati</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keadaan Pulang</label>
                                <select name="keadaan_pulang" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="H">Hidup</option>
                                    <option value="M">Mati</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal KB -->
    <div class="modal fade" id="addKbModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('kb.store', $mother) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data KB</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Tanggal *</label>
                                <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Metode KB</label>
                                <select name="metode_kb" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="MAL">MAL</option>
                                    <option value="Kondom">Kondom</option>
                                    <option value="Pil">Pil</option>
                                    <option value="Suntik">Suntik</option>
                                    <option value="AKDR">AKDR</option>
                                    <option value="Implan">Implan</option>
                                    <option value="MOW">MOW</option>
                                    <option value="MOP">MOP</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Rencana</label>
                                <input type="text" name="rencana" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pelaksanaan</label>
                                <input type="text" name="pelaksanaan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection