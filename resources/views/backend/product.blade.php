@extends('backend.layouts.layout')
@section('title', 'Product Management')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
    .page-header-left {}
    .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 700; }
    .card-body-0 { padding: 0; }

    /* Search bar */
    .search-bar { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; background: #fafafa; display: flex; gap: 10px; align-items: center; }
    .search-input { flex: 1; border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 7px 12px; font-size: 12px; font-family: 'Nunito', sans-serif; }
    .search-input:focus { border-color: #1872B5; outline: none; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); }
    .filter-select { border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 7px 10px; font-size: 12px; font-family: 'Nunito', sans-serif; cursor: pointer; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); }
    .btn-sm { padding: 4px 9px; font-size: 10px; }

    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead tr { background: #f9fafb; }
    thead th { padding: 10px 12px; font-family: 'Sora', sans-serif; font-weight: 700; color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 10px 12px; color: #374151; vertical-align: middle; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 20px; font-size: 10px; font-family: 'Sora', sans-serif; font-weight: 700; }
    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-info { background: #dbeafe; color: #1e40af; }
    .badge-danger { background: #fee2e2; color: #7f1d1d; }
    .badge-primary { background: #dbeafe; color: #1e40af; }

    .price-original { font-size: 10px; color: #9ca3af; text-decoration: line-through; display: block; }
    .price-sale { font-weight: 700; color: #059669; font-size: 12px; }
    .price-regular { font-weight: 600; color: #1f2937; font-size: 12px; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .modal-overlay.show { display: flex; }
    .modal-box { background: #fff; border-radius: 12px; width: 320px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .modal-box-header { background: linear-gradient(135deg, #ef4444, #f87171); padding: 12px 16px; color: white; display: flex; align-items: center; justify-content: space-between; }
    .modal-box-header h6 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; }
    .modal-close { background: none; border: none; color: white; font-size: 16px; cursor: pointer; }
    .modal-box-body { padding: 20px 16px; text-align: center; }
    .modal-box-body p { font-size: 12px; color: #374151; margin: 0 0 6px; }
    .modal-box-body strong { color: #ef4444; font-size: 13px; }
    .modal-box-body .note { font-size: 10px; color: #9ca3af; margin-top: 6px; }
    .modal-box-footer { padding: 10px 16px; display: flex; gap: 8px; justify-content: center; border-top: 1px solid #f3f4f6; }

    /* Stats row */
    .stats-row { display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; }
    .stat-card { background: #fff; border-radius: 10px; padding: 12px 18px; border: 1px solid #e5e7eb; flex: 1; min-width: 120px; box-shadow: 0 2px 8px rgba(10,33,79,0.06); }
    .stat-number { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; }
    .stat-label { font-size: 11px; color: #6b7280; font-weight: 500; margin-top: 2px; }
    .stat-card.green .stat-number { color: #059669; }
    .stat-card.orange .stat-number { color: #d97706; }
    .stat-card.blue .stat-number { color: #1872B5; }
        .form-check.form-switch {
    width: 61%;
    margin-left: 42px!important;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    .btn.btn-sm, .ajax-upload-dragdrop .btn-sm.ajax-file-upload, .btn-group-sm > .btn, .ajax-upload-dragdrop .btn-group-sm > .ajax-file-upload {
    font-size: 9px!important;
}
    .form-group label {
    font-size: 12px;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">📦 Product Management</h1>
            <p class="page-subtitle">Manage all your products</p>
        </div>
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Product
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    @php
        $total     = $products->count();
        $published = $products->where('status','published')->count();
        $draft     = $products->where('status','draft')->count();
        $featured  = $products->where('is_featured',1)->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card blue">
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">Total Products</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number">{{ $published }}</div>
            <div class="stat-label">Published</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-number">{{ $draft }}</div>
            <div class="stat-label">Draft</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $featured }}</div>
            <div class="stat-label">Featured</div>
        </div>
    </div>

    {{-- Product List Table --}}
    <div class="page-card">
        <div class="card-header-gradient">
            <div class="card-header-row">
                <h2 class="card-header-title"><i class="fas fa-list"></i> All Products</h2>
                <span class="table-count">Total: {{ $products->count() }}</span>
            </div>
        </div>

        {{-- Search / Filter --}}
        <div class="search-bar">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by title, SKU...">
            <select class="filter-select" id="statusFilter" onchange="filterTable()">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>

        <div class="card-body-0">
            <div class="table-wrapper">
                <table id="productTable">
                    <thead>
                        <tr>
                            <th style="width:55px;text-align:center;">ID</th>
                            <th style="width:90px;">Image</th>
                            <th>Title</th>
                            <th style="width:110px;">Price</th>
                            <th style="width:75px;text-align:center;">Stock</th>
                            <th style="width:160px;">Categories</th>
                            <th style="width:90px;text-align:center;">Status</th>
                            <th style="width:150px;text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr data-title="{{ strtolower($product->title) }}" data-sku="{{ strtolower($product->sku ?? '') }}" data-status="{{ $product->status }}">
                            <td style="text-align:center;">
                                <span class="badge badge-id">#{{ $product->id }}</span>
                            </td>
                            <td>
                                @if($product->featured_image)
                                    <img src="{{ asset('uploads/products/'.$product->featured_image) }}"
                                         style="width:70px;height:54px;object-fit:cover;border-radius:6px;border:1.5px solid #e5e7eb;">
                                @else
                                    <div style="width:70px;height:54px;background:#f3f4f6;border-radius:6px;border:1.5px dashed #e5e7eb;display:flex;align-items:center;justify-content:center;font-size:18px;">📷</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:700;color:#0a214f;font-size:12px;margin-bottom:4px;">
                                    {{ Str::limit($product->title, 40) }}
                                </div>
                                @if($product->sku)
                                    <div style="font-size:10px;color:#9ca3af;margin-bottom:3px;">SKU: {{ $product->sku }}</div>
                                @endif
                                <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                    @if($product->is_featured)
                                        <span class="badge badge-warning">⭐ Featured</span>
                                    @endif
                                    @php
                                        $tabsArr = $product->extra_tabs
                                            ? (is_array($product->extra_tabs) ? $product->extra_tabs : json_decode($product->extra_tabs, true))
                                            : [];
                                    @endphp
                                    @if(!empty($tabsArr))
                                        <span class="badge badge-info"><i class="fas fa-layer-group" style="font-size:8px;"></i> {{ count($tabsArr) }} Tabs</span>
                                    @endif
                                    @if($product->variants->count() > 0)
                                        <span class="badge" style="background:#f3e8ff;color:#7c3aed;">{{ $product->variants->count() }} Variants</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($product->sale_price)
                                    <span class="price-original">₹{{ number_format($product->price, 2) }}</span>
                                    <span class="price-sale">₹{{ number_format($product->sale_price, 2) }}</span>
                                @elseif($product->price)
                                    <span class="price-regular">₹{{ number_format($product->price, 2) }}</span>
                                @else
                                    <span style="color:#9ca3af;font-size:11px;">—</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <span class="badge {{ $product->stock_quantity > 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                    @foreach($product->categories as $cat)
                                        <span class="badge badge-primary">{{ $cat->name }}</span>
                                    @endforeach
                                    @if($product->categories->count() === 0)
                                        <span style="color:#9ca3af;font-size:11px;">—</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span class="badge {{ $product->status === 'published' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $product->status === 'published' ? '✅' : '⏸' }} {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex;gap:5px;align-items:center;justify-content:center;">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('product.delete', $product->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirmDelete(event, '{{ addslashes(Str::limit($product->title, 30)) }}')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Del
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-boxes"></i>
                                    <p>No products yet. <a href="{{ route('product.create') }}" style="color:#1872B5;font-weight:700;">Add your first one!</a></p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Delete Confirm Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-box-header">
            <h6><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h6>
            <button class="modal-close" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-box-body">
            <p>Are you sure you want to delete</p>
            <strong id="deleteItemName"></strong>
            <p class="note">This action cannot be undone.</p>
        </div>
        <div class="modal-box-footer">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
let pendingDeleteForm = null;

function confirmDelete(e, name) {
    e.preventDefault();
    pendingDeleteForm = e.target;
    document.getElementById('deleteItemName').textContent = '"' + name + '"';
    document.getElementById('deleteModal').classList.add('show');
    return false;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    pendingDeleteForm = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (pendingDeleteForm) pendingDeleteForm.submit();
});

// Live search + filter
document.getElementById('searchInput').addEventListener('input', filterTable);

function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value.toLowerCase();
    document.querySelectorAll('#productTable tbody tr').forEach(function(row) {
        if (!row.dataset.title) return; // empty state row
        const matchSearch = !search || row.dataset.title.includes(search) || row.dataset.sku.includes(search);
        const matchStatus = !status || row.dataset.status === status;
        row.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}

// Auto-dismiss alerts
setTimeout(() => { document.querySelectorAll('.alert-success,.alert-danger').forEach(el => el.remove()); }, 5000);
</script>

@endsection
