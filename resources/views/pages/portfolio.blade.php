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
                            @if ($portfolio->image)
                                <img src="{{ asset('storage/' . $portfolio->image) }}" class="card-img-top" alt="{{ $portfolio->title }}" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $portfolio->title }}</h5>
                                <p class="card-text">{{ Str::limit($portfolio->description, 80) }}</p>
                                
                                <div class="mb-3">
                                    <small class="badge bg-secondary">{{ ucfirst($portfolio->category) }}</small>
                                    @if ($portfolio->client_name)
                                        <small class="badge bg-info">Klien: {{ $portfolio->client_name }}</small>
                                    @endif
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
            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-light btn-lg">
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
