@extends('layouts.app')

@section('title', 'Disclaimer')

@section('content')
    <!-- Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-4 fw-bold">Disclaimer</h1>
            <p class="lead">Syarat & Ketentuan Layanan Kami</p>
        </div>
    </section>

    <!-- Disclaimer Content -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-info-circle"></i> Layanan Pendampingan Akademik</h5>
                            <p class="card-text">
                                bantutugas menyediakan layanan <strong>pendampingan dan konsultasi akademik</strong>, bukan layanan menulis atau mengerjakan tugas untuk diserahkan langsung sebagai hasil karya pribadi Anda. Semua layanan yang kami berikan dirancang untuk membantu, membimbing, dan meningkatkan pemahaman Anda terhadap materi akademik.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-exclamation-triangle"></i> Tanggung Jawab Klien</h5>
                            <p class="card-text">
                                Klien bertanggung jawab penuh atas penggunaan hasil dari layanan kami. Klien harus memastikan bahwa hasil yang kami berikan digunakan sesuai dengan:
                            </p>
                            <ul>
                                <li>Peraturan institusi pendidikan yang berlaku</li>
                                <li>Kode etik akademik</li>
                                <li>Ketentuan hukum yang berlaku di negara tempat domisili</li>
                                <li>Peraturan anti-plagiarisme dari institusi</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-shield-check"></i> Keaslian Karya</h5>
                            <p class="card-text">
                                Semua hasil kerja kami adalah karya orisinal dan bebas plagiarisme. Namun, kami tidak bertanggung jawab jika hasil tersebut dianggap tidak orisinal oleh pihak ketiga karena penggunaan atau modifikasi yang tidak sesuai oleh klien.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-lock"></i> Kerahasiaan & Privasi</h5>
                            <p class="card-text">
                                Kami menjaga kerahasiaan semua informasi dan detail proyek yang Anda berikan. Data klien tidak akan dibagikan kepada pihak ketiga tanpa persetujuan tertulis dari klien, kecuali diwajibkan oleh hukum.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-clock-history"></i> Revisi & Perbaikan</h5>
                            <p class="card-text">
                                Ngezoom bareng tersedia untuk pembahasan sampai jelas, dengan syarat masih berada dalam scope pekerjaan yang disepakati di awal. Perubahan scope besar akan dikenakan biaya tambahan.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-cash-coin"></i> Kebijakan Pembayaran</h5>
                            <p class="card-text">
                                <strong>Pembayaran:</strong> Dapat dilakukan melalui transfer bank, e-wallet, atau cicilan sesuai kesepakatan. Pengerjaan dimulai setelah pembayaran diterima atau sesuai kesepakatan (DP, lunas, atau cicilan terakhir).<br><br>
                                <strong>Pengembalian Dana:</strong> Uang tidak dapat dikembalikan setelah pengerjaan dimulai, kecuali untuk kasus khusus yang akan dipertimbangkan secara kasus per kasus.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-exclamation-octagon"></i> Pembatasan Tanggung Jawab</h5>
                            <p class="card-text">
                                bantutugas tidak bertanggung jawab atas:
                            </p>
                            <ul>
                                <li>Nilai/grade yang diterima dari hasil layanan kami</li>
                                <li>Keputusan dosen atau institusi terkait hasil kerja</li>
                                <li>Masalah hukum atau akademik yang timbul dari penggunaan hasil kerja kami</li>
                                <li>Kerugian tidak langsung atau konsekuensial dari penggunaan layanan kami</li>
                                <li>Kehilangan data atau delay karena pihak klien</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-file-ruled"></i> Hak Intelektual</h5>
                            <p class="card-text">
                                Hak intelektual atas hasil kerja yang kami ciptakan untuk klien menjadi milik klien setelah pembayaran dilakukan. Klien bebas untuk menggunakan, memodifikasi, atau mendistribusikan hasil tersebut sesuai kebutuhannya, dengan tetap mempertahankan tanggung jawab atas penggunaannya.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-pencil-square"></i> Perubahan Disclaimer</h5>
                            <p class="card-text">
                                Kami berhak untuk mengubah atau memperbarui disclaimer ini kapan saja tanpa pemberitahuan sebelumnya. Penggunaan layanan kami setelah perubahan berarti Anda menerima disclaimer yang telah diperbarui.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-3 border-danger">
                        <div class="card-body bg-light-danger">
                            <h5 class="card-title text-danger"><i class="bi bi-exclamation-circle"></i> Pernyataan Penting</h5>
                            <p class="card-text text-danger">
                                <strong>Dengan menggunakan layanan kami, Anda menyatakan bahwa Anda telah membaca, memahami, dan setuju dengan semua syarat dan ketentuan yang tercantum dalam disclaimer ini.</strong>
                            </p>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Jika ada pertanyaan tentang disclaimer ini, silakan hubungi kami melalui <a href="https://wa.me/6281234567890" target="_blank">WhatsApp</a> atau <a href="mailto:support@academictechsupport.com">email</a>.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
