@extends('backend.layouts.layout')
@section('title', 'Home Categories')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Home Categories</h2>
            </div>

            {{-- Success / Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">

                {{-- ── ADD / EDIT FORM ───────────────────────── --}}
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                {{ isset($editCategory) ? '✏️ Edit Category' : '➕ Add New Category' }}
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(isset($editCategory))
                                <form action="{{ route('home.category.update', $editCategory->id) }}" method="POST" enctype="multipart/form-data">
                                @method('POST')
                            @else
                                <form action="{{ route('home.category.store') }}" method="POST" enctype="multipart/form-data">
                            @endif
                            @csrf

                            {{-- Title --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $editCategory->title ?? '') }}" placeholder="e.g. Insecticides" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- URL --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link URL</label>
                                <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                                    value="{{ old('url', $editCategory->url ?? '') }}" placeholder="e.g. /collections/insecticides">
                                @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Image --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Image {{ isset($editCategory) ? '(Leave blank to keep existing)' : '*' }}
                                </label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                    accept="image/*" {{ isset($editCategory) ? '' : 'required' }}>
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                @if(isset($editCategory) && $editCategory->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/home-categories/' . $editCategory->image) }}"
                                            alt="{{ $editCategory->alt_tag }}"
                                            style="width:80px;height:80px;object-fit:cover;border-radius:50%;border:2px solid #dee2e6;">
                                        <small class="text-muted d-block mt-1">Current image</small>
                                    </div>
                                @endif
                            </div>

                            {{-- Alt Tag --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Image Alt Tag</label>
                                <input type="text" name="alt_tag" class="form-control"
                                    value="{{ old('alt_tag', $editCategory->alt_tag ?? '') }}" placeholder="Image description">
                            </div>

                            {{-- Sort Order --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" min="0"
                                    value="{{ old('sort_order', $editCategory->sort_order ?? 0) }}">
                                <small class="text-muted">Lower number = shown first</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($editCategory) ? '💾 Update Category' : '➕ Add Category' }}
                                </button>
                                @if(isset($editCategory))
                                    <a href="{{ route('home.category') }}" class="btn btn-secondary">Cancel</a>
                                @endif
                            </div>

                            </form>
                        </div>
                    </div>
                </div>

                {{-- ── LISTING TABLE ─────────────────────────── --}}
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">All Categories ({{ $categories->count() }})</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($categories->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="70">Image</th>
                                                <th>Title</th>
                                                <th>URL</th>
                                                <th width="70">Order</th>
                                                <th width="120">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $cat)
                                            <tr>
                                                <td>
                                                    @if($cat->image)
                                                        <img src="{{ asset('uploads/home-categories/' . $cat->image) }}"
                                                            alt="{{ $cat->alt_tag }}"
                                                            style="width:50px;height:50px;object-fit:cover;border-radius:50%;">
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle fw-semibold">{{ $cat->title }}</td>
                                                <td class="align-middle">
                                                    <small class="text-muted">{{ $cat->url ?: '—' }}</small>
                                                </td>
                                                <td class="align-middle text-center">{{ $cat->sort_order }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('home.category.edit', $cat->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>

                                                    <form action="{{ route('home.category.delete', $cat->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Delete \'{{ $cat->title }}\'?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Del</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="p-4 text-center text-muted">
                                    <p>No categories added yet. Add your first one!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>{{-- /row --}}
        </div>
    </div>
</div>

@endsection