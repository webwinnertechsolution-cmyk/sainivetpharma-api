@extends('backend.layouts.layout')
@section('title', 'Promotional Banner Management')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; padding: 0; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 10px; color: #6b7280; font-weight: 500; }

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
    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }

    .card-body { padding: 16px; }

    /* Sub-section cards inside form */
    .sub-card {
        border: 1.5px solid #e5e7eb; border-radius: 8px;
        margin-bottom: 12px; overflow: hidden;
    }
    .sub-card.desktop { border-left: 4px solid #1872B5; }
    .sub-card.mobile  { border-left: 4px solid #0dcaf0; }
    .sub-card.text    { border-left: 4px solid #8b5cf6; }
    .sub-card.button  { border-left: 4px solid #10b981; }

    .sub-card-header {
        background: #f9fafb; padding: 8px 12px;
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; display: flex; align-items: center; gap: 6px;
        border-bottom: 1px solid #e5e7eb;
    }
    .sub-card-body { padding: 12px; }

    .form-label {
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        color: #0a214f; margin-bottom: 6px; display: block;
    }
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
    .form-text { font-size: 10px; color: #6b7280; margin-top: 3px; display: block; }

    .form-check { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .form-check-input { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #1872B5; }
    .form-check-label { font-size: 12px; color: #0a214f; font-weight: 600; margin: 0; cursor: pointer; }
    .form-switch .form-check-input { width: 36px; height: 18px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }
    .row { display: grid; gap: 12px; }
    .row.cols-2 { grid-template-columns: 1fr 1fr; }

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
    .btn-sm { padding: 4px 9px; font-size: 10px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Image Preview Box */
    .img-preview-box {
        margin-top: 8px; padding: 6px; border: 1.5px dashed #d1d5db;
        border-radius: 6px; background: #f9fafb; display: none;
    }
    .img-preview-box img { max-width: 100%; max-height: 130px; border-radius: 4px; display: block; }
    .img-preview-box p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }
    .img-current-box {
        margin-top: 8px; padding: 6px; border: 1.5px solid #e5e7eb;
        border-radius: 6px; background: #f0f4f8;
    }
    .img-current-box img { max-width: 100%; max-height: 130px; border-radius: 4px; display: block; }
    .img-current-box p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }

    /* Banner Preview Card */
    .preview-section { margin-top: 16px; }

    .banner-preview-wrap {
        position: relative; border-radius: 10px; overflow: hidden;
        border: 2px solid #e5e7eb; background: #f0f4f8;
    }
    .banner-preview-wrap img { width: 100%; display: block; object-fit: cover; max-height: 240px; }
    .banner-preview-placeholder {
        width: 100%; height: 200px; background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 8px; color: #9ca3af;
    }
    .banner-preview-placeholder i { font-size: 32px; }
    .banner-preview-placeholder p { font-size: 12px; margin: 0; }

    .detail-grid { display: grid; grid-template-columns: 1fr auto; gap: 16px; margin-top: 12px; align-items: start; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px; border-radius: 20px; font-size: 10px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-danger { background: #fee2e2; color: #7f1d1d; }

    .detail-label { font-size: 10px; color: #6b7280; font-family: 'Sora', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    .detail-value { font-size: 13px; color: #0a214f; font-weight: 700; margin: 2px 0 10px; }
    .detail-heading { font-size: 18px; color: #0a214f; font-family: 'Sora', sans-serif; font-weight: 800; margin: 4px 0 12px; }

    .mobile-preview-wrap {
        max-width: 200px; margin: 0 auto;
        border: 2px solid #e5e7eb; border-radius: 10px; overflow: hidden;
    }
    .mobile-preview-wrap img { width: 100%; display: block; object-fit: cover; max-height: 280px; }

    .no-banner-state {
        text-align: center; padding: 40px 20px; color: #6b7280;
    }
    .no-banner-state i { font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.3; }
    .no-banner-state p { font-size: 12px; margin: 0; }

    .preview-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .preview-label { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #0a214f; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }

    @media (max-width: 1024px) { .row.cols-2 { grid-template-columns: 1fr; } .preview-grid { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🎯 Promotional Banner Management</h1>
        <p class="page-subtitle">Manage the promotional banner displayed on the homepage.</p>
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

    {{-- FORM CARD --}}
    @if($canAdd || isset($editBanner))
    <div class="page-card">
        <div class="{{ isset($editBanner) ? 'card-header-warning' : 'card-header-gradient' }}">
            <h2 class="card-header-title">
                @if(isset($editBanner))
                    <i class="fas fa-pen"></i> Edit Promotional Banner
                @else
                    <i class="fas fa-plus-circle"></i> Add Promotional Banner
                @endif
            </h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($editBanner) ? route('promotional.banner.update', $editBanner->id) : route('promotional.banner.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- Desktop Image --}}
                <div class="sub-card desktop">
                    <div class="sub-card-header">
                        <i class="fas fa-desktop"></i> Desktop Image
                    </div>
                    <div class="sub-card-body">
                        <div class="row cols-2">
                            <div>
                                <div class="form-group">
                                    <label class="form-label">
                                        Background Image {{ !isset($editBanner) ? '<span class="text-danger">*</span>' : '' }}
                                    </label>
                                    <input type="file"
                                           class="form-control @error('background_image') is-invalid @enderror"
                                           id="background_image"
                                           name="background_image"
                                           accept="image/*"
                                           {{ !isset($editBanner) ? 'required' : '' }}
                                           onchange="previewDesktopImage(event)">
                                    @error('background_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <span class="form-text">Recommended: 1920×400px</span>

                                    @if(isset($editBanner) && $editBanner->background_image)
                                        <div class="img-current-box">
                                            <img src="{{ asset('uploads/promotional-banners/' . $editBanner->background_image) }}" alt="Current Desktop">
                                            <p>Current Desktop Image</p>
                                        </div>
                                    @endif
                                    <div class="img-preview-box" id="desktopImagePreview">
                                        <img id="desktopPreview" src="" alt="Preview">
                                        <p>New Desktop Preview</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label class="form-label">Desktop Image Alt Tag</label>
                                    <input type="text"
                                           class="form-control @error('background_image_alt') is-invalid @enderror"
                                           id="background_image_alt"
                                           name="background_image_alt"
                                           value="{{ old('background_image_alt', isset($editBanner) ? $editBanner->background_image_alt : '') }}"
                                           placeholder="e.g., Pet food sale banner desktop">
                                    @error('background_image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Image --}}
                <div class="sub-card mobile">
                    <div class="sub-card-header">
                        <i class="fas fa-mobile-alt"></i> Mobile Image
                    </div>
                    <div class="sub-card-body">
                        <div class="row cols-2">
                            <div>
                                <div class="form-group">
                                    <label class="form-label">
                                        Mobile Background Image {{ !isset($editBanner) ? '<span class="text-danger">*</span>' : '' }}
                                    </label>
                                    <input type="file"
                                           class="form-control @error('background_image_mobile') is-invalid @enderror"
                                           id="background_image_mobile"
                                           name="background_image_mobile"
                                           accept="image/*"
                                           {{ !isset($editBanner) ? 'required' : '' }}
                                           onchange="previewMobileImage(event)">
                                    @error('background_image_mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <span class="form-text">Recommended: 540×700px (Portrait)</span>

                                    @if(isset($editBanner) && $editBanner->background_image_mobile)
                                        <div class="img-current-box">
                                            <img src="{{ asset('uploads/promotional-banners/' . $editBanner->background_image_mobile) }}" alt="Current Mobile">
                                            <p>Current Mobile Image</p>
                                        </div>
                                    @endif
                                    <div class="img-preview-box" id="mobileImagePreview">
                                        <img id="mobilePreview" src="" alt="Preview">
                                        <p>New Mobile Preview</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label class="form-label">Mobile Image Alt Tag</label>
                                    <input type="text"
                                           class="form-control @error('background_image_mobile_alt') is-invalid @enderror"
                                           id="background_image_mobile_alt"
                                           name="background_image_mobile_alt"
                                           value="{{ old('background_image_mobile_alt', isset($editBanner) ? $editBanner->background_image_mobile_alt : '') }}"
                                           placeholder="e.g., Pet food sale banner mobile">
                                    @error('background_image_mobile_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Text Content --}}
                <div class="sub-card text">
                    <div class="sub-card-header">
                        <i class="fas fa-heading"></i> Text Content
                    </div>
                    <div class="sub-card-body">
                        <div class="row cols-2">
                            <div>
                                <div class="form-group">
                                    <label class="form-label">Sub Heading</label>
                                    <input type="text"
                                           class="form-control @error('sub_heading') is-invalid @enderror"
                                           id="sub_heading" name="sub_heading"
                                           value="{{ old('sub_heading', isset($editBanner) ? $editBanner->sub_heading : '') }}"
                                           placeholder="e.g., Up to 50% OFF!">
                                    @error('sub_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Heading <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('heading') is-invalid @enderror"
                                           id="heading" name="heading"
                                           value="{{ old('heading', isset($editBanner) ? $editBanner->heading : '') }}"
                                           placeholder="e.g., All your Pet's Favourite Brands!"
                                           required>
                                    @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <label class="form-label">Sale Heading</label>
                                    <input type="text"
                                           class="form-control @error('sale_heading') is-invalid @enderror"
                                           id="sale_heading" name="sale_heading"
                                           value="{{ old('sale_heading', isset($editBanner) ? $editBanner->sale_heading : '') }}"
                                           placeholder="e.g., Sale end in:">
                                    @error('sale_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Sale End Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local"
                                           class="form-control @error('sale_end_date') is-invalid @enderror"
                                           id="sale_end_date" name="sale_end_date"
                                           value="{{ old('sale_end_date', isset($editBanner) && $editBanner->sale_end_date ? $editBanner->sale_end_date->format('Y-m-d\TH:i') : '') }}"
                                           required>
                                    @error('sale_end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Button --}}
                <div class="sub-card button">
                    <div class="sub-card-header">
                        <i class="fas fa-link"></i> Button
                    </div>
                    <div class="sub-card-body">
                        <div class="row cols-2">
                            <div class="form-group">
                                <label class="form-label">Button Text <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('button_text') is-invalid @enderror"
                                       id="button_text" name="button_text"
                                       value="{{ old('button_text', isset($editBanner) ? $editBanner->button_text : 'Shop Now') }}"
                                       placeholder="e.g., Shop Now" required>
                                @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Button URL <span class="text-danger">*</span></label>
                                <input type="url"
                                       class="form-control @error('button_url') is-invalid @enderror"
                                       id="button_url" name="button_url"
                                       value="{{ old('button_url', isset($editBanner) ? $editBanner->button_url : '') }}"
                                       placeholder="https://example.com/shop" required>
                                @error('button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Active Toggle --}}
                <div class="form-check form-switch" style="margin-left: 4px;">
                    <input class="form-check-input" type="checkbox"
                           id="is_active" name="is_active" value="1"
                           {{ old('is_active', isset($editBanner) ? $editBanner->is_active : true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active (Visible on homepage)
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="btn-group-custom">
                    @if(isset($editBanner))
                        <a href="{{ route('promotional.banner') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Banner
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Banner
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
    @endif

    {{-- Current Banner Preview --}}
    @if($banner)
    <div class="page-card">
        <div class="card-header-dark">
            <h2 class="card-header-title">
                <i class="fas fa-eye"></i> Current Banner Preview
                <span style="font-size:11px; background:rgba(255,255,255,0.15); padding:2px 10px; border-radius:20px; margin-left:auto;">
                    {{ $banner->is_active ? '✅ Active' : '❌ Inactive' }}
                </span>
            </h2>
        </div>
        <div class="card-body">

            {{-- Image Previews --}}
            <div class="preview-grid">
                <div>
                    <div class="preview-label"><i class="fas fa-desktop"></i> Desktop Preview</div>
                    <div class="banner-preview-wrap">
                        @if($banner->background_image)
                            <img src="{{ asset('uploads/promotional-banners/' . $banner->background_image) }}"
                                 alt="{{ $banner->background_image_alt }}">
                        @else
                            <div class="banner-preview-placeholder">
                                <i class="fas fa-image"></i>
                                <p>No desktop image uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="preview-label"><i class="fas fa-mobile-alt"></i> Mobile Preview</div>
                    <div class="mobile-preview-wrap">
                        @if($banner->background_image_mobile)
                            <img src="{{ asset('uploads/promotional-banners/' . $banner->background_image_mobile) }}"
                                 alt="{{ $banner->background_image_mobile_alt }}">
                        @else
                            <div class="banner-preview-placeholder" style="height:280px;">
                                <i class="fas fa-image"></i>
                                <p>No mobile image</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr>

            {{-- Details + Actions --}}
            <div class="detail-grid">
                <div>
                    <div class="detail-label">Sub Heading</div>
                    <div class="detail-value">{{ $banner->sub_heading ?? '—' }}</div>

                    <div class="detail-label">Heading</div>
                    <div class="detail-heading">{{ $banner->heading ?? '—' }}</div>

                    <div class="detail-label">{{ $banner->sale_heading ?? 'Sale End In' }}</div>
                    <div class="detail-value">
                        {{ $banner->sale_end_date ? $banner->sale_end_date->format('d M Y, H:i') : '—' }}
                    </div>

                    <a href="{{ $banner->button_url ?? '#' }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-external-link-alt"></i> {{ $banner->button_text ?? 'Shop Now' }}
                    </a>
                </div>

                <div style="display:flex; flex-direction:column; gap:8px; align-items:flex-end;">
                    <span class="badge {{ $banner->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $banner->is_active ? '✅ Active' : '⏸ Inactive' }}
                    </span>

                    {{-- Edit + Delete ek line mein --}}
                    <div style="display:flex; gap:5px; align-items:center;">
                        <a href="{{ route('promotional.banner.edit', $banner->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('promotional.banner.delete', $banner->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirmDelete(event, 'this banner')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Del
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif

</div>

{{-- Delete Confirm Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box" style="background:#fff; border-radius:12px; width:320px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:linear-gradient(135deg,#ef4444,#f87171); padding:12px 16px; color:white; display:flex; align-items:center; justify-content:space-between;">
            <h6 style="font-family:'Sora',sans-serif; font-size:13px; font-weight:700; margin:0;"><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h6>
            <button style="background:none; border:none; color:white; font-size:16px; cursor:pointer;" onclick="closeDeleteModal()">✕</button>
        </div>
        <div style="padding:20px 16px; text-align:center;">
            <p style="font-size:12px; color:#374151; margin:0 0 6px;">Are you sure you want to delete</p>
            <strong id="deleteItemName" style="color:#ef4444; font-size:13px;"></strong>
            <p style="font-size:10px; color:#9ca3af; margin-top:6px;">This action cannot be undone.</p>
        </div>
        <div style="padding:10px 16px; display:flex; gap:8px; justify-content:center; border-top:1px solid #f3f4f6;">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<script>
    // Image Preview
    function previewDesktopImage(event) {
        const preview = document.getElementById('desktopPreview');
        const box = document.getElementById('desktopImagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; box.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else { box.style.display = 'none'; }
    }

    function previewMobileImage(event) {
        const preview = document.getElementById('mobilePreview');
        const box = document.getElementById('mobileImagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; box.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else { box.style.display = 'none'; }
    }

    // Delete Modal
    let pendingDeleteForm = null;

    function confirmDelete(e, name) {
        e.preventDefault();
        pendingDeleteForm = e.target;
        document.getElementById('deleteItemName').textContent = '"' + name + '"';
        document.getElementById('deleteModal').style.display = 'flex';
        return false;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        pendingDeleteForm = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (pendingDeleteForm) pendingDeleteForm.submit();
    });

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

@endsection
