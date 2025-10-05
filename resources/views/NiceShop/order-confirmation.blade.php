@extends('layouts.web')

@section('title', 'Đơn Hàng')

@section('content')


    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Xem Lại Đơn Hàng</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="current">Xem lại đơn hàng</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Order Confirmation Section -->
    <section id="order-confirmation" class="order-confirmation section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="order-confirmation-3">
                <div class="row g-0">
                    <!-- Left sidebar with order summary -->
                    <div class="col-lg-4 sidebar" data-aos="fade-right">
                        <div class="sidebar-content">
                            <!-- Success animation -->
                            <div class="success-animation">
                                <i class="bi bi-check-lg"></i>
                            </div>

                            <!-- Order number and date -->
                            <div class="order-id">
                                <h4>Mã Đơn Hàng </br> #{{ $order_code }}</h4>
                            
                                <div class="order-date">{{ $orders->first()->created_at }}</div>
                            </div>

                            <!-- Order progress stepper -->
                            <div class="order-progress">
                                <div class="stepper-container">
                                    <div class="stepper-item completed">
                                        <div class="stepper-icon">1</div>
                                        <div class="stepper-text">Xác Nhận Đặt Hàng</div>
                                    </div>
                                    <div class="stepper-item current">
                                        <div class="stepper-icon">2</div>
                                        <div class="stepper-text">Đang chờ xử lý</div>
                                    </div>
                                    <div class="stepper-item">
                                        <div class="stepper-icon">3</div>
                                        <div class="stepper-text">Đã gửi</div>
                                    </div>
                                    <div class="stepper-item">
                                        <div class="stepper-icon">4</div>
                                        <div class="stepper-text">Đã giao hàng</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price summary -->
                            <div class="price-summary">
                                <h5>Tóm Tắt Đơn Hàng</h5>
                                <ul class="summary-list">
                                    <li>
                                        <span>Tổng phụ</span>
                                        <span>{{ number_format($orders->sum('total_price')) }}đ</span>
                                    </li>
                                    <li>
                                        <span>Vận chuyển</span>
                                        <span>$0.00</span>
                                    </li>
                                    <li>
                                        <span>Thuế</span>
                                        <span>$0.00</span>
                                    </li>
                                    <li class="total">
                                        <span>Tổng</span>
                                        <span>{{ number_format($orders->sum('total_price')) }}đ</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Delivery info -->
                            <div class="delivery-info">
                                <h5>Thông tin vận chuyển</h5>
                                <p class="delivery-estimate">
                                    <i class="bi bi-calendar-check"></i>
                                    <span>Dự kiến: 3 - 5 ngày kể từ ngày đặt hàng</span>
                                </p>
                                <p class="shipping-method">
                                    <i class="bi bi-truck"></i>
                                    <span>Miễn phí vận chuyển</span>
                                </p>
                            </div>

                            <!-- Customer service -->
                            <div class="customer-service">
                                <h5>Cần giúp đỡ?</h5>
                                <a href="#" class="help-link">
                                    <i class="bi bi-chat-dots"></i>
                                    <span>Liên hệ hỗ trợ</span>
                                </a>
                                <a href="#" class="help-link">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Hỏi Đáp</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Main content area -->
                    <div class="col-lg-8 main-content" data-aos="fade-in">
                        <!-- Thank you message -->
                        <div class="thank-you-message">
                            <h1>Cảm ơn bạn đã đặt hàng!</h1>
                            <p>Chúng tôi đã nhận được đơn hàng của bạn và sẽ bắt đầu xử lý ngay. Chúng tôi sẽ gửi cho
                                bạn
                                thông tin cập nhật qua email khi đơn hàng của bạn được xử lý.</p>
                        </div>

                        <!-- Shipping details -->
                        @foreach ($user->infos as $info)
                            <div class="details-card" data-aos="fade-up">
                                <div class="card-header" data-toggle="collapse">
                                    <h3>
                                        <i class="bi bi-geo-alt"></i>
                                        Chi tiết vận chuyển
                                    </h3>
                                    <i class="bi bi-chevron-down toggle-icon"></i>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="detail-group">
                                                <label>Chuyển đến</label>
                                                <address>
                                                    {{ Auth::user()->name }}<br>
                                                    {{ $info->address }}<br>
                                                    {{-- Seattle, WA 98101<br> --}}
                                                    Việt Nam
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-group">
                                                <label>Liên hệ</label>
                                                <div class="contact-info">
                                                    <p><i class="bi bi-envelope"></i> {{ Auth::user()->email }}</p>
                                                    <p><i class="bi bi-telephone"></i> {{ $info->phone }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment details -->
                            <div class="details-card" data-aos="fade-up">
                                <div class="card-header" data-toggle="collapse">
                                    <h3>
                                        <i class="bi bi-credit-card"></i>
                                        Chi tiết thanh toán
                                    </h3>
                                    <i class="bi bi-chevron-down toggle-icon"></i>
                                </div>
                                <div class="card-body">
                                    <div class="payment-method">
                                        <div class="payment-icon">
                                            <i class="bi bi-credit-card-2-front"></i>
                                        </div>
                                        {{-- <div class="payment-details">
                                            <div class="card-type">American Express</div>
                                            <div class="card-number">•••• •••• •••• 3782</div>
                                        </div> --}}
                                        <div class="billing-address mt-4">
                                            <h5>Thanh toán</h5>
                                            <p>{{ $orders->first()->payment_method }}</p>
                                        </div>
                                    </div>
                                    {{-- <div class="billing-address mt-4">
                                        <h5>Billing Address</h5>
                                        <p>Same as shipping address</p>
                                    </div> --}}
                                </div>
                            </div>
                        @endforeach


                        <!-- Order items -->
                        <div class="details-card" data-aos="fade-up">
                            <div class=" card-header" data-toggle="collapse">
                                <h3>
                                    <i class="bi bi-bag-check"></i>
                                    Danh sách đặt hàng
                                </h3>
                                <i class="bi bi-chevron-down toggle-icon"></i>
                            </div>
                            <div class="card-body">
                                @foreach ($orders as $order)
                                <a href="{{ route('product.show', $order->product->slug) }}">
                                  <div class="item">
                                      <div class="item-image">
                                          <img src="{{ Storage::url($order->product->images->first()->name ?? 'default.png') }}"
                                              alt="Product" loading="lazy">
                                      </div>
                                      <div class="item-details">
                                          <h4>{{$order->product->name}}</h4>
                                          {{-- <div class="item-meta">
                                              <span>Color: Navy Blue</span>
                                          </div> --}}
                                          <div class="item-price">
                                              <span class="quantity">{{ $order->quantity }} ×</span>
                                              <span class="price">{{ number_format($order->product->price) }}</span>
                                          </div>
                                      </div>
                                  </div>
                                </a>
                                @endforeach

                                {{-- <div class="item">
                                    <div class="item-image">
                                        <img src="assets/img/product/product-9.webp" alt="Product" loading="lazy">
                                    </div>
                                    <div class="item-details">
                                        <h4>Smart Fitness Tracker</h4>
                                        <div class="item-meta">
                                            <span>Color: Black</span>
                                            <span>Size: Medium</span>
                                        </div>
                                        <div class="item-price">
                                            <span class="quantity">1 ×</span>
                                            <span class="price">$89.98</span>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="action-area" data-aos="fade-up">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('home') }}" class="btn btn-back">
                                        <i class="bi bi-arrow-left"></i>
                                        Trở về trang chủ
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('account') }}" class="btn btn-account">
                                        <span>Xem trong tài khoản</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Recommended products -->
                        <div class="recommended" data-aos="fade-up">
                            <h3>Có lẽ bạn cũng thích</h3>
                            {{-- <div class="row g-4">
                                <div class="col-6 col-md-4">
                                    <div class="product-card">
                                        <div class="product-image">
                                            <img src="assets/img/product/product-11.webp" alt="Product" loading="lazy">
                                        </div>
                                        <h5>Wireless Earbuds</h5>
                                        <div class="product-price">$59.99</div>
                                        <a href="#" class="btn btn-add-cart">
                                            <i class="bi bi-plus"></i>
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="product-card">
                                        <div class="product-image">
                                            <img src="assets/img/product/product-10.webp" alt="Product" loading="lazy">
                                        </div>
                                        <h5>Portable Phone Charger</h5>
                                        <div class="product-price">$34.99</div>
                                        <a href="#" class="btn btn-add-cart">
                                            <i class="bi bi-plus"></i>
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 d-none d-md-block">
                                    <div class="product-card">
                                        <div class="product-image">
                                            <img src="assets/img/product/product-8.webp" alt="Product" loading="lazy">
                                        </div>
                                        <h5>Smart Watch</h5>
                                        <div class="product-price">$149.99</div>
                                        <a href="#" class="btn btn-add-cart">
                                            <i class="bi bi-plus"></i>
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Order Confirmation Section -->


@endsection
