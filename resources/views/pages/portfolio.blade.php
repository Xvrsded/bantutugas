@extends('layouts.app')

@section('title', 'Portofolio')

@section('content')
    <!-- Header -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <h1 class="display-4 fw-bold">Portofolio Kami</h1>
            <p class="lead">Lihat hasil karya terbaik kami dari berbagai proyek</p>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="py-5 bg-white">
        <div class="container">
            <!-- Filter Buttons -->
            <div class="text-center mb-5">
                <button class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="filterPortfolio('all')">Semua</button>
                @foreach ($categories as $cat)
                    <button class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="filterPortfolio('{{ $cat }}')">
                        {{ ucfirst($cat) }}
                    </button>
                @endforeach
            </div>

            <div class="row" id="portfolioGrid">
                @forelse ($portfolios as $portfolio)
                    <div class="col-md-6 col-lg-4 mb-4 portfolio-item" data-category="{{ $portfolio->category }}">
                        <div class="card h-100">
                            @php
                                $fallbackImages = match ($portfolio->category) {
                                    'iot' => ['portfolio-images/IoT1.jpg', 'portfolio-images/IoT2.jpg'],
                                    'programming', 'webmonitoring' => ['portfolio-images/websiteMonitoring.png', 'portfolio-images/websiteMonitoring2.png'],
                                    'pcb' => ['portfolio-images/DesignPCB1.png', 'portfolio-images/DesignPCB2.png'],
                                    default => ['portfolio-images/default-academic.svg'],
                                };

                                $images = $portfolio->image_list;
                                if (count($images) === 0) {
                                    $images = array_values(array_filter($fallbackImages, fn ($p) => file_exists(public_path($p))));
                                    if (count($images) === 0) {
                                        $images = ['portfolio-images/default-academic.svg'];
                                    }
                                }

                                $toUrl = function ($path) {
                                    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                                        return $path;
                                    }

                                    $path = ltrim($path, '/');

                                    if (str_starts_with($path, 'portfolio-images/') || str_starts_with($path, 'pembayaran/') || str_starts_with($path, 'js/')) {
                                        return asset($path);
                                    }

                                    if (str_starts_with($path, 'storage/')) {
                                        return asset($path);
                                    }

                                    return asset('storage/' . $path);
                                };

                                $carouselId = 'portfolioCarousel' . $portfolio->id;
                            @endphp
                            @if (count($images) > 1)
                                <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($images as $index => $imagePath)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ $toUrl($imagePath) }}" class="card-img-top" alt="{{ $portfolio->title }}" style="height: 250px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @else
                                <img src="{{ $toUrl($images[0]) }}" class="card-img-top" alt="{{ $portfolio->title }}" style="height: 250px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $portfolio->title }}</h5>
                                <p class="card-text">{{ Str::limit($portfolio->description, 80) }}</p>
                                
                                <div class="mb-3">
                                    <small class="badge bg-secondary">{{ ucfirst($portfolio->category) }}</small>
                                </div>

                                @if ($portfolio->technologies)
                                    <p class="small text-muted">
                                        <strong>Tech:</strong> {{ implode(', ', $portfolio->technologies) }}
                                    </p>
                                @endif

                                @if ($portfolio->project_url)
                                    <a href="{{ $portfolio->project_url }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-arrow-up-right"></i> Lihat Proyek
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">Portofolio belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white;">
        <div class="container text-center">
            <h2 class="mb-3">Ingin Proyek Seperti Ini?</h2>
            <p class="lead mb-4">Hubungi kami untuk mendiskusikan proyek Anda</p>
            <a href="https://wa.me/{{ config('app.whatsapp_number') }}" target="_blank" class="btn btn-light btn-lg">
                <i class="bi bi-whatsapp"></i> Hubungi Kami
            </a>
        </div>
    </section>

    <script>
        function filterPortfolio(category) {
            const items = document.querySelectorAll('.portfolio-item');
            items.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
@endsection
