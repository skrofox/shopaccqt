@extends('layouts.web')

@section('title', 'Tài Khoản')


@section('content')




    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Tài khoản</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="current">Tài khoản</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Account Section -->
    <section id="account" class="account section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- Mobile Menu Toggle -->
            <div class="mobile-menu d-lg-none mb-4">
                <button class="mobile-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#profileMenu">
                    <i class="bi bi-grid"></i>
                    <span>Menu</span>
                </button>
            </div>

            <div class="row g-4">
                <!-- Profile Menu -->
                <div class="col-lg-3">
                    <div class="profile-menu collapse d-lg-block" id="profileMenu">
                        <!-- User Info -->
                        <div class="user-info" data-aos="fade-right">
                            <div class="user-avatar">
                                <img src="{{ Storage::url('public/user_default.png') }}" alt="Profile" loading="lazy">
                                <span class="status-badge"><i class="bi bi-shield-check"></i></span>
                            </div>
                            <h4>{{ Auth::user()->name }}</h4>
                            <div class="user-status">
                                <i class="bi bi-award"></i>
                                <span>Khách hàng</span>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="menu-nav">
                            <ul class="nav flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#orders">
                                        <i class="bi bi-box-seam"></i>
                                        <span>Đơn hàng của tôi</span>
                                        <span
                                            class="badge">{{ \App\Models\Order::where('user_id', Auth::user()->id)->get()->groupBy('order_code')->count() }}</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#wishlist">
                                    <i class="bi bi-heart"></i>
                                    <span>Wishlist</span>
                                    <span class="badge">12</span>
                                    </a>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#wallet">
                                        <i class="bi bi-wallet2"></i>
                                        <span>Phương thức thanh toán</span>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                                        <i class="bi bi-star"></i>
                                        <span>Đánh giá của tôi</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#addresses">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>Địa chỉ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#settings">
                                        <i class="bi bi-gear"></i>
                                        <span>Cài đặt tài khoản</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="menu-footer">
                                <a href="#" class="help-link">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Trung tâm trợ giúp</span>
                                </a>
                                {{-- <a href="{{ route('logout') }}" class="logout-link">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Đăng xuất</span>
                                </a> --}}
                                <form id="formLogout" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a href="#" class="logout-link"
                                        onclick="document.getElementById('formLogout').submit()">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Đăng xuất</span>
                                    </a>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="col-lg-9">
                    <div class="content-area">
                        <div class="tab-content">
                            <!-- Orders Tab -->
                            <div class="tab-pane fade show active" id="orders">
                                <div class="section-header" data-aos="fade-up">
                                    <h2>Đơn hàng của tôi</h2>
                                    <div class="header-actions">
                                        <div class="search-box">
                                            <i class="bi bi-search"></i>
                                            <input type="text" placeholder="Search orders...">
                                        </div>
                                        <div class="dropdown">
                                            <button class="filter-btn" data-bs-toggle="dropdown">
                                                <i class="bi bi-funnel"></i>
                                                <span>Bộ Lọc</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Tất cả đơn hàng</a></li>
                                                <li><a class="dropdown-item" href="#">Đang xử lý</a></li>
                                                <li><a class="dropdown-item" href="#">Đang gửi đi</a></li>
                                                <li><a class="dropdown-item" href="#">Đã giao hàng</a></li>
                                                <li><a class="dropdown-item" href="#">Đã hủy</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="orders-grid">
                                    <!-- Order Card 1 -->
                                    @foreach ($orders as $order)
                                        <div class="order-card" data-aos="fade-up" data-aos-delay="100">
                                            <div class="order-header">
                                                <div class="order-id">
                                                    <span class="label">Mã Đơn Hàng:</span>
                                                    <span class="value">#{{ $order->first()->order_code }}</span>
                                                </div>
                                                <div class="order-date">{{ $order->first()->created_at }}</div>
                                                @if ($order->first()->status != 'completed' && $order->first()->status != 'processing')
                                                    <form
                                                        action="{{ route('cancelled.order', $order->first()->order_code) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit">
                                                            Hủy đơn
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="order-content">
                                                <div class="product-grid">
                                                    @foreach ($order as $item)
                                                        <img src="{{ Storage::url($item->product->images->first()->name) }}"
                                                            alt="{{ $item->product->name }}" loading="lazy">
                                                    @endforeach
                                                </div>
                                                <div class="order-info">
                                                    <div class="info-row">
                                                        <span>Trạng thái</span>
                                                        @if ($order->first()->status == 'processing')
                                                            <span
                                                                class="status shipped">{{ $order->first()->status }}</span>
                                                        @elseif ($order->first()->status == 'completed')
                                                            <span
                                                                class="status delivered">{{ $order->first()->status }}</span>
                                                        @elseif ($order->first()->status == 'pending')
                                                            <span
                                                                class="status processing">{{ $order->first()->status }}</span>
                                                        @elseif ($order->first()->status == 'cancelled')
                                                            <span
                                                                class="status cancelled">{{ $order->first()->status }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="info-row">
                                                        <span>Số hàng</span>
                                                        <span>{{ $order->count() }}</span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span>Tổng tiền</span>
                                                        <span
                                                            class="price">${{ number_format($order->sum('total_price')) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="order-footer">
                                                <button type="button" class="btn-track" data-bs-toggle="collapse"
                                                    data-bs-target="#tracking{{ $loop->iteration }}"
                                                    aria-expanded="false">Theo dõi
                                                    đơn</button>
                                                <button type="button" class="btn-details" data-bs-toggle="collapse"
                                                    data-bs-target="#details{{ $loop->iteration }}"
                                                    aria-expanded="false">Xem chi tiết</button>
                                            </div>
                                            <div class="__order-footer"
                                                style="margin-top: 24px;justify-self: center;width: max-content;">
                                                @if ($order->first()->status == 'completed')
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#ratingModal"
                                                        style="border: 1px solid #252223; padding: 8px 24px; text-decoration:none;">
                                                        Đánh giá ngay
                                                    </a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="ratingModal" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Đánh giá sản phẩm</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Đóng"></button>
                                                                </div>
                                                                @if (session('success'))
                                                                    <div class="alert alert-success mx-3 my-2">
                                                                        {{ session('success') }}
                                                                    </div>
                                                                @endif
                                                                @foreach ($order as $item)
                                                                    <div
                                                                        style="border: 1px solid #252223; margin: 8px 16px; border-radius: 10px;">
                                                                        @if (isset($reviews[$item->product->id]))
                                                                            <form
                                                                                action="{{ route('review.delete', $reviews[$item->product->id]) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-danger"
                                                                                    onclick="return confirm('Bạn có chắc muốn xóa đánh giá này không?')">
                                                                                    Xóa đánh giá
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                        <form
                                                                            action="{{ route('quick.assessment', $item->product->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                @if (isset($reviews[$item->product->id]))
                                                                                    <div>
                                                                                        <span class="text-success"><b>Đã
                                                                                                đánh
                                                                                                giá</b></span>
                                                                                    </div>
                                                                                @else
                                                                                    <div>
                                                                                        <span class="text-warning"><b>Chưa
                                                                                                đánh
                                                                                                giá</b></span>
                                                                                    </div>
                                                                                @endif
                                                                                <label for="">Tên sản phẩm:
                                                                                    <b>{{ $item->product->name }}</b></label><br>
                                                                                <label for="">Số lượng:
                                                                                    <b>{{ $item->quantity }}</b></label><br>
                                                                                <img src="{{ Storage::url($item->product->images->first()->name ?? asset('assets/img/default.png')) }}"
                                                                                    alt="{{ $item->product->name }}"
                                                                                    style="width: 100px;"><br>

                                                                                <div class="score-stars"
                                                                                    style="margin-top: 24px; color: #f59e0b">
                                                                                    <label style="color: black">Số
                                                                                        sao:</label>
                                                                                    <i class="bi bi-star"
                                                                                        data-value="1"></i>
                                                                                    <i class="bi bi-star"
                                                                                        data-value="2"></i>
                                                                                    <i class="bi bi-star"
                                                                                        data-value="3"></i>
                                                                                    <i class="bi bi-star"
                                                                                        data-value="4"></i>
                                                                                    <i class="bi bi-star"
                                                                                        data-value="5"></i>
                                                                                    <input type="hidden" name="rating"
                                                                                        value="{{ old($reviews[$item->product->id]->rating ?? 5, 5) }}">
                                                                                </div>

                                                                                <p>Bạn chọn: <span
                                                                                        class="rating-value">5</span> sao
                                                                                </p>
                                                                                <textarea class="form-control" name="assessment" placeholder="Nhập đánh giá...">{{ $reviews[$item->product->id]->content ?? '' }}</textarea>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Hủy</button>
                                                                                @if (isset($reviews[$item->product->id]))
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-secondary">Cập
                                                                                        nhật</button>
                                                                                @else
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Gửi đánh
                                                                                        giá</button>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                @endforeach

                                                                <script>
                                                                    document.querySelectorAll('.score-stars').forEach(starContainer => {
                                                                        const stars = starContainer.querySelectorAll('i');
                                                                        const ratingValueEl = starContainer.parentElement.querySelector('.rating-value');
                                                                        const hiddenInput = starContainer.querySelector('input[name="rating"]');
                                                                        let currentRating = 5; // ⭐ mặc định 5 sao

                                                                        function updateStars(value) {
                                                                            stars.forEach((s, index) => {
                                                                                s.classList.remove('active');
                                                                                s.classList.replace('bi-star-fill', 'bi-star');
                                                                                if (index < value) {
                                                                                    s.classList.add('active');
                                                                                    s.classList.replace('bi-star', 'bi-star-fill');
                                                                                }
                                                                            });
                                                                            ratingValueEl.textContent = value;
                                                                            hiddenInput.value = value;
                                                                        }

                                                                        stars.forEach(star => {
                                                                            star.addEventListener('click', () => {
                                                                                currentRating = parseInt(star.getAttribute('data-value'));
                                                                                updateStars(currentRating);
                                                                            });
                                                                        });

                                                                        // Hiển thị mặc định 5 sao
                                                                        updateStars(currentRating);
                                                                    });
                                                                </script>
                                                                @if (session('open_modal'))
                                                                    <script>
                                                                        document.addEventListener("DOMContentLoaded", function() {
                                                                            const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));
                                                                            ratingModal.show();
                                                                        });
                                                                    </script>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <form
                                                        action="{{ route('order.received', $order->first()->order_code) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn-received"
                                                            style="width: 500px; background-color: #252223; color: white;"
                                                            @if (!now()->greaterThan($order->first()->created_at->addDays(3)) && $order->first()->status == 'processing') disabled @endif>Đã nhận được
                                                            hàng</button>
                                                        {{-- <p>{{ $order->first()->created_at->addDays(3) }}</p> --}}
                                                        <style>
                                                            .__order-footer:hover {
                                                                background-color: #393436;
                                                            }
                                                        </style>
                                                    </form>
                                                @endif
                                            </div>

                                            <!-- Order Tracking -->
                                            <div class="collapse tracking-info" id="tracking{{ $loop->iteration }}">
                                                <div class="tracking-timeline">
                                                    <div class="timeline-item completed">
                                                        <div class="timeline-icon">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <h5>Xác nhận đơn hàng</h5>
                                                            <p>Bạn đã xác nhận đặt hàng</p>
                                                            <span
                                                                class="timeline-date">{{ $order->first()->created_at }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="timeline-item completed">
                                                        <div class="timeline-icon">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <h5>Đang xử lý</h5>
                                                            <p>Đơn hàng của bạn đang được chuẩn bị</p>
                                                            <span class="timeline-date">Feb 20, 2025 - 2:45 PM</span>
                                                        </div>
                                                    </div>

                                                    @if ($order->first()->status == 'processing' || $order->first()->status == 'completed')
                                                        <div class="timeline-item completed">
                                                            <div class="timeline-icon">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <h5>Đóng gói</h5>
                                                                <p>Người bán đã gửi hàng đi</p>
                                                                <span
                                                                    class="timeline-date">{{ $order->first()->updated_at }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-item completed">
                                                            <div class="timeline-icon">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <h5>Đang vận chuyển</h5>
                                                                <p>Đơn hàng sẽ được đem đến trong vòng từ 3-5 ngày kể từ lúc
                                                                    đặt
                                                                    hàng</p>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="timeline-item active">
                                                            <div class="timeline-icon">
                                                                <i class="bi bi-box-seam"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <h5>Đóng gói</h5>
                                                                <p>Người bán đang chuẩn bị hàng</p>
                                                                <span
                                                                    class="timeline-date">{{ $order->first()->updated_at }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-item">
                                                            <div class="timeline-icon">
                                                                <i class="bi bi-truck"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <h5>Đang vận chuyển</h5>
                                                                <p>Đơn hàng sẽ được đem đến trong vòng từ 3-5 ngày kể từ lúc
                                                                    đặt
                                                                    hàng</p>
                                                            </div>
                                                        </div>
                                                    @endif



                                                    <div class="timeline-item">
                                                        <div class="timeline-icon">
                                                            <i class="bi bi-house-door"></i>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <h5>Đã nhận hàng</h5>
                                                            <p>Estimated delivery: Feb xx, 20xx</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Order Details -->
                                            <div class="collapse order-details" id="details{{ $loop->iteration }}">
                                                <div class="details-content">
                                                    <div class="detail-section">
                                                        <h5>Thông tin đơn hàng</h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <span class="label">Phương thức thanh toán</span>
                                                                <span
                                                                    class="value">{{ $order->first()->payment_method }}</span>
                                                            </div>
                                                            <div class="info-item">
                                                                <span class="label">Phương thức vận chuyển</span>
                                                                <span class="value">Có hàng sau 2-3 ngày</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="detail-section">
                                                        <h5>Items {{ $order->count() }}</h5>
                                                        <div class="order-items">
                                                            @foreach ($order as $item)
                                                                <div class="item">
                                                                    <img src="{{ Storage::url($item->product->images->first()->name ?? 'public/default.png') }}"
                                                                        alt="Product" loading="lazy">
                                                                    <div class="item-info">
                                                                        <h6>{{ $item->product->name }}</h6>
                                                                        <div class="item-meta">
                                                                            {{-- <span class="sku">SKU: PRD-001</span> --}}
                                                                            <span class="qty">SL:
                                                                                {{ $item->quantity }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-price">
                                                                        {{ number_format($item->total_price) }}</div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="detail-section">
                                                        <h5>Chi tiết giá</h5>
                                                        <div class="price-breakdown">
                                                            <div class="price-row">
                                                                <span>Tổng phụ</span>
                                                                <span>{{ number_format($order->sum('total_price')) }}đ</span>
                                                            </div>
                                                            <div class="price-row">
                                                                <span>Shipping</span>
                                                                <span>$0.00</span>
                                                            </div>
                                                            {{-- <div class="price-row">
                                                                <span>Tax</span>
                                                                <span>$0.00</span>
                                                            </div> --}}
                                                            <div class="price-row total">
                                                                <span>Tổng</span>
                                                                <span>{{ number_format($order->sum('total_price')) }}đ</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="detail-section">
                                                        <h5>Địa chỉ giao hàng</h5>
                                                        <div class="address-info">
                                                            <h5>Địa chỉ</h5>
                                                            <p>{{ $user->infos->first()->address }}</p>
                                                            </br>
                                                            <h5>Số điện thoại</h5>
                                                            <p class="contact">{{ $user->infos->first()->phone }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- <div class="order-card" data-aos="fade-up" data-aos-delay="200">
                                        <div class="order-header">
                                            <div class="order-id">
                                                <span class="label">Order ID:</span>
                                                <span class="value">#ORD-2024-1265</span>
                                            </div>
                                            <div class="order-date">Feb 15, 2025</div>
                                        </div>
                                        <div class="order-content">
                                            <div class="product-grid">
                                                <img src="assets/img/product/product-4.webp" alt="Product"
                                                    loading="lazy">
                                                <img src="assets/img/product/product-5.webp" alt="Product"
                                                    loading="lazy">
                                            </div>
                                            <div class="order-info">
                                                <div class="info-row">
                                                    <span>Status</span>
                                                    <span class="status shipped">Shipped</span>
                                                </div>
                                                <div class="info-row">
                                                    <span>Items</span>
                                                    <span>2 items</span>
                                                </div>
                                                <div class="info-row">
                                                    <span>Total</span>
                                                    <span class="price">$459.99</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-footer">
                                            <button type="button" class="btn-track" data-bs-toggle="collapse"
                                                data-bs-target="#tracking2" aria-expanded="false">Track Order</button>
                                            <button type="button" class="btn-details" data-bs-toggle="collapse"
                                                data-bs-target="#details2" aria-expanded="false">View Details</button>
                                        </div>

                                        <!-- Order Tracking -->
                                        <div class="collapse tracking-info" id="tracking2">
                                            <div class="tracking-timeline">
                                                <div class="timeline-item completed">
                                                    <div class="timeline-icon">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h5>Order Confirmed</h5>
                                                        <p>Your order has been received and confirmed</p>
                                                        <span class="timeline-date">Feb 15, 2025 - 9:15 AM</span>
                                                    </div>
                                                </div>

                                                <div class="timeline-item completed">
                                                    <div class="timeline-icon">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h5>Processing</h5>
                                                        <p>Your order is being prepared for shipment</p>
                                                        <span class="timeline-date">Feb 15, 2025 - 11:30 AM</span>
                                                    </div>
                                                </div>

                                                <div class="timeline-item completed">
                                                    <div class="timeline-icon">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h5>Packaging</h5>
                                                        <p>Your items have been packaged for shipping</p>
                                                        <span class="timeline-date">Feb 15, 2025 - 2:45 PM</span>
                                                    </div>
                                                </div>

                                                <div class="timeline-item active">
                                                    <div class="timeline-icon">
                                                        <i class="bi bi-truck"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h5>In Transit</h5>
                                                        <p>Package in transit with carrier</p>
                                                        <span class="timeline-date">Feb 16, 2025 - 10:20 AM</span>
                                                        <div class="shipping-info">
                                                            <span>Tracking Number: </span>
                                                            <span class="tracking-number">1Z999AA1234567890</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="timeline-item">
                                                    <div class="timeline-icon">
                                                        <i class="bi bi-house-door"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h5>Delivery</h5>
                                                        <p>Estimated delivery: Feb 18, 2025</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order Details -->
                                        <div class="collapse order-details" id="details2">
                                            <div class="details-content">
                                                <div class="detail-section">
                                                    <h5>Order Information</h5>
                                                    <div class="info-grid">
                                                        <div class="info-item">
                                                            <span class="label">Payment Method</span>
                                                            <span class="value">Credit Card **** 7821</span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="label">Shipping Method</span>
                                                            <span class="value">Standard Shipping 3-5 days</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="detail-section">
                                                    <h5>Items 2</h5>
                                                    <div class="order-items">
                                                        <div class="item">
                                                            <img src="assets/img/product/product-4.webp" alt="Product"
                                                                loading="lazy">
                                                            <div class="item-info">
                                                                <h6>Ut enim ad minim veniam</h6>
                                                                <div class="item-meta">
                                                                    <span class="sku">SKU: PRD-004</span>
                                                                    <span class="qty">Qty: 1</span>
                                                                </div>
                                                            </div>
                                                            <div class="item-price">$299.99</div>
                                                        </div>

                                                        <div class="item">
                                                            <img src="assets/img/product/product-5.webp" alt="Product"
                                                                loading="lazy">
                                                            <div class="item-info">
                                                                <h6>Quis nostrud exercitation</h6>
                                                                <div class="item-meta">
                                                                    <span class="sku">SKU: PRD-005</span>
                                                                    <span class="qty">Qty: 1</span>
                                                                </div>
                                                            </div>
                                                            <div class="item-price">$159.99</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="detail-section">
                                                    <h5>Price Details</h5>
                                                    <div class="price-breakdown">
                                                        <div class="price-row">
                                                            <span>Subtotal</span>
                                                            <span>$459.98</span>
                                                        </div>
                                                        <div class="price-row">
                                                            <span>Shipping</span>
                                                            <span>$9.99</span>
                                                        </div>
                                                        <div class="price-row">
                                                            <span>Tax</span>
                                                            <span>$38.02</span>
                                                        </div>
                                                        <div class="price-row total">
                                                            <span>Total</span>
                                                            <span>$459.99</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="detail-section">
                                                    <h5>Shipping Address</h5>
                                                    <div class="address-info">
                                                        <p>Sarah Anderson<br>123 Main Street<br>Apt 4B<br>New York, NY
                                                            10001<br>United States</p>
                                                        <p class="contact">+1 555 123-4567</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="order-card" data-aos="fade-up" data-aos-delay="300">
                                        <div class="order-header">
                                            <div class="order-id">
                                                <span class="label">Order ID:</span>
                                                <span class="value">#ORD-2024-1252</span>
                                            </div>
                                            <div class="order-date">Feb 10, 2025</div>
                                        </div>
                                        <div class="order-content">
                                            <div class="product-grid">
                                                <img src="assets/img/product/product-6.webp" alt="Product"
                                                    loading="lazy">
                                            </div>
                                            <div class="order-info">
                                                <div class="info-row">
                                                    <span>Status</span>
                                                    <span class="status delivered">Delivered</span>
                                                </div>
                                                <div class="info-row">
                                                    <span>Items</span>
                                                    <span>1 item</span>
                                                </div>
                                                <div class="info-row">
                                                    <span>Total</span>
                                                    <span class="price">$129.99</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-footer">
                                            <button type="button" class="btn-review">Write Review</button>
                                            <button type="button" class="btn-details">View Details</button>
                                        </div>
                                    </div>

                                    <div class="order-card" data-aos="fade-up" data-aos-delay="400">
                                        <div class="order-header">
                                            <div class="order-id">
                                                <span class="label">Order ID:</span>
                                                <span class="value">#ORD-2024-1245</span>
                                            </div>
                                            <div class="order-date">Feb 5, 2025</div>
                                        </div>
                                        <div class="order-content">
                                            <div class="product-grid">
                                                <img src="assets/img/product/product-7.webp" alt="Product"
                                                    loading="lazy">
                                                <img src="assets/img/product/product-8.webp" alt="Product"
                                                    loading="lazy">
                                                <img src="assets/img/product/product-9.webp" alt="Product"
                                                    loading="lazy">
                                                <span class="more-items">+2</span>
                                            </div>
                                            <div class="order-info">
                                                <div class="info-row">
                                                    <span>Status</span>
                                                    <span class="status cancelled">Cancelled</span>
                                                </div>
                                                <div class="info-row">
                                                    <span>Items</span>
                                                    <span>5 items</span>
                                                </div>
                                                <div class="info-row">
                                                    <span>Total</span>
                                                    <span class="price">$1,299.99</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="order-footer">
                                            <button type="button" class="btn-reorder">Reorder</button>
                                            <button type="button" class="btn-details">View Details</button>
                                        </div>
                                    </div> --}}
                                </div>

                                <!-- Pagination -->
                                {{-- <div class="pagination-wrapper" data-aos="fade-up">
                                    <button type="button" class="btn-prev" disabled="">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <div class="page-numbers">
                                        <button type="button" class="active">1</button>
                                        <button type="button">2</button>
                                        <button type="button">3</button>
                                        <span>...</span>
                                        <button type="button">12</button>
                                    </div>
                                    <button type="button" class="btn-next">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div> --}}

                            </div>

                            <!-- Wishlist Tab -->
                            <div class="tab-pane fade" id="wishlist">
                                <div class="section-header" data-aos="fade-up">
                                    <h2>My Wishlist</h2>
                                    <div class="header-actions">
                                        <button type="button" class="btn-add-all">Add All to Cart</button>
                                    </div>
                                </div>

                                <div class="wishlist-grid">
                                    <!-- Wishlist Item 1 -->
                                    <div class="wishlist-card" data-aos="fade-up" data-aos-delay="100">
                                        <div class="wishlist-image">
                                            <img src="assets/img/product/product-1.webp" alt="Product" loading="lazy">
                                            <button class="btn-remove" type="button" aria-label="Remove from wishlist">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <div class="sale-badge">-20%</div>
                                        </div>
                                        <div class="wishlist-content">
                                            <h4>Lorem ipsum dolor sit amet</h4>
                                            <div class="product-meta">
                                                <div class="rating">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                    <span>4.5</span>
                                                </div>
                                                <div class="price">
                                                    <span class="current">$79.99</span>
                                                    <span class="original">$99.99</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-add-cart">Add to Cart</button>
                                        </div>
                                    </div>

                                    <!-- Wishlist Item 2 -->
                                    <div class="wishlist-card" data-aos="fade-up" data-aos-delay="200">
                                        <div class="wishlist-image">
                                            <img src="assets/img/product/product-2.webp" alt="Product" loading="lazy">
                                            <button class="btn-remove" type="button" aria-label="Remove from wishlist">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <div class="wishlist-content">
                                            <h4>Consectetur adipiscing elit</h4>
                                            <div class="product-meta">
                                                <div class="rating">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                    <span>4.0</span>
                                                </div>
                                                <div class="price">
                                                    <span class="current">$149.99</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-add-cart">Add to Cart</button>
                                        </div>
                                    </div>

                                    <!-- Wishlist Item 3 -->
                                    <div class="wishlist-card" data-aos="fade-up" data-aos-delay="300">
                                        <div class="wishlist-image">
                                            <img src="assets/img/product/product-3.webp" alt="Product" loading="lazy">
                                            <button class="btn-remove" type="button" aria-label="Remove from wishlist">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <div class="out-of-stock-badge">Out of Stock</div>
                                        </div>
                                        <div class="wishlist-content">
                                            <h4>Sed do eiusmod tempor</h4>
                                            <div class="product-meta">
                                                <div class="rating">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <span>5.0</span>
                                                </div>
                                                <div class="price">
                                                    <span class="current">$199.99</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-notify">Notify When Available</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Methods Tab -->
                            {{-- <div class="tab-pane fade" id="wallet">
                                <div class="section-header" data-aos="fade-up">
                                    <h2>Payment Methods</h2>
                                    <div class="header-actions">
                                        <button type="button" class="btn-add-new">
                                            <i class="bi bi-plus-lg"></i>
                                            Add New Card
                                        </button>
                                    </div>
                                </div>

                                <div class="payment-cards-grid">
                                    <!-- Payment Card 1 -->
                                    <div class="payment-card default" data-aos="fade-up" data-aos-delay="100">
                                        <div class="card-header">
                                            <i class="bi bi-credit-card"></i>
                                            <div class="card-badges">
                                                <span class="default-badge">Default</span>
                                                <span class="card-type">Visa</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-number">•••• •••• •••• 4589</div>
                                            <div class="card-info">
                                                <span>Expires 09/2026</span>
                                            </div>
                                        </div>
                                        <div class="card-actions">
                                            <button type="button" class="btn-edit">
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </button>
                                            <button type="button" class="btn-remove">
                                                <i class="bi bi-trash"></i>
                                                Remove
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Payment Card 2 -->
                                    <div class="payment-card" data-aos="fade-up" data-aos-delay="200">
                                        <div class="card-header">
                                            <i class="bi bi-credit-card"></i>
                                            <div class="card-badges">
                                                <span class="card-type">Mastercard</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-number">•••• •••• •••• 7821</div>
                                            <div class="card-info">
                                                <span>Expires 05/2025</span>
                                            </div>
                                        </div>
                                        <div class="card-actions">
                                            <button type="button" class="btn-edit">
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </button>
                                            <button type="button" class="btn-remove">
                                                <i class="bi bi-trash"></i>
                                                Remove
                                            </button>
                                            <button type="button" class="btn-make-default">Make Default</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <!-- Reviews Tab -->
                            <div class="tab-pane fade" id="reviews">
                                <div class="section-header" data-aos="fade-up">
                                    <h2>Đánh giá của bạn</h2>
                                    <div class="header-actions">
                                        <div class="dropdown">
                                            <button class="filter-btn" data-bs-toggle="dropdown">
                                                <i class="bi bi-funnel"></i>
                                                <span>Sắp sếp theo: Gần nhất</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Gần nhất</a></li>
                                                <li><a class="dropdown-item" href="#">Đánh giá cao</a></li>
                                                {{-- <li><a class="dropdown-item" href="#">Lowest Rating</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="reviews-grid">
                                    @foreach ($reviews as $review)
                                        <div class="review-card" data-aos="fade-up" data-aos-delay="100">
                                            <div class="review-header">
                                                <img src="{{ Storage::url($review->product->images->first()->name ?? '/public/default.png') }}"
                                                    alt="Product" class="product-image" loading="lazy">
                                                <div class="review-meta">
                                                    <h4>{{ $review->product->name }}</h4>
                                                    <div class="rating">
                                                        @for ($i = 0; $i < $review->rating; $i++)
                                                            <i class="bi bi-star-fill"></i>
                                                        @endfor
                                                        {{-- <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i> --}}
                                                        <span>{{ $review->rating }}.0</span>
                                                    </div>
                                                    <div class="review-date">Đánh giá vào lúc: {{ $review->created_at }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-content">
                                                <p>{{ $review->content }}.</p>
                                            </div>
                                            <div class="review-footer">
                                                <button type="button" class="btn-edit">Edit Review</button>
                                                <button type="button" class="btn-delete">Delete</button>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Review Card 2 -->
                                    {{-- <div class="review-card" data-aos="fade-up" data-aos-delay="200">
                                        <div class="review-header">
                                            <img src="assets/img/product/product-2.webp" alt="Product"
                                                class="product-image" loading="lazy">
                                            <div class="review-meta">
                                                <h4>Consectetur adipiscing elit</h4>
                                                <div class="rating">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                    <span>4.0</span>
                                                </div>
                                                <div class="review-date">Reviewed on Feb 10, 2025</div>
                                            </div>
                                        </div>
                                        <div class="review-content">
                                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                                aliquip ex ea commodo consequat.</p>
                                        </div>
                                        <div class="review-footer">
                                            <button type="button" class="btn-edit">Edit Review</button>
                                            <button type="button" class="btn-delete">Delete</button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <!-- Addresses Tab -->
                            <div class="tab-pane fade" id="addresses">
                                <div class="section-header" data-aos="fade-up">
                                    <h2>Địa chỉ của tôi</h2>
                                    <div class="header-actions">
                                        <button type="button" class="btn-add-new">
                                            <i class="bi bi-plus-lg"></i>
                                            Thêm địa chỉ mới
                                        </button>
                                    </div>
                                </div>

                                <div class="addresses-grid">
                                    <!-- Address Card 1 -->
                                    @foreach ($user->infos as $info)
                                        <div class="address-card default" data-aos="fade-up" data-aos-delay="100">
                                            <div class="card-header">
                                                <h4>Nhà</h4>
                                                <span class="default-badge">Mặc định</span>
                                            </div>
                                            <div class="card-body">
                                                <p class="address-text">{{ $info->address }}</p>
                                                <div class="contact-info">
                                                    <div><i class="bi bi-person"></i> {{ $user->name }}</div>
                                                    <div><i class="bi bi-telephone"></i> {{ $info->phone }}</div>
                                                </div>
                                            </div>
                                            <div class="card-actions">
                                                <button type="button" class="btn-edit">
                                                    <i class="bi bi-pencil"></i>
                                                    Sửa
                                                </button>
                                                <button type="button" class="btn-remove">
                                                    <i class="bi bi-trash"></i>
                                                    Xóa
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Address Card 2 -->
                                    {{-- <div class="address-card" data-aos="fade-up" data-aos-delay="200">
                                        <div class="card-header">
                                            <h4>Office</h4>
                                        </div>
                                        <div class="card-body">
                                            <p class="address-text">456 Business Ave<br>Suite 200<br>San Francisco, CA
                                                94107<br>United States</p>
                                            <div class="contact-info">
                                                <div><i class="bi bi-person"></i> Sarah Anderson</div>
                                                <div><i class="bi bi-telephone"></i> +1 555 987-6543</div>
                                            </div>
                                        </div>
                                        <div class="card-actions">
                                            <button type="button" class="btn-edit">
                                                <i class="bi bi-pencil"></i>
                                                Edit
                                            </button>
                                            <button type="button" class="btn-remove">
                                                <i class="bi bi-trash"></i>
                                                Remove
                                            </button>
                                            <button type="button" class="btn-make-default">Make Default</button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <!-- Settings Tab -->
                            <div class="tab-pane fade" id="settings">
                                <div class="section-header" data-aos="fade-up">
                                    <h2>Cài đặt tài khoản</h2>
                                </div>

                                <div class="settings-content">
                                    <!-- Personal Information -->
                                    <div class="settings-section" data-aos="fade-up">
                                        <h3>Thông tin người dùng</h3>
                                        <form action="{{ route('account.update') }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="firstName" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="{{ $user->name }}" required>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <label for="lastName" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                        value="Anderson" required="">
                                                </div> --}}
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email"
                                                        value="{{ $user->email }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" pattern="[0-9]*" class="form-control" name="phone" value="{{ $info->phone }}">
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <button type="submit" class="border-collapse" style="border-radius: 8px; background-color: #252223; color: white;">Lưu thay đổi</button>
                                            </div>

                                            {{-- <div class="loading">Loading</div> --}}
                                            @if (session('error'))
                                                <div class="error-message">{{ $message }}</div>
                                            @endif
                                            @if (session('success'))
                                                <div class="sent-message">Your changes have been saved successfully!</div>
                                            @endif
                                        </form>
                                    </div>

                                    <!-- Email Preferences -->
                                    {{-- <div class="settings-section" data-aos="fade-up" data-aos-delay="100">
                                        <h3>Email Preferences</h3>
                                        <div class="preferences-list">
                                            <div class="preference-item">
                                                <div class="preference-info">
                                                    <h4>Order Updates</h4>
                                                    <p>Receive notifications about your order status</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="orderUpdates"
                                                        checked="">
                                                </div>
                                            </div>

                                            <div class="preference-item">
                                                <div class="preference-info">
                                                    <h4>Promotions</h4>
                                                    <p>Receive emails about new promotions and deals</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="promotions">
                                                </div>
                                            </div>

                                            <div class="preference-item">
                                                <div class="preference-info">
                                                    <h4>Newsletter</h4>
                                                    <p>Subscribe to our weekly newsletter</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="newsletter"
                                                        checked="">
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <!-- Security Settings -->
                                    <div class="settings-section" data-aos="fade-up" data-aos-delay="200">
                                        <h3>Bảo mật</h3>
                                        <form class="php-email-form settings-form">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="currentPassword" class="form-label">Mật khẩu hiện
                                                        tại</label>
                                                    <input type="password" class="form-control" id="currentPassword"
                                                        name="current_password">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="newPassword" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" id="newPassword"
                                                        name="new_password">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="confirmPassword" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        name="confirm_password">
                                                </div>
                                            </div>

                                            <div class="form-buttons">
                                                <button type="submit" class="btn-save">Cập nhật</button>
                                            </div>

                                            <div class="loading">Loading</div>
                                            @if (session('error'))
                                                <div class="error-message">{{ $message }}</div>
                                            @endif
                                            @if (session('success'))
                                                <div class="sent-message">Your changes have been saved successfully!</div>
                                            @endif
                                        </form>
                                    </div>

                                    <!-- Delete Account -->
                                    <div class="settings-section danger-zone" data-aos="fade-up" data-aos-delay="300">
                                        <h3>Xóa tài khoản</h3>
                                        <div class="danger-zone-content">
                                            <p>Một khi bạn đã xóa tài khoản, bạn sẽ không thể quay lại được nữa. Hãy chắc
                                                chắn nhé.</p>
                                            <button type="button" class="btn-danger">Xóa tài khoản</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Account Section -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Khi click tab, lưu ID tab vào localStorage
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tabLink) {
                tabLink.addEventListener('shown.bs.tab', function(e) {
                    localStorage.setItem('activeTab', e.target.getAttribute('href'));
                });
            });

            // Khi load lại trang, nếu có tab được lưu → mở lại
            let activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                let someTabTriggerEl = document.querySelector(`a[href="${activeTab}"]`);
                if (someTabTriggerEl) {
                    new bootstrap.Tab(someTabTriggerEl).show();
                }
            }
        });
    </script>


@endsection
