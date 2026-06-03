@extends('backend.layouts.layout')
@section('title', isset($editProduct) ? 'Edit Product' : 'Add Product')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
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
    .alert-validation {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 14px; border-radius: 8px; margin-bottom: 14px;
        font-weight: 500; font-size: 12px;
    }
    .alert-validation ul { margin: 6px 0 0 16px; padding: 0; }
    .alert-validation li { margin-bottom: 2px; }

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
    .card-header-light {
        background: #f9fafb; padding: 10px 16px;
        border-bottom: 1.5px solid #e5e7eb;
    }
    .card-header-success {
        background: linear-gradient(135deg, #065f46, #059669);
        padding: 10px 16px; color: #ffffff;
    }
    .card-header-info {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        padding: 10px 16px; color: #ffffff;
    }
    .card-header-purple {
        background: linear-gradient(135deg, #4c1d95, #7c3aed);
        padding: 10px 16px; color: #ffffff;
    }
    .card-header-orange {
        background: linear-gradient(135deg, #92400e, #d97706);
        padding: 10px 16px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .card-header-light .card-header-title { color: #0a214f; font-size: 12px; }

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
    .form-row { display: grid; gap: 12px; }
    .form-row-2 { grid-template-columns: 1fr 1fr; }
    .form-row-3 { grid-template-columns: 1fr 1fr 1fr; }
    .form-row-4 { grid-template-columns: 1fr 1fr 1fr 1fr; }
    .form-hint { font-size: 10px; color: #9ca3af; margin-top: 3px; display: block; }
    .slug-preview { background: #f1f5f9; padding: 7px 10px; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 11px; color: #1e40af; margin-top: 5px; border: 1px solid #e0e7ff; }

    .form-check { display: flex; align-items: center; gap: 8px; }
    .form-check-input { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #1872B5; }
    .form-check-label { font-size: 12px; color: #374151; font-weight: 500; margin: 0; cursor: pointer; }
    .form-switch .form-check-input { width: 36px; height: 18px; }

    /* Checkbox Grid Styles */
    .checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
        margin-top: 8px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        max-height: 240px;
        overflow-y: auto;
    }
    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .checkbox-item:hover {
        border-color: #1872B5;
        background: #eff6ff;
    }
    .checkbox-item input[type="checkbox"] {
        cursor: pointer;
        width: 16px;
        height: 16px;
        accent-color: #1872B5;
        flex-shrink: 0;
    }
    .checkbox-item input[type="checkbox"]:checked + label {
        color: #0a214f;
        font-weight: 600;
    }
    .checkbox-item label {
        cursor: pointer;
        margin: 0;
        font-size: 12px;
        color: #374151;
        flex: 1;
        user-select: none;
    }

    .cta-group { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 6px; }
    .cta-option { display: flex; align-items: center; gap: 6px; background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 6px 12px; cursor: pointer; transition: all 0.2s; }
    .cta-option:has(input:checked) { border-color: #1872B5; background: #eff6ff; }
    .cta-option input { accent-color: #1872B5; }
    .cta-option label { font-size: 12px; font-weight: 600; color: #374151; cursor: pointer; margin: 0; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }

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
    .btn-sm { padding: 4px 9px; font-size: 10px; }
    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    .img-preview-box {
        margin-top: 8px; display: inline-block; position: relative;
        border: 1.5px solid #e5e7eb; border-radius: 8px; overflow: hidden;
    }
    .img-preview-box img { display: block; max-width: 180px; max-height: 130px; object-fit: cover; }
    .img-preview-box .remove-btn {
        position: absolute; top: 4px; right: 4px;
        background: rgba(239,68,68,0.9); border: none; color: white;
        border-radius: 4px; padding: 2px 7px; font-size: 10px; cursor: pointer;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .img-label { font-size: 10px; color: #9ca3af; margin-top: 4px; display: block; }
    .gallery-grid { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
    .gallery-thumb { position: relative; width: 90px; }
    .gallery-thumb img { width: 84px; height: 84px; object-fit: cover; border: 1.5px solid #e5e7eb; border-radius: 6px; display: block; }
    .gallery-thumb .remove-btn { position: absolute; top: 2px; right: 8px; background: rgba(239,68,68,0.9); border: none; color: white; border-radius: 3px; padding: 1px 6px; font-size: 9px; cursor: pointer; }
    .gallery-thumb .new-badge { position: absolute; bottom: 2px; left: 2px; background: #0ea5e9; color: white; font-size: 9px; padding: 1px 5px; border-radius: 3px; }
    .video-thumb { width: 84px; height: 84px; background: #111827; border: 1.5px solid #e5e7eb; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    .video-thumb span { font-size: 22px; }
    .video-thumb small { color: #9ca3af; font-size: 9px; margin-top: 3px; }

    /* Variant Builder */
    .vg-card {
        background: #fff; border: 1.5px solid #e0e7ff; border-radius: 10px;
        margin-bottom: 10px; overflow: hidden;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .vg-card:hover { border-color: #6366f1; box-shadow: 0 2px 10px rgba(99,102,241,0.12); }
    .vg-header {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; background: #f5f3ff; border-bottom: 1px solid #e0e7ff;
    }
    .vg-header input[type="text"] {
        flex: 1; border: 1.5px solid #e0e7ff; border-radius: 6px;
        padding: 6px 10px; font-size: 12px; font-weight: 600; color: #1a2332;
        background: #fff; outline: none;
    }
    .vg-header input[type="text"]:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
    .vg-type-label { font-size: 10px; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap; font-family: 'Sora', sans-serif; }
    .btn-vg-remove { background: none; border: none; color: #ef4444; padding: 5px 8px; border-radius: 5px; cursor: pointer; font-size: 13px; transition: background 0.15s; flex-shrink: 0; }
    .btn-vg-remove:hover { background: #fef2f2; }
    .vg-options-area { padding: 12px 14px 10px; }
    .vg-tags-wrap { display: flex; flex-wrap: wrap; gap: 6px; min-height: 32px; align-items: center; margin-bottom: 8px; }
    .vg-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1d4ed8;
        border-radius: 20px; padding: 3px 10px 3px 10px;
        font-size: 11px; font-weight: 600; cursor: default;
        animation: tagPop 0.15s ease;
    }
    @keyframes tagPop { from { transform: scale(0.85); opacity:0; } to { transform: scale(1); opacity:1; } }
    .vg-tag .tag-x { background: none; border: none; padding: 0 0 0 2px; cursor: pointer; color: #93c5fd; font-size: 11px; transition: color 0.15s; }
    .vg-tag .tag-x:hover { color: #ef4444; }
    .vg-input-row { display: flex; gap: 7px; align-items: center; margin-top: 3px; }
    .vg-opt-input {
        flex: 1; border: 1.5px dashed #bfdbfe; border-radius: 6px;
        padding: 6px 10px; font-size: 12px; color: #1a2332; background: #f9faff;
        outline: none; transition: all 0.2s;
    }
    .vg-opt-input:focus { border-color: #6366f1; border-style: solid; background: #fff; }
    .btn-add-opt { background: #6366f1; color: #fff; border: none; border-radius: 6px; padding: 6px 13px; font-size: 11px; font-weight: 700; cursor: pointer; font-family: 'Sora', sans-serif; }
    .btn-add-opt:hover { background: #4f46e5; }
    .vg-hint { font-size: 10px; color: #9ca3af; margin-top: 5px; }
    .btn-add-vg-type {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        width: 100%; background: #fff; border: 2px dashed #6366f1; color: #6366f1;
        border-radius: 8px; padding: 9px 16px; font-size: 12px; font-weight: 700;
        cursor: pointer; margin-top: 4px; transition: all 0.15s; font-family: 'Sora', sans-serif;
    }
    .btn-add-vg-type:hover { background: #f5f3ff; }

    .gen-wrap {
        background: #f5f3ff; border: 1.5px solid #ddd6fe;
        border-radius: 10px; margin-top: 14px; overflow: hidden;
        animation: fadeIn 0.25s ease;
    }
    @keyframes fadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
    .gen-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 14px; background: #ede9fe; border-bottom: 1px solid #ddd6fe;
    }
    .gen-head h6 { margin: 0; font-size: 12px; font-weight: 700; color: #4c1d95; text-transform: uppercase; letter-spacing: 0.04em; font-family: 'Sora', sans-serif; }
    .gen-badge { background: #6366f1; color: #fff; font-size: 10px; font-weight: 700; border-radius: 12px; padding: 2px 9px; }
    .gen-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .gen-table th { background: #ede9fe; font-size: 10px; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em; padding: 7px 12px; text-align: left; border-bottom: 1px solid #ddd6fe; font-family: 'Sora', sans-serif; }
    .gen-table td { padding: 7px 12px; color: #1a2332; border-bottom: 1px solid #ede9fe; vertical-align: middle; }
    .gen-table tr:last-child td { border-bottom: none; }
    .gen-table tr:hover td { background: #f0ebff; }
    .gen-name { font-weight: 700; color: #4c1d95; font-size: 11px; }
    .gen-input { border: 1.5px solid #ddd6fe; border-radius: 5px; padding: 4px 8px; font-size: 11px; width: 100%; outline: none; background: #fff; }
    .gen-input:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.1); }
    .gen-input.compare-price-input { border-color: #fecaca; background: #fff9f9; }
    .gen-input.compare-price-input:focus { border-color: #ef4444; }
    .compare-price-hint { font-size: 9px; color: #ef4444; margin-top: 2px; display: block; }
    .gen-footer-note { padding: 7px 14px; background: #fff8e1; border-top: 1px solid #ddd6fe; font-size: 10px; color: #92400e; }

    .variant-img-existing { width: 48px; height: 48px; object-fit: cover; border: 1.5px solid #ddd6fe; border-radius: 5px; margin-bottom: 4px; display: block; }
    .variant-img-placeholder { width: 48px; height: 48px; background: #f5f3ff; border: 1.5px dashed #ddd6fe; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; font-size: 16px; }
    .variant-img-input { border: 1.5px dashed #ddd6fe !important; background: #f9faff !important; padding: 2px 5px !important; font-size: 10px !important; cursor: pointer; }
    .variant-img-preview { margin-top: 4px; display: none; }
    .variant-img-preview img { width: 48px; height: 48px; object-fit: cover; border: 1.5px solid #34d399; border-radius: 5px; display: block; }

    /* Extra Tabs */
    .tab-item {
        background: #fff; border: 1.5px solid #d1fae5; border-radius: 10px;
        padding: 14px; margin-bottom: 10px; position: relative;
        transition: border-color 0.2s, box-shadow 0.2s;
        animation: tabSlideIn 0.2s ease;
    }
    @keyframes tabSlideIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
    .tab-item:hover { border-color: #059669; box-shadow: 0 2px 10px rgba(5,150,105,0.10); }
    .tab-header-row { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #d1fae5; }
    .tab-number-badge { background: #059669; color: #fff; font-size: 10px; font-weight: 700; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-family: 'Sora', sans-serif; }
    .tab-label { font-size: 12px; font-weight: 700; color: #065f46; text-transform: uppercase; letter-spacing: 0.05em; flex: 1; font-family: 'Sora', sans-serif; }
    .btn-remove-tab { background: none; border: none; color: #ef4444; padding: 3px 7px; border-radius: 5px; cursor: pointer; font-size: 12px; transition: background 0.15s; }
    .btn-remove-tab:hover { background: #fef2f2; }
    .btn-add-tab {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        width: 100%; background: #fff; border: 2px dashed #059669; color: #059669;
        border-radius: 8px; padding: 9px 16px; font-size: 12px; font-weight: 700;
        cursor: pointer; margin-top: 4px; transition: all 0.15s; font-family: 'Sora', sans-serif;
    }
    .btn-add-tab:hover { background: #f0fdf4; }
    .no-tabs-msg { text-align: center; padding: 24px; color: #9ca3af; font-size: 12px; }
    .no-tabs-msg i { font-size: 26px; margin-bottom: 8px; display: block; color: #bbf7d0; }
    .tab-ck-container { border: 1.5px solid #e5e7eb; border-radius: 6px; min-height: 140px; overflow: hidden; }
    .tab-ck-container .ck-editor__editable { min-height: 140px; }

    .seo-section { background: #f9fafb; border-radius: 8px; padding: 14px; }
    .info-tip { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 8px 12px; font-size: 11px; color: #1d4ed8; margin-bottom: 12px; display: flex; align-items: flex-start; gap: 7px; }
    .info-tip i { flex-shrink: 0; margin-top: 1px; }

    /* Back breadcrumb */
    .breadcrumb-bar { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 12px; color: #6b7280; }
    .breadcrumb-bar a { color: #1872B5; text-decoration: none; font-weight: 600; }
    .breadcrumb-bar a:hover { text-decoration: underline; }
    .breadcrumb-bar .sep { opacity: 0.4; }

    @media (max-width: 768px) {
        .form-row-2, .form-row-3, .form-row-4 { grid-template-columns: 1fr; }
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
        .checkbox-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
    }
</style>

<div class="page-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-bar">
        <a href="{{ route('product') }}"><i class="fas fa-boxes"></i> Products</a>
        <span class="sep">›</span>
        <span>{{ isset($editProduct) ? 'Edit: '.Str::limit($editProduct->title, 40) : 'Add New Product' }}</span>
    </div>

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ isset($editProduct) ? '✏️ Edit Product' : '➕ Add New Product' }}
            </h1>
            <p class="page-subtitle">
                {{ isset($editProduct) ? 'Update product details below' : 'Fill in the details to create a new product' }}
            </p>
        </div>
        <a href="{{ route('product') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="alert-validation">
            <strong>⚠️ Validation Errors:</strong>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- FORM --}}
    <form id="productForm"
          action="{{ isset($editProduct) ? route('product.update', $editProduct->id) : route('product.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf

        {{-- BASIC INFO --}}
        <div class="page-card">
            <div class="card-header-light">
                <h3 class="card-header-title"><i class="fas fa-info-circle text-primary"></i> Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Product Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title"
                           value="{{ old('title', $editProduct->title ?? '') }}"
                           placeholder="e.g. Premium Conveyor Belt Guard" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                           id="slug" name="slug"
                           value="{{ old('slug', $editProduct->slug ?? '') }}"
                           placeholder="url-friendly-slug" required>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="slug-preview">🔗 <span id="slug-text">{{ isset($editProduct) && $editProduct->slug ? url('product/'.$editProduct->slug) : 'Will generate from title' }}</span></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Overview / Short Description</label>
                    <textarea class="form-control" name="overview" rows="2"
                              placeholder="Brief product description for listings">{{ old('overview', $editProduct->overview ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Full Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="editor" name="description" rows="6">{{ old('description', $editProduct->description ?? '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- EXTRA TABS --}}
        <div class="page-card">
            <div class="card-header-success">
                <div class="card-header-row">
                    <h3 class="card-header-title"><i class="fas fa-layer-group"></i> Extra Tabs <small style="font-size:10px;font-weight:500;opacity:0.8;">(Specifications, Features, etc.)</small></h3>
                    <button type="button" class="btn btn-sm" style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.4);" onclick="addTab()">
                        <i class="fas fa-plus"></i> Add Tab
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="tabs-container">
                    @php
                        $existingTabs = [];
                        if (isset($editProduct) && $editProduct->extra_tabs) {
                            $decoded = is_array($editProduct->extra_tabs)
                                ? $editProduct->extra_tabs
                                : json_decode($editProduct->extra_tabs, true);
                            $existingTabs = $decoded ?: [];
                        }
                    @endphp

                    @foreach($existingTabs as $ti => $tab)
                    <div class="tab-item" id="tab-item-{{ $ti }}">
                        <div class="tab-header-row">
                            <span class="tab-number-badge">{{ $ti + 1 }}</span>
                            <span class="tab-label">Tab {{ $ti + 1 }}</span>
                            <button type="button" class="btn-remove-tab" onclick="removeTab(this)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-heading me-1" style="color:#6366f1;"></i> Tab Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tab_titles[]"
                                   value="{{ $tab['title'] ?? '' }}"
                                   placeholder="e.g. Specifications, Features, How to Use">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label"><i class="fas fa-align-left me-1" style="color:#6366f1;"></i> Tab Content</label>
                            <input type="hidden" name="tab_contents[]" id="tab-hidden-{{ $ti }}" value="{{ $tab['content'] ?? '' }}">
                            <div id="tab-editor-{{ $ti }}" class="tab-ck-container" data-hidden-id="tab-hidden-{{ $ti }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="no-tabs-msg" class="no-tabs-msg" style="{{ count($existingTabs) > 0 ? 'display:none;' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    No extra tabs yet.<br>
                    <span style="font-size:11px;">Click <strong>+ Add Tab</strong> to add Specifications, Features, FAQs, etc.</span>
                </div>

                <button type="button" class="btn-add-tab" onclick="addTab()">
                    <i class="fas fa-plus-circle"></i> Add New Tab
                </button>
            </div>
        </div>

        {{-- IMAGES --}}
        <div class="page-card">
            <div class="card-header-info">
                <h3 class="card-header-title"><i class="fas fa-images"></i> Product Images</h3>
            </div>
            <div class="card-body">
                <div class="form-row form-row-2">
                    <div>
                        <div class="form-group">
                            <label class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                   name="featured_image" accept="image/*"
                                   onchange="previewImage(event,'featured')">
                            @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if(isset($editProduct) && $editProduct->featured_image)
                                <div class="img-preview-box mt-2" id="featured-current-wrap">
                                    <img src="{{ asset('uploads/products/'.$editProduct->featured_image) }}">
                                    <button type="button" class="remove-btn" onclick="removeFeaturedImage()">✕</button>
                                    <input type="hidden" name="remove_featured_image" id="remove_featured_image" value="0">
                                </div>
                                <span class="img-label">Current featured image</span>
                            @endif
                            <div id="featured-preview" style="display:none;" class="img-preview-box mt-2">
                                <img id="featured-img" src="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Featured Image Alt Tag</label>
                            <input type="text" class="form-control" name="featured_image_alt"
                                   value="{{ old('featured_image_alt', $editProduct->featured_image_alt ?? '') }}"
                                   placeholder="Image description for SEO">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label class="form-label">Gallery Images <small>Hold Ctrl/Cmd to select multiple</small></label>
                            <input type="file" class="form-control" name="gallery_images[]"
                                   accept="image/*,video/mp4,video/webm,video/ogg,video/mov"
                                   multiple onchange="previewGalleryImages(event)">
                            <div id="gallery-preview" class="gallery-grid"></div>
                            @if(isset($editProduct) && $editProduct->images->count() > 0)
                                <div class="mt-2">
                                    <label class="form-label" style="color:#6b7280;">Existing Gallery:</label>
                                    <div class="gallery-grid">
                                        @foreach($editProduct->images as $img)
                                        <div class="gallery-thumb" id="gallery-img-{{ $img->id }}">
                                            @if(($img->type ?? 'image') === 'video')
                                                <div class="video-thumb"><span>▶️</span><small>Video</small></div>
                                            @else
                                                <img src="{{ asset('uploads/products/gallery/'.$img->image) }}">
                                            @endif
                                            <button type="button" class="remove-btn" onclick="deleteGalleryImage({{ $img->id }})">✕</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRICING & INVENTORY --}}
        <div class="page-card">
            <div class="card-header-orange">
                <h3 class="card-header-title"><i class="fas fa-rupee-sign"></i> Pricing & Inventory</h3>
            </div>
            <div class="card-body">
                <div class="form-row form-row-4">
                    <div class="form-group">
                        <label class="form-label">Regular Price</label>
                        <input type="number" class="form-control" name="price"
                               value="{{ old('price', $editProduct->price ?? '') }}"
                               step="0.01" min="0" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sale Price <small>Leave empty if not on sale</small></label>
                        <input type="number" class="form-control" name="sale_price"
                               value="{{ old('sale_price', $editProduct->sale_price ?? '') }}"
                               step="0.01" min="0" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-control" name="sku"
                               value="{{ old('sku', $editProduct->sku ?? '') }}"
                               placeholder="PROD-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" name="stock_quantity"
                               value="{{ old('stock_quantity', $editProduct->stock_quantity ?? 0) }}"
                               min="0">
                    </div>
                </div>
            </div>
        </div>

        {{-- VARIANTS --}}
        <div class="page-card">
            <div class="card-header-purple">
                <h3 class="card-header-title"><i class="fas fa-sliders-h"></i> Product Variants</h3>
            </div>
            <div class="card-body">
                <div class="info-tip">
                    <i class="fas fa-lightbulb"></i>
                    Add a <strong>Variant Type</strong> (Size, Color, etc.), then add <strong>Options</strong>. Combinations are auto-generated below with individual image upload per variant.
                </div>

                <div id="vg-container">
                    @if(isset($editProduct) && $editProduct->variants->count() > 0)
                        @php
                            $groups = [];
                            foreach($editProduct->variants as $v) {
                                $attrs = is_array($v->attributes) ? $v->attributes : [];
                                if(!empty($attrs)) {
                                    foreach($attrs as $k => $val) { $groups[$k][] = $val; }
                                } else {
                                    $groups['Option'][] = $v->name;
                                }
                            }
                            $groups = array_map('array_unique', $groups);
                        @endphp
                        @foreach($groups as $typeName => $options)
                        @php $gi = $loop->index; @endphp
                        <div class="vg-card" data-gid="{{ $gi }}">
                            <div class="vg-header">
                                <span class="vg-type-label">Type</span>
                                <input type="text" name="variant_types[]"
                                       value="{{ ucfirst($typeName) }}"
                                       placeholder="e.g. Size, Color, Material"
                                       onchange="regenerate()">
                                <button type="button" class="btn-vg-remove" onclick="removeGroup(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <div class="vg-options-area">
                                <div class="vg-tags-wrap" id="tags-{{ $gi }}">
                                    @foreach($options as $opt)
                                        <span class="vg-tag" data-val="{{ $opt }}">
                                            {{ $opt }}
                                            <button type="button" class="tag-x" onclick="removeTag(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="variant_options[{{ $gi }}][]" value="{{ $opt }}">
                                        </span>
                                    @endforeach
                                </div>
                                <div class="vg-input-row">
                                    <input type="text" class="vg-opt-input"
                                           placeholder="Type an option and press Enter"
                                           onkeydown="handleKey(event,this,{{ $gi }})"
                                           data-gid="{{ $gi }}">
                                    <button type="button" class="btn-add-opt" onclick="addOptBtn(this,{{ $gi }})">
                                        <i class="fas fa-plus me-1"></i> Add
                                    </button>
                                </div>
                                <div class="vg-hint"><i class="fas fa-info-circle me-1"></i>Press <strong>Enter</strong> or click <strong>Add</strong>.</div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <button type="button" class="btn-add-vg-type" onclick="addGroup()">
                    <i class="fas fa-plus-circle"></i> Add Variant Type (Size, Color, etc.)
                </button>

                <div id="gen-wrap" class="gen-wrap" style="display:none;">
                    <div class="gen-head">
                        <h6><i class="fas fa-th me-1"></i> Generated Variant Combinations</h6>
                        <span class="gen-badge" id="gen-badge">0</span>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="gen-table">
                            <thead>
                                <tr>
                                    <th style="min-width:150px;">Variant</th>
                                    <th style="min-width:100px;">SKU</th>
                                    <th style="min-width:100px;">Price (₹)</th>
                                    <th style="min-width:120px;">Compare Price (₹)</th>
                                    <th style="min-width:80px;">Stock</th>
                                    <th style="min-width:130px;"><i class="fas fa-image me-1"></i>Image</th>
                                </tr>
                            </thead>
                            <tbody id="gen-tbody"></tbody>
                        </table>
                    </div>
                    <div class="gen-footer-note">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Compare Price</strong> = MRP/Original price (strikethrough). Should be higher than sale price.
                    </div>
                </div>

                @if(isset($editProduct))
                    <script id="existing-variants-data" type="application/json">
                        {!! json_encode($editProduct->variants->mapWithKeys(function($v) {
                            return [$v->name => [
                                'sku'           => $v->sku ?? '',
                                'price'         => $v->price ?? '',
                                'compare_price' => $v->compare_price ?? '',
                                'stock'         => $v->stock_quantity ?? 0,
                                'image'         => $v->image ? asset('uploads/products/variants/'.$v->image) : ''
                            ]];
                        })) !!}
                    </script>
                @endif
            </div>
        </div>

        {{-- CATEGORIES & TAGS --}}
        <div class="page-card">
            <div class="card-header-light">
                <h3 class="card-header-title"><i class="fas fa-tags text-primary"></i> Categories, Tags & Settings</h3>
            </div>
            <div class="card-body">
                <div class="form-row form-row-2">
                    {{-- CATEGORIES AS CHECKBOXES --}}
                    <div class="form-group">
                        <label class="form-label">Categories</label>
                        <div class="checkbox-grid">
                            @foreach($categories as $cat)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="cat-{{ $cat->id }}" name="categories[]" value="{{ $cat->id }}"
                                        {{ isset($editProduct) && $editProduct->categories->contains($cat->id) ? 'checked' : '' }}>
                                    <label for="cat-{{ $cat->id }}">{{ $cat->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TAGS AS CHECKBOXES --}}
                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <div class="checkbox-grid">
                            @foreach($tags as $tag)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"
                                        {{ isset($editProduct) && $editProduct->tags->contains($tag->id) ? 'checked' : '' }}>
                                    <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-row form-row-3">
                    <div class="form-group">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="draft"     {{ old('status', $editProduct->status ?? '') == 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $editProduct->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">CTA Button (Frontend)</label>
                        @php $ctaVal = old('cta_button', $editProduct->cta_button ?? 'add_to_cart'); @endphp
                        <div class="cta-group">
                            <div class="cta-option">
                                <input type="radio" name="cta_button" id="cta_add_to_cart" value="add_to_cart" {{ $ctaVal === 'add_to_cart' ? 'checked' : '' }}>
                                <label for="cta_add_to_cart">🛒 Add to Cart</label>
                            </div>
                            <div class="cta-option">
                                <input type="radio" name="cta_button" id="cta_enquire_now" value="enquire_now" {{ $ctaVal === 'enquire_now' ? 'checked' : '' }}>
                                <label for="cta_enquire_now">✉️ Enquire Now</label>
                            </div>
                        </div>
                        <span class="form-hint">Frontend pe sirf yahi button dikhega</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Featured</label>
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                   {{ isset($editProduct) && $editProduct->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Mark as featured product</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="page-card">
            <div class="card-header-light">
                <h3 class="card-header-title"><i class="fas fa-search text-primary"></i> SEO Settings</h3>
            </div>
            <div class="card-body">
                <div class="seo-section">
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title"
                                   value="{{ old('meta_title', $editProduct->meta_title ?? '') }}"
                                   placeholder="Leave empty to use product title">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords"
                                   value="{{ old('meta_keywords', $editProduct->meta_keywords ?? '') }}"
                                   placeholder="keyword1, keyword2">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $editProduct->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- OPEN GRAPH --}}
        <div class="page-card">
            <div class="card-header-light">
                <h3 class="card-header-title"><i class="fas fa-share-alt text-primary"></i> Social Media (Open Graph)</h3>
            </div>
            <div class="card-body">
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label class="form-label">OG Title</label>
                        <input type="text" class="form-control" name="og_title"
                               value="{{ old('og_title', $editProduct->og_title ?? '') }}"
                               placeholder="Title for social media sharing">
                    </div>
                    <div class="form-group">
                        <label class="form-label">OG Image <small>1200×630px recommended</small></label>
                        <input type="file" class="form-control" name="og_image"
                               accept="image/*" onchange="previewImage(event,'og')">
                        @if(isset($editProduct) && $editProduct->og_image)
                            <div class="img-preview-box mt-2" id="og-current-wrap">
                                <img src="{{ asset('uploads/products/og/'.$editProduct->og_image) }}">
                                <button type="button" class="remove-btn" onclick="removeOgImage()">✕</button>
                                <input type="hidden" name="remove_og_image" id="remove_og_image" value="0">
                            </div>
                        @endif
                        <div id="og-preview" style="display:none;" class="img-preview-box mt-2">
                            <img id="og-img" src="">
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">OG Description</label>
                    <textarea class="form-control" name="og_description" rows="2">{{ old('og_description', $editProduct->og_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- SUBMIT BUTTONS --}}
        <div class="btn-group-custom">
            <a href="{{ route('product') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
            @if(!isset($editProduct))
                <button type="reset" class="btn btn-secondary" onclick="resetTabsForm()">
                    <i class="fas fa-redo"></i> Reset
                </button>
            @endif
            <button type="submit" id="submitBtn" class="{{ isset($editProduct) ? 'btn btn-warning' : 'btn btn-primary' }}">
                <i class="fas fa-save"></i> {{ isset($editProduct) ? 'Update Product' : 'Add Product' }}
            </button>
        </div>

    </form>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
// ════════════════════════════════════
// GLOBAL STATE
// ════════════════════════════════════
let editorInstance;
let gid = 0;
let tabCount = {{ isset($editProduct) && $editProduct->extra_tabs
    ? count(is_array($editProduct->extra_tabs) ? $editProduct->extra_tabs : (json_decode($editProduct->extra_tabs, true) ?: []))
    : 0 }};

const tabEditors = {};

const existingVariantData = (() => {
    const el = document.getElementById('existing-variants-data');
    if (!el) return {};
    try { return JSON.parse(el.textContent); } catch(e) { return {}; }
})();

// ════════════════════════════════════
// MAIN EDITOR
// ════════════════════════════════════
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
}).then(e => { editorInstance = e; }).catch(console.error);

// ════════════════════════════════════
// EXISTING TAB EDITORS (edit mode)
// ════════════════════════════════════
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-ck-container').forEach(function(container) {
        const divId    = container.id;
        const hiddenId = container.getAttribute('data-hidden-id');
        const hidden   = document.getElementById(hiddenId);
        const content  = hidden ? hidden.value : '';
        ClassicEditor.create(container, {
            toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
        }).then(function(editor) {
            tabEditors[divId] = editor;
            if (content && content.trim() !== '') editor.setData(content);
        }).catch(console.error);
    });

    const existing = document.querySelectorAll('#vg-container .vg-card');
    gid = existing.length;
    if (existing.length > 0) regenerate();
});

// ════════════════════════════════════
// SLUG
// ════════════════════════════════════
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const si = document.getElementById('slug');
    if (!si.value || si.dataset.auto === 'true') { si.value = slug; si.dataset.auto = 'true'; }
    document.getElementById('slug-text').textContent = slug ? window.location.origin + '/product/' + slug : 'Will generate from title';
});
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.auto = 'false';
    document.getElementById('slug-text').textContent = this.value ? window.location.origin + '/product/' + this.value : 'Will generate from title';
});

// ════════════════════════════════════
// IMAGE HELPERS
// ════════════════════════════════════
function previewImage(ev, type) {
    const f = ev.target.files[0];
    const d = document.getElementById(type + '-preview');
    const i = document.getElementById(type + '-img');
    if (f) { const r = new FileReader(); r.onload = e => { i.src = e.target.result; d.style.display = 'block'; }; r.readAsDataURL(f); }
    else { d.style.display = 'none'; }
}

function previewGalleryImages(ev) {
    const c = document.getElementById('gallery-preview');
    c.innerHTML = '';
    const videoExts = ['mp4','webm','ogg','mov','avi'];
    Array.from(ev.target.files).forEach(f => {
        const ext = f.name.split('.').pop().toLowerCase();
        const isVideo = videoExts.includes(ext);
        const d = document.createElement('div');
        d.className = 'gallery-thumb';
        if (isVideo) {
            d.innerHTML = `<div class="video-thumb"><span>▶️</span><small>${f.name.substring(0,10)}</small></div><span class="new-badge">New</span>`;
        } else {
            const r = new FileReader();
            r.onload = e => { d.innerHTML = `<img src="${e.target.result}"><span class="new-badge">New</span>`; };
            r.readAsDataURL(f);
        }
        c.appendChild(d);
    });
}

function previewVariantImg(input) {
    const preview = input.nextElementSibling;
    if (!preview || !preview.classList.contains('variant-img-preview')) return;
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = function(e) {
            preview.style.display = 'block';
            preview.querySelector('img').src = e.target.result;
        };
        r.readAsDataURL(input.files[0]);
    } else { preview.style.display = 'none'; }
}

function removeFeaturedImage() {
    if (!confirm('Remove featured image?')) return;
    document.getElementById('featured-current-wrap').style.display = 'none';
    document.getElementById('remove_featured_image').value = '1';
}

function removeOgImage() {
    if (!confirm('Remove OG image?')) return;
    document.getElementById('og-current-wrap').style.display = 'none';
    document.getElementById('remove_og_image').value = '1';
}

function deleteGalleryImage(id) {
    if (!confirm('Delete this image?')) return;
    fetch(`/product/gallery-image/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            const el = document.getElementById('gallery-img-' + id);
            if (el) { el.style.transition='opacity 0.3s'; el.style.opacity='0'; setTimeout(()=>el.remove(),300); }
        } else { alert('Error: ' + d.error); }
    })
    .catch(() => alert('Failed to delete image'));
}

// ════════════════════════════════════
// EXTRA TABS
// ════════════════════════════════════
function addTab() {
    const noMsg = document.getElementById('no-tabs-msg');
    if (noMsg) noMsg.style.display = 'none';
    const num = document.querySelectorAll('#tabs-container .tab-item').length + 1;
    const uid = tabCount;
    const divId = 'tab-editor-' + uid;
    const hiddenId = 'tab-hidden-' + uid;
    tabCount++;
    const div = document.createElement('div');
    div.className = 'tab-item';
    div.innerHTML = `
        <div class="tab-header-row">
            <span class="tab-number-badge">${num}</span>
            <span class="tab-label">Tab ${num}</span>
            <button type="button" class="btn-remove-tab" onclick="removeTab(this)"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-heading me-1" style="color:#6366f1;"></i> Tab Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="tab_titles[]" placeholder="e.g. Specifications, Features">
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label"><i class="fas fa-align-left me-1" style="color:#6366f1;"></i> Tab Content</label>
            <input type="hidden" name="tab_contents[]" id="${hiddenId}">
            <div id="${divId}" class="tab-ck-container" data-hidden-id="${hiddenId}"></div>
        </div>
    `;
    document.getElementById('tabs-container').appendChild(div);
    ClassicEditor.create(document.getElementById(divId), {
        toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
    }).then(editor => { tabEditors[divId] = editor; }).catch(console.error);
    div.querySelector('input[name="tab_titles[]"]').focus();
    div.scrollIntoView({ behavior:'smooth', block:'nearest' });
}

function removeTab(btn) {
    const item = btn.closest('.tab-item');
    const edDiv = item.querySelector('.tab-ck-container');
    if (edDiv && edDiv.id && tabEditors[edDiv.id]) {
        tabEditors[edDiv.id].destroy().catch(console.error);
        delete tabEditors[edDiv.id];
    }
    item.style.transition='opacity 0.2s,transform 0.2s'; item.style.opacity='0'; item.style.transform='translateY(-6px)';
    setTimeout(() => {
        item.remove(); renumberTabs();
        const remaining = document.querySelectorAll('#tabs-container .tab-item');
        const noMsg = document.getElementById('no-tabs-msg');
        if (noMsg && remaining.length === 0) noMsg.style.display='';
    }, 220);
}

function renumberTabs() {
    document.querySelectorAll('#tabs-container .tab-item').forEach((item, i) => {
        const numEl = item.querySelector('.tab-number-badge');
        const labelEl = item.querySelector('.tab-label');
        if (numEl) numEl.textContent = i + 1;
        if (labelEl) labelEl.textContent = 'Tab ' + (i + 1);
    });
}

function resetTabsForm() {
    Object.keys(tabEditors).forEach(id => { if (tabEditors[id]) { tabEditors[id].destroy().catch(console.error); delete tabEditors[id]; } });
    document.getElementById('tabs-container').innerHTML = '';
    tabCount = 0;
    const noMsg = document.getElementById('no-tabs-msg');
    if (noMsg) noMsg.style.display = '';
}

// ════════════════════════════════════
// VARIANT BUILDER
// ════════════════════════════════════
function getGroups() {
    const groups = [];
    document.querySelectorAll('#vg-container .vg-card').forEach(card => {
        const typeName = card.querySelector('input[name="variant_types[]"]').value.trim();
        const opts = [];
        card.querySelectorAll('.vg-tag').forEach(t => opts.push(t.dataset.val));
        if (typeName) groups.push({ typeName, opts });
    });
    return groups;
}

function cartesian(arrays) {
    if (!arrays.length) return [];
    return arrays.reduce((a, b) => { const res=[]; a.forEach(x=>b.forEach(y=>res.push([...x,y]))); return res; }, [[]]);
}

function regenerate() {
    const groups = getGroups().filter(g => g.opts.length > 0);
    const genWrap = document.getElementById('gen-wrap');
    const tbody = document.getElementById('gen-tbody');
    const badge = document.getElementById('gen-badge');
    if (!groups.length) { genWrap.style.display='none'; tbody.innerHTML=''; return; }
    const optArrays = groups.map(g => g.opts.map(o => ({ type: g.typeName, val: o })));
    const combos = cartesian(optArrays);
    genWrap.style.display = 'block';
    badge.textContent = combos.length;
    tbody.innerHTML = '';
    combos.forEach(combo => {
        const label = combo.map(c => c.val).join(' / ');
        const attrObj = {};
        combo.forEach(c => { attrObj[c.type.toLowerCase()] = c.val; });
        const attrJson = JSON.stringify(attrObj);
        const ex = existingVariantData[label] || {};
        const existingImgHtml = ex.image
            ? `<img src="${esc(ex.image)}" class="variant-img-existing" title="Current: ${esc(label)}">`
            : `<div class="variant-img-placeholder">🖼️</div>`;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="gen-name">
                ${esc(label)}
                <input type="hidden" name="variant_names[]" value="${esc(label)}">
                <input type="hidden" name="variant_attributes[]" value='${esc(attrJson)}'>
            </td>
            <td><input type="text" class="gen-input" name="variant_skus[]" value="${esc(ex.sku||'')}" placeholder="SKU"></td>
            <td><input type="number" class="gen-input" name="variant_prices[]" value="${esc(ex.price||'')}" placeholder="0.00" step="0.01" min="0"></td>
            <td>
                <input type="number" class="gen-input compare-price-input" name="variant_compare_prices[]" value="${esc(ex.compare_price||'')}" placeholder="0.00" step="0.01" min="0">
                <span class="compare-price-hint">MRP / Original</span>
            </td>
            <td><input type="number" class="gen-input" name="variant_stocks[]" value="${esc(ex.stock??0)}" placeholder="0" min="0"></td>
            <td>
                ${existingImgHtml}
                <input type="file" class="gen-input variant-img-input" name="variant_images[]" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" onchange="previewVariantImg(this)" title="Upload for: ${esc(label)}">
                <div class="variant-img-preview"><img src="" alt="preview"></div>
                <small style="font-size:9px;color:#9ca3af;">${ex.image?'Upload to replace':'Optional image'}</small>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function esc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function addGroup() {
    const id = gid++;
    const card = document.createElement('div');
    card.className = 'vg-card'; card.dataset.gid = id;
    card.innerHTML = `
        <div class="vg-header">
            <span class="vg-type-label">Type</span>
            <input type="text" name="variant_types[]" placeholder="e.g. Size, Color, Material" onchange="regenerate()">
            <button type="button" class="btn-vg-remove" onclick="removeGroup(this)"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="vg-options-area">
            <div class="vg-tags-wrap" id="tags-${id}"></div>
            <div class="vg-input-row">
                <input type="text" class="vg-opt-input" placeholder="Type option, press Enter" onkeydown="handleKey(event,this,${id})" data-gid="${id}">
                <button type="button" class="btn-add-opt" onclick="addOptBtn(this,${id})"><i class="fas fa-plus me-1"></i>Add</button>
            </div>
            <div class="vg-hint"><i class="fas fa-info-circle me-1"></i>Press Enter or click Add.</div>
        </div>
    `;
    document.getElementById('vg-container').appendChild(card);
    card.querySelector('input[name="variant_types[]"]').focus();
}

function removeGroup(btn) {
    const card = btn.closest('.vg-card');
    card.style.transition='opacity 0.2s'; card.style.opacity='0';
    setTimeout(()=>{ card.remove(); regenerate(); },220);
}

function handleKey(ev, input, gid) {
    if (ev.key==='Enter') { ev.preventDefault(); addTag(input.value.trim(),gid); input.value=''; }
}

function addOptBtn(btn, gid) {
    const input = btn.closest('.vg-input-row').querySelector('.vg-opt-input');
    if (input.value.trim()) { addTag(input.value.trim(),gid); input.value=''; }
    input.focus();
}

function addTag(val, gid) {
    if (!val) return;
    const wrap = document.getElementById('tags-' + gid);
    if (!wrap) return;
    const existing = Array.from(wrap.querySelectorAll('.vg-tag')).map(t=>t.dataset.val.toLowerCase());
    if (existing.includes(val.toLowerCase())) return;
    const tag = document.createElement('span');
    tag.className='vg-tag'; tag.dataset.val=val;
    tag.innerHTML=`${esc(val)}<button type="button" class="tag-x" onclick="removeTag(this)"><i class="fas fa-times"></i></button><input type="hidden" name="variant_options[${gid}][]" value="${esc(val)}">`;
    wrap.appendChild(tag);
    regenerate();
}

function removeTag(btn) { btn.closest('.vg-tag').remove(); regenerate(); }

// ════════════════════════════════════
// FORM SUBMIT — sync editors
// ════════════════════════════════════
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (editorInstance) document.querySelector('#editor').value = editorInstance.getData();
    Object.keys(tabEditors).forEach(function(divId) {
        const editor = tabEditors[divId];
        const container = document.getElementById(divId);
        if (!editor || !container) return;
        const hiddenId = container.getAttribute('data-hidden-id');
        if (hiddenId) { const hidden = document.getElementById(hiddenId); if (hidden) hidden.value = editor.getData(); }
    });
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    this.submit();
});

// Auto-dismiss alerts
setTimeout(() => { document.querySelectorAll('.alert-success,.alert-danger,.alert-validation').forEach(el=>el.remove()); }, 5000);
</script>

@endsection
