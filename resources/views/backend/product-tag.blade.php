@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-tag me-2 text-primary"></i>Product Tags
                </h2>
                <span class="badge bg-secondary fs-6">Total: {{ $tags->count() }}</span>
            </div>

            {{-- Success / Error Messages --}}
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

            {{-- ADD / EDIT FORM --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header {{ isset($editTag) ? 'bg-warning text-dark' : 'bg-primary text-white' }}">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($editTag) ? 'edit' : 'plus-circle' }} me-2"></i>
                        {{ isset($editTag) ? 'Edit Tag: ' . $editTag->name : 'Add New Tag' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editTag) ? route('product.tag.update', $editTag->id) : route('product.tag.store') }}"
                          method="POST">
                        @csrf
                        <div class="row align-items-end">

                            {{-- Name --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Tag Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $editTag->name ?? '') }}"
                                       placeholder="e.g. New Arrival, Sale, Featured..."
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug (read only - auto generated) --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">Slug</label>
                                <input type="text"
                                       class="form-control bg-light"
                                       value="{{ isset($editTag) ? $editTag->slug : '' }}"
                                       placeholder="auto-generated"
                                       readonly>
                                <small class="text-muted">Auto-generated</small>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-md-3 mb-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-{{ isset($editTag) ? 'warning' : 'primary' }} w-100">
                                        <i class="fas fa-save me-1"></i>
                                        {{ isset($editTag) ? 'Update Tag' : 'Add Tag' }}
                                    </button>
                                    @if(isset($editTag))
                                        <a href="{{ route('product.tag') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- TAGS TABLE --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>All Product Tags
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;" class="text-center">#</th>
                                    <th>Tag Name</th>
                                    <th>Slug</th>
                                    <th style="width:150px;">Created At</th>
                                    <th style="width:130px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tags as $tag)
                                <tr class="{{ isset($editTag) && $editTag->id == $tag->id ? 'table-warning' : '' }}">

                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                                        </span>
                                    </td>

                                    <td>
                                        <code class="text-success">{{ $tag->slug }}</code>
                                    </td>

                                    <td>
                                        <small class="text-muted">{{ $tag->created_at->format('d M Y') }}</small>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <a href="{{ route('product.tag.edit', $tag->id) }}"
                                           class="btn btn-sm btn-primary me-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('product.tag.delete', $tag->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure? Delete this tag?');">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                            <p class="mb-1 fs-5">No tag found.</p>
                                            <small>Add the first tag from the form above!</small>
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
</style>
@endsection