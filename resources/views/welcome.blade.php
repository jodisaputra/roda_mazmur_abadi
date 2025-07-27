@extends('layouts.frontend')

@section('title', 'Homepage - FreshCart')

@section('content')
    <section class="mt-8">
        <div class="container">
            <div class="hero-slider">
                <div
                    style="background: url('{{ asset('assets/images/slider/slide-1.jpg') }}') no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                    <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <h2 class="text-dark display-5 fw-bold mt-4">SuperMarket For Fresh Grocery</h2>
                        <p class="lead">Introduced a new model for online grocery shopping and convenient home delivery.
                        </p>
                        <a href="#!" class="btn btn-dark mt-3">
                            Shop Now
                            <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div
                    style="background: url('{{ asset('assets/images/slider/slider-2.jpg') }}') no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                    <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <span class="badge text-bg-warning">Free Shipping - orders over $100</span>
                        <h2 class="text-dark display-5 fw-bold mt-4">
                            Free Shipping on
                            <br />
                            orders over
                            <span class="text-primary">$100</span>
                        </h2>
                        <p class="lead">Free Shipping to First-Time Customers Only, After promotions and discounts are
                            applied.</p>
                        <a href="#!" class="btn btn-dark mt-3">
                            Shop Now
                            <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Start-->
    <section class="my-lg-14 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0">Popular Products</h3>
                </div>
            </div>

            <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                <div class="col">
                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <div class="position-absolute top-0 start-0">
                                    <span class="badge bg-danger">Sale</span>
                                </div>
                                <a href="#!"><img src="{{ asset('assets/images/products/product-img-1.jpg') }}"
                                        alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>

                                <div class="card-product-action">
                                    <a href="#!" class="btn-action" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Quick View"></i>
                                    </a>
                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="Compare"><i class="bi bi-arrow-left-right"></i></a>
                                </div>
                            </div>
                            <div class="text-small mb-1">
                                <a href="#!" class="text-decoration-none text-muted"><small>Snack &
                                        Munchies</small></a>
                            </div>
                            <h2 class="fs-6"><a href="./pages/shop-single.html"
                                    class="text-inherit text-decoration-none">Haldiram's Sev Bhujia</a></h2>
                            <div>
                                <small class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </small>
                                <span class="text-muted small">4.5(149)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="text-dark">$18</span>
                                    <span class="text-decoration-line-through text-muted">$24</span>
                                </div>
                                <div>
                                    <a href="#!" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <a href="./pages/shop-single.html"><img
                                        src="{{ asset('assets/images/products/product-img-7.jpg') }}"
                                        alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>
                                <div class="card-product-action">
                                    <a href="#!" class="btn-action" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Quick View"></i>
                                    </a>
                                    <a href="../pages/shop-wishlist.html" class="btn-action" data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="Compare"><i class="bi bi-arrow-left-right"></i></a>
                                </div>
                            </div>
                            <div class="text-small mb-1">
                                <a href="#!" class="text-decoration-none text-muted"><small>Dairy, Bread &
                                        Eggs</small></a>
                            </div>
                            <h2 class="fs-6"><a href="./pages/shop-single.html"
                                    class="text-inherit text-decoration-none">Britannia Cheese Slices</a></h2>
                            <div class="text-warning">
                                <small>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </small>
                                <span class="text-muted small">5 (345)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div><span class="text-dark">$24</span></div>
                                <div>
                                    <a href="#!" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <a href="./pages/shop-single.html"><img
                                        src="{{ asset('assets/images/products/product-img-8.jpg') }}"
                                        alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>
                                <div class="card-product-action">
                                    <a href="#!" class="btn-action" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Quick View"></i>
                                    </a>
                                    <a href="../pages/shop-wishlist.html" class="btn-action" data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="Compare"><i class="bi bi-arrow-left-right"></i></a>
                                </div>
                            </div>
                            <div class="text-small mb-1">
                                <a href="#!" class="text-decoration-none text-muted"><small>Instant
                                        Food</small></a>
                            </div>
                            <h2 class="fs-6"><a href="./pages/shop-single.html"
                                    class="text-inherit text-decoration-none">Kellogg's Original Cereals</a></h2>
                            <div class="text-warning">
                                <small>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </small>
                                <span class="text-muted small">4 (90)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="text-dark">$32</span>
                                    <span class="text-decoration-line-through text-muted">$35</span>
                                </div>
                                <div>
                                    <a href="#!" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <a href="./pages/shop-single.html"><img
                                        src="{{ asset('assets/images/products/product-img-9.jpg') }}"
                                        alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>
                                <div class="card-product-action">
                                    <a href="#!" class="btn-action" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Quick View"></i>
                                    </a>
                                    <a href="../pages/shop-wishlist.html" class="btn-action" data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="Compare"><i class="bi bi-arrow-left-right"></i></a>
                                </div>
                            </div>
                            <div class="text-small mb-1">
                                <a href="#!" class="text-decoration-none text-muted"><small>Snack &
                                        Munchies</small></a>
                            </div>
                            <h2 class="fs-6"><a href="./pages/shop-single.html"
                                    class="text-inherit text-decoration-none">Slurrp Millet Chocolate</a></h2>
                            <div class="text-warning">
                                <small>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </small>
                                <span class="text-muted small">4.5 (67)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="text-dark">$3</span>
                                    <span class="text-decoration-line-through text-muted">$5</span>
                                </div>
                                <div>
                                    <a href="#!" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <a href="./pages/shop-single.html"><img
                                        src="{{ asset('assets/images/products/product-img-10.jpg') }}"
                                        alt="Grocery Ecommerce Template" class="mb-3 img-fluid" /></a>
                                <div class="card-product-action">
                                    <a href="#!" class="btn-action" data-bs-toggle="modal"
                                        data-bs-target="#quickViewModal">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Quick View"></i>
                                    </a>
                                    <a href="../pages/shop-wishlist.html" class="btn-action" data-bs-toggle="tooltip"
                                        data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#!" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="Compare"><i class="bi bi-arrow-left-right"></i></a>
                                </div>
                            </div>
                            <div class="text-small mb-1">
                                <a href="#!" class="text-decoration-none text-muted"><small>Dairy, Bread &
                                        Eggs</small></a>
                            </div>
                            <h2 class="fs-6"><a href="./pages/shop-single.html"
                                    class="text-inherit text-decoration-none">Amul Butter - 500 g</a></h2>
                            <div class="text-warning">
                                <small>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <i class="bi bi-star"></i>
                                </small>
                                <span class="text-muted small">3.5 (89)</span>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    <span class="text-dark">$13</span>
                                    <span class="text-decoration-line-through text-muted">$18</span>
                                </div>
                                <div>
                                    <a href="#!" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Products End-->

@endsection

@push('scripts')
    <script>
        // Custom JavaScript for homepage can be added here
        console.log('Homepage loaded successfully');
    </script>
@endpush
