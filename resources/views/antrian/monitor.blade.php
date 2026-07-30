<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Antrian — {{ $namaPraktik }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <meta http-equiv="refresh" content="10">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            overflow: hidden;
        }

        .monitor-header {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
        }

        .clock {
            font-size: 1.5rem;
            font-weight: 300;
        }

        .now-serving {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 20px;
            padding: 2rem 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
            }

            50% {
                box-shadow: 0 20px 60px rgba(59, 130, 246, 0.5);
            }
        }

        .now-serving .number {
            font-size: 6rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: 0.1em;
        }

        .now-serving .name {
            font-size: 2rem;
            font-weight: 300;
            margin-top: 0.5rem;
        }

        .priority-badge {
            display: inline-block;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
        }

        .priority-gawat {
            background: #dc2626;
            color: white;
        }

        .priority-mendesak {
            background: #f59e0b;
            color: #1e293b;
        }

        .priority-biasa {
            background: #22c55e;
            color: white;
        }

        .queue-list {
            max-height: calc(100vh - 380px);
            overflow-y: auto;
        }

        .queue-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .queue-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .queue-number {
            font-size: 1.5rem;
            font-weight: 700;
            min-width: 80px;
        }

        .no-queue {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .no-queue i {
            font-size: 5rem;
        }

        .serving-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="monitor-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 fw-bold">{{ $namaPraktik }}</h4>
            <small class="opacity-75">Sistem Antrian Digital — {{ $tanggal->translatedFormat('l, d F Y') }}</small>
        </div>
        <div class="clock" id="clock"></div>
    </div>

    @php
        $isMenanganiGawat = false;
        if ($dipanggil && $dipanggil->prioritas?->kode === 'GAWAT') $isMenanganiGawat = true;
        foreach($dilayani as $d) {
            if ($d->prioritas?->kode === 'GAWAT') $isMenanganiGawat = true;
        }
    @endphp

    @if($isMenanganiGawat)
    <div class="bg-danger text-white text-center py-2 fw-bold w-100" style="font-size: 1.5rem; letter-spacing: 1px; animation: pulse-glow 2s infinite; border-bottom: 2px solid #b91c1c;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Mohon maaf, Bidan sedang menangani pasien Gawat Darurat.
    </div>
    @endif




    <div class="container-fluid px-4 py-4">
        <div class="row g-4">
            {{-- Kolom Kiri: Sedang Dipanggil --}}
            <div class="col-md-5">
                <div class="serving-label mb-3 text-center">
                    <i class="bi bi-megaphone me-1"></i> SEDANG DIPANGGIL
                </div>

                @if($dipanggil)
                    <div class="now-serving">
                        <div class="number">{{ $dipanggil->no_antrian }}</div>
                        <div class="name">{{ $dipanggil->nama_pasien }}</div>
                        <div class="mt-3">
                            @php
                                $prioClass = match ($dipanggil->prioritas?->kode) {
                                    'GAWAT' => 'priority-gawat',
                                    'MENDESAK' => 'priority-mendesak',
                                    default => 'priority-biasa',
                                };
                            @endphp
                            <span class="priority-badge {{ $prioClass }}">
                                {{ $dipanggil->prioritas?->nama }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="now-serving" style="background: rgba(255,255,255,0.05); box-shadow: none; animation: none;">
                        <div class="opacity-50">
                            <i class="bi bi-hourglass" style="font-size: 3rem;"></i>
                            <div class="mt-2" style="font-size: 1.2rem;">Tidak ada pasien dipanggil</div>
                        </div>
                    </div>
                @endif

                {{-- Sedang Dilayani --}}
                @if($dilayani->count() > 0)
                    <div class="mt-4">
                        <div class="serving-label mb-2 text-center opacity-50">
                            <i class="bi bi-play-circle me-1"></i> SEDANG DILAYANI
                        </div>
                        @foreach($dilayani as $d)
                            <div class="queue-item" style="border-color: rgba(59, 130, 246, 0.3);">
                                <div>
                                    <span class="queue-number text-info">{{ $d->no_antrian }}</span>
                                    <span>{{ $d->nama_pasien }}</span>
                                </div>
                                <span class="badge bg-primary">Dilayani</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan: Daftar Menunggu --}}
            <div class="col-md-7">
                <div class="serving-label mb-3">
                    <i class="bi bi-people me-1"></i> DAFTAR TUNGGU
                    <span class="badge bg-secondary ms-2">{{ $menunggu->count() }}</span>
                </div>

                <div class="queue-list">
                    @forelse($menunggu as $index => $m)
                        @php
                            $prioClass = match ($m->prioritas?->kode) {
                                'GAWAT' => 'priority-gawat',
                                'MENDESAK' => 'priority-mendesak',
                                default => 'priority-biasa',
                            };
                        @endphp
                        <div class="queue-item">
                            <div class="d-flex align-items-center gap-3">
                                <span class="queue-number">{{ $m->no_antrian }}</span>
                                <div>
                                    <strong>{{ $m->nama_pasien }}</strong>
                                    <br>
                                    <span class="priority-badge {{ $prioClass }}"
                                        style="font-size: 0.75rem; padding: 0.2rem 0.8rem;">
                                        {{ $m->prioritas?->nama }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="opacity-75 small">Estimasi</div>
                                <div class="fs-5 fw-bold">{{ $m->estimasi_dilayani ?? '-' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="no-queue">
                            <i class="bi bi-emoji-smile"></i>
                            <p class="mt-3 fs-5">Tidak ada pasien menunggu</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live clock
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('clock').textContent = time;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</body>

</html>