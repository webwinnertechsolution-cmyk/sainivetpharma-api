@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-globe me-2 text-primary"></i>Shipping Zones</h2>
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
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($editZone) ? 'edit' : 'plus-circle' }} me-2"></i>
                        {{ isset($editZone) ? 'Edit Zone' : 'Add New Zone' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editZone) ? route('shipping.zone.update', $editZone->id) : route('shipping.zone.store') }}"
                          method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', isset($editZone) ? $editZone->name : '') }}"
                                   placeholder="e.g. India, Rest of World">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Countries --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Countries / States</label>
                            <textarea name="countries_text" class="form-control" rows="3"
                                      placeholder="e.g. India, Pakistan, Bangladesh (comma separated)">{{ old('countries_text', isset($editZone) ? implode(', ', $editZone->countries ?? []) : '') }}</textarea>
                            <small class="text-muted">Leave empty for "Rest of World"</small>
                        </div>

                        {{-- Sort Order --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                   value="{{ old('sort_order', isset($editZone) ? $editZone->sort_order : 0) }}"
                                   min="0">
                        </div>

                        {{-- Active --}}
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                   {{ (!isset($editZone) || $editZone->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Active</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                {{ isset($editZone) ? 'Update Zone' : 'Add Zone' }}
                            </button>
                            @if(isset($editZone))
                                <a href="{{ route('shipping.zone') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Zones ({{ $zones->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($zones->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-globe fa-3x mb-3 d-block opacity-25"></i>
                            No shipping zones yet. Add one!
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Zone Name</th>
                                        <th>Countries</th>
                                        <th>Rates</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($zones as $zone)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $zone->name }}</strong></td>
                                        <td>
                                            @if(!empty($zone->countries))
                                                <span class="text-muted small">
                                                    {{ implode(', ', array_slice($zone->countries, 0, 3)) }}
                                                    @if(count($zone->countries) > 3)
                                                        <span class="badge bg-secondary">+{{ count($zone->countries) - 3 }}</span>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="badge bg-info">All Countries</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $zone->rates()->count() }} rates</span>
                                        </td>
                                        <td>
                                            @if($zone->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('shipping.zone.edit', $zone->id) }}"
                                               class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('shipping.zone.delete', $zone->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this zone?')">
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