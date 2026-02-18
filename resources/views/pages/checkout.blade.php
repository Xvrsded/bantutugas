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

                            <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
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
                                    <label class="form-label fw-bold">Detail/Catatan Pesanan <span class="text-danger">*</span></label>
                                    <textarea name="notes" class="form-control" rows="4" required placeholder="Jelaskan detail tugas Anda secara lengkap...&#10;Contoh: Tugas Kalkulus 2 tentang integral, 10 soal, deadline 3 hari lagi"></textarea>
                                </div>

                                <!-- Parameter Kalkulasi Harga Otomatis -->
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading"><i class="bi bi-calculator me-2"></i>Parameter Kalkulasi Harga</h6>
                                    <p class="mb-0 small">Isi parameter di bawah untuk mendapatkan estimasi harga otomatis</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Soal/Tugas <span class="text-danger">*</span></label>
                                    <select name="question_type" id="question-type" class="form-select" required>
                                        <option value="">Pilih jenis...</option>
                                        <option value="multiple_choice">Pilihan Ganda (Multiple Choice)</option>
                                        <option value="essay">Esai / Uraian</option>
                                        <option value="calculation">Hitungan / Matematika</option>
                                        <option value="project">Project / Tugas Besar</option>
                                        <option value="coding">Coding / Pemrograman</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="subject" class="form-control" required placeholder="Contoh: Matematika, Fisika, Pemrograman">
                                    <small class="text-muted">Tulis mata pelajaran atau topik tugas</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jumlah Soal/Halaman <span class="text-danger">*</span></label>
                                    <input type="number" name="question_count" id="question-count" class="form-control" required min="1" placeholder="Contoh: 10">
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="needs_explanation" id="needs-explanation" value="1">
                                        <label class="form-check-label fw-bold" for="needs-explanation">
                                            Butuh Penjelasan Detail
                                        </label>
                                    </div>
                                    <small class="text-muted">Centang jika membutuhkan langkah-langkah penyelesaian lengkap</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deadline <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="deadline" id="deadline" class="form-control" required>
                                    <small class="text-muted">Kapan tugas harus selesai?</small>
                                </div>

                                <!-- Preview Harga Otomatis -->
                                <div id="price-preview" class="card border-primary mb-4" style="display: none;">
                                    <div class="card-body">
                                        <h6 class="text-primary"><i class="bi bi-cash-stack me-2"></i>Estimasi Harga Otomatis</h6>
                                        <div class="row text-center g-3">
                                            <div class="col-6">
                                                <small class="text-muted">Tingkat Kesulitan</small>
                                                <div class="fw-bold" id="difficulty-badge"></div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Skor Kesulitan</small>
                                                <div class="fw-bold" id="difficulty-score">0</div>
                                            </div>
                                            <div class="col-12">
                                                <hr class="my-2">
                                                <h4 class="text-primary mb-0" id="price-display">Rp 0</h4>
                                                <small class="text-muted">Harga per unit: <span id="price-per-unit">Rp 0</span></small>
                                            </div>
                                        </div>
                                        <small class="text-muted d-block mt-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Harga dapat disesuaikan setelah review file tugas
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Upload File Tugas <span class="text-danger">*</span></label>
                                    <input type="file" name="attachment" class="form-control" id="file-input" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                                    <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG, ZIP, RAR (Max: 10MB)</small>
                                    <div id="file-info" class="mt-2" style="display: none;">
                                        <div class="alert alert-success d-flex align-items-center mb-0">
                                            <i class="bi bi-file-earmark-check me-2"></i>
                                            <span id="file-name"></span>
                                            <button type="button" class="btn-close ms-auto" onclick="clearFile()"></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Proses Selanjutnya:</h6>
                                    <ol class="mb-0 ps-3">
                                        <li>Sistem menghitung harga otomatis berdasarkan parameter</li>
                                        <li>Anda kirim detail + file tugas</li>
                                        <li>Kami review file (jika diperlukan adjustment harga)</li>
                                        <li>Kami hubungi via WhatsApp untuk konfirmasi</li>
                                        <li>Anda setuju? Lakukan pembayaran</li>
                                        <li>Pengerjaan dimulai!</li>
                                    </ol>
                                    <small class="text-muted"><em>Harga otomatis sangat akurat. Adjustment hanya jika file berbeda dari parameter.</em></small>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-send"></i> Kirim Pesanan
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
                                <span>Harga Kalkulasi Otomatis:</span>
                                <strong id="summary-subtotal" style="color: var(--primary-color);">Rp 0</strong>
                            </div>
                            <hr>
                            <div class="alert alert-success mb-0">
                                <small>
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>Harga Dihitung Otomatis!</strong><br>
                                    Sistem menghitung berdasarkan parameter objektif. Hanya disesuaikan jika file tidak sesuai deskripsi.
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
        // File upload handling
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file-input');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Check file size (10MB)
                        if (file.size > 10 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar! Maksimal 10MB');
                            e.target.value = '';
                            return;
                        }
                        
                        document.getElementById('file-name').textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                        document.getElementById('file-info').style.display = 'block';
                    }
                });
            }
        });

        function clearFile() {
            document.getElementById('file-input').value = '';
            document.getElementById('file-info').style.display = 'none';
        }

        // Wait for cart to be fully loaded
        function initCheckout() {
            // Get cart from localStorage directly
            const cartData = localStorage.getItem('bantutugas_cart');
            
            if (!cartData) {
                alert('Keranjang Anda kosong! Silakan pilih layanan terlebih dahulu.');
                window.location.href = '{{ route("home") }}';
                return;
            }

            const items = JSON.parse(cartData);
            
            if (!items || items.length === 0) {
                alert('Keranjang Anda kosong! Silakan pilih layanan terlebih dahulu.');
                window.location.href = '{{ route("home") }}';
                return;
            }

            // Populate order summary
            const summaryDiv = document.getElementById('order-summary');
            const subtotalEl = document.getElementById('summary-subtotal');

            let html = '';
            let total = 0;

            items.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                html += `
                    <div class="order-item">
                        <div class="order-item-name">${item.name}</div>
                        <div class="order-item-qty">x${item.quantity}</div>
                        <div class="order-item-price">Rp ${new Intl.NumberFormat('id-ID').format(itemTotal)}</div>
                    </div>
                `;
            });

            summaryDiv.innerHTML = html;
            subtotalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);

            // Set cart items to hidden input
            document.getElementById('cart-items-input').value = JSON.stringify(items);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize checkout
            initCheckout();

            // Real-time price calculation
            const priceCalculator = {
                basePrices: {
                    'multiple_choice': 5000,
                    'essay': 15000,
                    'calculation': 12000,
                    'project': 50000,
                    'coding': 75000
                },
                
                weights: {
                    questionType: {
                        'multiple_choice': 10,
                        'essay': 30,
                        'calculation': 25,
                        'project': 50,
                        'coding': 60
                    },
                    subjectComplexity: {
                        'low': 5,
                        'medium': 15,
                        'high': 25
                    },
                    quantity: {
                        '1-5': 5,
                        '6-10': 10,
                        '11-20': 15,
                        '21+': 20
                    },
                    explanation: {
                        'no': 0,
                        'yes': 15
                    },
                    deadline: {
                        'relaxed': 0,
                        'normal': 10,
                        'urgent': 25,
                        'very_urgent': 40
                    }
                },
                
                multipliers: {
                    'easy': 1.0,
                    'medium': 1.5,
                    'hard': 2.2
                },

                getSubjectComplexity(subject) {
                    const subjectLower = subject.toLowerCase();
                    const high = ['kalkulus', 'statistika', 'pemrograman', 'coding', 'algoritma', 'fisika kuantum', 'kimia organik'];
                    const medium = ['fisika', 'kimia', 'matematika sma', 'akuntansi', 'ekonomi', 'biologi'];
                    
                    for (let keyword of high) {
                        if (subjectLower.includes(keyword)) return 'high';
                    }
                    for (let keyword of medium) {
                        if (subjectLower.includes(keyword)) return 'medium';
                    }
                    return 'low';
                },

                getQuantityRange(count) {
                    if (count >= 21) return '21+';
                    if (count >= 11) return '11-20';
                    if (count >= 6) return '6-10';
                    return '1-5';
                },

                getDeadlineUrgency(hours) {
                    if (hours < 24) return 'very_urgent';
                    if (hours <= 48) return 'urgent';
                    if (hours <= 168) return 'normal';
                    return 'relaxed';
                },

                getDifficultyLevel(score) {
                    if (score >= 67) return 'hard';
                    if (score >= 34) return 'medium';
                    return 'easy';
                },

                calculate(questionType, subject, questionCount, needsExplanation, deadlineHours) {
                    let score = 0;

                    // Score dari jenis soal
                    score += this.weights.questionType[questionType] || 0;

                    // Score dari kompleksitas pelajaran
                    const complexity = this.getSubjectComplexity(subject);
                    score += this.weights.subjectComplexity[complexity];

                    // Score dari jumlah
                    const qtyRange = this.getQuantityRange(questionCount);
                    score += this.weights.quantity[qtyRange];

                    // Score dari penjelasan
                    score += needsExplanation ? this.weights.explanation.yes : this.weights.explanation.no;

                    // Score dari deadline
                    const urgency = this.getDeadlineUrgency(deadlineHours);
                    score += this.weights.deadline[urgency];

                    // Pastikan max 100
                    score = Math.min(score, 100);

                    // Tentukan level
                    const level = this.getDifficultyLevel(score);

                    // Hitung harga
                    const basePrice = this.basePrices[questionType] || 10000;
                    const multiplier = this.multipliers[level];
                    const pricePerUnit = basePrice * multiplier;
                    const totalPrice = pricePerUnit * questionCount;
                    
                    // Bulatkan ke ribuan
                    const finalPrice = Math.ceil(totalPrice / 1000) * 1000;
                    const roundedPricePerUnit = Math.ceil(pricePerUnit / 1000) * 1000;

                    return {
                        score: score,
                        level: level,
                        basePrice: basePrice,
                        multiplier: multiplier,
                        pricePerUnit: roundedPricePerUnit,
                        finalPrice: finalPrice
                    };
                }
            };

            // Update price display
            function updatePriceDisplay() {
                const questionType = document.getElementById('question-type').value;
                const subject = document.getElementById('subject').value;
                const questionCount = parseInt(document.getElementById('question-count').value) || 0;
                const needsExplanation = document.getElementById('needs-explanation').checked;
                const deadlineInput = document.getElementById('deadline').value;

                // Cek apakah semua field terisi
                if (!questionType || !subject || questionCount === 0 || !deadlineInput) {
                    document.getElementById('price-preview').style.display = 'none';
                    return;
                }

                // Hitung deadline hours
                const deadlineDate = new Date(deadlineInput);
                const now = new Date();
                const deadlineHours = Math.max(0, (deadlineDate - now) / (1000 * 60 * 60));

                // Kalkulasi harga
                const result = priceCalculator.calculate(questionType, subject, questionCount, needsExplanation, deadlineHours);

                // Update display
                document.getElementById('price-preview').style.display = 'block';
                document.getElementById('difficulty-score').textContent = result.score + '/100';
                
                const badgeColors = {
                    'easy': 'success',
                    'medium': 'warning',
                    'hard': 'danger'
                };
                const badgeText = {
                    'easy': 'Mudah',
                    'medium': 'Sedang',
                    'hard': 'Sulit'
                };
                
                document.getElementById('difficulty-badge').innerHTML = 
                    `<span class="badge bg-${badgeColors[result.level]}">${badgeText[result.level]}</span>`;
                
                document.getElementById('price-display').textContent = 
                    'Rp ' + new Intl.NumberFormat('id-ID').format(result.finalPrice);
                
                document.getElementById('price-per-unit').textContent = 
                    'Rp ' + new Intl.NumberFormat('id-ID').format(result.pricePerUnit);
                
                // Update sidebar summary with calculated price
                document.getElementById('summary-subtotal').textContent = 
                    'Rp ' + new Intl.NumberFormat('id-ID').format(result.finalPrice);
            }

            // Add event listeners for real-time calculation
            ['question-type', 'subject', 'question-count', 'needs-explanation', 'deadline'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('change', updatePriceDisplay);
                    element.addEventListener('input', updatePriceDisplay);
                }
            });

            // Handle form submission
            document.getElementById('checkout-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate file upload
                const fileInput = document.getElementById('file-input');
                if (!fileInput.files.length) {
                    alert('Mohon upload file tugas terlebih dahulu!');
                    fileInput.focus();
                    return;
                }
                
                const formData = new FormData(this);
                
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

                // Submit via AJAX
                fetch('{{ route("checkout.process") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear cart from localStorage
                        localStorage.removeItem('bantutugas_cart');
                        
                        // Show success message
                        alert('✅ Pesanan Berhasil Dikirim!\n\n' +
                              'Kami sudah terima:\n' +
                              '✓ Data Anda\n' +
                              '✓ Detail tugas\n' +
                              '✓ File tugas\n\n' +
                              'Selanjutnya:\n' +
                              '1. Kami review file (maks 2 jam)\n' +
                              '2. Tentukan harga PASTI\n' +
                              '3. Hubungi WhatsApp Anda\n' +
                              '4. Anda setuju? Bayar & selesai!\n\n' +
                              'Terima kasih! 😊');
                        
                        // Redirect to home
                        window.location.href = '{{ route("home") }}';
                    } else {
                        alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengirim. Silakan coba lagi.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        });
    </script>
@endsection
