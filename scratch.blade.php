
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

