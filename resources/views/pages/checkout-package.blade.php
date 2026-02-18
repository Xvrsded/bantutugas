@extends('layouts.app')

@section('title', 'Checkout - ' . $service->name)

@section('content')
    <!-- Checkout Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-5 fw-bold">Checkout Pesanan</h1>
            <p class="lead">{{ $service->name }}</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white">Checkout</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Checkout Content -->
    <section class="py-5">
        <div class="container">
            <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="package_id" id="package-id-input">
                <input type="hidden" name="selected_addons" id="selected-addons-input">

                <div class="row">
                    <!-- Left Column - Form -->
                    <div class="col-lg-7">
                        <!-- Package Selection -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Pilih Paket</h5>
                            </div>
                            <div class="card-body">
                                <div class="row" id="packages-container">
                                    @foreach($service->activePackages as $package)
                                    <div class="col-md-4 mb-3">
                                        <div class="package-card" data-package-id="{{ $package->id }}" 
                                             data-price="{{ $package->price_per_unit }}" 
                                             data-min-quantity="{{ $package->min_quantity }}">
                                            <div class="package-header {{ $loop->iteration == 2 ? 'recommended' : '' }}">
                                                @if($loop->iteration == 2)
                                                    <span class="badge bg-warning text-dark mb-2">
                                                        <i class="bi bi-star-fill"></i> PALING POPULER
                                                    </span>
                                                @endif
                                                <h6 class="package-name">{{ $package->name }}</h6>
                                                <div class="package-price">
                                                    {{ $package->formatted_price }}
                                                    <small class="d-block">per unit</small>
                                                </div>
                                            </div>
                                            <div class="package-body">
                                                <p class="small text-muted">{{ $package->description }}</p>
                                                <ul class="package-features">
                                                    @foreach($package->features ?? [] as $feature)
                                                        <li><i class="bi bi-check-circle-fill text-success"></i> {{ $feature }}</li>
                                                    @endforeach
                                                </ul>
                                                @if($package->min_quantity > 1)
                                                    <small class="text-muted">Min. order: {{ $package->min_quantity }} unit</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Input -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="bi bi-123"></i> Jumlah Unit</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jumlah Halaman/Soal/Project <span class="text-danger">*</span></label>
                                    <input type="number" name="unit_quantity" id="unit-quantity" class="form-control form-control-lg" 
                                           min="1" value="1" required>
                                    <small class="text-muted">Tentukan berapa unit yang Anda butuhkan</small>
                                </div>
                            </div>
                        </div>

                        <!-- Add-ons Selection -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambahan (Opsional)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($addons as $addon)
                                    <div class="col-md-6 mb-3">
                                        <div class="addon-card">
                                            <div class="form-check">
                                                <input class="form-check-input addon-checkbox" type="checkbox" 
                                                       value="{{ $addon->id }}"
                                                       data-addon-id="{{ $addon->id }}"
                                                       data-addon-type="{{ $addon->type }}"
                                                       data-addon-price="{{ $addon->price }}"
                                                       id="addon-{{ $addon->id }}">
                                                <label class="form-check-label w-100" for="addon-{{ $addon->id }}">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <i class="{{ $addon->icon_class }} text-primary me-2"></i>
                                                            <strong>{{ $addon->name }}</strong>
                                                            <p class="small text-muted mb-0">{{ $addon->description }}</p>
                                                        </div>
                                                        <div class="text-end">
                                                            <strong class="text-primary">{{ $addon->formatted_price }}</strong>
                                                            @if($addon->type == 'percentage')
                                                                <small class="d-block text-muted">dari subtotal</small>
                                                            @elseif($addon->type == 'per_unit')
                                                                <small class="d-block text-muted">per unit</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-person-fill"></i> Informasi Pemesan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" name="whatsapp" class="form-control" required placeholder="08123456789">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deadline <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="deadline" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Detail/Catatan Pesanan <span class="text-danger">*</span></label>
                                    <textarea name="notes" class="form-control" rows="4" required 
                                              placeholder="Jelaskan detail tugas Anda secara lengkap..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Upload File Tugas <span class="text-danger">*</span></label>
                                    <input type="file" name="attachment" id="file-input" class="form-control" required
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                                    <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG, ZIP, RAR (Max: 10MB)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle"></i> Buat Pesanan
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Right Column - Price Summary -->
                    <div class="col-lg-5">
                        <div class="card shadow-lg sticky-top" style="top: 20px;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-calculator"></i> Ringkasan Harga</h5>
                            </div>
                            <div class="card-body">
                                <!-- Package Info -->
                                <div id="selected-package-info" class="alert alert-info" style="display: none;">
                                    <strong>Paket:</strong> <span id="package-name-display">-</span><br>
                                    <strong>Harga per unit:</strong> <span id="package-price-display">-</span>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="price-breakdown">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Harga Paket:</span>
                                        <strong id="package-subtotal">Rp 0</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Jumlah Unit:</span>
                                        <strong id="quantity-display">0</strong>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal Paket:</span>
                                        <strong id="subtotal-display">Rp 0</strong>
                                    </div>
                                    
                                    <!-- Add-ons List -->
                                    <div id="addons-list" style="display: none;">
                                        <hr>
                                        <h6 class="text-success">Tambahan:</h6>
                                        <div id="addons-breakdown"></div>
                                        <hr>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Add-ons:</span>
                                            <strong class="text-success" id="addons-total">Rp 0</strong>
                                        </div>
                                    </div>

                                    <hr class="my-3" style="border-width: 2px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">TOTAL:</h5>
                                        <h4 class="mb-0 text-primary" id="grand-total">Rp 0</h4>
                                    </div>
                                </div>

                                <!-- Min Order Warning -->
                                <div id="min-order-warning" class="alert alert-warning mt-3" style="display: none;">
                                    <small><i class="bi bi-exclamation-triangle"></i> <span id="min-order-text"></span></small>
                                </div>

                                <!-- Price Adjustment Clause -->
                                <div class="alert alert-light mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle"></i> <strong>Catatan:</strong> 
                                        Harga dapat disesuaikan setelah kami review file tugas Anda. 
                                        Kami akan konfirmasi via WhatsApp sebelum pengerjaan dimulai.
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
        .package-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
        }

        .package-card:hover {
            border-color: var(--secondary-color);
            box-shadow: 0 4px 12px rgba(0,102,204,0.15);
            transform: translateY(-2px);
        }

        .package-card.selected {
            border-color: var(--secondary-color);
            background: linear-gradient(135deg, #f8f9ff 0%, #e6f2ff 100%);
            box-shadow: 0 6px 20px rgba(0,102,204,0.2);
        }

        .package-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            text-align: center;
        }

        .package-card.selected .package-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%);
            color: white;
        }

        .package-header.recommended {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
        }

        .package-name {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .package-price {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .package-price small {
            font-size: 0.8rem;
            font-weight: 400;
        }

        .package-body {
            padding: 1.5rem;
        }

        .package-features {
            list-style: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .package-features li {
            padding: 0.4rem 0;
            font-size: 0.9rem;
        }

        .package-features i {
            margin-right: 0.5rem;
        }

        .addon-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.2s ease;
        }

        .addon-card:has(.addon-checkbox:checked) {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-color: #4caf50;
        }

        .price-breakdown {
            font-size: 1rem;
        }

        .sticky-top {
            z-index: 100;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-top: 0.5rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedPackage = null;
            let quantity = 1;
            let selectedAddons = [];

            // Package Selection
            document.querySelectorAll('.package-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remove selected class from all
                    document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
                    
                    // Add selected class
                    this.classList.add('selected');
                    
                    // Update selected package
                    selectedPackage = {
                        id: this.dataset.packageId,
                        price: parseFloat(this.dataset.price),
                        minQuantity: parseInt(this.dataset.minQuantity),
                        name: this.querySelector('.package-name').textContent
                    };
                    
                    document.getElementById('package-id-input').value = selectedPackage.id;
                    updatePrice();
                });
            });

            // Quantity Change
            document.getElementById('unit-quantity').addEventListener('input', function() {
                quantity = parseInt(this.value) || 1;
                updatePrice();
            });

            // Add-on Selection
            document.querySelectorAll('.addon-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectedAddons.push({
                            id: this.dataset.addonId,
                            type: this.dataset.addonType,
                            price: parseFloat(this.dataset.addonPrice),
                            name: this.closest('.addon-card').querySelector('strong').textContent
                        });
                    } else {
                        selectedAddons = selectedAddons.filter(a => a.id !== this.dataset.addonId);
                    }
                    updatePrice();
                });
            });

            function updatePrice() {
                if (!selectedPackage) {
                    document.getElementById('selected-package-info').style.display = 'none';
                    resetPriceDisplay();
                    return;
                }

                // Show package info
                document.getElementById('selected-package-info').style.display = 'block';
                document.getElementById('package-name-display').textContent = selectedPackage.name;
                document.getElementById('package-price-display').textContent = formatRupiah(selectedPackage.price);

                // Check minimum quantity
                const effectiveQuantity = Math.max(quantity, selectedPackage.minQuantity);
                if (quantity < selectedPackage.minQuantity) {
                    document.getElementById('min-order-warning').style.display = 'block';
                    document.getElementById('min-order-text').textContent = 
                        `Minimum order untuk paket ini adalah ${selectedPackage.minQuantity} unit`;
                    document.getElementById('unit-quantity').value = selectedPackage.minQuantity;
                    quantity = selectedPackage.minQuantity;
                } else {
                    document.getElementById('min-order-warning').style.display = 'none';
                }

                // Calculate package subtotal
                const packageSubtotal = selectedPackage.price * effectiveQuantity;
                
                // Update package display
                document.getElementById('package-subtotal').textContent = formatRupiah(selectedPackage.price);
                document.getElementById('quantity-display').textContent = effectiveQuantity + ' unit';
                document.getElementById('subtotal-display').textContent = formatRupiah(packageSubtotal);

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
                            addonPrice = addon.price * effectiveQuantity;
                            break;
                    }
                    
                    addonsTotal += addonPrice;
                    addonsHtml += `
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>+ ${addon.name}</span>
                            <span>${formatRupiah(addonPrice)}</span>
                        </div>
                    `;
                });

                // Show/hide add-ons section
                if (selectedAddons.length > 0) {
                    document.getElementById('addons-list').style.display = 'block';
                    document.getElementById('addons-breakdown').innerHTML = addonsHtml;
                    document.getElementById('addons-total').textContent = formatRupiah(addonsTotal);
                } else {
                    document.getElementById('addons-list').style.display = 'none';
                }

                // Calculate grand total
                const grandTotal = packageSubtotal + addonsTotal;
                document.getElementById('grand-total').textContent = formatRupiah(grandTotal);

                // Update hidden input for add-ons
                document.getElementById('selected-addons-input').value = JSON.stringify(
                    selectedAddons.map(a => ({id: a.id, price: calculateAddonPrice(a, packageSubtotal, effectiveQuantity)}))
                );
            }

            function calculateAddonPrice(addon, subtotal, qty) {
                switch(addon.type) {
                    case 'percentage':
                        return (subtotal * addon.price) / 100;
                    case 'fixed':
                        return addon.price;
                    case 'per_unit':
                        return addon.price * qty;
                    default:
                        return 0;
                }
            }

            function resetPriceDisplay() {
                document.getElementById('package-subtotal').textContent = 'Rp 0';
                document.getElementById('quantity-display').textContent = '0';
                document.getElementById('subtotal-display').textContent = 'Rp 0';
                document.getElementById('addons-list').style.display = 'none';
                document.getElementById('grand-total').textContent = 'Rp 0';
            }

            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(number));
            }

            // Form submission validation
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                if (!selectedPackage) {
                    e.preventDefault();
                    alert('Silakan pilih paket terlebih dahulu!');
                    return false;
                }

                const fileInput = document.getElementById('file-input');
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Mohon upload file tugas terlebih dahulu!');
                    return false;
                }
            });
        });
    </script>
@endsection
