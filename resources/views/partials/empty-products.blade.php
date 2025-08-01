<!-- Empty State Component for Products - Minimal Version -->
<section class="py-5" style="background-color: #ffffff; min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="text-center py-5">

                    <!-- SVG Illustration -->
                    <div class="mb-4">
                        <img src="{{ asset('assets/images/svg-graphics/empty-products.svg') }}"
                             alt="Belum ada produk"
                             class="img-fluid"
                             style="max-width: 280px; opacity: 0.9;">
                    </div>

                    <!-- Title -->
                    <h1 style="color: #000000; font-size: 2.5rem; font-weight: 700; margin-bottom: 1.5rem;">
                        {{ $title ?? 'Produk Belum Tersedia' }}
                    </h1>

                    <!-- Description -->
                    <p style="color: #666666; font-size: 1.1rem; font-weight: 400; margin-bottom: 2.5rem; line-height: 1.6; max-width: 500px; margin-left: auto; margin-right: auto;">
                        {{ $description ?? 'Kami sedang mempersiapkan koleksi produk terbaik untuk Anda. Tetap pantau halaman ini untuk update produk terbaru!' }}
                    </p>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ $contactUrl ?? '#' }}"
                           style="background-color: #28a745; color: #ffffff; font-weight: 600; font-size: 1rem; padding: 0.8rem 1.8rem; text-decoration: none; border-radius: 0.5rem; border: none; display: inline-flex; align-items: center; justify-content: center; min-width: 180px;">
                            <i class="bi bi-telephone" style="margin-right: 0.5rem; font-size: 1rem;"></i>
                            {{ $contactText ?? 'Hubungi Kami' }}
                        </a>
                        <a href="{{ $subscribeUrl ?? '#' }}"
                           style="background-color: #ffffff; color: #28a745; font-weight: 600; font-size: 1rem; padding: 0.8rem 1.8rem; text-decoration: none; border-radius: 0.5rem; border: 2px solid #28a745; display: inline-flex; align-items: center; justify-content: center; min-width: 180px;">
                            <i class="bi bi-envelope" style="margin-right: 0.5rem; font-size: 1rem;"></i>
                            {{ $subscribeText ?? 'Berlangganan Notifikasi' }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
