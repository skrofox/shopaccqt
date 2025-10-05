@extends('admin.layouts.app')

@section('title', 'Show')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Chi tiết đơn hàng #{{ $orderInfo->order_code }}</h4>
                    </div>

                    <div class="card-body">
                        <!-- Thông tin khách hàng -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="border-bottom pb-2 mb-3">Thông tin khách hàng</h5>
                                <p><strong>Tên:</strong> {{ $orderInfo->user->name }}</p>
                                <p><strong>Email:</strong> {{ $orderInfo->user->email }}</p>
                                @if ($orderInfo->user->infos->isNotEmpty())
                                    <p><strong>Số điện thoại:</strong>
                                        {{ $orderInfo->user->infos->first()->phone ?? 'Chưa cập nhật' }}</p>
                                    <p><strong>Địa chỉ:</strong>
                                        {{ $orderInfo->user->infos->first()->address ?? 'Chưa cập nhật' }}</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h5 class="border-bottom pb-2 mb-3">Thông tin đơn hàng</h5>
                                <p><strong>Mã đơn:</strong> {{ $orderInfo->order_code }}</p>
                                <p><strong>Ngày đặt:</strong> {{ $orderInfo->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Phương thức thanh toán:</strong>
                                    <span class="badge bg-info">{{ $orderInfo->payment_method }}</span>
                                </p>
                                <p><strong>Trạng thái thanh toán:</strong>
                                    <span
                                        class="badge {{ $orderInfo->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $orderInfo->payment_status }}
                                    </span>
                                </p>
                                <p><strong>Trạng thái đơn hàng:</strong>
                                    <span class="badge bg-primary">{{ $orderInfo->status }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Danh sách sản phẩm -->
                        <h5 class="border-bottom pb-2 mb-3">Danh sách sản phẩm</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalAmount = 0;
                                    @endphp
                                    @foreach ($orders as $index => $order)
                                        @php
                                            $totalAmount += $order->total_price;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->product->name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ number_format($order->total_price / $order->quantity, 0, ',', '.') }} đ
                                            </td>
                                            <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td><strong>{{ number_format($totalAmount, 0, ',', '.') }} đ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Nút hành động -->
                        <div class="mt-4">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                <i class="fas fa-print"></i> In đơn hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            .card-header {
                display: none;
            }
        }
    </style>
@endsection
