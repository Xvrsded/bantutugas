@extends('layouts.app')

@section('title', 'Checkout - Pembayaran')

@section('content')
    <!-- Checkout Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-5 fw-bold">Checkout</h1>
            <p class="lead">Lengkapi data dan selesaikan pembayaran Anda</p>
        </div>
    </section>

    <!-- Checkout Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Form Section -->
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="mb-4" style="color: var(--primary-color);">
                                <i class="bi bi-person-fill"></i> Informasi Pemesan
                            </h4>

                            <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
                                @csrf
                                <input type="hidden" name="cart_items" id="cart-items-input">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required placeholder="email@example.com">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" name="whatsapp" class="form-control" required placeholder="08123456789">
                                    <small class="text-muted">Kami akan menghubungi Anda melalui WhatsApp</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail/Catatan Pesanan</label>
                                    <textarea name="notes" class="form-control" rows="4" placeholder="Tuliskan detail pesanan, requirement, atau catatan khusus..."></textarea>
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3" style="color: var(--primary-color);">
                                    <i class="bi bi-credit-card"></i> Metode Pembayaran
                                </h5>

                                <div class="payment-methods">
                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="ovo" value="ovo" required>
                                        <label class="form-check-label" for="ovo">
                                            <img src="{{ asset('pembayaran/Ovo.jpg') }}" alt="OVO" style="height: 30px;">
                                            OVO
                                        </label>
                                    </div>

                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="gopay" value="gopay">
                                        <label class="form-check-label" for="gopay">
                                            <img src="{{ asset('pembayaran/Gopay.png') }}" alt="GoPay" style="height: 30px;">
                                            GoPay
                                        </label>
                                    </div>

                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="dana" value="dana">
                                        <label class="form-check-label" for="dana">
                                            <img src="{{ asset('pembayaran/Dana.jpg') }}" alt="Dana" style="height: 30px;">
                                            Dana
                                        </label>
                                    </div>

                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="shopee" value="shopeepay">
                                        <label class="form-check-label" for="shopee">
                                            <img src="{{ asset('pembayaran/Shopepay.png') }}" alt="ShopeePay" style="height: 30px;">
                                            ShopeePay
                                        </label>
                                    </div>

                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="mandiri" value="bank_mandiri">
                                        <label class="form-check-label" for="mandiri">
                                            <img src="{{ asset('pembayaran/Mandiri.png') }}" alt="Bank Mandiri" style="height: 30px;">
                                            Bank Mandiri
                                        </label>
                                    </div>

                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="seabank" value="seabank">
                                        <label class="form-check-label" for="seabank">
                                            <img src="{{ asset('pembayaran/Seabank.png') }}" alt="SeaBank" style="height: 30px;">
                                            SeaBank
                                        </label>
                                    </div>

                                    <div class="form-check payment-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="jago" value="bank_jago">
                                        <label class="form-check-label" for="jago">
                                            <img src="{{ asset('pembayaran/Jago.png') }}" alt="Bank Jago" style="height: 30px;">
                                            Bank Jago
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle"></i> Proses Pembayaran
                                    </button>
                                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Kembali Belanja
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header" style="background-color: var(--primary-color); color: white;">
                            <h5 class="mb-0"><i class="bi bi-receipt"></i> Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div id="order-summary">
                                <!-- Will be populated by JS -->
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <strong id="summary-subtotal">Rp 0</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Biaya Admin:</span>
                                <strong>Rp 0</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total:</h5>
                                <h5 class="mb-0" style="color: var(--primary-color);" id="summary-total">Rp 0</h5>
                            </div>

                            <div class="alert alert-info mt-3">
                                <small>
                                    <i class="bi bi-info-circle"></i>
                                    Setelah checkout, Anda akan menerima instruksi pembayaran via WhatsApp
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .payment-option {
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .payment-option:hover {
            border-color: var(--secondary-color);
            background-color: #f8f9fa;
        }

        .payment-option input:checked ~ label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .payment-option input:checked {
            border-color: var(--secondary-color);
            background-color: var(--secondary-color);
        }

        .payment-option label {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0;
            width: 100%;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-name {
            flex: 1;
            font-weight: 500;
        }

        .order-item-qty {
            color: #666;
            margin-right: 1rem;
        }

        .order-item-price {
            font-weight: 600;
            color: var(--primary-color);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if cart is empty
            if (!cart || cart.items.length === 0) {
                window.location.href = '{{ route("home") }}';
                return;
            }

            // Populate order summary
            const summaryDiv = document.getElementById('order-summary');
            const subtotalEl = document.getElementById('summary-subtotal');
            const totalEl = document.getElementById('summary-total');

            let html = '';
            cart.items.forEach(item => {
                html += `
                    <div class="order-item">
                        <div class="order-item-name">${item.name}</div>
                        <div class="order-item-qty">x${item.quantity}</div>
                        <div class="order-item-price">Rp ${cart.formatPrice(item.price * item.quantity)}</div>
                    </div>
                `;
            });

            summaryDiv.innerHTML = html;

            const total = cart.getTotalPrice();
            subtotalEl.textContent = 'Rp ' + cart.formatPrice(total);
            totalEl.textContent = 'Rp ' + cart.formatPrice(total);

            // Set cart items to hidden input
            document.getElementById('cart-items-input').value = JSON.stringify(cart.items);

            // Handle form submission
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

                // Simulate processing (replace with actual AJAX call)
                setTimeout(() => {
                    // Clear cart
                    cart.clearCart();
                    
                    // Redirect to success page (you can create this later)
                    alert('Pesanan berhasil! Kami akan menghubungi Anda via WhatsApp segera.');
                    window.location.href = '{{ route("home") }}';
                }, 1500);
            });
        });
    </script>
@endsection
