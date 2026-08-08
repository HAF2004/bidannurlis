<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIMAR')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #f8fafc;
            --accent-color: #059669;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: #1e293b;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar .brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .brand h4 {
            color: white;
            margin: 0;
            font-weight: 700;
        }

        .sidebar .brand small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.8rem 1.5rem;
            border-radius: 0;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-color);
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 10px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }




        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .table th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .badge-role-admin {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-role-bidan {
            background: #dbeafe;
            color: #2563eb;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <h4><i class="bi bi-heart-pulse me-2"></i>SIMAR</h4>
            <small>Sistem Informasi Manajemen Antrian dan Rekam Medis</small>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="px-3 mt-3 mb-1"><small class="text-white-50 text-uppercase"
                    style="font-size: 0.65rem; letter-spacing: 0.1em;">Antrian</small></div>
            <a class="nav-link {{ request()->routeIs('antrian.index') || request()->routeIs('antrian.create') ? 'active' : '' }}"
                href="{{ route('antrian.index') }}">
                <i class="bi bi-list-ol"></i> Kelola Antrian
            </a>
            <a class="nav-link {{ request()->routeIs('antrian.riwayat') ? 'active' : '' }}"
                href="{{ route('antrian.riwayat') }}">
                <i class="bi bi-clock-history"></i> Riwayat Antrian
            </a>



            <div class="px-3 mt-3 mb-1"><small class="text-white-50 text-uppercase"
                    style="font-size: 0.65rem; letter-spacing: 0.1em;">Layanan Umum</small></div>
            <a class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}"
                href="{{ route('patients.index') }}">
                <i class="bi bi-people"></i> Data Pasien
            </a>
            <div class="px-3 mt-3 mb-1"><small class="text-white-50 text-uppercase"
                    style="font-size: 0.65rem; letter-spacing: 0.1em;">KIA</small></div>
            <a class="nav-link {{ request()->routeIs('mothers.*') ? 'active' : '' }}"
                href="{{ route('mothers.index') }}">
                <i class="bi bi-gender-female"></i> Kehamilan
            </a>
        </nav>
        <div class="mt-auto p-3" style="position: absolute; bottom: 0; width: 100%;">
            <div class="d-flex align-items-center text-white-50 small">
                <i class="bi bi-person-circle me-2"></i>
                <span>{{ Auth::user()->name ?? 'Guest' }}</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge {{ Auth::user()->role === 'admin' ? 'badge-role-admin' : 'badge-role-bidan' }}">
                    {{ ucfirst(Auth::user()->role ?? 'guest') }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>