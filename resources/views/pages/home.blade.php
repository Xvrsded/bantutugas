@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="brand-title">Bantu Tugas</h1>
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
                        Mengapa Memilih Bantu Tugas?
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

    <!-- Testimonials Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Testimoni Pelanggan</h2>
                <p class="subtitle">Dengarkan langsung dari mereka yang telah merasakan manfaat layanan kami</p>
            </div>

            <div class="row" id="testimonialContainer">
                @forelse ($testimonials as $testimonial)
                    <div class="col-md-6 col-lg-4 mb-4 testimonial-card" data-testimonial-id="{{ $testimonial->id }}">
                        <div class="card h-100" style="border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                            <div class="card-body">
                                <div style="margin-bottom: 1rem;">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    @endfor
                                </div>
                                <p class="card-text" style="color: #555; font-style: italic; margin-bottom: 1.5rem;">
                                    "{{ $testimonial->message }}"
                                </p>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.3rem;">
                                        {{ strtoupper(substr($testimonial->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0" style="color: #333; font-weight: 600;">{{ $testimonial->name }}</h6>
                                        <small style="color: #888;">{{ $testimonial->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Belum ada testimoni. Jadilah yang pertama!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
                </div>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ecf0f1 100%);">
        <div class="container">
            <div class="section-title">
                <h2>Berikan Feedback Anda</h2>
                <p class="subtitle">Bantuan Anda sangat penting untuk kami terus berkembang dan memberikan layanan yang lebih baik</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <form id="feedbackForm" style="background: white; padding: 2.5rem; border-radius: 15px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                        <div class="mb-4">
                            <label for="feedbackName" class="form-label" style="font-weight: 600; color: var(--primary-color);">Nama Anda</label>
                            <input type="text" class="form-control" id="feedbackName" name="name" placeholder="Masukkan nama Anda" required style="border-radius: 8px; padding: 0.75rem; border: 1px solid #ddd;">
                        </div>

                        <div class="mb-4">
                            <label for="feedbackEmail" class="form-label" style="font-weight: 600; color: var(--primary-color);">Email Anda</label>
                            <input type="email" class="form-control" id="feedbackEmail" name="email" placeholder="contoh@email.com" required style="border-radius: 8px; padding: 0.75rem; border: 1px solid #ddd;">
                        </div>

                        <div class="mb-4">
                            <label for="feedbackRating" class="form-label" style="font-weight: 600; color: var(--primary-color);">Rating Layanan Kami</label>
                            <div id="ratingContainer" style="display: flex; gap: 0.5rem; font-size: 1.8rem;">
                                <button type="button" class="rating-star" data-rating="1" style="background: none; border: none; cursor: pointer; color: #ddd; transition: color 0.2s;">★</button>
                                <button type="button" class="rating-star" data-rating="2" style="background: none; border: none; cursor: pointer; color: #ddd; transition: color 0.2s;">★</button>
                                <button type="button" class="rating-star" data-rating="3" style="background: none; border: none; cursor: pointer; color: #ddd; transition: color 0.2s;">★</button>
                                <button type="button" class="rating-star" data-rating="4" style="background: none; border: none; cursor: pointer; color: #ddd; transition: color 0.2s;">★</button>
                                <button type="button" class="rating-star" data-rating="5" style="background: none; border: none; cursor: pointer; color: #ddd; transition: color 0.2s;">★</button>
                            </div>
                            <input type="hidden" id="feedbackRating" name="rating" value="0">
                        </div>

                        <div class="mb-4">
                            <label for="feedbackMessage" class="form-label" style="font-weight: 600; color: var(--primary-color);">Pesan Feedback</label>
                            <textarea class="form-control" id="feedbackMessage" name="message" rows="5" placeholder="Bagikan pengalaman dan saran Anda..." required style="border-radius: 8px; padding: 0.75rem; border: 1px solid #ddd; font-family: inherit;"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 8px; font-weight: 600;">
                                <i class="bi bi-send"></i> Kirim Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        .rating-star {
            padding: 0 !important;
        }

        .rating-star:hover,
        .rating-star.active {
            color: #ffc107 !important;
        }

        #feedbackForm .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }
    </style>

    <script>
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', function(e) {
                e.preventDefault();
                const rating = this.dataset.rating;
                document.getElementById('feedbackRating').value = rating;
                
                document.querySelectorAll('.rating-star').forEach(s => {
                    s.classList.remove('active');
                    s.style.color = '#ddd';
                });
                
                this.classList.add('active');
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.rating-star')[i].style.color = '#ffc107';
                }
            });

            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
                document.querySelectorAll('.rating-star').forEach(s => {
                    s.style.color = '#ddd';
                });
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.rating-star')[i].style.color = '#ffc107';
                }
            });
        });

        document.getElementById('ratingContainer').addEventListener('mouseleave', function() {
            const currentRating = document.getElementById('feedbackRating').value;
            document.querySelectorAll('.rating-star').forEach(s => {
                s.style.color = '#ddd';
            });
            for (let i = 0; i < currentRating; i++) {
                document.querySelectorAll('.rating-star')[i].style.color = '#ffc107';
            }
        });

        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const rating = document.getElementById('feedbackRating').value;
            
            if (rating == 0) {
                alert('Silakan berikan rating!');
                return;
            }

            const formData = new FormData(this);
            
            // Submit via AJAX
            fetch('{{ route("testimonial.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new testimonial to the page
                    const testimonial = data.testimonial;
                    const initials = testimonial.name.substring(0, 2).toUpperCase();
                    const starsHtml = '⭐'.repeat(testimonial.rating);
                    
                    const testimonialCard = `
                        <div class="col-md-6 col-lg-4 mb-4 testimonial-card" data-testimonial-id="${testimonial.id}" style="animation: slideIn 0.5s ease-in-out;">
                            <div class="card h-100" style="border: 1px solid #e0e0e0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                                <div class="card-body">
                                    <div style="margin-bottom: 1rem;">
                                        ${Array(parseInt(testimonial.rating)).fill('<i class="bi bi-star-fill" style="color: #ffc107;"></i>').join('')}
                                    </div>
                                    <p class="card-text" style="color: #555; font-style: italic; margin-bottom: 1.5rem;">
                                        "${testimonial.message}"
                                    </p>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.3rem;">
                                            ${initials}
                                        </div>
                                        <div>
                                            <h6 class="mb-0" style="color: #333; font-weight: 600;">${testimonial.name}</h6>
                                            <small style="color: #888;">${testimonial.email}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Remove "Belum ada testimoni" message if it exists
                    const emptyMessage = document.querySelector('#testimonialContainer .col-12');
                    if (emptyMessage) {
                        emptyMessage.remove();
                    }
                    
                    // Add new testimonial to container
                    document.getElementById('testimonialContainer').insertAdjacentHTML('afterbegin', testimonialCard);
                    
                    // Show success message
                    alert('Terima kasih atas feedback Anda! Testimoni Anda telah ditambahkan.');
                    
                    // Reset form
                    this.reset();
                    document.getElementById('feedbackRating').value = 0;
                    document.querySelectorAll('.rating-star').forEach(s => {
                        s.style.color = '#ddd';
                    });
                    
                    // Scroll to testimonials
                    document.getElementById('testimonialContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

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
