@extends('layouts.web')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="hero-container">
            <div class="hero-content">
                <div class="content-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <h1 class="hero-title">Khám phá những sản phẩm mới</h1>
                    <p class="hero-description">Khám phá bộ sưu tập các sản phẩm cao cấp được tuyển chọn kỹ lưỡng của chúng
                        tôi, được thiết kế để nâng tầm phong cách sống của bạn. Từ thời trang đến công nghệ, hãy tìm mọi thứ
                        bạn cần với ưu đãi độc quyền và giao hàng nhanh chóng.
                    </p>
                    <div class="hero-actions" data-aos="fade-up" data-aos-delay="200">
                        <a href="#products" class="btn-primary">Mua Sắm Ngay</a>
                        <a href="#categories" class="btn-secondary">Xem Danh Mục</a>
                    </div>
                    <div class="features-list" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-item">
                            <i class="bi bi-truck"></i>
                            <span>Giao hàng miễn phí</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-award"></i>
                            <span>Đảm bảo chất lượng</span>
                        </div>
                        <div class="feature-item">
                            <i class="bi bi-headset"></i>
                            <span>Hoạt động 24/7</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-visuals">
                <div class="product-showcase" data-aos="fade-left" data-aos-delay="200">
                    <a href="{{ route('product.show', $newProduct->slug) }}">
                        <div class="product-card featured">
                            @if ($newProduct->images->count() > 0)
                                <img src="{{ Storage::url($newProduct->images->first()->name) }}" alt="Featured Product"
                                    class="img-fluid">
                            @else
                                <img src="{{ asset('assets/img/default.png') }}" alt="Featured Product" class="img-fluid">
                            @endif
                            <a href="#0" class="">
                                <div class="product-badge">Sản phẩm mới nhất</div>
                            </a>
                            <div class="product-info">
                                <h4>{{ $newProduct->name }}</h4>
                                <div class="price">
                                    <span class="sale-price">{{ number_format($newProduct->price) }} VND</span>
                                    {{-- <span class="original-price">$399</span> --}}
                                </div>
                            </div>
                        </div>
                    </a>

                    {{-- <div class="product-grid">
                        <div class="product-mini" data-aos="zoom-in" data-aos-delay="400">
                            <img src="assets/img/product/product-3.webp" alt="Product" class="img-fluid">
                            <span class="mini-price">$89</span>
                        </div>
                        <div class="product-mini" data-aos="zoom-in" data-aos-delay="500">
                            <img src="assets/img/product/product-5.webp" alt="Product" class="img-fluid">
                            <span class="mini-price">$149</span>
                        </div>
                    </div> --}}
                </div>

                <div class="floating-elements">
                    <div class="floating-icon cart" data-aos="fade-up" data-aos-delay="600">
                        <i class="bi bi-cart3"></i>
                        <span class="notification-dot">3</span>
                    </div>
                    <div class="floating-icon wishlist" data-aos="fade-up" data-aos-delay="700">
                        <i class="bi bi-heart"></i>
                    </div>
                    <div class="floating-icon search" data-aos="fade-up" data-aos-delay="800">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- Promo Cards Section -->
    {{-- @foreach ($categories as $category) --}}
    <section id="promo-cards" class="promo-cards section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="category-featured" data-aos="fade-right" data-aos-delay="200">
                        <div class="category-image">
                            <img src="{{ Storage::url($categories[0]->image) }}" alt="Women's Collection" class="img-fluid">
                        </div>
                        <div class="category-content">
                            <span class="category-tag">Bộ Sưu Tập Mới Nhất</span>
                            <h2>{{ $categories[0]->name }}</h2>
                            <p>Khám phá những sản phẩm mới nhất của chúng tôi được thiết kế cho phong cách sống hiện đại.
                                Thời trang thanh lịch, thoải mái và bền vững cho mọi dịp..</p>
                            <a href="#" class="btn-shop">Khám phá bộ sưu tập <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="row gy-4">
                        {{-- @foreach ($categories as $category) --}}
                        @for ($i = 0; $i < count($categories) - 1; $i++)
                            <div class="col-xl-6">
                                <div class="category-card cat-men" data-aos="fade-up" data-aos-delay="300">
                                    <div class="category-image">
                                        @if ($categories[$i] != null)
                                            <img src="{{ Storage::url($categories[$i]->image) }}" alt="Men's Fashion"
                                                class="img-fluid">
                                        @else
                                            <img src="{{ asset('assets/img/default.png') }}" alt="Men's Fashion"
                                                class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="category-content">
                                        <h4>{{ $categories[$i]->name }}</h4>
                                        <p>{{ $categories[$i]->total_products }}</p>
                                        <a href="#" class="card-link">Xem Ngay <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        {{-- @endforeach --}}
                    </div>
                </div>

            </div>

        </div>
    </section><!-- /Promo Cards Section -->
    {{-- @endforeach --}}

    <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Sản Phẩm Mới Nhất</h2>
            {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-5">

                <!-- Product 3 -->
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <div class="product-item">
                                <div class="product-image">
                                    @if ($product->images->count() > 0)
                                        <img src="{{ Storage::url($product->images[0]->name) }}"
                                            alt="{{ $product->name }}" class="img-fluid" loading="lazy">
                                    @else
                                        <img src="{{ asset('assets/img/default.png') }}" alt="{{ $product->name }}"
                                            class="img-fluid" loading="lazy">
                                    @endif
                                    <div class="product-actions">
                                        <button class="action-btn wishlist-btn">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <button class="action-btn compare-btn">
                                            <i class="bi bi-arrow-left-right"></i>
                                        </button>
                                        <button class="action-btn quickview-btn">
                                            <i class="bi bi-zoom-in"></i>
                                        </button>
                                    </div>
                                    <button class="cart-btn">Thêm vào giỏ</button>
                                </div>
                                <div class="product-info">
                                    {{-- <div class="product-category">New Arrivals</div> --}}
                                    <h4 class="product-name"><a href="product-details.html">{{ $product->name }}</a></h4>
                                    <div class="product-rating">
                                        <div class="stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <i class="bi bi-star"></i>
                                        </div>
                                        <span class="rating-count">(12)</span>
                                    </div>
                                    <div class="product-price">{{ number_format($product->price) }} VND</div>
                                    {{-- <div class="color-swatches">
                                  <span class="swatch active" style="background-color: #ef4444;"></span>
                                  <span class="swatch" style="background-color: #06b6d4;"></span>
                                  <span class="swatch" style="background-color: #10b981;"></span>
                              </div> --}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <!-- End Product 3 -->

            </div>

        </div>

    </section>
    <!-- /Best Sellers Section -->

    <!-- Cards Section -->
    {{-- <section id="cards" class="cards section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 mb-5 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-category">
                        <h3 class="category-title">
                            <i class="bi bi-fire"></i> Trending Now
                        </h3>
                        <div class="product-list">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-1.webp" alt="Premium Leather Tote"
                                        class="img-fluid">
                                    <div class="product-badges">
                                        <span class="badge-new">New</span>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Premium Leather Tote</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span>(24)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$87.50</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-3.webp" alt="Statement Earrings"
                                        class="img-fluid">
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Statement Earrings</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span>(41)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$39.99</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-5.webp" alt="Organic Cotton Shirt"
                                        class="img-fluid">
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Organic Cotton Shirt</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                        <span>(18)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$45.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                    <div class="product-category">
                        <h3 class="category-title">
                            <i class="bi bi-award"></i> Best Sellers
                        </h3>
                        <div class="product-list">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-2.webp" alt="Slim Fit Denim" class="img-fluid">
                                    <div class="product-badges">
                                        <span class="badge-sale">-15%</span>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Slim Fit Denim</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span>(87)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$68.00</span>
                                        <span class="old-price">$80.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-6.webp" alt="Designer Handbag"
                                        class="img-fluid">
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Designer Handbag</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span>(56)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$129.99</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-8.webp" alt="Leather Crossbody"
                                        class="img-fluid">
                                    <div class="product-badges">
                                        <span class="badge-hot">Hot</span>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Leather Crossbody</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span>(112)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$95.50</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5 mb-md-0" data-aos="fade-up" data-aos-delay="400">
                    <div class="product-category">
                        <h3 class="category-title">
                            <i class="bi bi-star"></i> Featured Items
                        </h3>
                        <div class="product-list">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-7.webp" alt="Pleated Midi Skirt"
                                        class="img-fluid">
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Pleated Midi Skirt</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                        <span>(32)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$75.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-4.webp" alt="Geometric Earrings"
                                        class="img-fluid">
                                    <div class="product-badges">
                                        <span class="badge-limited">Limited</span>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Geometric Earrings</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span>(47)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$42.99</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-image">
                                    <img src="assets/img/product/product-9.webp" alt="Structured Satchel"
                                        class="img-fluid">
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name">Structured Satchel</h4>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span>(64)</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price">$89.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section> --}}
    <!-- /Cards Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="main-content text-center" data-aos="zoom-in" data-aos-delay="200">
                        <div class="offer-badge" data-aos="fade-down" data-aos-delay="250">
                            <span class="limited-time">Limited Time</span>
                            <span class="offer-text">50% OFF</span>
                        </div>

                        <h2 data-aos="fade-up" data-aos-delay="300">Exclusive Flash Sale</h2>

                        <p class="subtitle" data-aos="fade-up" data-aos-delay="350">Don't miss out on our biggest sale of
                            the year. Premium quality products at unbeatable prices for the next 48 hours only.</p>

                        <div class="countdown-wrapper" data-aos="fade-up" data-aos-delay="400">
                            <div class="countdown d-flex justify-content-center" data-count="2025/12/31">
                                <div>
                                    <h3 class="count-days"></h3>
                                    <h4>Days</h4>
                                </div>
                                <div>
                                    <h3 class="count-hours"></h3>
                                    <h4>Hours</h4>
                                </div>
                                <div>
                                    <h3 class="count-minutes"></h3>
                                    <h4>Minutes</h4>
                                </div>
                                <div>
                                    <h3 class="count-seconds"></h3>
                                    <h4>Seconds</h4>
                                </div>
                            </div>
                        </div>

                        <div class="action-buttons" data-aos="fade-up" data-aos-delay="450">
                            <a href="#" class="btn-shop-now">Xem Ngay</a>
                            <a href="#" class="btn-view-deals">View All Deals</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row featured-products-row" data-aos="fade-up" data-aos-delay="500">
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="product-showcase">
                        <div class="product-image">
                            <img src="assets/img/product/product-5.webp" alt="Featured Product" class="img-fluid">
                            <div class="discount-badge">-45%</div>
                        </div>
                        <div class="product-details">
                            <h6>Premium Wireless Headphones</h6>
                            <div class="price-section">
                                <span class="original-price">$129</span>
                                <span class="sale-price">$71</span>
                            </div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="rating-count">(324)</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Product Showcase -->

                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="150">
                    <div class="product-showcase">
                        <div class="product-image">
                            <img src="assets/img/product/product-7.webp" alt="Featured Product" class="img-fluid">
                            <div class="discount-badge">-60%</div>
                        </div>
                        <div class="product-details">
                            <h6>Smart Fitness Tracker</h6>
                            <div class="price-section">
                                <span class="original-price">$89</span>
                                <span class="sale-price">$36</span>
                            </div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="rating-count">(198)</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Product Showcase -->

                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="product-showcase">
                        <div class="product-image">
                            <img src="assets/img/product/product-11.webp" alt="Featured Product" class="img-fluid">
                            <div class="discount-badge">-35%</div>
                        </div>
                        <div class="product-details">
                            <h6>Luxury Travel Backpack</h6>
                            <div class="price-section">
                                <span class="original-price">$159</span>
                                <span class="sale-price">$103</span>
                            </div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="rating-count">(267)</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Product Showcase -->

                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="250">
                    <div class="product-showcase">
                        <div class="product-image">
                            <img src="assets/img/product/product-1.webp" alt="Featured Product" class="img-fluid">
                            <div class="discount-badge">-55%</div>
                        </div>
                        <div class="product-details">
                            <h6>Artisan Coffee Mug Set</h6>
                            <div class="price-section">
                                <span class="original-price">$75</span>
                                <span class="sale-price">$34</span>
                            </div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <span class="rating-count">(142)</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Product Showcase -->
            </div> --}}

        </div>

    </section><!-- /Call To Action Section -->
@endsection
