@extends('layouts.auth')

@section('title', 'Confirm Password')

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
                    Need help?
                    <a href="#!">Contact Support</a>
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
                            <h1 class="mb-1 h2 fw-bold">Confirm Password</h1>
                            <p>{{ __('Please confirm your password before continuing.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="row g-3">
                                <!-- Password field -->
                                <div class="col-12">
                                    <div class="password-field position-relative">
                                        <label for="password"
                                            class="form-label visually-hidden">{{ __('Password') }}</label>
                                        <div class="password-field position-relative">
                                            <input id="password" type="password"
                                                class="form-control fakePassword @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password" required
                                                autocomplete="current-password" autofocus />
                                            <span><i class="bi bi-eye-slash passwordToggler"></i></span>

                                            @error('password')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @else
                                                <div class="invalid-feedback">Please enter your password.</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Confirm Password') }}
                                    </button>
                                </div>

                                <!-- Forgot password link -->
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        Forgot your password?
                                        <a href="{{ route('password.request') }}">Reset It</a>
                                    @endif
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
