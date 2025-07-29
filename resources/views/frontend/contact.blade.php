@extends('layouts.frontend')

@section('title', 'Hubungi Kami - FreshCart')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold mb-3">Hubungi Kami</h1>
            <p class="lead text-muted">Kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami!</p>
        </div>
    </div>

    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="h-100">
                <h3 class="fw-bold mb-4">Informasi Kontak</h3>

                <div class="mb-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="text-success me-3 mt-1">
                            <i class="bi bi-geo-alt-fill" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Alamat</h6>
                            <p class="text-muted mb-0">
                                Jl. Sudirman No. 123<br>
                                Jakarta Pusat, DKI Jakarta<br>
                                Indonesia 10220
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="text-success me-3 mt-1">
                            <i class="bi bi-telephone-fill" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Telepon</h6>
                            <p class="text-muted mb-1">021-123-4567</p>
                            <p class="text-muted mb-0">0812-3456-7890 (WhatsApp)</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="text-success me-3 mt-1">
                            <i class="bi bi-envelope-fill" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-muted mb-1">info@freshcart.com</p>
                            <p class="text-muted mb-0">support@freshcart.com</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="text-success me-3 mt-1">
                            <i class="bi bi-clock-fill" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Jam Operasional</h6>
                            <p class="text-muted mb-1">Senin - Jumat: 08:00 - 22:00</p>
                            <p class="text-muted mb-1">Sabtu - Minggu: 09:00 - 21:00</p>
                            <p class="text-muted mb-0">Customer Service: 24/7</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div>
                    <h6 class="fw-bold mb-3">Ikuti Kami</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Kirim Pesan</h3>

                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone">
                            </div>
                            <div class="col-md-6">
                                <label for="subject" class="form-label">Subjek</label>
                                <select class="form-select" id="subject" required>
                                    <option value="">Pilih Subjek</option>
                                    <option value="general">Pertanyaan Umum</option>
                                    <option value="order">Masalah Pesanan</option>
                                    <option value="product">Pertanyaan Produk</option>
                                    <option value="complaint">Keluhan</option>
                                    <option value="suggestion">Saran</option>
                                    <option value="partnership">Kerjasama</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Pesan</label>
                                <textarea class="form-control" id="message" rows="6" required
                                    placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Saya ingin mendapatkan newsletter dan update promo terbaru
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-send me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold text-center mb-5">Pertanyaan yang Sering Diajukan</h3>
        </div>
        <div class="col-lg-6">
            <div class="accordion" id="faqAccordion1">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            Bagaimana cara berbelanja di FreshCart?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion1">
                        <div class="accordion-body">
                            Mudah sekali! Cukup pilih produk yang Anda inginkan, masukkan ke keranjang,
                            lakukan checkout, dan pilih metode pembayaran. Pesanan akan diproses dan dikirim ke alamat Anda.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            Berapa lama waktu pengiriman?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                        <div class="accordion-body">
                            Untuk area Jakarta dan sekitarnya, pengiriman memakan waktu 1-2 hari kerja.
                            Untuk kota lain di Indonesia, waktu pengiriman adalah 2-5 hari kerja tergantung lokasi.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            Apa saja metode pembayaran yang tersedia?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                        <div class="accordion-body">
                            Kami menerima berbagai metode pembayaran: Transfer Bank, E-wallet (OVO, GoPay, DANA),
                            Kartu Kredit/Debit, dan COD (Cash on Delivery) untuk area tertentu.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="accordion" id="faqAccordion2">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            Bagaimana jika produk yang diterima tidak sesuai?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                        <div class="accordion-body">
                            Kami memiliki garansi 100% untuk kepuasan pelanggan. Jika produk tidak sesuai atau rusak,
                            Anda dapat mengajukan pengembalian dalam 24 jam setelah produk diterima.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                            Apakah ada minimum pembelian untuk gratis ongkir?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                        <div class="accordion-body">
                            Ya, untuk mendapatkan gratis ongkir, minimum pembelian adalah Rp 100.000.
                            Promo ini berlaku untuk seluruh Indonesia dengan ekspedisi standar.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
                            Bagaimana cara melacak pesanan saya?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                        <div class="accordion-body">
                            Setelah pesanan dikirim, Anda akan mendapatkan nomor resi via email dan SMS.
                            Anda bisa melacak pesanan melalui website kurir atau di menu "Pesanan Saya" setelah login.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Contact CTA -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body text-center py-5">
                    <h4 class="fw-bold mb-3">Butuh Bantuan Segera?</h4>
                    <p class="text-muted mb-4">Tim customer service kami siap membantu Anda 24/7</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="tel:+6221-123-4567" class="btn btn-success">
                            <i class="bi bi-telephone me-2"></i>Telepon Sekarang
                        </a>
                        <a href="https://wa.me/6281234567890" class="btn btn-outline-success" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                        </a>
                        <a href="mailto:support@freshcart.com" class="btn btn-outline-success">
                            <i class="bi bi-envelope me-2"></i>Email Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show success message
            alert('Terima kasih! Pesan Anda telah terkirim. Tim kami akan segera menghubungi Anda.');

            // Reset form
            this.reset();
        });
    }
});
</script>
@endpush
