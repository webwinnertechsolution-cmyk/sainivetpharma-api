@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-tags me-2 text-primary"></i>Product Categories
                </h2>
                <span class="badge bg-secondary fs-6">Total: {{ $categories->count() }}</span>
            </div>

            {{-- Success / Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ADD / EDIT FORM --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header {{ isset($editCategory) ? 'bg-warning text-dark' : 'bg-primary text-white' }}">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($editCategory) ? 'edit' : 'plus-circle' }} me-2"></i>
                        {{ isset($editCategory) ? 'Edit Category: ' . $editCategory->name : 'Add New Category' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editCategory) ? route('product.category.update', $editCategory->id) : route('product.category.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- ══════════════════════════════════
                             SECTION 1 — BASIC INFO
                        ══════════════════════════════════ --}}
                        <div class="section-label">
                            <i class="fas fa-info-circle me-2"></i>Basic Information
                        </div>

                        <div class="row">
                            {{-- Name --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">
                                    Category Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $editCategory->name ?? '') }}"
                                       placeholder="e.g. Electronics, Clothing..."
                                       oninput="autoSlug(this.value)"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       name="slug"
                                       id="slug"
                                       value="{{ old('slug', $editCategory->slug ?? '') }}"
                                       placeholder="auto-generated from name">
                                <small class="text-muted">It will be used in the URL. Leave it blank to auto-generate.</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">Sort Order</label>
                                <input type="number"
                                       class="form-control"
                                       name="sort_order"
                                       value="{{ old('sort_order', $editCategory->sort_order ?? 0) }}"
                                       min="0">
                            </div>

                            {{-- Is Active --}}
                            <div class="col-md-2 mb-3 d-flex align-items-center">
                                <div class="form-check form-switch mt-3">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', $editCategory->is_active ?? 1) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Description --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control"
                                          name="description"
                                          rows="3"
                                          placeholder="Short description of the category...">{{ old('description', $editCategory->description ?? '') }}</textarea>
                            </div>

                            {{-- Image --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">Category Image</label>
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       name="image"
                                       accept="image/*"
                                       onchange="previewImage(this, 'imagePreview')">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max 2MB. JPG, PNG, WebP</small>
                                <div id="imagePreview" class="mt-2">
                                    @if(isset($editCategory) && $editCategory->image)
                                        <img src="{{ asset('uploads/product-categories/' . $editCategory->image) }}"
                                             class="img-thumbnail" style="max-height:80px;">
                                    @endif
                                </div>
                            </div>

                            {{-- Image Alt --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">Image Alt Tag</label>
                                <input type="text"
                                       class="form-control"
                                       name="image_alt"
                                       value="{{ old('image_alt', $editCategory->image_alt ?? '') }}"
                                       placeholder="Image ka alt text">
                            </div>
                        </div>

                        {{-- ══════════════════════════════════
                             SECTION 2 — SEO SETTINGS
                        ══════════════════════════════════ --}}
                        <div class="section-label mt-3">
                            <i class="fas fa-search me-2"></i>SEO Settings
                            <small class="text-muted fw-normal ms-2">(Search Engine Optimization)</small>
                        </div>

                        <div class="row">
                            {{-- Meta Title --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Meta Title</label>
                                <input type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       name="meta_title"
                                       id="meta_title"
                                       value="{{ old('meta_title', $editCategory->meta_title ?? '') }}"
                                       placeholder="SEO Title — leave it blank to use the category name."
                                       maxlength="255"
                                       oninput="charCount(this, 'metaTitleCount', 60)">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Recommended: 50–60 characters</small>
                                    <small id="metaTitleCount" class="char-count">0 / 60</small>
                                </div>
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Meta Keywords --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Meta Keywords</label>
                                <input type="text"
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       name="meta_keywords"
                                       value="{{ old('meta_keywords', $editCategory->meta_keywords ?? '') }}"
                                       placeholder="keyword1, keyword2, keyword3">
                                <small class="text-muted">Comma separated keywords</small>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Meta Description --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          name="meta_description"
                                          id="meta_description"
                                          rows="2"
                                          maxlength="500"
                                          placeholder="SEO Description — will appear in Google search results (150–160 characters recommended)."
                                          oninput="charCount(this, 'metaDescCount', 160)">{{ old('meta_description', $editCategory->meta_description ?? '') }}</textarea>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Recommended: 150–160 characters</small>
                                    <small id="metaDescCount" class="char-count">0 / 160</small>
                                </div>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ══════════════════════════════════
                             SECTION 3 — OG / SOCIAL SETTINGS
                        ══════════════════════════════════ --}}
                        <div class="section-label mt-3">
                            <i class="fas fa-share-alt me-2"></i>Social / OG Settings
                            <small class="text-muted fw-normal ms-2">(Facebook, WhatsApp, Twitter share preview)</small>
                        </div>

                        <div class="row">
                            {{-- OG Title --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">OG Title</label>
                                <input type="text"
                                       class="form-control @error('og_title') is-invalid @enderror"
                                       name="og_title"
                                       value="{{ old('og_title', $editCategory->og_title ?? '') }}"
                                       placeholder="Social share title — leave it blank to use the meta title."
                                       maxlength="255">
                                @error('og_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- OG Image --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">OG Image</label>
                                <input type="file"
                                       class="form-control @error('og_image') is-invalid @enderror"
                                       name="og_image"
                                       accept="image/*"
                                       onchange="previewImage(this, 'ogImagePreview')">
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended: 1200×630px</small>
                                <div id="ogImagePreview" class="mt-2">
                                    @if(isset($editCategory) && $editCategory->og_image)
                                        <img src="{{ asset('uploads/product-categories/og/' . $editCategory->og_image) }}"
                                             class="img-thumbnail" style="max-height:80px;">
                                    @endif
                                </div>
                            </div>

                            {{-- OG Image Alt --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">OG Image Alt</label>
                                <input type="text"
                                       class="form-control"
                                       name="og_image_alt"
                                       value="{{ old('og_image_alt', $editCategory->og_image_alt ?? '') }}"
                                       placeholder="OG image alt text">
                            </div>
                        </div>

                        <div class="row">
                            {{-- OG Description --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">OG Description</label>
                                <textarea class="form-control @error('og_description') is-invalid @enderror"
                                          name="og_description"
                                          rows="2"
                                          placeholder="Social share description — blank chhodo to meta description use hoga">{{ old('og_description', $editCategory->og_description ?? '') }}</textarea>
                                @error('og_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- ══════════════════════════════════
                             BUTTONS
                        ══════════════════════════════════ --}}
                        <div class="d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-{{ isset($editCategory) ? 'warning' : 'primary' }} px-4">
                                <i class="fas fa-save me-1"></i>
                                {{ isset($editCategory) ? 'Update Category' : 'Add Category' }}
                            </button>
                            @if(isset($editCategory))
                                <a href="{{ route('product.category') }}" class="btn btn-secondary px-4">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>

            {{-- ══════════════════════════════════
                 CATEGORIES TABLE
            ══════════════════════════════════ --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>All Product Categories
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;" class="text-center">#</th>
                                    <th style="width:70px;" class="text-center">Image</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th style="width:100px;" class="text-center">Products</th>
                                    <th style="width:90px;" class="text-center">SEO</th>
                                    <th style="width:80px;" class="text-center">Status</th>
                                    <th style="width:80px;" class="text-center">Order</th>
                                    <th style="width:130px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr class="{{ isset($editCategory) && $editCategory->id == $category->id ? 'table-warning' : '' }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    {{-- Image --}}
                                    <td class="text-center">
                                        @if($category->image)
                                            <img src="{{ asset('uploads/product-categories/' . $category->image) }}"
                                                 alt="{{ $category->image_alt }}"
                                                 class="img-thumbnail"
                                                 style="width:45px; height:45px; object-fit:cover;">
                                        @else
                                            <span class="text-muted"><i class="fas fa-image fa-lg"></i></span>
                                        @endif
                                    </td>

                                    <td><strong>{{ $category->name }}</strong></td>

                                    <td><code class="text-primary">{{ $category->slug }}</code></td>

                                    <td>
                                        <span class="text-muted small">
                                            {{ $category->description ? \Illuminate\Support\Str::limit($category->description, 60) : '-' }}
                                        </span>
                                    </td>

                                    {{-- Products Count --}}
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">
                                            {{ $category->products_count ?? 0 }} products
                                        </span>
                                    </td>

                                    {{-- SEO Status --}}
                                    <td class="text-center">
                                        @if($category->meta_title || $category->meta_description)
                                            <span class="badge bg-success" title="Meta Title: {{ $category->meta_title }}">
                                                <i class="fas fa-check me-1"></i>Done
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation me-1"></i>Missing
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        @if($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- Sort Order --}}
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $category->sort_order }}</span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <a href="{{ route('product.category.edit', $category->id) }}"
                                           class="btn btn-sm btn-primary mb-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('product.category.delete', $category->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure? If there are products, it will not be deleted..');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-1" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                            <p class="mb-1 fs-5">No category found.</p>
                                            <small>Add the first category from the form above!</small>
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
</div>

<style>
.table td { vertical-align: middle; }
.card { border-radius: 8px; }
.card-header { border-radius: 8px 8px 0 0 !important; }
.form-check-input { width: 2.5em; height: 1.3em; cursor: pointer; }

/* Section labels */
.section-label {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #374151;
    background: #f3f4f6;
    border-left: 4px solid #3b82f6;
    padding: 8px 14px;
    border-radius: 0 6px 6px 0;
    margin-bottom: 16px;
}

/* Char counter */
.char-count {
    font-size: 11px;
    font-weight: 600;
    color: #6b7280;
    transition: color .2s;
}
.char-count.warn  { color: #f59e0b; }
.char-count.over  { color: #dc2626; }
</style>

<script>
// ── Auto slug from name ──
function autoSlug(name) {
    const slugField = document.getElementById('slug');
    if (slugField.dataset.manually !== 'true') {
        slugField.value = name
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
}
document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manually = 'true';
    if (this.value === '') this.dataset.manually = 'false';
});

// ── Image preview ──
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail mt-1';
            img.style.maxHeight = '80px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Character counter ──
function charCount(el, counterId, limit) {
    const len     = el.value.length;
    const counter = document.getElementById(counterId);
    counter.textContent = len + ' / ' + limit;
    counter.className   = 'char-count';
    if (len > limit)            counter.classList.add('over');
    else if (len > limit * 0.85) counter.classList.add('warn');
}

// ── Init counters on page load ──
document.addEventListener('DOMContentLoaded', function () {
    const metaTitle = document.getElementById('meta_title');
    const metaDesc  = document.getElementById('meta_description');
    if (metaTitle) charCount(metaTitle, 'metaTitleCount', 60);
    if (metaDesc)  charCount(metaDesc,  'metaDescCount',  160);
});
</script>
@endsection