@extends('backend.layouts.layout')
@section('title', 'Home Logos')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">🖼️ Home Logos</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row">

        {{-- ── LEFT: Add / Edit Form ── --}}
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ isset($editLogo) ? '✏️ Edit Logo' : '➕ Add New Logo' }}</h5>
                </div>
                <div class="card-body">
                    @if(isset($editLogo))
                        <form action="{{ route('homelogo.update', $editLogo->id) }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('homelogo.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf

                    {{-- Image --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Image {{ isset($editLogo) ? '<small class="text-muted">(blank = keep existing)</small>' : '<span class="text-danger">*</span>' }}
                        </label>
                        <input type="file" name="image" class="form-control" accept="image/*"
                            {{ isset($editLogo) ? '' : 'required' }}>
                        @if(isset($editLogo) && $editLogo->image)
                            <div class="mt-2 p-2 bg-light rounded d-inline-block">
                                <img src="{{ asset('uploads/homelogos/' . $editLogo->image) }}"
                                    alt="{{ $editLogo->alt_tag }}"
                                    style="max-width:120px;max-height:60px;object-fit:contain;">
                            </div>
                        @endif
                    </div>

                    {{-- Alt Tag --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alt Tag</label>
                        <input type="text" name="alt_tag" class="form-control"
                            value="{{ old('alt_tag', $editLogo->alt_tag ?? '') }}"
                            placeholder="e.g. Company Name">
                    </div>

                    {{-- URL --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">URL <small class="text-muted">(optional)</small></label>
                        <input type="text" name="url" class="form-control"
                            value="{{ old('url', $editLogo->url ?? '') }}"
                            placeholder="e.g. https://example.com">
                    </div>

                    {{-- Sort Order --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" min="0"
                            value="{{ old('sort_order', $editLogo->sort_order ?? 0) }}">
                    </div>

                    {{-- Active --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                            {{ old('is_active', $editLogo->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">Active</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            {{ isset($editLogo) ? '💾 Update' : '➕ Add Logo' }}
                        </button>
                        @if(isset($editLogo))
                            <a href="{{ route('homelogo.index') }}" class="btn btn-secondary">Cancel</a>
                        @endif
                    </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Logos Table ── --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Logos ({{ $logos->count() }})</h5>
                    <code style="background:rgba(255,255,255,.2);color:#fff;padding:3px 10px;border-radius:4px;font-size:12px;">
                        @include('frontend.components.homelogo')
                    </code>
                </div>
                <div class="card-body p-0">
                    @if($logos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="120">Image</th>
                                    <th>Alt Tag</th>
                                    <th>URL</th>
                                    <th width="70" class="text-center">Order</th>
                                    <th width="80" class="text-center">Status</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logos as $logo)
                                <tr>
                                    <td>
                                        @if($logo->image)
                                            <img src="{{ asset('uploads/homelogos/' . $logo->image) }}"
                                                alt="{{ $logo->alt_tag }}"
                                                style="max-width:100px;max-height:50px;object-fit:contain;
                                                       background:#f9fafb;padding:6px;border-radius:8px;
                                                       border:1px solid #e5e7eb;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $logo->alt_tag ?: '—' }}</td>
                                    <td><small class="text-muted">{{ Str::limit($logo->url, 30) ?: '—' }}</small></td>
                                    <td class="text-center">{{ $logo->sort_order }}</td>
                                    <td class="text-center">
                                        @if($logo->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('homelogo.edit', $logo->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('homelogo.delete', $logo->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this logo?')">
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
                            <div style="font-size:42px;">🖼️</div>
                            <p class="mt-2 mb-0">No logos added yet!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@endsection