@extends('backend.layouts.layout')
@section('title', 'Home Categories')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; padding: 0; }
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
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-warning {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 700; }

    .card-body { padding: 16px; }

    .form-label {
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        color: #0a214f; margin-bottom: 6px; display: block;
    }
    .form-label small { display: block; font-size: 10px; font-weight: 500; color: #6b7280; margin-top: 2px; }

    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 7px 10px; font-size: 12px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .form-group { margin-bottom: 12px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }
    .text-muted-sm { color: #6b7280; font-size: 11px; margin-top: 4px; display: block; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 5px 10px; font-size: 11px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Two col layout */
    .two-col { display: grid; grid-template-columns: 420px 1fr; gap: 16px; align-items: start; }

    /* Current image preview */
    .img-preview {
        width: 60px; height: 60px; object-fit: cover;
        border-radius: 50%; border: 2px solid #dee2e6; margin-top: 8px;
    }
    .img-preview-label { font-size: 10px; color: #6b7280; margin-top: 4px; display: block; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead tr { background: #f9fafb; }
    thead th {
        padding: 10px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 10px 12px; color: #374151; vertical-align: middle; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px; border-radius: 20px; font-size: 10px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }

    .cat-img {
        width: 44px; height: 44px; object-fit: cover;
        border-radius: 50%; border: 2px solid #e5e7eb;
    }
    .cat-img-placeholder { color: #9ca3af; font-size: 11px; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    /* Delete Modal */
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

    .form-group label { font-size: 11px; line-height: 1; vertical-align: top; margin-bottom: 0.5rem; }

    @media (max-width: 1024px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🏷️ Home Categories</h1>
        <p class="page-subtitle">Manage categories displayed on the homepage</p>
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

    <div class="two-col">

        {{-- FORM CARD --}}
        <div class="page-card">
            <div class="{{ isset($editCategory) ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if(isset($editCategory))
                        <i class="fas fa-pen"></i> Edit Category #{{ $editCategory->id }}
                    @else
                        <i class="fas fa-plus-circle"></i> Add New Category
                    @endif
                </h2>
            </div>
            <div class="card-body">

                @if(isset($editCategory))
                    <form action="{{ route('home.category.update', $editCategory->id) }}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                @else
                    <form action="{{ route('home.category.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                @csrf

                {{-- Title --}}
                <div class="form-group">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $editCategory->title ?? '') }}"
                        placeholder="e.g. Insecticides" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- URL --}}
                <div class="form-group">
                    <label class="form-label">Link URL</label>
                    <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                        value="{{ old('url', $editCategory->url ?? '') }}"
                        placeholder="e.g. /collections/insecticides">
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Image --}}
                <div class="form-group">
                    <label class="form-label">
                        Image
                        <small>{{ isset($editCategory) ? 'Leave blank to keep existing image' : 'Required' }}</small>
                    </label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                        accept="image/*" {{ isset($editCategory) ? '' : 'required' }}>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    @if(isset($editCategory) && $editCategory->image)
                        <div class="mt-2">
                            <img src="{{ asset('uploads/home-categories/' . $editCategory->image) }}"
                                alt="{{ $editCategory->alt_tag }}"
                                class="img-preview">
                            <small class="img-preview-label">Current image</small>
                        </div>
                    @endif
                </div>

                {{-- Alt Tag --}}
                <div class="form-group">
                    <label class="form-label">Image Alt Tag</label>
                    <input type="text" name="alt_tag" class="form-control"
                        value="{{ old('alt_tag', $editCategory->alt_tag ?? '') }}"
                        placeholder="Image description for SEO">
                </div>

                {{-- Sort Order --}}
                <div class="form-group">
                    <label class="form-label">
                        Sort Order
                        <small>Lower number = shown first</small>
                    </label>
                    <input type="number" name="sort_order" class="form-control" min="0"
                        value="{{ old('sort_order', $editCategory->sort_order ?? 0) }}">
                </div>

                {{-- Buttons --}}
                <div class="btn-group-custom">
                    @if(isset($editCategory))
                        <a href="{{ route('home.category') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Category
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Category
                        </button>
                    @endif
                </div>

                </form>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="page-card">
            <div class="card-header-gradient">
                <div class="card-header-row">
                    <h2 class="card-header-title"><i class="fas fa-list"></i> All Categories</h2>
                    <span class="table-count">Total: {{ $categories->count() }}</span>
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th style="width:70px">Image</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th style="width:70px;text-align:center;">Order</th>
                                <th style="width:140px;text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                            <tr>
                                <td style="text-align:center;">
                                    <span class="badge badge-id">#{{ $cat->id }}</span>
                                </td>
                                <td>
                                    @if($cat->image)
                                        <img src="{{ asset('uploads/home-categories/' . $cat->image) }}"
                                            alt="{{ $cat->alt_tag }}"
                                            class="cat-img">
                                    @else
                                        <span class="cat-img-placeholder">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#0a214f;font-size:12px;">{{ $cat->title }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $cat->url ?: '— No URL —' }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-weight:700;color:#0a214f;font-size:12px;">{{ $cat->sort_order }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <a href="{{ route('home.category.edit', $cat->id) }}"
                                       class="btn btn-warning btn-sm" style="margin-bottom:4px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('home.category.delete', $cat->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirmDelete(event, '{{ addslashes($cat->title) }}')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-tags"></i>
                                        <p>No categories yet. Add your first one!</p>
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
</div>

{{-- Delete Modal --}}
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

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (pendingDeleteForm) pendingDeleteForm.submit();
    });

    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

@endsection
