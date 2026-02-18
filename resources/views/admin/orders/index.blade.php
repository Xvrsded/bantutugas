@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

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

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Klien</th>
                    <th>Email</th>
                    <th>Layanan</th>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->client_name }}</td>
                        <td><small>{{ $order->client_email }}</small></td>
                        <td><small>{{ $order->service->name }}</small></td>
                        <td>
                            <small>
                                <span title="{{ $order->project_title }}">
                                    {{ Str::limit($order->project_title, 25) }}
                                </span>
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
                        <td><small>{{ $order->created_at->format('d/m/Y') }}</small></td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $order->id }})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i><br>
                            Belum ada pesanan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
