@extends('backend.layouts.layout')
@section('title', 'Edit Page SEO')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 900px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        margin-bottom: 16px;
    }

    .card-header-warning {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-section {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        padding: 8px 16px; color: #ffffff; margin: 0 -16px 14px;
    }
    .card-header-section h6 {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 6px; letter-spacing: 0.05em; text-transform: uppercase;
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
    .form-control[readonly] {
        background: #f9fafb; color: #6b7280; cursor: not-allowed;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .form-group { margin-bottom: 12px; }

    textarea.form-control { resize: vertical; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 14px 0; }
    .text-danger { color: #ef4444; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; box-shadow: 0 6px 16px rgba(245,158,11,0.4); }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); color: #1f2937; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; justify-content: flex-end; flex-wrap: wrap; }

    .alert-errors {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 14px; border-radius: 8px; margin-bottom: 14px;
        font-size: 12px;
    }
    .alert-errors ul { margin: 6px 0 0; padding-left: 18px; }
    .alert-errors li { margin-bottom: 2px; }

    .og-image-preview {
        margin-top: 8px; display: inline-block;
        border: 2px solid #e5e7eb; border-radius: 8px; overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .og-image-preview img { display: block; height: 80px; width: auto; }

    .readonly-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #fef3c7; color: #92400e; font-size: 10px;
        padding: 3px 8px; border-radius: 20px; font-family: 'Sora', sans-serif;
        font-weight: 700; border: 1px solid #fde68a; margin-left: 8px; vertical-align: middle;
    }
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

    <div class="page-header">
        <h1 class="page-title">✏️ Edit Page SEO</h1>
        <p class="page-subtitle">Updating SEO settings for: <strong>{{ $pageSeo->page_name }}</strong></p>
    </div>

    @if($errors->any())
        <div class="alert-errors">
            <strong>⚠️ Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-card">
        <div class="card-header-warning">
            <h2 class="card-header-title"><i class="fas fa-pen"></i> Edit SEO — #{{ $pageSeo->id }} {{ $pageSeo->page_name }}</h2>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.pageseo.update', $pageSeo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Page Identity --}}
                <div class="card-header-section">
                    <h6><i class="fas fa-id-card"></i> Page Identity</h6>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Page Type (Route)
                        <span class="readonly-badge"><i class="fas fa-lock"></i> Read Only</span>
                    </label>
                    <input type="text" class="form-control" name="route_name"
                        value="{{ $pageSeo->route_name }}" readonly>
                    <small style="font-size:10px;color:#9ca3af;margin-top:4px;display:block;">
                        Page Type cannot be changed once created.
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Page Slug
                        <small>Optional. Identifies specific page for dynamic routes (e.g. 3d-scanning)</small>
                    </label>
                    <input type="text" class="form-control" name="page_slug"
                        value="{{ old('page_slug', $pageSeo->page_slug) }}"
                        placeholder="e.g. 3d-scanning">
                </div>

                <hr>

                {{-- Meta Tags --}}
                <div class="card-header-section">
                    <h6><i class="fas fa-tags"></i> Meta Tags</h6>
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="title"
                        value="{{ old('title', $pageSeo->title) }}"
                        placeholder="e.g. About Us | Company Name">
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" rows="3"
                        placeholder="150–160 characters recommended">{{ old('meta_description', $pageSeo->meta_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Meta Keywords
                        <small>Comma separated keywords</small>
                    </label>
                    <input type="text" class="form-control" name="meta_keywords"
                        value="{{ old('meta_keywords', $pageSeo->meta_keywords) }}"
                        placeholder="keyword1, keyword2, keyword3">
                </div>

                <hr>

                {{-- Open Graph --}}
                <div class="card-header-section">
                    <h6><i class="fas fa-share-alt"></i> Open Graph (Social Media)</h6>
                </div>

                <div class="form-group">
                    <label class="form-label">OG Title</label>
                    <input type="text" class="form-control" name="og_title"
                        value="{{ old('og_title', $pageSeo->og_title) }}"
                        placeholder="Title shown when shared on social media">
                </div>

                <div class="form-group">
                    <label class="form-label">OG Description</label>
                    <textarea class="form-control" name="og_description" rows="3"
                        placeholder="Description shown when shared on social media">{{ old('og_description', $pageSeo->og_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        OG Image
                        <small>Upload a new image to replace the current one. Recommended: 1200×630px</small>
                    </label>
                    <input type="file" class="form-control" name="og_image" accept="image/*">
                    @if($pageSeo->og_image)
                        <div class="og-image-preview mt-2">
                            <img src="{{ asset('public/uploads/pages/' . $pageSeo->og_image) }}" alt="Current OG Image">
                        </div>
                        <div style="font-size:10px;color:#9ca3af;margin-top:4px;">Current image shown above. Upload a new one to replace.</div>
                    @endif
                </div>

                <div class="btn-group-custom">
                    <a href="{{ route('admin.pageseo.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update SEO Settings
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
