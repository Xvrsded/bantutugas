@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
    <!-- Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-4 fw-bold">Hubungi Kami</h1>
            <p class="lead">Kami siap membantu menjawab semua pertanyaan Anda</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <!-- Contact Info -->
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-info-circle text-primary"></i> Informasi Kontak
                            </h5>
                            
                            <div class="mb-4">
                                <h6><i class="bi bi-whatsapp text-success"></i> WhatsApp</h6>
                                <p class="text-muted">
                                    <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                                        +62 812-3456-7890
                                    </a>
                                </p>
                                <small class="text-muted">Response time: Kurang dari 1 jam</small>
                            </div>

                            <div class="mb-4">
                                <h6><i class="bi bi-envelope text-danger"></i> Email</h6>
                                <p class="text-muted">
                                    <a href="mailto:support@academictechsupport.com" class="text-decoration-none">
                                        support@academictechsupport.com
                                    </a>
                                </p>
                                <small class="text-muted">Response time: 1-2 jam</small>
                            </div>

                            <div class="mb-4">
                                <h6><i class="bi bi-clock text-warning"></i> Jam Operasional</h6>
                                <p class="text-muted">
                                    Senin - Jumat: 08:00 - 20:00<br>
                                    Sabtu: 10:00 - 18:00<br>
                                    Minggu: Libur
                                </p>
                            </div>

                            <div>
                                <h6><i class="bi bi-lightning-charge text-info"></i> Respons Cepat</h6>
                                <p class="text-muted">
                                    Gunakan WhatsApp untuk respons tercepat. Tim kami siap 24/7 untuk pertanyaan mendesak.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-chat-dots text-primary"></i> Kirim Pesan
                            </h5>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.send') }}">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" required value="{{ old('subject') }}">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-send"></i> Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WhatsApp CTA -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3">
                    <h3>Butuh Respons Lebih Cepat?</h3>
                    <p class="lead">Hubungi kami melalui WhatsApp untuk respons instan dan konsultasi gratis!</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success btn-lg">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
