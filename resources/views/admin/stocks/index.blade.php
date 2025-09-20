@extends('admin.layouts.app')

@section('title', 'Quản Lý Tồn Kho')

@section('content')
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Quản Lý Tồn Kho</h2>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
                        <i class="lni lni-plus"></i> Thêm Tồn Kho
                    </button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-style mb-30">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Sản Phẩm</th>
                            <th width="15%">Danh Mục</th>
                            <th width="12%">Tồn Kho</th>
                            <th width="12%">Tối Thiểu</th>
                            <th width="12%">Tối Đa</th>
                            <th width="12%">Trạng Thái</th>
                            <th width="12%" class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks as $stock)
                            <tr>
                                <form action="{{ route('admin.stocks.update', $stock->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="product-info">
                                            <h6 class="mb-0">{{ $stock->product->name }}</h6>
                                            <small class="text-muted">{{ $stock->product->slug }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $stock->product->category->name }}</span>
                                    </td>
                                    <td>
                                        <input type="number" name="on_hand" class="form-control form-control-sm"
                                            value="{{ $stock->on_hand }}" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="min_stock" class="form-control form-control-sm"
                                            value="{{ $stock->min_stock }}" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="max_stock" class="form-control form-control-sm"
                                            value="{{ $stock->max_stock }}" min="0">
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'success';
                                            $statusText = 'Bình Thường';
                                            if ($stock->on_hand <= $stock->min_stock) {
                                                $statusClass = 'danger';
                                                $statusText = 'Thấp';
                                            } elseif ($stock->on_hand >= $stock->max_stock) {
                                                $statusClass = 'warning';
                                                $statusText = 'Cao';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                                </form>
                                <form action="{{ route('admin.stocks.destroy', $stock->id) }}" method="post"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xóa tồn kho này?')">Xóa</button>
                                </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="lni lni-package" style="font-size: 48px; color: #ddd;"></i>
                                        <p class="mt-2 text-muted">Chưa có dữ liệu tồn kho</p>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#addStockModal">
                                            Thêm Tồn Kho Đầu Tiên
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($stocks->count() > 0)
                <div class="mt-3">
                    {{ $stocks->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Tồn Kho Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addStockForm" action="{{ route('admin.stocks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Sản Phẩm *</label>
                            <select class="form-select" name="product_id" required>
                                <option value="">Chọn sản phẩm...</option>
                                @foreach ($products ?? [] as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}
                                        ({{ $product->category->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số Lượng Tồn Kho *</label>
                            <input type="number" class="form-control" name="on_hand" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số Lượng Tối Thiểu *</label>
                            <input type="number" class="form-control" name="min_stock" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số Lượng Tối Đa *</label>
                            <input type="number" class="form-control" name="max_stock" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm Tồn Kho</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .product-info h6 {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .action-buttons {
            white-space: nowrap;
        }

        .stock-row.editing {
            background-color: #f8f9fa;
        }

        .empty-state {
            padding: 2rem 0;
        }

        .table td {
            vertical-align: middle;
        }

        .edit-mode input {
            width: 80px;
        }

        .stock-status.bg-danger {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit functionality
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('.stock-row');
                    const stockId = this.dataset.id;

                    // Toggle to edit mode
                    row.classList.add('editing');
                    row.querySelectorAll('.view-mode').forEach(el => el.classList.add('d-none'));
                    row.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('d-none'));
                });
            });

            // Cancel edit
            document.querySelectorAll('.cancel-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('.stock-row');
                    cancelEdit(row);
                });
            });


            // Add new stock
            document.getElementById('addStockForm').addEventListener('submit', function(e) {
                // e.preventDefault();
                addStock();
            });

            function cancelEdit(row) {
                row.classList.remove('editing');
                row.querySelectorAll('.view-mode').forEach(el => el.classList.remove('d-none'));
                row.querySelectorAll('.edit-mode').forEach(el => el.classList.add('d-none'));

                // Reset input values
                row.querySelectorAll('input').forEach(input => {
                    const viewSpan = row.querySelector(`span[data-field="${input.name}"]`);
                    if (viewSpan) {
                        input.value = viewSpan.textContent.trim();
                    }
                });
            }

            function addStock() {
                const formData = new FormData(document.getElementById('addStockForm'));
            }

            function updateStockStatus(row, stock) {
                const statusBadge = row.querySelector('.stock-status');
                let statusClass = 'bg-success';
                let statusText = 'Bình Thường';

                if (stock.on_hand <= stock.min_stock) {
                    statusClass = 'bg-danger';
                    statusText = 'Thấp';
                } else if (stock.on_hand >= stock.max_stock) {
                    statusClass = 'bg-warning';
                    statusText = 'Cao';
                }

                statusBadge.className = `status-badge badge ${statusClass} stock-status`;
                statusBadge.textContent = statusText;
            }

            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                const container = document.querySelector('.container-fluid');
                const titleWrapper = container.querySelector('.title-wrapper');
                titleWrapper.insertAdjacentHTML('afterend', alertHtml);

                setTimeout(() => {
                    const alert = container.querySelector('.alert');
                    if (alert) alert.remove();
                }, 5000);
            }
        });
    </script>
@endsection
