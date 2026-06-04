@extends('backend.layouts.layout')
@section('title', 'Gallery Management')
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
    .alert-validation {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        font-weight: 500; font-size: 12px;
    }
    .alert-validation ul { margin: 6px 0 0 16px; padding: 0; font-size: 11px; }

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
    .card-header-info {
        background: linear-gradient(135deg, #0369a1 0%, #0ea5e9 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-dark {
        background: linear-gradient(135deg, #111827 0%, #374151 100%);
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

    .form-check { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .form-check-input { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #1872B5; }
    .form-check-label { font-size: 12px; color: #0a214f; font-weight: 600; margin: 0; cursor: pointer; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }
    .text-muted-sm { color: #6b7280; font-size: 10px; margin-top: 3px; display: block; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-success { background: linear-gradient(135deg, #065f46, #10b981); color: white; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 4px 9px; font-size: 10px; }
    .btn-full { width: 100%; justify-content: center; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Two col layout */
    .two-col { display: grid; grid-template-columns: 400px 1fr; gap: 16px; align-items: start; }

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
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }
    .badge-danger { background: #fee2e2; color: #7f1d1d; }
    .badge-info { background: #e0f2fe; color: #0369a1; }
    .badge-warning { background: #fef3c7; color: #92400e; }

    .shortcode-box {
        background: #f0f4f8; padding: 2px 8px; border-radius: 4px;
        font-size: 10px; font-family: 'Courier New', monospace;
        color: #1e40af; display: inline-block; margin-top: 4px;
        border: 1px solid #e0e7ff;
    }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    /* Action btns inline */
    .action-btns { display: flex; gap: 5px; align-items: center; justify-content: center; flex-wrap: nowrap; }

    /* Media type radio */
    .media-type-row { display: flex; gap: 16px; margin-bottom: 12px; }
    .media-type-row .form-check { margin-bottom: 0; }

    /* Section divider label */
    .section-label {
        font-family: 'Sora', sans-serif; font-size: 10px; font-weight: 700;
        color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em;
        margin-bottom: 8px; display: flex; align-items: center; gap: 6px;
    }
    .section-label::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }

    /* Image previews */
    .img-preview-grid { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
    .img-preview-item {
        position: relative; width: 72px; height: 72px;
        border-radius: 6px; overflow: hidden; border: 1.5px solid #e5e7eb;
    }
    .img-preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .img-preview-item .remove-btn {
        position: absolute; top: 2px; right: 2px;
        background: rgba(239,68,68,0.9); color: white;
        border: none; border-radius: 50%; width: 18px; height: 18px;
        font-size: 10px; cursor: pointer; display: flex;
        align-items: center; justify-content: center; line-height: 1;
    }

    /* Media meta fields */
    .meta-field-box {
        background: #f9fafb; border: 1px solid #e5e7eb;
        border-radius: 6px; padding: 8px 10px; margin-bottom: 8px;
    }
    .meta-field-box .meta-label {
        font-family: 'Sora', sans-serif; font-size: 10px; font-weight: 700;
        color: #6b7280; margin-bottom: 6px; display: block;
    }

    /* Existing media grid */
    .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; }
    .media-card {
        background: #fff; border-radius: 8px; border: 1px solid #e5e7eb;
        overflow: hidden; transition: all 0.2s; cursor: move;
    }
    .media-card:hover { box-shadow: 0 4px 16px rgba(10,33,79,0.12); transform: translateY(-2px); }
    .media-card-thumb { height: 130px; background: #f3f4f6; position: relative; overflow: hidden; }
    .media-card-thumb img, .media-card-thumb video { width: 100%; height: 100%; object-fit: cover; }
    .media-card-thumb .media-type-badge {
        position: absolute; top: 6px; left: 6px;
        background: rgba(10,33,79,0.75); color: white;
        font-size: 9px; padding: 2px 7px; border-radius: 20px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .media-card-thumb .sort-badge {
        position: absolute; top: 6px; right: 6px;
        background: rgba(255,255,255,0.9); color: #0a214f;
        font-size: 9px; padding: 2px 7px; border-radius: 20px;
        font-family: 'Sora', sans-serif; font-weight: 700;
        border: 1px solid #e5e7eb;
    }
    .media-card-body { padding: 8px 10px; }
    .media-card-body .media-title { font-weight: 700; font-size: 11px; color: #0a214f; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .media-card-body .media-alt { font-size: 10px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .media-card-actions { padding: 6px 10px 8px; display: flex; gap: 5px; border-top: 1px solid #f3f4f6; }

    /* Delete Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.5); z-index: 9999;
        align-items: center; justify-content: center;
    }
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

    /* Edit Media Modal */
    .edit-modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.5); z-index: 9999;
        align-items: center; justify-content: center;
    }
    .edit-modal-overlay.show { display: flex; }
    .edit-modal-box { background: #fff; border-radius: 12px; width: 360px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .edit-modal-header { background: linear-gradient(135deg, #b45309, #f59e0b); padding: 12px 16px; color: white; display: flex; align-items: center; justify-content: space-between; }
    .edit-modal-header h6 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; }
    .edit-modal-body { padding: 16px; }
    .edit-modal-footer { padding: 10px 16px; display: flex; gap: 8px; justify-content: flex-end; border-top: 1px solid #f3f4f6; }
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
    .form-check {
    margin-left: 24px;
}
    .form-group label {
    font-size: 12px;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
    @media (max-width: 1024px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .media-grid { grid-template-columns: repeat(2, 1fr); }
        .btn-group-custom { flex-direction: column-reverse; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🖼️ Gallery Management</h1>
        <p class="page-subtitle">Manage the image and video galleries displayed on the website.</p>
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
    @if($errors->any())
        <div class="alert-validation">
            <strong>❌ Validation Errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="two-col">

        {{-- ══════════════════════════════ --}}
        {{-- FORM CARD --}}
        {{-- ══════════════════════════════ --}}
        <div class="page-card" style="position: sticky; top: 20px;">
            <div class="{{ isset($gallery) ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if(isset($gallery))
                        <i class="fas fa-pen"></i> Edit Gallery #{{ $gallery->id }}
                    @else
                        <i class="fas fa-plus-circle"></i> Create New Gallery
                    @endif
                </h2>
            </div>
            <div class="card-body">

                @if(isset($gallery))
                    <form action="{{ route('gallery.update', $gallery->id) }}" method="POST"
                          enctype="multipart/form-data" id="galleryForm">
                @else
                    <form action="{{ route('gallery.store') }}" method="POST"
                          enctype="multipart/form-data" id="galleryForm">
                @endif
                @csrf

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label">Gallery Title <span class="text-danger">*</span></label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               required value="{{ old('title', $gallery->title ?? '') }}"
                               placeholder="e.g. Summer Collection 2025">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label class="form-label">Slug (URL Friendly)</label>
                        <input type="text" name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $gallery->slug ?? '') }}"
                               placeholder="summer-collection-2025">
                        <span class="text-muted-sm">Leave blank to auto-generate from title</span>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"
                                  placeholder="Optional description...">{{ old('description', $gallery->description ?? '') }}</textarea>
                    </div>

                    {{-- Active --}}
                    <div class="form-check" style="margin-bottom: 12px;">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                               value="1" {{ old('is_active', $gallery->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (Visible on frontend)</label>
                    </div>

                    <hr>

                    {{-- Media Type --}}
                    <div class="form-group">
                        <label class="form-label">📁 Media Type</label>
                        <div class="media-type-row">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="media_type"
                                       id="type_image" value="image" checked>
                                <label class="form-check-label" for="type_image">📸 Images</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="media_type"
                                       id="type_video" value="video">
                                <label class="form-check-label" for="type_video">🎬 Videos</label>
                            </div>
                        </div>
                    </div>

                    {{-- IMAGE UPLOAD --}}
                    <div id="imageSection" class="form-group">
                        <label class="form-label">🖼️ Upload Images</label>
                        <input type="file" name="images[]" id="imageInput"
                               class="form-control" multiple accept="image/*">
                        <span class="text-muted-sm">Multiple allowed · JPG, PNG, GIF, WEBP · Max 5MB each</span>
                        <div class="img-preview-grid" id="imagePreviewContainer"></div>
                        <div id="imageMetaContainer"></div>
                    </div>

                    {{-- VIDEO UPLOAD --}}
                    <div id="videoSection" class="form-group" style="display:none;">
                        <label class="form-label">🎬 Upload Videos</label>
                        <input type="file" name="videos[]" id="videoInput"
                               class="form-control" multiple accept="video/mp4,video/webm,video/ogg,.mov,.avi">
                        <span class="text-muted-sm">Multiple allowed · MP4, WebM · Max 100MB each</span>
                        <div id="videoPreviewContainer" class="mt-2"></div>
                        <div id="videoMetaContainer"></div>

                        <div class="form-group" style="margin-top: 10px;">
                            <label class="form-label">🖼️ Video Thumbnails <span style="font-weight:400;color:#6b7280;">(Optional)</span></label>
                            <input type="file" name="video_thumbnails[]" id="videoThumbnailInput"
                                   class="form-control" multiple accept="image/*">
                            <span class="text-muted-sm">One thumbnail per video (same order)</span>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="btn-group-custom">
                        @if(isset($gallery))
                            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Gallery
                            </button>
                        @else
                            <button type="reset" class="btn btn-secondary" onclick="clearPreviews()">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Gallery
                            </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        {{-- ══════════════════════════════ --}}
        {{-- TABLE CARD --}}
        {{-- ══════════════════════════════ --}}
        <div>

            {{-- Shortcode info --}}
            <div class="page-card" style="margin-bottom: 12px;">
                <div class="card-body" style="padding: 10px 16px; display:flex; align-items:center; gap:10px;">
                    <span style="font-size:18px;">💡</span>
                    <div style="font-size:11px; color:#1e40af;">
                        <strong style="font-family:'Sora',sans-serif;">Shortcode Usage:</strong>
                        Paste in your blade file:
                        <code style="background:#eff6ff; padding:2px 8px; border-radius:4px; font-size:11px; border:1px solid #bfdbfe; margin-left:4px;">
                            @{{ shortcode('gallery', ID) }}
                        </code>
                    </div>
                </div>
            </div>

            <div class="page-card">
                <div class="card-header-gradient">
                    <div class="card-header-row">
                        <h2 class="card-header-title"><i class="fas fa-images"></i> All Galleries</h2>
                        <span class="table-count">Total: {{ $galleries->count() }}</span>
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:55px">ID</th>
                                    <th>Title</th>
                                    <th style="width:120px;text-align:center;">Media</th>
                                    <th style="width:75px;text-align:center;">Status</th>
                                    <th style="width:120px;text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galleries as $gal)
                                <tr>
                                    <td style="text-align:center;">
                                        <span class="badge badge-id">#{{ $gal->id }}</span>
                                    </td>
                                    <td>
                                        <div style="font-weight:700;color:#0a214f;font-size:12px;">{{ $gal->title }}</div>
                                        @if($gal->description)
                                            <div style="font-size:10px;color:#6b7280;margin-top:2px;">{{ Str::limit($gal->description, 50) }}</div>
                                        @endif
                                        <div class="shortcode-box">
                                            @php echo htmlspecialchars("{{ shortcode('gallery', " . $gal->id . ") }}"); @endphp
                                        </div>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="badge badge-info">📸 {{ $gal->images()->count() }}</span>
                                        <span class="badge badge-warning" style="margin-top:3px;">🎬 {{ $gal->videos()->count() }}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        @if($gal->is_active)
                                            <span class="badge badge-success">✅ Active</span>
                                        @else
                                            <span class="badge badge-danger">❌ Off</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <div class="action-btns">
                                            <a href="{{ route('gallery.edit', $gal->id) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('gallery.delete', $gal->id) }}" method="POST"
                                                  onsubmit="return confirmDelete(event, '{{ addslashes($gal->title) }}')">
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
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <i class="fas fa-images"></i>
                                            <p>No galleries yet. Create your first one!</p>
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

    {{-- ══════════════════════════════════════ --}}
    {{-- EXISTING MEDIA (Edit Mode Only) --}}
    {{-- ══════════════════════════════════════ --}}
    @if(isset($gallery))
    <div class="page-card" style="margin-top: 4px;">
        <div class="card-header-info">
            <div class="card-header-row">
                <h2 class="card-header-title"><i class="fas fa-photo-video"></i> Existing Media — {{ $gallery->title }}</h2>
                <span class="table-count">{{ $gallery->media()->count() }} files · Drag to reorder</span>
            </div>
        </div>
        <div class="card-body">
            @if($gallery->media()->count() > 0)
                <div class="media-grid" id="mediaList">
                    @foreach($gallery->media()->orderBy('sort_order')->get() as $media)
                    <div class="media-card" data-media-id="{{ $media->id }}">
                        <div class="media-card-thumb">
                            @if($media->isImage())
                                <img src="{{ $media->file_url }}" alt="{{ $media->alt_tag }}">
                                <span class="media-type-badge">📸 Image</span>
                            @else
                                <video><source src="{{ $media->file_url }}"></video>
                                <span class="media-type-badge">🎬 Video</span>
                            @endif
                            <span class="sort-badge">#{{ $loop->iteration }}</span>
                        </div>
                        <div class="media-card-body">
                            <div class="media-title title-text">{{ $media->title ?: '—' }}</div>
                            <div class="media-alt alt-text">{{ $media->alt_tag ?: '—' }}</div>
                        </div>
                        <div class="media-card-actions">
                            <button type="button" class="btn btn-warning btn-sm edit-btn"
                                    data-media-id="{{ $media->id }}" style="flex:1; justify-content:center;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-media-btn"
                                    data-media-id="{{ $media->id }}" style="flex:1; justify-content:center;">
                                <i class="fas fa-trash"></i> Del
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-photo-video"></i>
                    <p>No media yet. Use the form above to add images or videos.</p>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>

{{-- ══════ DELETE GALLERY MODAL ══════ --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-box-header">
            <h6><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h6>
            <button class="modal-close-btn" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-box-body">
            <p>Are you sure you want to delete</p>
            <strong id="deleteItemName"></strong>
            <p class="note">All media in this gallery will also be deleted. This cannot be undone.</p>
        </div>
        <div class="modal-box-footer">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

{{-- ══════ EDIT MEDIA MODAL ══════ --}}
<div class="edit-modal-overlay" id="editMediaModal">
    <div class="edit-modal-box">
        <div class="edit-modal-header">
            <h6><i class="fas fa-edit"></i> Edit Media Info</h6>
            <button class="modal-close-btn" onclick="closeEditModal()">✕</button>
        </div>
        <div class="edit-modal-body">
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" id="editTitle" class="form-control" placeholder="Media title...">
            </div>
            <div class="form-group">
                <label class="form-label">Alt Tag</label>
                <input type="text" id="editAltTag" class="form-control" placeholder="Alt text for accessibility...">
            </div>
        </div>
        <div class="edit-modal-footer">
            <button class="btn btn-secondary btn-sm" onclick="closeEditModal()">Cancel</button>
            <button class="btn btn-warning btn-sm" id="saveEditBtn">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>

// ════════════════════════════════
// DELETE GALLERY MODAL
// ════════════════════════════════
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

// ════════════════════════════════
// EDIT MEDIA MODAL
// ════════════════════════════════
let currentMediaId = null;

function closeEditModal() {
    document.getElementById('editMediaModal').classList.remove('show');
    currentMediaId = null;
}

document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        currentMediaId = this.dataset.mediaId;
        const card = this.closest('[data-media-id]');
        document.getElementById('editTitle').value  = card.querySelector('.title-text').textContent.trim().replace('—','');
        document.getElementById('editAltTag').value = card.querySelector('.alt-text').textContent.trim().replace('—','');
        document.getElementById('editMediaModal').classList.add('show');
    });
});

document.getElementById('saveEditBtn') && document.getElementById('saveEditBtn').addEventListener('click', function () {
    const title  = document.getElementById('editTitle').value;
    const altTag = document.getElementById('editAltTag').value;

    fetch(`/gallery/media/info/${currentMediaId}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ title: title, alt_tag: altTag })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            const card = document.querySelector(`[data-media-id="${currentMediaId}"]`);
            card.querySelector('.title-text').textContent = title || '—';
            card.querySelector('.alt-text').textContent   = altTag || '—';
            closeEditModal();
        }
    });
});

// ════════════════════════════════
// DELETE MEDIA
// ════════════════════════════════
document.querySelectorAll('.delete-media-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        if (!confirm('⚠️ Delete this media file? Cannot be undone.')) return;
        const mediaId = this.dataset.mediaId;
        fetch(`/gallery/media/delete/${mediaId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(res => res.json()).then(data => {
            if (data.success) {
                document.querySelector(`[data-media-id="${mediaId}"]`).remove();
                location.reload();
            }
        });
    });
});

// ════════════════════════════════
// DRAG & DROP SORT
// ════════════════════════════════
const mediaList = document.getElementById('mediaList');
if (mediaList) {
    Sortable.create(mediaList, {
        animation: 150,
        ghostClass: 'opacity-50',
        onEnd: function () {
            const order = Array.from(mediaList.children).map(el => el.dataset.mediaId);
            fetch('{{ route("gallery.media.sort") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ order: order })
            }).then(() => {
                Array.from(mediaList.children).forEach((el, idx) => {
                    el.querySelector('.sort-badge').textContent = '#' + (idx + 1);
                });
            });
        }
    });
}

// ════════════════════════════════
// MEDIA TYPE TOGGLE
// ════════════════════════════════
const radios = document.querySelectorAll('input[name="media_type"]');
const imageSection = document.getElementById('imageSection');
const videoSection = document.getElementById('videoSection');

radios.forEach(radio => {
    radio.addEventListener('change', function () {
        if (this.value === 'image') {
            imageSection.style.display = 'block';
            videoSection.style.display = 'none';
            selectedVideoFiles = [];
            document.getElementById('videoInput').value = '';
            document.getElementById('videoPreviewContainer').innerHTML = '';
            document.getElementById('videoMetaContainer').innerHTML = '';
        } else {
            imageSection.style.display = 'none';
            videoSection.style.display = 'block';
            selectedImageFiles = [];
            document.getElementById('imageInput').value = '';
            document.getElementById('imagePreviewContainer').innerHTML = '';
            document.getElementById('imageMetaContainer').innerHTML = '';
        }
    });
});

// ════════════════════════════════
// IMAGE PREVIEW + META
// ════════════════════════════════
let selectedImageFiles = [];

document.getElementById('imageInput').addEventListener('change', function () {
    Array.from(this.files).forEach(file => {
        const exists = selectedImageFiles.some(f => f.name === file.name && f.size === file.size);
        if (!exists) selectedImageFiles.push(file);
    });
    renderImagePreviews();
});

function renderImagePreviews() {
    const previewContainer = document.getElementById('imagePreviewContainer');
    const metaContainer    = document.getElementById('imageMetaContainer');
    previewContainer.innerHTML = '';
    metaContainer.innerHTML    = '';

    selectedImageFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const item = document.createElement('div');
            item.className = 'img-preview-item';
            item.dataset.index = i;
            item.innerHTML = `
                <img src="${e.target.result}" alt="">
                <button type="button" class="remove-btn" data-index="${i}">✕</button>`;
            previewContainer.appendChild(item);

            const meta = document.createElement('div');
            meta.className = 'meta-field-box';
            meta.dataset.index = i;
            meta.innerHTML = `
                <span class="meta-label">Image ${i + 1}: ${file.name}</span>
                <input type="text" name="image_titles[]" class="form-control" style="margin-bottom:5px;" placeholder="Title (optional)">
                <input type="text" name="image_alts[]"   class="form-control" placeholder="Alt tag (optional)">`;
            metaContainer.appendChild(meta);

            item.querySelector('.remove-btn').addEventListener('click', function () {
                selectedImageFiles.splice(parseInt(this.dataset.index), 1);
                rebuildImageInput();
                renderImagePreviews();
            });
        };
        reader.readAsDataURL(file);
    });
}

function rebuildImageInput() {
    const dt = new DataTransfer();
    selectedImageFiles.forEach(f => dt.items.add(f));
    document.getElementById('imageInput').files = dt.files;
}

// ════════════════════════════════
// VIDEO PREVIEW + META
// ════════════════════════════════
let selectedVideoFiles = [];

document.getElementById('videoInput').addEventListener('change', function () {
    Array.from(this.files).forEach(file => {
        const exists = selectedVideoFiles.some(f => f.name === file.name && f.size === file.size);
        if (!exists) selectedVideoFiles.push(file);
    });
    renderVideoPreviews();
});

function renderVideoPreviews() {
    const previewContainer = document.getElementById('videoPreviewContainer');
    const metaContainer    = document.getElementById('videoMetaContainer');
    previewContainer.innerHTML = '';
    metaContainer.innerHTML    = '';

    selectedVideoFiles.forEach((file, i) => {
        const div = document.createElement('div');
        div.className = 'meta-field-box';
        div.dataset.index = i;
        div.style.marginBottom = '8px';
        div.innerHTML = `
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:20px;">🎬</span>
                    <div>
                        <div style="font-size:12px;font-weight:700;color:#0a214f;">${file.name}</div>
                        <div style="font-size:10px;color:#6b7280;">${(file.size/1024/1024).toFixed(2)} MB</div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-video-btn" data-index="${i}">✕</button>
            </div>`;
        previewContainer.appendChild(div);

        const meta = document.createElement('div');
        meta.className = 'meta-field-box';
        meta.dataset.index = i;
        meta.innerHTML = `
            <span class="meta-label">Video ${i + 1}: ${file.name}</span>
            <input type="text" name="video_titles[]" class="form-control" placeholder="Video title (optional)">`;
        metaContainer.appendChild(meta);

        div.querySelector('.remove-video-btn').addEventListener('click', function () {
            selectedVideoFiles.splice(parseInt(this.dataset.index), 1);
            rebuildVideoInput();
            renderVideoPreviews();
        });
    });
}

function rebuildVideoInput() {
    const dt = new DataTransfer();
    selectedVideoFiles.forEach(f => dt.items.add(f));
    document.getElementById('videoInput').files = dt.files;
}

// Clear previews on reset
function clearPreviews() {
    selectedImageFiles = [];
    selectedVideoFiles = [];
    document.getElementById('imagePreviewContainer').innerHTML = '';
    document.getElementById('imageMetaContainer').innerHTML = '';
    document.getElementById('videoPreviewContainer').innerHTML = '';
    document.getElementById('videoMetaContainer').innerHTML = '';
}

// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('.alert-success, .alert-danger, .alert-validation').forEach(el => el.remove());
}, 5000);

</script>

@endsection
