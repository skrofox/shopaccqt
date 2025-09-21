@extends('layouts.web')

@section('title', 'Đăng Ký')

@section('content')

    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Đăng Ký</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Đăng ký</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Register Section -->
    <form action="{{ route('register') }}" method="post">
        @csrf
        <section id="register" class="register section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="registration-form-wrapper">
                            <div class="form-header text-center">
                                <h2>Create Your Account</h2>
                                <p>Create your account and start shopping with us</p>
                            </div>

                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <form action="register.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Name" id="name"
                                                class="block mt-1 w-full" name="name" :value="old('name')" required
                                                autofocus autocomplete="name">
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            <label for="fullName">Full Name</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" placeholder="Email Address"
                                                id="email" class="block mt-1 w-full" name="email"
                                                :value="old('email')" required autocomplete="username">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            <label for="email">Email Address</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" placeholder="Password"
                                                        id="password" type="password" name="password" required
                                                        autocomplete="new-password">
                                                    <label for="password">Password</label>
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" placeholder="Confirm Password"
                                                        id="password_confirmation" class="block mt-1 w-full" type="password"
                                                        name="password_confirmation" required autocomplete="new-password">
                                                    <label for="confirmPassword">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-floating mb-4">
                                            <select class="form-select" id="country" name="country" required="">
                                                <option value="" selected="" disabled="">Select your country
                                                </option>
                                                <option value="us">United States</option>
                                                <option value="ca">Canada</option>
                                                <option value="uk">United Kingdom</option>
                                                <option value="au">Australia</option>
                                                <option value="de">Germany</option>
                                                <option value="fr">France</option>
                                                <option value="jp">Japan</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="country">Country</label>
                                        </div> --}}

                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" id="termsCheck"
                                                name="termsCheck" required="">
                                            <label class="form-check-label" for="termsCheck">
                                                I agree to the <a href="#">Terms of Service</a> and <a
                                                    href="#">Privacy Policy</a>
                                            </label>
                                        </div>

                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" id="marketingCheck"
                                                name="marketingCheck">
                                            <label class="form-check-label" for="marketingCheck">
                                                I would like to receive marketing communications about products, services,
                                                and promotions
                                            </label>
                                        </div>

                                        <div class="d-grid mb-4">
                                            <button type="submit" class="btn btn-register">Create Account</button>
                                        </div>

                                        <div class="login-link text-center">
                                            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="social-login">
                                <div class="row">
                                    <div class="col-lg-8 mx-auto">
                                        <div class="divider">
                                            <span>or sign up with</span>
                                        </div>
                                        <div class="social-buttons">
                                            <a href="#" class="btn btn-social">
                                                <i class="bi bi-google"></i>
                                                <span>Google</span>
                                            </a>
                                            <a href="#" class="btn btn-social">
                                                <i class="bi bi-facebook"></i>
                                                <span>Facebook</span>
                                            </a>
                                            <a href="#" class="btn btn-social">
                                                <i class="bi bi-apple"></i>
                                                <span>Apple</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="decorative-elements">
                                <div class="circle circle-1"></div>
                                <div class="circle circle-2"></div>
                                <div class="circle circle-3"></div>
                                <div class="square square-1"></div>
                                <div class="square square-2"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    </form>
    <!-- /Register Section -->


@endsection
