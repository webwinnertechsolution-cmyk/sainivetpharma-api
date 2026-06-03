@extends('backend.layouts.layout')
@section('title', 'Product Categories')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1500px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    /* Alerts */
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

    /* Cards */
    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-gradient { background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%); padding: 12px 20px; color: #fff; }
    .card-header-warning  { background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%); padding: 12px 20px; color: #fff; }
    .card-header-dark     { background: linear-gradient(135deg, #111827 0%, #374151 100%); padding: 12px 20px; color: #fff; }

    .card-header-title { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 8px; }
    .card-header-row   { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 700; }

    .card-body { padding: 16px; }

    /* Form */
    .form-label { font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700; color: #0a214f; margin-bottom: 6px; display: block; }
    .form-label small { display: block; font-size: 10px; font-weight: 500; color: #6b7280; margin-top: 2px; }
    .form-control, .form-select, textarea.form-control {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 7px 10px; font-size: 12px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus, textarea.form-control:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .form-group { margin-bottom: 12px; }
    .text-muted-sm { color: #6b7280; font-size: 10px; margin-top: 3px; display: block; }
    .text-danger { color: #ef4444; }

    .form-check { display: flex; align-items: center; gap: 8px; }
    .form-check-input { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #1872B5; }
    .form-check-label { font-size: 12px; color: #0a214f; font-weight: 600; margin: 0; cursor: pointer; }
    .form-switch .form-check-input { width: 36px; height: 18px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }

    /* Section labels inside form */
    .section-divider {
        font-family: 'Sora', sans-serif; font-size: 10px; font-weight: 700;
        color: #1872B5; text-transform: uppercase; letter-spacing: 0.08em;
        background: #eff6ff; border-left: 3px solid #1872B5;
        padding: 5px 10px; border-radius: 0 5px 5px 0;
        margin: 14px 0 10px; display: flex; align-items: center; gap: 6px;
    }

    /* Buttons */
    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary   { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover   { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-warning   { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover   { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover    { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 4px 9px; font-size: 10px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }
    .action-btns { display: flex; gap: 5px; align-items: center; justify-content: center; flex-wrap: nowrap; }

    /* Two col */
    .two-col { display: grid; grid-template-columns: 460px 1fr; gap: 16px; align-items: start; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead tr { background: #f9fafb; }
    thead th { padding: 10px 12px; font-family: 'Sora', sans-serif; font-weight: 700; color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody tr.row-editing { background: #fffbeb; }
    tbody td { padding: 10px 12px; color: #374151; vertical-align: middle; }

    /* Badges */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 20px; font-size: 10px; font-family: 'Sora', sans-serif; font-weight: 700; }
    .badge-success   { background: #d1fae5; color: #065f46; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-id        { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }
    .badge-danger    { background: #fee2e2; color: #7f1d1d; }
    .badge-info      { background: #e0f2fe; color: #0369a1; }
    .badge-warning-soft { background: #fef3c7; color: #92400e; }
    .badge-count     { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 11px; padding: 3px 10px; }
    .badge-count-zero { background: #f3f4f6; color: #9ca3af; border: 1px solid #e5e7eb; font-size: 11px; padding: 3px 10px; }
    .badge-seo-ok    { background: #d1fae5; color: #065f46; }
    .badge-seo-miss  { background: #fef3c7; color: #92400e; }

    /* Category image in table */
    .cat-thumb { width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1.5px solid #e5e7eb; }
    .cat-thumb-placeholder { width: 40px; height: 40px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #d1d5db; font-size: 16px; border: 1.5px solid #e5e7eb; }

    /* Char counter */
    .char-count { font-size: 10px; font-weight: 700; color: #6b7280; transition: color .2s; }
    .char-count.warn { color: #f59e0b; }
    .char-count.over { color: #dc2626; }

    /* Image preview */
    .img-preview { margin-top: 6px; }
    .img-preview img { max-height: 70px; border-radius: 5px; border: 1.5px solid #e5e7eb; }

    /* Delete Modal */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .modal-overlay.show { display: flex; }
    .modal-box { background: #fff; border-radius: 12px; width: 320px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .modal-box-header { background: linear-gradient(135deg, #ef4444, #f87171); padding: 12px 16px; color: white; display: flex; align-items: center; justify-content: space-between; }
    .modal-box-header h6 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; }
    .modal-close-btn { background: none; border: none; color: white; font-size: 16px; cursor: pointer; }
    .modal-box-body { padding: 20px 16px; text-align: center; }
    .modal-box-body p { font-size: 12px; color: #374151; margin: 0 0 6px; }
    .modal-box-body strong { color: #ef4444; font-size: 13px; }
    .modal-box-body .note { font-size: 10px; color: #9ca3af; margin-top: 6px; }
    .modal-box-footer { padding: 10px 16px; display: flex; gap: 8px; justify-content: center; border-top: 1px solid #f3f4f6; }
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
    /* Responsive */
    @media (max-width: 1200px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 768px) { .btn-group-custom { flex-direction: column-reverse; } }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🏷️ Product Categories</h1>
        <p class="page-subtitle">Manage categories used to organize your products</p>
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

        {{-- ══════════════════════
             FORM CARD
        ══════════════════════ --}}
        <div class="page-card" style="position: sticky; top: 20px;">
            <div class="{{ isset($editCategory) ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if(isset($editCategory))
                        <i class="fas fa-pen"></i> Edit Category — {{ $editCategory->name }}
                    @else
                        <i class="fas fa-plus-circle"></i> Add New Category
                    @endif
                </h2>
            </div>
            <div class="card-body">

                <form action="{{ isset($editCategory) ? route('product.category.update', $editCategory->id) : route('product.category.store') }}"
                      method="POST" enctype="multipart/form-data">
                @csrf

                    {{-- ─── BASIC INFO ─── --}}
                    <div class="section-divider"><i class="fas fa-info-circle"></i> Basic Information</div>

                    <div class="form-group">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $editCategory->name ?? '') }}"
                               placeholder="e.g. Electronics, Clothing..."
                               oninput="autoSlug(this.value)" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Slug
                            <small>Leave blank to auto-generate from name</small>
                        </label>
                        <input type="text" name="slug" id="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $editCategory->slug ?? '') }}"
                               placeholder="auto-generated-from-name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 80px; gap:10px;">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2"
                                      placeholder="Short description...">{{ old('description', $editCategory->description ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" min="0"
                                   value="{{ old('sort_order', $editCategory->sort_order ?? 0) }}">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <div class="form-group">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*" onchange="previewImage(this, 'imagePreview')">
                            <span class="text-muted-sm">Max 2MB · JPG, PNG, WebP</span>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="img-preview" id="imagePreview">
                                @if(isset($editCategory) && $editCategory->image)
                                    <img src="{{ asset('uploads/product-categories/' . $editCategory->image) }}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Image Alt Tag</label>
                            <input type="text" name="image_alt" class="form-control"
                                   value="{{ old('image_alt', $editCategory->image_alt ?? '') }}"
                                   placeholder="Descriptive alt text">
                        </div>
                    </div>

                    <div class="form-check form-switch" style="margin: 4px 0 12px;">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                               value="1" {{ old('is_active', $editCategory->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (Visible on frontend)</label>
                    </div>

                    {{-- ─── SEO ─── --}}
                    <div class="section-divider"><i class="fas fa-search"></i> SEO Settings</div>

                    <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title"
                               class="form-control @error('meta_title') is-invalid @enderror"
                               value="{{ old('meta_title', $editCategory->meta_title ?? '') }}"
                               placeholder="SEO title — blank to use category name" maxlength="255"
                               oninput="charCount(this, 'metaTitleCount', 60)">
                        <div style="display:flex; justify-content:space-between;">
                            <span class="text-muted-sm">Recommended: 50–60 characters</span>
                            <span id="metaTitleCount" class="char-count">0 / 60</span>
                        </div>
                        @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords"
                               class="form-control @error('meta_keywords') is-invalid @enderror"
                               value="{{ old('meta_keywords', $editCategory->meta_keywords ?? '') }}"
                               placeholder="keyword1, keyword2, keyword3">
                        <span class="text-muted-sm">Comma separated</span>
                        @error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description"
                                  class="form-control @error('meta_description') is-invalid @enderror"
                                  rows="2" maxlength="500"
                                  placeholder="SEO description (150–160 chars)"
                                  oninput="charCount(this, 'metaDescCount', 160)">{{ old('meta_description', $editCategory->meta_description ?? '') }}</textarea>
                        <div style="display:flex; justify-content:space-between;">
                            <span class="text-muted-sm">Recommended: 150–160 characters</span>
                            <span id="metaDescCount" class="char-count">0 / 160</span>
                        </div>
                        @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- ─── OG / SOCIAL ─── --}}
                    <div class="section-divider"><i class="fas fa-share-alt"></i> Social / OG Settings</div>

                    <div class="form-group">
                        <label class="form-label">OG Title</label>
                        <input type="text" name="og_title"
                               class="form-control @error('og_title') is-invalid @enderror"
                               value="{{ old('og_title', $editCategory->og_title ?? '') }}"
                               placeholder="Social share title — blank to use meta title">
                        @error('og_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <div class="form-group">
                            <label class="form-label">OG Image
                                <small>Recommended: 1200×630px</small>
                            </label>
                            <input type="file" name="og_image"
                                   class="form-control @error('og_image') is-invalid @enderror"
                                   accept="image/*" onchange="previewImage(this, 'ogImagePreview')">
                            @error('og_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="img-preview" id="ogImagePreview">
                                @if(isset($editCategory) && $editCategory->og_image)
                                    <img src="{{ asset('uploads/product-categories/og/' . $editCategory->og_image) }}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">OG Image Alt</label>
                            <input type="text" name="og_image_alt" class="form-control"
                                   value="{{ old('og_image_alt', $editCategory->og_image_alt ?? '') }}"
                                   placeholder="OG image alt text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">OG Description</label>
                        <textarea name="og_description"
                                  class="form-control @error('og_description') is-invalid @enderror"
                                  rows="2"
                                  placeholder="Social share description — blank to use meta description">{{ old('og_description', $editCategory->og_description ?? '') }}</textarea>
                        @error('og_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="btn-group-custom">
                        @if(isset($editCategory))
                            <a href="{{ route('product.category') }}" class="btn btn-secondary">
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

        {{-- ══════════════════════
             TABLE CARD
        ══════════════════════ --}}
        <div class="page-card">
            <div class="card-header-dark">
                <div class="card-header-row">
                    <h2 class="card-header-title"><i class="fas fa-list"></i> All Product Categories</h2>
                    <span class="table-count">Total: {{ $categories->count() }}</span>
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50px; text-align:center;">#</th>
                                <th style="width:55px; text-align:center;">Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th style="width:110px; text-align:center;">Products</th>
                                <th style="width:80px; text-align:center;">SEO</th>
                                <th style="width:75px; text-align:center;">Status</th>
                                <th style="width:65px; text-align:center;">Order</th>
                                <th style="width:110px; text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr class="{{ isset($editCategory) && $editCategory->id == $category->id ? 'row-editing' : '' }}">

                                <td style="text-align:center;">
                                    <span class="badge badge-id">#{{ $loop->iteration }}</span>
                                </td>

                                {{-- Image --}}
                                <td style="text-align:center;">
                                    @if($category->image)
                                        <img src="{{ asset('uploads/product-categories/' . $category->image) }}"
                                             alt="{{ $category->image_alt }}" class="cat-thumb">
                                    @else
                                        <div class="cat-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Name + Description --}}
                                <td>
                                    <div style="font-weight:700; color:#0a214f; font-size:12px;">{{ $category->name }}</div>
                                    @if($category->description)
                                        <div style="font-size:10px; color:#6b7280; margin-top:2px;">
                                            {{ Str::limit($category->description, 55) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Slug --}}
                                <td>
                                    <span style="font-family:'Courier New',monospace; font-size:11px; color:#1e40af; background:#eff6ff; padding:2px 7px; border-radius:4px; border:1px solid #bfdbfe;">
                                        {{ $category->slug }}
                                    </span>
                                </td>

                                {{-- ✅ Products Count --}}
                                <td style="text-align:center;">
                                    @if(($category->products_count ?? 0) > 0)
                                        <span class="badge badge-count">
                                            🛍️ {{ $category->products_count }} products
                                        </span>
                                    @else
                                        <span class="badge badge-count-zero">
                                            0 products
                                        </span>
                                    @endif
                                </td>

                                {{-- SEO --}}
                                <td style="text-align:center;">
                                    @if($category->meta_title || $category->meta_description)
                                        <span class="badge badge-seo-ok">✅ Done</span>
                                    @else
                                        <span class="badge badge-seo-miss">⚠️ Missing</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td style="text-align:center;">
                                    @if($category->is_active)
                                        <span class="badge badge-success">✅ Active</span>
                                    @else
                                        <span class="badge badge-danger">❌ Off</span>
                                    @endif
                                </td>

                                {{-- Sort Order --}}
                                <td style="text-align:center;">
                                    <span class="badge badge-secondary">{{ $category->sort_order }}</span>
                                </td>

                                {{-- Actions — ek line mein --}}
                                <td style="text-align:center;">
                                    <div class="action-btns">
                                        <a href="{{ route('product.category.edit', $category->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('product.category.delete', $category->id) }}"
                                              method="POST"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($category->name) }}')">
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
                                <td colspan="9">
                                    <div class="empty-state" style="text-align:center; padding:40px 20px; color:#6b7280;">
                                        <i class="fas fa-folder-open" style="font-size:36px; display:block; margin-bottom:10px; opacity:0.4;"></i>
                                        <p style="font-size:12px; margin:0;">No categories yet. Add your first one!</p>
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
            <button class="modal-close-btn" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-box-body">
            <p>Are you sure you want to delete</p>
            <strong id="deleteItemName"></strong>
            <p class="note">Categories with products cannot be deleted.</p>
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
// ── Delete Modal ──
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

// ── Auto Slug ──
function autoSlug(name) {
    const slugField = document.getElementById('slug');
    if (slugField.dataset.manually !== 'true') {
        slugField.value = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
}
document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manually = 'true';
    if (this.value === '') this.dataset.manually = 'false';
});

// ── Image Preview ──
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxHeight = '70px';
            img.style.borderRadius = '5px';
            img.style.border = '1.5px solid #e5e7eb';
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Char Counter ──
function charCount(el, counterId, limit) {
    const len = el.value.length;
    const counter = document.getElementById(counterId);
    counter.textContent = len + ' / ' + limit;
    counter.className = 'char-count';
    if (len > limit) counter.classList.add('over');
    else if (len > limit * 0.85) counter.classList.add('warn');
}

// ── Init counters ──
document.addEventListener('DOMContentLoaded', function () {
    const mt = document.getElementById('meta_title');
    const md = document.getElementById('meta_description');
    if (mt) charCount(mt, 'metaTitleCount', 60);
    if (md) charCount(md, 'metaDescCount', 160);
});

// ── Auto dismiss alerts ──
setTimeout(() => {
    document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
}, 5000);
</script>

@endsection
