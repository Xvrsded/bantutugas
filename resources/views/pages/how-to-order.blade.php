@extends('layouts.app')

@section('title', 'Cara Pemesanan')

@section('content')
    <!-- Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-4 fw-bold">Cara Pemesanan</h1>
            <p class="lead">Proses mudah dan transparan untuk memesan layanan kami</p>
        </div>
    </section>

    <!-- Steps -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <div style="width: 80px; height: 80px; background: var(--secondary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; font-weight: bold;">
                            1
                        </div>
                        <h5>Pilih Layanan</h5>
                        <p class="text-muted">Pilih layanan yang Anda butuhkan dari halaman Layanan atau Harga</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <div style="width: 80px; height: 80px; background: var(--secondary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; font-weight: bold;">
                            2
                        </div>
                        <h5>Isi Formulir</h5>
                        <p class="text-muted">Lengkapi data diri dan detail proyek Anda dengan jelas</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <div style="width: 80px; height: 80px; background: var(--secondary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; font-weight: bold;">
                            3
                        </div>
                        <h5>Konfirmasi</h5>
                        <p class="text-muted">Kami akan menghubungi Anda untuk konfirmasi dan negosiasi harga</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="text-center">
                        <div style="width: 80px; height: 80px; background: var(--secondary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem; font-weight: bold;">
                            4
                        </div>
                        <h5>Pengerjaan</h5>
                        <p class="text-muted">Setelah pembayaran, kami mulai mengerjakan proyek Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Process -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Proses Detail</h2>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="accordion" id="processAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#process1">
                                    <strong>Langkah 1: Jelajahi Layanan</strong>
                                </button>
                            </h2>
                            <div id="process1" class="accordion-collapse collapse show" data-bs-parent="#processAccordion">
                                <div class="accordion-body">
                                    <p>Kunjungi halaman <a href="{{ route('services') }}">Layanan</a> atau <a href="{{ route('pricing') }}">Harga</a> untuk melihat semua layanan yang tersedia. Setiap layanan memiliki deskripsi lengkap dan informasi harga.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#process2">
                                    <strong>Langkah 2: Klik Tombol Pesan</strong>
                                </button>
                            </h2>
                            <div id="process2" class="accordion-collapse collapse" data-bs-parent="#processAccordion">
                                <div class="accordion-body">
                                    <p>Klik tombol "Pesan Sekarang" pada layanan yang Anda pilih. Anda akan diarahkan ke formulir pemesanan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#process3">
                                    <strong>Langkah 3: Isi Formulir Pemesanan</strong>
                                </button>
                            </h2>
                            <div id="process3" class="accordion-collapse collapse" data-bs-parent="#processAccordion">
                                <div class="accordion-body">
                                    <p>Isi formulir dengan informasi:</p>
                                    <ul>
                                        <li>Nama lengkap</li>
                                        <li>Email</li>
                                        <li>Nomor WhatsApp</li>
                                        <li>Judul proyek</li>
                                        <li>Deskripsi detail</li>
                                        <li>Deadline yang diinginkan</li>
                                        <li>Budget (opsional)</li>
                                        <li>Attachment/File (opsional)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#process4">
                                    <strong>Langkah 4: Konfirmasi & Negosiasi</strong>
                                </button>
                            </h2>
                            <div id="process4" class="accordion-collapse collapse" data-bs-parent="#processAccordian">
                                <div class="accordion-body">
                                    <p>Tim kami akan menghubungi Anda melalui WhatsApp untuk:</p>
                                    <ul>
                                        <li>Konfirmasi detail proyek</li>
                                        <li>Diskusi timeline</li>
                                        <li>Negotiasi harga jika diperlukan</li>
                                        <li>Menjawab pertanyaan Anda</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#process5">
                                    <strong>Langkah 5: Pembayaran & Pengerjaan</strong>
                                </button>
                            </h2>
                            <div id="process5" class="accordion-collapse collapse" data-bs-parent="#processAccordion">
                                <div class="accordion-body">
                                    <p>Setelah kesepakatan:</p>
                                    <ul>
                                        <li>Kami akan memberikan invoice</li>
                                        <li>Lakukan pembayaran sesuai kesepakatan (DP, lunas, atau cicilan)</li>
                                        <li>Setelah pembayaran diterima, pengerjaan dimulai</li>
                                        <li>Anda akan mendapat update progress secara berkala</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#process6">
                                    <strong>Langkah 6: Revisi & Finalisasi</strong>
                                </button>
                            </h2>
                            <div id="process6" class="accordion-collapse collapse" data-bs-parent="#processAccordion">
                                <div class="accordion-body">
                                    <p>Setelah draft selesai:</p>
                                    <ul>
                                        <li>Kami akan menunjukkan hasil kerja</li>
                                        <li>Berikan feedback dan permintaan revisi</li>
                                        <li>Ngezoom bareng sampai jelas (sesuai scope)</li>
                                        <li>Setelah final, file dikirimkan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Pertanyaan Umum</h2>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOneCollapse" aria-expanded="true" aria-controls="faqOneCollapse">
                                    <i class="bi bi-question-circle me-2"></i> Berapa lama proses pengerjaan?
                                </button>
                            </h2>
                            <div id="faqOneCollapse" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Waktu pengerjaan tergantung kompleksitas dan deadline yang Anda minta. Kami akan diskusikan detail timeline saat konfirmasi.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwoCollapse" aria-expanded="false" aria-controls="faqTwoCollapse">
                                    <i class="bi bi-question-circle me-2"></i> Apakah ada revisi?
                                </button>
                            </h2>
                            <div id="faqTwoCollapse" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, bisa ngezoom bareng sampai jelas (sesuai dengan scope pekerjaan yang disepakati).
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThreeCollapse" aria-expanded="false" aria-controls="faqThreeCollapse">
                                    <i class="bi bi-question-circle me-2"></i> Apakah ada jaminan kualitas?
                                </button>
                            </h2>
                            <div id="faqThreeCollapse" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, kami menjamin hasil berkualitas tinggi sesuai dengan standar yang disepakati bersama.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFourCollapse" aria-expanded="false" aria-controls="faqFourCollapse">
                                    <i class="bi bi-question-circle me-2"></i> Bagaimana dengan kerahasiaan proyek?
                                </button>
                            </h2>
                            <div id="faqFourCollapse" class="accordion-collapse collapse" aria-labelledby="faqFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Semua proyek dijaga kerahasiaannya sesuai dengan perjanjian kontrak. Kami tidak akan membagikan detail proyek tanpa izin Anda.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #e67e22 100%); color: white;">
        <div class="container text-center">
            <h2 class="mb-3">Siap Memulai?</h2>
            <p class="lead mb-4">Pesan layanan Anda sekarang dan dapatkan konsultasi gratis!</p>
            <a href="{{ route('services') }}" class="btn btn-light btn-lg me-2">
                <i class="bi bi-briefcase"></i> Jelajahi Layanan
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-outline-light btn-lg">
                <i class="bi bi-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </section>
@endsection
