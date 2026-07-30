<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Kartu Ibu - {{ $mother->nama_ibu }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 4mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 6.5pt;
            line-height: 1.2;
            background: #eee;
        }

        .page {
            width: 289mm;
            height: 202mm;
            background: white;
            margin: 0 auto;
            display: flex;
            padding: 2mm;
        }

        .left-side,
        .right-side {
            height: 100%;
            padding: 2mm;
        }

        .left-side {
            width: 50%;
            border-right: 0.4pt solid #000;
        }

        .right-side {
            width: 50%;
        }

        /* Headers */
        h1 {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5mm;
        }

        h2 {
            font-size: 7pt;
            font-weight: bold;
            background: #000;
            color: #fff;
            padding: 0.8mm 2mm;
            margin: 1.5mm 0 1mm;
        }

        h3 {
            font-size: 6.5pt;
            font-weight: bold;
            margin: 1mm 0 0.5mm;
            border-bottom: 0.3pt solid #999;
            padding-bottom: 0.3mm;
        }

        .header-kia {
            font-size: 5.5pt;
            text-align: right;
            color: #666;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
        }

        table.bordered td,
        table.bordered th {
            border: 0.3pt solid #000;
            padding: 0.8mm;
            vertical-align: middle;
            height: 5mm;
            /* Fixed row height */
        }

        table.bordered th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        table.info td {
            padding: 0.5mm 0.8mm;
            vertical-align: top;
        }

        table.info td:first-child {
            font-weight: bold;
            width: 33%;
        }

        /* Checkbox styling */
        .cb-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5mm;
            margin: 0.8mm 0;
            align-items: center;
        }

        .cb-item {
            display: inline-flex;
            align-items: center;
            font-size: 5.5pt;
            padding: 0.4mm 0.8mm;
            gap: 0.5mm;
        }

        .cb {
            width: 2.8mm;
            height: 2.8mm;
            min-width: 2.8mm;
            min-height: 2.8mm;
            border: 0.4pt solid #000;
            display: inline-block;
            text-align: center;
            line-height: 2.8mm;
            vertical-align: middle;
            margin-right: 0.5mm;
            font-size: 6pt;
            font-weight: bold;
        }

        .cb.checked {
            background: #d4edda;
        }

        .cb.checked::before {
            content: "✓";
            color: #155724;
            font-size: 6pt;
        }

        /* Registration boxes */
        .reg-box {
            display: inline-block;
            width: 3.5mm;
            height: 4.5mm;
            border: 0.3pt solid #000;
            text-align: center;
            line-height: 4.5mm;
            font-size: 7pt;
            font-weight: bold;
            margin-right: 0.2mm;
        }

        /* Grid layout */
        .row {
            display: flex;
            gap: 2mm;
            margin-bottom: 0.8mm;
        }

        .col {
            flex: 1;
        }

        .small-text {
            font-size: 5pt;
            color: #666;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        /* KB Legend */
        .kb-legend {
            font-size: 5.5pt;
            padding: 1mm;
            background: #f9f9f9;
            border: 0.3pt solid #ddd;
            margin-bottom: 1mm;
        }

        /* Print controls */
        .no-print {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            display: flex;
            gap: 10px;
        }

        .no-print button {
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        .btn-print {
            background: #4f46e5;
        }

        .btn-back {
            background: #6b7280;
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        /* ANC Page (Back Side) */
        .anc-page {
            page-break-before: always;
            display: block;
            padding: 1mm;
            height: 200mm;
            overflow: hidden;
        }

        .anc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 4pt;
            table-layout: fixed;
        }

        .anc-table th,
        .anc-table td {
            border: 1px solid #000;
            padding: 0.3mm;
            vertical-align: middle;
            text-align: center;
        }

        .anc-table th {
            background: #f0f0f0;
            font-weight: bold;
            font-size: 3.5pt;
        }

        .anc-table tbody td {
            height: 15mm;
            font-size: 4pt;
        }

        .anc-no {
            width: 4mm;
        }

        .anc-cat {
            font-size: 4.5pt !important;
            padding: 0.5mm !important;
            background: #e0e0e0 !important;
        }

        .anc-vertical {
            width: 5.5mm;
            height: 18mm;
            padding: 0.2mm !important;
            position: relative;
            overflow: hidden;
        }

        .anc-vertical span {
            display: block;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            font-size: 3.5pt;
            line-height: 1;
            margin: 0 auto;
        }

        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none !important;
            }

            .page {
                margin: 0;
                page-break-after: always;
            }

            .page:last-child {
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>
    <div class="no-print">
        <a href="{{ route('mothers.show', $mother) }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak</button>
    </div>

    <div class="page">
        <!-- LEFT SIDE: PERSALINAN -->
        <div class="left-side">
            <h2>PERSALINAN</h2>
            @php $d = $mother->deliveries->first(); @endphp

            <table class="bordered" style="margin-bottom: 1.5mm;">
                <tr>
                    <th>Fase</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>UK</th>
                    <th>Perdarahan</th>
                </tr>
                <tr>
                    <td>Kala I Aktif</td>
                    <td class="text-center">{{ $d?->kala1_aktif_tanggal?->format('d/m/y') ?? '' }}</td>
                    <td class="text-center">{{ $d?->kala1_aktif_jam ?? '' }}</td>
                    <td rowspan="4" class="text-center text-bold" style="font-size: 8pt;">
                        {{ $d?->usia_kehamilan_minggu ?? '' }} {{ $d ? 'mg' : '' }}
                    </td>
                    <td rowspan="4" class="text-center">{{ $d?->perdarahan_kala_iv_cc ?? '' }} {{ $d ? 'cc' : '' }}</td>
                </tr>
                <tr>
                    <td>Kala II</td>
                    <td class="text-center">{{ $d?->kala2_tanggal?->format('d/m/y') ?? '' }}</td>
                    <td class="text-center">{{ $d?->kala2_jam ?? '' }}</td>
                </tr>
                <tr>
                    <td>Bayi Lahir</td>
                    <td class="text-center">{{ $d?->bayi_lahir_tanggal?->format('d/m/y') ?? '' }}</td>
                    <td class="text-center">{{ $d?->bayi_lahir_jam ?? '' }}</td>
                </tr>
                <tr>
                    <td>Plasenta</td>
                    <td class="text-center">{{ $d?->plasenta_lahir_tanggal?->format('d/m/y') ?? '' }}</td>
                    <td class="text-center">{{ $d?->plasenta_lahir_jam ?? '' }}</td>
                </tr>
            </table>

            <div class="row">
                <div class="col">
                    <table class="bordered">
                        <tr>
                            <th colspan="2">Kondisi</th>
                        </tr>
                        <tr>
                            <td>Keadaan Ibu</td>
                            <td><span class="cb {{ $d?->keadaan_ibu == 'Hidup' ? 'checked' : '' }}"></span>Hidup <span
                                    class="cb {{ $d?->keadaan_ibu == 'Mati' ? 'checked' : '' }}"></span>Mati</td>
                        </tr>
                        <tr>
                            <td>Keadaan Bayi</td>
                            <td><span class="cb {{ $d?->keadaan_bayi == 'Hidup' ? 'checked' : '' }}"></span>Hidup <span
                                    class="cb {{ $d?->keadaan_bayi == 'Mati' ? 'checked' : '' }}"></span>Mati</td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <table class="bordered">
                        <tr>
                            <th colspan="2">Data Bayi</th>
                        </tr>
                        <tr>
                            <td>BB</td>
                            <td class="text-bold">{{ $d?->berat_bayi_gram ?? '' }}
                                {{ $d?->berat_bayi_gram ? 'gr' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>PB / LK</td>
                            <td>{{ $d?->panjang_badan_cm ?? '' }} / {{ $d?->lingkar_kepala_cm ?? '' }}
                                {{ $d ? 'cm' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td><span class="cb {{ $d?->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}"></span>L <span
                                    class="cb {{ $d?->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}"></span>P</td>
                        </tr>
                    </table>
                </div>
            </div>

            <h3>Presentasi</h3>
            <div class="cb-group">
                @foreach(['Puncak Kepala', 'Belakang Kepala', 'Lintang/Oblique', 'Menumbung', 'Bokong', 'Dahi', 'Muka', 'Kaki', 'Campuran'] as $v)
                    <div class="cb-item"><span class="cb {{ $d?->presentasi == $v ? 'checked' : '' }}"></span>{{ $v }}</div>
                @endforeach
            </div>

            <h3>Tempat Persalinan</h3>
            <div class="cb-group">
                @foreach(['Rumah', 'Polindes', 'Pustu', 'Puskesmas', 'RB', 'RSIA', 'RS', 'RS ODHA'] as $v)
                    <div class="cb-item"><span
                            class="cb {{ $d?->tempat_persalinan == $v ? 'checked' : '' }}"></span>{{ $v }}</div>
                @endforeach
            </div>

            <h3>Penolong</h3>
            <div class="cb-group">
                @foreach(['Keluarga', 'Dukun', 'Bidan', 'Dr Spesialis', 'Dr Lainnya', 'Tidak Ada'] as $v)
                    <div class="cb-item"><span class="cb {{ $d?->penolong == $v ? 'checked' : '' }}"></span>{{ $v }}</div>
                @endforeach
            </div>

            <h3>Cara Persalinan</h3>
            <div class="cb-group">
                @foreach(['Normal', 'Vakum', 'Forseps', 'Seksio Sesarea'] as $v)
                    <div class="cb-item"><span class="cb {{ $d?->cara_persalinan == $v ? 'checked' : '' }}"></span>{{ $v }}
                    </div>
                @endforeach
            </div>

            <h3>Manajemen Aktif Kala III</h3>
            <div class="cb-group">
                @foreach(['Injeksi Oksitosin', 'Peregangan Tali Pusat Terkendali', 'Masase Fundus Uteri'] as $v)
                    <div class="cb-item"><span
                            class="cb {{ in_array($v, $d?->manajemen_aktif_kala_iii ?? []) ? 'checked' : '' }}"></span>{{ $v }}
                    </div>
                @endforeach
            </div>

            <h3>Pelayanan & Komplikasi</h3>
            <div class="cb-group">
                <div class="cb-item">IMD: <span class="cb {{ $d?->imd == '< 1 jam' ? 'checked' : '' }}"></span>&lt;1 jam
                    <span class="cb {{ $d?->imd == '> 1 jam' ? 'checked' : '' }}"></span>&gt;1 jam
                </div>
                <div class="cb-item"><span class="cb {{ $d?->menggunakan_partograf ? 'checked' : '' }}"></span>Partograf
                </div>
                <div class="cb-item"><span class="cb {{ $d?->catat_buku_kia ? 'checked' : '' }}"></span>Buku KIA</div>
                @foreach(['Distosia', 'HDK', 'PPP', 'Infeksi', 'Lainnya'] as $v)
                    <div class="cb-item"><span
                            class="cb {{ in_array($v, $d?->komplikasi_persalinan ?? []) ? 'checked' : '' }}"></span>{{ $v }}
                    </div>
                @endforeach
            </div>

            <h3>Dirujuk ke</h3>
            <div class="cb-group">
                @foreach(['Puskesmas', 'RB', 'RSIA/RSB', 'RS', 'RS ODHA', 'Tidak Dirujuk'] as $v)
                    <div class="cb-item"><span class="cb {{ $d?->dirujuk_ke == $v ? 'checked' : '' }}"></span>{{ $v }}</div>
                @endforeach
            </div>

            <h2>PEMERIKSAAN NIFAS</h2>
            <table class="bordered" style="font-size: 4.5pt;">
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Hari Ke</th>
                    <th colspan="3">KF</th>
                    <th colspan="2">Tanda Vital</th>
                    <th colspan="3">Pelayanan</th>
                    <th colspan="4">Komplikasi**</th>
                    <th rowspan="2">Penanganan</th>
                    <th colspan="5">Dirujuk ke**</th>
                    <th colspan="2">Keadaan</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>TD</th>
                    <th>Suhu</th>
                    <th>KIA</th>
                    <th>Fe*</th>
                    <th>VitA</th>
                    <th>PPP</th>
                    <th>Inf</th>
                    <th>HDK</th>
                    <th>Lain</th>
                    <th>PKM</th>
                    <th>RB</th>
                    <th>RSIA</th>
                    <th>RS</th>
                    <th>ODHA</th>
                    <th>Tiba</th>
                    <th>Plg</th>
                </tr>
                @for($i = 0; $i < 4; $i++)
                    @php $pv = $mother->postpartumVisits[$i] ?? null; @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $pv?->tanggal?->format('d/m/Y') ?? '' }}</td>
                        <td class="text-center">{{ $pv?->hari_ke ?? '' }}</td>
                        <td class="text-center">{{ $pv?->kf == 'KF1' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->kf == 'KF2' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->kf == 'KF3' ? '✓' : '' }}</td>
                        <td>{{ $pv?->td_mmhg ?? '' }}</td>
                        <td>{{ $pv?->suhu_c ?? '' }}</td>
                        <td class="text-center">{{ in_array('Catat di Buku KIA', $pv?->pelayanan ?? []) ? '✓' : '' }}</td>
                        <td class="text-center">{{ in_array('Fe/TTD', $pv?->pelayanan ?? []) ? '✓' : '' }}</td>
                        <td class="text-center">{{ in_array('Vit A', $pv?->pelayanan ?? []) ? '✓' : '' }}</td>
                        <td class="text-center">{{ in_array('PPP', $pv?->komplikasi ?? []) ? '✓' : '' }}</td>
                        <td class="text-center">{{ in_array('Infeksi', $pv?->komplikasi ?? []) ? '✓' : '' }}</td>
                        <td class="text-center">{{ in_array('HDK', $pv?->komplikasi ?? []) ? '✓' : '' }}</td>
                        <td class="text-center">{{ in_array('Lainnya', $pv?->komplikasi ?? []) ? '✓' : '' }}</td>
                        <td>{{ $pv?->penanganan_komplikasi_kebidanan ?? '' }}</td>
                        <td class="text-center">{{ $pv?->dirujuk_ke == 'PKM' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->dirujuk_ke == 'RB' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->dirujuk_ke == 'RSIA/RSB' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->dirujuk_ke == 'RS' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->dirujuk_ke == 'RS ODHA' ? '✓' : '' }}</td>
                        <td class="text-center">{{ $pv?->keadaan_tiba ?? '' }}</td>
                        <td class="text-center">{{ $pv?->keadaan_pulang ?? '' }}</td>
                    </tr>
                @endfor
            </table>
            <div class="kb-legend" style="margin-top: 1mm;">
                <span style="font-size: 4.5pt;"><b>KF:</b> 1=6jam-3hari, 2=4-28hari, 3=29-42hari | * Tulis nama obat |
                    ** ✓/X</span>
            </div>

            <h2>KB PASKA SALIN</h2>
            <div class="kb-legend">
                <strong>Metode KB:</strong> 1. MAL &nbsp; 2. Kondom &nbsp; 3. Pil &nbsp; 4. Suntik &nbsp; 5. AKDR &nbsp;
                6. Implan &nbsp; 7. MOW &nbsp; 8. MOP
            </div>
            <table class="bordered">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Metode KB</th>
                    <th>Rencana</th>
                    <th>Pelaksanaan</th>
                </tr>
                @for($i = 0; $i < 3; $i++)
                    @php $kbi = $mother->familyPlannings[$i] ?? null; @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $kbi?->tanggal?->format('d/m/Y') ?? '' }}</td>
                        <td>{{ $kbi?->metode_kb ?? '' }}</td>
                        <td>{{ $kbi?->rencana ?? '' }}</td>
                        <td>{{ $kbi?->pelaksanaan ?? '' }}</td>
                    </tr>
                @endfor
            </table>
            <div class="text-center small-text" style="margin-top: 1mm;">Hal. 3</div>
        </div>

        <!-- RIGHT SIDE: KARTU IBU -->
        <div class="right-side">
            <div class="header-kia">Lembar KIA 2a</div>
            <h1>KARTU IBU</h1>

            <table class="info" style="margin-bottom: 1.5mm;">
                <tr>
                    <td>Puskesmas</td>
                    <td colspan="3"><strong>{{ $mother->puskesmas ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td>No. Registrasi</td>
                    <td colspan="3">@foreach(str_split(str_pad($mother->no_registrasi ?? '', 16, ' ')) as $c)<span
                    class="reg-box">{{ $c }}</span>@endforeach</td>
                </tr>
                <tr>
                    <td>Nama Ibu</td>
                    <td colspan="3"><strong style="font-size: 11pt;">{{ $mother->nama_ibu }}</strong></td>
                </tr>
                <tr>
                    <td>Nama Suami</td>
                    <td colspan="3"><strong>{{ $mother->nama_suami ?? '-' }}</strong></td>
                </tr>
            </table>

            <div class="row">
                <div class="col">
                    <table class="info">
                        <tr>
                            <td>Tgl. Lahir</td>
                            <td>{{ $mother->tgl_lahir?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td>{{ $mother->umur ?? '-' }} th</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $mother->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>RT/RW</td>
                            <td>{{ $mother->rt ?? '-' }}/{{ $mother->rw ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Desa/Kel</td>
                            <td>{{ $mother->desa_kelurahan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>{{ $mother->kecamatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>{{ $mother->kabupaten ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td>{{ $mother->provinsi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <table class="info">
                        <tr>
                            <td>Agama</td>
                            <td>{{ $mother->agama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pendidikan</td>
                            <td>{{ $mother->pendidikan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan Ibu</td>
                            <td>{{ $mother->pekerjaan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan Suami</td>
                            <td>{{ $mother->pekerjaan_suami ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tgl. Menikah</td>
                            <td>{{ $mother->tgl_menikah?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jamkes</td>
                            <td>{{ $mother->jamkes ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Gol. Darah</td>
                            <td>@foreach(['A', 'B', 'AB', 'O'] as $g)<span
                                class="cb {{ $mother->gol_darah == $g ? 'checked' : '' }}"></span>{{ $g }}
                            @endforeach</td>
                        </tr>
                        <tr>
                            <td>Telp/HP</td>
                            <td>{{ $mother->telp_hp ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="info">
                        <tr>
                            <td>Posyandu</td>
                            <td>{{ $mother->posyandu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Kader</td>
                            <td>{{ $mother->nama_kader ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Dukun</td>
                            <td>{{ $mother->nama_dukun ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <h2>RIWAYAT OBSTETRIK</h2>
                    <table class="bordered">
                        <tr>
                            <td>Gravida</td>
                            <td class="text-center text-bold" style="font-size: 10pt;">{{ $mother->gravida }}</td>
                            <td>Partus</td>
                            <td class="text-center text-bold" style="font-size: 10pt;">{{ $mother->partus }}</td>
                        </tr>
                        <tr>
                            <td>Abortus</td>
                            <td class="text-center text-bold" style="font-size: 10pt;">{{ $mother->abortus }}</td>
                            <td>Hidup</td>
                            <td class="text-center text-bold" style="font-size: 10pt;">{{ $mother->hidup }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <h2>PEMERIKSAAN BIDAN</h2>
            @php $e = $mother->midwifeExam; @endphp
            <div class="row">
                <div class="col">
                    <table class="info">
                        <tr>
                            <td>Tgl. Periksa</td>
                            <td>{{ $e?->tanggal_periksa?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>HPHT</td>
                            <td>{{ $e?->tanggal_hpht?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Taksiran Persalinan</td>
                            <td>{{ $e?->taksiran_persalinan?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>BB Sebelum Hamil</td>
                            <td>{{ $e?->bb_sebelum_hamil ?? '-' }} kg</td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <table class="info">
                        <tr>
                            <td>Tinggi Badan</td>
                            <td>{{ $e?->tinggi_badan ?? '-' }} cm</td>
                        </tr>
                        <tr>
                            <td>LILA</td>
                            <td>{{ $e?->lila ?? '-' }} cm</td>
                        </tr>
                        <tr>
                            <td>Status Gizi</td>
                            <td><span class="cb {{ $e?->status_gizi == 'KEK' ? 'checked' : '' }}"></span>KEK <span
                                    class="cb {{ $e?->status_gizi == 'Normal' ? 'checked' : '' }}"></span>Normal</td>
                        </tr>
                        <tr>
                            <td>Buku KIA</td>
                            <td><span class="cb {{ $e?->buku_kia == 'Memiliki' ? 'checked' : '' }}"></span>Punya <span
                                    class="cb {{ $e?->buku_kia == 'Tidak Memiliki' ? 'checked' : '' }}"></span>Tidak
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div style="font-size: 5.5pt; padding: 1mm; background: #f5f5f5; margin: 1mm 0;">
                <strong>Riwayat Komplikasi:</strong> {{ $e?->riwayat_komplikasi_kebidanan ?? '-' }} | <strong>Penyakit
                    Kronis/Alergi:</strong> {{ $e?->riwayat_kronis_dan_alergi ?? '-' }}
            </div>

            <h2>RENCANA PERSALINAN</h2>
            <table class="bordered">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Penolong</th>
                    <th>Tempat</th>
                    <th>Pendamping</th>
                    <th>Transportasi</th>
                    <th>Pendonor</th>
                </tr>
                @for($i = 0; $i < 3; $i++)
                    @php $bp = $mother->birthPlans[$i] ?? null; @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $bp?->tanggal?->format('d/m/Y') ?? '' }}</td>
                        <td>{{ $bp?->penolong ?? '' }}</td>
                        <td>{{ $bp?->tempat ?? '' }}</td>
                        <td>{{ $bp?->pendamping ?? '' }}</td>
                        <td>{{ $bp?->transportasi ?? '' }}</td>
                        <td>{{ $bp?->pendonor_darah ?? '' }}</td>
                    </tr>
                @endfor
            </table>

            <div style="margin-top: 1.5mm; font-size: 5pt; display: flex; gap: 2mm; flex-wrap: wrap;">
                <span><b>Penolong:</b> 1.Dr Sp 2.Dr Umum 3.Bidan 4.Dukun 5.Keluarga 6.Lain</span>
                <span><b>Tempat:</b> 1.Rumah 2.Poskesdes 3.Pustu 4.PKM 5.RB 6.RSIA 7.RS 8.ODHA</span>
                <span><b>Pendamping/Transport/Donor:</b> 1.Suami 2.Keluarga 3.Teman 4.Tetangga 5.Lain</span>
            </div>

            <div class="text-center small-text" style="margin-top: 1mm;">Hal. 1</div>
        </div>
    </div>
    <!-- PAGE 2: ANTE NATAL CARE (Back Side) -->
    <div class="page anc-page">
        <div style="width: 100%; height: 100%;">
            <h2
                style="text-align: center; font-size: 10pt; margin-bottom: 2mm; background: #000; color: #fff; padding: 1.5mm 3mm;">
                ANTE NATAL CARE
            </h2>

            <table class="anc-table">
                <colgroup>
                    <col style="width: 2.5%;"><!-- No -->
                    @for($c = 0; $c < 36; $c++)
                        <col style="width: {{ 97.5 / 36 }}%;">
                    @endfor
                </colgroup>
                <thead>
                    <!-- Row 1: Top-level category headers -->
                    <tr>
                        <th rowspan="3" class="anc-no anc-cat">No.</th>
                        <th colspan="3" class="anc-cat">Register</th>
                        <th colspan="10" class="anc-cat">Pemeriksaan</th>
                        <th rowspan="3" class="anc-vertical"><span>Status Imunitas TT</span></th>
                        <th colspan="4" class="anc-cat">Pelayanan</th>
                        <th colspan="6" class="anc-cat">Laboratorium</th>
                        <th colspan="12" class="anc-cat">Integrasi Program</th>
                    </tr>
                    <!-- Row 2: Sub-category headers -->
                    <tr>
                        <th rowspan="2" class="anc-vertical"><span>Tanggal</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Usia Kehamilan (Mg)</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Trimester ke</span></th>
                        <!-- Pemeriksaan Ibu -->
                        <th colspan="4" class="anc-cat" style="font-size: 4.5pt; padding: 0.5mm;">Ibu</th>
                        <!-- Pemeriksaan Bayi -->
                        <th colspan="6" class="anc-cat" style="font-size: 4.5pt; padding: 0.5mm;">Bayi</th>
                        <!-- Pelayanan -->
                        <th rowspan="2" class="anc-vertical"><span>Injeksi TT</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Catat di Buku KIA</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Fe/TTD</span></th>
                        <th rowspan="2" class="anc-vertical"><span>PMK Bumil KEK</span></th>
                        <!-- Laboratorium -->
                        <th rowspan="2" class="anc-vertical"><span>Hb (g/dl)</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Anemia (+/-)</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Gula Darah</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Thalasemia</span></th>
                        <th rowspan="2" class="anc-vertical"><span>HBsAg</span></th>
                        <th rowspan="2" class="anc-vertical"><span>Sifilis</span></th>
                        <!-- Integrasi Program: PPIA -->
                        <th colspan="4" class="anc-cat" style="font-size: 3.5pt; padding: 0.5mm; line-height: 1.1;">
                            Pencegahan Penularan
                            HIV dari Ibu ke Anak (PPIA)</th>
                        <!-- Integrasi Program: Malaria -->
                        <th colspan="3" class="anc-cat" style="font-size: 4pt; padding: 0.5mm;">Malaria</th>
                        <!-- Integrasi Program: TB -->
                        <th colspan="2" class="anc-cat" style="font-size: 4pt; padding: 0.5mm;">TB</th>
                        <!-- Ankylostoma -->
                        <th rowspan="2" class="anc-vertical"><span>Ankylostoma (+/-)</span></th>
                        <!-- IMS -->
                        <th colspan="2" class="anc-cat" style="font-size: 4pt; padding: 0.5mm;">IMS</th>
                    </tr>
                    <!-- Row 3: Detail column headers -->
                    <tr>
                        <!-- Pemeriksaan Ibu detail -->
                        <th class="anc-vertical"><span>Anamnesis</span></th>
                        <th class="anc-vertical"><span>BB (kg)</span></th>
                        <th class="anc-vertical"><span>TFU (cm)</span></th>
                        <th class="anc-vertical"><span>Refleks Patella</span></th>
                        <!-- Pemeriksaan Bayi detail -->
                        <th class="anc-vertical"><span>DJJ (x/mnt)</span></th>
                        <th class="anc-vertical"><span>Kepala thd</span></th>
                        <th class="anc-vertical"><span>TBJ</span></th>
                        <th class="anc-vertical"><span>Presentasi</span></th>
                        <th class="anc-vertical"><span>Jumlah Janin</span></th>
                        <th class="anc-vertical"><span>Konseling</span></th>
                        <!-- PPIA detail -->
                        <th class="anc-vertical"><span>Datang dgn HIV (+)</span></th>
                        <th class="anc-vertical"><span>Ditawarkan Tes*</span></th>
                        <th class="anc-vertical"><span>HIV +/-</span></th>
                        <th class="anc-vertical"><span>Mendapatkan ARV</span></th>
                        <!-- Malaria detail -->
                        <th class="anc-vertical"><span>Diberikan Kelambu</span></th>
                        <th class="anc-vertical"><span>Malaria +/-</span></th>
                        <th class="anc-vertical"><span>Obat**</span></th>
                        <!-- TB detail -->
                        <th class="anc-vertical"><span>TBC (+/-)</span></th>
                        <th class="anc-vertical"><span>Obat</span></th>
                        <!-- IMS detail -->
                        <th class="anc-vertical"><span>Diperiksa*</span></th>
                        <th class="anc-vertical"><span>Diagnosis IMS</span></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < 10; $i++)
                        @php $anc = $mother->ancVisits[$i] ?? null; @endphp
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <!-- Register -->
                            <td class="text-center">{{ $anc?->tanggal_kunjungan?->format('d/m/y') ?? '' }}</td>
                            <td class="text-center">{{ $anc?->usia_kehamilan_minggu ?? '' }}</td>
                            <td class="text-center">{{ $anc?->trimester ?? '' }}</td>
                            <!-- Pemeriksaan Ibu -->
                            <td style="font-size: 3.5pt;">{{ $anc?->anamnesis ?? '' }}</td>
                            <td class="text-center">{{ $anc?->bb_kg ?? '' }}</td>
                            <td class="text-center">{{ $anc?->tfu_cm ?? '' }}</td>
                            <td class="text-center">{{ $anc?->refleks_patella ?? '' }}</td>
                            <!-- Pemeriksaan Bayi -->
                            <td class="text-center">{{ $anc?->djj ?? '' }}</td>
                            <td class="text-center">{{ $anc?->kepala_thd ?? '' }}</td>
                            <td class="text-center">{{ $anc?->tbj_gram ?? '' }}</td>
                            <td class="text-center">{{ $anc?->presentasi ?? '' }}</td>
                            <td class="text-center">{{ $anc?->jumlah_janin ?? '' }}</td>
                            <td style="font-size: 3.5pt;">{{ $anc?->konseling ?? '' }}</td>
                            <!-- Status Imunitas TT -->
                            <td class="text-center">{{ $anc?->status_imunisasi_tt ?? '' }}</td>
                            <!-- Pelayanan -->
                            <td class="text-center">{{ $anc?->injeksi_tt ? '✓' : '' }}</td>
                            <td class="text-center">{{ $anc?->catat_buku_kia ? '✓' : '' }}</td>
                            <td class="text-center">{{ $anc?->fe_tablet ?? '' }}</td>
                            <td class="text-center">{{ $anc?->pmk_bumil_kek ? '✓' : '' }}</td>
                            <!-- Laboratorium -->
                            <td class="text-center">{{ $anc?->hb ?? '' }}</td>
                            <td class="text-center">{{ $anc?->anemia ?? '' }}</td>
                            <td class="text-center">{{ $anc?->gula_darah ?? '' }}</td>
                            <td class="text-center">{{ $anc?->thalasemia ?? '' }}</td>
                            <td class="text-center">{{ $anc?->hbsag ?? '' }}</td>
                            <td class="text-center">{{ $anc?->sifilis ?? '' }}</td>
                            <!-- Integrasi Program: PPIA -->
                            <td class="text-center">{{ $anc?->datang_dengan_hiv ? '✓' : '' }}</td>
                            <td class="text-center">{{ $anc?->ditawarkan_tes_hiv ? '✓' : '' }}</td>
                            <td class="text-center">{{ $anc?->hasil_hiv ?? '' }}</td>
                            <td class="text-center">{{ $anc?->mendapatkan_arv ? '✓' : '' }}</td>
                            <!-- Integrasi Program: Malaria -->
                            <td class="text-center">{{ $anc?->diberikan_kelambu ? '✓' : '' }}</td>
                            <td class="text-center">{{ $anc?->hasil_malaria ?? '' }}</td>
                            <td class="text-center">{{ $anc?->obat_malaria ?? '' }}</td>
                            <!-- Integrasi Program: TB -->
                            <td class="text-center">{{ $anc?->hasil_tb ?? '' }}</td>
                            <td class="text-center">{{ $anc?->obat_tb ?? '' }}</td>
                            <!-- Ankylostoma -->
                            <td class="text-center">{{ $anc?->ankylostoma ?? '' }}</td>
                            <!-- IMS -->
                            <td class="text-center">{{ $anc?->diperiksa_ims ? '✓' : '' }}</td>
                            <td style="font-size: 3.5pt;">{{ $anc?->diagnosis_ims ?? '' }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <div class="kb-legend" style="margin-top: 1.5mm; font-size: 4.5pt;">
                <b>Keterangan:</b> * Tes ditawarkan sesuai kebijakan | ** Tulis nama obat
            </div>
            <div class="text-center small-text" style="margin-top: 1mm;">Hal. 2</div>
        </div>
    </div>
</body>

</html>