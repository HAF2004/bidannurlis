@extends('layouts.app')

@section('title', 'Pendaftaran Antrian')
@section('page-title', 'Daftarkan Pasien ke Antrian')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-plus me-1"></i> Form Pendaftaran</span>
                    <span class="badge bg-dark fs-6">{{ $nomorAntrian }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('antrian.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            {{-- Pilih pasien terdaftar (opsional) --}}
                            <div class="col-12">
                                <label class="form-label fw-bold">Cari Pasien Terdaftar <small
                                        class="text-muted">(opsional — cari berdasarkan nama, NIK, No. HP, atau No. RM)</small></label>
                                <input type="hidden" name="patient_id" id="hiddenPatientId" value="{{ old('patient_id') }}">
                                <div class="position-relative">
                                    <input type="text" id="searchPatient" class="form-control"
                                        placeholder="Ketik nama, NIK, No. HP, atau No. RM..." autocomplete="off">
                                    <div id="searchResults" class="list-group position-absolute w-100 shadow-sm"
                                        style="z-index: 999; max-height: 280px; overflow-y: auto; display: none;"></div>
                                </div>

                                {{-- Data store --}}
                                <script>
                                    const patientData = [
                                        @foreach($patients as $p)
                                            @php $umur = $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->age : ''; @endphp
                                            {
                                                id: "{{ $p->id }}",
                                                type: "patient",
                                                nama: @json($p->nama),
                                                nik: @json($p->nik ?? ''),
                                                hp: @json($p->telp_hp ?? ''),
                                                noRm: @json($p->no_rm ?? ''),
                                                umur: "{{ $umur }}",
                                                label: "📋",
                                                group: "Pasien"
                                            },
                                        @endforeach
                                        @foreach($mothers as $m)
                                            {
                                                id: "",
                                                type: "mother",
                                                nama: @json($m->nama_ibu),
                                                nik: "",
                                                hp: @json($m->telp_hp ?? ''),
                                                noRm: @json($m->no_registrasi ?? ''),
                                                umur: "{{ $m->umur }}",
                                                label: "🤰",
                                                group: "Ibu Hamil"
                                            },
                                        @endforeach
                                    ];
                                </script>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Pasien <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pasien" id="inputNama"
                                    class="form-control @error('nama_pasien') is-invalid @enderror"
                                    value="{{ old('nama_pasien') }}" required autofocus>
                                @error('nama_pasien') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Umur</label>
                                <div class="input-group has-validation">
                                    <input type="number" name="umur" id="inputUmur" class="form-control @error('umur') is-invalid @enderror" min="0" max="150"
                                        value="{{ old('umur') }}">
                                    <span class="input-group-text">tahun</span>
                                    @error('umur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">No. HP</label>
                                <input type="tel" name="no_hp" id="inputHp" class="form-control @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp') }}" pattern="[0-9]*" inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            {{-- TIMESTAMPS / WAKTU DAFTAR MANUAL UNTUK BOOKING WA --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold" title="Ubah jika pasien booking via WhatsApp">Waktu Daftar <i class="bi bi-whatsapp text-success"></i></label>
                                <input type="time" name="waktu_daftar" id="inputWaktuDaftar" class="form-control"
                                    value="{{ old('waktu_daftar', now()->format('H:i')) }}">
                                <small class="text-muted" style="font-size: 0.70rem;">Default: Waktu Saat Ini</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Layanan <span class="text-danger">*</span></label>
                                <select name="jenis_layanan" id="inputLayanan" class="form-select @error('jenis_layanan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    <option value="Persalinan" {{ old('jenis_layanan') == 'Persalinan' ? 'selected' : '' }}>Persalinan 24 Jam</option>
                                    <option value="KB" {{ old('jenis_layanan') == 'KB' ? 'selected' : '' }}>Keluarga Berencana (KB)</option>
                                    <option value="ANC" {{ old('jenis_layanan') == 'ANC' ? 'selected' : '' }}>Periksa Kehamilan (ANC)</option>
                                    <option value="Imunisasi" {{ old('jenis_layanan') == 'Imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                                    <option value="Anak" {{ old('jenis_layanan') == 'Anak' ? 'selected' : '' }}>Periksa Perkembangan Anak</option>
                                    <option value="Umum" {{ old('jenis_layanan') == 'Umum' ? 'selected' : '' }}>Berobat Umum</option>
                                </select>
                                @error('jenis_layanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Keluhan / Gejala Utama</label>
                                <textarea name="keluhan" id="inputKeluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="2"
                                    placeholder="Contoh: pendarahan hebat, demam tinggi, kontrol rutin...">{{ old('keluhan') }}</textarea>
                                @error('keluhan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Ketik keluhan untuk mengaktifkan deteksi prioritas otomatis (RBR)</small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tensi (Sistolik)</label>
                                <div class="input-group has-validation">
                                    <input type="number" name="tensi_sistolik" id="inputSistolik" class="form-control @error('tensi_sistolik') is-invalid @enderror" placeholder="120" value="{{ old('tensi_sistolik') }}">
                                    <span class="input-group-text">mmHg</span>
                                    @error('tensi_sistolik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tensi (Diastolik)</label>
                                <div class="input-group has-validation">
                                    <input type="number" name="tensi_diastolik" id="inputDiastolik" class="form-control @error('tensi_diastolik') is-invalid @enderror" placeholder="80" value="{{ old('tensi_diastolik') }}">
                                    <span class="input-group-text">mmHg</span>
                                    @error('tensi_diastolik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Berat Badan</label>
                                <div class="input-group has-validation">
                                    <input type="number" step="0.1" name="berat_badan" id="inputBerat" class="form-control @error('berat_badan') is-invalid @enderror" placeholder="60" value="{{ old('berat_badan') }}">
                                    <span class="input-group-text">kg</span>
                                    @error('berat_badan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- PRIORITAS (RBR) --}}
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold mb-0">Prioritas 
                                        <span id="rbrSuggestion" class="ms-2"></span>
                                    </label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="switchVeto" name="is_override" value="1">
                                        <label class="form-check-label fw-bold text-danger" for="switchVeto">Hak Veto (Pilih Manual)</label>
                                    </div>
                                </div>
                                <div class="row g-2 d-flex" id="prioritasContainer">
                                    @foreach($prioritas as $p)
                                        @php
                                            $colorClass = match ($p->kode) {
                                                'GAWAT' => 'btn-outline-danger',
                                                'MENDESAK' => 'btn-outline-warning',
                                                default => 'btn-outline-success',
                                            };
                                            $bgHover = match ($p->kode) {
                                                'GAWAT' => 'danger',
                                                'MENDESAK' => 'warning',
                                                default => 'success',
                                            };
                                        @endphp
                                        <div class="col-md-4 d-flex">
                                            <input type="radio" name="prioritas_id" id="prio_{{ $p->id }}" value="{{ $p->id }}"
                                                class="btn-check" disabled>
                                            <label for="prio_{{ $p->id }}" class="btn {{ $colorClass }} w-100 text-start p-3 d-flex flex-column disabled-label"
                                                style="border-width: 2px; min-height: 120px;" id="label_prio_{{ $p->id }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong>{{ $p->nama }}</strong>
                                                    <span class="badge bg-{{ $bgHover }}">{{ $p->estimasi_waktu }} mnt</span>
                                                </div>
                                                <small class="d-block mt-1 text-muted flex-grow-1" style="font-size: 0.75rem;">
                                                    IF: {{ $p->gejala }}
                                                </small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('prioritas_id') <div class="text-danger fw-bold mt-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                                <small class="text-muted mt-2 d-block"><i class="bi bi-robot"></i> Sistem otomatis mendeteksi prioritas dari Tensi dan Keluhan. Aktifkan Hak Veto untuk mengubah manual.</small>
                            </div>
                        </div>

                        <style>
                            .disabled-label { opacity: 0.6; cursor: not-allowed; }
                        </style>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-1"></i> Daftarkan Antrian
                            </button>
                            <a href="{{ route('antrian.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-info-circle me-1"></i> Cara Kerja RBR + TBS</div>
                <div class="card-body small">
                    <h6><i class="bi bi-cpu me-1"></i> Rule-Based Reasoning (RBR)</h6>
                    <p class="mb-2">Sistem mencocokkan keluhan pasien dengan aturan prioritas:</p>
                    <ul class="list-unstyled mb-3">
                        <li class="mb-1">🔴 <strong>Gawat</strong>: Pendarahan, kejang, pecah ketuban</li>
                        <li class="mb-1">🟡 <strong>Mendesak</strong>: Demam tinggi, nyeri hebat, TD tidak normal</li>
                        <li>🟢 <strong>Biasa</strong>: Kontrol rutin, konsultasi, imunisasi</li>
                    </ul>
                    <hr>
                    <h6><i class="bi bi-clock me-1"></i> Time-Based Scheduling (TBS)</h6>
                    <p class="mb-0">Estimasi waktu dihitung dari jumlah pasien aktif × durasi layanan per prioritas. Pasien
                        gawat disisipkan ke depan antrian.</p>
                </div>
            </div>

            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i> Penting</h6>
                    <p class="small mb-0">Bidan tetap dapat memilih prioritas secara manual. Saran otomatis dari keluhan
                        hanya sebagai bantuan (decision support).</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // ─── SEARCH PASIEN ───
        const searchInput = document.getElementById('searchPatient');
        const searchResults = document.getElementById('searchResults');
        const hiddenId = document.getElementById('hiddenPatientId');

        searchInput.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            if (q.length < 1) {
                searchResults.style.display = 'none';
                return;
            }

            const matches = patientData.filter(p =>
                (p.nama ? String(p.nama).toLowerCase() : '').includes(q) ||
                (p.nik ? String(p.nik).toLowerCase() : '').includes(q) ||
                (p.hp ? String(p.hp).toLowerCase() : '').includes(q) ||
                (p.noRm ? String(p.noRm).toLowerCase() : '').includes(q)
            );

            if (matches.length === 0) {
                searchResults.innerHTML = '<div class="list-group-item text-muted small">Tidak ditemukan — data akan didaftarkan sebagai pasien baru</div>';
                searchResults.style.display = 'block';
                return;
            }

            searchResults.innerHTML = matches.map((p, i) => {
                let detail = [];
                if (p.nik) detail.push(`NIK: ${p.nik}`);
                if (p.noRm) detail.push(`No.RM: ${p.noRm}`);
                if (p.hp) detail.push(`HP: ${p.hp}`);
                if (p.umur) detail.push(`${p.umur} th`);
                const detailStr = detail.length ? `<br><small class="text-muted">${detail.join(' • ')}</small>` : '';

                return `<button type="button" class="list-group-item list-group-item-action" data-idx="${i}"
                    onclick="pilihPasien(${i}, this)">
                    <span class="me-1">${p.label}</span>
                    <strong>${p.nama}</strong>
                    <span class="badge bg-light text-dark border ms-1">${p.group}</span>
                    ${detailStr}
                </button>`;
            }).join('');
            searchResults.style.display = 'block';

            // Store filtered results for selection
            searchResults._matches = matches;
        });

        function pilihPasien(idx, btn) {
            const matches = searchResults._matches;
            const p = matches[idx];

            // Set form values
            hiddenId.value = p.id || '';
            document.getElementById('inputNama').value = p.nama;
            document.getElementById('inputUmur').value = p.umur || '';
            document.getElementById('inputHp').value = p.hp || '';

            // Update search input to show selection
            searchInput.value = `${p.label} ${p.nama}`;
            searchInput.classList.add('border-success');
            setTimeout(() => searchInput.classList.remove('border-success'), 1500);

            searchResults.style.display = 'none';
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });

        // Reset hidden ID saat user mengetik ulang
        searchInput.addEventListener('input', function () {
            hiddenId.value = '';
        });

        // Toggle Veto
        const switchVeto = document.getElementById('switchVeto');
        const prioRadios = document.querySelectorAll('input[name="prioritas_id"]');
        const prioLabels = document.querySelectorAll('.disabled-label');
        
        switchVeto.addEventListener('change', function() {
            const isVeto = this.checked;
            prioRadios.forEach(radio => {
                radio.disabled = !isVeto;
                radio.required = isVeto; // Menambahkan atribut required
            });
            prioLabels.forEach(label => {
                if(isVeto) label.classList.remove('disabled-label');
                else label.classList.add('disabled-label');
            });
        });

        // RBR: Suggest prioritas otomatis saat input berubah
        let debounceTimer;
        const triggerRBR = function () {
            clearTimeout(debounceTimer);
            const keluhan = document.getElementById('inputKeluhan').value;
            const layanan = document.getElementById('inputLayanan').value;
            const sistolik = document.getElementById('inputSistolik').value;
            const diastolik = document.getElementById('inputDiastolik').value;

            debounceTimer = setTimeout(() => {
                fetch('{{ route("antrian.suggest") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        keluhan: keluhan,
                        jenis_layanan: layanan,
                        tensi_sistolik: sistolik,
                        tensi_diastolik: diastolik
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.prioritas_id) {
                            const colors = { 'GAWAT': 'danger', 'MENDESAK': 'warning', 'BIASA': 'success' };
                            const badge = colors[data.kode] || 'secondary';
                            document.getElementById('rbrSuggestion').innerHTML =
                                `<span class="badge bg-${badge}"><i class="bi bi-robot"></i> Keputusan Sistem: ${data.nama}</span>`;

                            // Auto-select prioritas
                            const radio = document.getElementById('prio_' + data.prioritas_id);
                            if (radio) {
                                // Temporarily enable to check it, if not veto mode
                                radio.checked = true;
                            }
                        } else {
                            document.getElementById('rbrSuggestion').innerHTML = '';
                        }
                    });
            }, 500);
        };

        document.getElementById('inputKeluhan').addEventListener('input', triggerRBR);
        document.getElementById('inputLayanan').addEventListener('change', triggerRBR);
        document.getElementById('inputSistolik').addEventListener('input', triggerRBR);
        document.getElementById('inputDiastolik').addEventListener('input', triggerRBR);
    </script>
@endpush