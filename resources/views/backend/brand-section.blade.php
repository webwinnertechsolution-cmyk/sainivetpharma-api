@extends('backend.layouts.layout')
@section('title', 'Brands Section')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">🏷️ Brands Section</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- ── ROW 1: Section Settings + Add Brand (side by side) ── --}}
    <div class="row mb-4">

        {{-- Section Settings --}}
        <div class="col-lg-6 mb-3 mb-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">⚙️ Section Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('brand.section.save') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Heading <span class="text-danger">*</span></label>
                            <input type="text" name="heading" class="form-control"
                                value="{{ old('heading', $section->heading ?? 'Brands') }}"
                                placeholder="e.g. Our Brands" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">View All Button Text</label>
                            <input type="text" name="view_all_text" class="form-control"
                                value="{{ old('view_all_text', $section->view_all_text ?? 'View All') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">View All URL</label>
                            <input type="text" name="view_all_url" class="form-control"
                                value="{{ old('view_all_url', $section->view_all_url ?? '') }}"
                                placeholder="e.g. /collections">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="sec_active"
                                {{ ($section->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="sec_active">Show on Frontend</label>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">💾 Save Settings</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add / Edit Brand --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ isset($editBrand) ? '✏️ Edit Brand' : '➕ Add New Brand' }}</h5>
                </div>
                <div class="card-body">
                    @if(isset($editBrand))
                        <form action="{{ route('brand.update', $editBrand->id) }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Brand Logo {{ isset($editBrand) ? '(blank = keep existing)' : '*' }}
                        </label>
                        <input type="file" name="image" class="form-control" accept="image/*"
                            {{ isset($editBrand) ? '' : 'required' }}>
                        @if(isset($editBrand) && $editBrand->image)
                            <div class="mt-2 p-2 bg-light rounded d-inline-block">
                                <img src="{{ asset('uploads/brands/' . $editBrand->image) }}"
                                    alt="{{ $editBrand->alt_tag }}"
                                    style="max-width:80px;max-height:45px;object-fit:contain;">
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alt Tag</label>
                            <input type="text" name="alt_tag" class="form-control"
                                value="{{ old('alt_tag', $editBrand->alt_tag ?? '') }}"
                                placeholder="Brand name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" min="0"
                                value="{{ old('sort_order', $editBrand->sort_order ?? 0) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Brand URL <small class="text-muted">(optional)</small></label>
                        <input type="text" name="url" class="form-control"
                            value="{{ old('url', $editBrand->url ?? '') }}"
                            placeholder="e.g. /collections?brand=bayer">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="brand_active"
                            {{ old('is_active', $editBrand->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="brand_active">Active</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            {{ isset($editBrand) ? '💾 Update Brand' : '➕ Add Brand' }}
                        </button>
                        @if(isset($editBrand))
                            <a href="{{ route('brand.section') }}" class="btn btn-secondary">Cancel</a>
                        @endif
                    </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- ── ROW 2: Brands Table full width ── --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Brands ({{ $brands->count() }})</h5>
                    <code style="background:rgba(255,255,255,.2);color:#fff;padding:3px 10px;border-radius:4px;font-size:12px;">
                        @include('frontend.components.brands')
                    </code>
                </div>
                <div class="card-body p-0">
                    @if($brands->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="110">Logo</th>
                                    <th>Alt Tag</th>
                                    <th>URL</th>
                                    <th width="80" class="text-center">Order</th>
                                    <th width="90" class="text-center">Status</th>
                                    <th width="130" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $brand)
                                <tr>
                                    <td>
                                        @if($brand->image)
                                            <img src="{{ asset('uploads/brands/' . $brand->image) }}"
                                                alt="{{ $brand->alt_tag }}"
                                                style="max-width:85px;max-height:46px;object-fit:contain;
                                                       background:#f9fafb;padding:6px;border-radius:8px;
                                                       border:1px solid #e5e7eb;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $brand->alt_tag ?: '—' }}</td>
                                    <td><small class="text-muted">{{ Str::limit($brand->url, 40) ?: '—' }}</small></td>
                                    <td class="text-center">{{ $brand->sort_order }}</td>
                                    <td class="text-center">
                                        @if($brand->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('brand.edit', $brand->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('brand.delete', $brand->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this brand?')">
                                            @csrf
                                            <button class="btn btn-sm btn-danger">Del</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="p-5 text-center text-muted">
                            <div style="font-size:42px;">🏷️</div>
                            <p class="mt-2 mb-0">No brands added yet. Add your first brand above!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
