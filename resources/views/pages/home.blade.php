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

    <!-- Trust & Introduction Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1.5rem;">
                        Mengapa Memilih bantutugas?
                    </h2>
                    <p style="font-size: 1.1rem; color: #555; line-height: 1.8; margin-bottom: 1.5rem;">
                        Kami adalah platform terpercaya yang telah membantu ribuan pelajar dan profesional mencapai tujuan akademik dan teknologi mereka. Dengan tim ahli berpengalaman, layanan berkualitas tinggi, dan komitmen terhadap kepuasan pelanggan, kami siap menjadi mitra terbaik Anda.
                    </p>
                    <ul style="list-style: none; padding: 0; margin-bottom: 2rem;">
                        <li style="margin-bottom: 1rem; font-size: 1rem; color: #333;">
                            <i class="bi bi-check-circle-fill" style="color: var(--success-color); margin-right: 0.8rem;"></i>
                            <strong>Aman & Terpercaya</strong> - Transaksi aman dengan berbagai metode pembayaran
                        </li>
                        <li style="margin-bottom: 1rem; font-size: 1rem; color: #333;">
                            <i class="bi bi-check-circle-fill" style="color: var(--success-color); margin-right: 0.8rem;"></i>
                            <strong>Tim Profesional</strong> - Ahli berpengalaman siap membantu Anda
                        </li>
                        <li style="margin-bottom: 1rem; font-size: 1rem; color: #333;">
                            <i class="bi bi-check-circle-fill" style="color: var(--success-color); margin-right: 0.8rem;"></i>
                            <strong>Hasil Berkualitas</strong> - Kepuasan pelanggan adalah prioritas utama kami
                        </li>
                        <li style="margin-bottom: 1rem; font-size: 1rem; color: #333;">
                            <i class="bi bi-check-circle-fill" style="color: var(--success-color); margin-right: 0.8rem;"></i>
                            <strong>Respons Cepat</strong> - Dukungan 24/7 untuk semua kebutuhan Anda
                        </li>
                    </ul>
                    <p style="font-style: italic; color: var(--secondary-color); font-weight: 600; font-size: 1.05rem;">
                        "Investasi terbaik adalah investasi pada diri sendiri. Mulai sekarang dan raih kesuksesan Anda!"
                    </p>
                </div>
                <div class="col-lg-6">
                    <div style="background: linear-gradient(135deg, var(--accent-color) 0%, var(--secondary-color) 100%); border-radius: 15px; padding: 2.5rem; color: white; text-align: center; box-shadow: 0 8px 24px rgba(30, 58, 95, 0.2);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 style="margin-bottom: 1.5rem; font-weight: 700; font-size: 1.3rem;">
                            Bergabunglah Dengan Ribuan Pelanggan Puas
                        </h4>
                        <p style="font-size: 1.05rem; margin-bottom: 2rem; line-height: 1.8;">
                            Dari pelajar hingga profesional, semua telah merasakan manfaat layanan kami. Saatnya Anda merasakan pengalaman yang sama!
                        </p>
                        <div style="display: flex; justify-content: space-around; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.3);">
                            <div>
                                <div style="font-size: 2rem; font-weight: 700;">1000+</div>
                                <div style="font-size: 0.9rem; margin-top: 0.5rem;">Pelanggan Puas</div>
                            </div>
                            <div>
                                <div style="font-size: 2rem; font-weight: 700;">100%</div>
                                <div style="font-size: 0.9rem; margin-top: 0.5rem;">Kepuasan</div>
                            </div>
                            <div>
                                <div style="font-size: 2rem; font-weight: 700;">24/7</div>
                                <div style="font-size: 0.9rem; margin-top: 0.5rem;">Dukungan</div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                @php
                                    $priceRange = $service->priceRange;
                                @endphp
                                <p class="text-danger fw-bold">
                                    Rp {{ number_format($priceRange['min'], 0, ',', '.') }}
                                    @if ($priceRange['min'] != $priceRange['max'])
                                        - Rp {{ number_format($priceRange['max'], 0, ',', '.') }}
                                    @endif
                                    <small class="text-muted d-block" style="font-size: 0.8rem;">per unit</small>
                                </p>
                                <a href="{{ route('checkout', ['service' => $service->id]) }}" class="btn btn-sm btn-primary">
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
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Ovo.jpg') }}" alt="OVO" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">OVO</p>
                    </div>

                    <!-- GoPay -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Gopay.png') }}" alt="GoPay" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">GoPay</p>
                    </div>

                    <!-- Dana -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Dana.jpg') }}" alt="Dana" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">Dana</p>
                    </div>

                    <!-- ShopeePay -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Shopepay.png') }}" alt="ShopeePay" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">ShopeePay</p>
                    </div>

                    <!-- Mandiri -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Mandiri.png') }}" alt="Mandiri" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">Mandiri</p>
                    </div>

                    <!-- SeaBank -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Seabank.png') }}" alt="SeaBank" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">SeaBank</p>
                    </div>

                    <!-- Bank Jago -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Jago.png') }}" alt="Bank Jago" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">Bank Jago</p>
                    </div>

                    <!-- Duplicate for seamless loop -->
                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Ovo.jpg') }}" alt="OVO" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                        </div>
                        <p class="payment-name">OVO</p>
                    </div>

                    <div class="payment-item">
                        <div class="payment-logo">
                            <img src="{{ asset('pembayaran/Gopay.png') }}" alt="GoPay" style="max-width: 90%; max-height: 90%; object-fit: contain;">
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
                    background: white;
                    width: 80px;
                    height: 80px;
                    border-radius: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 0.5rem;
                    transition: all 0.3s ease;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    padding: 5px;
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
