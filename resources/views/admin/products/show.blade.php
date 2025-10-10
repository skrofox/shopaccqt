@extends('admin.layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Chi Tiết Sản Phẩm</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Sửa</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <h6 class="mb-25">Thông tin</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Tên:</strong> {{ $product->name }}</li>
                        <li class="list-group-item"><strong>Danh mục:</strong> {{ $product->category->name }}</li>
                        <li class="list-group-item"><strong>Slug:</strong> {{ $product->slug }}</li>
                        <li class="list-group-item"><strong>Trạng thái:</strong>
                            @if($product->is_active)
                                <span class="status-btn success-btn">Active</span>
                            @else
                                <span class="status-btn close-btn">Inactive</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Mô tả:</strong>
                            <div class="mt-2">{{ $product->description }}</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-style mb-30">
                    <h6 class="mb-25">Hình ảnh</h6>
                    <div class="row g-3">
                        @forelse($product->images as $image)
                            <div class="col-6 col-md-4">
                                <img src="{{ Storage::url($image->name) }}" alt="{{ $product->name }}" class="img-fluid rounded" />
                            </div>
                        @empty
                            <div class="col-12">Chưa có hình ảnh</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-style mb-30">
                    <h6>Giá: {{ $product->formatted_price }}</h6>
                </div>
            </div>
        </div>
    </div>
@endsection

