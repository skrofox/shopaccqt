@extends('admin.layouts.app')

@section('title', 'Thêm Sản Phẩm')

@section('content')
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Thêm Sản Phẩm</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#0">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#0">Forms</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Form Elements
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== form-elements-wrapper start ========== -->
            <div class="form-elements-wrapper">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- input style start -->
                        <div class="card-style mb-30">
                            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h6 class="mb-25">Nhập</h6>
                                <div class="input-style-1">
                                    <label>Tên Sản Phẩm</label>
                                    <input type="text" name="name" placeholder="Tên sản phẩm..." />
                                </div>
                                <div class="input-style-1">
                                    <label>Mô Tả</label>
                                    <textarea name="description" id="" placeholder="Nhập mô tả sản phẩm..." cols="30" rows="10"></textarea>
                                </div>
                                <h6 class="mb-25">Selects</h6>
                                <!-- end select -->
                                <div class="select-style-2">
                                    <div class="select-position">
                                        <select required name="category_id">
                                            <option value="">Chọn Danh Mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <h6 class="mb-25">Trạng Thái</h6>
                                <div class="form-check form-switch toggle-switch mb-30">
                                    <input class="form-check-input" type="checkbox" id="toggleSwitch1" name="is_active"/>
                                    <label class="form-check-label" for="toggleSwitch1">Kích Hoạt</label>
                                </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-6">
                        <!-- input style start -->
                        <div class="card-style mb-30">
                            <h6 class="mb-25">Thêm Ảnh</h6>
                            <div class="input-style-1">
                                <label>Chọn ảnh</label>
                                <input type="file" name="image[]" multiple accept="image/*"/>
                            </div>
                            <Button type="submit" class="btn btn-primary">
                                Thêm
                            </Button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- end row -->
            </div>
            <!-- ========== form-elements-wrapper end ========== -->
        </div>
        <!-- end container -->
    </section>

@endsection
