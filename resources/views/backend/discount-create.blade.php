{{-- resources/views/backend/discount-create.blade.php --}}
@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; display: flex; align-items: center; gap: 10px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: #0a214f; margin: 0; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 10px; color: #6b7280; font-weight: 500; margin: 0; }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }

    /* Cards */
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
    .card-header-warning {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-plain {
        background: #f9fafb;
        padding: 10px 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px; color: #fff;
    }
    .card-header-plain .card-header-title { color: #0a214f; }

    .card-body { padding: 16px; }

    /* Form elements */
    .form-label {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; margin-bottom: 5px; display: block;
    }
    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 6px 10px; font-size: 11px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback, .text-danger { color: #ef4444; font-size: 10px; margin-top: 3px; display: block; }
    .form-group { margin-bottom: 12px; }

    .input-group { display: flex; }
    .input-group .form-control { border-radius: 6px 0 0 6px; }
    .input-group-text {
        background: #f3f4f6; border: 1.5px solid #e5e7eb; border-left: none;
        padding: 6px 10px; font-size: 11px; border-radius: 0 6px 6px 0;
        font-family: 'Nunito', sans-serif; color: #374151;
    }

    .form-check { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
    .form-check-input { width: 14px; height: 14px; accent-color: #1872B5; cursor: pointer; }
    .form-check-label { font-size: 11px; color: #374151; font-family: 'Nunito', sans-serif; cursor: pointer; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }

    /* Buttons */
    .btn {
        padding: 6px 13px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 10px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary   { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); color: white; }
    .btn-success   { background: linear-gradient(135deg, #059669, #34d399); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-warning   { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); color: #1f2937; }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); color: white; }
    .btn-outline-secondary {
        background: transparent; color: #374151;
        border: 1.5px solid #e5e7eb; padding: 5px 11px;
    }
    .btn-outline-secondary:hover { background: #f3f4f6; color: #374151; }
    .btn-sm { padding: 4px 8px; font-size: 10px; }
    .btn-lg { padding: 9px 18px; font-size: 12px; }

    /* Method toggle buttons */
    .method-toggle { display: flex; border: 1.5px solid #e5e7eb; border-radius: 6px; overflow: hidden; }
    .method-toggle label {
        flex: 1; text-align: center; padding: 7px 10px;
        font-family: 'Sora', sans-serif; font-weight: 700; font-size: 10px;
        color: #374151; cursor: pointer; transition: all 0.2s;
        background: #f9fafb; border: none; margin: 0;
    }
    .method-toggle input[type="radio"] { display: none; }
    .method-toggle input[type="radio"]:checked + label {
        background: linear-gradient(135deg, #0a214f, #1872B5);
        color: white;
    }
    .method-toggle label:first-of-type { border-right: 1px solid #e5e7eb; }

    /* Type cards */
    .type-cards-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
    .type-card {
        border: 1.5px solid #e5e7eb; border-radius: 10px;
        padding: 14px 12px; cursor: pointer; text-align: center;
        transition: all 0.2s; background: #fff;
    }
    .type-card:hover { border-color: #1872B5; background: #f0f7ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(24,114,181,0.15); }
    .type-card.selected { border-color: #1872B5; background: #e8f0fe; box-shadow: 0 4px 12px rgba(24,114,181,0.2); }
    .type-card i { font-size: 22px; display: block; margin-bottom: 8px; }
    .type-card h6 { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #0a214f; margin: 0 0 4px; }
    .type-card small { font-size: 10px; color: #6b7280; }
    .type-card .tc-primary  i { color: #1872B5; }
    .type-card .tc-info     i { color: #0891b2; }
    .type-card .tc-warning  i { color: #b45309; }
    .type-card .tc-success  i { color: #059669; }

    /* Layout */
    .two-col-form { display: grid; grid-template-columns: 1fr 300px; gap: 16px; align-items: start; }

    /* Summary card sticky */
    .summary-card { position: sticky; top: 20px; }

    /* Text helpers */
    .text-muted { color: #6b7280; font-size: 10px; }
    small.text-muted { display: block; margin-top: 3px; }

    /* Generate code btn inside input */
    .code-input-group { display: flex; gap: 0; }
    .code-input-group .form-control { border-radius: 6px 0 0 6px; }
    .code-input-group .btn { border-radius: 0 6px 6px 0; white-space: nowrap; }

    /* Summary list */
    .summary-list { list-style: none; padding: 0; margin: 0; }
    .summary-list li {
        font-size: 10px; color: #374151; padding: 5px 0;
        border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 6px;
    }
    .summary-list li:last-child { border-bottom: none; }
    .summary-list li i { color: #1872B5; font-size: 11px; }
          .form-check.form-switch {
    width: 61%;
    margin-left: 42px!important;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    .btn.btn-sm, .ajax-upload-dragdrop .btn-sm.ajax-file-upload, .btn-group-sm > .btn, .ajax-upload-dragdrop .btn-group-sm > .ajax-file-upload {
    font-size: 9px!important;
}

.form-group label {
    font-size: 12px;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
    @media (max-width: 1024px) {
        .two-col-form { grid-template-columns: 1fr; }
        .type-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .summary-card { position: static; }
    }
    @media (max-width: 600px) {
        .type-cards-grid { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('discount.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <div>
            <h1 class="page-title">{{ isset($discount) ? '✏️ Edit Discount' : '🏷️ Create Discount' }}</h1>
            <p class="page-subtitle">{{ isset($discount) ? 'Existing discount ko update karein' : 'Naya discount ya coupon code banayein' }}</p>
        </div>
    </div>

    {{-- Error Alert --}}
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Step 1: Type Selector (only on create) --}}
    @if(!isset($discount))
    <div class="page-card" id="typeSelector">
        <div class="card-header-gradient">
            <h2 class="card-header-title"><i class="fas fa-th-large"></i> Discount Type Chunein</h2>
        </div>
        <div class="card-body">
            <div class="type-cards-grid">
                <div class="type-card" onclick="selectType('amount_off_products')" id="type_amount_off_products">
                    <i class="fas fa-tag" style="color:#1872B5;"></i>
                    <h6>Amount off products</h6>
                    <small>Specific products ya collections par discount</small>
                </div>
                <div class="type-card" onclick="selectType('buy_x_get_y')" id="type_buy_x_get_y">
                    <i class="fas fa-gift" style="color:#0891b2;"></i>
                    <h6>Buy X Get Y</h6>
                    <small>X kharido, Y free ya discounted pao</small>
                </div>
                <div class="type-card" onclick="selectType('amount_off_order')" id="type_amount_off_order">
                    <i class="fas fa-shopping-cart" style="color:#b45309;"></i>
                    <h6>Amount off order</h6>
                    <small>Poore order par discount lagao</small>
                </div>
                <div class="type-card" onclick="selectType('free_shipping')" id="type_free_shipping">
                    <i class="fas fa-truck" style="color:#059669;"></i>
                    <h6>Free shipping</h6>
                    <small>Order par free shipping offer karein</small>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Form --}}
    <form action="{{ isset($discount) ? route('discount.update', $discount->id) : route('discount.store') }}"
          method="POST" id="discountForm" style="{{ !isset($discount) ? 'display:none' : '' }}">
        @csrf

        <input type="hidden" name="type" id="selectedType"
               value="{{ isset($discount) ? $discount->type : '' }}">

        <div class="two-col-form">

            {{-- LEFT COLUMN --}}
            <div>

                {{-- Method & Code Card --}}
                <div class="page-card">
                    <div class="card-header-gradient">
                        <h2 class="card-header-title" id="formTypeTitle">
                            <i class="fas fa-tag"></i> Discount
                        </h2>
                    </div>
                    <div class="card-body">

                        {{-- Method --}}
                        <div class="form-group">
                            <label class="form-label">Method</label>
                            <div class="method-toggle">
                                <input type="radio" name="method" id="method_code" value="discount_code"
                                       {{ (!isset($discount) || $discount->method === 'discount_code') ? 'checked' : '' }}
                                       onchange="toggleMethod()">
                                <label for="method_code">Discount Code</label>
                                <input type="radio" name="method" id="method_auto" value="automatic"
                                       {{ (isset($discount) && $discount->method === 'automatic') ? 'checked' : '' }}
                                       onchange="toggleMethod()">
                                <label for="method_auto">Automatic Discount</label>
                            </div>
                        </div>

                        {{-- Code Input --}}
                        <div class="form-group" id="codeInputGroup">
                            <label class="form-label"><span id="titleLabel">Discount Code</span></label>
                            <div class="code-input-group">
                                <input type="text"
                                       class="form-control @error('code') is-invalid @enderror"
                                       name="code" id="codeInput"
                                       value="{{ old('code', isset($discount) ? $discount->code : '') }}"
                                       placeholder="e.g. SUMMER20">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="generateCode()">
                                    <i class="fas fa-random"></i> Generate
                                </button>
                            </div>
                            <small class="text-muted">Customers must enter this code at checkout.</small>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Auto Title --}}
                        <div class="form-group" id="autoTitleGroup" style="display:none">
                            <label class="form-label">Title</label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   name="title"
                                   value="{{ old('title', isset($discount) ? $discount->title : '') }}"
                                   placeholder="e.g. Summer Sale">
                            <small class="text-muted">Customers will see this in their cart.</small>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>

                {{-- Discount Value --}}
                <div class="page-card" id="valueSection">
                    <div class="card-header-dark">
                        <h2 class="card-header-title"><i class="fas fa-percent"></i> Discount Value</h2>
                    </div>
                    <div class="card-body">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div class="form-group">
                                <label class="form-label">Value Type</label>
                                <select class="form-select" name="value_type" id="valueType">
                                    <option value="percentage" {{ (isset($discount) && $discount->value_type === 'percentage') ? 'selected' : '' }}>Percentage</option>
                                    <option value="fixed"      {{ (isset($discount) && $discount->value_type === 'fixed')      ? 'selected' : '' }}>Fixed amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Value</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="value"
                                           value="{{ old('value', isset($discount) ? $discount->value : '') }}"
                                           placeholder="0" min="0" step="0.01">
                                    <span class="input-group-text" id="valueSuffix">%</span>
                                </div>
                            </div>
                        </div>

                        {{-- Applies To --}}
                        <div id="appliesToSection">
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Applies To</label>
                                <select class="form-select" name="applies_to" id="appliesToSelect" onchange="toggleAppliesTo()">
                                    <option value="all_products"          {{ (isset($discount) && $discount->rule?->applies_to === 'all_products')          ? 'selected' : '' }}>All products</option>
                                    <option value="specific_collections"  {{ (isset($discount) && $discount->rule?->applies_to === 'specific_collections')  ? 'selected' : '' }}>Specific collections</option>
                                    <option value="specific_products"     {{ (isset($discount) && $discount->rule?->applies_to === 'specific_products')     ? 'selected' : '' }}>Specific products</option>
                                </select>
                            </div>

                            <div id="collectionsSelect" style="display:none">
                                <label class="form-label">Select Collections</label>
                                <select class="form-select" name="collection_ids[]" multiple size="5">
                                    @foreach($collections as $col)
                                        <option value="{{ $col->id }}"
                                            {{ (isset($discount) && $discount->products->where('product_type','collection')->pluck('product_id')->contains($col->id)) ? 'selected' : '' }}>
                                            {{ $col->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="productsSelect" style="display:none">
                                <label class="form-label">Select Products</label>
                                <select class="form-select" name="product_ids[]" multiple size="5">
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}"
                                            {{ (isset($discount) && $discount->products->where('product_type','product')->pluck('product_id')->contains($prod->id)) ? 'selected' : '' }}>
                                            {{ $prod->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buy X Get Y --}}
                <div class="page-card" id="bxgySection" style="display:none">
                    <div class="card-header-gradient">
                        <h2 class="card-header-title"><i class="fas fa-cart-plus"></i> Customer Buys</h2>
                    </div>
                    <div class="card-body">
                        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:10px;">
                            <div class="form-group">
                                <label class="form-label">Buy Type</label>
                                <select class="form-select" name="buy_type">
                                    <option value="min_quantity" {{ (isset($discount) && $discount->bxgy?->buy_type === 'min_quantity') ? 'selected' : '' }}>Min quantity</option>
                                    <option value="min_amount"   {{ (isset($discount) && $discount->bxgy?->buy_type === 'min_amount')   ? 'selected' : '' }}>Min amount</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="buy_quantity"
                                       value="{{ old('buy_quantity', isset($discount) ? $discount->bxgy?->buy_quantity : '') }}"
                                       min="1" placeholder="1">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Items From</label>
                                <select class="form-select" name="buy_from">
                                    <option value="any_items">Any items</option>
                                    <option value="specific_products">Specific products</option>
                                    <option value="specific_collections">Specific collections</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Search Products (Buy)</label>
                            <select class="form-select" name="buy_product_ids[]" multiple size="4">
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-header-dark" style="border-top:1px solid #e5e7eb;">
                        <h2 class="card-header-title"><i class="fas fa-gift"></i> Customer Gets</h2>
                    </div>
                    <div class="card-body">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="get_quantity"
                                       value="{{ old('get_quantity', isset($discount) ? $discount->bxgy?->get_quantity : 1) }}"
                                       min="1" placeholder="1">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Items From</label>
                                <select class="form-select" name="get_from">
                                    <option value="any_items">Any items</option>
                                    <option value="specific_products">Specific products</option>
                                    <option value="specific_collections">Specific collections</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Search Products (Get)</label>
                            <select class="form-select" name="get_product_ids[]" multiple size="4">
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">At a Discounted Value</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="get_value_type" value="percentage" id="gvt_pct" checked>
                                <label class="form-check-label" for="gvt_pct">Percentage</label>
                            </div>
                            <div class="input-group" style="max-width:180px; margin: 6px 0;">
                                <input type="number" class="form-control" name="get_value"
                                       value="{{ old('get_value', isset($discount) ? $discount->bxgy?->get_value : '') }}"
                                       placeholder="0" min="0">
                                <span class="input-group-text">%</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="get_value_type" value="amount_off" id="gvt_amt">
                                <label class="form-check-label" for="gvt_amt">Amount off each</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="get_value_type" value="free" id="gvt_free"
                                       {{ (isset($discount) && $discount->bxgy?->get_value_type === 'free') ? 'checked' : '' }}>
                                <label class="form-check-label" for="gvt_free">Free</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="max_uses_per_order" id="maxUsesPerOrder" value="1">
                            <label class="form-check-label" for="maxUsesPerOrder">Set a maximum number of uses per order</label>
                        </div>
                    </div>
                </div>

                {{-- Free Shipping --}}
                <div class="page-card" id="shippingSection" style="display:none">
                    <div class="card-header-gradient">
                        <h2 class="card-header-title"><i class="fas fa-truck"></i> Countries</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="country_type" value="all" id="allCountries" checked>
                            <label class="form-check-label" for="allCountries">All countries</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="country_type" value="selected" id="selectedCountries">
                            <label class="form-check-label" for="selectedCountries">Selected countries</label>
                        </div>
                        <hr>
                        <label class="form-label">Shipping Rates</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="exclude_shipping" id="excludeShipping">
                            <label class="form-check-label" for="excludeShipping">Exclude shipping rates over a certain amount</label>
                        </div>
                        <div class="mt-2" id="excludeShippingAmount" style="display:none">
                            <div class="input-group" style="max-width:180px">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="exclude_shipping_over" placeholder="0" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Eligibility --}}
                <div class="page-card">
                    <div class="card-header-dark">
                        <h2 class="card-header-title"><i class="fas fa-users"></i> Eligibility</h2>
                    </div>
                    <div class="card-body">
                        <small class="text-muted" style="display:block; margin-bottom:8px;">Available on all sales channels</small>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="eligibility" value="all_customers" id="elig_all" checked>
                            <label class="form-check-label" for="elig_all">All customers</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="eligibility" value="specific_segments" id="elig_seg">
                            <label class="form-check-label" for="elig_seg">Specific customer segments</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="eligibility" value="specific_customers" id="elig_cust">
                            <label class="form-check-label" for="elig_cust">Specific customers</label>
                        </div>
                    </div>
                </div>

                {{-- Minimum Purchase --}}
                <div class="page-card">
                    <div class="card-header-dark">
                        <h2 class="card-header-title"><i class="fas fa-rupee-sign"></i> Minimum Purchase Requirements</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="min_requirement" value="none" id="min_none" checked onchange="toggleMinReq()">
                            <label class="form-check-label" for="min_none">No minimum requirements</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="min_requirement" value="min_amount" id="min_amount_r" onchange="toggleMinReq()">
                            <label class="form-check-label" for="min_amount_r">Minimum purchase amount (₹)</label>
                        </div>
                        <div id="minAmountInput" style="display:none; margin: 6px 0 6px 22px;">
                            <div class="input-group" style="max-width:180px">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="min_amount"
                                       value="{{ old('min_amount', isset($discount) ? $discount->rule?->min_amount : '') }}"
                                       placeholder="0" min="0">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="min_requirement" value="min_quantity" id="min_qty" onchange="toggleMinReq()">
                            <label class="form-check-label" for="min_qty">Minimum quantity of items</label>
                        </div>
                        <div id="minQtyInput" style="display:none; margin: 6px 0 6px 22px;">
                            <input type="number" class="form-control" name="min_quantity"
                                   style="max-width:180px"
                                   value="{{ old('min_quantity', isset($discount) ? $discount->rule?->min_quantity : '') }}"
                                   placeholder="0" min="0">
                        </div>
                    </div>
                </div>

                {{-- Max Uses --}}
                <div class="page-card">
                    <div class="card-header-dark">
                        <h2 class="card-header-title"><i class="fas fa-hashtag"></i> Maximum Discount Uses</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="limit_total_uses" id="limitTotal" onchange="toggleMaxUses('total')">
                            <label class="form-check-label" for="limitTotal">Limit number of times this discount can be used in total</label>
                        </div>
                        <div id="maxUsesTotalInput" style="display:none; margin: 6px 0 10px 22px;">
                            <input type="number" class="form-control" name="max_uses_total"
                                   style="max-width:180px"
                                   value="{{ old('max_uses_total', isset($discount) ? $discount->rule?->max_uses_total : '') }}"
                                   placeholder="0" min="1">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="limit_per_customer" id="limitPerCustomer" onchange="toggleMaxUses('per')">
                            <label class="form-check-label" for="limitPerCustomer">Limit to one use per customer</label>
                        </div>
                        <div id="maxUsesPerInput" style="display:none; margin: 6px 0 0 22px;">
                            <input type="number" class="form-control" name="max_uses_per_customer"
                                   style="max-width:180px"
                                   value="{{ old('max_uses_per_customer', isset($discount) ? $discount->rule?->max_uses_per_customer : '') }}"
                                   placeholder="1" min="1">
                        </div>
                    </div>
                </div>

                {{-- Combinations --}}
                <div class="page-card">
                    <div class="card-header-dark">
                        <h2 class="card-header-title"><i class="fas fa-layer-group"></i> Combinations</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-muted" style="margin-bottom:10px;">This discount can be combined with:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="combine_product_discounts" id="combineProduct"
                                   {{ (isset($discount) && $discount->rule?->combine_product_discounts) ? 'checked' : '' }}>
                            <label class="form-check-label" for="combineProduct">Product discounts</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="combine_order_discounts" id="combineOrder"
                                   {{ (isset($discount) && $discount->rule?->combine_order_discounts) ? 'checked' : '' }}>
                            <label class="form-check-label" for="combineOrder">Order discounts</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="combine_shipping_discounts" id="combineShipping"
                                   {{ (isset($discount) && $discount->rule?->combine_shipping_discounts) ? 'checked' : '' }}>
                            <label class="form-check-label" for="combineShipping">Shipping discounts</label>
                        </div>
                    </div>
                </div>

                {{-- Active Dates --}}
                <div class="page-card">
                    <div class="card-header-gradient">
                        <h2 class="card-header-title"><i class="fas fa-calendar-alt"></i> Active Dates</h2>
                    </div>
                    <div class="card-body">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px;">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="starts_at"
                                       value="{{ old('starts_at', isset($discount) && $discount->starts_at ? $discount->starts_at->format('Y-m-d') : date('Y-m-d')) }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" value="{{ date('H:i') }}">
                            </div>
                        </div>

                        <div class="form-check" style="margin-bottom:10px;">
                            <input class="form-check-input" type="checkbox" id="setEndDate"
                                   onchange="toggleEndDate()"
                                   {{ (isset($discount) && $discount->ends_at) ? 'checked' : '' }}>
                            <label class="form-check-label" for="setEndDate">Set end date</label>
                        </div>

                        <div id="endDateSection" style="{{ (isset($discount) && $discount->ends_at) ? '' : 'display:none' }}">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div class="form-group">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="ends_at"
                                           value="{{ old('ends_at', isset($discount) && $discount->ends_at ? $discount->ends_at->format('Y-m-d') : '') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">End Time</label>
                                    <input type="time" class="form-control" name="end_time" value="23:59">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: Summary --}}
            <div class="summary-card">
                <div class="page-card">
                    <div class="card-header-warning">
                        <h2 class="card-header-title"><i class="fas fa-file-alt"></i> Summary</h2>
                    </div>
                    <div class="card-body">
                        <div id="summaryContent">
                            <p class="text-muted" style="text-align:center; padding:10px 0;">
                                Discount type chunne ke baad yahan summary dikhegi
                            </p>
                        </div>
                        <hr>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <button type="submit" class="btn btn-primary btn-lg" style="width:100%; justify-content:center;">
                                <i class="fas fa-save"></i>
                                {{ isset($discount) ? 'Update Discount' : 'Save Discount' }}
                            </button>
                            <a href="{{ route('discount.index') }}" class="btn btn-secondary" style="width:100%; justify-content:center;">
                                <i class="fas fa-times"></i> Discard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
function selectType(type) {
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    const card = document.getElementById('type_' + type);
    if (card) card.classList.add('selected');

    document.getElementById('selectedType').value = type;
    document.getElementById('discountForm').style.display = 'block';

    const titles = {
        'amount_off_products': '<i class="fas fa-tag"></i> Amount off Products',
        'buy_x_get_y':         '<i class="fas fa-gift"></i> Buy X Get Y',
        'amount_off_order':    '<i class="fas fa-shopping-cart"></i> Amount off Order',
        'free_shipping':       '<i class="fas fa-truck"></i> Free Shipping',
    };
    const el = document.getElementById('formTypeTitle');
    if (el) el.innerHTML = titles[type] || '<i class="fas fa-tag"></i> Discount';

    const vs = document.getElementById('valueSection');
    const bx = document.getElementById('bxgySection');
    const sh = document.getElementById('shippingSection');
    const ap = document.getElementById('appliesToSection');

    if (vs) vs.style.display = 'block';
    if (bx) bx.style.display = 'none';
    if (sh) sh.style.display = 'none';
    if (ap) ap.style.display = 'block';

    if (type === 'buy_x_get_y') {
        if (vs) vs.style.display = 'none';
        if (bx) bx.style.display = 'block';
    } else if (type === 'free_shipping') {
        if (vs) vs.style.display = 'none';
        if (sh) sh.style.display = 'block';
    } else if (type === 'amount_off_order') {
        if (ap) ap.style.display = 'none';
    }

    updateSummary(type);
    document.getElementById('discountForm').scrollIntoView({ behavior: 'smooth' });
}

function toggleMethod() {
    const isCode = document.getElementById('method_code').checked;
    document.getElementById('codeInputGroup').style.display  = isCode ? 'block' : 'none';
    document.getElementById('autoTitleGroup').style.display  = isCode ? 'none'  : 'block';
    document.getElementById('titleLabel').textContent        = isCode ? 'Discount Code' : 'Title';
}

function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 10; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
    document.getElementById('codeInput').value = code;
}

function toggleAppliesTo() {
    const val = document.getElementById('appliesToSelect').value;
    document.getElementById('collectionsSelect').style.display = val === 'specific_collections' ? 'block' : 'none';
    document.getElementById('productsSelect').style.display    = val === 'specific_products'    ? 'block' : 'none';
}

function toggleMinReq() {
    const val = document.querySelector('input[name="min_requirement"]:checked').value;
    document.getElementById('minAmountInput').style.display = val === 'min_amount'   ? 'block' : 'none';
    document.getElementById('minQtyInput').style.display    = val === 'min_quantity' ? 'block' : 'none';
}

function toggleMaxUses(type) {
    if (type === 'total') {
        document.getElementById('maxUsesTotalInput').style.display = document.getElementById('limitTotal').checked ? 'block' : 'none';
    } else {
        document.getElementById('maxUsesPerInput').style.display = document.getElementById('limitPerCustomer').checked ? 'block' : 'none';
    }
}

function toggleEndDate() {
    document.getElementById('endDateSection').style.display = document.getElementById('setEndDate').checked ? 'block' : 'none';
}

document.getElementById('valueType')?.addEventListener('change', function() {
    document.getElementById('valueSuffix').textContent = this.value === 'percentage' ? '%' : '₹';
});

document.getElementById('excludeShipping')?.addEventListener('change', function() {
    document.getElementById('excludeShippingAmount').style.display = this.checked ? 'block' : 'none';
});

function updateSummary(type) {
    const icons = {
        'amount_off_products': 'fa-tag',
        'buy_x_get_y':         'fa-gift',
        'amount_off_order':    'fa-shopping-cart',
        'free_shipping':       'fa-truck',
    };
    const descs = {
        'amount_off_products': ['Type: Amount off products', 'Applies to selected products/collections'],
        'buy_x_get_y':         ['Type: Buy X Get Y', 'Customer buys X items, gets Y free/discounted'],
        'amount_off_order':    ['Type: Amount off order', 'Discount on entire order total'],
        'free_shipping':       ['Type: Free shipping', 'Offer free shipping on order'],
    };
    if (!descs[type]) return;
    const items = descs[type].map(d => `<li><i class="fas fa-check-circle" style="color:#059669;"></i> ${d}</li>`).join('');
    document.getElementById('summaryContent').innerHTML = `<ul class="summary-list">${items}</ul>`;
}

@if(isset($discount))
    selectType('{{ $discount->type }}');
@endif
</script>

@endsection
