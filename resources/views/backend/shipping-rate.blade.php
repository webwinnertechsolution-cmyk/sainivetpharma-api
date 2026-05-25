@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-rupee-sign me-2 text-warning"></i>Shipping Rates</h2>
        <div>
            <a href="{{ route('shipping.zone') }}" class="btn btn-outline-primary btn-sm me-2">
                <i class="fas fa-globe me-1"></i>Manage Zones
            </a>
            <a href="{{ route('shipping.method') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-truck me-1"></i>Manage Methods
            </a>
        </div>
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

    {{-- No zones/methods warning --}}
    @if($zones->isEmpty() || $methods->isEmpty())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            @if($zones->isEmpty())
                Please <a href="{{ route('shipping.zone') }}">add a Shipping Zone</a> first.
            @endif
            @if($methods->isEmpty())
                Please <a href="{{ route('shipping.method') }}">add a Shipping Method</a> first.
            @endif
        </div>
    @endif

    <div class="row">
        {{-- Form Column --}}
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ isset($editRate) ? 'edit' : 'plus-circle' }} me-2"></i>
                        {{ isset($editRate) ? 'Edit Rate' : 'Add New Rate' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editRate) ? route('shipping.rate.update', $editRate->id) : route('shipping.rate.store') }}"
                          method="POST">
                        @csrf

                        {{-- Zone --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Zone <span class="text-danger">*</span></label>
                            <select name="zone_id" class="form-select @error('zone_id') is-invalid @enderror">
                                <option value="">-- Select Zone --</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}"
                                        {{ old('zone_id', isset($editRate) ? $editRate->zone_id : '') == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Method --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Method <span class="text-danger">*</span></label>
                            <select name="method_id" class="form-select @error('method_id') is-invalid @enderror">
                                <option value="">-- Select Method --</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}"
                                        {{ old('method_id', isset($editRate) ? $editRate->method_id : '') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('method_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Rate Type --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rate Type <span class="text-danger">*</span></label>
                            <select name="rate_type" class="form-select" id="rateType" onchange="toggleRateFields()">
                                <option value="flat_rate"    {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'flat_rate'    ? 'selected' : '' }}>Flat Rate</option>
                                <option value="weight_based" {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'weight_based' ? 'selected' : '' }}>Weight Based</option>
                                <option value="cart_value"   {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'cart_value'   ? 'selected' : '' }}>Cart Value Based</option>
                                <option value="free"         {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'free'         ? 'selected' : '' }}>Free Shipping</option>
                            </select>
                        </div>

                        {{-- Base Rate --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Base Rate (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="base_rate" class="form-control @error('base_rate') is-invalid @enderror"
                                       value="{{ old('base_rate', isset($editRate) ? $editRate->base_rate : 0) }}"
                                       min="0" step="0.01" placeholder="0.00">
                            </div>
                            <small class="text-muted">Set 0 for free shipping</small>
                            @error('base_rate')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- Cart Value Section --}}
                        <div id="cartValueSection" style="display:none">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Minimum Cart Value (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="min_cart_value" class="form-control"
                                           value="{{ old('min_cart_value', isset($editRate) ? $editRate->min_cart_value : '') }}"
                                           min="0" step="0.01" placeholder="e.g. 500">
                                </div>
                                <small class="text-muted">Free/discounted shipping above this amount</small>
                            </div>
                        </div>

                        {{-- Weight Section --}}
                        <div id="weightSection" style="display:none">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Weight From (kg)</label>
                                    <input type="number" name="weight_from" class="form-control"
                                           value="{{ old('weight_from', isset($editRate) ? $editRate->weight_from : '') }}"
                                           min="0" step="0.01" placeholder="0">
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">Weight To (kg)</label>
                                    <input type="number" name="weight_to" class="form-control"
                                           value="{{ old('weight_to', isset($editRate) ? $editRate->weight_to : '') }}"
                                           min="0" step="0.01" placeholder="5">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Per KG Rate (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="per_kg_rate" class="form-control"
                                           value="{{ old('per_kg_rate', isset($editRate) ? $editRate->per_kg_rate : '') }}"
                                           min="0" step="0.01" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        {{-- COD --}}
                        <div class="card bg-light mb-3">
                            <div class="card-body py-2">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="cod_available"
                                           id="codAvailable" onchange="toggleCod()"
                                           {{ old('cod_available', isset($editRate) ? $editRate->cod_available : false) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="codAvailable">
                                        <i class="fas fa-money-bill me-1 text-success"></i>COD Available
                                    </label>
                                </div>
                                <div id="codChargeField" style="{{ (isset($editRate) && $editRate->cod_available) ? '' : 'display:none' }}">
                                    <label class="form-label">COD Extra Charge (₹)</label>
                                    <div class="input-group" style="max-width:180px">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" name="cod_charge" class="form-control"
                                               value="{{ old('cod_charge', isset($editRate) ? $editRate->cod_charge : 0) }}"
                                               min="0" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Active --}}
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                   {{ (!isset($editRate) || $editRate->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Active</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="fas fa-save me-1"></i>
                                {{ isset($editRate) ? 'Update Rate' : 'Add Rate' }}
                            </button>
                            @if(isset($editRate))
                                <a href="{{ route('shipping.rate') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Rates ({{ $rates->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($rates->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-rupee-sign fa-3x mb-3 d-block opacity-25"></i>
                            No shipping rates yet. Add one!
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Zone</th>
                                        <th>Method</th>
                                        <th>Type</th>
                                        <th>Rate</th>
                                        <th>COD</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rates as $rate)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $rate->zone?->name ?? '—' }}</strong></td>
                                        <td>{{ $rate->method?->name ?? '—' }}</td>
                                        <td>
                                            @php
                                                $typeLabels = [
                                                    'flat_rate'    => ['label'=>'Flat Rate',   'color'=>'primary'],
                                                    'weight_based' => ['label'=>'Weight',      'color'=>'info'],
                                                    'cart_value'   => ['label'=>'Cart Value',  'color'=>'warning'],
                                                    'free'         => ['label'=>'Free',         'color'=>'success'],
                                                ];
                                                $t = $typeLabels[$rate->rate_type] ?? ['label'=>$rate->rate_type,'color'=>'secondary'];
                                            @endphp
                                            <span class="badge bg-{{ $t['color'] }} text-{{ in_array($t['color'],['warning','info']) ? 'dark' : 'white' }}">
                                                {{ $t['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($rate->rate_type === 'free')
                                                <span class="text-success fw-bold">FREE</span>
                                            @else
                                                <strong>₹{{ number_format($rate->base_rate, 2) }}</strong>
                                                @if($rate->rate_type === 'cart_value' && $rate->min_cart_value)
                                                    <br><small class="text-muted">Min: ₹{{ number_format($rate->min_cart_value, 2) }}</small>
                                                @endif
                                                @if($rate->rate_type === 'weight_based')
                                                    <br><small class="text-muted">{{ $rate->weight_from }}kg – {{ $rate->weight_to }}kg</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($rate->cod_available)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    @if($rate->cod_charge > 0) +₹{{ $rate->cod_charge }} @else Free @endif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($rate->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('shipping.rate.edit', $rate->id) }}"
                                               class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('shipping.rate.delete', $rate->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this rate?')">
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

<script>
function toggleRateFields() {
    const type = document.getElementById('rateType').value;
    document.getElementById('cartValueSection').style.display = type === 'cart_value'   ? 'block' : 'none';
    document.getElementById('weightSection').style.display    = type === 'weight_based' ? 'block' : 'none';
}

function toggleCod() {
    const checked = document.getElementById('codAvailable').checked;
    document.getElementById('codChargeField').style.display = checked ? 'block' : 'none';
}

// Page load pe bhi run karo
document.addEventListener('DOMContentLoaded', function() {
    toggleRateFields();
});
</script>
@endsection