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
                    <!-- OVO -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #550099 0%, #7c3aed 100%); position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="50" height="50">
                                <circle cx="30" cy="30" r="25" fill="white" opacity="0.95"/>
                                <text x="30" y="38" font-family="Arial, sans-serif" font-size="22" font-weight="bold" text-anchor="middle" fill="#550099">OVO</text>
                            </svg>
                        </div>
                        <p class="payment-name">OVO</p>
                    </div>

                    <!-- GoPay -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00b4e6 0%, #0099ff 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <g fill="white">
                                    <circle cx="18" cy="20" r="8"/>
                                    <path d="M35 20 C35 15 40 12 45 12 C50 12 53 15 53 20"/>
                                    <path d="M18 35 C18 28 24 22 30 22 C36 22 42 28 42 35"/>
                                </g>
                            </svg>
                        </div>
                        <p class="payment-name">GoPay</p>
                    </div>

                    <!-- Dana -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00b4e6 0%, #0099ff 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <circle cx="30" cy="30" r="22" fill="white" opacity="0.95"/>
                                <text x="30" y="39" font-family="Arial, sans-serif" font-size="24" font-weight="bold" text-anchor="middle" fill="#0099ff">D</text>
                            </svg>
                        </div>
                        <p class="payment-name">Dana</p>
                    </div>

                    <!-- LinkAja -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #ff5722 0%, #ff7043 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <rect x="8" y="15" width="44" height="30" rx="4" fill="white" opacity="0.95"/>
                                <text x="30" y="38" font-family="Arial, sans-serif" font-size="16" font-weight="bold" text-anchor="middle" fill="#ff5722">LinkAja</text>
                            </svg>
                        </div>
                        <p class="payment-name">LinkAja</p>
                    </div>

                    <!-- Mandiri -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <rect x="10" y="10" width="40" height="40" rx="3" fill="white" opacity="0.95"/>
                                <circle cx="30" cy="30" r="12" fill="#e74c3c"/>
                                <path d="M30 25 L35 35 L25 35 Z" fill="#e74c3c"/>
                            </svg>
                        </div>
                        <p class="payment-name">Mandiri</p>
                    </div>

                    <!-- SeaBank -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #1e90ff 0%, #1873cc 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <ellipse cx="30" cy="30" rx="22" ry="20" fill="white" opacity="0.95"/>
                                <path d="M20 28 Q30 22 40 28" fill="none" stroke="#1e90ff" stroke-width="2" stroke-linecap="round"/>
                                <path d="M20 34 Q30 28 40 34" fill="none" stroke="#1e90ff" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="payment-name">SeaBank</p>
                    </div>

                    <!-- Bank Jago -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00a8e8 0%, #0088cc 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <path d="M30 12 L48 26 L48 48 L12 48 L12 26 Z" fill="white" opacity="0.95"/>
                                <path d="M22 32 L22 42 M38 32 L38 42" stroke="#00a8e8" stroke-width="2" stroke-linecap="round"/>
                                <rect x="28" y="38" width="4" height="4" fill="#00a8e8"/>
                            </svg>
                        </div>
                        <p class="payment-name">Bank Jago</p>
                    </div>

                    <!-- Duplicate for seamless loop -->
                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #550099 0%, #7c3aed 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="50" height="50">
                                <circle cx="30" cy="30" r="25" fill="white" opacity="0.95"/>
                                <text x="30" y="38" font-family="Arial, sans-serif" font-size="22" font-weight="bold" text-anchor="middle" fill="#550099">OVO</text>
                            </svg>
                        </div>
                        <p class="payment-name">OVO</p>
                    </div>

                    <div class="payment-item">
                        <div class="payment-logo" style="background: linear-gradient(135deg, #00b4e6 0%, #0099ff 100%);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="45" height="45">
                                <g fill="white">
                                    <circle cx="18" cy="20" r="8"/>
                                    <path d="M35 20 C35 15 40 12 45 12 C50 12 53 15 53 20"/>
                                    <path d="M18 35 C18 28 24 22 30 22 C36 22 42 28 42 35"/>
                                </g>
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
