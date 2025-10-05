@extends('layouts.web')

@section('title', 'Thanh Toán')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Checkout</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Checkout</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6><strong>Có lỗi xảy ra:</strong></h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-7">
                    <!-- Checkout Form -->
                    <div class="checkout-container" data-aos="fade-up">
                        <form class="" action="{{ route('checkout.store') }}" method="POST">
                            @csrf

                            <!-- Customer Information -->
                            @foreach ($user->infos as $info)
                                <div class="checkout-section" id="customer-info">
                                    <div class="section-header">
                                        <div class="section-number">1</div>
                                        <h3>Thông tin khách hàng</h3>
                                    </div>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="first-name">Tên Khách Hàng <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror" id="first-name"
                                                    placeholder="Nhập tên khách hàng" required
                                                    value="{{ old('name', Auth::user()->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Your Email" value="{{ Auth::user()->email }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" placeholder="Nhập số điện thoại (VD: 0987654321)" required
                                                value="{{ old('phone', $info->phone) }}"
                                                title="Số điện thoại phải có 10-11 chữ số">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Address -->
                                <div class="checkout-section" id="shipping-address">
                                    <div class="section-header">
                                        <div class="section-number">2</div>
                                        <h3>Địa chỉ giao hàng</h3>
                                    </div>
                                    <div class="section-content">
                                        <div class="form-group">
                                            <label for="address">Địa chỉ <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror" name="address"
                                                id="address"
                                                placeholder="Nhập địa chỉ đầy đủ (số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố)"
                                                required value="{{ old('address', $info->address) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <select name="choose_address" >
                                                <option value="0">Chọn địa chỉ có sẵn</option>
                                                <option value="">{{$info->address . ' - ' . $info->phone}}</option>
                                            </select>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="billing-same"
                                                name="save_address" value="1"
                                                {{ old('save_address') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="billing-same">
                                                Lưu địa chỉ này cho đơn hàng sau
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <!-- Payment Method -->
                            <div class="checkout-section" id="payment-method">
                                <div class="section-header">
                                    <div class="section-number">3</div>
                                    <h3>Phương thức thanh toán</h3>
                                </div>
                                <div class="section-content">
                                    <div class="payment-options">
                                        <div
                                            class="payment-option {{ old('payment_method', 'cod') == 'cod' ? 'active' : '' }}">
                                            <input type="radio" name="payment_method" id="credit-card" value="cod"
                                                {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                            <label for="credit-card">
                                                <span class="payment-icon"><i
                                                        class="bi bi-credit-card-2-front"></i></span>
                                                <span class="payment-label">Thanh toán khi nhận hàng (COD)</span>
                                            </label>
                                        </div>
                                        <div class="payment-option {{ old('payment_method') == 'ck' ? 'active' : '' }}">
                                            <input type="radio" name="payment_method" id="paypal" value="ck"
                                                {{ old('payment_method') == 'ck' ? 'checked' : '' }}>
                                            <label for="paypal">
                                                <span class="payment-icon"><i class="bi bi-paypal"></i></span>
                                                <span class="payment-label">Chuyển khoản ngân hàng</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror

                                    <!-- Thông tin chuyển khoản (hiện khi chọn chuyển khoản) -->
                                    <div class="payment-details {{ old('payment_method') == 'ck' ? '' : 'd-none' }}"
                                        id="bank-transfer-details">
                                        <div class="alert alert-info mt-3">
                                            <h6><strong>Thông tin chuyển khoản:</strong></h6>
                                            <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                                            <p class="mb-1"><strong>Số tài khoản:</strong> 1234567890</p>
                                            <p class="mb-1"><strong>Chủ tài khoản:</strong> SHOP ABC</p>
                                            <p class="mb-0"><strong>Nội dung:</strong> Thanh toan don hang [Mã đơn hàng]
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Review -->
                            <div class="checkout-section" id="order-review">
                                <div class="section-header">
                                    <div class="section-number">4</div>
                                    <h3>Xác nhận đơn hàng</h3>
                                </div>
                                <div class="section-content">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input @error('agree_terms') is-invalid @enderror"
                                            type="checkbox" id="agree-terms" name="agree_terms" value="1" required
                                            {{ old('agree_terms') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="agree-terms">
                                            Tôi đồng ý với <a href="#" target="_blank">điều khoản dịch vụ</a> và <a
                                                href="#" target="_blank">chính sách bảo mật</a> <span
                                                class="text-danger">*</span>
                                        </label>
                                        @error('agree_terms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="place-order-container">
                                        <button type="submit" class="btn btn-primary place-order-btn w-100"
                                            id="place-order-btn">
                                            <span class="btn-text">Đặt hàng</span>
                                            <span class="btn-price">{{ number_format($carts->sum('total_price')) }}
                                                VNĐ</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <!-- Order Summary -->
                    <div class="order-summary" data-aos="fade-left" data-aos-delay="200">
                        <div class="order-summary-header">
                            <h3>Tóm tắt đơn hàng</h3>
                            <span class="item-count">{{ $carts->count() }} sản phẩm</span>
                        </div>

                        <div class="order-summary-content">
                            <div class="order-items">
                                @foreach ($carts as $cart)
                                    <div class="order-item">
                                        <div class="order-item-image">
                                            @if ($cart->product->images->count() > 0)
                                                <img src="{{ Storage::url($cart->product->images->first()->name) }}"
                                                    alt="{{ $cart->product->name }}" class="img-fluid" loading="lazy">
                                            @else
                                                <img src="{{ asset('assets/img/default.png') }}"
                                                    alt="{{ $cart->product->name }}" class="img-fluid" loading="lazy">
                                            @endif
                                        </div>
                                        <div class="order-item-details">
                                            <h4>{{ $cart->product->name }}</h4>
                                            <div class="order-item-price">
                                                <span class="quantity">{{ $cart->quantity }} ×</span>
                                                <span class="price">{{ number_format($cart->product->price) }} VNĐ</span>
                                            </div>
                                            <div class="order-item-total">
                                                <strong>{{ number_format($cart->total_price) }} VNĐ</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="promo-code">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Mã giảm giá"
                                        aria-label="Promo Code">
                                    <button class="btn btn-outline-secondary" type="button">Áp dụng</button>
                                </div>
                            </div>

                            <div class="order-totals">
                                <div class="order-subtotal d-flex justify-content-between">
                                    <span>Tạm tính</span>
                                    <span>{{ number_format($carts->sum('total_price')) }} VNĐ</span>
                                </div>
                                <div class="order-shipping d-flex justify-content-between">
                                    <span>Phí vận chuyển</span>
                                    <span>Miễn phí</span>
                                </div>
                                <div class="order-tax d-flex justify-content-between">
                                    <span>Giảm giá</span>
                                    <span>0 VNĐ</span>
                                </div>
                                <hr>
                                <div class="order-total d-flex justify-content-between">
                                    <strong>Tổng tiền</strong>
                                    <strong class="summary-value">{{ number_format($carts->sum('total_price')) }}
                                        VNĐ</strong>
                                </div>
                            </div>

                            <div class="secure-checkout">
                                <div class="secure-checkout-header">
                                    <i class="bi bi-shield-lock"></i>
                                    <span>Thanh toán bảo mật</span>
                                </div>
                                <div class="payment-icons">
                                    <i class="bi bi-credit-card-2-front"></i>
                                    <i class="bi bi-credit-card"></i>
                                    <i class="bi bi-paypal"></i>
                                    <i class="bi bi-bank"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Checkout Section -->

    <!-- JavaScript để xử lý payment method -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
            const bankDetails = document.getElementById('bank-transfer-details');

            paymentOptions.forEach(option => {
                option.addEventListener('change', function() {
                    // Remove active class from all options
                    document.querySelectorAll('.payment-option').forEach(opt => opt.classList
                        .remove('active'));

                    // Add active class to selected option
                    this.closest('.payment-option').classList.add('active');

                    // Show/hide bank transfer details
                    if (this.value === 'ck') {
                        bankDetails.classList.remove('d-none');
                    } else {
                        bankDetails.classList.add('d-none');
                    }
                });
            });

            // Prevent double submission
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('place-order-btn');

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
            });
        });
    </script>

    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .payment-option.active {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .order-item-total {
            margin-top: 5px;
            font-weight: 500;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endsection
