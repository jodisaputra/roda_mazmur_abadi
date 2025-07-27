@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    <!-- navigation -->
    <div class="border-bottom shadow-sm">
        <nav class="navbar navbar-light py-2">
            <div class="container justify-content-center justify-content-lg-between">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo/freshcart-logo.svg') }}" alt="{{ config('app.name') }}"
                        class="d-inline-block align-text-top" />
                </a>
                <span class="navbar-text">
                    Don't have an account?
                    <a href="{{ route('register') }}">Sign Up</a>
                </span>
            </div>
        </nav>
    </div>

    <main>
        <!-- section -->
        <section class="my-lg-14 my-8">
            <div class="container">
                <!-- row -->
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                        <!-- img -->
                        <img src="{{ asset('assets/images/svg-graphics/signin-g.svg') }}" alt=""
                            class="img-fluid" />
                    </div>
                    <!-- col -->
                    <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                        <div class="mb-lg-9 mb-5">
                            <h1 class="mb-1 h2 fw-bold">Sign in to {{ config('app.name') }}</h1>
                            <p>Welcome back to {{ config('app.name') }}! Enter your email to get started.</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3">
                                <!-- Email field -->
                                <div class="col-12">
                                    <label for="email"
                                        class="form-label visually-hidden">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Email" required autocomplete="email"
                                        autofocus />

                                    @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @else
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    @enderror
                                </div>

                                <!-- Password field -->
                                <div class="col-12">
                                    <div class="password-field position-relative">
                                        <label for="password"
                                            class="form-label visually-hidden">{{ __('Password') }}</label>
                                        <div class="password-field position-relative">
                                            <input id="password" type="password"
                                                class="form-control fakePassword @error('password') is-invalid @enderror"
                                                name="password" placeholder="*****" required
                                                autocomplete="current-password" />
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

                                <!-- Remember me and Forgot password -->
                                <div class="d-flex justify-content-between">
                                    <!-- form check -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }} />
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <div>
                                        @if (Route::has('password.request'))
                                            Forgot password?
                                            <a href="{{ route('password.request') }}">Reset It</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Sign In') }}
                                    </button>
                                </div>

                                <!-- Sign up link -->
                                <div>
                                    Don't have an account?
                                    <a href="{{ route('register') }}">Sign Up</a>
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
