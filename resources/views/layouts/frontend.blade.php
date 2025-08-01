<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="Codescandy" name="author" />
    <title>@yield('title', config('app.name'))</title>

    <!-- CSS Files -->
    <link href="{{ asset('assets/libs/slick-carousel/slick/slick.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/slick-carousel/slick/slick-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" rel="stylesheet" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" />

    <!-- Libs CSS -->
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/feather-webfont/dist/feather-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" />

    <!-- Custom Banner CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom-banner.css') }}" />

    <!-- Responsive Navbar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive-navbar.css') }}" />

    <!-- Additional CSS from pages -->
    @stack('styles')

    <!-- Preloader CSS -->
    <style>
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        .preloader.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        .preloader-inner {
            text-align: center;
            animation: preloaderPulse 2s ease-in-out infinite;
        }

        .preloader-logo {
            margin-bottom: 2rem;
        }

        .preloader-logo .logo-img {
            height: 60px;
            width: auto;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
        }

        .preloader-spinner {
            margin: 2rem 0;
        }

        .spinner-ring {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px;
        }

        .spinner-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 51px;
            height: 51px;
            margin: 6px;
            border: 6px solid #0aad0a;
            border-radius: 50%;
            animation: spinnerRing 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #0aad0a transparent transparent transparent;
        }

        .spinner-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .spinner-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .spinner-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        .preloader-text h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .preloader-text small {
            color: #6c757d;
            font-size: 0.875rem;
        }

        @keyframes spinnerRing {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes preloaderPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        /* Hide content while preloader is active */
        body.preloader-active {
            overflow: hidden;
        }

        body.preloader-active .navbar,
        body.preloader-active main,
        body.preloader-active footer {
            opacity: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .preloader-logo .logo-img {
                height: 50px;
            }

            .spinner-ring {
                width: 48px;
                height: 48px;
            }

            .spinner-ring div {
                width: 38px;
                height: 38px;
                margin: 5px;
                border-width: 4px;
            }

            .preloader-text h5 {
                font-size: 1.1rem;
            }
        }
    </style>

    <!-- Analytics Scripts -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-M8S4MT3EYG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "G-M8S4MT3EYG");
    </script>
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments);
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "kuc8w5o9nt");
    </script>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader" class="preloader">
        <div class="preloader-inner">
            <div class="preloader-logo">
                <img src="{{ asset('assets/images/logo/freshcart-logo.svg') }}" alt="FreshCart" class="logo-img">
            </div>
            <div class="preloader-spinner">
                <div class="spinner-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="preloader-text">
                <h5 class="mb-0">Loading...</h5>
                <small class="text-muted">Preparing your experience</small>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    @include('layouts.partials.frontend.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Modals -->
    @include('layouts.partials.frontend.modals')

    <!-- Footer -->
    @include('layouts.partials.frontend.footer')

    <!-- Javascript -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/countdown.js') }}"></script>
    <script src="{{ asset('assets/libs/slick-carousel/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/slick-slider.js') }}"></script>
    <script src="{{ asset('assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/tns-slider.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/zoom.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/validation.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Additional JavaScript from pages -->
    @stack('scripts')

    <!-- Preloader JavaScript -->
    <script>
        // Preloader functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add preloader-active class to body initially
            document.body.classList.add('preloader-active');

            // Hide preloader after page load
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const preloader = document.getElementById('preloader');
                    if (preloader) {
                        preloader.classList.add('fade-out');
                        document.body.classList.remove('preloader-active');

                        // Remove preloader from DOM after animation
                        setTimeout(function() {
                            preloader.remove();
                        }, 500);
                    }
                }, 500); // Show preloader for at least 500ms for better UX
            });

            // Fallback: Hide preloader after maximum 5 seconds
            setTimeout(function() {
                const preloader = document.getElementById('preloader');
                if (preloader && !preloader.classList.contains('fade-out')) {
                    preloader.classList.add('fade-out');
                    document.body.classList.remove('preloader-active');

                    setTimeout(function() {
                        preloader.remove();
                    }, 500);
                }
            }, 5000);
        });

        // Show preloader on page transitions (for SPA-like experience)
        function showPreloader() {
            const existingPreloader = document.getElementById('preloader');
            if (!existingPreloader) {
                const preloaderHTML = `
                    <div id="preloader" class="preloader">
                        <div class="preloader-inner">
                            <div class="preloader-logo">
                                <img src="{{ asset('assets/images/logo/freshcart-logo.svg') }}" alt="FreshCart" class="logo-img">
                            </div>
                            <div class="preloader-spinner">
                                <div class="spinner-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <div class="preloader-text">
                                <h5 class="mb-0">Loading...</h5>
                                <small class="text-muted">Preparing your experience</small>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('afterbegin', preloaderHTML);
                document.body.classList.add('preloader-active');
            }
        }

        // Optional: Add preloader to form submissions and AJAX calls
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                showPreloader();
            }
        });
    </script>

    <!-- SweetAlert Laravel Integration -->
    @include('sweetalert::alert')
</body>

</html>
