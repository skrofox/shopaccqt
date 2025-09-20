@extends('layouts.web')

@section('title', 'Kết quả tìm kiếm')

@section('content')

    <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kết quả tìm kiếm cho "{{ $query }}"</h2>
            {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-5">
                <!-- Product 3 -->
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6">
                        <a href="">
                            <div class="product-product">
                                <div class="product-image">
                                    <img src="{{ Storage::url($product->images[0]->name) }}" alt="{{ $product->slug }}"
                                        class="img-fluid" loading="lazy">
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
                                    <button class="cart-btn">Add to Cart</button>
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

    </section><!-- /Best Sellers Section -->

@endsection
