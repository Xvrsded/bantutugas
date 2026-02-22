@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@php
    $paymentChannel = collect(config('payment.channels', []))->firstWhere('id', (string) $order->payment_method);
@endphp

@section('extra-css')
<style>
    .detail-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-weight: 600;
        color: #1e3a5f;
        margin-bottom: 1rem;
    }

    .quick-status-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }

    .priority-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.32rem 0.6rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid #d9e2ec;
        background-color: #fff;
        color: #4b5563;
    }

    .priority-chip.overdue {
        border-color: #f5c2c7;
        background-color: #fff5f5;
        color: #b42318;
    }

    .contact-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
        margin-top: 0.55rem;
    }

    .contact-actions .btn {
        font-size: 0.78rem;
    }
</style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-lg-8">
            <!-- Order Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-bag-check"></i> Detail Pesanan #{{ $order->id }}
                    </h5>
                    <div class="mb-3">
                        @if ($order->deadline && $order->deadline->isPast() && !in_array($order->status, ['completed', 'rejected'], true))
                            <span class="priority-chip overdue"><i class="bi bi-exclamation-triangle"></i> Prioritas Tinggi - Overdue</span>
                        @else
                            <span class="priority-chip"><i class="bi bi-check2-circle"></i> Monitoring Normal</span>
                        @endif
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="detail-label">Nama Klien</div>
                            <div class="detail-value">{{ $order->client_name }}</div>

                            <div class="detail-label">Email</div>
                            <div class="detail-value"><a href="mailto:{{ $order->client_email }}">{{ $order->client_email }}</a></div>

                            <div class="detail-label">WhatsApp</div>
                            <div class="detail-value">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client_phone) }}" target="_blank">
                                    {{ $order->client_phone }}
                                </a>
                                <div class="contact-actions">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyText('{{ $order->client_phone }}')">
                                        <i class="bi bi-clipboard"></i> Salin WA
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyText('{{ $order->client_email }}')">
                                        <i class="bi bi-clipboard"></i> Salin Email
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Layanan</div>
                            <div class="detail-value">{{ optional($order->service)->name ?? '-' }}</div>

                            <div class="detail-label">Judul Proyek</div>
                            <div class="detail-value">{{ $order->project_title }}</div>

                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <span class="badge bg-{{ $order->status_badge }} fs-6">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="detail-label">Deskripsi Proyek</div>
                    <div class="bg-light p-3 rounded mb-3">{!! nl2br(e($order->description)) !!}</div>

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

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Subtotal:</strong><br>
                                @if (!is_null($order->subtotal))
                                    Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Harga Final:</strong><br>
                                @if (!is_null($order->admin_adjusted_price))
                                    Rp {{ number_format($order->admin_adjusted_price, 0, ',', '.') }}
                                @elseif (!is_null($order->final_price))
                                    Rp {{ number_format($order->final_price, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">Belum dihitung</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Kanal Pembayaran:</strong><br>
                                @if ($paymentChannel)
                                    {{ $paymentChannel['name'] }} - {{ $paymentChannel['number'] }}<br>
                                    <small class="text-muted">a.n. {{ $paymentChannel['holder'] }}</small>
                                @else
                                    <span class="text-muted">Belum dipilih</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Status Pembayaran:</strong><br>
                                <span class="badge bg-{{ ($order->payment_status ?? 'waiting') === 'paid' ? 'success' : 'secondary' }}">
                                    {{ ($order->payment_status ?? 'waiting') === 'paid' ? 'Payment Success' : 'Waiting Payment' }}
                                </span>
                                @if ($order->paid_at)
                                    <br><small class="text-muted">Paid at: {{ $order->paid_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Biaya Admin:</strong><br>
                                Rp {{ number_format($order->payment_admin_fee ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Total Transfer Saat Ini:</strong><br>
                                Rp {{ number_format($order->payment_total_due ?? 0, 0, ',', '.') }}
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
                    <div class="quick-status-grid mb-3">
                        @foreach (['accepted' => 'Terima', 'in_progress' => 'Proses', 'completed' => 'Selesai', 'rejected' => 'Tolak'] as $quickStatus => $quickLabel)
                            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $quickStatus }}">
                                <input type="hidden" name="notes" value="{{ $order->notes }}">
                                <button type="submit" class="btn btn-outline-primary btn-sm w-100" {{ $order->status === $quickStatus ? 'disabled' : '' }}>
                                    {{ $quickLabel }}
                                </button>
                            </form>
                        @endforeach
                    </div>

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

                    <hr>
                    <form method="POST" action="{{ route('admin.orders.update-payment-status', $order) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                <option value="waiting" {{ ($order->payment_status ?? 'waiting') === 'waiting' ? 'selected' : '' }}>Waiting Payment</option>
                                <option value="paid" {{ ($order->payment_status ?? 'waiting') === 'paid' ? 'selected' : '' }}>Payment Success</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="bi bi-cash-coin"></i> Update Pembayaran
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

@section('extra-js')
<script>
    function copyText(value) {
        if (!navigator.clipboard) {
            return;
        }

        navigator.clipboard.writeText(value);
    }
</script>
@endsection
