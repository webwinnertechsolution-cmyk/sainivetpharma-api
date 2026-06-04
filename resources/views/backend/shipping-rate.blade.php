@extends('backend.layouts.layout')
@section('title', 'Shipping Rates')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }
    .alert-warning-box {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #fcd34d; color: #92400e;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        font-weight: 500; font-size: 12px;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 700; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary   { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); color: white; }
    .btn-success   { background: linear-gradient(135deg, #059669, #34d399); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-warning   { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); color: #1f2937; }
    .btn-outline   { background: transparent; border: 1.5px solid #1872B5; color: #1872B5; }
    .btn-outline:hover { background: #1872B5; color: white; }
    .btn-sm { padding: 4px 9px; font-size: 10px; }

    /* Form styles */
    .form-body { padding: 20px; }
    .form-group { margin-bottom: 16px; }
    .form-label { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #0a214f; display: block; margin-bottom: 6px; }
    .form-label .req { color: #ef4444; }
    .form-control {
        width: 100%; border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 8px 12px; font-size: 12px; font-family: 'Nunito', sans-serif;
        color: #374151; background: #f9fafb; transition: border-color 0.2s;
    }
    .form-control:focus { border-color: #1872B5; outline: none; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); background: #fff; }
    .form-select {
        width: 100%; border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 8px 12px; font-size: 12px; font-family: 'Nunito', sans-serif;
        color: #374151; background: #f9fafb; cursor: pointer;
    }
    .form-select:focus { border-color: #1872B5; outline: none; }
    .input-prefix { display: flex; align-items: center; }
    .input-prefix-text {
        background: #e5e7eb; border: 1.5px solid #e5e7eb; border-right: none;
        padding: 8px 10px; border-radius: 6px 0 0 6px; font-size: 12px;
        font-weight: 700; color: #374151;
    }
    .input-prefix .form-control { border-radius: 0 6px 6px 0; }
    .form-hint { font-size: 10px; color: #9ca3af; margin-top: 4px; }
    .form-error { font-size: 10px; color: #ef4444; margin-top: 4px; }

    .sub-card {
        background: #f9fafb; border: 1px solid #e5e7eb;
        border-radius: 8px; padding: 14px; margin-bottom: 14px;
    }
    .sub-card-title { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #374151; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }

    /* Toggle switch */
    .toggle-row { display: flex; align-items: center; gap: 10px; }
    .toggle-switch { position: relative; display: inline-block; width: 40px; height: 22px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; cursor: pointer; inset: 0;
        background: #d1d5db; border-radius: 22px; transition: 0.3s;
    }
    .toggle-slider:before {
        content: ''; position: absolute; height: 16px; width: 16px;
        left: 3px; bottom: 3px; background: white;
        border-radius: 50%; transition: 0.3s;
    }
    .toggle-switch input:checked + .toggle-slider { background: #1872B5; }
    .toggle-switch input:checked + .toggle-slider:before { transform: translateX(18px); }
    .toggle-label { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #374151; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead tr { background: #f9fafb; }
    thead th { padding: 10px 12px; font-family: 'Sora', sans-serif; font-weight: 700; color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 10px 12px; color: #374151; vertical-align: middle; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 20px; font-size: 10px; font-family: 'Sora', sans-serif; font-weight: 700; }
    .badge-id     { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-info   { background: #dbeafe; color: #1e40af; }
    .badge-danger { background: #fee2e2; color: #7f1d1d; }
    .badge-primary { background: #dbeafe; color: #1e40af; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    /* Stats */
    .stats-row { display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; }
    .stat-card { background: #fff; border-radius: 10px; padding: 12px 18px; border: 1px solid #e5e7eb; flex: 1; min-width: 120px; box-shadow: 0 2px 8px rgba(10,33,79,0.06); }
    .stat-number { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; }
    .stat-label  { font-size: 11px; color: #6b7280; font-weight: 500; margin-top: 2px; }
    .stat-card.green .stat-number { color: #059669; }
    .stat-card.orange .stat-number { color: #d97706; }
    .stat-card.blue  .stat-number { color: #1872B5; }

    /* Modal */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .modal-overlay.show { display: flex; }
    .modal-box { background: #fff; border-radius: 12px; width: 320px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .modal-box-header { background: linear-gradient(135deg, #ef4444, #f87171); padding: 12px 16px; color: white; display: flex; align-items: center; justify-content: space-between; }
    .modal-box-header h6 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; }
    .modal-close { background: none; border: none; color: white; font-size: 16px; cursor: pointer; }
    .modal-box-body { padding: 20px 16px; text-align: center; }
    .modal-box-body p { font-size: 12px; color: #374151; margin: 0 0 6px; }
    .modal-box-body strong { color: #ef4444; font-size: 13px; }
    .modal-box-body .note { font-size: 10px; color: #9ca3af; margin-top: 6px; }
    .modal-box-footer { padding: 10px 16px; display: flex; gap: 8px; justify-content: center; border-top: 1px solid #f3f4f6; }

    .form-check.form-switch { width: 61%; margin-left: 42px!important; }
    .btn.btn-sm { font-size: 9px!important; }
    .form-group label { font-size: 12px!important; line-height: 1; vertical-align: top; margin-bottom: 0.5rem; }

    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .section-divider {
        font-family: 'Sora', sans-serif; font-size: 9px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af;
        margin: 16px 0 12px; display: flex; align-items: center; gap: 8px;
    }
    .section-divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">🚚 Shipping Rates</h1>
            <p class="page-subtitle">Manage shipping rates for zones and methods</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('shipping.zone') }}" class="btn btn-outline">
                <i class="fas fa-globe"></i> Zones
            </a>
            <a href="{{ route('shipping.method') }}" class="btn btn-success">
                <i class="fas fa-truck"></i> Methods
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:14px;color:#065f46;">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:14px;color:#7f1d1d;">✕</button>
        </div>
    @endif

    @if($zones->isEmpty() || $methods->isEmpty())
        <div class="alert-warning-box">
            <i class="fas fa-exclamation-triangle"></i>
            @if($zones->isEmpty())
                Pehle <a href="{{ route('shipping.zone') }}" style="color:#92400e;font-weight:700;">Shipping Zone add karo</a>.
            @endif
            @if($methods->isEmpty())
                Pehle <a href="{{ route('shipping.method') }}" style="color:#92400e;font-weight:700;">Shipping Method add karo</a>.
            @endif
        </div>
    @endif

    {{-- Stats --}}
    @php
        $totalRates  = $rates->count();
        $activeRates = $rates->where('is_active', 1)->count();
        $freeRates   = $rates->where('rate_type', 'free')->count();
        $codRates    = $rates->where('cod_available', 1)->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card blue">
            <div class="stat-number">{{ $totalRates }}</div>
            <div class="stat-label">Total Rates</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number">{{ $activeRates }}</div>
            <div class="stat-label">Active</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-number">{{ $freeRates }}</div>
            <div class="stat-label">Free Shipping</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $codRates }}</div>
            <div class="stat-label">COD Available</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:400px 1fr;gap:16px;align-items:start;">

        {{-- Form Card --}}
        <div class="page-card">
            <div class="card-header-gradient">
                <h2 class="card-header-title">
                    <i class="fas fa-{{ isset($editRate) ? 'edit' : 'plus-circle' }}"></i>
                    {{ isset($editRate) ? 'Edit Rate' : 'Add New Rate' }}
                </h2>
            </div>
            <div class="form-body">
                <form action="{{ isset($editRate) ? route('shipping.rate.update', $editRate->id) : route('shipping.rate.store') }}"
                      method="POST">
                    @csrf

                    <div class="section-divider">Basic Info</div>

                    {{-- Zone --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-globe" style="color:#1872B5;"></i> Zone <span class="req">*</span></label>
                        <select name="zone_id" class="form-select">
                            <option value="">-- Select Zone --</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}"
                                    {{ old('zone_id', isset($editRate) ? $editRate->zone_id : '') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('zone_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Method --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-truck" style="color:#1872B5;"></i> Method <span class="req">*</span></label>
                        <select name="method_id" class="form-select">
                            <option value="">-- Select Method --</option>
                            @foreach($methods as $method)
                                <option value="{{ $method->id }}"
                                    {{ old('method_id', isset($editRate) ? $editRate->method_id : '') == $method->id ? 'selected' : '' }}>
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('method_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Rate Type --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tag" style="color:#1872B5;"></i> Rate Type <span class="req">*</span></label>
                        <select name="rate_type" class="form-select" id="rateType" onchange="toggleRateFields()">
                            <option value="flat_rate"    {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'flat_rate'    ? 'selected' : '' }}>Flat Rate</option>
                            <option value="weight_based" {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'weight_based' ? 'selected' : '' }}>Weight Based</option>
                            <option value="cart_value"   {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'cart_value'   ? 'selected' : '' }}>Cart Value Based</option>
                            <option value="free"         {{ old('rate_type', isset($editRate) ? $editRate->rate_type : '') == 'free'         ? 'selected' : '' }}>Free Shipping</option>
                        </select>
                    </div>

                    {{-- Base Rate --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-rupee-sign" style="color:#1872B5;"></i> Base Rate (₹) <span class="req">*</span></label>
                        <div class="input-prefix">
                            <span class="input-prefix-text">₹</span>
                            <input type="number" name="base_rate" class="form-control"
                                   value="{{ old('base_rate', isset($editRate) ? $editRate->base_rate : 0) }}"
                                   min="0" step="0.01" placeholder="0.00">
                        </div>
                        <div class="form-hint">Free shipping ke liye 0 rakho</div>
                        @error('base_rate')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Cart Value Section --}}
                    <div id="cartValueSection" style="display:none">
                        <div class="form-group">
                            <label class="form-label">Minimum Cart Value (₹)</label>
                            <div class="input-prefix">
                                <span class="input-prefix-text">₹</span>
                                <input type="number" name="min_cart_value" class="form-control"
                                       value="{{ old('min_cart_value', isset($editRate) ? $editRate->min_cart_value : '') }}"
                                       min="0" step="0.01" placeholder="500">
                            </div>
                            <div class="form-hint">Is amount ke upar free/discounted shipping milegi</div>
                        </div>
                    </div>

                    {{-- Weight Section --}}
                    <div id="weightSection" style="display:none">
                        <div class="two-col">
                            <div class="form-group">
                                <label class="form-label">Weight From (kg)</label>
                                <input type="number" name="weight_from" class="form-control"
                                       value="{{ old('weight_from', isset($editRate) ? $editRate->weight_from : '') }}"
                                       min="0" step="0.01" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Weight To (kg)</label>
                                <input type="number" name="weight_to" class="form-control"
                                       value="{{ old('weight_to', isset($editRate) ? $editRate->weight_to : '') }}"
                                       min="0" step="0.01" placeholder="5">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Per KG Rate (₹)</label>
                            <div class="input-prefix">
                                <span class="input-prefix-text">₹</span>
                                <input type="number" name="per_kg_rate" class="form-control"
                                       value="{{ old('per_kg_rate', isset($editRate) ? $editRate->per_kg_rate : '') }}"
                                       min="0" step="0.01" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">COD Settings</div>

                    {{-- COD --}}
                    <div class="sub-card">
                        <div class="toggle-row" style="margin-bottom:10px;">
                            <label class="toggle-switch">
                                <input type="checkbox" name="cod_available" id="codAvailable" onchange="toggleCod()"
                                       {{ old('cod_available', isset($editRate) ? $editRate->cod_available : false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label"><i class="fas fa-money-bill" style="color:#059669;"></i> COD Available</span>
                        </div>
                        <div id="codChargeField" style="{{ (isset($editRate) && $editRate->cod_available) ? '' : 'display:none' }}">
                            <label class="form-label">COD Extra Charge (₹)</label>
                            <div class="input-prefix" style="max-width:180px;">
                                <span class="input-prefix-text">₹</span>
                                <input type="number" name="cod_charge" class="form-control"
                                       value="{{ old('cod_charge', isset($editRate) ? $editRate->cod_charge : 0) }}"
                                       min="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">Status</div>

                    {{-- Active --}}
                    <div class="form-group">
                        <div class="toggle-row">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" id="is_active"
                                       {{ (!isset($editRate) || $editRate->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">Active</span>
                        </div>
                    </div>

                    <div style="display:flex;gap:8px;margin-top:20px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            {{ isset($editRate) ? 'Update Rate' : 'Add Rate' }}
                        </button>
                        @if(isset($editRate))
                            <a href="{{ route('shipping.rate') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="page-card">
            <div class="card-header-dark">
                <div class="card-header-row">
                    <h2 class="card-header-title"><i class="fas fa-list"></i> All Rates</h2>
                    <span class="table-count">Total: {{ $rates->count() }}</span>
                </div>
            </div>

            <div class="table-wrapper">
                @if($rates->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-rupee-sign"></i>
                        <p>Koi rate nahi mila. Naya rate add karo!</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th style="width:45px;text-align:center;">#</th>
                                <th>Zone</th>
                                <th>Method</th>
                                <th>Type</th>
                                <th>Rate</th>
                                <th style="text-align:center;">COD</th>
                                <th style="text-align:center;">Status</th>
                                <th style="width:100px;text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $rate)
                            <tr>
                                <td style="text-align:center;">
                                    <span class="badge badge-id">#{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#0a214f;font-size:12px;">{{ $rate->zone?->name ?? '—' }}</div>
                                </td>
                                <td>
                                    <div style="font-size:12px;color:#374151;">{{ $rate->method?->name ?? '—' }}</div>
                                </td>
                                <td>
                                    @php
                                        $typeMap = [
                                            'flat_rate'    => ['label' => 'Flat Rate',   'class' => 'badge-primary'],
                                            'weight_based' => ['label' => 'Weight',      'class' => 'badge-info'],
                                            'cart_value'   => ['label' => 'Cart Value',  'class' => 'badge-warning'],
                                            'free'         => ['label' => 'Free',         'class' => 'badge-success'],
                                        ];
                                        $t = $typeMap[$rate->rate_type] ?? ['label' => $rate->rate_type, 'class' => 'badge-secondary'];
                                    @endphp
                                    <span class="badge {{ $t['class'] }}">{{ $t['label'] }}</span>
                                </td>
                                <td>
                                    @if($rate->rate_type === 'free')
                                        <span style="color:#059669;font-weight:700;font-size:12px;">FREE</span>
                                    @else
                                        <span style="font-weight:700;color:#0a214f;">₹{{ number_format($rate->base_rate, 2) }}</span>
                                        @if($rate->rate_type === 'cart_value' && $rate->min_cart_value)
                                            <div style="font-size:10px;color:#9ca3af;">Min: ₹{{ number_format($rate->min_cart_value, 2) }}</div>
                                        @endif
                                        @if($rate->rate_type === 'weight_based')
                                            <div style="font-size:10px;color:#9ca3af;">{{ $rate->weight_from }}kg – {{ $rate->weight_to }}kg</div>
                                        @endif
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($rate->cod_available)
                                        <span class="badge badge-success">
                                            ✅ @if($rate->cod_charge > 0) +₹{{ $rate->cod_charge }} @else Free @endif
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <span class="badge {{ $rate->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $rate->is_active ? '✅ Active' : '⏸ Inactive' }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <div style="display:flex;gap:5px;justify-content:center;">
                                        <a href="{{ route('shipping.rate.edit', $rate->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('shipping.rate.delete', $rate->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirmDelete(event, 'Rate #{{ $loop->iteration }}')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-box-header">
            <h6><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h6>
            <button class="modal-close" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-box-body">
            <p>Delete karna chahte hain?</p>
            <strong id="deleteItemName"></strong>
            <p class="note">Yeh action undo nahi hoga.</p>
        </div>
        <div class="modal-box-footer">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Haan, Delete
            </button>
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
document.addEventListener('DOMContentLoaded', function() {
    toggleRateFields();
});

let pendingDeleteForm = null;
function confirmDelete(e, name) {
    e.preventDefault();
    pendingDeleteForm = e.target;
    document.getElementById('deleteItemName').textContent = '"' + name + '"';
    document.getElementById('deleteModal').classList.add('show');
    return false;
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
    pendingDeleteForm = null;
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (pendingDeleteForm) pendingDeleteForm.submit();
});

setTimeout(() => {
    document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
}, 5000);
</script>

@endsection
