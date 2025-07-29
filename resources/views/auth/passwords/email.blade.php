@extends('layouts.auth')

@section('title', 'Forgot Password')

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
                    Remember your password?
                    <a href="{{ route('login') }}">Sign in</a>
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
                            <h1 class="mb-1 h2 fw-bold">Forgot Password?</h1>
                            <p>Enter your email address and we'll send you a link to reset your password.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
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

                                <!-- Submit button -->
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>

                                <!-- Back to login link -->
                                <div>
                                    Remember your password?
                                    <a href="{{ route('login') }}">Back to Sign In</a>
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
    <!-- Validation scripts -->
    <script src="{{ asset('assets/js/vendors/validation.js') }}"></script>
@endpush
