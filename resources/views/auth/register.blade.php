@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
    <!-- navigation -->
    <div class="border-bottom shadow-sm">
        <nav class="navbar navbar-light py-2">
            <div class="container justify-content-center justify-content-lg-between">
                <a class="navbar-brand" href="{{ route('homepage') }}">
                    <img src="{{ asset('assets/images/logo/freshcart-logo.svg') }}" alt="{{ config('app.name') }}"
                        class="d-inline-block align-text-top" />
                </a>
                <span class="navbar-text">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </span>
            </div>
        </nav>
    </div>

    <main>
        <!-- section -->
        <section class="my-lg-14 my-8">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                        <!-- img -->
                        <img src="{{ asset('assets/images/svg-graphics/signup-g.svg') }}" alt=""
                            class="img-fluid" />
                    </div>
                    <!-- col -->
                    <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                        <div class="mb-lg-9 mb-5">
                            <h1 class="mb-1 h2 fw-bold">Get Start Shopping</h1>
                            <p>Welcome to {{ config('app.name') }}! Enter your email to get started.</p>
                        </div>

                        <!-- form -->
                        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3">
                                <!-- First Name and Last Name -->
                                <div class="col">
                                    <!-- input -->
                                    <label for="first_name"
                                        class="form-label visually-hidden">{{ __('First Name') }}</label>
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name') }}" placeholder="First Name" required
                                        autocomplete="given-name" autofocus />

                                    @error('first_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @else
                                        <div class="invalid-feedback">Please enter first name.</div>
                                    @enderror
                                </div>

                                <div class="col">
                                    <!-- input -->
                                    <label for="last_name" class="form-label visually-hidden">{{ __('Last Name') }}</label>
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name') }}" placeholder="Last Name" required
                                        autocomplete="family-name" />

                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @else
                                        <div class="invalid-feedback">Please enter last name.</div>
                                    @enderror
                                </div>

                                <!-- Full Name (if you prefer single name field instead of first/last) -->
                                <!-- Uncomment this and comment out first_name/last_name if needed -->
                                <!--
                                <div class="col-12">
                                    <label for="name" class="form-label visually-hidden">{{ __('Name') }}</label>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Full Name"
                                           required
                                           autocomplete="name"
                                           autofocus />

                                    @error('name')
        <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
    @else
        <div class="invalid-feedback">Please enter your name.</div>
    @enderror
                                </div>
                                -->

                                <!-- Email -->
                                <div class="col-12">
                                    <!-- input -->
                                    <label for="email"
                                        class="form-label visually-hidden">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Email" required autocomplete="email" />

                                    @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @else
                                        <div class="invalid-feedback">Please enter email.</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-12">
                                    <div class="password-field position-relative">
                                        <label for="password"
                                            class="form-label visually-hidden">{{ __('Password') }}</label>
                                        <div class="password-field position-relative">
                                            <input id="password" type="password"
                                                class="form-control fakePassword @error('password') is-invalid @enderror"
                                                name="password" placeholder="*****" required autocomplete="new-password" />
                                            <span><i class="bi bi-eye-slash passwordToggler"></i></span>

                                            @error('password')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @else
                                                <div class="invalid-feedback">Please enter password.</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Confirmation -->
                                <div class="col-12">
                                    <div class="password-field position-relative">
                                        <label for="password-confirm"
                                            class="form-label visually-hidden">{{ __('Confirm Password') }}</label>
                                        <div class="password-field position-relative">
                                            <input id="password-confirm" type="password" class="form-control fakePassword"
                                                name="password_confirmation" placeholder="Confirm Password" required
                                                autocomplete="new-password" />
                                            <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                                            <div class="invalid-feedback">Please confirm your password.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>

                                <!-- Terms and Privacy -->
                                <p>
                                    <small>
                                        By continuing, you agree to our
                                        <a href="#!">Terms of Service</a>
                                        &
                                        <a href="#!">Privacy Policy</a>
                                    </small>
                                </p>

                                <!-- Login link -->
                                <div>
                                    Already have an account?
                                    <a href="{{ route('login') }}">Sign in</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <!-- Password toggle and validation scripts -->
    <script src="{{ asset('assets/js/vendors/password.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/validation.js') }}"></script>
@endpush
