@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-truck me-2 text-success"></i>Shipping Methods</h2>
    </div>

    {{-- Alerts --}}
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

    <div class="row">
        {{-- Form Column --}}
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($editMethod) ? 'edit' : 'plus-circle' }} me-2"></i>
                        {{ isset($editMethod) ? 'Edit Method' : 'Add New Method' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editMethod) ? route('shipping.method.update', $editMethod->id) : route('shipping.method.store') }}"
                          method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Method Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', isset($editMethod) ? $editMethod->name : '') }}"
                                   placeholder="e.g. Standard Delivery, Express, Same Day">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="2"
                                      placeholder="Short description shown to customers">{{ old('description', isset($editMethod) ? $editMethod->description : '') }}</textarea>
                        </div>

                        {{-- Delivery Time --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Delivery Time</label>
                            <input type="text" name="delivery_time" class="form-control"
                                   value="{{ old('delivery_time', isset($editMethod) ? $editMethod->delivery_time : '') }}"
                                   placeholder="e.g. 3-5 business days, Next day">
                        </div>

                        {{-- Sort Order --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="{{ old('sort_order', isset($editMethod) ? $editMethod->sort_order : 0) }}"
                                   min="0">
                        </div>

                        {{-- Active --}}
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                   {{ (!isset($editMethod) || $editMethod->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Active</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>
                                {{ isset($editMethod) ? 'Update Method' : 'Add Method' }}
                            </button>
                            @if(isset($editMethod))
                                <a href="{{ route('shipping.method') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- List Column --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Methods ({{ $methods->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($methods->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-truck fa-3x mb-3 d-block opacity-25"></i>
                            No shipping methods yet. Add one!
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Method Name</th>
                                        <th>Delivery Time</th>
                                        <th>Rates</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($methods as $method)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $method->name }}</strong>
                                            @if($method->description)
                                                <br><small class="text-muted">{{ $method->description }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($method->delivery_time)
                                                <span class="badge bg-info text-dark">
                                                    <i class="fas fa-clock me-1"></i>{{ $method->delivery_time }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $method->rates()->count() }} rates</span>
                                        </td>
                                        <td>
                                            @if($method->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('shipping.method.edit', $method->id) }}"
                                               class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('shipping.method.delete', $method->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this method?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection