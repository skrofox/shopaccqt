@extends('admin.layouts.app')

@section('title', 'Danh Sách Sản Phẩm')

@section('content')
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Danh Sách Sản Phẩm</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-style mb-30">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Danh Mục</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Slug</th>
                            <th>Ảnh</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->name }}</td>
                                {{-- <td>{{ number_format($product->price, 2) }}</td> --}}
                                <td>{{ $product->formatted_price }}</td>
                                <td class="text-truncate" style="max-width: 50px" title="{{ $product->slug }}">{{ $product->slug }}</td>
                                <td>{{ $product->images->count() }}</td>
                                <td>
                                    @if($product->is_active)
                                        <span class="status-btn success-btn">Active</span>
                                    @else
                                        <span class="status-btn close-btn">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">Xem</a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xóa Sản Phẩm này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có Sản Phẩm</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection


