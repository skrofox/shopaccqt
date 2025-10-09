@extends('layouts.web')

@section('title', $product->name)


@section('content')

    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Mua Sản Phẩm</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Chi tiết sản Phẩm</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Product Details Section -->
    <section id="product-details" class="product-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-4">
                <!-- Product Gallery -->
                <div class="col-lg-7" data-aos="zoom-in" data-aos-delay="150">
                    <div class="product-gallery">
                        <div class="main-showcase">
                            <div class="image-zoom-container">
                                @if ($product->images?->count() > 0)
                                    <img src="{{ Storage::url($product->images[0]->name) }}" alt="Product Main"
                                        class="img-fluid main-product-image drift-zoom" id="main-product-image"
                                        data-zoom="{{ Storage::url($product->images[0]->name) }}">
                                @else
                                    <img src="{{ asset('assets/img/default.png') }}" alt="Product Main"
                                        class="img-fluid main-product-image drift-zoom" id="main-product-image">
                                @endif

                                <div class="image-navigation">
                                    <button class="nav-arrow prev-image image-nav-btn prev-image" type="button">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button class="nav-arrow next-image image-nav-btn next-image" type="button">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="thumbnail-grid">
                            @if ($product->images->count() > 0)
                                @foreach ($product->images as $image)
                                    <div class="thumbnail-wrapper thumbnail-item active"
                                        data-image="{{ Storage::url($image->name) }}">
                                        <img src="{{ Storage::url($image->name) }}" alt="View 1" class="img-fluid">
                                    </div>
                                @endforeach
                            @else
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                    <div class="product-details">
                        <div class="product-badge-container">
                            <span class="badge-category">{{ $product->category->name }}</span>
                            <div class="rating-group">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="review-text">( {{ $totalReviews }} reviews)</span>
                            </div>
                        </div>

                        <h1 class="product-name">{{ $product->name }}</h1>

                        <div class="pricing-section">
                            <div class="price-display">
                                <span class="sale-price">{{ number_format($product->price) }} VND</span>
                                {{-- <span class="regular-price">$239.99</span> --}}
                            </div>
                            {{-- <div class="savings-info">
                  <span class="save-amount">Save $50.00</span>
                  <span class="discount-percent">(21% off)</span>
                </div> --}}
                        </div>

                        <div class="product-description">
                            <p>{{ $product->description }}</p>
                        </div>

                        @if ($product->stocks?->on_hand != null)
                            <div class="availability-status">
                                <div class="stock-indicator">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span class="stock-text">Có sẵn</span>
                                </div>
                                <div class="quantity-left">Hiện có {{ $product->stocks->on_hand }} sản phẩm</div>
                            </div>
                        @else
                            <div class="availability-status" style="border: 1px solid red; background: #fff;">
                                <div class="stock-indicator" style="background-color: #fff;">
                                    <i class="bi bi-ban" style="color: red"></i>
                                    <span class="stock-text">Không Có sẵn</span>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="availability-status" style="border: 1px solid red; background: #fff;">
                                <div class="stock-indicator" style="background-color: #fff;">
                                    <i class="bi bi-ban" style="color: red"></i>
                                    <span class="stock-text">Không thêm được sản phẩm vào giỏ:
                                        {{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="availability-status">
                                <div class="stock-indicator">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span class="stock-text">Đã thêm sản phẩm vào giỏ</span>
                                </div>
                                {{-- <div class="quantity-left">Đã thêm sản phẩm vào giỏ</div> --}}
                            </div>
                        @endif

                        <!-- Product Variants -->
                        {{-- <div class="variant-section">
                            <div class="color-selection">
                                <label class="variant-label">Available Colors:</label>
                                <div class="color-grid">
                                    <div class="color-chip active" data-color="Midnight Black"
                                        style="background: linear-gradient(135deg, #1a1a1a, #000);">
                                        <span class="selection-check"><i class="bi bi-check"></i></span>
                                    </div>
                                    <div class="color-chip" data-color="Pearl White"
                                        style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                                        <span class="selection-check"><i class="bi bi-check"></i></span>
                                    </div>
                                    <div class="color-chip" data-color="Ocean Blue"
                                        style="background: linear-gradient(135deg, #0066cc, #004499);">
                                        <span class="selection-check"><i class="bi bi-check"></i></span>
                                    </div>
                                    <div class="color-chip" data-color="Forest Green"
                                        style="background: linear-gradient(135deg, #28a745, #155724);">
                                        <span class="selection-check"><i class="bi bi-check"></i></span>
                                    </div>
                                </div>
                                <div class="selected-variant">Selected: <span>Midnight Black</span></div>
                            </div>
                        </div> --}}

                        <!-- Purchase Options -->


                        @if ($product->stocks?->on_hand != null)
                            <form action="{{ route('cart.action') }}" method="post">
                                @csrf
                                <div class="purchase-section">
                                    <div class="quantity-control">
                                        <label class="control-label">Số Lượng:</label>
                                        <div class="quantity-input-group">
                                            <div class="quantity-selector">
                                                <button class="quantity-btn decrease" type="button">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" class="quantity-input" value="1" min="1"
                                                    max="{{ $product->stocks->on_hand }}" name="quantity">
                                                <button class="quantity-btn increase" type="button">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="action-buttons" type="submit" name="action">
                                        @auth
                                            <button class="btn primary-action" type="submit">
                                                <i class="bi bi-bag-plus"></i>
                                                Thêm Vào Giỏ
                                            </button>
                                            {{-- <button class="btn secondary-action" type="submit" name="action">
                                                <i class="bi bi-lightning"></i>
                                                Mua Ngay
                                            </button> --}}
                                            <button class="btn icon-action" title="Add to Wishlist" type="submit"
                                                name="action">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        @endauth
                                        @guest
                                            <form action="{{ route('login') }}" method="post">
                                                @csrf
                                                <button class="btn primary-action" type="submit">
                                                    <i class="bi bi-bag-plus"></i>
                                                    Đăng nhập để mua hàng
                                                </button>
                                            </form>
                                        @endguest
                                    </div>
                                </div>
                            </form>
                        @else
                        @endif

                        <!-- Benefits List -->
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <i class="bi bi-truck"></i>
                                <span>Giao hàng miễn phí cho đơn hàng trên 500 nghìn đồng</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span>Trả hàng dễ dàng trong 45 ngày</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Bảo hành 3 năm của nhà sản xuất</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-headset"></i>
                                <span>Hỗ trợ khách hàng 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Tabs -->
            <div class="row mt-5" data-aos="fade-up" data-aos-delay="300">
                <div class="col-12">
                    <div class="info-tabs-container">
                        <nav class="tabs-navigation nav">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#ecommerce-product-details-5-overview" type="button">Tổng quát</button>
                            {{-- <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#ecommerce-product-details-5-technical" type="button">Technical
                                Details</button> --}}
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#ecommerce-product-details-5-customer-reviews" type="button">Đánh giá /
                                Bình luận
                                ({{ $totalReviews }})</button>
                        </nav>

                        <div class="tab-content">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="ecommerce-product-details-5-overview">
                                <div class="overview-content">
                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            <div class="content-section">
                                                <h3>Tổng quan về sản phẩm</h3>
                                                <p>{{ $product->description }}.</p>

                                                {{-- <h4>Điểm Nổi Bật</h4>
                                                <div class="highlights-grid">
                                                    <div class="highlight-card">
                                                        <i class="bi bi-volume-up"></i>
                                                        <h5>Superior Audio</h5>
                                                        <p>Ut enim ad minima veniam quis nostrum exercitationem</p>
                                                    </div>
                                                    <div class="highlight-card">
                                                        <i class="bi bi-battery-charging"></i>
                                                        <h5>Long Battery</h5>
                                                        <p>Excepteur sint occaecat cupidatat non proident</p>
                                                    </div>
                                                    <div class="highlight-card">
                                                        <i class="bi bi-wifi"></i>
                                                        <h5>Wireless Tech</h5>
                                                        <p>Duis aute irure dolor in reprehenderit in voluptate</p>
                                                    </div>
                                                    <div class="highlight-card">
                                                        <i class="bi bi-person-check"></i>
                                                        <h5>Comfort Fit</h5>
                                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing</p>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-4">
                                            <div class="package-contents">
                                                <h4>Package Contents</h4>
                                                <ul class="contents-list">
                                                    <li><i class="bi bi-check-circle"></i>Premium Audio Device</li>
                                                    <li><i class="bi bi-check-circle"></i>Premium Carrying Case</li>
                                                    <li><i class="bi bi-check-circle"></i>USB-C Fast Charging Cable</li>
                                                    <li><i class="bi bi-check-circle"></i>3.5mm Audio Connector</li>
                                                    <li><i class="bi bi-check-circle"></i>Quick Start Guide</li>
                                                    <li><i class="bi bi-check-circle"></i>Warranty Documentation</li>
                                                </ul>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>

                            <!-- Technical Details Tab -->
                            {{-- <div class="tab-pane fade" id="ecommerce-product-details-5-technical">
                                <div class="technical-content">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="tech-group">
                                                <h4>Audio Specifications</h4>
                                                <div class="spec-table">
                                                    <div class="spec-row">
                                                        <span class="spec-name">Frequency Range</span>
                                                        <span class="spec-value">15Hz - 25kHz</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Driver Diameter</span>
                                                        <span class="spec-value">50mm Dynamic</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Sensitivity</span>
                                                        <span class="spec-value">98dB SPL</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Impedance</span>
                                                        <span class="spec-value">24 Ohm</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">THD</span>
                                                        <span class="spec-value">&lt; 0.5%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="tech-group">
                                                <h4>Connectivity &amp; Power</h4>
                                                <div class="spec-table">
                                                    <div class="spec-row">
                                                        <span class="spec-name">Wireless Protocol</span>
                                                        <span class="spec-value">Bluetooth 5.3</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Range</span>
                                                        <span class="spec-value">Up to 30ft (10m)</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Battery Capacity</span>
                                                        <span class="spec-value">800mAh Li-ion</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Usage Time</span>
                                                        <span class="spec-value">35+ hours</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Charge Time</span>
                                                        <span class="spec-value">2.5 hours</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="tech-group">
                                                <h4>Physical Dimensions</h4>
                                                <div class="spec-table">
                                                    <div class="spec-row">
                                                        <span class="spec-name">Weight</span>
                                                        <span class="spec-value">285g</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Dimensions</span>
                                                        <span class="spec-value">190 x 165 x 82mm</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Ear Cup Material</span>
                                                        <span class="spec-value">Memory Foam</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Headband</span>
                                                        <span class="spec-value">Adjustable Steel</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="tech-group">
                                                <h4>Advanced Features</h4>
                                                <div class="spec-table">
                                                    <div class="spec-row">
                                                        <span class="spec-name">Noise Cancellation</span>
                                                        <span class="spec-value">Hybrid ANC</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Voice Assistant</span>
                                                        <span class="spec-value">Siri &amp; Google</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Microphone Type</span>
                                                        <span class="spec-value">Dual Array</span>
                                                    </div>
                                                    <div class="spec-row">
                                                        <span class="spec-name">Water Rating</span>
                                                        <span class="spec-value">IPX5</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Reviews Tab -->
                            <div class="tab-pane fade" id="ecommerce-product-details-5-customer-reviews">
                                <div class="reviews-content">
                                    <div class="reviews-header">
                                        <div class="rating-overview">
                                            {{-- <div class="average-score">
                                                <div class="score-display">4.6</div>
                                                <div class="score-stars">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div>
                                                <div class="total-reviews">{{ $reviews->count() }} người dùng đã đánh giá
                                                </div>
                                            </div>

                                            <div class="rating-distribution">
                                                <div class="rating-row">
                                                    <span class="stars-label">5★</span>
                                                    <div class="progress-container">
                                                        <div class="progress-fill" style="width: 68%;"></div>
                                                    </div>
                                                    <span class="count-label">86</span>
                                                </div>
                                                <div class="rating-row">
                                                    <span class="stars-label">4★</span>
                                                    <div class="progress-container">
                                                        <div class="progress-fill" style="width: 22%;"></div>
                                                    </div>
                                                    <span class="count-label">28</span>
                                                </div>
                                                <div class="rating-row">
                                                    <span class="stars-label">3★</span>
                                                    <div class="progress-container">
                                                        <div class="progress-fill" style="width: 6%;"></div>
                                                    </div>
                                                    <span class="count-label">8</span>
                                                </div>
                                                <div class="rating-row">
                                                    <span class="stars-label">2★</span>
                                                    <div class="progress-container">
                                                        <div class="progress-fill" style="width: 3%;"></div>
                                                    </div>
                                                    <span class="count-label">4</span>
                                                </div>
                                                <div class="rating-row">
                                                    <span class="stars-label">1★</span>
                                                    <div class="progress-container">
                                                        <div class="progress-fill" style="width: 1%;"></div>
                                                    </div>
                                                    <span class="count-label">1</span>
                                                </div>
                                            </div> --}}
                                            <div class="average-score">
                                                <div class="score-display">{{ $averageRating }}.0 <i
                                                        class="bi bi-star-fill" style="color: #ffd700"></i></div>
                                                <div class="score-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($averageRating >= $i)
                                                            <i class="bi bi-star-fill"></i>
                                                        @elseif ($averageRating >= $i - 0.5)
                                                            <i class="bi bi-star-half"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="total-reviews">{{ $totalReviews }} người dùng đã đánh giá
                                                </div>
                                            </div>

                                            <div class="rating-distribution">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <div class="rating-row">
                                                        <span class="stars-label">{{ $i }}★</span>
                                                        <div class="progress-container">
                                                            <div class="progress-fill"
                                                                style="width: {{ $ratingPercents[$i] }}%;"></div>
                                                        </div>
                                                        <span class="count-label">{{ $ratingCounts[$i] }}</span>
                                                    </div>
                                                @endfor
                                            </div>

                                        </div>

                                        <div class="write-review-cta">
                                            <h4>Bạn muốn chia sẻ ý kiến?</h4>
                                            <p>Mua hàng để chia sẻ ý kiến của bạn!</p>
                                            <button class="btn review-btn">Mua ngay</button>
                                        </div>
                                    </div>

                                    <div class="customer-reviews-list">
                                        @foreach ($reviews as $review)
                                            <div class="review-card">
                                                <div class="reviewer-profile">
                                                    <img src="assets/img/person/person-f-3.webp" alt="Customer"
                                                        class="profile-pic">
                                                    <div class="profile-details">
                                                        <div class="customer-name" style="display: flex">{{ $review->user->name }} - <p style="color:green">(Đã mua)</p></div>
                                                        <div class="review-meta">
                                                            <div class="review-stars">
                                                                @for ($i = 0; $i < $review->rating; $i++)
                                                                    <i class="bi bi-star-fill"></i>
                                                                @endfor
                                                            </div>
                                                            </br>
                                                            <span class="review-date">{{ $review->created_at }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <h5 class="review-headline">Outstanding audio quality and comfort</h5> --}}
                                                <div class="review-text">
                                                    <p>{{ $review->content }}.</p>
                                                </div>
                                                <div class="review-actions">
                                                    <form action="{{ route('helpful', $review->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="action-btn" type="submit"><i class="bi bi-hand-thumbs-up"></i>
                                                            Hữu ích
                                                            ({{ $review->helpful_vote }})
                                                        </button>
                                                    </form>
                                                    {{-- <button class="action-btn"><i class="bi bi-chat-dots"></i>
                                                        Reply</button> --}}
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="load-more-section">
                                            <button class="btn load-more-reviews">Show More Reviews</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- /Product Details Section -->


@endsection
