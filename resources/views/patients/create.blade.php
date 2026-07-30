@extends('layouts.app')

@section('title', 'Tambah Pasien')
@section('page-title', 'Tambah Pasien Baru')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Gol. Darah</label>
                        <select name="gol_darah" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach(['A', 'B', 'AB', 'O'] as $gd)
                                <option value="{{ $gd }}" {{ old('gol_darah') == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">NIK</label>
                        <input type="text" name="nik" class="form-control" maxlength="16" value="{{ old('nik') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="col-12">
                        <hr>
                        <h6 class="text-muted">Alamat</h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" maxlength="5" value="{{ old('rt') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" maxlength="5" value="{{ old('rw') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Desa/Kelurahan</label>
                        <input type="text" name="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                    </div>

                    <div class="col-12">
                        <hr>
                        <h6 class="text-muted">Data Tambahan</h6>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Lainnya'] as $a)
                                <option value="{{ $a }}" {{ old('agama') == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pendidikan</label>
                        <select name="pendidikan" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'] as $p)
                                <option value="{{ $p }}" {{ old('pendidikan') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $sp)
                                <option value="{{ $sp }}" {{ old('status_perkawinan') == $sp ? 'selected' : '' }}>{{ $sp }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Orang Tua</label>
                        <input type="text" name="nama_orangtua" class="form-control" value="{{ old('nama_orangtua') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="telp_hp" class="form-control" value="{{ old('telp_hp') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. BPJS</label>
                        <input type="text" name="no_bpjs" class="form-control" value="{{ old('no_bpjs') }}">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Simpan</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection