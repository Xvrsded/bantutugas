@extends('layouts.app')

@section('title', 'Pesanan Berhasil Dibuat')

@section('content')
    <section class="py-5 bg-light" style="min-height: 60vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card text-center">
                        <div class="card-body py-5">
                            <div style="font-size: 4rem; color: var(--success-color); margin-bottom: 1.5rem;">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>

                            <h2 class="card-title mb-3">Pesanan Berhasil Dibuat!</h2>
                            
                            <p class="card-text text-muted mb-4">
                                Terima kasih telah mempercayai layanan kami. Tim kami akan segera menghubungi Anda untuk konfirmasi dan diskusi lebih lanjut.
                            </p>

                            <div class="alert alert-info mb-4">
                                <strong><i class="bi bi-info-circle"></i> Nomor Pesanan: #{{ $order->id }}</strong><br>
                                <small>Simpan nomor ini untuk referensi Anda</small>
                            </div>

                            <div class="card bg-light mb-4">
                                <div class="card-body text-start">
                                    <h6 class="mb-3"><i class="bi bi-document-text"></i> Detail Pesanan</h6>
                                    <p class="mb-2">
                                        <strong>Nama:</strong> {{ $order->client_name }}<br>
                                        <strong>Email:</strong> {{ $order->client_email }}<br>
                                        <strong>WhatsApp:</strong> {{ $order->client_phone }}<br>
                                        <strong>Layanan:</strong> {{ $order->service->name }}<br>
                                        <strong>Judul:</strong> {{ $order->project_title }}<br>
                                        <strong>Deadline:</strong> {{ $order->deadline->format('d/m/Y H:i') }}<br>
                                        <strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="alert alert-warning mb-4">
                                <i class="bi bi-exclamation-circle"></i> <strong>Apa selanjutnya?</strong><br>
                                <small>
                                    1. Tim kami akan menghubungi Anda melalui WhatsApp dalam 1 jam<br>
                                    2. Kami akan mendiskusikan detail dan harga final<br>
                                    3. Setelah kesepakatan, kirimkan pembayaran<br>
                                    4. Pengerjaan dimulai segera setelah pembayaran diterima
                                </small>
                            </div>

                            <div class="alert alert-success mb-4">
                                <i class="bi bi-chat-left-dots"></i> <strong>Chat WhatsApp</strong><br>
                                <small>Atau hubungi kami langsung melalui WhatsApp untuk respons lebih cepat</small>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success btn-lg">
                                    <i class="bi bi-whatsapp"></i> Chat WhatsApp Sekarang
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-house"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
