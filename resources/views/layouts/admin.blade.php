<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #1e3a5f;
            --secondary-color: #0066cc;
            --accent-color: #00d4ff;
            --success-color: #27ae60;
            --light-bg: #ecf0f1;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fb;
            color: #1f2937;
        }

        .admin-shell {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: var(--primary-color);
            color: white;
            min-height: 100vh;
            width: 260px;
            position: sticky;
            top: 0;
            padding-bottom: 1rem;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .sidebar-caption {
            display: block;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.65);
            margin-top: 0.35rem;
            font-weight: 500;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0.8rem 0.65rem 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.3rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            border-radius: 10px;
            padding: 0.8rem 0.95rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(2px);
        }

        .sidebar-menu i {
            margin-right: 0.7rem;
            width: 20px;
        }

        .sidebar-divider {
            border-color: rgba(255,255,255,0.15);
            margin: 0.75rem 0.55rem;
        }

        .main-content {
            flex: 1;
            padding: 1.35rem;
        }

        .admin-header {
            background-color: white;
            padding: 1.1rem 1.25rem;
            border-radius: 12px;
            border: 1px solid #e8edf3;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.06);
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 1rem;
            z-index: 10;
        }

        .admin-header h1 {
            margin: 0;
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.92rem;
            color: #4b5563;
            background-color: #f6f9fc;
            border: 1px solid #e8edf3;
            padding: 0.45rem 0.7rem;
            border-radius: 999px;
        }

        .content-section {
            background: transparent;
            border-radius: 12px;
        }

        .card {
            border: 1px solid #e8edf3;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.06);
        }

        .stat-card {
            background-color: white;
            padding: 1.1rem;
            border-radius: 12px;
            border: 1px solid #e8edf3;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.06);
            border-left: 4px solid var(--secondary-color);
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            line-height: 1.2;
        }

        .stat-card .stat-label {
            color: #666;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .table-responsive {
            background-color: white;
            border-radius: 12px;
            border: 1px solid #e8edf3;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.06);
            padding: 1rem;
        }

        .table {
            margin: 0;
        }

        .table thead {
            background-color: #f6f9fc;
        }

        .table thead th {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 1px solid #e8edf3;
            font-size: 0.86rem;
        }

        .table tbody tr:hover {
            background-color: #f9fbfd;
        }

        .badge {
            padding: 0.38rem 0.65rem;
            font-weight: 600;
            font-size: 0.76rem;
            border-radius: 999px;
        }

        .form-control,
        .form-select {
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            padding: 0.62rem 0.72rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #004a99;
            border-color: #004a99;
        }

        .logout-btn {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 0.95rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .logout-btn:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(2px);
        }

        @media (max-width: 768px) {
            .admin-shell {
                display: block;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                min-height: auto;
            }

            .main-content {
                padding: 1rem;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                position: static;
            }

            .admin-header h1 {
                margin-bottom: 0.7rem;
            }

            .sidebar-menu a {
                padding: 0.75rem 0.85rem;
            }
        }
    </style>

    @yield('extra-css')
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="sidebar-brand">
                Admin Panel
                <span class="sidebar-caption">Bantu Tugas Management</span>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="{{ Route::is('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check"></i> Pesanan
                    </a>
                </li>
                <li>
                    <hr class="sidebar-divider">
                </li>
                <li>
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house"></i> Lihat Website
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="padding: 0; margin: 0;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="bi bi-box-arrow-right" style="margin-right: 0.7rem; width: 20px;"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="admin-header">
                <h1>@yield('title')</h1>
                <div class="user-info">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="content-section">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')
</body>
</html>
