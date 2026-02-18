@extends('layouts.app')

@section('title', 'Pesan - ' . $service->name)

@section('content')
    <section class="py-5 bg-light" style="min-height: 80vh;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title mb-4">
                                <i class="bi bi-bag-check"></i> Form Pemesanan
                            </h2>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> <strong>Layanan:</strong> {{ $service->name }}
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Terjadi Kesalahan:</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('order.store') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <h5 class="mt-4 mb-3">Informasi Pribadi</h5>
                                <hr>

                                <div class="mb-3">
                                    <label for="client_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name" required value="{{ old('client_name') }}">
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="client_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('client_email') is-invalid @enderror" id="client_email" name="client_email" required value="{{ old('client_email') }}">
                                    @error('client_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="client_phone" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('client_phone') is-invalid @enderror" id="client_phone" name="client_phone" placeholder="62812xxxxx" required value="{{ old('client_phone') }}">
                                    @error('client_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h5 class="mt-4 mb-3">Detail Proyek</h5>
                                <hr>

                                <div class="mb-3">
                                    <label for="project_title" class="form-label">Judul Proyek <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('project_title') is-invalid @enderror" id="project_title" name="project_title" placeholder="Misal: Skripsi tentang IoT..." required value="{{ old('project_title') }}">
                                    @error('project_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi Detail <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Jelaskan detail proyek, requirements, dan yang Anda harapkan..." required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Semakin detail, semakin baik kami memahami kebutuhan Anda</small>
                                </div>

                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Deadline <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" required value="{{ old('deadline') }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="budget" class="form-label">Budget yang Anda inginkan (Opsional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('budget') is-invalid @enderror" id="budget" name="budget" placeholder="0" value="{{ old('budget') }}">
                                    </div>
                                    <small class="text-muted">Biarkan kosong jika ingin kami memberikan quote</small>
                                </div>

                                <div class="mb-3">
                                    <label for="attachment" class="form-label">Lampiran File (Opsional)</label>
                                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.jpg,.png">
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Maksimal 5MB. Format: PDF, DOC, XLS, ZIP, gambar, dll</small>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="disclaimer" required>
                                    <label class="form-check-label" for="disclaimer">
                                        Saya telah membaca dan setuju dengan <a href="{{ route('disclaimer') }}" target="_blank">syarat & ketentuan</a> layanan
                                    </label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle"></i> Kirim Pesanan
                                    </button>
                                    <a href="{{ route('services') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title">Ringkasan Layanan</h5>
                            <hr>
                            
                            <p class="mb-2">
                                <strong>Layanan:</strong><br>
                                {{ $service->name }}
                            </p>

                            <p class="mb-2">
                                <strong>Kategori:</strong><br>
                                {{ ucfirst(str_replace('-', ' ', $service->category)) }}
                            </p>

                            <p class="mb-2">
                                <strong>Deskripsi:</strong><br>
                                <small>{{ $service->description }}</small>
                            </p>

                            @if ($service->features)
                                <p class="mb-2">
                                    <strong>Fitur:</strong><br>
                                    <small>
                                        @foreach ($service->features as $feature)
                                            • {{ $feature }}<br>
                                        @endforeach
                                    </small>
                                </p>
                            @endif

                            <hr>

                            <p class="mb-0">
                                <strong>Harga:</strong><br>
                                <span class="badge bg-danger fs-6">
                                    Rp {{ number_format($service->price_start, 0, ',', '.') }}
                                    @if ($service->price_end)
                                        - Rp {{ number_format($service->price_end, 0, ',', '.') }}
                                    @else
                                        (Harga Mulai)
                                    @endif
                                </span>
                            </p>

                            <div class="alert alert-info mt-3 mb-0">
                                <small><i class="bi bi-info-circle"></i> Harga final akan dikonfirmasi setelah kami review detail proyek Anda.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
