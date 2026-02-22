<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Bantu Tugas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #1e3a5f;
            --secondary-color: #0066cc;
            --accent-color: #00d4ff;
            --success-color: #27ae60;
            --light-bg: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: white !important;
        }

        .navbar-brand i {
            margin-right: 0.5rem;
            color: var(--secondary-color);
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--secondary-color) !important;
        }

        .nav-link.active {
            color: var(--secondary-color) !important;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            font-weight: 600;
            padding: 0.6rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: #004a99;
            border-color: #004a99;
        }

        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .brand-title {
            letter-spacing: 1px;
            text-transform: capitalize;
        }

        .hero .tagline {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: rgba(255,255,255,0.9);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer-section h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--secondary-color);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            line-height: 2;
        }

        .footer-section a:hover {
            color: var(--secondary-color);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .section-title .subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        /* Alert */
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .hero .tagline {
                font-size: 1.1rem;
            }
        }
    </style>

    @yield('extra-css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Bantu Tugas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('services') ? 'active' : '' }}" href="{{ route('services') }}">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('how-to-order') ? 'active' : '' }}" href="{{ route('how-to-order') }}">Cara Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="text-decoration: none;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 footer-section mb-4">
                    <h5>Bantu Tugas</h5>
                    <p>Menyediakan layanan bantuan akademik dan teknologi berkualitas untuk kesuksesan Anda.</p>
                </div>
                <div class="col-md-3 col-sm-6 footer-section mb-4">
                    <h5>Layanan</h5>
                    <ul>
                        <li><a href="{{ route('services') }}">Semua Layanan</a></li>
                        <li><a href="{{ route('portfolio') }}">Portofolio</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer-section mb-4">
                    <h5>Informasi</h5>
                    <ul>
                        <li><a href="{{ route('how-to-order') }}">Cara Pemesanan</a></li>
                        <li><a href="{{ route('contact') }}">Hubungi Kami</a></li>
                        <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer-section mb-4">
                    <h5>Hubungi Kami</h5>
                    <p>
                        <i class="bi bi-whatsapp"></i> <a href="https://wa.me/{{ config('app.whatsapp_number') }}" target="_blank">{{ config('app.whatsapp_display') }}</a>
                    </p>
                    <p>
                        <i class="bi bi-envelope"></i> <a href="mailto:support@bantutugas.com">support@bantutugas.com</a>
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ now()->year }} Bantu Tugas. All rights reserved. | <a href="{{ route('disclaimer') }}">Disclaimer</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    
    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pesanan</h5>
                <button type="button" class="btn-close" onclick="closeConfirmationModal()"></button>
            </div>
            <div class="modal-body">
                <p>Anda akan menambahkan layanan berikut ke keranjang:</p>
                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1rem 0;">
                    <h6 id="confirm-service-name" style="margin-bottom: 0.5rem;"></h6>
                    <p id="confirm-service-price" style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin: 0;"></p>
                </div>
                <p class="text-muted small">Anda dapat mengubah jumlah pesanan dan menambah layanan lain di keranjang sebelum checkout.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeConfirmationModal()">Batal</button>
                <button type="button" class="btn btn-primary" onclick="confirmAddToCart()">
                    <i class="bi bi-cart-plus"></i> Tambahkan ke Keranjang
                </button>
            </div>
            <input type="hidden" id="confirm-service-id">
            <input type="hidden" id="confirm-service-price-value">
        </div>
    </div>

    <!-- Floating Cart Widget -->
    <div id="cart-widget" class="cart-widget">
        <button id="cart-toggle" class="cart-toggle" title="Buka Keranjang">
            <i class="bi bi-cart3"></i>
            <span id="cart-count" class="cart-count" style="display: none;">0</span>
        </button>
        <div class="cart-panel">
            <div class="cart-header">
                <h6>Keranjang Belanja</h6>
                <button type="button" class="btn-close-cart" onclick="document.getElementById('cart-widget').classList.remove('open')" style="font-size: 1.2rem; background: none; border: none; cursor: pointer;">×</button>
            </div>
            <div id="cart-items" class="cart-items">
                <p class="text-muted text-center p-3">Keranjang kosong</p>
            </div>
            <div id="cart-total" class="cart-footer">
                <!-- Total akan di-render oleh JS -->
            </div>
        </div>
    </div>

    <style>
        /* Cart Widget Styles */
        .cart-widget {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 999;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: none; /* Hidden by default, will show when items added */
        }

        .cart-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(30, 58, 95, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-toggle:hover {
            background-color: var(--secondary-color);
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 16px rgba(30, 58, 95, 0.4);
        }

        .cart-toggle:active {
            transform: scale(0.95);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #e74c3c;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Cart Widget Animations */
        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(100px);
                opacity: 0;
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: scale(1);
            }
            25% {
                transform: scale(1.3);
            }
            50% {
                transform: scale(0.9);
            }
            75% {
                transform: scale(1.15);
            }
        }

        .cart-widget.cart-appear {
            animation: slideUp 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .cart-widget.cart-disappear {
            animation: slideDown 0.3s ease-in;
        }

        .cart-count.badge-bounce {
            animation: bounce 0.5s ease;
        }

        .cart-panel {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-widget.open .cart-panel {
            max-height: 500px;
            opacity: 1;
        }

        .cart-header {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-color);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .cart-header h6 {
            margin: 0;
            font-weight: 700;
        }

        .cart-items {
            overflow-y: auto;
            flex: 1;
            max-height: 300px;
        }

        .cart-item-card {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            background: #fff;
        }

        .cart-item-card:hover {
            background-color: #f8f9fa;
        }

        .cart-item-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.5rem;
        }

        .cart-item-header strong {
            flex: 1;
            font-size: 0.95rem;
            color: #333;
        }

        .btn-remove {
            background: none;
            border: none;
            color: #e74c3c;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .btn-remove:hover {
            color: #c0392b;
        }

        .cart-item-price {
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .cart-item-quantity {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            align-items: center;
        }

        .cart-item-quantity button {
            background-color: #e9ecef;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.2s;
        }

        .cart-item-quantity button:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .cart-item-quantity input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .cart-item-subtotal {
            font-size: 0.85rem;
            color: #555;
            text-align: right;
        }

        .cart-footer {
            padding: 1rem;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 12px 12px;
        }

        .cart-total-section {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .total-items, .total-price {
            font-size: 0.9rem;
            color: #555;
        }

        .total-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            margin: 0;
            font-weight: 700;
            color: var(--primary-color);
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        /* Toast Notification */
        .toast-notification {
            position: fixed;
            bottom: 100px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 998;
        }

        .toast-notification.show {
            opacity: 1;
        }

        @media (max-width: 576px) {
            .cart-widget {
                bottom: 1rem;
                right: 1rem;
            }

            .cart-toggle {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            .cart-panel {
                width: 300px;
            }

            .modal-content {
                width: 95%;
            }
        }
    </style>

    @yield('extra-js')
</body>
</html>
