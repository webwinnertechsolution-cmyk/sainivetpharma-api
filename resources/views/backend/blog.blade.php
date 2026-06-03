@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 20px; }

    .page-header { margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 13px; color: #6b7280; font-weight: 500; }

    .breadcrumb-bar { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 12px; color: #6b7280; }
    .breadcrumb-bar a { color: #1872B5; text-decoration: none; font-weight: 600; }
    .breadcrumb-bar a:hover { text-decoration: underline; }
    .breadcrumb-bar .sep { opacity: 0.4; }

    /* ALERTS */
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 12px 14px; border-radius: 8px; margin-bottom: 16px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px; animation: slideIn 0.3s ease;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 12px 14px; border-radius: 8px; margin-bottom: 16px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px; animation: slideIn 0.3s ease;
    }
    .alert-validation {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 12px 14px; border-radius: 8px; margin-bottom: 16px;
        font-weight: 500; font-size: 12px; animation: slideIn 0.3s ease;
    }
    .alert-validation ul { margin: 8px 0 0 16px; padding: 0; }
    .alert-validation li { margin-bottom: 3px; font-size: 11px; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    /* CARDS */
    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-light {
        background: #f9fafb; padding: 12px 16px;
        border-bottom: 1.5px solid #e5e7eb;
    }
    .card-header-primary {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-info {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-success {
        background: linear-gradient(135deg, #065f46, #059669);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px; color: #0a214f;
    }
    .card-header-primary .card-header-title,
    .card-header-info .card-header-title,
    .card-header-success .card-header-title { color: #ffffff; }

    .card-body { padding: 16px; }

    /* FORMS */
    .form-label {
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        color: #0a214f; margin-bottom: 6px; display: block;
    }
    .form-label small { display: block; font-size: 10px; font-weight: 500; color: #6b7280; margin-top: 2px; }
    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 8px 10px; font-size: 12px; font-family: 'Nunito', sans-serif;
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
    .form-hint { font-size: 10px; color: #9ca3af; margin-top: 3px; display: block; }
    .slug-preview { background: #f1f5f9; padding: 8px 10px; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 11px; color: #1e40af; margin-top: 5px; border: 1px solid #e0e7ff; }

    /* CHECKBOXES */
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

    /* IMAGE PREVIEW */
    .img-preview-box {
        margin-top: 8px; display: inline-block; position: relative;
        border: 1.5px solid #e5e7eb; border-radius: 8px; overflow: hidden;
        background: #f9fafb;
    }
    .img-preview-box img { display: block; max-width: 200px; max-height: 140px; object-fit: cover; }
    .img-label { font-size: 10px; color: #9ca3af; margin-top: 6px; display: block; }

    /* INFO TIP */
    .info-tip {
        background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px;
        padding: 10px 12px; font-size: 11px; color: #1d4ed8; margin-bottom: 12px;
        display: flex; align-items: flex-start; gap: 8px;
    }
    .info-tip i { flex-shrink: 0; margin-top: 1px; }

    /* BUTTONS */
    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-success { background: linear-gradient(135deg, #059669, #10b981); color: white; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
    .btn-success:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(16,185,129,0.4); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #dc2626, #ef4444); color: white; box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(239,68,68,0.4); color: white; }
    .btn-sm { padding: 4px 9px; font-size: 10px; }
    .btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .btn-group { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* TABLE */
    .table-wrapper { overflow-x: auto; }
    .table {
        width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 0;
    }
    .table th {
        background: #f9fafb; font-weight: 700; color: #0a214f; padding: 10px 12px;
        border-bottom: 1.5px solid #e5e7eb; text-align: left; font-family: 'Sora', sans-serif;
    }
    .table td {
        padding: 10px 12px; color: #374151; border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background: #f9fafb; transition: background 0.2s;
    }
    .table tbody tr:last-child td { border-bottom: 1px solid #e5e7eb; }

    .badge {
        display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 10px;
        font-weight: 600; font-family: 'Sora', sans-serif;
    }
    .badge-primary { background: #dbeafe; color: #1e40af; }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-info { background: #cffafe; color: #0c4a6e; }
    .badge-secondary { background: #e5e7eb; color: #4b5563; }

    .img-thumbnail {
        border: 1px solid #e5e7eb; border-radius: 6px; padding: 2px; transition: all 0.2s;
    }
    .img-thumbnail:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

    /* EMPTY STATE */
    .empty-state {
        text-align: center; padding: 40px 20px; color: #9ca3af;
    }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #d1d5db; opacity: 0.5; }
    .empty-state p { font-size: 13px; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .form-row-2, .form-row-3 { grid-template-columns: 1fr; }
        .btn-group { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
        .table { font-size: 11px; }
        .table td, .table th { padding: 8px; }
        .checkbox-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
    }

    .text-danger { color: #ef4444; }
    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
</style>

<div class="page-container">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-bar">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span class="sep">›</span>
        <span>Blog Management</span>
    </div>

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-newspaper" style="color: #1872B5;"></i> Blog Management
            </h1>
            <p class="page-subtitle">Create and manage your blog posts, categories, and tags</p>
        </div>
    </div>

    {{-- ALERTS --}}
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

    {{-- ADD/EDIT FORM --}}
    <div class="page-card">
        <div class="card-header-primary">
            <h3 class="card-header-title">
                <i class="fas fa-{{ isset($editBlog) ? 'edit' : 'plus-circle' }}"></i>
                {{ isset($editBlog) ? '✏️ Edit Blog Post' : '📝 Add New Blog Post' }}
            </h3>
        </div>
        <div class="card-body">
            <form id="blogForm" action="{{ isset($editBlog) ? route('blog.update', $editBlog->id) : route('blog.store') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf

                {{-- BASIC INFO --}}
                <div class="page-card">
                    <div class="card-header-light">
                        <h3 class="card-header-title"><i class="fas fa-info-circle" style="color: #1872B5;"></i> Basic Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Post Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title', isset($editBlog) ? $editBlog->title : '') }}"
                                   placeholder="e.g. How to Care for Your Plants"
                                   required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug"
                                   value="{{ old('slug', isset($editBlog) ? $editBlog->slug : '') }}"
                                   placeholder="url-friendly-slug"
                                   required>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="slug-preview">🔗 <span id="slug-text">Will generate from title</span></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      id="excerpt" name="excerpt" rows="2"
                                      placeholder="Brief summary for blog listings">{{ old('excerpt', isset($editBlog) ? $editBlog->excerpt : '') }}</textarea>
                            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="editor" name="content" rows="8">{{ old('content', isset($editBlog) ? $editBlog->content : '') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- IMAGES --}}
                <div class="page-card">
                    <div class="card-header-info">
                        <h3 class="card-header-title"><i class="fas fa-image"></i> Images</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row form-row-2">
                            <div>
                                <div class="form-group">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                           name="featured_image" accept="image/*"
                                           onchange="previewImage(event, 'featured')">
                                    @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                    @if(isset($editBlog) && $editBlog->featured_image)
                                        <div class="img-preview-box mt-3">
                                            <img src="{{ asset('uploads/blogs/' . $editBlog->featured_image) }}"
                                                 alt="{{ $editBlog->image_alt_tag ?? 'Featured' }}">
                                        </div>
                                        <span class="img-label">Current featured image</span>
                                    @endif

                                    <div id="featured-preview" style="display:none;">
                                        <div class="img-preview-box mt-3">
                                            <img id="featured-img" src="">
                                        </div>
                                        <span class="img-label">New image preview</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Featured Image Alt Tag</label>
                                    <input type="text" class="form-control"
                                           name="image_alt_tag"
                                           value="{{ old('image_alt_tag', isset($editBlog) ? $editBlog->image_alt_tag : '') }}"
                                           placeholder="Image description for SEO">
                                </div>
                            </div>

                            <div>
                                <div class="form-group">
                                    <label class="form-label">OG Image <small>(Social Media)</small></label>
                                    <input type="file" class="form-control @error('og_image') is-invalid @enderror"
                                           name="og_image" accept="image/*"
                                           onchange="previewImage(event, 'og')">
                                    @error('og_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="form-hint">1200×630px recommended</small>

                                    @if(isset($editBlog) && $editBlog->og_image)
                                        <div class="img-preview-box mt-3">
                                            <img src="{{ asset('uploads/blogs/og/' . $editBlog->og_image) }}"
                                                 alt="OG Image">
                                        </div>
                                        <span class="img-label">Current OG image</span>
                                    @endif

                                    <div id="og-preview" style="display:none;">
                                        <div class="img-preview-box mt-3">
                                            <img id="og-img" src="">
                                        </div>
                                        <span class="img-label">New OG preview</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">OG Image Alt Tag</label>
                                    <input type="text" class="form-control"
                                           name="og_image_alt_tag"
                                           value="{{ old('og_image_alt_tag', isset($editBlog) ? $editBlog->og_image_alt_tag : '') }}"
                                           placeholder="OG image description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CATEGORIES & TAGS --}}
                <div class="page-card">
                    <div class="card-header-success">
                        <h3 class="card-header-title"><i class="fas fa-tags"></i> Categories & Tags</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Categories</label>
                                <div class="checkbox-grid">
                                    @forelse($categories as $category)
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="cat-{{ $category->id }}"
                                                   name="categories[]" value="{{ $category->id }}"
                                                {{ isset($editBlog) && $editBlog->categories->contains($category->id) ? 'checked' : '' }}>
                                            <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                    @empty
                                        <p class="text-muted" style="grid-column: 1/-1; text-align: center; padding: 20px; font-size: 11px;">
                                            No categories available
                                        </p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tags</label>
                                <div class="checkbox-grid">
                                    @forelse($tags as $tag)
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="tag-{{ $tag->id }}"
                                                   name="tags[]" value="{{ $tag->id }}"
                                                {{ isset($editBlog) && $editBlog->tags->contains($tag->id) ? 'checked' : '' }}>
                                            <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                                        </div>
                                    @empty
                                        <p class="text-muted" style="grid-column: 1/-1; text-align: center; padding: 20px; font-size: 11px;">
                                            No tags available
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATUS & OG --}}
                <div class="page-card">
                    <div class="card-header-light">
                        <h3 class="card-header-title"><i class="fas fa-cog" style="color: #1872B5;"></i> Status & Open Graph</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status', isset($editBlog) ? $editBlog->status : '') == 'draft' ? 'selected' : '' }}>📋 Draft</option>
                                    <option value="published" {{ old('status', isset($editBlog) ? $editBlog->status : '') == 'published' ? 'selected' : '' }}>✅ Published</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">OG Title</label>
                                <input type="text" class="form-control"
                                       name="og_title"
                                       value="{{ old('og_title', isset($editBlog) ? $editBlog->og_title : '') }}"
                                       placeholder="Title for social sharing">
                                <small class="form-hint">Leave empty to use post title</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">OG Description</label>
                            <textarea class="form-control" name="og_description" rows="2"
                                      placeholder="Description when shared on social media">{{ old('og_description', isset($editBlog) ? $editBlog->og_description : '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div class="page-card">
                    <div class="card-header-light">
                        <h3 class="card-header-title"><i class="fas fa-search" style="color: #1872B5;"></i> SEO Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control"
                                       name="meta_title"
                                       value="{{ old('meta_title', isset($editBlog) ? $editBlog->meta_title : '') }}"
                                       placeholder="Leave empty to use post title"
                                       maxlength="60">
                                <small class="form-hint">Max 60 characters</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control"
                                       name="meta_keywords"
                                       value="{{ old('meta_keywords', isset($editBlog) ? $editBlog->meta_keywords : '') }}"
                                       placeholder="keyword1, keyword2">
                                <small class="form-hint">Comma-separated</small>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="2"
                                      maxlength="160">{{ old('meta_description', isset($editBlog) ? $editBlog->meta_description : '') }}</textarea>
                            <small class="form-hint">Max 160 characters for search results</small>
                        </div>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="btn-group">
                    @if(isset($editBlog))
                        <a href="{{ route('blog') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" id="submitBtn" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Post
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" id="submitBtn" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Post
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- BLOG LIST --}}
    <div class="page-card">
        <div class="card-header-primary">
            <h3 class="card-header-title"><i class="fas fa-list"></i> All Blog Posts</h3>
        </div>
        <div class="card-body">
            @if($blogs->count() > 0)
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th style="width: 100px;">Image</th>
                                <th>Title</th>
                                <th style="width: 120px;">Categories</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 100px;">Published</th>
                                <th style="width: 160px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                            <tr>
                                <td><strong>#{{ $blog->id }}</strong></td>
                                <td>
                                    @if($blog->featured_image)
                                        <img src="{{ asset('uploads/blogs/' . $blog->featured_image) }}"
                                             alt="{{ $blog->image_alt_tag ?? 'Blog' }}"
                                             style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;"
                                             class="img-thumbnail">
                                    @else
                                        <span class="badge badge-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ Str::limit($blog->title, 45) }}</strong><br>
                                    <code style="font-size: 10px; color: #6b7280;">{{ Str::limit($blog->slug, 35) }}</code>
                                </td>
                                <td>
                                    @forelse($blog->categories as $category)
                                        <span class="badge badge-primary">{{ $category->name }}</span><br>
                                    @empty
                                        <span class="text-muted" style="font-size: 10px;">-</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($blog->status === 'published')
                                        <span class="badge badge-success">✅ Published</span>
                                    @else
                                        <span class="badge badge-secondary">📋 Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->published_at)
                                        <small><strong>{{ $blog->published_at->format('d M Y') }}</strong></small><br>
                                        <small class="text-muted">{{ $blog->published_at->format('h:i A') }}</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('blog.edit', $blog->id) }}"
                                       class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('blog.delete', $blog->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Delete this blog post?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <p><strong>No blog posts yet</strong></p>
                    <p style="font-size: 11px;">Create your first blog post above to get started!</p>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
let editorInstance;

// Initialize CKEditor
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
})
.then(editor => { editorInstance = editor; })
.catch(console.error);

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
    const slug = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const slugInput = document.getElementById('slug');
    if (!slugInput.value || slugInput.dataset.auto === 'true') {
        slugInput.value = slug;
        slugInput.dataset.auto = 'true';
    }
    updateSlugPreview();

    if (!document.getElementById('meta_title').value) {
        document.getElementById('meta_title').value = e.target.value.substring(0, 60);
    }
    if (!document.getElementById('og_title').value) {
        document.getElementById('og_title').value = e.target.value;
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.auto = 'false';
    updateSlugPreview();
});

function updateSlugPreview() {
    const slug = document.getElementById('slug').value;
    document.getElementById('slug-text').textContent = slug
        ? window.location.origin + '/blog/' + slug
        : 'Will generate from title';
}

// Preview images
function previewImage(event, type) {
    const file = event.target.files[0];
    const previewDiv = document.getElementById(type + '-preview');
    const previewImg = document.getElementById(type + '-img');
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        previewDiv.style.display = 'none';
    }
}

// Form submit
document.getElementById('blogForm').addEventListener('submit', function(e) {
    if (editorInstance) document.querySelector('#editor').value = editorInstance.getData();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    return true;
});

// Initialize on load
window.addEventListener('DOMContentLoaded', updateSlugPreview);

// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('.alert-success,.alert-danger,.alert-validation').forEach(el => el.remove());
}, 5000);
</script>

@endsection
