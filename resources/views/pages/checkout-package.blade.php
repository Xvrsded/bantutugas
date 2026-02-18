@extends('layouts.app')

@section('title', 'Checkout - ' . $service->name)

@section('content')
    <!-- Checkout Header -->
    <section style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">Checkout Pesanan</h1>
            <p class="lead mb-0"><i class="bi bi-check-circle"></i> {{ $service->name }}</p>
        </div>
    </section>

    <!-- Checkout Content -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="package_id" id="package-id-input">
                <input type="hidden" name="selected_addons" id="selected-addons-input">

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- PRICING PLANS -->
                        <div class="mb-5">
                            <h2 class="h3 fw-bold mb-2">Pilih Paket Anda</h2>
                            <p class="text-muted mb-4">Bandingkan fitur untuk menemukan paket terbaik</p>

                            <div class="row g-4" id="pricing-plans">
                                @foreach($service->activePackages as $package)
                                <div class="col-lg-4">
                                    <div class="pricing-card {{ $loop->iteration == 2 ? 'pricing-featured' : '' }}" 
                                         data-package-id="{{ $package->id }}" 
                                         data-price="{{ $package->price_per_unit }}" 
                                         data-min-qty="{{ $package->min_quantity }}">
                                        
                                        @if($loop->iteration == 2)
                                        <div class="pricing-badge">
                                            <span><i class="bi bi-star-fill"></i> PALING POPULER</span>
                                        </div>
                                        @endif

                                        <div class="pricing-header">
                                            <h3 class="plan-name">{{ $package->name }}</h3>
                                            <div class="price-box">
                                                <span class="currency">Rp</span>
                                                <span class="amount">{{ number_format($package->price_per_unit, 0, ',', '.') }}</span>
                                                <span class="unit">/unit</span>
                                            </div>
                                            <p class="plan-desc">{{ $package->description }}</p>
                                        </div>

                                        <div class="pricing-features">
                                            <h6 class="features-label mb-3">Keuntungan:</h6>
                                            <ul>
                                                @foreach($package->features ?? [] as $feature)
                                                    <li><i class="bi bi-check-circle-fill"></i> {{ $feature }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @if($package->min_quantity > 1)
                                        <div class="min-info">
                                            <i class="bi bi-info-circle"></i>
                                            <small>Min. {{ $package->min_quantity }} unit</small>
                                        </div>
                                        @endif

                                        <button type="button" class="btn-select-plan" data-package-id="{{ $package->id }}">
                                            <span>Pilih Paket Ini</span>
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- QUANTITY -->
                        <div class="card shadow-sm mb-4" style="border: none; border-radius: 12px;">
                            <div class="card-body p-4">
                                <label class="fw-bold mb-3"><i class="bi bi-calculator"></i> Berapa banyak yang Anda butuhkan?</label>
                                <div class="qty-group">
                                    <button type="button" class="qty-btn" id="qty-minus">−</button>
                                    <input type="number" name="unit_quantity" id="unit-quantity" class="qty-input" min="1" value="1" required>
                                    <button type="button" class="qty-btn" id="qty-plus">+</button>
                                </div>
                                <small class="text-muted d-block mt-2" id="qty-helper">Pilih paket terlebih dahulu</small>
                            </div>
                        </div>

                        <!-- ADD-ONS -->
                        <div class="card shadow-sm mb-4" style="border: none; border-radius: 12px;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4"><i class="bi bi-gift"></i> Tambahan Layanan (Opsional)</h5>
                                <div class="row">
                                    @foreach($addons as $addon)
                                    <div class="col-md-6 mb-3">
                                        <div class="addon-item">
                                            <input class="addon-checkbox" type="checkbox" id="addon-{{ $addon->id }}" 
                                                   data-addon-id="{{ $addon->id }}"
                                                   data-addon-name="{{ $addon->name }}"
                                                   data-addon-type="{{ $addon->type }}"
                                                   data-addon-price="{{ $addon->price }}">
                                            <label for="addon-{{ $addon->id }}">
                                                <div class="addon-name">
                                                    <span>{{ $addon->name }}</span>
                                                    <span class="addon-price">
                                                        @if($addon->type === 'percentage')
                                                            +{{ $addon->price }}%
                                                        @elseif($addon->type === 'fixed')
                                                            +Rp {{ number_format($addon->price, 0, ',', '.') }}
                                                        @else
                                                            Rp {{ number_format($addon->price, 0, ',', '.') }}/unit
                                                        @endif
                                                    </span>
                                                </div>
                                                <small>{{ $addon->description }}</small>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- CUSTOMER INFO -->
                        <div class="card shadow-sm mb-4" style="border: none; border-radius: 12px;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4"><i class="bi bi-person-circle"></i> Informasi Anda</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">WhatsApp <span class="text-danger">*</span></label>
                                        <input type="tel" name="whatsapp" class="form-control form-control-lg" placeholder="08xx xxxx xxxx" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Deadline <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="deadline" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Detail Pesanan <span class="text-danger">*</span></label>
                                        <textarea name="notes" class="form-control" rows="4" required placeholder="Jelaskan detail tugas Anda..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Upload File <span class="text-danger">*</span></label>
                                        <div class="file-upload">
                                            <input type="file" name="attachment" id="file-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar" required>
                                            <label for="file-input">
                                                <i class="bi bi-cloud-upload"></i>
                                                <span>Klik untuk upload atau drag & drop</span>
                                                <small>Max 10MB • PDF, DOC, JPG, PNG, ZIP</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DISCLAIMER -->
                        <div class="alert alert-warning" role="alert">
                            <h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Perhatian</h6>
                            <p class="small mb-0">
                                Harga adalah estimasi. <strong>Setelah review file, harga mungkin disesuaikan.</strong> 
                                Kami akan konfirmasi via WhatsApp <strong>sebelum mulai bekerja.</strong>
                            </p>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-btn" disabled>
                                <i class="bi bi-check-circle"></i> Proses Pesanan
                            </button>
                        </div>
                    </div>

                    <!-- Right Column - STICKY SUMMARY -->
                    <div class="col-lg-4">
                        <div class="sticky-summary">
                            <div class="card shadow-lg" style="border: none; border-radius: 12px;">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>

                                    <div class="summary-section mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="label">Paket:</span>
                                            <strong id="summary-package">-</strong>
                                        </div>
                                        <small class="text-muted" id="summary-details">Pilih paket terlebih dahulu</small>
                                    </div>

                                    <hr>

                                    <div class="breakdown">
                                        <div class="breakdown-item">
                                            <span>Harga Paket:</span>
                                            <span class="fw-bold" id="breakdown-package">Rp 0</span>
                                        </div>
                                        <div class="breakdown-item" id="breakdown-qty-item" style="display: none;">
                                            <span><span id="qty-label">0</span> × Unit</span>
                                            <span class="fw-bold" id="breakdown-calc">Rp 0</span>
                                        </div>
                                    </div>

                                    <div id="addons-breakdown" style="display: none;">
                                        <hr>
                                        <h6 class="text-success mb-3">Tambahan Layanan:</h6>
                                        <div id="addons-items"></div>
                                        <div class="breakdown-item">
                                            <span>Total Add-ons:</span>
                                            <span class="fw-bold text-success" id="addons-sum">Rp 0</span>
                                        </div>
                                    </div>

                                    <hr class="my-3" style="border-width: 2px;">

                                    <div class="grand-total">
                                        <div class="d-flex justify-content-between">
                                            <span class="label">Total:</span>
                                            <span class="amount" id="grand-total">Rp 0</span>
                                        </div>
                                    </div>

                                    <small class="text-muted d-block mt-3 text-center">
                                        <i class="bi bi-auto-reboot"></i> Update otomatis
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <style>
        :root {
            --primary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --gray-light: #f8f9fa;
            --gray-medium: #e9ecef;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        /* PRICING CARDS */
        .pricing-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            padding: 0;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .pricing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pricing-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(52, 152, 219, 0.15);
        }

        .pricing-card:hover::before {
            opacity: 1;
        }

        .pricing-card.selected {
            border-color: var(--primary-color);
            border-width: 3px;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.02) 0%, rgba(52, 152, 219, 0.05) 100%);
            box-shadow: 0 12px 28px rgba(52, 152, 219, 0.2), inset 0 1px 0 rgba(52, 152, 219, 0.1);
        }

        .pricing-badge {
            position: absolute;
            top: -1px;
            right: -1px;
            background: linear-gradient(135deg, var(--warning-color) 0%, #e67e22 100%);
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 0 var(--border-radius) 0 12px;
            box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
        }

        .pricing-badge span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .pricing-featured {
            border-color: var(--primary-color) !important;
            border-width: 2px;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.04) 0%, rgba(52, 152, 219, 0.08) 100%);
            transform: scale(1.02);
        }

        .pricing-featured:hover {
            transform: translateY(-8px) scale(1.02);
        }

        .pricing-header {
            padding: 2rem 1.5rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            flex-grow: 0;
        }

        .pricing-featured .pricing-header {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.08) 0%, rgba(52, 152, 219, 0.04) 100%);
        }

        .plan-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0 0 1rem 0;
        }

        .price-box {
            margin-bottom: 0.8rem;
        }

        .price-box .currency {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        .price-box .amount {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            line-height: 1.2;
        }

        .price-box .unit {
            font-size: 0.85rem;
            color: #999;
            font-weight: 500;
        }

        .plan-desc {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        .pricing-features {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .features-label {
            font-size: 0.9rem;
            color: var(--dark-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .pricing-features ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pricing-features li {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.7rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .pricing-features li:last-child {
            margin-bottom: 0;
        }

        .pricing-features i {
            color: var(--success-color);
            font-size: 0.8rem;
            margin-top: 0.2rem;
            flex-shrink: 0;
        }

        .min-info {
            padding: 0.75rem 1.5rem;
            background: #f0f8ff;
            border-top: 1px solid #e0e0e0;
            font-size: 0.85rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .min-info i {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .btn-select-plan {
            width: 100%;
            padding: 1rem 1.5rem;
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .pricing-card.selected .btn-select-plan {
            background: var(--primary-color);
            color: white;
        }

        .btn-select-plan:hover {
            background: var(--primary-color);
            color: white;
            transform: none;
        }

        /* QUANTITY GROUP */
        .qty-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            max-width: 200px;
        }

        .qty-btn {
            width: 44px;
            height: 44px;
            border: 2px solid var(--primary-color);
            background: white;
            color: var(--primary-color);
            border-radius: 6px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .qty-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .qty-input {
            width: 80px;
            height: 44px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            border: 2px solid var(--primary-color);
            border-radius: 6px;
            padding: 0;
        }

        .qty-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        /* ADD-ON ITEMS */
        .addon-item {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            transition: var(--transition);
        }

        .addon-item:hover {
            border-color: var(--primary-color);
            background: #f8fcff;
        }

        .addon-checkbox {
            cursor: pointer;
            accent-color: var(--primary-color);
        }

        .addon-item label {
            cursor: pointer;
            margin-bottom: 0;
        }

        .addon-name {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 0.3rem;
        }

        .addon-name span:first-child {
            font-weight: 600;
            color: var(--dark-color);
        }

        .addon-price {
            font-weight: 700;
            color: var(--primary-color);
            white-space: nowrap;
        }

        .addon-item small {
            color: #999;
            display: block;
        }

        /* FILE UPLOAD */
        .file-upload {
            position: relative;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed var(--primary-color);
            border-radius: 8px;
            cursor: pointer;
            background: #f8fcff;
            transition: var(--transition);
            text-align: center;
        }

        .file-upload input[type="file"]:hover + label,
        .file-upload label:hover {
            background: #e8f5ff;
            border-color: var(--accent-color);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .file-upload span {
            display: block;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.3rem;
        }

        .file-upload small {
            color: #999;
        }

        /* STICKY SUMMARY */
        .sticky-summary {
            position: sticky;
            top: 20px;
        }

        .summary-section {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .summary-section .label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .summary-section strong {
            color: var(--dark-color);
            font-weight: 600;
        }

        .breakdown {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            font-size: 0.95rem;
            color: #555;
        }

        .breakdown-item:first-child {
            padding-top: 0;
        }

        .breakdown-item .fw-bold {
            color: var(--dark-color);
        }

        .grand-total {
            padding: 1rem;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(52, 152, 219, 0.05) 100%);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }

        .grand-total .label {
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
        }

        .grand-total .amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* FORM STYLING */
        .form-control,
        .form-control-lg {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-control-lg:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-label {
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2980b9 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(52, 152, 219, 0.3);
            color: white;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sticky-summary {
                position: static;
                margin-top: 2rem;
            }

            .pricing-featured {
                transform: scale(1);
            }

            .pricing-featured:hover {
                transform: translateY(-8px);
            }

            .price-box .amount {
                font-size: 1.8rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedPackage = null;
            let selectedAddons = [];

            // Format Rupiah Helper
            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(number));
            }

            // PRICING CARD SELECTION
            document.querySelectorAll('.btn-select-plan').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const card = this.closest('.pricing-card');
                    const packageId = this.dataset.packageId;
                    const packageName = card.querySelector('.plan-name').textContent;
                    const packagePrice = parseFloat(card.dataset.price);
                    const minQty = parseInt(card.dataset.minQty);

                    // Remove selected class from all cards
                    document.querySelectorAll('.pricing-card').forEach(c => {
                        c.classList.remove('selected');
                    });

                    // Add selected to current
                    card.classList.add('selected');

                    // Update selected package
                    selectedPackage = {
                        id: packageId,
                        name: packageName,
                        price: packagePrice,
                        minQty: minQty
                    };

                    // Update hidden input
                    document.getElementById('package-id-input').value = packageId;

                    // Update quantity controls
                    const qtyInput = document.getElementById('unit-quantity');
                    qtyInput.min = minQty;
                    qtyInput.value = Math.max(1, minQty);

                    // Enable quantity and submit button
                    document.getElementById('qty-plus').disabled = false;
                    document.getElementById('qty-minus').disabled = false;
                    qtyInput.disabled = false;
                    document.getElementById('submit-btn').disabled = false;

                    // Update helper text
                    document.getElementById('qty-helper').textContent = 
                        `Min. ${minQty} unit untuk paket ini`;

                    // Update summary
                    updateSummary();
                });
            });

            // QUANTITY CONTROLS
            document.getElementById('qty-plus').addEventListener('click', function() {
                const input = document.getElementById('unit-quantity');
                input.value = parseInt(input.value) + 1;
                updateSummary();
            });

            document.getElementById('qty-minus').addEventListener('click', function() {
                const input = document.getElementById('unit-quantity');
                const currentValue = parseInt(input.value);
                if (currentValue > (selectedPackage?.minQty || 1)) {
                    input.value = currentValue - 1;
                    updateSummary();
                }
            });

            document.getElementById('unit-quantity').addEventListener('change', function() {
                const minQty = selectedPackage?.minQty || 1;
                if (parseInt(this.value) < minQty) {
                    this.value = minQty;
                }
                updateSummary();
            });

            // ADD-ON SELECTION
            document.querySelectorAll('.addon-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const addonId = this.dataset.addonId;
                    const addonName = this.dataset.addonName;
                    const addonType = this.dataset.addonType;
                    const addonPrice = parseFloat(this.dataset.addonPrice);

                    if (this.checked) {
                        selectedAddons.push({
                            id: addonId,
                            name: addonName,
                            type: addonType,
                            price: addonPrice
                        });
                    } else {
                        selectedAddons = selectedAddons.filter(a => a.id !== addonId);
                    }

                    updateSummary();
                });
            });

            // UPDATE SUMMARY AND CALCULATIONS
            function updateSummary() {
                if (!selectedPackage) {
                    document.getElementById('submit-btn').disabled = true;
                    document.getElementById('summary-package').textContent = '-';
                    document.getElementById('summary-details').textContent = 'Pilih paket terlebih dahulu';
                    document.getElementById('breakdown-package').textContent = 'Rp 0';
                    document.getElementById('breakdown-qty-item').style.display = 'none';
                    document.getElementById('addons-breakdown').style.display = 'none';
                    document.getElementById('grand-total').textContent = 'Rp 0';
                    return;
                }

                const quantity = parseInt(document.getElementById('unit-quantity').value);
                const packagePrice = selectedPackage.price;

                // Update package info in summary
                document.getElementById('summary-package').textContent = selectedPackage.name;
                document.getElementById('summary-details').textContent = 
                    `${quantity} unit × ${formatRupiah(packagePrice)}`;

                // Calculate package subtotal
                const packageSubtotal = packagePrice * quantity;

                // Update breakdown
                document.getElementById('breakdown-package').textContent = formatRupiah(packagePrice);
                document.getElementById('qty-label').textContent = quantity;
                document.getElementById('breakdown-calc').textContent = formatRupiah(packageSubtotal);
                document.getElementById('breakdown-qty-item').style.display = 'flex';

                // Calculate add-ons
                let addonsTotal = 0;
                let addonsHtml = '';

                selectedAddons.forEach(addon => {
                    let addonPrice = 0;

                    switch(addon.type) {
                        case 'percentage':
                            addonPrice = (packageSubtotal * addon.price) / 100;
                            break;
                        case 'fixed':
                            addonPrice = addon.price;
                            break;
                        case 'per_unit':
                            addonPrice = addon.price * quantity;
                            break;
                    }

                    addonsTotal += addonPrice;
                    addonsHtml += `
                        <div class="breakdown-item small">
                            <span>+ ${addon.name}</span>
                            <span class="fw-bold text-success">${formatRupiah(addonPrice)}</span>
                        </div>
                    `;
                });

                // Show/hide add-ons breakdown
                if (selectedAddons.length > 0) {
                    document.getElementById('addons-breakdown').style.display = 'block';
                    document.getElementById('addons-items').innerHTML = addonsHtml;
                    document.getElementById('addons-sum').textContent = formatRupiah(addonsTotal);
                } else {
                    document.getElementById('addons-breakdown').style.display = 'none';
                }

                // Calculate grand total
                const grandTotal = packageSubtotal + addonsTotal;
                document.getElementById('grand-total').textContent = formatRupiah(grandTotal);

                // Update hidden input for add-ons
                const addonsWithCalculatedPrice = selectedAddons.map(a => {
                    let price = 0;
                    switch(a.type) {
                        case 'percentage':
                            price = (packageSubtotal * a.price) / 100;
                            break;
                        case 'fixed':
                            price = a.price;
                            break;
                        case 'per_unit':
                            price = a.price * quantity;
                            break;
                    }
                    return { id: a.id, name: a.name, price: price };
                });

                document.getElementById('selected-addons-input').value = JSON.stringify(addonsWithCalculatedPrice);
            }

            // FORM SUBMISSION
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                if (!selectedPackage) {
                    e.preventDefault();
                    alert('Silakan pilih paket terlebih dahulu!');
                    return false;
                }

                const fileInput = document.getElementById('file-input');
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Mohon upload file tugas terlebih dahulu!');
                    return false;
                }

                // Optional: validate file size (max 10MB)
                const maxSize = 10 * 1024 * 1024;
                if (fileInput.files[0].size > maxSize) {
                    e.preventDefault();
                    alert('Ukuran file maksimal 10MB!');
                    return false;
                }
            });

            // Initialize - disable controls until package is selected
            document.getElementById('qty-plus').disabled = true;
            document.getElementById('qty-minus').disabled = true;
            document.getElementById('unit-quantity').disabled = true;
            document.getElementById('submit-btn').disabled = true;
        });
    </script>
@endsection
