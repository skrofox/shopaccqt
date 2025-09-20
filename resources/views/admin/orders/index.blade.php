@extends('admin.layouts.app')

@section('title', 'Danh Sách Đặt Hàng')

@section('content')
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Danh Sách Đặt Hàng</h2>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-style mb-30">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>IDKH</th>
                            <th>Tên sản phẩm</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thanh toán</th>
                            <th>Số Lượng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng thái</th>
                            <th>Note</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->user_id }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->payment_method }}</td>
                                <td>
                                    @if ($order->payment_status == 'paid')
                                        <span class="status-btn success-btn">Đã</span>
                                    @else
                                        <span class="status-btn close-btn">Chưa</span>
                                    @endif
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ number_format($order->total_price) }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang
                                                xử lý</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                Đang giao</option>
                                            <option value="cancelled"
                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="text-truncate" style="max-width: 50px" title="{{ $order->note }}">
                                    {{ $order->note }}</td>
                                <td class="text-end">
                                    <a href="" class="btn btn-sm btn-primary">Xem</a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                        style="display:inline-block" onsubmit="return confirm('Xóa danh mục này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có danh mục</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
