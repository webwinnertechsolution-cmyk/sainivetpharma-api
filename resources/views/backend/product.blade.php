@extends('backend.layouts.layout')
@section('content')

<style>
/* =============================================
   SHOPIFY-STYLE VARIANT BUILDER
   ============================================= */
.variant-builder-wrap { font-family: inherit; }

.vg-card {
    background: #fff;
    border: 1.5px solid #dde1e9;
    border-radius: 10px;
    margin-bottom: 14px;
    overflow: hidden;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.vg-card:hover { border-color: #5c6ac4; box-shadow: 0 2px 10px rgba(92,106,196,0.10); }

.vg-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: #f7f8fc;
    border-bottom: 1px solid #dde1e9;
}
.vg-header input[type="text"] {
    flex: 1;
    border: 1.5px solid #dde1e9;
    border-radius: 7px;
    padding: 7px 12px;
    font-size: 14px;
    font-weight: 600;
    color: #1a2332;
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
}
.vg-header input[type="text"]:focus {
    border-color: #5c6ac4;
    box-shadow: 0 0 0 3px rgba(92,106,196,0.12);
}
.vg-header input::placeholder { font-weight: 400; color: #b0b8c4; }
.vg-type-label {
    font-size: 11px;
    font-weight: 700;
    color: #5c6ac4;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    white-space: nowrap;
}
.btn-vg-remove {
    background: none;
    border: none;
    color: #c44b4b;
    padding: 6px 9px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    line-height: 1;
    transition: background 0.15s;
    flex-shrink: 0;
}
.btn-vg-remove:hover { background: #fef0f0; }

.vg-options-area { padding: 13px 15px 10px; }
.vg-tags-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    min-height: 36px;
    align-items: center;
    margin-bottom: 9px;
}
.vg-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #eef0fd;
    border: 1.5px solid #c5caf5;
    color: #3a46a8;
    border-radius: 20px;
    padding: 4px 10px 4px 12px;
    font-size: 13px;
    font-weight: 500;
    cursor: default;
    animation: tagPop 0.15s ease;
}
@keyframes tagPop { from { transform: scale(0.85); opacity:0; } to { transform: scale(1); opacity:1; } }
.vg-tag .tag-x {
    background: none;
    border: none;
    padding: 0 0 0 2px;
    cursor: pointer;
    color: #8892d8;
    font-size: 13px;
    line-height: 1;
    transition: color 0.15s;
}
.vg-tag .tag-x:hover { color: #c44b4b; }
.vg-input-row {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 3px;
}
.vg-opt-input {
    flex: 1;
    border: 1.5px dashed #c5caf5;
    border-radius: 7px;
    padding: 7px 12px;
    font-size: 13px;
    color: #1a2332;
    background: #f9faff;
    outline: none;
    transition: border-color 0.2s, background 0.2s;
}
.vg-opt-input:focus {
    border-color: #5c6ac4;
    border-style: solid;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(92,106,196,0.10);
}
.vg-opt-input::placeholder { color: #b0b8c4; }
.btn-add-opt {
    background: #5c6ac4;
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 7px 15px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.15s;
}
.btn-add-opt:hover { background: #4959b8; }
.vg-hint { font-size: 11.5px; color: #9aa2b4; margin-top: 6px; }

.btn-add-vg-type {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: #fff;
    border: 2px dashed #5c6ac4;
    color: #5c6ac4;
    border-radius: 9px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 4px;
    transition: all 0.15s;
}
.btn-add-vg-type:hover { background: #f0f2fd; border-color: #4959b8; color: #4959b8; }

.gen-wrap {
    background: #f4f6ff;
    border: 1.5px solid #d5daf5;
    border-radius: 10px;
    margin-top: 18px;
    overflow: hidden;
    animation: fadeIn 0.25s ease;
}
@keyframes fadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
.gen-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 16px;
    background: #eef0fd;
    border-bottom: 1px solid #d5daf5;
}
.gen-head h6 {
    margin: 0;
    font-size: 12.5px;
    font-weight: 700;
    color: #3a46a8;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.gen-badge {
    background: #5c6ac4;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    border-radius: 12px;
    padding: 2px 9px;
}
.gen-table { width: 100%; border-collapse: collapse; }
.gen-table th {
    background: #eef0fd;
    font-size: 11px;
    font-weight: 700;
    color: #5c6ac4;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 8px 13px;
    text-align: left;
    border-bottom: 1px solid #d5daf5;
}
.gen-table td {
    padding: 8px 13px;
    font-size: 13px;
    color: #1a2332;
    border-bottom: 1px solid #e8ebf8;
    vertical-align: middle;
}
.gen-table tr:last-child td { border-bottom: none; }
.gen-table tr:hover td { background: #f0f2fd; }
.gen-name { font-weight: 600; color: #2d3563; }
.gen-input {
    border: 1.5px solid #d5daf5;
    border-radius: 6px;
    padding: 5px 9px;
    font-size: 13px;
    width: 100%;
    outline: none;
    background: #fff;
    color: #1a2332;
    transition: border-color 0.15s;
}
.gen-input:focus {
    border-color: #5c6ac4;
    box-shadow: 0 0 0 2px rgba(92,106,196,0.12);
}
.gen-input.compare-price-input {
    border-color: #f5c5c5;
    background: #fff9f9;
}
.gen-input.compare-price-input:focus {
    border-color: #e05c5c;
    box-shadow: 0 0 0 2px rgba(224,92,92,0.12);
}
.compare-price-hint {
    font-size: 10px;
    color: #e05c5c;
    margin-top: 3px;
    display: block;
}
.no-combo-msg {
    text-align: center;
    padding: 22px 16px;
    color: #9aa2b4;
    font-size: 13px;
}

/* =============================================
   EXTRA TABS STYLES
   ============================================= */
.tab-item {
    background: #fff;
    border: 1.5px solid #dde1e9 !important;
    border-radius: 10px !important;
    padding: 18px !important;
    margin-bottom: 14px !important;
    position: relative;
    transition: border-color 0.2s, box-shadow 0.2s;
    animation: tabSlideIn 0.2s ease;
}
@keyframes tabSlideIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tab-item:hover {
    border-color: #5c6ac4 !important;
    box-shadow: 0 2px 10px rgba(92,106,196,0.10);
}
.tab-item .tab-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eef0fd;
}
.tab-item .tab-number {
    background: #5c6ac4;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.tab-item .tab-label {
    font-size: 13px;
    font-weight: 600;
    color: #3a46a8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    flex: 1;
}
.btn-remove-tab {
    background: none;
    border: none;
    color: #c44b4b;
    padding: 4px 8px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.15s;
    flex-shrink: 0;
}
.btn-remove-tab:hover { background: #fef0f0; }

.btn-add-tab {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: #fff;
    border: 2px dashed #20c997;
    color: #20c997;
    border-radius: 9px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 4px;
    transition: all 0.15s;
}
.btn-add-tab:hover { background: #f0fdf8; border-color: #1aab82; color: #1aab82; }

.no-tabs-msg {
    text-align: center;
    padding: 24px 16px;
    color: #9aa2b4;
    font-size: 13px;
}
.no-tabs-msg i { font-size: 28px; margin-bottom: 8px; display: block; color: #c5e8df; }

/* CKEditor container styling */
.tab-ck-container {
    border: 1.5px solid #dde1e9;
    border-radius: 7px;
    min-height: 150px;
    overflow: hidden;
}
.tab-ck-container .ck-editor__editable {
    min-height: 150px;
}

/* General */
.table td { vertical-align: middle; }
.gallery-img-wrap img { transition: opacity 0.2s; }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4"><i class="fas fa-boxes me-2"></i>Product Management</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Validation Errors:</strong>
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- ========== ADD / EDIT FORM ========== -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header {{ isset($editProduct) ? 'bg-warning text-dark' : 'bg-primary text-white' }}">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($editProduct) ? 'edit' : 'plus-circle' }} me-2"></i>
                        {{ isset($editProduct) ? 'Edit: '.$editProduct->title : 'Add New Product' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="productForm"
                          action="{{ isset($editProduct) ? route('product.update', $editProduct->id) : route('product.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- ── Basic Info ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-info-circle me-2"></i>Basic Information</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Product Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                               id="title" name="title"
                                               value="{{ old('title', $editProduct->title ?? '') }}"
                                               placeholder="e.g. Premium Conveyor Belt Guard" required>
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                               id="slug" name="slug"
                                               value="{{ old('slug', $editProduct->slug ?? '') }}"
                                               placeholder="url-friendly-slug" required>
                                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="mt-2" style="background:#e9ecef;padding:10px;border-radius:5px;font-family:monospace;font-size:12px;">
                                            Preview URL: <span id="slug-text">{{ isset($editProduct) && $editProduct->slug ? url('product/'.$editProduct->slug) : 'Will generate from title' }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Overview / Short Description</label>
                                        <textarea class="form-control" name="overview" rows="2"
                                                  placeholder="Brief product description for listings">{{ old('overview', $editProduct->overview ?? '') }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Full Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="editor" name="description" rows="6">{{ old('description', $editProduct->description ?? '') }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ══════════════════════════════════════════
                             EXTRA TABS — FIXED VERSION
                             ══════════════════════════════════════════ -->
                        <div class="card mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <strong><i class="fas fa-layer-group me-2 text-success"></i>Extra Tabs
                                    <small class="text-muted fw-normal ms-2" style="font-size:12px;">(Specifications, Features, etc.)</small>
                                </strong>
                                <button type="button" class="btn btn-sm btn-success" onclick="addTab()">
                                    <i class="fas fa-plus me-1"></i> Add Tab
                                </button>
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
                                        <div class="tab-header">
                                            <span class="tab-number">{{ $ti + 1 }}</span>
                                            <span class="tab-label">Tab {{ $ti + 1 }}</span>
                                            <button type="button" class="btn-remove-tab" onclick="removeTab(this)" title="Remove Tab">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        {{-- Tab Title --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="fas fa-heading me-1 text-primary"></i> Tab Title
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control"
                                                   name="tab_titles[]"
                                                   value="{{ $tab['title'] ?? '' }}"
                                                   placeholder="e.g. Specifications, Features">
                                        </div>

                                        {{-- Tab Content - FIXED: hidden input + div container --}}
                                        <div>
                                            <label class="form-label fw-semibold">
                                                <i class="fas fa-align-left me-1 text-primary"></i> Tab Content
                                            </label>
                                            {{-- Hidden input: ye actually form submit hogi --}}
                                            <input type="hidden"
       name="tab_contents[]"
       id="tab-hidden-{{ $ti }}"
       value="{{ $tab['content'] ?? '' }}">
                                            {{-- CKEditor yahan mount hoga --}}
                                            <div id="tab-editor-{{ $ti }}"
                                                 class="tab-ck-container"
                                                 data-hidden-id="tab-hidden-{{ $ti }}"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Empty state -->
                                <div id="no-tabs-msg" class="no-tabs-msg"
                                     style="{{ count($existingTabs) > 0 ? 'display:none;' : '' }}">
                                    <i class="fas fa-layer-group"></i>
                                    No extra tabs added yet.<br>
                                    <span style="font-size:12px;">Click <strong>+ Add Tab</strong> to add tabs like Specifications, Features, FAQs, etc.</span>
                                </div>

                                <button type="button" class="btn-add-tab mt-2" onclick="addTab()">
                                    <i class="fas fa-plus-circle"></i> Add New Tab
                                </button>
                            </div>
                        </div>
                        <!-- ══════════════════════════════════════════ -->

                        <!-- ── Images ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-images me-2"></i>Product Images</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Featured Image</label>
                                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                               name="featured_image" accept="image/*"
                                               onchange="previewImage(event,'featured')">
                                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if(isset($editProduct) && $editProduct->featured_image)
                                            <div class="mt-2 position-relative d-inline-block" id="featured-current-wrap">
                                                <img src="{{ asset('uploads/products/'.$editProduct->featured_image) }}"
                                                     style="max-width:200px;max-height:150px;border:1px solid #ddd;padding:5px;border-radius:4px;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute"
                                                        style="top:0;right:0;padding:2px 7px;font-size:11px;border-radius:0 4px 0 4px;"
                                                        onclick="removeFeaturedImage()"><i class="fas fa-times"></i></button>
                                                <input type="hidden" name="remove_featured_image" id="remove_featured_image" value="0">
                                                <p class="text-muted small mt-1 mb-0">Current Featured Image</p>
                                            </div>
                                        @endif
                                        <div id="featured-preview" class="mt-2" style="display:none;">
                                            <img id="featured-img" src="" style="max-width:200px;max-height:150px;border:1px solid #ddd;padding:5px;border-radius:4px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Featured Image Alt Tag</label>
                                        <input type="text" class="form-control" name="featured_image_alt"
                                               value="{{ old('featured_image_alt', $editProduct->featured_image_alt ?? '') }}"
                                               placeholder="Image description for SEO">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Gallery Images (Multiple)</label>
                                        <input type="file" class="form-control" name="gallery_images[]"
                                               accept="image/*,video/mp4,video/webm,video/ogg,video/mov"
                                               multiple onchange="previewGalleryImages(event)">
                                        <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                                        <div id="gallery-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                                        @if(isset($editProduct) && $editProduct->images->count() > 0)
                                            <div class="mt-3">
                                                <p class="fw-semibold mb-2">Existing Gallery Images:</p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($editProduct->images as $img)
                                                    <div class="position-relative gallery-img-wrap" id="gallery-img-{{ $img->id }}" style="width:110px;">
                                                        @if(($img->type ?? 'image') === 'video')
                                                            <div style="width:100px;height:100px;background:#1a1a1a;border:1px solid #ddd;border-radius:4px;display:flex;align-items:center;justify-content:center;flex-direction:column;">
                                                                <span style="font-size:28px;">▶️</span>
                                                                <span style="color:#fff;font-size:9px;margin-top:4px;">Video</span>
                                                            </div>
                                                        @else
                                                            <img src="{{ asset('uploads/products/gallery/'.$img->image) }}"
                                                                 style="width:100px;height:100px;object-fit:cover;border:1px solid #ddd;padding:3px;border-radius:4px;display:block;">
                                                        @endif
                                                        <button type="button" class="btn btn-danger btn-sm position-absolute"
                                                                style="top:0;right:10px;padding:2px 6px;font-size:10px;border-radius:0 4px 0 4px;"
                                                                onclick="deleteGalleryImage({{ $img->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ── Pricing ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-dollar-sign me-2"></i>Pricing & Inventory</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Regular Price</label>
                                        <input type="number" class="form-control" name="price"
                                               value="{{ old('price', $editProduct->price ?? '') }}" step="0.01" min="0" placeholder="0.00">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Sale Price</label>
                                        <input type="number" class="form-control" name="sale_price"
                                               value="{{ old('sale_price', $editProduct->sale_price ?? '') }}" step="0.01" min="0" placeholder="0.00">
                                        <small class="text-muted">Leave empty if not on sale</small>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" class="form-control" name="sku"
                                               value="{{ old('sku', $editProduct->sku ?? '') }}" placeholder="PROD-001">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" class="form-control" name="stock_quantity"
                                               value="{{ old('stock_quantity', $editProduct->stock_quantity ?? 0) }}" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ── Variants ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <strong><i class="fas fa-sliders-h me-2"></i>Product Variants</strong>
                            </div>
                            <div class="card-body variant-builder-wrap">
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-lightbulb text-warning me-1"></i>
                                    First add a <strong>Variant Type</strong> (such as Size, Color), then add <strong>Options</strong>.
                                    The combinations will be automatically generated below.
                                </p>

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
                                                        <i class="fas fa-plus me-1"></i>Add
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
                                        <h6><i class="fas fa-th me-2"></i>Generated Variant Combinations</h6>
                                        <span class="gen-badge" id="gen-badge">0</span>
                                    </div>
                                    <div style="overflow-x:auto;">
                                        <table class="gen-table">
                                            <thead>
                                                <tr>
                                                    <th style="min-width:160px;">Variant</th>
                                                    <th style="min-width:110px;">SKU</th>
                                                    <th style="min-width:110px;">Price (₹)</th>
                                                    <th style="min-width:130px;">Compare Price (₹)</th>
                                                    <th style="min-width:90px;">Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gen-tbody"></tbody>
                                        </table>
                                    </div>
                                    <div style="padding:8px 14px;background:#fff8e1;border-top:1px solid #d5daf5;font-size:11.5px;color:#b07d00;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Compare Price</strong> = Original/MRP price (shown strikethrough). Should be higher than sale price.
                                    </div>
                                </div>

                                @if(isset($editProduct))
                                    <script id="existing-variants-data" type="application/json">
                                        {!! json_encode($editProduct->variants->mapWithKeys(function($v) {
                                            return [$v->name => [
                                                'sku'           => $v->sku ?? '',
                                                'price'         => $v->price ?? '',
                                                'compare_price' => $v->compare_price ?? '',
                                                'stock'         => $v->stock_quantity ?? 0
                                            ]];
                                        })) !!}
                                    </script>
                                @endif
                            </div>
                        </div>

                        <!-- ── Categories & Tags ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-tags me-2"></i>Categories & Tags</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Categories</label>
                                        <select class="form-select" name="categories[]" multiple style="height:120px;">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ isset($editProduct) && $editProduct->categories->contains($cat->id) ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Ctrl/Cmd for multiple</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tags</label>
                                        <select class="form-select" name="tags[]" multiple style="height:120px;">
                                            @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ isset($editProduct) && $editProduct->tags->contains($tag->id) ? 'selected' : '' }}>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Ctrl/Cmd for multiple</small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status" required>
                                            <option value="draft"     {{ old('status', $editProduct->status ?? '') == 'draft'     ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status', $editProduct->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                        </select>
                                    </div>
									{{-- ✅ NEW: CTA Button Selection --}}
<div class="col-md-4 mb-3">
    <label class="form-label fw-bold">
        <i class="fas fa-mouse-pointer me-1 text-primary"></i>
        CTA Button (Frontend)
    </label>
    @php
        $ctaVal = old('cta_button', $editProduct->cta_button ?? 'add_to_cart');
    @endphp
    <div class="d-flex gap-3 mt-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cta_button"
                   id="cta_add_to_cart" value="add_to_cart"
                   {{ $ctaVal === 'add_to_cart' ? 'checked' : '' }}>
            <label class="form-check-label" for="cta_add_to_cart">
                🛒 Add to Cart
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cta_button"
                   id="cta_enquire_now" value="enquire_now"
                   {{ $ctaVal === 'enquire_now' ? 'checked' : '' }}>
            <label class="form-check-label" for="cta_enquire_now">
                ✉️ Enquire Now
            </label>
        </div>
    </div>
    <small class="text-muted">Frontend pe sirf yahi button dikhega</small>
</div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label d-block">Featured</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                                   {{ isset($editProduct) && $editProduct->is_featured ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Mark as featured</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ── SEO ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-search me-2"></i>SEO Settings</strong>
                            </div>
                            <div class="card-body" style="background:#f8f9fa;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title"
                                               value="{{ old('meta_title', $editProduct->meta_title ?? '') }}" placeholder="Leave empty to use product title">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords"
                                               value="{{ old('meta_keywords', $editProduct->meta_keywords ?? '') }}" placeholder="keyword1, keyword2">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $editProduct->meta_description ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ── OG ── -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-share-alt me-2"></i>Social Media (Open Graph)</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">OG Title</label>
                                        <input type="text" class="form-control" name="og_title"
                                               value="{{ old('og_title', $editProduct->og_title ?? '') }}" placeholder="Title for social media sharing">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">OG Image</label>
                                        <input type="file" class="form-control" name="og_image" accept="image/*" onchange="previewImage(event,'og')">
                                        <small class="text-muted">1200x630px recommended</small>
                                        @if(isset($editProduct) && $editProduct->og_image)
                                            <div class="mt-2 position-relative d-inline-block" id="og-current-wrap">
                                                <img src="{{ asset('uploads/products/og/'.$editProduct->og_image) }}"
                                                     style="max-width:200px;max-height:150px;border:1px solid #ddd;padding:5px;border-radius:4px;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute"
                                                        style="top:0;right:0;padding:2px 7px;font-size:11px;border-radius:0 4px 0 4px;"
                                                        onclick="removeOgImage()"><i class="fas fa-times"></i></button>
                                                <input type="hidden" name="remove_og_image" id="remove_og_image" value="0">
                                            </div>
                                        @endif
                                        <div id="og-preview" class="mt-2" style="display:none;">
                                            <img id="og-img" src="" style="max-width:200px;max-height:150px;border:1px solid #ddd;padding:5px;border-radius:4px;">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">OG Description</label>
                                        <textarea class="form-control" name="og_description" rows="2">{{ old('og_description', $editProduct->og_description ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ── Submit ── -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editProduct))
                                <a href="{{ route('product') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times"></i> Cancel Edit
                                </a>
                                <button type="submit" id="submitBtn" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Product
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2" onclick="resetTabsForm()">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Product
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- ========== PRODUCT LIST ========== -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Products</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;">ID</th>
                                    <th style="width:100px;">Image</th>
                                    <th>Title</th>
                                    <th style="width:100px;">Price</th>
                                    <th style="width:80px;">Stock</th>
                                    <th>Categories</th>
                                    <th style="width:100px;">Status</th>
                                    <th style="width:200px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td class="text-center">{{ $product->id }}</td>
                                    <td>
                                        @if($product->featured_image)
                                            <img src="{{ asset('uploads/products/'.$product->featured_image) }}"
                                                 style="width:80px;height:60px;object-fit:cover;" class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Str::limit($product->title, 40) }}
                                        @if($product->is_featured)<span class="badge bg-warning text-dark ms-1">Featured</span>@endif
                                        @php
                                            $tabsArr = $product->extra_tabs ? (is_array($product->extra_tabs) ? $product->extra_tabs : json_decode($product->extra_tabs, true)) : [];
                                        @endphp
                                        @if(!empty($tabsArr))
                                            <span class="badge bg-info text-dark ms-1">
                                                <i class="fas fa-layer-group me-1"></i>{{ count($tabsArr) }} Tabs
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->sale_price)
                                            <s class="text-muted">${{ number_format($product->price, 2) }}</s><br>
                                            <strong class="text-success">${{ number_format($product->sale_price, 2) }}</strong>
                                        @elseif($product->price)
                                            ${{ number_format($product->price, 2) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        @foreach($product->categories as $cat)
                                            <span class="badge bg-primary mb-1">{{ $cat->name }}</span><br>
                                        @endforeach
                                        @if($product->categories->count() === 0)<span class="text-muted">-</span>@endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning mb-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('product.delete', $product->id) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-1">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-boxes fa-3x mb-3 d-block"></i>
                                        No products yet. Create your first product above!
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

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
// ==============================================
// GLOBAL STATE
// ==============================================
let editorInstance;
let gid = 0;
let tabCount = {{ isset($editProduct) && $editProduct->extra_tabs
    ? count(is_array($editProduct->extra_tabs) ? $editProduct->extra_tabs : (json_decode($editProduct->extra_tabs, true) ?: []))
    : 0 }};

// KEY FIX: tabEditors stores { 'tab-editor-0': CKEditorInstance, ... }
const tabEditors = {};

const existingVariantData = (() => {
    const el = document.getElementById('existing-variants-data');
    if (!el) return {};
    try { return JSON.parse(el.textContent); } catch(e) { return {}; }
})();

// ==============================================
// MAIN DESCRIPTION EDITOR
// ==============================================
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
}).then(e => {
    editorInstance = e;
}).catch(console.error);

// ==============================================
// EXISTING TAB EDITORS (edit mode mein)
// KEY FIX: textarea ki jagah div container use karo
// aur content hidden input se load karo
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    // Har existing tab ke liye CKEditor initialize karo
    document.querySelectorAll('.tab-ck-container').forEach(function(container) {
        const divId    = container.id;                            // e.g. "tab-editor-0"
        const hiddenId = container.getAttribute('data-hidden-id'); // e.g. "tab-hidden-0"
        const hidden   = document.getElementById(hiddenId);
        const content  = hidden ? hidden.value : '';

        ClassicEditor.create(container, {
            toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
        }).then(function(editor) {
            tabEditors[divId] = editor;
            // Hidden input ki value set karo editor mein
            if (content && content.trim() !== '') {
                editor.setData(content);
            }
        }).catch(console.error);
    });

    // Variants regenerate karo agar existing hain
    const existing = document.querySelectorAll('#vg-container .vg-card');
    gid = existing.length;
    if (existing.length > 0) regenerate();
});

// ==============================================
// SLUG
// ==============================================
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'');
    const si = document.getElementById('slug');
    if (!si.value || si.dataset.auto === 'true') {
        si.value = slug;
        si.dataset.auto = 'true';
    }
    document.getElementById('slug-text').textContent =
        slug ? window.location.origin + '/product/' + slug : 'Will generate from title';
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.auto = 'false';
    document.getElementById('slug-text').textContent =
        this.value ? window.location.origin + '/product/' + this.value : 'Will generate from title';
});

// ==============================================
// IMAGE HELPERS
// ==============================================
function previewImage(ev, type) {
    const f = ev.target.files[0];
    const d = document.getElementById(type + '-preview');
    const i = document.getElementById(type + '-img');
    if (f) {
        const r = new FileReader();
        r.onload = e => { i.src = e.target.result; d.style.display = 'block'; };
        r.readAsDataURL(f);
    } else {
        d.style.display = 'none';
    }
}

function previewGalleryImages(ev) {
    const c = document.getElementById('gallery-preview');
    c.innerHTML = '';
    const videoExts = ['mp4','webm','ogg','mov','avi'];
    Array.from(ev.target.files).forEach(f => {
        const ext     = f.name.split('.').pop().toLowerCase();
        const isVideo = videoExts.includes(ext);
        const d       = document.createElement('div');
        d.style.cssText = 'position:relative;width:110px;';
        if (isVideo) {
            d.innerHTML = `
                <div style="width:100px;height:100px;background:#1a1a1a;border:1px solid #ddd;
                            border-radius:4px;display:flex;align-items:center;
                            justify-content:center;flex-direction:column;">
                    <span style="font-size:28px;">▶️</span>
                    <span style="color:#fff;font-size:9px;margin-top:4px;">${f.name.substring(0,12)}...</span>
                </div>
                <span style="position:absolute;top:0;left:0;background:#e05c5c;color:#fff;
                             font-size:9px;padding:1px 5px;border-radius:0 0 4px 0;">Video</span>`;
        } else {
            const r = new FileReader();
            r.onload = e => {
                d.innerHTML = `
                    <img src="${e.target.result}" style="width:100px;height:100px;object-fit:cover;
                                border:1px solid #ddd;padding:3px;border-radius:4px;display:block;">
                    <span style="position:absolute;top:0;left:0;background:#17a2b8;color:#fff;
                                 font-size:9px;padding:1px 5px;border-radius:0 0 4px 0;">New</span>`;
            };
            r.readAsDataURL(f);
        }
        c.appendChild(d);
    });
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
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(r => r.json()).then(d => {
        if (d.success) {
            const el = document.getElementById('gallery-img-' + id);
            if (el) {
                el.style.transition = 'opacity 0.3s';
                el.style.opacity    = '0';
                setTimeout(() => el.remove(), 300);
            }
        } else {
            alert('Error: ' + d.error);
        }
    }).catch(() => alert('Failed'));
}

// ==============================================
// EXTRA TABS — FIXED VERSION
// ==============================================
function addTab() {
    const noMsg = document.getElementById('no-tabs-msg');
    if (noMsg) noMsg.style.display = 'none';

    const num      = document.querySelectorAll('#tabs-container .tab-item').length + 1;
    // Unique IDs
    const uid      = tabCount;
    const divId    = 'tab-editor-' + uid;
    const hiddenId = 'tab-hidden-' + uid;
    tabCount++;

    const div = document.createElement('div');
    div.className = 'tab-item';
    div.innerHTML = `
        <div class="tab-header">
            <span class="tab-number">${num}</span>
            <span class="tab-label">Tab ${num}</span>
            <button type="button" class="btn-remove-tab" onclick="removeTab(this)" title="Remove Tab">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="fas fa-heading me-1 text-primary"></i> Tab Title
                <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control"
                   name="tab_titles[]"
                   placeholder="e.g. Specifications, Features, How to Use">
        </div>

        <div>
            <label class="form-label fw-semibold">
                <i class="fas fa-align-left me-1 text-primary"></i> Tab Content
            </label>
            <input type="hidden" name="tab_contents[]" id="${hiddenId}">
            <div id="${divId}" class="tab-ck-container" data-hidden-id="${hiddenId}"></div>
        </div>
    `;

    document.getElementById('tabs-container').appendChild(div);

    // CKEditor initialize karo naye div container pe
    ClassicEditor.create(document.getElementById(divId), {
        toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote']
    }).then(function(editor) {
        tabEditors[divId] = editor;
        console.log('Tab editor created:', divId);
    }).catch(console.error);

    div.querySelector('input[name="tab_titles[]"]').focus();
    div.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function removeTab(btn) {
    const item  = btn.closest('.tab-item');
    const edDiv = item.querySelector('.tab-ck-container');

    // CKEditor destroy karo
    if (edDiv && edDiv.id && tabEditors[edDiv.id]) {
        tabEditors[edDiv.id].destroy().catch(console.error);
        delete tabEditors[edDiv.id];
    }

    item.style.transition = 'opacity 0.2s, transform 0.2s';
    item.style.opacity    = '0';
    item.style.transform  = 'translateY(-6px)';

    setTimeout(() => {
        item.remove();
        renumberTabs();
        const remaining = document.querySelectorAll('#tabs-container .tab-item');
        const noMsg     = document.getElementById('no-tabs-msg');
        if (noMsg && remaining.length === 0) noMsg.style.display = '';
    }, 220);
}

function renumberTabs() {
    document.querySelectorAll('#tabs-container .tab-item').forEach((item, i) => {
        const numEl   = item.querySelector('.tab-number');
        const labelEl = item.querySelector('.tab-label');
        if (numEl)   numEl.textContent   = i + 1;
        if (labelEl) labelEl.textContent = 'Tab ' + (i + 1);
    });
}

function resetTabsForm() {
    // Reset pe saare tab editors destroy karo
    Object.keys(tabEditors).forEach(id => {
        if (tabEditors[id]) {
            tabEditors[id].destroy().catch(console.error);
            delete tabEditors[id];
        }
    });
    document.getElementById('tabs-container').innerHTML = '';
    tabCount = 0;
    const noMsg = document.getElementById('no-tabs-msg');
    if (noMsg) noMsg.style.display = '';
}

// ==============================================
// SHOPIFY VARIANT BUILDER
// ==============================================
function getGroups() {
    const groups = [];
    document.querySelectorAll('#vg-container .vg-card').forEach(card => {
        const typeName = card.querySelector('input[name="variant_types[]"]').value.trim();
        const opts     = [];
        card.querySelectorAll('.vg-tag').forEach(t => opts.push(t.dataset.val));
        if (typeName) groups.push({ typeName, opts });
    });
    return groups;
}

function cartesian(arrays) {
    if (!arrays.length) return [];
    return arrays.reduce((a, b) => {
        const res = [];
        a.forEach(x => b.forEach(y => res.push([...x, y])));
        return res;
    }, [[]]);
}

function regenerate() {
    const groups  = getGroups().filter(g => g.opts.length > 0);
    const genWrap = document.getElementById('gen-wrap');
    const tbody   = document.getElementById('gen-tbody');
    const badge   = document.getElementById('gen-badge');

    if (!groups.length) {
        genWrap.style.display = 'none';
        tbody.innerHTML = '';
        return;
    }

    const optArrays = groups.map(g => g.opts.map(o => ({ type: g.typeName, val: o })));
    const combos    = cartesian(optArrays);

    genWrap.style.display = 'block';
    badge.textContent     = combos.length;
    tbody.innerHTML       = '';

    combos.forEach(combo => {
        const label   = combo.map(c => c.val).join(' / ');
        const attrObj = {};
        combo.forEach(c => { attrObj[c.type.toLowerCase()] = c.val; });
        const attrJson = JSON.stringify(attrObj);
        const ex       = existingVariantData[label] || {};

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="gen-name">
                ${esc(label)}
                <input type="hidden" name="variant_names[]"      value="${esc(label)}">
                <input type="hidden" name="variant_attributes[]" value='${esc(attrJson)}'>
            </td>
            <td>
                <input type="text" class="gen-input" name="variant_skus[]"
                       value="${esc(ex.sku || '')}" placeholder="SKU">
            </td>
            <td>
                <input type="number" class="gen-input" name="variant_prices[]"
                       value="${esc(ex.price || '')}" placeholder="0.00" step="0.01" min="0">
            </td>
            <td>
                <input type="number" class="gen-input compare-price-input" name="variant_compare_prices[]"
                       value="${esc(ex.compare_price || '')}" placeholder="0.00" step="0.01" min="0">
                <span class="compare-price-hint">MRP / Original price</span>
            </td>
            <td>
                <input type="number" class="gen-input" name="variant_stocks[]"
                       value="${esc(ex.stock ?? 0)}" placeholder="0" min="0">
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function esc(s) {
    return String(s)
        .replace(/&/g,'&amp;')
        .replace(/"/g,'&quot;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;');
}

function addGroup() {
    const id   = gid++;
    const card = document.createElement('div');
    card.className   = 'vg-card';
    card.dataset.gid = id;
    card.innerHTML   = `
        <div class="vg-header">
            <span class="vg-type-label">Type</span>
            <input type="text" name="variant_types[]"
                   placeholder="e.g. Size, Color, Material"
                   onchange="regenerate()">
            <button type="button" class="btn-vg-remove" onclick="removeGroup(this)">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        <div class="vg-options-area">
            <div class="vg-tags-wrap" id="tags-${id}"></div>
            <div class="vg-input-row">
                <input type="text" class="vg-opt-input"
                       placeholder="Type an option and press Enter"
                       onkeydown="handleKey(event,this,${id})"
                       data-gid="${id}">
                <button type="button" class="btn-add-opt" onclick="addOptBtn(this,${id})">
                    <i class="fas fa-plus me-1"></i>Add
                </button>
            </div>
            <div class="vg-hint"><i class="fas fa-info-circle me-1"></i>Press Enter or click Add.</div>
        </div>
    `;
    document.getElementById('vg-container').appendChild(card);
    card.querySelector('input[name="variant_types[]"]').focus();
}

function removeGroup(btn) {
    const card = btn.closest('.vg-card');
    card.style.transition = 'opacity 0.2s';
    card.style.opacity    = '0';
    setTimeout(() => { card.remove(); regenerate(); }, 220);
}

function handleKey(ev, input, gid) {
    if (ev.key === 'Enter') {
        ev.preventDefault();
        addTag(input.value.trim(), gid);
        input.value = '';
    }
}

function addOptBtn(btn, gid) {
    const input = btn.closest('.vg-input-row').querySelector('.vg-opt-input');
    if (input.value.trim()) {
        addTag(input.value.trim(), gid);
        input.value = '';
    }
    input.focus();
}

function addTag(val, gid) {
    if (!val) return;
    const wrap = document.getElementById('tags-' + gid);
    if (!wrap) return;
    const existing = Array.from(wrap.querySelectorAll('.vg-tag')).map(t => t.dataset.val.toLowerCase());
    if (existing.includes(val.toLowerCase())) return;

    const tag = document.createElement('span');
    tag.className   = 'vg-tag';
    tag.dataset.val = val;
    tag.innerHTML   = `
        ${esc(val)}
        <button type="button" class="tag-x" onclick="removeTag(this)">
            <i class="fas fa-times"></i>
        </button>
        <input type="hidden" name="variant_options[${gid}][]" value="${esc(val)}">
    `;
    wrap.appendChild(tag);
    regenerate();
}

function removeTag(btn) {
    btn.closest('.vg-tag').remove();
    regenerate();
}

// ==============================================
// FORM SUBMIT — KEY FIX
// ==============================================
document.getElementById('productForm').addEventListener('submit', function(e) {
    // Step 1: Form submit temporarily rok do
    e.preventDefault();

    // Step 2: Main description editor sync
    if (editorInstance) {
        document.querySelector('#editor').value = editorInstance.getData();
    }

    // Step 3: Saare tab editors ko unke hidden inputs mein sync karo
    // Yahi asli fix hai — hidden input mein data daalo, textarea mein nahi
    Object.keys(tabEditors).forEach(function(divId) {
        const editor   = tabEditors[divId];
        const container = document.getElementById(divId);
        if (!editor || !container) return;

        const hiddenId = container.getAttribute('data-hidden-id');
        if (hiddenId) {
            const hidden = document.getElementById(hiddenId);
            if (hidden) {
                hidden.value = editor.getData();
                console.log('Synced tab', divId, '→', hiddenId, ':', hidden.value.substring(0, 50));
            }
        }
    });

    // Step 4: Submit button disable karo
    const btn = document.getElementById('submitBtn');
    btn.disabled    = true;
    btn.innerHTML   = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    // Step 5: Ab actually submit karo
    this.submit();
});
</script>
@endsection