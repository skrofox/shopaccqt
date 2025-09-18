@extends('admin.layouts.app')

@section('title', 'Thêm Danh Mục')

@section('content')
    <section class="tab-components">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Thêm Danh Mục</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-style mb-30">
                            <form action="{{ route('admin.categories.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <h6 class="mb-25">Nhập</h6>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="input-style-1">
                                    <label>Tên</label>
                                    <input type="text" name="name" value="{{ old('name') }}" />
                                </div>
                                <div class="input-style-1">
                                    <label>Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug') }}" />
                                </div>
                                <div class="input-style-1">
                                    <label>Ảnh</label>
                                    <input type="file" name="image" value="{{ old('image') }}" />
                                </div>
                                <div class="form-check form-switch toggle-switch mb-30">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        id="is_active" {{ old('is_active') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_active">Kích hoạt</label>
                                </div>

                                <button type="submit" class="btn btn-primary">Tạo Danh Mục</button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
