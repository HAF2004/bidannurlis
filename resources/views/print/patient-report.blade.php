<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pasien - {{ $patient->nama }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .print-controls {
            text-align: center;
            padding: 15px;
            background: #f0f0f0;
            margin-bottom: 20px;
        }

        .print-controls button {
            padding: 8px 24px;
            font-size: 14px;
            cursor: pointer;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            margin: 0 5px;
        }

        .print-controls button.secondary {
            background: #6b7280;
        }

        @media print {
            .print-controls {
                display: none;
            }
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 14pt;
        }

        .header p {
            margin: 2px 0;
            font-size: 9pt;
            color: #444;
        }

        .patient-info {
            border: 1px solid #000;
            padding: 8px 12px;
            margin-bottom: 12px;
        }

        .patient-info table {
            width: 100%;
            font-size: 9pt;
        }

        .patient-info td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .patient-info td.label {
            font-weight: bold;
            width: 120px;
        }

        .section-title {
            background: #000;
            color: #fff;
            padding: 4px 10px;
            font-size: 10pt;
            font-weight: bold;
            margin: 12px 0 6px 0;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-bottom: 10px;
        }

        table.report-table th,
        table.report-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }

        table.report-table th {
            background: #e0e0e0;
            font-weight: bold;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            margin-top: 20px;
            font-size: 8pt;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="print-controls">
        <button onclick="window.print()">🖨️ Print</button>
        <button class="secondary" onclick="window.close()">✕ Tutup</button>
    </div>

    {{-- HEADER --}}
    <div class="header">
        <h2>REKAM MEDIS PASIEN</h2>
        <p>Praktik Bidan</p>
    </div>

    {{-- PATIENT INFO --}}
    <div class="patient-info">
        <table>
            <tr>
                <td class="label">No. RM</td>
                <td>: {{ $patient->no_rm ?? '-' }}</td>
                <td class="label">Jenis Kelamin</td>
                <td>: {{ $patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $patient->nama }}</td>
                <td class="label">Gol. Darah</td>
                <td>: {{ $patient->gol_darah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>: {{ $patient->nik ?? '-' }}</td>
                <td class="label">No. HP</td>
                <td>: {{ $patient->telp_hp ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">TTL</td>
                <td>:
                    {{ $patient->tempat_lahir ?? '' }}{{ $patient->tanggal_lahir ? ', ' . $patient->tanggal_lahir->format('d/m/Y') : '' }}
                </td>
                <td class="label">No. BPJS</td>
                <td>: {{ $patient->no_bpjs ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td colspan="3">: {{ $patient->alamat ?? '-' }}
                    @if($patient->desa_kelurahan), {{ $patient->desa_kelurahan }}@endif
                    @if($patient->kecamatan), {{ $patient->kecamatan }}@endif
                </td>
            </tr>
        </table>
    </div>

    {{-- BEROBAT UMUM --}}
    @if($patient->generalTreatments->count())
        <div class="section-title">RIWAYAT BEROBAT UMUM</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keluhan</th>
                    <th>TD</th>
                    <th>Suhu</th>
                    <th>BB</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Obat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->generalTreatments as $i => $t)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td style="white-space: nowrap;">{{ $t->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td>{{ $t->keluhan ?? '-' }}</td>
                        <td style="text-align: center;">
                            {{ $t->td_sistol && $t->td_diastol ? $t->td_sistol . '/' . $t->td_diastol : '-' }}</td>
                        <td style="text-align: center;">{{ $t->suhu ?? '-' }}</td>
                        <td style="text-align: center;">{{ $t->bb_kg ?? '-' }}</td>
                        <td>{{ $t->diagnosa ?? '-' }}</td>
                        <td>{{ $t->tindakan ?? '-' }}</td>
                        <td>{{ $t->resep_obat ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- IMUNISASI --}}
    @if($patient->immunizations->count())
        <div class="section-title">RIWAYAT IMUNISASI</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Vaksin</th>
                    <th>Dosis</th>
                    <th>Batch No</th>
                    <th>Lokasi</th>
                    <th>BB</th>
                    <th>TB</th>
                    <th>Petugas</th>
                    <th>KIPI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->immunizations as $i => $imun)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td style="white-space: nowrap;">{{ $imun->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $imun->jenis_vaksin }}</td>
                        <td style="text-align: center;">{{ $imun->dosis ?? '-' }}</td>
                        <td>{{ $imun->batch_no ?? '-' }}</td>
                        <td>{{ $imun->lokasi_penyuntikan ?? '-' }}</td>
                        <td style="text-align: center;">{{ $imun->bb_kg ?? '-' }}</td>
                        <td style="text-align: center;">{{ $imun->tb_cm ?? '-' }}</td>
                        <td>{{ $imun->petugas ?? '-' }}</td>
                        <td>{{ $imun->reaksi_kipi ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- KB --}}
    @if($patient->kbRegisters->count())
        <div class="section-title">DATA KELUARGA BERENCANA</div>
        @foreach($patient->kbRegisters as $kb)
            <div style="border: 1px solid #000; padding: 5px 8px; margin-bottom: 8px;">
                <table style="width: 100%; font-size: 8pt; margin-bottom: 4px;">
                    <tr>
                        <td style="width: 100px; font-weight: bold;">No. Register</td>
                        <td>: {{ $kb->no_register }}</td>
                        <td style="width: 80px; font-weight: bold;">Metode</td>
                        <td>: {{ $kb->metode_kb ?? '-' }}</td>
                        <td style="width: 80px; font-weight: bold;">Status</td>
                        <td>: {{ $kb->status_peserta }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Tgl Daftar</td>
                        <td>: {{ $kb->tanggal_daftar->format('d/m/Y') }}</td>
                        <td style="font-weight: bold;">Suami</td>
                        <td colspan="3">: {{ $kb->nama_suami ?? '-' }}</td>
                    </tr>
                </table>
                @if($kb->visits->count())
                    <table class="report-table" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Metode</th>
                                <th>Keluhan</th>
                                <th>Tindakan</th>
                                <th>Biaya</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kb->visits as $v)
                                <tr>
                                    <td>{{ $v->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $v->metode_kb ?? '-' }}</td>
                                    <td>{{ $v->keluhan ?? '-' }}</td>
                                    <td>{{ $v->tindakan ?? '-' }}</td>
                                    <td>{{ $v->sumber_biaya ?? '-' }}</td>
                                    <td>{{ $v->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    @endif

    {{-- LAHIRAN --}}
    @if($patient->birthReports->count())
        <div class="section-title">LAPORAN PARTUS</div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Anak Ke</th>
                    <th>Jenis</th>
                    <th>Bayi</th>
                    <th>JK</th>
                    <th>BB Bayi</th>
                    <th>PB</th>
                    <th>Keadaan Ibu</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patient->birthReports as $i => $br)
                    <tr>
                        <td style="text-align: center;">{{ $i + 1 }}</td>
                        <td style="white-space: nowrap;">{{ $br->tanggal_partus->format('d/m/Y') }}</td>
                        <td>{{ $br->jam_partus ?? '-' }}</td>
                        <td style="text-align: center;">{{ $br->anak_ke ?? '-' }}</td>
                        <td>{{ $br->jenis_partus }}</td>
                        <td style="text-align: center;">{{ $br->keadaan_bayi }}</td>
                        <td style="text-align: center;">{{ $br->jenis_kelamin_bayi ?? '-' }}</td>
                        <td style="text-align: center;">{{ $br->bb_bayi_gram ? $br->bb_bayi_gram . ' g' : '-' }}</td>
                        <td style="text-align: center;">{{ $br->pb_bayi_cm ? $br->pb_bayi_cm . ' cm' : '-' }}</td>
                        <td>{{ $br->keadaan_ibu ?? '-' }}</td>
                        <td>{{ $br->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>