@extends('layouts.admin')

@section('title', 'Dashboard')

@section('extra-css')
<style>
    .kpi-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 12px rgba(30, 58, 95, 0.06);
        height: 100%;
    }

    .kpi-label {
        color: #6b7280;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        margin-bottom: 0.45rem;
    }

    .kpi-value {
        color: #1e3a5f;
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .kpi-meta {
        margin-top: 0.35rem;
        font-size: 0.82rem;
        color: #6b7280;
    }

    .panel-title {
        font-weight: 700;
        color: #1e3a5f;
        font-size: 1.05rem;
    }

    .panel-subtitle {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .mini-progress-row {
        display: grid;
        grid-template-columns: 110px 1fr 44px;
        align-items: center;
        gap: 0.7rem;
        margin-bottom: 0.8rem;
    }

    .mini-progress-row:last-child {
        margin-bottom: 0;
    }

    .mini-progress-row .label {
        font-size: 0.86rem;
        color: #374151;
    }

    .mini-progress-row .count {
        text-align: right;
        font-size: 0.83rem;
        font-weight: 600;
        color: #4b5563;
    }
</style>
@endsection

@section('content')
    @php
        $totalOrders = max((int) $stats['total_orders'], 1);
    @endphp

    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <div class="panel-title">Ringkasan Operasional</div>
                <div class="panel-subtitle">Pantau performa pesanan dan tindak lanjuti pekerjaan prioritas lebih cepat.</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-list-check"></i> Kelola Pesanan
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-arrow-up-right"></i> Lihat Website
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Total Pesanan</div>
                <div class="kpi-value">{{ $stats['total_orders'] }}</div>
                <div class="kpi-meta">Semua order yang tercatat</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Butuh Tindakan</div>
                <div class="kpi-value">{{ $stats['pending_orders'] }}</div>
                <div class="kpi-meta">Menunggu konfirmasi admin</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Order Hari Ini</div>
                <div class="kpi-value">{{ $stats['today_orders'] }}</div>
                <div class="kpi-meta">Pesanan baru hari ini</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Overdue Aktif</div>
                <div class="kpi-value">{{ $stats['overdue_orders'] }}</div>
                <div class="kpi-meta">Melewati deadline & belum selesai</div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Sedang Dikerjakan</div>
                <div class="kpi-value">{{ $stats['in_progress_orders'] }}</div>
                <div class="kpi-meta">Order status in progress</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Order Selesai</div>
                <div class="kpi-value">{{ $stats['completed_orders'] }}</div>
                <div class="kpi-meta">Tingkat selesai {{ $stats['completion_rate'] }}%</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Revenue Selesai</div>
                <div class="kpi-value">Rp {{ number_format($stats['completed_revenue'], 0, ',', '.') }}</div>
                <div class="kpi-meta">Akumulasi order completed</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="kpi-card">
                <div class="kpi-label">Data Sistem</div>
                <div class="kpi-value">{{ $stats['total_services'] }} / {{ $stats['total_portfolios'] }} / {{ $stats['total_users'] }}</div>
                <div class="kpi-meta">Layanan / Portofolio / Admin</div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Distribusi Status</h6>
                    <div class="mini-progress-row">
                        <div class="label">Pending</div>
                        <div class="progress" style="height: 10px;"><div class="progress-bar bg-warning" style="width: {{ ($order_status_data['pending'] / $totalOrders) * 100 }}%"></div></div>
                        <div class="count">{{ $order_status_data['pending'] }}</div>
                    </div>
                    <div class="mini-progress-row">
                        <div class="label">Accepted</div>
                        <div class="progress" style="height: 10px;"><div class="progress-bar bg-info" style="width: {{ ($order_status_data['accepted'] / $totalOrders) * 100 }}%"></div></div>
                        <div class="count">{{ $order_status_data['accepted'] }}</div>
                    </div>
                    <div class="mini-progress-row">
                        <div class="label">In Progress</div>
                        <div class="progress" style="height: 10px;"><div class="progress-bar bg-primary" style="width: {{ ($order_status_data['in_progress'] / $totalOrders) * 100 }}%"></div></div>
                        <div class="count">{{ $order_status_data['in_progress'] }}</div>
                    </div>
                    <div class="mini-progress-row">
                        <div class="label">Completed</div>
                        <div class="progress" style="height: 10px;"><div class="progress-bar bg-success" style="width: {{ ($order_status_data['completed'] / $totalOrders) * 100 }}%"></div></div>
                        <div class="count">{{ $order_status_data['completed'] }}</div>
                    </div>
                    <div class="mini-progress-row">
                        <div class="label">Rejected</div>
                        <div class="progress" style="height: 10px;"><div class="progress-bar bg-danger" style="width: {{ ($order_status_data['rejected'] / $totalOrders) * 100 }}%"></div></div>
                        <div class="count">{{ $order_status_data['rejected'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Aksi Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-primary btn-sm text-start">
                            <i class="bi bi-clock-history"></i> Tinjau Pesanan Pending
                        </a>
                        <a href="{{ route('admin.orders.index', ['period' => 'overdue']) }}" class="btn btn-outline-danger btn-sm text-start">
                            <i class="bi bi-exclamation-circle"></i> Cek Pesanan Overdue
                        </a>
                        <a href="{{ route('admin.orders.index', ['status' => 'in_progress']) }}" class="btn btn-outline-secondary btn-sm text-start">
                            <i class="bi bi-arrow-repeat"></i> Lanjutkan Pekerjaan Aktif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">Pesanan Terbaru</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                    Lihat Semua
                </a>
            </div>
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
                                <td><small>{{ optional($order->service)->name ?? '-' }}</small></td>
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
