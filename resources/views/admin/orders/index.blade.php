@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('extra-css')
<style>
    .filter-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .table-wrap {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        padding: 1rem;
    }

    .result-meta {
        font-size: 0.9rem;
        color: #666;
    }

    .action-buttons {
        display: flex;
        gap: 0.35rem;
    }

    .quick-filter-links {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 0.75rem;
    }

    .quick-filter-links a {
        text-decoration: none;
        font-size: 0.78rem;
        padding: 0.32rem 0.58rem;
        border: 1px solid #d9e2ec;
        border-radius: 999px;
        color: #4b5563;
        background-color: #fff;
    }

    .quick-filter-links a:hover {
        border-color: var(--secondary-color);
        color: var(--secondary-color);
    }

    .status-inline-form {
        min-width: 140px;
    }
</style>
@endsection

@section('content')
    <!-- Stats Quick View -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-4">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card" style="border-left-color: #f39c12;">
                <div class="stat-value" style="color: #f39c12;">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-value" style="color: #3498db;">{{ $stats['accepted'] }}</div>
                <div class="stat-label">Accepted</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card" style="border-left-color: #2980b9;">
                <div class="stat-value" style="color: #2980b9;">{{ $stats['in_progress'] }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card" style="border-left-color: #27ae60;">
                <div class="stat-value" style="color: #27ae60;">{{ $stats['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="stat-card" style="border-left-color: #e74c3c;">
                <div class="stat-value" style="color: #e74c3c;">{{ $stats['rejected'] }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label for="q" class="form-label mb-1">Cari Pesanan</label>
                <input
                    type="text"
                    id="q"
                    name="q"
                    class="form-control"
                    value="{{ $search }}"
                    placeholder="Nama klien, email, WA, judul, atau ID"
                >
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label mb-1">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ $status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="period" class="form-label mb-1">Periode</label>
                <select id="period" name="period" class="form-select">
                    <option value="">Semua</option>
                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="7days" {{ $period === '7days' ? 'selected' : '' }}>7 Hari</option>
                    <option value="30days" {{ $period === '30days' ? 'selected' : '' }}>30 Hari</option>
                    <option value="overdue" {{ $period === 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>

            <div class="col-md-2 d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Terapkan
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        <div class="result-meta mt-3">
            Menampilkan <strong>{{ $filteredCount }}</strong> pesanan{{ ($search || $status || $period) ? ' sesuai filter' : '' }}.
        </div>

        <div class="quick-filter-links">
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Pending ({{ $stats['pending'] }})</a>
            <a href="{{ route('admin.orders.index', ['status' => 'in_progress']) }}">In Progress ({{ $stats['in_progress'] }})</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}">Completed ({{ $stats['completed'] }})</a>
            <a href="{{ route('admin.orders.index', ['period' => 'overdue']) }}">Overdue</a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-wrap">
        <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Klien</th>
                    <th>Kontak</th>
                    <th>Layanan</th>
                    <th>Judul</th>
                    <th>Nilai</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Quick Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->client_name }}</td>
                        <td>
                            <small class="d-block">{{ $order->client_email }}</small>
                            <small class="text-muted">{{ $order->client_phone }}</small>
                        </td>
                        <td><small>{{ optional($order->service)->name ?? '-' }}</small></td>
                        <td>
                            <small>
                                <span title="{{ $order->project_title }}">
                                    {{ Str::limit($order->project_title, 25) }}
                                </span>
                            </small>
                        </td>
                        <td>
                            <small>
                                @php
                                    $orderValue = $order->admin_adjusted_price ?? $order->final_price ?? $order->subtotal ?? $order->budget;
                                @endphp
                                @if (!is_null($orderValue))
                                    Rp {{ number_format($orderValue, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </small>
                        </td>
                        <td>
                            <small>
                                @if ($order->deadline)
                                    {{ $order->deadline->format('d/m/Y H:i') }}
                                    @if ($order->deadline->isPast())
                                        <span class="badge bg-danger">Overdue</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ ($order->payment_status ?? 'waiting') === 'paid' ? 'success' : 'secondary' }}">
                                {{ ($order->payment_status ?? 'waiting') === 'paid' ? 'Paid' : 'Waiting' }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="status-inline-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="notes" value="{{ $order->notes }}">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="rejected" {{ $order->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <small class="d-block">{{ $order->created_at->format('d/m/Y') }}</small>
                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client_phone) }}" target="_blank" class="btn btn-sm btn-success" title="Chat WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $order->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i><br>
                            Belum ada pesanan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($orders->hasPages())
        <nav class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </nav>
    @endif

    <script>
        function confirmDelete(orderId) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/orders/${orderId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
