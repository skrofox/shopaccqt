@extends('layouts.web')

@section('title', 'Giỏ hàng')

@section('content')


    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Giỏ Hàng</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Cart Section -->
    <section id="cart" class="cart section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($carts as $cart)
                        <div class="cart-items">
                            <div class="cart-header d-none d-lg-block">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <h5>Sản phẩm</h5>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <h5>Giá</h5>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <h5>Số lượng</h5>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <h5>Tổng tiền</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-12 mt-3 mt-lg-0 mb-lg-0 mb-3">
                                        <div class="product-info d-flex align-items-center">
                                            <div class="product-image">
                                                @if ($cart->product->images->count() > 0)
                                                    <img src="{{ Storage::url($cart->product->images->first()->name) }}"
                                                        alt="Product" class="img-fluid" loading="lazy">
                                                @else
                                                    <img src="{{ asset('assets/img/default.png') }}" alt="Product"
                                                        class="img-fluid" loading="lazy">
                                                @endif
                                            </div>
                                            <div class="product-details">
                                                <a href="{{ route('product.show', $cart->product->slug) }}">
                                                    <h6 class="product-title">{{ $cart->product->name }}</h6>
                                                </a>
                                                <form action="{{ route('cart.remove', $cart->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#0"
                                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                                        class="remove-item">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                                        <div class="price-tag">
                                            <span class="current-price">{{ number_format($cart->product->price) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                                        <div class="quantity-selector">
                                            <button class="quantity-btn decrease" data-id="{{ $cart->id }}">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" class="quantity-input" value="{{ $cart->quantity }}"
                                                min="{{ $cart->quantity }}" max="{{ $cart->product->stocks->on_hand }}"
                                                data-id="{{ $cart->id }}">
                                            <button class="quantity-btn increase" data-id="{{ $cart->id }}">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-12 mt-3 mt-lg-0 text-center">
                                        <div class="item-total">
                                            <span
                                                id="item-total-{{ $cart->id }}">{{ number_format($cart->total_price) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="cart-actions">
                                <div class="row">
                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                        <div class="coupon-form">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Coupon code">
                                                <button class="btn btn-outline-accent" type="button">Apply
                                                    Coupon</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 text-md-end">
                                        <button class="btn btn-outline-heading me-2">
                                            <i class="bi bi-arrow-clockwise"></i> Update Cart
                                        </button>
                                        <button class="btn btn-outline-remove">
                                            <i class="bi bi-trash"></i> Clear Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                    <div class="cart-summary">
                        <h4 class="summary-title">Danh sách giỏ hàng</h4>

                        <div class="summary-item">
                            <span class="summary-label">Tổng tiền sản phẩm</span>
                            <span class="summary-value">{{ number_format($carts->sum('total_price')) }}</span>
                        </div>

                        {{-- <div class="summary-item shipping-item">
                            <span class="summary-label">Shipping</span>
                            <div class="shipping-options">
                                <div class="form-check text-end">
                                    <input class="form-check-input" type="radio" name="shipping" id="standard" checked="">
                                    <label class="form-check-label" for="standard">
                                        Standard Delivery - $4.99
                                    </label>
                                </div>
                                <div class="form-check text-end">
                                    <input class="form-check-input" type="radio" name="shipping" id="express">
                                    <label class="form-check-label" for="express">
                                        Express Delivery - $12.99
                                    </label>
                                </div>
                                <div class="form-check text-end">
                                    <input class="form-check-input" type="radio" name="shipping" id="free">
                                    <label class="form-check-label" for="free">
                                        Free Shipping (Orders over $300)
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="summary-item">
                            <span class="summary-label">Tax</span>
                            <span class="summary-value">$27.00</span>
                        </div> --}}

                        <div class="summary-item discount">
                            <span class="summary-label">Giảm giá</span>
                            <span class="summary-value">-$0.00</span>
                        </div>

                        <div class="summary-total">
                            <span class="summary-label">Tổng tiền</span>
                            <span class="summary-value">{{ number_format($carts->sum('total_price')) }} VND</span>
                        </div>

                        <div class="checkout-button">
                            <a href="{{ route('checkout') }}" class="btn btn-accent w-100">
                                Thanh Toán <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        <div class="continue-shopping">
                            <a href="{{ route('home') }}" class="btn btn-link w-100">
                                <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                            </a>
                        </div>

                        <div class="payment-methods">
                            <p class="payment-title">We Accept</p>
                            <div class="payment-icons">
                                <i class="bi bi-credit-card"></i>
                                <i class="bi bi-paypal"></i>
                                <i class="bi bi-wallet2"></i>
                                <i class="bi bi-bank"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Cart Section -->
    <script></script>
@endsection
