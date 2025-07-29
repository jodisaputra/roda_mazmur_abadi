@extends('layouts.frontend')

@section('title', 'Tentang Kami - FreshCart')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold mb-3">Tentang FreshCart</h1>
            <p class="lead text-muted">Platform belanja online terpercaya untuk kebutuhan segar dan berkualitas</p>
        </div>
    </div>

    <!-- About Content -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <img src="https://via.placeholder.com/600x400" alt="About FreshCart" class="img-fluid rounded shadow">
        </div>
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">Cerita Kami</h2>
            <p class="mb-4">
                FreshCart didirikan dengan visi sederhana: memberikan akses mudah kepada semua orang untuk mendapatkan
                produk-produk segar dan berkualitas tinggi langsung dari petani dan produsen terpercaya.
            </p>
            <p class="mb-4">
                Sejak tahun 2020, kami telah melayani ribuan pelanggan di seluruh Indonesia dengan komitmen untuk
                memberikan produk terbaik dengan harga yang fair dan pelayanan yang memuaskan.
            </p>
            <div class="row g-3">
                <div class="col-6">
                    <div class="text-center">
                        <h3 class="fw-bold text-success">10,000+</h3>
                        <p class="text-muted mb-0">Pelanggan Puas</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center">
                        <h3 class="fw-bold text-success">500+</h3>
                        <p class="text-muted mb-0">Produk Fresh</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold text-center mb-5">Nilai-Nilai Kami</h2>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="text-success mb-3">
                        <i class="bi bi-heart-fill" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Kualitas Terjamin</h5>
                    <p class="text-muted">
                        Kami hanya menyediakan produk-produk terbaik yang telah melalui proses seleksi ketat
                        untuk memastikan kualitas dan kesegaran.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="text-success mb-3">
                        <i class="bi bi-shield-check" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Terpercaya</h5>
                    <p class="text-muted">
                        Kepercayaan pelanggan adalah prioritas utama kami. Setiap transaksi dijamin aman
                        dan pengiriman tepat waktu.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="text-success mb-3">
                        <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Pelayanan Prima</h5>
                    <p class="text-muted">
                        Tim customer service kami siap melayani 24/7 untuk membantu setiap kebutuhan
                        dan pertanyaan Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold text-center mb-5">Tim Kami</h2>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="https://via.placeholder.com/150x150" alt="CEO" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h6 class="fw-bold">Budi Santoso</h6>
                    <p class="text-muted small mb-2">Chief Executive Officer</p>
                    <p class="text-muted small">Memimpin visi dan strategi perusahaan dengan pengalaman 15+ tahun di industri retail.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="https://via.placeholder.com/150x150" alt="CTO" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h6 class="fw-bold">Sari Indah</h6>
                    <p class="text-muted small mb-2">Chief Technology Officer</p>
                    <p class="text-muted small">Mengembangkan platform teknologi terdepan untuk pengalaman belanja yang seamless.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="https://via.placeholder.com/150x150" alt="Head of Operations" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h6 class="fw-bold">Ahmad Wijaya</h6>
                    <p class="text-muted small mb-2">Head of Operations</p>
                    <p class="text-muted small">Memastikan operasional supply chain dan logistik berjalan dengan efisien.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="https://via.placeholder.com/150x150" alt="Head of Marketing" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h6 class="fw-bold">Maya Putri</h6>
                    <p class="text-muted small mb-2">Head of Marketing</p>
                    <p class="text-muted small">Membangun brand awareness dan hubungan yang kuat dengan customer.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-success text-white border-0">
                <div class="card-body text-center py-5">
                    <h3 class="fw-bold mb-3">Siap Berbelanja dengan Kami?</h3>
                    <p class="lead mb-4">Bergabunglah dengan ribuan pelanggan yang telah merasakan pengalaman berbelanja terbaik</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('homepage') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-telephone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
