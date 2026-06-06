@extends('backend.layouts.layout')
@section('title', 'Add New Page SEO')
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

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
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
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .form-group { margin-bottom: 12px; }

    textarea.form-control { resize: vertical; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 14px 0; }
    .text-danger { color: #ef4444; }

    .two-col-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
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
    @media (max-width: 640px) { .two-col-grid { grid-template-columns: 1fr; } }
</style>

<div class="page-container">

    <div class="page-header">
        <h1 class="page-title">🔍 Add New Page SEO</h1>
        <p class="page-subtitle">Fill in the SEO details for a new page</p>
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
        <div class="card-header-gradient">
            <h2 class="card-header-title"><i class="fas fa-plus-circle"></i> New SEO Entry</h2>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.pageseo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Page Identity --}}
                <div class="card-header-section">
                    <h6><i class="fas fa-id-card"></i> Page Identity</h6>
                </div>

                <div class="two-col-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Page Name <span class="text-danger">*</span>
                            <small>Friendly name for the admin panel</small>
                        </label>
                        <input type="text" class="form-control @error('page_name') is-invalid @enderror"
                            name="page_name" value="{{ old('page_name') }}"
                            placeholder="e.g. About Us" required>
                        @error('page_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Page Type (Route) <span class="text-danger">*</span>
                            <small>Select the type of page</small>
                        </label>
                        <input type="text" class="form-control @error('route_name') is-invalid @enderror" 
    name="route_name" 
    value="{{ old('route_name') }}"
    placeholder="e.g. about, contact, home, collections"
    required>
                        @error('route_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Page Slug (for Dynamic Pages)
                        <small>Required ONLY for "Service Detail" or similar dynamic routes. Leave empty for static pages.</small>
                    </label>
                    <input type="text" class="form-control" name="page_slug"
                        value="{{ old('page_slug') }}" placeholder="e.g. 3d-scanning">
                </div>

                <hr>

                {{-- Meta Tags --}}
                <div class="card-header-section">
                    <h6><i class="fas fa-tags"></i> Meta Tags</h6>
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                        placeholder="e.g. About Us | Company Name">
                </div>

                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" rows="3"
                        placeholder="Brief description of the page (150–160 characters recommended)">{{ old('meta_description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Meta Keywords
                        <small>Comma separated keywords</small>
                    </label>
                    <input type="text" class="form-control" name="meta_keywords"
                        value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
                </div>

                <hr>

                {{-- Open Graph --}}
                <div class="card-header-section">
                    <h6><i class="fas fa-share-alt"></i> Open Graph (Social Media)</h6>
                </div>

                <div class="form-group">
                    <label class="form-label">OG Title</label>
                    <input type="text" class="form-control" name="og_title" value="{{ old('og_title') }}"
                        placeholder="Title shown when shared on social media">
                </div>

                <div class="form-group">
                    <label class="form-label">OG Description</label>
                    <textarea class="form-control" name="og_description" rows="3"
                        placeholder="Description shown when shared on social media">{{ old('og_description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        OG Image
                        <small>Recommended size: 1200×630px</small>
                    </label>
                    <input type="file" class="form-control" name="og_image" accept="image/*">
                </div>

                <div class="btn-group-custom">
                    <a href="{{ route('admin.pageseo.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Page SEO
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
