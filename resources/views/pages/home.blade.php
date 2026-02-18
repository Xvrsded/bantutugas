@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>bantutugas</h1>
            <p class="tagline">Platform Jasa Akademik dan Konsultasi Teknologi Terpercaya</p>
            <div class="mt-4">
                <a href="{{ route('services') }}" class="btn btn-light btn-lg me-3">
                    <i class="bi bi-briefcase"></i> Jelajahi Layanan
                </a>
                <a href="{{ route('how-to-order') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-question-circle"></i> Cara Pesan
                </a>
            </div>
        </div>
    </section>

    <!-- Highlight Services -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Unggulan</h2>
                <p class="subtitle">Kami menyediakan berbagai layanan berkualitas untuk mendukung kesuksesan akademik dan teknis Anda</p>
            </div>

            <div class="row">
                @forelse ($services as $service)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="card-icon">
                                    <i class="bi bi-{{ $loop->index % 2 == 0 ? 'book' : 'gear' }}"></i>
                                </div>
                                <h5 class="card-title">{{ $service->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($service->description, 80) }}</p>
                                <p class="text-danger fw-bold">
                                    Rp {{ number_format($service->price_start, 0, ',', '.') }}
                                    @if ($service->price_end)
                                        - Rp {{ number_format($service->price_end, 0, ',', '.') }}
                                    @endif
                                </p>
                                <a href="{{ route('order.create', $service) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-cart-plus"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Layanan tidak tersedia untuk saat ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('services') }}" class="btn btn-primary btn-lg">
                    Lihat Semua Layanan
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Portfolio -->
    <section class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Portofolio Terpilih</h2>
                <p class="subtitle">Hasil karya terbaik kami dari berbagai proyek</p>
            </div>

            <div class="row">
                @forelse ($portfolios as $portfolio)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card">
                            @if ($portfolio->image)
                                <img src="{{ asset('storage/' . $portfolio->image) }}" class="card-img-top" alt="{{ $portfolio->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $portfolio->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($portfolio->description, 60) }}</p>
                                <p class="card-text">
                                    <small class="badge bg-secondary">{{ $portfolio->category }}</small>
                                </p>
                                @if ($portfolio->project_url)
                                    <a href="{{ $portfolio->project_url }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-arrow-up-right"></i> Lihat Proyek
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Portofolio belum tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('portfolio') }}" class="btn btn-primary btn-lg">
                    Lihat Semua Portofolio
                </a>
            </div>
        </div>
    </section>

    <!-- Payment Methods -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="section-title">
                <h2>Metode Pembayaran</h2>
                <p class="subtitle">Kami menerima berbagai metode pembayaran untuk kemudahan Anda</p>
            </div>

            <div class="payment-carousel">
                <div class="payment-slider">
                    <!-- E-Wallet: OVO -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #550099 0%, #7c3aed 100%);">
                            <span style="font-size: 2.5rem; font-weight: bold; color: white;">O</span>
                        </div>
                        <p class="payment-name">OVO</p>
                    </div>

                    <!-- E-Wallet: GoPay -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00b4e6 0%, #0099ff 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="40" height="40">
                                <circle cx="20" cy="20" r="12" fill="white"/>
                                <path d="M35 30 L50 15 L50 35 Z" fill="white"/>
                            </svg>
                        </div>
                        <p class="payment-name">GoPay</p>
                    </div>

                    <!-- E-Wallet: Dana -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #0099ff 0%, #0077ff 100%);">
                            <span style="font-size: 2.5rem; font-weight: bold; color: white;">D</span>
                        </div>
                        <p class="payment-name">Dana</p>
                    </div>

                    <!-- E-Wallet: LinkAja -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);">
                            <span style="font-size: 1.8rem; font-weight: bold; color: white;">LA</span>
                        </div>
                        <p class="payment-name">LinkAja</p>
                    </div>

                    <!-- Bank: Mandiri -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                            <span style="font-size: 2rem; font-weight: bold; color: white;">BTN</span>
                        </div>
                        <p class="payment-name">Mandiri</p>
                    </div>

                    <!-- Bank: SeaBank -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #1e90ff 0%, #1873cc 100%);">
                            <span style="font-size: 2.2rem; font-weight: bold; color: white;">≈</span>
                        </div>
                        <p class="payment-name">SeaBank</p>
                    </div>

                    <!-- Bank: Bank Jago -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00a8e8 0%, #0088cc 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="35" height="35">
                                <path d="M30 10 L45 25 L45 50 L15 50 L15 25 Z" fill="white"/>
                                <rect x="20" y="30" width="10" height="12" fill="#00a8e8"/>
                                <rect x="32" y="30" width="10" height="12" fill="#00a8e8"/>
                            </svg>
                        </div>
                        <p class="payment-name">Bank Jago</p>
                    </div>

                    <!-- Duplicate for seamless loop -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #550099 0%, #7c3aed 100%);">
                            <span style="font-size: 2.5rem; font-weight: bold; color: white;">O</span>
                        </div>
                        <p class="payment-name">OVO</p>
                    </div>

                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00b4e6 0%, #0099ff 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="40" height="40">
                                <circle cx="20" cy="20" r="12" fill="white"/>
                                <path d="M35 30 L50 15 L50 35 Z" fill="white"/>
                            </svg>
                        </div>
                        <p class="payment-name">GoPay</p>
                    </div>
                </div>
            </div>

            <style>
                .payment-carousel {
                    overflow: hidden;
                    background: white;
                    border-radius: 8px;
                    padding: 2rem 0;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                }

                .payment-slider {
                    display: flex;
                    animation: slide 15s linear infinite;
                    width: 200%;
                }

                @keyframes slide {
                    0% {
                        transform: translateX(0);
                    }
                    100% {
                        transform: translateX(-50%);
                    }
                }

                .payment-item {
                    flex: 0 0 calc(100% / 9);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 1.5rem;
                    min-width: 120px;
                }

                .payment-logo {
                    background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
                    width: 80px;
                    height: 80px;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 0.5rem;
                    transition: all 0.3s ease;
                    font-weight: bold;
                    color: #1e3a5f;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                }

                .payment-item:hover .payment-logo {
                    transform: translateY(-5px);
                    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.2);
                }

                .payment-name {
                    font-weight: 600;
                    color: #333;
                    font-size: 0.9rem;
                    margin: 0;
                    text-align: center;
                }

                @media (max-width: 768px) {
                    .payment-item {
                        padding: 1rem;
                        min-width: 100px;
                    }

                    .payment-logo {
                        width: 70px;
                        height: 70px;
                    }

                    .payment-logo i {
                        font-size: 2rem !important;
                    }
                }
            </style>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white;">
        <div class="container text-center">
            <h2 class="mb-3">Siap Memulai?</h2>
            <p class="lead mb-4">Hubungi kami sekarang dan dapatkan konsultasi gratis untuk kebutuhan Anda</p>
            <a href="https://wa.me/6288991796535" target="_blank" class="btn btn-light btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
            </a>
        </div>
    </section>
@endsection
