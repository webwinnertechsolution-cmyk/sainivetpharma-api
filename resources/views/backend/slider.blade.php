@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .slider-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .slider-header { margin-bottom: 14px; padding: 0; }
    .slider-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .slider-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

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

    .slider-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .slider-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

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

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
    .form-group { margin-bottom: 12px; }

    .slide-type-section {
        background: #f8fafc; border-radius: 8px; padding: 12px;
        margin-bottom: 12px; border: 1px solid #e9ecef;
    }

    .media-section {
        background: #f8fafc; border-radius: 8px; padding: 12px;
        margin-bottom: 12px; border: 1px solid #e9ecef;
    }

    .form-check { display: flex; align-items: center; gap: 8px; }
    .form-check-input { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #1872B5; }
    .form-check-label { font-size: 12px; color: #0a214f; font-weight: 600; margin: 0; cursor: pointer; }

    .form-switch .form-check-input { width: 36px; height: 18px; }

    .radio-group { display: flex; gap: 16px; }
    .radio-item { display: flex; align-items: center; gap: 6px; cursor: pointer; }
    .radio-item input[type="radio"] { width: 15px; height: 15px; accent-color: #1872B5; cursor: pointer; }
    .radio-item label { font-size: 12px; font-weight: 600; color: #0a214f; cursor: pointer; }

    .img-preview-box {
        margin-top: 8px; display: inline-block;
    }
    .img-preview-box img, .img-preview-box video {
        max-width: 200px; max-height: 120px; border: 2px solid #ddd;
        border-radius: 6px; padding: 3px; object-fit: cover;
    }
    .img-preview-box.new-preview img, .img-preview-box.new-preview video {
        border-color: #1872B5;
    }
    .img-preview-box p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }
    .text-muted { color: #6b7280; font-size: 11px; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary {
        background: linear-gradient(135deg, #1872B5, #2596e1); color: white;
        box-shadow: 0 4px 12px rgba(24,114,181,0.3);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-warning {
        background: linear-gradient(135deg, #b45309, #f59e0b); color: white;
        box-shadow: 0 4px 12px rgba(245,158,11,0.3);
    }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 5px 10px; font-size: 11px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Table Styles */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead tr { background: #f9fafb; }
    thead th {
        padding: 10px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb;
        white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 10px 12px; color: #374151; vertical-align: middle; }
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px; border-radius: 20px; font-size: 10px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .badge-primary { background: #dbeafe; color: #1d4ed8; }
    .badge-danger { background: #fee2e2; color: #b91c1c; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }

    .table-header { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: #e5e7eb; color: #374151; padding: 3px 10px; border-radius: 20px; font-weight: 700; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    /* Delete Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.5); z-index: 9999;
        align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: #fff; border-radius: 12px; width: 320px;
        overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .modal-box-header {
        background: linear-gradient(135deg, #ef4444, #f87171);
        padding: 12px 16px; color: white; display: flex;
        align-items: center; justify-content: space-between;
    }
    .modal-box-header h6 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; }
    .modal-close { background: none; border: none; color: white; font-size: 16px; cursor: pointer; }
    .modal-box-body { padding: 20px 16px; text-align: center; }
    .modal-box-body p { font-size: 12px; color: #374151; margin: 0 0 6px; }
    .modal-box-body strong { color: #ef4444; font-size: 13px; }
    .modal-box-body .note { font-size: 10px; color: #9ca3af; margin-top: 6px; }
    .modal-box-footer { padding: 10px 16px; display: flex; gap: 8px; justify-content: center; border-top: 1px solid #f3f4f6; }
.form-group label {
    font-size: 12px!important;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
    .btn.btn-sm, .ajax-upload-dragdrop .btn-sm.ajax-file-upload, .btn-group-sm > .btn, .ajax-upload-dragdrop .btn-group-sm > .ajax-file-upload {
    font-size: 10px!important;
}
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="slider-container">

    {{-- Header --}}
    <div class="slider-header">
        <h1 class="slider-title">🖼️ Slider Management</h1>
        <p class="slider-subtitle">Manage homepage sliders with images or videos</p>
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

    {{-- Form Card --}}
    <div class="slider-card">
        <div class="{{ isset($editSlider) ? 'card-header-warning' : 'card-header-gradient' }}">
            <h2 class="card-header-title">
                @if(isset($editSlider))
                    <i class="fas fa-pen"></i> Edit Slider #{{ $editSlider->id }}
                @else
                    <i class="fas fa-plus-circle"></i> Add New Slider
                @endif
            </h2>
        </div>

        <div class="card-body">
            <form action="{{ isset($editSlider) ? route('slider.update', $editSlider->id) : route('slider.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Slide Type Toggle --}}
                <div class="slide-type-section" style="margin-bottom: 14px;">
                    <label class="form-label">Slide Type <span class="text-danger">*</span></label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" name="slide_type" id="type_image" value="image"
                                {{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'image' ? 'checked' : '' }}
                                onchange="toggleSlideType('image')">
                            <label for="type_image"><i class="fas fa-image" style="color:#1872B5;margin-right:4px;"></i> Image</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" name="slide_type" id="type_video" value="video"
                                {{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'video' ? 'checked' : '' }}
                                onchange="toggleSlideType('video')">
                            <label for="type_video"><i class="fas fa-video" style="color:#ef4444;margin-right:4px;"></i> Video</label>
                        </div>
                    </div>
                </div>

                <div class="form-row" style="align-items: start;">

                    {{-- LEFT COLUMN --}}
                    <div>

                        {{-- Image Section --}}
                        <div id="image_section" class="media-section"
                            style="{{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'video' ? 'display:none' : '' }}">
                            <div class="form-group">
                                <label class="form-label">
                                    Image 
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*"
                                    onchange="previewMedia(event,'image')">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                @if(isset($editSlider) && $editSlider->image && $editSlider->slide_type === 'image')
                                    <div class="img-preview-box">
                                        <img src="{{ asset('uploads/slider/' . $editSlider->image) }}" alt="Current">
                                        <p><i class="fas fa-info-circle"></i> Current — leave blank to keep</p>
                                    </div>
                                @endif
                                <div class="img-preview-box new-preview" id="imagePreview" style="display:none;">
                                    <img id="previewImg" src="" alt="Preview">
                                    <p><i class="fas fa-eye"></i> New preview</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Image Alt Tag</label>
                                <input type="text" class="form-control @error('alt_tag') is-invalid @enderror"
                                    id="alt_tag" name="alt_tag"
                                    value="{{ old('alt_tag', isset($editSlider) ? $editSlider->alt_tag : '') }}"
                                    placeholder="Describe image for SEO">
                                @error('alt_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Video Section --}}
                        <div id="video_section" class="media-section"
                            style="{{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'image' ? 'display:none' : '' }}">
                            <div class="form-group">
                                <label class="form-label">
                                    Video (MP4/WebM — max 50MB)
                                    {{ !isset($editSlider) ? '<span class="text-danger">*</span>' : '' }}
                                </label>
                                <input type="file" class="form-control @error('video') is-invalid @enderror"
                                    id="video" name="video" accept="video/mp4,video/webm,video/ogg"
                                    onchange="previewMedia(event,'video')">
                                @error('video')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                @if(isset($editSlider) && $editSlider->video && $editSlider->slide_type === 'video')
                                    <div class="img-preview-box">
                                        <video controls style="max-width:220px;">
                                            <source src="{{ asset('uploads/slider/videos/' . $editSlider->video) }}" type="video/mp4">
                                        </video>
                                        <p><i class="fas fa-info-circle"></i> Current — leave blank to keep</p>
                                    </div>
                                @endif
                                <div class="img-preview-box new-preview" id="videoPreview" style="display:none;">
                                    <video id="previewVid" controls style="max-width:220px;"></video>
                                    <p><i class="fas fa-eye"></i> New preview</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Video Alt Tag</label>
                                <input type="text" class="form-control @error('video_alt_tag') is-invalid @enderror"
                                    id="video_alt_tag" name="video_alt_tag"
                                    value="{{ old('video_alt_tag', isset($editSlider) ? $editSlider->video_alt_tag : '') }}"
                                    placeholder="Describe video for accessibility">
                                @error('video_alt_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Sub Heading --}}
                        <div class="form-group">
                            <label class="form-label">Sub Heading</label>
                            <input type="text" class="form-control @error('sub_heading') is-invalid @enderror"
                                id="sub_heading" name="sub_heading"
                                value="{{ old('sub_heading', isset($editSlider) ? $editSlider->sub_heading : '') }}"
                                placeholder="e.g. Welcome to our site">
                            @error('sub_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Heading --}}
                        <div class="form-group">
                            <label class="form-label">
                                Heading
                                <small>Use <code>&lt;span style="color:#DA200B"&gt;Word&lt;/span&gt;</code> to colour a word</small>
                            </label>
                            <input type="text" class="form-control @error('heading') is-invalid @enderror"
                                id="heading" name="heading"
                                value="{{ old('heading', isset($editSlider) ? $editSlider->heading : '') }}"
                                placeholder="Main heading text">
                            @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="editor" name="description" rows="5"
                                placeholder="Enter slide description">{{ old('description', isset($editSlider) ? $editSlider->description : '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Button Text --}}
                        <div class="form-group">
                            <label class="form-label">Button Text</label>
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                                id="button_text" name="button_text"
                                value="{{ old('button_text', isset($editSlider) ? $editSlider->button_text : '') }}"
                                placeholder="e.g. GET A QUOTE">
                            @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Button URL --}}
                        <div class="form-group">
                            <label class="form-label">Button URL</label>
                            <input type="text" class="form-control @error('button_url') is-invalid @enderror"
                                id="button_url" name="button_url"
                                value="{{ old('button_url', isset($editSlider) ? $editSlider->button_url : '') }}"
                                placeholder="https://example.com or /page-name">
                            @error('button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>

                <hr>

                {{-- Buttons --}}
                <div class="btn-group-custom">
                    @if(isset($editSlider))
                        <a href="{{ route('slider') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Slider
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary" onclick="resetPreviews()">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Slider
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="slider-card">
        <div class="card-header-gradient">
            <div class="table-header">
                <h2 class="card-header-title"><i class="fas fa-list"></i> All Sliders</h2>
                <span class="table-count">Total: {{ $sliders->count() }}</span>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th style="width:120px">Media</th>
                            <th style="width:80px">Type</th>
                            <th>Sub Heading</th>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Button</th>
                            <th style="width:110px">Created</th>
                            <th style="width:140px" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                        <tr>
                            <td style="font-weight:700;color:#9ca3af;">{{ $slider->id }}</td>

                            <td>
                                @if(($slider->slide_type ?? 'image') === 'video' && $slider->video)
                                    <div style="position:relative;width:90px;height:56px;background:#000;border-radius:6px;overflow:hidden;">
                                        <video style="width:100%;height:100%;object-fit:cover;" muted preload="metadata">
                                            <source src="{{ asset('uploads/slider/videos/' . $slider->video) }}" type="video/mp4">
                                        </video>
                                        <span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#fff;font-size:16px;">
                                            <i class="fas fa-play-circle"></i>
                                        </span>
                                    </div>
                                @elseif($slider->image)
                                    <img src="{{ asset('uploads/slider/' . $slider->image) }}"
                                         alt="{{ $slider->alt_tag ?? 'Slider' }}"
                                         style="width:90px;height:56px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;">
                                @else
                                    <span class="badge badge-secondary">No Media</span>
                                @endif
                            </td>

                            <td>
                                @if(($slider->slide_type ?? 'image') === 'video')
                                    <span class="badge badge-danger"><i class="fas fa-video"></i> Video</span>
                                @else
                                    <span class="badge badge-primary"><i class="fas fa-image"></i> Image</span>
                                @endif
                            </td>

                            <td>{{ Str::limit($slider->sub_heading, 25) ?: '—' }}</td>
                            <td>{!! Str::limit(strip_tags($slider->heading), 30) ?: '—' !!}</td>
                            <td>{{ Str::limit(strip_tags($slider->description), 40) ?: '—' }}</td>

                            <td>
                                @if($slider->button_text && $slider->button_url)
                                    <a href="{{ $slider->button_url }}" target="_blank"
                                       style="font-size:11px;color:#1872B5;font-weight:700;text-decoration:none;">
                                        {{ Str::limit($slider->button_text, 15) }} <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @else
                                    <span style="color:#9ca3af;">—</span>
                                @endif
                            </td>

                            <td>
                                <span style="font-size:11px;font-weight:600;color:#374151;display:block;">{{ $slider->created_at->format('d M Y') }}</span>
                                <span style="font-size:10px;color:#9ca3af;">{{ $slider->created_at->format('h:i A') }}</span>
                            </td>

                            <td style="text-align:center;">
                                <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-warning btn-sm" style="margin-bottom:4px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('slider.delete', $slider->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirmDelete(event, '{{ addslashes($slider->heading ?: 'this slider') }}')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-images"></i>
                                    <p>No sliders found. Add your first slider above!</p>
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(err => console.error(err));

    function toggleSlideType(type) {
        const imgSec = document.getElementById('image_section');
        const vidSec = document.getElementById('video_section');
        if (type === 'image') {
            imgSec.style.display = 'block';
            vidSec.style.display = 'none';
            document.getElementById('video').value = '';
            document.getElementById('videoPreview').style.display = 'none';
        } else {
            imgSec.style.display = 'none';
            vidSec.style.display = 'block';
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        }
    }

    function previewMedia(event, type) {
        const file = event.target.files[0];
        if (!file) return;
        if (type === 'image') {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('previewVid').src = URL.createObjectURL(file);
            document.getElementById('videoPreview').style.display = 'block';
        }
    }

    function resetPreviews() {
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('videoPreview').style.display = 'none';
        document.getElementById('type_image').checked = true;
        toggleSlideType('image');
    }

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
