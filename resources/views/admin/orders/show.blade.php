@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="row mb-4">
        <div class="col-lg-8">
            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-bag-check"></i> Detail Pesanan #{{ $order->id }}
                    </h5>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Nama Klien:</strong><br>
                                {{ $order->client_name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ $order->client_email }}">{{ $order->client_email }}</a>
                            </p>
                            <p class="mb-2">
                                <strong>WhatsApp:</strong><br>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client_phone) }}" target="_blank">
                                    {{ $order->client_phone }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Layanan:</strong><br>
                                {{ $order->service->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Judul Proyek:</strong><br>
                                {{ $order->project_title }}
                            </p>
                            <p class="mb-2">
                                <strong>Status:</strong><br>
                                <span class="badge bg-{{ $order->status_badge }} fs-6">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <p class="mb-3">
                        <strong>Deskripsi Proyek:</strong><br>
                        <div class="bg-light p-3 rounded">
                            {{ nl2br($order->description) }}
                        </div>
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Deadline:</strong><br>
                                @if ($order->deadline)
                                    {{ $order->deadline->format('d/m/Y H:i') }}
                                    @if ($order->deadline->isPast())
                                        <span class="badge bg-danger">OVERDUE</span>
                                    @else
                                        <small class="text-muted">({{ $order->deadline->diffForHumans() }})</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Budget:</strong><br>
                                @if ($order->budget)
                                    Rp {{ number_format($order->budget, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($order->attachment)
                        <p class="mb-0">
                            <strong>Lampiran:</strong><br>
                            <a href="{{ asset('storage/' . $order->attachment) }}" target="_blank" class="btn btn-sm btn-secondary mt-2">
                                <i class="bi bi-download"></i> Download File
                            </a>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Timestamps -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Informasi Sistem</h6>
                    <p class="mb-1">
                        <small><strong>Dibuat:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </p>
                    <p class="mb-0">
                        <small><strong>Diupdate:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Update Status Card -->
            <div class="card mb-4 sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h6 class="card-title">Update Status</h6>
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ $order->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Tambahkan catatan untuk pesanan ini...">{{ $order->notes }}</textarea>
                            <small class="text-muted">Catatan ini hanya untuk internal</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Aksi</h6>
                    <div class="d-grid gap-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client_phone) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="bi bi-whatsapp"></i> Chat WhatsApp
                        </a>
                        <a href="mailto:{{ $order->client_email }}" class="btn btn-info btn-sm">
                            <i class="bi bi-envelope"></i> Kirim Email
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
