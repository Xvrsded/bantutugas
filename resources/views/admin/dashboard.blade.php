@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #f39c12;">
                <div class="stat-value" style="color: #f39c12;">{{ $stats['pending_orders'] }}</div>
                <div class="stat-label">Pesanan Pending</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-value" style="color: #3498db;">{{ $stats['in_progress_orders'] }}</div>
                <div class="stat-label">Sedang Dikerjakan</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #27ae60;">
                <div class="stat-value" style="color: #27ae60;">{{ $stats['completed_orders'] }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #9b59b6;">
                <div class="stat-value" style="color: #9b59b6;">{{ $stats['total_services'] }}</div>
                <div class="stat-label">Total Layanan</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #1abc9c;">
                <div class="stat-value" style="color: #1abc9c;">{{ $stats['total_portfolios'] }}</div>
                <div class="stat-label">Portofolio</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="border-left-color: #34495e;">
                <div class="stat-value" style="color: #34495e;">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Total Admin</div>
            </div>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Status Pesanan</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Pending</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($order_status_data['pending'] / $stats['total_orders'] * 100) ?? 0 }}%">
                                            {{ $order_status_data['pending'] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Accepted</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ ($order_status_data['accepted'] / $stats['total_orders'] * 100) ?? 0 }}%">
                                            {{ $order_status_data['accepted'] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>In Progress</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($order_status_data['in_progress'] / $stats['total_orders'] * 100) ?? 0 }}%">
                                            {{ $order_status_data['in_progress'] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Completed</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($order_status_data['completed'] / $stats['total_orders'] * 100) ?? 0 }}%">
                                            {{ $order_status_data['completed'] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Rejected</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($order_status_data['rejected'] / $stats['total_orders'] * 100) ?? 0 }}%">
                                            {{ $order_status_data['rejected'] }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Ringkasan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-bag-check text-danger"></i>
                            <strong>Total Pesanan:</strong> {{ $stats['total_orders'] }}
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-clock text-warning"></i>
                            <strong>Menunggu Konfirmasi:</strong> {{ $stats['pending_orders'] }}
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-hourglass-split text-primary"></i>
                            <strong>Sedang Dikerjakan:</strong> {{ $stats['in_progress_orders'] }}
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle text-success"></i>
                            <strong>Selesai:</strong> {{ $stats['completed_orders'] }}
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Semua Pesanan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Pesanan Terbaru</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Klien</th>
                            <th>Layanan</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recent_orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->client_name }}</td>
                                <td><small>{{ $order->service->name }}</small></td>
                                <td>{{ Str::limit($order->project_title, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td><small>{{ $order->created_at->format('d/m/Y H:i') }}</small></td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
