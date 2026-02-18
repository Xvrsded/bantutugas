@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
    <!-- Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-4 fw-bold">Layanan Kami</h1>
            <p class="lead">Temukan solusi lengkap untuk kebutuhan akademik dan teknologi Anda</p>
        </div>
    </section>

    <!-- Academic Services -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Akademik</h2>
                <p class="subtitle">Bantuan penuh untuk semua kebutuhan akademik Anda</p>
            </div>

            <div class="row">
                @forelse ($academicServices as $service)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-icon text-center">
                                    <i class="bi bi-book"></i>
                                </div>
                                <h5 class="card-title text-center">{{ $service->name }}</h5>
                                <p class="card-text">{{ $service->description }}</p>
                                
                                @php
                                    $features = $service->features;
                                    if (is_string($features)) {
                                        $features = json_decode($features, true);
                                    }
                                    $features = is_array($features) ? $features : [];
                                @endphp
                                
                                @if (!empty($features))
                                    <h6 class="mt-3 mb-2">Fitur:</h6>
                                    <ul class="small">
                                        @foreach ($features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <div class="text-center mt-4">
                                    <p class="text-danger fw-bold">
                                        Rp {{ number_format($service->price_start, 0, ',', '.') }}
                                        @if ($service->price_end)
                                            - Rp {{ number_format($service->price_end, 0, ',', '.') }}
                                        @endif
                                    </p>
                                    <a href="{{ route('order.create', $service) }}" class="btn btn-primary">
                                        <i class="bi bi-cart-plus"></i> Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Layanan akademik tidak tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Tech Services -->
    <section class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Teknis & Pemrograman</h2>
                <p class="subtitle">Solusi teknis modern untuk proyek Anda</p>
            </div>

            <div class="row">
                @forelse ($techServices as $service)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="card-icon text-center">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <h5 class="card-title text-center">{{ $service->name }}</h5>
                                <p class="card-text">{{ $service->description }}</p>
                                
                                @php
                                    $features = $service->features;
                                    if (is_string($features)) {
                                        $features = json_decode($features, true);
                                    }
                                    $features = is_array($features) ? $features : [];
                                @endphp
                                
                                @if (!empty($features))
                                    <h6 class="mt-3 mb-2">Fitur:</h6>
                                    <ul class="small">
                                        @foreach ($features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <div class="text-center mt-4">
                                    <p class="text-danger fw-bold">
                                        Rp {{ number_format($service->price_start, 0, ',', '.') }}
                                        @if ($service->price_end)
                                            - Rp {{ number_format($service->price_end, 0, ',', '.') }}
                                        @endif
                                    </p>
                                    <a href="{{ route('order.create', $service) }}" class="btn btn-primary">
                                        <i class="bi bi-cart-plus"></i> Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Layanan teknis tidak tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Pilih Kami?</h2>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <i class="bi bi-award" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                        <h5>Tim Profesional</h5>
                        <p class="text-muted">Tim berpengalaman di bidangnya masing-masing</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <i class="bi bi-lightning-charge" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                        <h5>Cepat & Efisien</h5>
                        <p class="text-muted">Pengerjaan cepat tanpa mengorbankan kualitas</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                        <h5>Terjamin Kualitas</h5>
                        <p class="text-muted">Hasil berkualitas tinggi dengan revisi unlimited</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <i class="bi bi-chat-dots" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                        <h5>Support 24/7</h5>
                        <p class="text-muted">Siap membantu Anda kapan saja melalui WhatsApp</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
