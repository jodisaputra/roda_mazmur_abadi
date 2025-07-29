<!-- footer -->
<footer class="footer bg-dark text-white">
    <div class="container">
        <!-- Main footer content -->
        <div class="py-5">
            <div class="row g-4">
                <!-- Company info -->
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <img src="{{ asset('assets/images/logo/freshcart-logo.svg') }}" alt="FreshCart"
                             style="height: 40px; filter: brightness(0) invert(1);">
                    </div>
                    <p class="text-light">
                        FreshCart adalah platform belanja online terpercaya untuk kebutuhan segar dan berkualitas.
                        Kami menyediakan produk-produk pilihan dengan harga terjangkau.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white mb-3">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('homepage') }}" class="text-light text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Kategori</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Promo</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-3">Layanan Pelanggan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Bantuan</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Syarat & Ketentuan</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Kebijakan Privasi</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Cara Berbelanja</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Pengembalian</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-3">Hubungi Kami</h6>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt text-success me-2"></i>
                            <small class="text-light">Jl. Sudirman No. 123, Jakarta</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telephone text-success me-2"></i>
                            <small class="text-light">021-123-4567</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope text-success me-2"></i>
                            <small class="text-light">info@freshcart.com</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock text-success me-2"></i>
                            <small class="text-light">Senin - Minggu: 08:00 - 22:00</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom footer -->
        <div class="border-top border-secondary py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-light">
                        © {{ date('Y') }} FreshCart. Semua hak dilindungi undang-undang.
                    </small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-light">
                        Dibuat dengan <i class="bi bi-heart-fill text-danger"></i> untuk pelanggan Indonesia
                    </small>
                </div>
            </div>
        </div>
    </div>
</footer>
