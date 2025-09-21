@extends('layouts.web')

@section('title', 'Đăng Nhập')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Login</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Login</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Login Section -->


    <section id="login" class="login section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="auth-container" data-aos="fade-in" data-aos-delay="200">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <!-- Login Form -->
                            <div class="auth-form login-form active">
                                <div class="form-header">
                                    <h3>Chào mừng trở lại</h3>
                                    <p>Đăng nhập vào tài khoản của bạn</p>
                                </div>

                                <form class="auth-form-content">
                                    <div class="input-group mb-3">
                                        <span class="input-icon">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" placeholder="Email address"
                                            id="email" name="email" :value="old('email')" required autofocus
                                            autocomplete="username" required="" autocomplete="email">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-icon">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" placeholder="Password" id="password"
                                            class="block mt-1 w-full" type="password" name="password" required
                                            autocomplete="current-password">
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <span class="password-toggle">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>

                                    <div class="form-options mb-4">
                                        <div class="remember-me">
                                            <input type="checkbox" id="remember_me" name="remember">
                                            <label for="rememberLogin">Remember me</label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a class="forgot-password underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                                    </div>

                                    <button type="submit" class="auth-btn primary-btn mb-3">
                                        Sign In
                                        <i class="bi bi-arrow-right"></i>
                                    </button>

                                    {{-- <div class="divider">
                                        <span>or</span>
                                    </div>

                                    <button type="button" class="auth-btn social-btn">
                                        <i class="bi bi-google"></i>
                                        Continue with Google
                                    </button>
                                    <button type="button" class="auth-btn social-btn">
                                        <i class="bi bi-facebook"></i>
                                        Continue with Facebook
                                    </button>
                                    <button type="button" class="auth-btn social-btn">
                                        <i class="bi bi-apple"></i>
                                        Continue with Apple ID
                                    </button> --}}

                                    <div class="switch-form">
                                        <span>Don't have an account?</span>
                                        <a href="{{ route('register') }}" class="switch-btn" data-target="register">Create
                                            account</a>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Login Section -->


@endsection
