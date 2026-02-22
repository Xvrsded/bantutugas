@extends('layouts.app')

@section('title', 'Harga')

@section('content')
    <!-- Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-4 fw-bold">Paket Harga</h1>
            <p class="lead">Transparansi harga untuk semua layanan kami</p>
        </div>
    </section>

    <!-- Pricing Table -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <table class="table mb-0">
                            <thead style="background-color: var(--primary-color); color: white;">
                                <tr>
                                    <th>Layanan</th>
                                    <th>Kategori</th>
                                    <th>Harga Mulai</th>
                                    <th>Harga Maks</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>
                                            <strong>{{ $service->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst(str_replace('-', ' ', $service->category)) }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-danger">Rp {{ number_format($service->price_start, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            @if ($service->price_end)
                                                <strong class="text-danger">Rp {{ number_format($service->price_end, 0, ',', '.') }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('order.create', $service) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-cart-plus"></i> Pesan
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            Layanan tidak tersedia untuk saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ / Pricing Info -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Kebijakan Harga</h2>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-info-circle text-primary"></i> Informasi Penting</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">✓ Harga di atas adalah harga dasar</li>
                                <li class="mb-2">✓ Harga dapat berubah tergantung kompleksitas</li>
                                <li class="mb-2">✓ Konsultasi gratis sebelum pengerjaan</li>
                                <li class="mb-2">✓ Ngezoom bareng hingga jelas</li>
                                <li class="mb-2">✓ Cicilan tersedia untuk proyek besar</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-credit-card text-success"></i> Metode Pembayaran</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">• Transfer Bank</li>
                                <li class="mb-2">• E-Wallet (GCash, OVO, Dana)</li>
                                <li class="mb-2">• Cicilan (sesuai kesepakatan)</li>
                                <li class="mb-2">• Cicilan Tanpa Bunga untuk pemesanan tertentu</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #e67e22 100%); color: white;">
        <div class="container text-center">
            <h2 class="mb-3">Ada pertanyaan tentang harga?</h2>
            <p class="lead mb-4">Hubungi kami untuk konsultasi dan quotation khusus</p>
            <a href="https://wa.me/{{ config('app.whatsapp_number') }}" target="_blank" class="btn btn-light btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
            </a>
        </div>
    </section>
@endsection
