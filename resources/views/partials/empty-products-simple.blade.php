<!-- Simple and High Contrast Empty State -->
<link rel="stylesheet" href="{{ asset('assets/css/force-visible.css') }}">
<section class="py-5 empty-state-force-visible" style="background-color: #ffffff !important; min-height: 60vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center py-5">
                    <!-- Icon instead of SVG for better visibility -->
                    <div class="mb-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                             style="width: 120px; height: 120px; background-color: #f8f9fa; border: 2px solid #dee2e6;">
                            <i class="bi bi-box-seam" style="font-size: 3rem; color: #6c757d !important;"></i>
                        </div>
                    </div>

                    <!-- High contrast text with inline styles -->
                    <h1 style="font-size: 2.5rem; font-weight: 700; color: #000000 !important; margin-bottom: 1rem; text-shadow: none;">
                        {{ $title ?? 'Produk Belum Tersedia' }}
                    </h1>
                    <p style="font-size: 1.2rem; font-weight: 500; color: #333333 !important; margin-bottom: 2rem; line-height: 1.6; padding: 0 1rem;">
                        {{ $description ?? 'Kami sedang mempersiapkan koleksi produk terbaik untuk Anda. Tetap pantau halaman ini untuk update produk terbaru!' }}
                    </p>

                    <!-- Action Buttons with high contrast -->
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
                        <a href="{{ $contactUrl ?? '#' }}"
                           style="background-color: #28a745 !important; color: #ffffff !important; font-weight: 700; font-size: 1.1rem; padding: 1rem 2rem; text-decoration: none; border-radius: 0.5rem; border: none; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-telephone" style="margin-right: 0.5rem;"></i>
                            {{ $contactText ?? 'Hubungi Kami' }}
                        </a>
                        <a href="{{ $subscribeUrl ?? '#' }}"
                           style="background-color: #ffffff !important; color: #000000 !important; font-weight: 700; font-size: 1.1rem; padding: 1rem 2rem; text-decoration: none; border-radius: 0.5rem; border: 2px solid #000000; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-envelope" style="margin-right: 0.5rem;"></i>
                            {{ $subscribeText ?? 'Berlangganan Notifikasi' }}
                        </a>
                    </div>

                    <!-- Simple info badges -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div style="padding: 1.5rem; background-color: #fff3cd; border-radius: 0.75rem; border: 2px solid #ffc107; text-align: center;">
                                <i class="bi bi-bell-fill" style="font-size: 2rem; color: #ff8c00 !important; margin-bottom: 0.5rem; display: block;"></i>
                                <h5 style="font-weight: 700; color: #000000 !important; margin-bottom: 0.25rem; font-size: 1.1rem;">Notifikasi</h5>
                                <p style="color: #333333 !important; margin: 0; font-size: 0.9rem; font-weight: 500;">Update via email</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding: 1.5rem; background-color: #d1eddd; border-radius: 0.75rem; border: 2px solid #28a745; text-align: center;">
                                <i class="bi bi-shield-check-fill" style="font-size: 2rem; color: #28a745 !important; margin-bottom: 0.5rem; display: block;"></i>
                                <h5 style="font-weight: 700; color: #000000 !important; margin-bottom: 0.25rem; font-size: 1.1rem;">Kualitas</h5>
                                <p style="color: #333333 !important; margin: 0; font-size: 0.9rem; font-weight: 500;">Produk terjamin</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding: 1.5rem; background-color: #cfe2ff; border-radius: 0.75rem; border: 2px solid #007bff; text-align: center;">
                                <i class="bi bi-truck" style="font-size: 2rem; color: #007bff !important; margin-bottom: 0.5rem; display: block;"></i>
                                <h5 style="font-weight: 700; color: #000000 !important; margin-bottom: 0.25rem; font-size: 1.1rem;">Pengiriman</h5>
                                <p style="color: #333333 !important; margin: 0; font-size: 0.9rem; font-weight: 500;">Cepat & aman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
