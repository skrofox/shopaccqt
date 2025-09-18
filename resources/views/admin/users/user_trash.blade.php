@extends('admin.layouts.app')

@section('title', 'Quản Lý Người Dùng')


@section('content')
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Danh Sách Người Dùng Đã Xóa</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Tables
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

            <!-- ========== tables-wrapper start ========== -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <h6 class="mb-10">Thùng rác người dùng</h6>
                            <p class="text-sm mb-20">
                                Danh sách người dùng đã bị xóa
                            </p>
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="lead-info">
                                                <h6>#</h6>
                                            </th>
                                            <th class="lead-email">
                                                <h6>Name</h6>
                                            </th>
                                            <th class="lead-phone">
                                                <h6>Email</h6>
                                            </th>
                                            <th class="lead-company">
                                                <h6>Tạo Lúc</h6>
                                            </th>
                                            <th>
                                                <h6>Action</h6>
                                            </th>
                                        </tr>
                                        <!-- end table row-->
                                    </thead>
                                    @foreach ($users as $user)
                                        <tbody>
                                            <tr>
                                                <td class="min-width">
                                                    <div class="lead">
                                                        <div class="lead-text">
                                                            <p>{{ $loop->iteration }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="min-width">
                                                    <p><a href="#0">{{ $user->name }}</a></p>
                                                </td>
                                                <td class="min-width">
                                                    <p>{{ $user->email }}</p>
                                                </td>
                                                <td class="min-width">
                                                    <p>{{ $user->created_at }}</p>
                                                </td>
                                                <td>
                                                    <div class="action" style="display:flex; gap:8px; align-items:center;">
                                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-primary" style="background: transparent; border: none;" title="Khôi phục">
                                                                {{-- <i class="lni lni-emoji-smile"></i> --}}
                                                                Khôi phục  
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.force', $user->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn người dùng này? Hành động không thể hoàn tác.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-danger" style="background: transparent; border: none;" title="Xóa vĩnh viễn">
                                                                {{-- <i class="lni lni-trash-can"></i> --}}
                                                                Xóa vĩnh viễn
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- end table row -->
                                        </tbody>
                                    @endforeach
                                </table>
                                {{-- Pagination --}}
                                {{ $users->links() }}
                                <!-- end table -->
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== tables-wrapper end ========== -->
        </div>
        <!-- end container -->
    </section>
    <script>
        // Xác nhận xóa vĩnh viễn được xử lý qua onsubmit của form
    </script>

@endsection
