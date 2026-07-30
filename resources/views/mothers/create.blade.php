@extends('layouts.app')

@section('title', 'Tambah Data Ibu')
@section('page-title', 'Tambah Data Ibu')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('mothers.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            Form Data Ibu Baru
        </div>
        <div class="card-body">
            <form action="{{ route('mothers.store') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Identitas Ibu -->
                <h5 class="mb-3"><i class="bi bi-person-badge me-2"></i>Identitas Ibu</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">No. Registrasi</label>
                        <input type="text" name="no_registrasi" class="form-control" value="{{ old('no_registrasi') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" maxlength="16" value="{{ old('nik') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Puskesmas</label>
                        <input type="text" name="puskesmas" class="form-control" value="{{ old('puskesmas') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ibu" class="form-control" required value="{{ old('nama_ibu') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Suami</label>
                        <input type="text" name="nama_suami" class="form-control" value="{{ old('nama_suami') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Golongan Darah</label>
                        <select name="gol_darah" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" {{ old('gol_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('gol_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('gol_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('gol_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No. Telp/HP</label>
                        <input type="text" name="telp_hp" class="form-control" value="{{ old('telp_hp') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No. Jamkes</label>
                        <input type="text" name="no_jamkes" class="form-control" value="{{ old('no_jamkes') }}">
                    </div>
                </div>

                <!-- Alamat -->
                <h5 class="mb-3"><i class="bi bi-geo-alt me-2"></i>Alamat</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ old('rt') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ old('rw') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Desa/Kelurahan</label>
                        <input type="text" name="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                    </div>
                </div>

                <!-- Data Tambahan -->
                <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Data Tambahan</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pendidikan</label>
                        <select name="pendidikan" class="form-select">
                            <option value="">Pilih</option>
                            <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pekerjaan Suami</label>
                        <input type="text" name="pekerjaan_suami" class="form-control" value="{{ old('pekerjaan_suami') }}">
                    </div>
                </div>

                <!-- Riwayat Obstetrik -->
                <h5 class="mb-3"><i class="bi bi-clipboard2-pulse me-2"></i>Riwayat Obstetrik</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Gravida (G)</label>
                        <input type="number" name="gravida" class="form-control" min="0" value="{{ old('gravida', 0) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Partus (P)</label>
                        <input type="number" name="partus" class="form-control" min="0" value="{{ old('partus', 0) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Abortus (A)</label>
                        <input type="number" name="abortus" class="form-control" min="0" value="{{ old('abortus', 0) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hidup (H)</label>
                        <input type="number" name="hidup" class="form-control" min="0" value="{{ old('hidup', 0) }}">
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('mothers.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection