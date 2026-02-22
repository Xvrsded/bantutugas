@extends('layouts.app')

@section('title', 'Login Admin')

@section('extra-css')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 220px);
        display: flex;
        align-items: center;
        padding: 3rem 0;
    }

    .auth-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
    }

    .auth-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 1.5rem 1.75rem;
    }

    .auth-header h1 {
        font-size: 1.35rem;
        margin: 0;
        font-weight: 700;
    }

    .auth-header p {
        margin: 0.5rem 0 0;
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }

    .auth-note {
        border-left: 4px solid var(--secondary-color);
        background-color: #f8f9fa;
        padding: 0.85rem 1rem;
        border-radius: 6px;
        font-size: 0.92rem;
        color: #555;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
    }

    .btn-login {
        padding: 0.7rem 1.1rem;
        font-weight: 600;
    }

    .demo-credential {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.85rem;
        color: #666;
    }
</style>
@endsection

@section('content')
<section class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card shadow auth-card">
                    <div class="auth-header">
                        <h1><i class="bi bi-shield-lock me-2"></i>Login Admin</h1>
                        <p>Masuk untuk mengelola order, layanan, testimoni, dan data website.</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="auth-note mb-4">
                            Halaman ini khusus admin. Pengunjung biasa tidak perlu login untuk melihat layanan atau melakukan pemesanan.
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Admin</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-login">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Dashboard
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
