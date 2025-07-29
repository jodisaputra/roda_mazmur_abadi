<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: #ffffff !important;">
            <div class="modal-header border-0 pb-0" style="background: #ffffff !important;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-eye text-success me-2" style="font-size: 1.5rem;"></i>
                    <h5 class="modal-title fw-bold" style="color: #000000 !important;">Preview Produk</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background: #ffffff !important;">
                <div class="row" id="quickViewContent">
                    <!-- Content will be loaded here via AJAX -->
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3" style="color: #333333 !important;">Memuat detail produk...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
