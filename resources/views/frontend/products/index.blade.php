@extends('layouts.frontend')

@section('title', 'Semua Shelf Produk - FreshCart')

@section('content')
<main>
    <!-- Breadcrumb section -->
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('homepage') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Semua Shelf Produk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main section -->
    <div class="mt-8 mb-lg-14 mb-8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Page header -->
                    <div class="card mb-4 bg-light border-0">
                        <div class="card-body p-9">
                            <h1 class="mb-0">Jelajahi Semua Shelf Produk</h1>
                            <p class="mb-0 text-muted">Temukan produk berdasarkan shelf yang tersedia</p>
                        </div>
                    </div>

                    @if($shelves->isNotEmpty())
                        <!-- Shelves grid -->
                        <div class="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2 row-cols-md-2">
                            @foreach($shelves as $shelf)
                                <div class="col">
                                    <div class="card card-product h-100 shadow-sm border-0">
                                        <div class="card-body text-center">
                                            <!-- Shelf icon -->
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center justify-content-center"
                                                     style="height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                                                    <i class="bi bi-box2 text-white" style="font-size: 3rem;"></i>
                                                </div>
                                            </div>

                                            <!-- Shelf info -->
                                            <h5 class="card-title mb-2">
                                                <a href="{{ route('shelf.show', $shelf->slug) }}"
                                                   class="text-decoration-none text-inherit">
                                                    {{ $shelf->name }}
                                                </a>
                                            </h5>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    {{ $shelf->products_count }} produk
                                                </small>
                                                <small class="text-muted">
                                                    @if($shelf->capacity)
                                                        Kapasitas: {{ $shelf->capacity }}
                                                    @endif
                                                </small>
                                            </div>

                                            <!-- Action -->
                                            <div class="mt-3">
                                                <a href="{{ route('shelf.show', $shelf->slug) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    Lihat Produk <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty state -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="mb-3">Belum Ada Shelf</h3>
                            <p class="text-muted mb-4">Shelf produk akan segera tersedia</p>
                            <a href="{{ route('homepage') }}" class="btn btn-primary">
                                Kembali ke Beranda
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
